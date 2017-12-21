<?php

class Alipay_Config{
	public static $PARTNER = '2088221785819081'; // 必填，合作商户号、
	public static $SELLER_ID = 'mengxinkeji@sina.com'; // 必填，卖家支付宝账号
	public static $NOTIFY_URL = 'http://localhost:8088/';//服务器异步通知页面路径
	public static $PRIVATE_KEY = "-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQDKqWg6Sj7+OqtC/WFzbmcHS+O/clT5biOm0HtjZrWnEhAkqTN6
8LFCdgTX9uPa2/cy4eFdfxZYQ2UDjtQMpqB8Hoj/D0F2QmE+2VpqxaYFUdP8/+WZ
Xdy1hzUBFexi8V21B+PG7extlwnV2etfXwt5Haill0s3Cnrp+/m8IVbqYQIDAQAB
AoGAIwxlMB+DAWiYEb/MSLBBNSvUuVlGhNSdac4IaMpsg/ZFwHFaq9pQbZQHhmn2
QfVkrPIPjaHa9WzCXXkoBwASJNYfA9OgyujTG6FIAgMko5o05Oi4bJUmezZ4PKKl
9Jsin9VHYIhxDJIpooqVEYi8hU0bMgwi9eyOJL7M9/rUtnkCQQDxp0EAi5aHvsqt
4sF2I4qjw8ke/kpq4MaaUgO4BYzpM3rVIrxe0QkL3rsndmmP8Hmst1jo++3UJ/2h
y/++78eDAkEA1rGLCq0Niz8yV772K6CAwmFa07pUvbM9jS0BL8QRro63mlr/c0oU
YL7aF/ijpGo7WZ8lwZN/QEK4vhB9pHn9SwJBAIQNdtr6bJ7vZshQ4pFRaMCHC8+w
/C+dd0n7SWb1OYRyCkyQN8nEhyICa9lrvtHWglcctixTByrpU5Nn6/CGDUsCQBP6
09i7gB4sVHAMCnbG6hSs4LoBhi9dReYkgQ7D7W1URMvtmgZNp5XVTRCcCAaeCEXv
5KCeLGJ7kxvFBxxOaf8CQG7uVy5Zvxfke6lFi999FFvL5xSNYRaXvsep8rl4LH3s
0dAMvSL2JrWLbELC+923YttLBxY64qu9vZ55/bDBAzY=
-----END RSA PRIVATE KEY-----";
}

/**
 * 支付宝支付
 */

class Payment_Alipay_Pay {
	public function getURL($r) {
		$parameter = $this->createParamter($r);
		//生成需要签名的订单
		$orderInfo = $this-> createLinkstring($parameter);
		//签名
		$sign = $this->rsaSign($orderInfo);
		//生成订单
		return $orderInfo . '&sign="' . $sign . '"&sign_type="RSA"';
	}

	
	private function createParamter($r){
		return array(
		'notify_url'     =>urlencode( Alipay_Config::$NOTIFY_URL),  
		    'service'        => 'mobile.securitypay.pay',   // 必填，接口名称，固定值
		    
		    'partner'        => Alipay_Config::$PARTNER,                   // 必填，合作商户号
		    
		    '_input_charset' => 'UTF-8',                    // 必填，参数编码字符集
		    'out_trade_no'   => $r['recharge_code'],              // 必填，商户网站唯一订单号
		    'subject'        => '旅爱商城购买',                   // 必填，商品名称
		    'payment_type'   => '1',                        // 必填，支付类型
		    'seller_id'      => Alipay_Config::$SELLER_ID,                 // 必填，卖家支付宝账号
		    'total_fee'      => $r['recharge_money'],                     // 必填，总金额，取值范围为[0.01,100000000.00]
		    
		    'body'           => '消费'.$r['recharge_money'].'元购买',                      // 必填，商品详情
		    
		    'it_b_pay'       => '1d',                       // 可选，未付款交易的超时时间
		                  // 可选，服务器异步通知页面路径
		    //'show_url'       => $base_path                  // 可选，商品展示网站
		 );
	}



	// 对签名字符串转义
	private function createLinkstring($para) {
		$arg = "";
		while (list($key, $val) = each($para)) {
			$arg .= $key . '="' . $val . '"&';
		}
		//去掉最后一个&字符
		$arg = substr($arg, 0, count($arg) - 2);
		//如果存在转义字符，那么去掉转义
		if (get_magic_quotes_gpc()) {$arg = stripslashes($arg);
		}
		return $arg;
	}

	// 签名生成订单信息
	private function rsaSign($data) {
		
		$priKey = Alipay_Config::$PRIVATE_KEY;
		$res = openssl_pkey_get_private($priKey);
		openssl_sign($data, $sign, $res);
		openssl_free_key($res);
		$sign = base64_encode($sign);
		$sign = urlencode($sign);
		return $sign;
	}

}
