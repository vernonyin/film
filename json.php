<?php

header("Content-type: text/html; charset=utf-8");
//ini_set('date.timezone','Asia/Shanghai');

similar_text("万万没想到：西游篇", "万万没想到", $per);
echo $per;exit;
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
$str = file_get_contents("txt/163.txt");
$json_obj = json_decode($str, true);
$str = '<table class="">';
foreach ($json_obj["cinemaList"] as $film) {
    $max = 0;
    $name="";
    foreach ($films as $row) {
        similar_text($row['c_name'], $film["name"], $per);
        if ($per > $max) {
            $max=$per; 
            $name = $row['c_name'];
            $id= $row["c_id"];
        }
    }
    if ($max<50) {
        $obj->insert($film["name"], $film["addr"], $film["area_name"], $film["longitude"], $film["latitude"], $film["cinema_brand"], $film["id"]);
            $str .="<tr><td>{$film["name"]}</td><td>{$name}  $max</td><td>{$film["id"]}  insert</td></tr>";
    }
    else{
       $obj->update($id,$film["id"]);
    $str .="<tr><td>{$film["name"]}</td><td>{$name}  $max</td><td>{$film["id"]} update</td></tr>";
    }
}
echo $str;
exit;
$obj = new c_cinema();
foreach ($json_obj["info"] as $film) {
    // public function insert($name,$addr,$area_name,addrlongitude,$latitude,$c_cinema_brand){
    $obj->insert($film["name"], $film["addr"], $film["area_name"], $film["longitude"], $film["latitude"], $film["cinema_brand"], $film["id"]);
}

//wx
$str = file_get_contents("1.txt");
$str = str_replace('MovieData.set("cinemas_city_221",', "", $str);
$str = str_replace(');', "", $str);

$json_obj = json_decode($str, true);
$obj = new c_cinema();
foreach ($json_obj["info"] as $film) {
    // public function insert($name,$addr,$area_name,addrlongitude,$latitude,$c_cinema_brand){
    $obj->insert($film["name"], $film["addr"], $film["area_name"], $film["longitude"], $film["latitude"], $film["cinema_brand"], $film["id"]);
}
