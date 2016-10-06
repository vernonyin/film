<html>
    <head>
        <title>电影票票价查询</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="/film/jquery.js"></script>
        <!-- 新 Bootstrap 核心 CSS 文件 -->
        <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- 可选的Bootstrap主题文件（一般不用引入） -->
        <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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
                padding: 2px 4px;
                border-style: solid;
                border-color: #666666;
                word-break:keep-all; /* for ie */
                white-space:nowrap; /* for chrome */
                background-color: #dedede;
            }
            table.gridtable td {
                border-width: 1px;
                padding: 2px 4px;
                border-style: solid;
                word-break:keep-all; /* for ie */
                white-space:nowrap; /* for chrome */
                border-color: #666666;
                background-color: #ffffff;
            }
            .dropdown-menu{
                min-width: inherit;
            }

            .dropdown{
                display: block;
                float: left;
                margin: 10px;
            }
            #grab, #see_now{
                /*clear: left;*/
                display: block;
                float: left;
                margin-left: 10px;
            }
            #grab{
                clear: left;
            }
            #data_div{
                clear: left;
                display: block;
                padding: 10px;
                float: none;
                /*background-color: blue;*/
            }
        </style>
    </head>
    <body>
        <div class="dropdown">
            <button type="button" class="btn btn-info dropdown-toggle" id="dropdownMenu1" 
                    data-toggle="dropdown">
                1.选择区域
                <span class="caret"></span>
            </button>
            <ul id="area_list" class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                <li><a href="#">罗湖区</a></li>  <li class="divider"></li>          <li><a href="#">南山区</a></li><li class="divider"></li>
                <li><a href="#">龙岗区</a></li>  <li class="divider"></li>          <li><a href="#">福田区</a></li><li class="divider"></li>
                <li><a href="#">宝安区</a></li>  <li class="divider"></li>          <li><a href="#">盐田区</a></li><li class="divider"></li>
                <li><a href="#">其他区县</a></li>
            </ul>
        </div>
        <div class="dropdown">
            <button type="button" value="142" class="btn btn-info dropdown-toggle" id="dropdownMenu2" 
                    data-toggle="dropdown">
                2.选择电影院
                <span class="caret"></span>
            </button>
            <ul id="cinema_list" class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">
            </ul>
        </div>
        <div class="btn-div">  
            <!--<button id="grab"  type="button" class="btn btn-success ">3.抓取</button>-->
            <button id="see_now" type="button" data-loading-text="Loading..." class="btn btn-success">3.实时查看当前票价</button>
        </div>
        <div id="data_div" >
            点查看后加载会有点久，要耐心等等.......
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                //拉取电影院列表
                $('#area_list a').click(function () {
                    $("#dropdownMenu1").text(this.innerHTML);
                    $('<span class="caret"></span>').appendTo("#dropdownMenu1")
                    url = "/film/get_cinema_list.php?area_name=" + this.innerHTML;
                    htmlobj = $.ajax({url: url, async: false});
                    $("#cinema_list").html(htmlobj.responseText);
                    //拉取电影院列表
                 $('#cinema_list a').click(function (event) {
                    $("#dropdownMenu2").text(this.innerHTML);
                    $('<span class="caret"></span>').appendTo("#dropdownMenu2")
                    $("#dropdownMenu2").attr("value",$(this).attr("value")); 
                });
                });
                //抓取
                $("#grab").click(function () {
                    url = "/film/grab.php?cid=" + $('#dropdownMenu2').attr("value");
                    $("#data_div").html("加载中....");
                    htmlobj = $.ajax({url: url, async: false});
                    $("#data_div").html(htmlobj.responseText);
//                    $("#grab").html("3.抓取");
                });
                
                $('#see_now').click(function () {
                    $("#data_div").html("加载中....");
                    $.ajax({
                        type: "GET",
                        url: "/film/get_cinema_list_2.php?cid=" +  $('#dropdownMenu2').attr("value"),
                        success: function (data) {
                              $("#data_div").html(data);
                        }
                    });
                });
            });

//            $(".dropdown-toggle").dropdown('toggle');
        </script>
    </body>
</html>


