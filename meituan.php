<?php

header("Content-type: text/html; charset=utf-8");
//ini_set('date.timezone','Asia/Shanghai');
include 'class/c_cinema_class.php';
echo "<pre/>";
$link = mysqli_connect('120.25.78.52:3306', 'vernon', 'vernon');
if (!$link) {
    die('Could not connect to MySQL: ' . mysql_error());
}
$obj = new c_cinema();
mysqli_select_db($link, "statics");
mysqli_query($link, "set names utf8");
$sql = "select * from t_cinema ";
$result = mysqli_query($link, $sql);
$films = array();
while ($row = mysqli_fetch_array($result)) {
    $films[] = $row;
}
//wx
$a = file('meituan_cinema.txt');
$str = '';
$str = '<table class="">';
foreach ($a as $line => $content) {
    $json = getMeituanInfo($content);
    $max = 0;
    $name = "";
    foreach ($films as $row) {
        similar_text($json["data"]["cinema_name"], $row['c_name'], $per);
        if ($per > $max) {
            $max = $per;
            $name = $row['c_name'];
            $id = $row["c_id"];
        }
    }
    $str .="<tr><td>{$json["data"]["cinema_name"]}</td><td>{$name}  $max</td><td>--{$json["data"]["cinema_id"]} update</td></tr>";
    continue;
    
    if ($max < 40) {
      //  $obj->insert($film["name"], $film["addr"], $film["area_name"], $film["longitude"], $film["latitude"], $film["cinema_brand"], $film["id"]);
        $str .="<tr><td>{$json["data"]["cinema_name"]}</td><td>{$name}  $max</td><td>--{$json["data"]["cinema_id"]} insert</td></tr>";
    } else {
        $obj->update_meituan($id, $json["data"]["cinema_id"],$content);
        $str .="<tr><td>{$json["data"]["cinema_name"]}</td><td>{$name}  $max</td><td>--{$json["data"]["cinema_id"]} update</td></tr>";
    }
//    break;
}
echo $str;

function getMeituanInfo(&$sql) {
    $header[] = 'Host: api.meituan.com';
    $header[] = 'Accept: */*';
    $header[] = '__skck: c8a86f38931f8d49dbaadc416db7b31e';
    $header[] = 'userid: 58478909';
    $header[] = 'Connection: keep-alive';
    $header[] = '__skua: 528c0d6a760e8afed1fb2f860a37c8f7';
    //两个关键参数
    $header[] = 'Authorization: 421bc88282466876871bddfacfa97543';
    $header[] = 'Key: E7FLNQOi';
    $header[] = 'Accept-Language: zh-Hans-CN, en-us;q=0.8';
    $header[] = 'Date: Sat, 05 Dec 2015 01:31:08 GMT';
    $header[] = 'Token: l0vNqDkhqW55vn_EKwnUs9UatSkAAAAAkwAAAG1wWd4MYqk1gZ015lHXeCU6_Wh_eG-th2Ag7jdVYJ-bRK2cCl9i6hQeRuNAhniisw';

    $sql = str_replace("\n", "", $sql);
    $sql = str_replace("\r", "", $sql);
//        echo $sql;
    $ch = curl_init($sql);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $filecontent = curl_exec($ch);
    curl_close($ch);
//        echo ($filecontent);exit;
    return $json = json_decode($filecontent, true);
}
