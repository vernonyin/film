<?php

include "curl.php";

class CSource {

    public $link;
    public $recordtime;
    public $cid;
    public $cidArr;

    function CSource($cinema_id, $recordtime) {
        $this->link = mysqli_connect('120.25.78.52:3306', 'vernon', 'vernon');
        if (!$this->link) {
            die('Could not connect to MySQL: ' . mysql_error());
        }
        mysqli_select_db($this->link, "statics");
        mysqli_query($this->link, "set names utf8");
        $this->recordtime = $recordtime;
        $this->cid = $cinema_id;
        $result = mysqli_query($this->link, "select * from t_cinema where c_id={$this->cid}");

        while ($row = mysqli_fetch_array($result)) {
            $this->cidArr = $row;
        }
    }

    function grap_weipiao_data() {
        if (strlen($this->cidArr["c_wp_url"]) < 5)
            return;
        $json = curl::getWeipiaoInfo($this->cidArr["c_wp_url"]);
        $count = 0;
        foreach ($json["data"] as $film) {
            $name = $film["name"];
            foreach ($film["sche"] as $day) {
                $day_time = substr($day["date"], 0, 4) . "-" . substr($day["date"], 4, 2) . "-"
                        . substr($day["date"], 6);
                foreach ($day["info"][0]["seat_info"] as $show) {
                    $start_time = $day_time . " " . $show['time'];
                    $price = $show["is_discount"] == 1 ? $show["discount"] : $show["calculate_price"];

                    $this->insert_data($name, $start_time, $price, $show["mpid"], 'weipiao');
                    $count++;
                }
            }
        }
        return $count;
    }

    function grap_163_data() {
        if ($this->cidArr["c_163id"] <= 0)
            return;

        $json = curl::get163Info(0, $this->cidArr["c_163id"]);
        $count = 0;
        foreach ($json["movieList"] as $film) {
            $movie_id = $film["id"];
            $name = $film["name"];
            $movie_json = curl::get163Info($movie_id, $this->cidArr["c_163id"]);
            foreach ($movie_json['ticketUnitList'] as $day) {
                foreach ($day['ticketList'] as $show) {
                    $start_time = substr($show["closeTime"], 0, -8) . $show["showTime"];
                    $price = $show["price"];
                    if ($price == 0)
                        continue;

                    $this->insert_data($name, $start_time, $price, $show["id"], '163');
                    $count++;
                }
            }
        }
        return $count;
    }

    function grap_nuomi_data() {
        if (strlen($this->cidArr["c_nuomi_post"]) < 5)
            return;

        $json = curl::getNuomiInfo($this->cidArr["c_nuomi_post"]);
        $count = 0;
        foreach ($json["data"]["movies"] as $film) {
            $name = $film["name"];
            foreach ($film["schedules"] as $day) {
                foreach ($day["dailySchedules"] as $show) {
                    $start_time = date('Y-m-d H:i', $show["startTime"] / 1000);
                    $price = $show["price"] / 100;

                    $this->insert_data($name, $start_time, $price, $show["seqNo"], 'nuomi');
                    $count++;
                }
            }
        }
        return $count;
    }

    function grap_meituan_data() {
        if (strlen($this->cidArr["c_meituan_url"]) < 5)
            return;

        $json = curl::getMeituanInfo($this->cidArr["c_meituan_url"]);
        $count = 0;
        foreach ($json["data"]["movies"] as $film) {
            $name = $film["nm"];
            foreach ($film["shows"] as $day) {
                $daytime = $day["showDate"];
                foreach ($day["plist"] as $show) {
                    $time = $show["tm"];
                    $price = $show["sellPr"];

                    $this->insert_data($name, "$daytime $time", $price, $show["seqNo"], 'meituan');
                    $count++;
                }
            }
        }
        return $count;
    }

    function grap_weixin_data() {
        if ($this->cidArr["c_wxid"] <= 0)
            return;

        $json = curl::getWeixinInfo($this->cidArr["c_wxid"]);
        $count = 0;
        foreach ($json as $film) {
            $name = $film["name"];
            foreach ($film["sche"] as $key => $day) {
                $day_time = substr($key, 0, 4) . "-" . substr($key, 4, 2) . "-" . substr($key, 6);
                if (!isset($day[0])) {
                    continue;
                }
                foreach ($day[0]["seat_info"] as $show) {
                    $start_time = $day_time . " " . $show['time'];
                    $price = $show["is_discount"] == 1 ? $show["discount"] : $show["calculate_price"];

                    $this->insert_data($name, $start_time, $price, $show["mpid"], 'weixin');
                    $count++;
                }
            }
        }
        return $count;
    }

