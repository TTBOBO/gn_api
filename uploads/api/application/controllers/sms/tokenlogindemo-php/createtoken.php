<?php 
	/***********************#rest.php 云之讯开发DEMO************************************
	*@function create($client_id,$client_pwd,$acc_id,$acc_token,$expire_time='')JSON格式注意区分大小写
	*@author 云之讯
	*@date 2014-07-17
	*
	*使用命令： python createtoken.py client_id client_pwd acc_id acc_token expire_time
	*@param $client_id string true client账号
	*@param $client_pwd string true client的密码
	*@param $acc_id string true 主账号
	*@param $acc_token string true 主账号的token
	*@param $expire_time string false UTC时间 比北京时间晚8个小时，格式：20140605184430
	*
	*/
	 
	function create($client_id,$client_pwd,$acc_id,$acc_token,$expire_time='') {
		
		//超时时间格式：20140605184430。不设置该参数的话默认从现在开始有效期两天
		if(empty($expire_time)) {
			//$expire_time = date('ymdHis',time()+3600*48);
			$expire_time = date('YmdHis',time()+3600*48);
			//echo $expire_time.PHP_EOL;
		}
		// 组合head信息
		$head_arr = array();
		$head_arr['Alg'] = 'HS256';
		$head_arr['Accid'] = $acc_id;
		$head_arr['Cnumber'] = $client_id;
		$head_arr['Expiretime'] = $expire_time;
		
		$head = json_encode($head_arr);
		// echo $head.PHP_EOL;
		
		// 组合body信息
		$body_arr = array();
		
		$body_arr['Accid'] = $acc_id;
		$body_arr['AccToken'] = $acc_token;
		$body_arr['Cnumber'] = $client_id;
		$body_arr['Cpwd'] = $client_pwd;
		$body_arr['Expiretime'] = $expire_time;
		
		$body = json_encode($body_arr);
		// echo $body.PHP_EOL;
		//HMAC+SHA256 认证方式。key为主账号的token
		//$body_bytes = hash_hmac( "sha224", utf8_encode( $body ), utf8_encode( $acc_token ),false );
		$hmac_arr ="sha256";
		$body_bytes = hash_hmac($hmac_arr , $body , $acc_token , true);
		// echo $body_bytes.PHP_EOL;
		//#base64编码
		$body_bytes = base64_encode($body_bytes);
		$head = base64_encode(utf8_encode($head));
		// 将SLC header，SLC pyload使用“.”进行连接，获得完整的SLC
		
		return $head.".".$body_bytes;
	}
	
	// $client_id = 'e03b2c9a6c6ed0eaebfc2c9a68fdcd48'; // client账号
	// $client_pwd = 123456;							 // client的密码
	// $acc_id = '7a19d21e2c9a455992056eeaebb33f96';	//	主账号
	// $acc_token = 'bf1c61c0e1eaebce31916eea051c5f1b';	//主账号的token
	// $expire_time = '3600';							//  为空的话有效期为当前时间算起 两天时间	
	
	 // $success_date = create($client_id,$client_pwd,$acc_id,$acc_token,$expire_time);
	 //echo "<br>";
  	 // print_r($success_date);
	 
?>