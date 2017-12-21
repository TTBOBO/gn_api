<?php
	
class Payment_Name{
	public static $ALIPAY = 'alipay';
	public static $WXPAY = 'wxpay';
}

class Payment_Lite {
	
	public function getPayInfo($payName,$info){
		
		if($payName == Payment_Name::$ALIPAY){
			$pay = new Payment_Alipay_Pay();
			return $pay->getURL($info);
		}else if($payName == Payment_Name::$WXPAY){
			$pay = new Payment_Wxpay_Pay();
			return $pay->getURL($info);
		}else{
			return null;
		}
		
	}
}