    function grap_gewara_data() {
        if ($this->cidArr["c_gewara_id"] <= 0)
            return;
//        echo $this->cidArr["c_gewara_id"];
        $arr = curl::getGewaraInfo($this->cidArr["c_gewara_id"]);
//        var_dump($arr);
        $count = 0;
        foreach ($arr as $film) {
            $dateArr = array(date("Y-m-d"),
                date('Y-m-d', strtotime(" +1 day")),
                date('Y-m-d', strtotime(" +2 day")),
                date('Y-m-d', strtotime(" +3 day")));
            foreach ($dateArr as $date) {

                $content = curl::getGewaraDetailInfo($film["id"], $this->cidArr["c_gewara_id"], $date);
                preg_match_all('/¥<\/i>[\d\.]+<\/b>/', $content, $price);
                foreach ($price[0] as &$val) {
                    $val = str_replace(array('¥</i>', '</b>'), "", $val);
                }

                preg_match_all('/\d\d:\d\d/', $content, $time);
                foreach ($time[0] as &$val) {
                    $val = str_replace(array('¥</i>', '</b>'), "", $val);
                }
//                var_dump($price,$time);exit;
                $new_price = array_slice($price[0], 0, count($price[0]) / 2);
//                var_dump($new_price);exit;
                foreach ($new_price as $key => $val) {
//                    echo "{$film['name']}, {$date} {$time[0][$key * 2]}, $val, '', 'gewara'<br/>";
//                    continue;
                    $this->insert_data($film['name'], "$date {$time[0][$key * 2]}", $val, '', 'gewara');
                    $count++;
                }
//                exit;
            }
        }
        return $count;
    }

    function grap_dp_data() {
        if ($this->cidArr["c_dp_id"] <= 0)
            return;
        $arr = curl::getDpInfo($this->cidArr["c_dp_id"]);
//        var_dump($arr);
        $count = 0;
        foreach ($arr as $film) {
            $dateArr = array(time(),
                  strtotime("today")+24*3600,
                strtotime("today")+2*24*3600,);
            foreach ($dateArr as $date) {

                $content = curl::getDpDetailInfo($film["id"], $this->cidArr["c_dp_id"], $date);
                preg_match_all('/¥[.\d]+/', $content, $price1);
                $price = array();
                foreach ($price1[0] as &$val) {
                    $price[] = str_replace(array('¥'), "", $val);
                }

                preg_match_all('/time">\d\d:\d\d/', $content, $time1);
                $time =array();
                foreach ($time1[0] as $val) {
                    $time[] = str_replace(array('time">'), "", $val);
                }
//                var_dump($price,$time);//exit;
                foreach ($price as $key => $val) {
                    $itime = date('Y-m-d',$date);
//                    echo "{$film['name']}, {$itime} {$time[$key]}, $val, '', 'dp'<br/>";
//                    continue;
                    $this->insert_data($film['name'], "{$itime} {$time[$key]}", $val, '', 'dp');
                    $count++;
                }
//                exit;
            }
        }
        return $count;
    }
    
      function grap_dp_data2() {
        if ($this->cidArr["c_dp_id"] <= 0)
            return;
        $arr = curl::getDpInfo2($this->cidArr["c_dp_id"]);
//        var_dump($arr);
        $count = 0;
        foreach ($arr as $film) {
            $dateArr = array(time(),
                strtotime("today")+24*3600,
                strtotime("today")+2*24*3600,
                );
            foreach ($dateArr as $date) {

                $content = curl::getDpDetailInfo2($film["id"], $this->cidArr["c_dp_id"], $date);
                preg_match_all('/¥[.\d]+/', $content, $price1);
                $price = array();
                foreach ($price1[0] as &$val) {
                    $price[] = str_replace(array('¥'), "", $val);
                }

                preg_match_all('/time">\d\d:\d\d/', $content, $time1);
                $time =array();
                foreach ($time1[0] as $val) {
                    $time[] = str_replace(array('time">'), "", $val);
                }
//                var_dump($content);//exit;
                foreach ($price as $key => $val) {
                    $itime = date('Y-m-d',$date);
//                    echo "{$film['name']}, {$itime} {$time[$key]}, $val, '', 'dp'<br/>";
//                    continue;
                    $this->insert_data($film['name'], "{$itime} {$time[$key]}", $val, '', 'dp');
                    $count++;
                }
//                exit;
            }
        }
        return $count;
    }

    function grap_taobao_data() {
        $json = curl::getTaobaoInfo();
        $count = 0;
        foreach ($json["data"]["returnValue"] as $film) {
            $id = $film["id"];
            $name = $film["showName"];
            $movies = curl::getTaobaoDetailInfo();
            foreach ($movies["data"]["returnValue"] as $movie) {
                $show_time = substr($movie['showTime'], 0, -3);
//                var_dump($name, $show_time, $movie['price'] / 100, $movie["id"], 'taobao');
//                exit;
                $this->insert_data($name, $show_time, $movie['price'] / 100, $movie["id"], 'taobao');
                $count++;
            }
        }
        exit;
        return $count;
    }

    function insert_data($name, $start_time, $price, $id, $source) {
        $sql = "INSERT INTO `t_file`( `t_name`,  `t_bgtime`,`t_price`,`t_no`,`t_from`,`t_recordtime`,`t_cid`)"
                . " VALUES ('$name','$start_time','$price','$id','$source','$this->recordtime','$this->cid')";
        if (!mysqli_query($this->link, $sql)) {
            echo $sql;
            echo mysqli_error($this->link);
        }
    }

}
