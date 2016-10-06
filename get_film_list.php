<?php

//include 'meituan_api.php';
include 'CSource.php';
date_default_timezone_set('Asia/Shanghai');
header("Content-type: text/html; charset=utf-8");

$cid = $_GET["cid"];
if(!is_numeric($cid)) exit;

$recordtime = date('Y-m-d H:i', time());
$obj = new CSource($cid,$recordtime);
 /*ip被封了*/
$obj->grap_gewara_data();
$obj->grap_dp_data();
$obj->grap_weixin_data();
$obj->grap_weipiao_data();
$obj->grap_163_data();
$obj->grap_meituan_data() ;
$obj->grap_nuomi_data() ;

//echo "<pre/>";
$link = mysqli_connect('120.25.78.52:3306', 'vernon', 'vernon');
if (!$link) {
    die('Could not connect to MySQL: ' . mysql_error());
}

mysqli_select_db($link, "statics");
mysqli_query($link, "set names utf8");

$sql = "select * from statics.t_file ";
$cid = $_GET["cid"];
if ($cid != "ALL")
    $sql = "SELECT a.* FROM `t_file` AS a RIGHT JOIN (SELECT MAX(t_recordtime) AS t_recordtime FROM `t_file` where t_cid={$cid}) AS b ON a.`t_recordtime`=b.t_recordtime and a.t_bgtime>NOW() order by a.t_bgtime asc";
//echo $sql;
$result = mysqli_query($link, $sql);
$film_data = array();
$from_arr = array();
while ($row = mysqli_fetch_array($result)) {
    foreach ($film_data as $name => $value) {

        similar_text($row["t_name"], $name, $per);
        if ($per > 50)
            $row["t_name"] = $name;
    }
    $film_data[$row["t_name"]][$row["t_bgtime"]][$row["t_from"]] = $row["t_price"];
    $t_recordtime = $row["t_recordtime"];
    $from_arr[$row["t_from"]] = $row["t_from"];
}
if (empty($t_recordtime))
    exit;
$str = '<table align="center" valign="middle"  class="table table-striped table-bordered" id="tbl1">';
//$str .="<tr><th colspan=\"3\">$t_recordtime</th></tr>";

$href = array(
    'weipiao' => array("name" => "微票", "url" => "#"),
    '163' => array("name" => "网易", "url" => "http://piao.163.com/wap/cinemaList.html?cityCode=440300"),
    'meituan' => array("name" => "猫眼", "url" => "http://i.meituan.com/shenzhen?cid=99&stid_b=1&cateType=poi"),
    'weixin' => array("name" => "微信", "url" => "http://wx.wepiao.com/cinema_list.html"),
    'nuomi' => array("name" => "糯米", "url" => "http://m.dianying.baidu.com/"),
    'gewara' => array("name" => "格瓦拉", "url" => "http://m.gewara.com/"),
    'dp' => array("name" => "点评", "url" => "http://m.dianping.com"),
);
foreach ($film_data as $name => $time_list) {
    $name= trim($name);
    $str .="<tr><th style=\"background-color: #00F5FF;\" colspan=".(count($from_arr)+1).">$name</th>";
    $str .="<tr><td></td>";
    foreach ($from_arr as $name) {
        $str .= "<td >{$href[$name]["name"]}</td>";
    }
    $str .= "</tr>";
    $day = $day1 = 0;
    foreach ($time_list as $daytime => $film_list) {
        $daytime = substr($daytime, 5);
        $day = substr($daytime, 0, 5);
        $day = str_replace("-", '月', $day);
        $day= trim($day);
        $day .= "日";
        $filetime = substr($daytime, 5);
        if ($day1 != $day) {
            $str .=" <tr><td colspan=".(count($from_arr)+1).">$day</td></tr>";
        }
        $day1 = $day;
        $str .=" <tr><td  style=\"font-size:14px;\">$filetime</td>";
        asort($film_list);
        $min_price = current($film_list);
        foreach ($from_arr as $name) {
            if (isset($film_list[$name])) {
                $str .= "<td style=\"color:red;font-size:14px;\"><a href=\"{$href[$name]["url"]}\">$film_list[$name]";
                if ($film_list[$name] == $min_price)
                    $str .= "<span style=\"color:red;\">*</span>";

                $str .= "</a></td>";
            }else {
                $str .= "<td>-</td>";
            }
        }
        $str .="</tr>";
    }
}
$str .='</table>';
echo $str;



