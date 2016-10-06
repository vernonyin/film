<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="/film/jquery.js"></script>
        <style>
            table.gridtable {
                font-family: verdana,arial,sans-serif;
                font-size:11px;
                color:#333333;
                border-width: 1px;
                border-color: #666666;
                border-collapse: collapse;
            }
            table.gridtable th {
                border-width: 1px;
                padding: 8px;
                border-style: solid;
                border-color: #666666;
                background-color: #dedede;
            }
            table.gridtable td {
                border-width: 1px;
                padding: 8px;
                border-style: solid;
                border-color: #666666;
                background-color: #ffffff;
            }
        </style>
    </head>
    <body>

        <form>
            <select id="area_list">
                <option >罗湖区</option>
                <option >南山区</option>
                <option >龙岗区</option>
                <option >福田区</option>
                <option >宝安区</option>
                <option >盐田区</option>
                <option >其他区县</option>
            </select>
            <select id="cinema_list">         </select>
            <!--<select id="film_list">           </select>-->

<!--            <select id="time_list">
            </select>-->
            <input id="grab" type="button" value="抓取">
            <input id="see_now" type="button" value="实时查看当前票价">
        </form>
        <div id="data_div">div</div>
        <script type="text/javascript">
            $(document).ready(function () {
                //获取电影列表
                url = "/www/get_film_name_list.php";
                htmlobj = $.ajax({url: url, async: false});
                $("#film_list").html(htmlobj.responseText);
                //获取电影院列表
                url = "/film/get_cinema_list.php";
                htmlobj = $.ajax({url: url, async: false});
                $("#cinema_list").html(htmlobj.responseText);

                //下拉更新电影院列表
                $("#area_list").change(function () {
                    url = "/film/get_cinema_list.php?area_name=" + $("#area_list option:selected").val();
                    htmlobj = $.ajax({url: url, async: false});
                    $("#cinema_list").html(htmlobj.responseText);
                });

                //下拉更新电影时间
                $("#film_list").change(function () {
                    $(this).css("background-color", "#FFFFCC");
                    url = "/www/get_time_list.php?film=" + this.value;
                    htmlobj = $.ajax({url: url, async: false});
                    $("#time_list").html(htmlobj.responseText);
                });

                //抓取
                $("#grab").click(function () {
                    $(this).css("background-color", "#FFFFCC");
                    url = "/film/grab.php?cid=" + $("#cinema_list option:selected").val();
                    htmlobj = $.ajax({url: url, async: false});
                    $("#data_div").html(htmlobj.responseText);
                });
                
                //点击更新详情
                $("#see_now").click(function () {
                    $(this).css("background-color", "#FFFFCC");
                    url = "/film/get_film_list.php?cid=" + $("#cinema_list option:selected").val();
                    htmlobj = $.ajax({url: url, async: false});
                    $("#data_div").html(htmlobj.responseText);
                });

            });
        </script>
    </body>
</html>


