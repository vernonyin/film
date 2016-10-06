<?php
/*
 * 从db里面拉取数据展示
 *  */


include 'meituan_api.php';
header("Content-type: text/html; charset=utf-8");
$link = mysqli_connect('127.0.0.1:3306','root',''); 
if (!$link) { 
	die('Could not connect to MySQL: ' . mysql_error()); 
} 

mysqli_select_db( $link,"statics");
mysqli_query($link, "set names utf8");
$sql =  "SELECT * FROM t_file AS t1 LEFT JOIN (SELECT t_id,MAX(t_recordtime) t_recordtime FROM t_file) AS t2 ON t1.t_recordtime=t2.t_recordtime WHERE t2.t_recordtime IS NOT NULL ";
$result = mysqli_query($link,$sql);
$film_data = array();
$t_recordtime ;
while ($row = mysqli_fetch_array($result)) {
    $film_data[$row["t_name"]][$row["t_bgtime"]][] = array("t_price"=>$row["t_price"],"t_from"=>$row["t_from"]);
    $t_recordtime = $row["t_recordtime"];
}
$str ='<table class="gridtable">';
$str .="<tr><th colspan=\"3\">$t_recordtime</th></tr>";
foreach ($film_data as $name=>$time_list) {
      $str .="<tr><th colspan=\"3\">$name</th></tr>";
    foreach ($time_list as $daytime=>$film_list) {
        $str .=" <tr><td>$daytime</td>";
        usort($film_list, function($a, $b) {
            return ($a['t_price'] > $b['t_price']) ? 1 : -1;
        });
        foreach ($film_list as $show) {
            $str .="<td>{$show["t_price"]}({$show["t_from"]})</td>";
        }
        $str .="</tr>";
    }
}
$str .='</table>';

include 'newhtml.html';
//echo $str;
