<?php

$a = file('weipiao.txt');
$link = mysqli_connect('120.25.78.52:3306', 'vernon', 'vernon');
if (!$link) {
    die('Could not connect to MySQL: ' . mysql_error());
}

mysqli_select_db($link, "statics");
mysqli_query($link, "set names utf8");
foreach ($a as $line => $content) {
    $arr = convertUrlQuery($content);
    if (isset($arr["cinemaId"])) {
        $sql = "update t_cinema set c_wp_url='{$content}' where c_wxid={$arr["cinemaId"]}";
        if (!mysqli_query($link, $sql)) {
            echo $sql;
            echo mysqli_error($link);
        }
    }
}

function convertUrlQuery($query) {
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}
