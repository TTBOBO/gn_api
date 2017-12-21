<?php 
	/***********************#rest.php ��֮Ѷ����DEMO************************************
	*@function create($client_id,$client_pwd,$acc_id,$acc_token,$expire_time='')JSON��ʽע�����ִ�Сд
	*@author ��֮Ѷ
	*@date 2014-07-17
	*
	*ʹ����� python createtoken.py client_id client_pwd acc_id acc_token expire_time
	*@param $client_id string true client�˺�
	*@param $client_pwd string true client������
	*@param $acc_id string true ���˺�
	*@param $acc_token string true ���˺ŵ�token
	*@param $expire_time string false UTCʱ�� �ȱ���ʱ����8��Сʱ����ʽ��20140605184430
	*
	*/
	 
	function create($client_id,$client_pwd,$acc_id,$acc_token,$expire_time='') {
		
		//��ʱʱ���ʽ��20140605184430�������øò����Ļ�Ĭ�ϴ����ڿ�ʼ��Ч������
		if(empty($expire_time)) {
			//$expire_time = date('ymdHis',time()+3600*48);
			$expire_time = date('YmdHis',time()+3600*48);
			//echo $expire_time.PHP_EOL;
		}
		// ���head��Ϣ
		$head_arr = array();
		$head_arr['Alg'] = 'HS256';
		$head_arr['Accid'] = $acc_id;
		$head_arr['Cnumber'] = $client_id;
		$head_arr['Expiretime'] = $expire_time;
		
		$head = json_encode($head_arr);
		// echo $head.PHP_EOL;
		
		// ���body��Ϣ
		$body_arr = array();
		
		$body_arr['Accid'] = $acc_id;
		$body_arr['AccToken'] = $acc_token;
		$body_arr['Cnumber'] = $client_id;
		$body_arr['Cpwd'] = $client_pwd;
		$body_arr['Expiretime'] = $expire_time;
		
		$body = json_encode($body_arr);
		// echo $body.PHP_EOL;
		//HMAC+SHA256 ��֤��ʽ��keyΪ���˺ŵ�token
		//$body_bytes = hash_hmac( "sha224", utf8_encode( $body ), utf8_encode( $acc_token ),false );
		$hmac_arr ="sha256";
		$body_bytes = hash_hmac($hmac_arr , $body , $acc_token , true);
		// echo $body_bytes.PHP_EOL;
		//#base64����
		$body_bytes = base64_encode($body_bytes);
		$head = base64_encode(utf8_encode($head));
		// ��SLC header��SLC pyloadʹ�á�.���������ӣ����������SLC
		
		return $head.".".$body_bytes;
	}
	
	// $client_id = 'e03b2c9a6c6ed0eaebfc2c9a68fdcd48'; // client�˺�
	// $client_pwd = 123456;							 // client������
	// $acc_id = '7a19d21e2c9a455992056eeaebb33f96';	//	���˺�
	// $acc_token = 'bf1c61c0e1eaebce31916eea051c5f1b';	//���˺ŵ�token
	// $expire_time = '3600';							//  Ϊ�յĻ���Ч��Ϊ��ǰʱ������ ����ʱ��	
	
	 // $success_date = create($client_id,$client_pwd,$acc_id,$acc_token,$expire_time);
	 //echo "<br>";
  	 // print_r($success_date);
	 
?>