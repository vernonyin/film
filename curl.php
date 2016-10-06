<?php

class curl {
    #get
    // h5 http://m.maoyan.com/showtime/wrap.json?cinemaid=1614

    static function getMeituanInfo($url) {
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
        //压缩导致的
        //$header[]= 'Accept-Encoding: gzip, deflate';
        //$header[]= 'User-Agent: com.meituan.imeituan/823 (unknown, iPhone OS 9.1, iPhone, Scale/2.000000)';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
        curl_close($ch);
//        echo $filecontent;
//        exit;
        return $json = json_decode($filecontent, true);
    }

    //get
    static function getWeixinInfo($cinema_id) {
        $str = "sched_city_cinema_221_" . $cinema_id;
        $url = 'http://wx.wepiao.com/data/v5/cinemas/cities/221/' . $str . '.json?_1449307402552';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
        $filecontent = str_replace('MovieData.set("' . $str . '",', "", $filecontent);
        $filecontent = str_replace(');', "", $filecontent);
        curl_close($ch);
        return $json = json_decode($filecontent, true);
    }

    //post
    static function getNuomiInfo($post) {
        $header[] = 'Host: movieapp.baidu.com';
        $header[] = 'Content-Type: application/json';
        $header[] = 'Accept: */*';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Cookie: BAIDUID=22C2DDF44B35AC7FCEB0F5F6C3426DE9:FG=1; BAINUOCUID=5cafcb1e1009f13c97b421ced5c89731b0e61ec7; BDUSS=VZsT3AzNDNqSFFBQ0ZNUW9hNnlkR1F1QmMwM25ST1lpemEzZFZ3aEVxNjhMamRXQVFBQUFBJCQAAAAAAAAAAAEAAADeNFMLye7b2sG6AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALyhD1a8oQ9WV; UID=190002398';

        $ch = curl_init("http://movieapp.baidu.com/na/app/dispatcher?mockup=0");

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
//        $post = '{"api":1003,"version":"1.0.0.1","user":{"bduss":"VZsT3AzNDNqSFFBQ0ZNUW9hNnlkR1F1QmMwM25ST1lpemEzZFZ3aEVxNjhMamRXQVFBQUFBJCQAAAAAAAAAAAEAAADeNFMLye7b2sG6AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALyhD1a8oQ9WV","cuid":"5cafcb1e1009f13c97b421ced5c89731b0e61ec7"},"data":"{\"cinemaId\":\"8298\"}","timestamp":1450444647320,"channel":"nuomi","client":"na","osName":"ios","osVersion":9.2,"experimentIds":["214","217","120","296","285","210","253","222","218","292","298","83","118"],"cityType":1,"subChannel":"com_dot_apple|portal|cinemaPortal|cinemaShow","sign":"e91077e23ee09aadd5c00a9f7402b8e8"}';
//      $post='{"api":1003,"version":"1.0.0.1","user":{"bduss":"VZsT3AzNDNqSFFBQ0ZNUW9hNnlkR1F1QmMwM25ST1lpemEzZFZ3aEVxNjhMamRXQVFBQUFBJCQAAAAAAAAAAAEAAADeNFMLye7b2sG6AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALyhD1a8oQ9WV","cuid":"5cafcb1e1009f13c97b421ced5c89731b0e61ec7"},"data":"{\"cinemaId\":\"3\"}","timestamp":1450517559515,"channel":"nuomi","client":"na","osName":"ios","osVersion":9.2,"experimentIds":["217","120","296","285","210","253","222","218","292","298","83","118"],"cityType":1,"subChannel":"com_dot_apple|portal|cinemaShow","sign":"de6ff826c269b4882da7c235c281a4a0"}';

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
//  echo $post;exit;
//        echo $filecontent;
//        exit;
        curl_close($ch);
        return $json = json_decode($filecontent, true);
    }

