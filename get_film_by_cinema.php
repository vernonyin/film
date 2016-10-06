<?php

include 'class/c_weixin_class.php';
include "meituan_api.php";

date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
$cinema_id = $_GET["cid"];
$json = c_weixin::getWeixinInfo($cinema_id);

$str = '<table class="gridtable">';
foreach ($json as $film) {
    if (!isset($film["name"]))
        break;
    $name = $film["name"];
    $str .="<tr><th colspan=\"3\">$name</th></tr>";
    foreach ($film["sche"] as $key => $day) {
        $day_time = substr($key, 0, 4) . "-" . substr($key, 4, 2) . "-" . substr($key, 6);
        if (!isset($day[0])) {
            continue;
        }
        $str .="<tr><th colspan=\"3\">$day_time</th></tr>";
        foreach ($day[0]["seat_info"] as $show) {
            $start_time = $day_time . " " . $show['time'];
            $price = $show["is_discount"] == 1 ? $show["discount"] : $show["calculate_price"];
            $str .=" <tr><td>$start_time</td><td>$price</td><td>-</td></tr>";
        }
    }
}
echo $str;