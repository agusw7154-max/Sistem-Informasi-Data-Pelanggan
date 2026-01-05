<?php
$c=file_get_contents(__DIR__.'/../data_pelanggan.sql');
$c=str_replace(["\r\n","\r"],"\n",$c);
$lines=explode('\n',$c);
$del=';'; $buf=''; $stmts=[];
foreach($lines as $line){
    if (preg_match('/^DELIMITER\s+(\S+)/i', ltrim($line), $m)) { $del=$m[1]; continue; }
    $buf .= $line."\n";
    if ($del!='' && substr(trim($buf), -strlen($del)) === $del) { $stmts[] = substr($buf, 0, -strlen($del)); $buf=''; }
}
if (trim($buf)!='') $stmts[]=$buf;

foreach ($stmts as $i=>$s) {
    if (stripos($s,'create table') !== false) {
        echo "stmt#".($i+1)." len=".strlen($s)."\n";
        echo substr($s,0,1000)."\n\n";
    }
}
