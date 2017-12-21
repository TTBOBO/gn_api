<?php
	require_once "WxPay.Api.php";
	require_once "WxPay.Data.php";

class Payment_Wxpay_Pay {
	
	
	
	
	public function getURL($r) {
		
		// 获取支付金额
		$amount= $r['recharge_money'];
		$total = floatval($amount);
		$total = round($total*100); // 将元转成分
		if(empty($total)){
		   return null;
		}
		
		// 商品名称
		$subject = '旅爱商城购买';
		// 订单号，示例代码使用时间值作为唯一的订单ID号
		$out_trade_no = $r['recharge_code'];		
		$unifiedOrder = new WxPayUnifiedOrder();
		$unifiedOrder->SetBody($subject);//商品或支付单简要描述
		$unifiedOrder->SetOut_trade_no($out_trade_no);
		$unifiedOrder->SetTotal_fee($total);
		$unifiedOrder->SetTrade_type("APP");
		$result = WxPayApi::unifiedOrder($unifiedOrder);
		if (is_array($result)) {
		    return json_encode($result);
		}
		return null;
	}
	
	
	
	
	
	
	
}
