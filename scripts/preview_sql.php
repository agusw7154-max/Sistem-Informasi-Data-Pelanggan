<?php
$root = __DIR__ . '/..';
$sqlFile = $root . '/data_pelanggan.sql';
$content = file_get_contents($sqlFile);
$content = str_replace(["\r\n", "\r"], "\n", $content);
$lines = explode("\n", $content);
$delimiter = ';';
$buffer = '';
$statements = [];
foreach ($lines as $line) {
    $trim = ltrim($line);
    if (preg_match('/^DELIMITER\s+(\S+)/i', $trim, $m)) {
        $delimiter = $m[1];
        continue;
    }
    $buffer .= $line . "\n";
    if ($delimiter !== '' && substr(trim($buffer), -strlen($delimiter)) === $delimiter) {
        $stmt = substr($buffer, 0, -strlen($delimiter));
        $statements[] = $stmt;
        $buffer = '';
    }
}
if (trim($buffer) !== '') $statements[] = $buffer;

$max = min(6, count($statements));
echo "Total parsed: " . count($statements) . "\n\n";
for ($i=0;$i<count($statements);$i++) {
    $s = $statements[$i];
    $low = strtolower($s);
    if (strpos($low,'procedure')!==false || strpos($low,'trigger')!==false || strpos($low,'function')!==false) {
        echo "--- Statement #".($i+1)." (len=".strlen($statements[$i]).") ---\n";
        $s2 = preg_replace('/DEFINER=`[^`]+`@`[^`]+`\s*/i','',$s);
        echo substr($s2,0,2000) . "\n\n";
    }
}

