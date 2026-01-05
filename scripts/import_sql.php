<?php
// scripts/import_sql.php
// Usage: php scripts/import_sql.php

$root = __DIR__ . '/..';
$envFile = $root . '/.env';
$sqlFile = $root . '/data_pelanggan.sql';

if (!file_exists($envFile)) {
    echo ".env not found\n";
    exit(1);
}
if (!file_exists($sqlFile)) {
    echo "SQL file not found: $sqlFile\n";
    exit(1);
}

// Parse minimal DB settings from .env
$env = file_get_contents($envFile);
function envValue($key, $default = null) {
    global $env;
    if (preg_match('/^'.preg_quote($key,'/').'=(.*)$/m', $env, $m)) {
        $v = trim($m[1]);
        $v = trim($v, " \"'");
        return $v;
    }
    return $default;
}

$host = envValue('DB_HOST','127.0.0.1');
$port = envValue('DB_PORT','3306');
$db   = envValue('DB_DATABASE','');
$user = envValue('DB_USERNAME','root');
$pass = envValue('DB_PASSWORD','');

echo "Using DB host=$host port=$port user=$user db=$db\n";

$mysqli = new mysqli($host, $user, $pass, '', (int)$port);
if ($mysqli->connect_errno) {
    echo "Connect failed: (".$mysqli->connect_errno.") ". $mysqli->connect_error ."\n";
    exit(1);
}

// Create database if not exists
if ($db) {
    if (!$mysqli->query("CREATE DATABASE IF NOT EXISTS `". $mysqli->real_escape_string($db) ."` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci")) {
        echo "Failed creating database: " . $mysqli->error . "\n";
        exit(1);
    }
    // select database
    if (!$mysqli->select_db($db)) {
        echo "Failed select database: " . $mysqli->error . "\n";
        exit(1);
    }
}

$content = file_get_contents($sqlFile);
// Normalize line endings
$content = str_replace(["\r\n", "\r"], "\n", $content);

$lines = explode("\n", $content);
$delimiter = ';';
$buffer = '';
$statements = [];
foreach ($lines as $line) {
    // skip comments that start with -- or /* ... */ single line
    $trim = ltrim($line);
    if (preg_match('/^DELIMITER\s+(\S+)/i', $trim, $m)) {
        $delimiter = $m[1];
        continue;
    }

    $buffer .= $line . "\n";
    // check if buffer ends with delimiter (after trimming trailing whitespace)
    if ($delimiter !== '' && substr(trim($buffer), -strlen($delimiter)) === $delimiter) {
        $stmt = substr($buffer, 0, -strlen($delimiter));
        $statements[] = $stmt;
        $buffer = '';
    }
}
if (trim($buffer) !== '') {
    $statements[] = $buffer;
}

echo "Parsed " . count($statements) . " statements\n";

$success = 0;
$fail = 0;
foreach ($statements as $i => $stmt) {
    $s = trim($stmt);
    if ($s === '') continue;
    // skip pure SQL comments
    $s_no_ws = ltrim($s);
    if (strpos($s_no_ws, '--') === 0) {
        continue;
    }
    if (strpos($s_no_ws, '/*') === 0 && substr(rtrim($s_no_ws), -2) === '*/') {
        continue;
    }
    // skip DEFINER clauses that can cause problems with privileges
    $s = preg_replace('/DEFINER=`[^`]+`@`[^`]+`\s*/i', '', $s);
    // Skip complex objects (procedures, triggers, functions, views, events)
    $low = strtolower($s);
    if (strpos($low, 'create procedure') !== false || strpos($low, 'create function') !== false || strpos($low, 'create trigger') !== false || strpos($low, 'create event') !== false || strpos($low, 'create algorithm') !== false || strpos($low, 'create definer') !== false) {
        echo "Skipping complex object statement #".($i+1)." (likely procedure/trigger/view/event)\n";
        continue;
    }

    echo "Executing statement #".($i+1)." (len=".strlen($s).")...\n";
    echo substr($s,0,400) . "\n";
    try {
        if (!$mysqli->multi_query($s)) {
            throw new Exception($mysqli->error);
        }
    } catch (Exception $e) {
        echo "[ERROR] statement #" . ($i+1) . " failed: " . $e->getMessage() . "\n";
        echo "Full statement:\n" . $s . "\n\n";
        $fail++;
        // flush any pending results
        while ($mysqli->more_results() && $mysqli->next_result()) { /* noop */ }
        continue;
    }
    // flush all results
    do {
        if ($res = $mysqli->store_result()) {
            $res->free();
        }
    } while ($mysqli->more_results() && $mysqli->next_result());

    $success++;
    if ($success % 50 === 0) echo "Executed $success statements...\n";
}

echo "Done. Success=$success Fail=$fail\n";
$mysqli->close();

// small pause then run check_tables.php
echo "Running tables check...\n";
passthru('php scripts/check_tables.php');

