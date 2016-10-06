<!DOCTYPE html>
<html>
<head>
      <meta charset="UTF-8">
   <title>Bootstrap 实例 - 下拉菜单（Dropdown）插件方法</title>
   <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
   <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
   <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</head>
<body>
<div class="dropdown">
   <button type="button" class="btn dropdown-toggle" id="dropdownMenu1" 
      data-toggle="dropdown">
      主题
      <span class="caret"></span>
   </button>
   <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
        <li><a href="#">罗湖区</a></li>            <li><a href="#">南山区</a></li>
            <li><a href="#">龙岗区</a></li>            <li><a href="#">福田区</a></li>
            <li><a href="#">宝安区</a></li>            <li><a href="#">盐田区</a></li>
            <li><a href="#">其他区县</a></li>
   </ul>
     <button id="grab"  type="button" class="btn btn-info ">抓取</button>
    <button id="see_now" type="button" class="btn btn-info">实时查看当前票价</button>
</div>
   

<script>
$(function(){
	// 默认显示
	$(".dropdown-toggle").dropdown('toggle');
}); 
</script>

</body>
</html>
