<?php


 function getDpInfo($id) {
        $header[] = 'Host: dianping.com';
        $header[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.107 Safari/537.36';
        $header[] = 'Referer: http://m.dianping.com/movie/shenzhen?cityId=7&districtId=0&sortType=def&isSubCity=&item=&channel=&utm_source=';
        $ch = curl_init("http://dianping.com/");

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);

        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
        echo ($filecontent);exit;
        preg_match_all("/mid=\"\d+/", $filecontent, $match0);
        preg_match_all("/<p class=\"title\">[\s\S]*?<span class=\"num\">/", $filecontent, $match);
//        var_dump($match0,$match);exit;
        $arr = array();
        foreach ($match[0] as $key => $name) {
            $name = trim(str_replace(array('<p class="title">','<span class="num">'), '', $name));
            $id = str_replace('mid="', '', $match0[0][$key]);
            $arr[] =array("name"=>$name,"id"=>$id);
        }
//        var_dump($arr);exit;
        curl_close($ch);
        return $arr;
    }
    
    getDpInfo(1705426);