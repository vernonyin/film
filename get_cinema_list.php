<?php
//include 'meituan_api.php';
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");
$link = mysqli_connect('120.25.78.52:3306', 'vernon', 'vernon');
if (!$link) {
    die('Could not connect to MySQL: ' . mysql_error());
}

mysqli_select_db($link, "statics"); 
mysqli_query($link,"set names utf8");


$area_name =$_GET["area_name"];
$recordtime = date('Y-m-d H:i:s', time());
$sql = "select * from statics.t_cinema ";
if (!empty($area_name)){
    $sql .= " where c_area_name='$area_name'";
}
$result = mysqli_query($link, $sql);
$str ="";
while ($row = mysqli_fetch_array($result)) {
//    $str .= "<option value={$row["c_id"]}>{$row["c_name"]}</option>";
    $str .="<li><a href=\"#\" value={$row["c_id"]}>{$row["c_name"]}</a></li> ";
}

echo $str;



