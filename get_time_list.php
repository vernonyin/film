<?php
include 'meituan_api.php';
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
echo "<pre/>";
$link = mysqli_connect('120.25.78.52:3306', 'vernon', 'vernon');
if (!$link) {
    die('Could not connect to MySQL: ' . mysql_error());
}

mysqli_select_db($link, "statics");
mysqli_query($link,"set names utf8");


$film =$_GET["film"];
$recordtime = date('Y-m-d H:i:s', time());
$sql = "select distinct(t_bgtime) from statics.t_file where t_name='$film' and t_bgtime>'$recordtime'";
echo $sql;
$result = mysqli_query($link, $sql);
$str = "<option >ALL</option>";
while ($row = mysqli_fetch_array($result)) {
    $str .= "<option >{$row["t_bgtime"]}</option>";
}

echo $str;



