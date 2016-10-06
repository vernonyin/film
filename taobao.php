<?php

header("Content-type: text/html; charset=utf-8");
$a = file_get_contents('work.txt');
//var_dump($a);
preg_match_all('/openid=\d+/', $a, $matches);
print_r($matches);
exit;
$a = json_decode($a,true);

