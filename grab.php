<?php

include 'CSource.php';
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");

$cinema_id = $_GET["cid"];
$recordtime = date('Y-m-d H:i', time());
$obj = new CSource($cinema_id,$recordtime);
//echo "dp count:" . $obj->grap_dp_data() . "<br/>";
//exit;

$obj->grap_dp_data2();
exit;
echo "gewara count:" . $obj->grap_dp_data2() . "<br/>";
echo "weixin count:" . $obj->grap_weixin_data() . "<br/>";
echo "weipiao count:" . $obj->grap_weipiao_data() . "<br/>";
echo "163 count:" . $obj->grap_163_data() . "<br/>";
echo "meituan count:" . $obj->grap_meituan_data() . "<br/>";
echo "nuomi count:" . $obj->grap_nuomi_data() . "<br/>";
exit;


echo "nuomi count:" . $obj->grap_nuomi_data() . "\n";