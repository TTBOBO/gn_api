<?php
/**
 * Created by PhpStorm.
 * User: TAB00
 * Date: 2017/3/18
 * Time: 17:14
 */

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
<!--	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />-->
	<title></title>
	<style>
		.mui-bar-nav
		{
			top: 0;

			-webkit-box-shadow: 0 1px 6px #ccc;
			box-shadow: 0 1px 6px #ccc;
		}
		.mui-bar{
			position: fixed;
			z-index: 10;
			right: 0;
			left: 0;
			height: 80px;
			padding:10px;
			border-bottom: 0;
			background-color: #f7f7f7;
			-webkit-box-shadow: 0 0 1px rgba(0,0,0,.85);
			box-shadow: 0 0 1px rgba(0,0,0,.85);
			-webkit-backface-visibility: hidden;
			backface-visibility: hidden;
		}
		.mui-title{
			font-size: 35px;
			font-weight: 500;
			line-height: 80px;
			position: absolute;
			display: block;
			width: 100%;
			margin: 0 -10px;
			padding: 0;
			text-align: center;
			white-space: nowrap;
			color: #000;
		}
		body{
			margin: 0;
		}
		.titsud {
			width: 95%;
			margin-left: 2.5%;
			margin-top: 5px;
			font-family: "黑体";
			font-size: 20px;
			margin-top: 150px;
		}



		#writer1 {
			font-size: 12px;
		}

		.writerTitle,
		.releseTime {
			font-size:30px;
		}

		#hour1 {
			padding-left: 50px;
			font-size: 30px;
		}







		h4 {
			position: absolute;
			margin-left: 20px;
		}



		nav>span {
			margin-left: 8%;
		}

		.article_content {
			width: 100%;
			height: 100px;
		}

		.title {
			font-size: 50px;
			font-weight: bolder;
		}

		.article_time {
			height: 30px;
			width: 100%;
			color: #B6B6B6;
			margin-top: 20px;
		}


		.recommend span:before {
			width: 57px;
			content: '';
			height: 1px;
			background: #DC143C;
			position: absolute;
			bottom: -1px;
		}

		.body_content{
			width: 100%;
			padding: 10px;
			font-size: 30px;
		}
		img{
			width: 100%;
			height:500px!important;
		}
	</style>
</head>
<body>
	<header style="background: #d74b28;" class="mui-bar mui-bar-nav" id="header">
		<h1 class="mui-title" style="color: white;">文章详情</h1>
	</header>
	<div class="titsud">
		<div class="article_content">
			<span id="title" class="title"><?php echo $data ["title"]?></span>
			<div class="article_time">
				<span class="writerTitle"><?php echo $data ["writer"]?></span><span id="writer1"></span>
				<!--<span class="releseTime">发布时间：</span>-->
				<span id="hour1"><?php echo date("Y-m-d", $data["pubdate"])?></span>
			</div>
		</div>
		<div class="body_content">
			<?php echo $data ["body"] ?>
		</div>
	</div>
</body>
</html>
<?php
//var_dump($data);
?>

