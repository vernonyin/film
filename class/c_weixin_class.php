<?php

class c_weixin {

    //get
    static function getWeixinInfo($cinema_id) {
        $str = "sched_city_cinema_221_".$cinema_id;
        $url = 'http://wx.wepiao.com/data/v5/cinemas/cities/221/'.$str.'.json?_1449307402552';
        $ch = curl_init($url);
//        echo $url;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
        $filecontent = str_replace('MovieData.set("'.$str.'",', "", $filecontent);
        $filecontent = str_replace(');', "", $filecontent);
        curl_close($ch);
        return $json = json_decode($filecontent, true);
    }

    static function grap_weixin_data($cinema_id) {
        $json = $this->getWeixinInfo($cinema_id);
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

}
