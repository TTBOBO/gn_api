<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>WebService数据说明</title>
<style type="text/css">
	body {
		background-color: #fff;
		margin: 40px;
		font-size: 14px;
		line-height:22px;
		color: #4F5155;
		font-family:"宋体";
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration:none;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;		
		text-indent:0;
	}
	hr{
		border:1px dotted #ccc;
	}
	</style>
</head>
<body>
<?php
$url="/api/index.php/webservices/";
//$url="/api/webservices/";
?>
<h1>特别提醒：所有参数均为小写字母！</h1>
数据通信类型：<?php echo $dataType?><hr />
数据通信格式：<?php echo $format?><br />

<?php echo $desc?><hr />
WebService方法：<br>
<?php 
	$tmpCode="";
	foreach($webservice as $key=>$val){
		$tmpCode.='<div style="width:550px;padding:10px;height:330px;margin:10px ; float:left;overflow-y:auto;border:1px dotted #f00" >';
			$tmpCode.="方 法 名：<a href=\"{$url}{$val["serviceName"]}/?callback=undefined\" target=\"blank\">{$val["serviceName"]}</a><hr />";
			$tmpCode.="方法作用：{$val["desc"]}<hr />";
			$tmpCode.="通信方法：{$val["method"]}<hr />";
			$tmpCode.="格式说明：{$val["format"]}<hr />";
			$tmpCode.="data说明：{$val["result"]}<hr />传入参数：<br>";
			if(sizeof($val["para"])!=0){
				foreach($val["para"] as $k1=>$v1){
					$tmpCode.="参数名称：{$val["para"][$k1]["field"]}；";
					$tmpCode.="说明：{$val["para"][$k1]["desc"]}<br />";
				}
			}
		$tmpCode.="</div>";
	}
	echo $tmpCode;
?>
</body>
</html>