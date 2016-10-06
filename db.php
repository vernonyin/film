<?php

//include 'meituan_api.php';
include 'CSource.php';
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");

$link = mysqli_connect('120.25.78.52:3306', 'vernon', 'vernon');
if (!$link) {
    die('Could not connect to MySQL: ' . mysql_error());
}

mysqli_select_db($link, "statics");
mysqli_query($link, "set names utf8");

$sql = "SELECT DISTINCT(t_recordtime) FROM `t_file` ORDER BY t_createtime DESC ";
$result = mysqli_query($link, $sql);
$film_data = array();
$from_arr = array();
while ($row = mysqli_fetch_array($result)) {
    echo $row["t_recordtime"]."<br/>";
}

