<?php

class Api {
    #get
    static function getMeituanInfo() {
        $header[] = 'Host: api.meituan.com';
        $header[] = 'Authorization: 421bc88282466876871bddfacfa97543';
        $header[] = 'Accept: */*';
        $header[] = '__skck: c8a86f38931f8d49dbaadc416db7b31e';
        $header[] = 'userid: 58478909';
        $header[] = 'Connection: keep-alive';
        $header[] = '__skua: 528c0d6a760e8afed1fb2f860a37c8f7';
        $header[] = 'Key: E7FLNQOi';
        $header[] = 'Accept-Language: zh-Hans-CN, en-us;q=0.8';
        $header[] = 'Date: Sat, 05 Dec 2015 01:31:08 GMT';
        $header[] = 'Token: l0vNqDkhqW55vn_EKwnUs9UatSkAAAAAkwAAAG1wWd4MYqk1gZ015lHXeCU6_Wh_eG-th2Ag7jdVYJ-bRK2cCl9i6hQeRuNAhniisw';
        //压缩导致的
        //$header[]= 'Accept-Encoding: gzip, deflate';
        //$header[]= 'User-Agent: com.meituan.imeituan/823 (unknown, iPhone OS 9.1, iPhone, Scale/2.000000)';

        $ch = curl_init("http://api.meituan.com/show/v2/movies/shows.json?__skck=c8a86f38931f8d49dbaadc416db7b31e&__skcy=k3gLg2Qsl7Oa46VI%2F%2FNjP8EkDaw%3D&__skno=CED9CB87-9945-4A88-932D-AA35AE75F4A3&__skts=1449329224.833474&__skua=528c0d6a760e8afed1fb2f860a37c8f7&__vhost=api.maoyan.com&channelId=3&ci=30&client=iphone&clientType=ios&movieBundleVersion=100&msid=502B1EE0-96EE-4113-81E7-77A414E4D1D02015-12-05-23-2522&poi_id=1788402&utm_campaign=AgroupBgroupGhomepage_category2_99__a1&utm_content=2C3D940EE99D9C80AA657E3070AE9B01E4F0E9B8645237871DA3521B26FC4EF0&utm_medium=iphone&utm_source=AppStore&utm_term=6.2&uuid=2C3D940EE99D9C80AA657E3070AE9B01E4F0E9B8645237871DA3521B26FC4EF0&version_name=6.2");

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
//        echo $filecontent;exit;
        curl_close($ch);
        return $json = json_decode($filecontent, true);
    }
    //get
    static function getWeixinInfo() {
        $url = 'http://wx.wepiao.com/data/v5/cinemas/cities/221/sched_city_cinema_221_1003025.json?_1449307402552';
        $ch = curl_init($url);

        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
        $filecontent=str_replace('MovieData.set("sched_city_cinema_221_1003025",', "", $filecontent);
        $filecontent=str_replace(');', "", $filecontent);
//          echo $filecontent;exit;
        curl_close($ch);
        return $json = json_decode($filecontent, true);
    }

    //post
    static function getNuomiInfo() {
        $header[] = 'Host: movieapp.baidu.com';
        $header[] = 'Content-Type: application/json';
        $header[] = 'Accept: */*';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Cookie: BAIDUID=22C2DDF44B35AC7FCEB0F5F6C3426DE9:FG=1; BAINUOCUID=5cafcb1e1009f13c97b421ced5c89731b0e61ec7; BDUSS=VZsT3AzNDNqSFFBQ0ZNUW9hNnlkR1F1QmMwM25ST1lpemEzZFZ3aEVxNjhMamRXQVFBQUFBJCQAAAAAAAAAAAEAAADeNFMLye7b2sG6AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALyhD1a8oQ9WV; UID=190002398';

        $ch = curl_init("http://movieapp.baidu.com/na/app/dispatcher?mockup=0");

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        
       $post = '{"api":1003,"version":"1.0.0.1","user":{"bduss":"VZsT3AzNDNqSFFBQ0ZNUW9hNnlkR1F1QmMwM25ST1lpemEzZFZ3aEVxNjhMamRXQVFBQUFBJCQAAAAAAAAAAAEAAADeNFMLye7b2sG6AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALyhD1a8oQ9WV","cuid":"5cafcb1e1009f13c97b421ced5c89731b0e61ec7"},"data":"{\"cinemaId\":\"277\"}","timestamp":1449331045408,"channel":"nuomi","client":"na","osName":"ios","osVersion":9.1,"experimentIds":["214","217","120","210","253","222","212","218","83","118"],"subChannel":"com_dot_apple|portal|cinemaShow","sign":"b755e63015fdc01a772ba8628edffe49"}';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
//       echo $filecontent;exit;
        curl_close($ch);
        return $json = json_decode($filecontent, true);
    }
    
     //post
    static function get163Info($movie_id=0) {
        $header[] = 'Host: piao.163.com';
        $header[] = 'Content-Type: application/x-www-form-urlencoded';
        $header[] = 'Cookie: JSESSIONID=abc9nR_aaUpgkgDLe62fv; JSESSIONID0=230ab6059864eaf3b8396bd43c2a9161';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Accept: */*';
        $header[] = 'User-Agent: NTES(ios 9.1;iPhone;640*1136) Movie163/3.7.1';
        $header[] = 'Accept-Language: zh-Hans-CN;q=1';
        $header[] = 'Referer: http://piao.163.com/';
        
        if ($movie_id == 0){
            $url = "http://piao.163.com/m/cinema/schedule.html?app_id=2&mobileType=iPhone&ver=3.7.1&channel=lede&deviceId=C5998390-CE7F-4C91-95D1-82D72CACF035&apiVer=21&city=440300";
        }else{
            $url ="http://piao.163.com/m/cinema/ticket.html?app_id=2&mobileType=iPhone&ver=3.7.1&channel=lede&deviceId=C5998390-CE7F-4C91-95D1-82D72CACF035&apiVer=21&city=440300";
        }
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        
        $post = 'cinema_id=4062&movie_id='.$movie_id;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
       // echo $filecontent;exit;
        curl_close($ch);
        return $json = json_decode($filecontent, true);
    }
    
     //post
    static function getWeipiaoInfo() {
        $header[] = 'Host: ioscgi.wepiao.com';
        $header[] = 'Content-Type: application/x-www-form-urlencoded';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Connection: keep-alive';
        $header[] = 'Accept: */*';
        $header[] = 'User-Agent: WeiXinMovie/5.1.1 (iPhone; iOS 9.1; Scale/2.00)';
        $header[] = 'Accept-Language: zh-Hans-CN;q=1';

        $url = "http://ioscgi.wepiao.com/sche/cinema";
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        
        $post = 'appkey=8&appver=5.1.1&cinemaId=1003025&cityId=221&from=1234567890&sign=277224E3FBAACCC5CE8775F7B6A9B663&t=1449401213&v=2015102701';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        //不直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $filecontent = curl_exec($ch);
       // echo $filecontent;exit;
        curl_close($ch);
        return $json = json_decode($filecontent, true);
    }

}