    //post
    static function get163Info($movie_id = 0, $cid) {
        $header[] = 'Host: piao.163.com';
        $header[] = 'Content-Type: application/x-www-form-urlencoded';
        $header[] = 'Cookie: JSESSIONID=abc9nR_aaUpgkgDLe62fv; JSESSIONID0=230ab6059864eaf3b8396bd43c2a9161';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Accept: */*';
        $header[] = 'User-Agent: NTES(ios 9.1;iPhone;640*1136) Movie163/3.7.1';
        $header[] = 'Accept-Language: zh-Hans-CN;q=1';
        $header[] = 'Referer: http://piao.163.com/';

        if ($movie_id == 0) {
            $url = "http://piao.163.com/m/cinema/schedule.html?app_id=2&mobileType=iPhone&ver=3.7.1&channel=lede&deviceId=C5998390-CE7F-4C91-95D1-82D72CACF035&apiVer=21&city=440300";
        } else {
            $url = "http://piao.163.com/m/cinema/ticket.html?app_id=2&mobileType=iPhone&ver=3.7.1&channel=lede&deviceId=C5998390-CE7F-4C91-95D1-82D72CACF035&apiVer=21&city=440300";
        }
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);

        $post = "cinema_id={$cid}&movie_id=$movie_id";
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
//        echo $filecontent;exit;
        curl_close($ch);
        return $json = json_decode($filecontent, true);
    }

    //post
    static function getWeipiaoInfo($post) {
        $header[] = 'Host: ioscgi.wepiao.com';
        $header[] = 'Content-Type: application/x-www-form-urlencoded';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Accept: */*';
        $header[] = 'User-Agent: WeiXinMovie/5.1.1 (iPhone; iOS 9.1; Scale/2.00)';
        $header[] = 'Accept-Language: zh-Hans-CN;q=1';

        $url = "http://ioscgi.wepiao.com/sche/cinema";
        $ch = curl_init($url);
        $post = str_replace("\n", "", $post);
        $post = str_replace("\r", "", $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
//        echo $filecontent;exit;
        curl_close($ch);
        return $json = json_decode($filecontent, true);
    }

    static function getGewaraInfo($id) {
        $header[] = 'm.gewara.com';
        $header[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $header[] = 'Referer: http://m.gewara.com/movie/m/index.xhtml';
        $ch = curl_init("http://103.20.250.58/movie/m/choiceMovie.xhtml?cid=$id");

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//        curl_setopt($ch, CURLOPT_POST, 1);

        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
//        var_dump($filecontent);exit;
        preg_match_all("/bind=\"event\" id=\"\d+/", $filecontent, $match0);
        preg_match_all("/<b>.+<\/b>/", $filecontent, $match);
        $arr = array();
        foreach ($match0[0] as $key => $id) {
            $id = str_replace('bind="event" id="', '', $id);
            $name = str_replace(array("<b>", "</b>"), '', $match[0][$key + 1]);
            $arr[] =array("name"=>$name,"id"=>$id);
        }
        curl_close($ch);
        return $arr;
    }
    
    static function getGewaraDetailInfo($mid,$cid,$date) {
        $header[] = 'm.gewara.com';
        $header[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $header[] = 'Referer: http://m.gewara.com/movie/m/index.xhtml';
        
        $ch = curl_init("http://m.gewara.com/movie/m/chooseMovieOpi.xhtml");

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);

//        $mid = 214046326;
//        $cid = 37991736;
           //mid=214046326&cid=37991736&discountid=&adverId=
        //mid=214046326&cid=37991736&discountid=&adverId=&opiClick=true&openDate=2015-12-22
        $post = "mid={$mid}&cid={$cid}&discountid=&adverId=&&openDate=$date";
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
//        echo $filecontent;
       
        curl_close($ch);
        return $filecontent;
    }
    
    static function getDpInfo($id) {
        $header[] = 'Host: m.dianping.com';
        $header[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.107 Safari/537.36';
        $header[] = 'Referer: http://m.dianping.com/movie/shenzhen?cityId=7&districtId=0&sortType=def&isSubCity=&item=&channel=&utm_source=';
        $ch = curl_init("http://m.dianping.com/movie/cinema/$id?cityId=7");

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//        curl_setopt($ch, CURLOPT_POST, 1);

        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
//        echo ($filecontent);exit;
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
    
       static function getDpInfo2($id) {
        $header[] = 'Host: m.dianping.com';
        $header[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.107 Safari/537.36';
        $header[] = 'Referer: http://m.dianping.com/movie/shenzhen?cityId=7&districtId=0&sortType=def&isSubCity=&item=&channel=&utm_source=';
        $ch = curl_init("http://m.dianping.com/movie/cinema/$id?cityId=7");
        echo "http://m.dianping.com/movie/cinema/$id?cityId=7";

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//        curl_setopt($ch, CURLOPT_POST, 1);

        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
//        echo ($filecontent);exit;
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

    static function getDpDetailInfo($mid,$cid,$date) {
        $header[] = 'Host: m.dianping.com';
        $header[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.107 Safari/537.36';
        $header[] = 'Referer: http://m.dianping.com/movie/shenzhen?cityId=7&districtId=0&sortType=def&isSubCity=&item=&channel=&utm_source=';
        
        $ch = curl_init("http://m.dianping.com/movie/ajax/getMovieShowWithDay?cinemaId={$cid}&movieId={$mid}&date={$date}000");
//echo "http://m.dianping.com/movie/ajax/getMovieShowWithDay?cinemaId={$cid}&movieId={$mid}&date={$date}000";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);

        $post = "mid={$mid}&cid={$cid}&discountid=&adverId=&&openDate=$date";
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
//        echo $filecontent;exit;
       
        curl_close($ch);
        return $filecontent;
    }
    
     static function getDpDetailInfo2($mid,$cid,$date) {
        $header[] = 'Host: m.dianping.com';
        $header[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.107 Safari/537.36';
        $header[] = 'Referer: http://m.dianping.com/movie/shenzhen?cityId=7&districtId=0&sortType=def&isSubCity=&item=&channel=&utm_source=';
        
        $ch = curl_init("http://m.dianping.com/movie/ajax/getMovieShowWithDay?cinemaId={$cid}&movieId={$mid}&date={$date}000");
echo "http://m.dianping.com/movie/ajax/getMovieShowWithDay?cinemaId={$cid}&movieId={$mid}&date={$date}000";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);

        $post = "mid={$mid}&cid={$cid}&discountid=&adverId=&&openDate=$date";
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
//        echo $filecontent;exit;
       
        curl_close($ch);
        return $filecontent;
    }
    
    static function getTaobaoInfo($post = '') {
        $header[] = 'Host: api.m.taobao.com';
        $header[] = 'Cookie: _m_h5_tk=1a536ee9c52ed5f6f60e11988e732e5b_1450623353674; _m_h5_tk_enc=112e159ebd768a6c68e3f84e62813ab4; cna=lN0WDupQ52ACAXRNCTTgoekU; cookie2=1c4d97ad4879e81c46d570cf4cd9f4c0; isg=E6B5D3345D0F0890721AEA8856409994; l=Ar29Slj4pFFvKEWw77K/sgOEzQK3WPGs; t=d3181f1e0f66b7bf51bbde58e21f5be8; v=0';
        $header[] = 'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 9.2 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3 QHBrowser/242';
        $header[] = 'Accept-Language: zh-cn';
        $header[] = 'Referer: http://h5.m.taobao.com/app/movie/pages/index/show-list.html?spm=a1z2r.7661904.h5_cinema_list.1&_=_&cinemaid=4401&cinemaname=%E6%B7%B1%E5%9C%B3%E6%A8%AA%E5%BA%97%E7%94%B5%E5%BD%B1%E5%9F%8E&groupon=false';

        $ch = curl_init("http://api.m.taobao.com/h5/mtop.film.mtopshowapi.getshowsbycinemaid/4.0/?v=4.0&api=mtop.film.MtopShowAPI.getShowsByCinemaId&appKey=12574478&t=1450619107489&callback=mtopjsonp1&type=jsonp&sign=542a86f32f15b1e8fffcf87afeafe1c3&data={\"platform\":\"8\",\"asac\":\"D679AU6J95PHQT67G0B5\",\"cinemaid\":\"4401\"}");

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
        $filecontent = str_replace("mtopjsonp1(", '', $filecontent);
        $filecontent = substr($filecontent, 0, -1);
//        echo $filecontent;
//        exit;
        curl_close($ch);
        return $json = json_decode($filecontent, true);
    }

    static function getTaobaoDetailInfo($data = '') {
        $header[] = 'Host: api.m.taobao.com';
        $header[] = 'Cookie: _m_h5_tk=1a536ee9c52ed5f6f60e11988e732e5b_1450623353674; _m_h5_tk_enc=112e159ebd768a6c68e3f84e62813ab4; cna=lN0WDupQ52ACAXRNCTTgoekU; cookie2=1c4d97ad4879e81c46d570cf4cd9f4c0; isg=E6B5D3345D0F0890721AEA8856409994; l=Ar29Slj4pFFvKEWw77K/sgOEzQK3WPGs; t=d3181f1e0f66b7bf51bbde58e21f5be8; v=0';
        $header[] = 'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 9.2 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3 QHBrowser/242';
        $header[] = 'Accept-Language: zh-cn';
        $header[] = ' http://h5.m.taobao.com/app/movie/pages/index/show-list.html?spm=a1z2r.7661904.h5_cinema_list.1&_=_&cinemaid=4401&cinemaname=%E6%B7%B1%E5%9C%B3%E6%A8%AA%E5%BA%97%E7%94%B5%E5%BD%B1%E5%9F%8E&groupon=false';

        $ch = curl_init("http://api.m.taobao.com/h5/mtop.film.mtopscheduleapi.getschedulesbydays/4.0/?v=4.0&api=mtop.film.MtopScheduleAPI.getSchedulesByDays&appKey=12574478&t=1450619107891&callback=mtopjsonp2&type=jsonp&sign=5767682b43f6cd4ae3aec8cc197416ac&data=$data");

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);

//        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
        $filecontent = str_replace("mtopjsonp2(", '', $filecontent);
        $filecontent = substr($filecontent, 0, -1);
//        echo $filecontent;
//        exit;
        curl_close($ch);
        return $json = json_decode($filecontent, true);
    }

}
