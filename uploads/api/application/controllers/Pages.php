<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Pages extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		header ( "content-type:text/html;charset=utf-8" );
		$this->webserviceArr = array (
				"dataType" => "jsonp",
				"format" => 'callbackName({"msg":"msgData","code":"codeData","data":{"field":"value"}})',
				"desc" => "<div>通信格式说明：<br>callbackName：自定义的回调名；
				msg：通信消息；
				code：通信代码（2000表示获取数据成功，4001表示数据为空）；
				data：通信数据内容（只有 code是2000的时候才有数据）</div>", 
				"webserviceMethod"=>array()
		);
	}
	public function index() {
		$dedecmsDsUrl='http://help.dedecms.com/develop/2011/0714/166.html';
		/*urlencode测试处理 -start*/
		$Method=	array (
				"serviceName" => "urlencodeHandler",
				"desc" => "urlencode测试处理",
				"method" => 'GET',
				"format" => 'urlencode处理后的字符串',
				"result" => "urlencode处理后的字符串",
				"para" => array (
						array (
								"field" => "str",
								"desc" => "需要urlencode处理的字符串"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*urlencode测试处理 -end*/

		/*urldecode测试处理 -start*/
		$Method=	array (
				"serviceName" => "urldecodeHandler",
				"desc" => "urldecode测试处理",
				"method" => 'GET',
				"format" => 'urldecode处理后的字符串',
				"result" => "urldecode处理后的字符串",
				"para" => array (
						array (
								"field" => "str",
								"desc" => "需要urldecode处理的字符串"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*urldecode测试处理 -end*/
		/*获得图集文章列表数据 -start*/
        $Method=	array (
            "serviceName" => "get_img_article",
            "desc" => "获得图集文章列表",
            "method" => 'GET',
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
            "result" => "data内为图集文章列表字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a> <a target = \"blank\" href = \"{$dedecmsDsUrl}#dede_addonimages\" >dede_addonimages字段</a>",
            //data内为文章列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a>
            "para" => array (
                array (
                    "field" => "typeid",
                    "desc" => "栏目id( 默认：2 新闻图集栏目 )"
                ),
                array (
                    "field" => "page",
                    "desc" => "当前页码( 默认：2 )"
                ),
                array (
                    "field" => "pagesize",
                    "desc" => "分页数量( 默认：10 )"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);
        /*获得图集文章列表数据 -end*/

        /*获得图集文章内容数据 -start*/
        $Method=	array (
            "serviceName" => "get_img_article_content",
            "desc" => "获得图集文章内容",
            "method" => 'GET',
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
            "result" => "data内为图集文章内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a> <a target = \"blank\" href = \"{$dedecmsDsUrl}#dede_addonimages\" >dede_addonimages字段</a>",
            //data内为文章列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a>
            "para" => array (
                array (
                    "field" => "id",
                    "desc" => "图集文章id( 默认：id降序  第一条数据 )"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);
        /*获得图集文章内容数据 -end*/

        /*用户发布动态文章 -start*/
        $Method = array(
            "serviceName" => "set_release_img",
            "desc" => "用户发布新闻动态",
            "mothod" => "POST",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a> <a target = \"blank\" href = \"{$dedecmsDsUrl}#dede_addonimages\" >dede_addonimages字段</a>",
            "para" => array (
                array (
                    "field" => "mid",
                    "desc" => "用户id"
                ),
                array(
                    "field" => "img",
                    "desc" => "用户动态的图片集，最少一张"
                ),
                array(
                    "field" => "msg",
                    "desc" => "动态内容，不能为空"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);
        /*用户发布动态文章 - end*/

        /*用户获取动态文章 -start*/
        $Method = array(
            "serviceName" => "get_release_list",
            "desc" => "获取用户新闻动态",
            "mothod" => "POST",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a> <a target = \"blank\" href = \"{$dedecmsDsUrl}#dede_addonimages\" >dede_addonimages字段</a>",
            "para" => array (
                array (
                    "field" => "typeid",
                    "desc" => "栏目id（默认为10  社区）"
                ),
                array(
                    "field" => "page",
                    "desc" => "当前页码( 默认：2 )"
                ),
                array(
                    "field" => "pageSize",
                    "desc" => "分页数量( 默认：10 )"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);


        /*聚实惠商品目录 - start*/
        $Method = array(
            "serviceName" => "get_shop_list",
            "desc" => "商品列表",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "para" => array (
                array (
                    "field" => "typeid",
                    "desc" => "栏目id（默认为10  社区）"
                ),
                array(
                    "field" => "page",
                    "desc" => "当前页码( 默认：2 )"
                ),
                array(
                    "field" => "pageSize",
                    "desc" => "分页数量( 默认：10 )"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*聚实惠商品目录 - end*/

        /*获取商品价格信息 - start*/
        $Method = array(
            "serviceName" => "get_shop_detail",
            "desc" => "获取商品价格信息",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "para" => array (
                array (
                    "field" => "shopid",
                    "desc" => "商品id"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*获取商品价格信息 - end*/

        /*获取商品详情信息 - start*/
        $Method = array(
            "serviceName" => "get_shop_about",
            "desc" => "获取商品价格信息",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "para" => array (
                array (
                    "field" => "shopid",
                    "desc" => "商品id"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*获取商品详情信息 - end*/

        /*聚实惠商品分类 - start*/
        $Method = array(
            "serviceName" => "get_shop_subClass",
            "desc" => "聚实惠商品分类",
            "mothod" => "get",
            "para" => array (
                array (
                    "field" => "typeid",
                    "desc" => "栏目id（默认为3 聚实惠子类）"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*聚实惠商品分类 - end*/

        /*聚实惠商品分类（子类商品列表） - start*/
        $Method = array(
            "serviceName" => "get_shop_subClass_list",
            "desc" => "聚实惠商品分类（子类商品列表）",
            "mothod" => "get",
            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "para" => array (
                array (
                    "field" => "typeid",
                    "desc" => "栏目id（默认为10  社区）"
                ),
                array(
                    "field" => "page",
                    "desc" => "当前页码( 默认：2 )"
                ),
                array(
                    "field" => "pageSize",
                    "desc" => "分页数量( 默认：10 )"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*聚实惠商品分类（子类商品列表） - end*/

        /*汽车栏目商品信息 - start*/
        $Method = array(
            "serviceName" => "get_car_about",
            "desc" => "汽车栏目商品信息",
            "mothod" => "get",
            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "para" => array (
                array (
                    "field" => "id",
                    "desc" => "汽车栏目商品的id"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*汽车栏目商品信息 - end*/

        /*用户添加收货地址 - start*/

        $Method = array(
            "serviceName" => "add_user_address",
            "desc" => "用户添加收货地址",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败,user_no_had表示用户不存在）",
            "para" => array (
                array (
                    "field" => "userid",
                    "desc" => "用户id）"
                ),
                array(
                    "field" => "consignee",
                    "desc" => "收货人姓名"
                ),
                array(
                    "field" => "address",
                    "desc" => "收货地址"
                ),
                array(
                    "field" => "city",
                    "desc" => "所在地区"
                ),
                array(
                    "field" => "tel",
                    "desc" => "收货电话号码"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户添加收货地址 - end */

        /*用户修改收货地址 - start*/

        $Method = array(
            "serviceName" => "update_user_address",
            "desc" => "用户修改收货地址",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败,user_no_had表示用户不存在）",
            "para" => array (
                array (
                    "field" => "aid",
                    "desc" => "（地址id）"
                ),
                array (
                    "field" => "mid",
                    "desc" => "用户id）"
                ),
                array(
                    "field" => "consignee",
                    "desc" => "收货人姓名"
                ),
                array(
                    "field" => "address",
                    "desc" => "收货地址"
                ),
                array(
                    "field" => "city",
                    "desc" => "所在地区"
                ),
                array(
                    "field" => "tel",
                    "desc" => "收货电话号码"
                ),
                 array(
                     "field" => "des",
                     "desc" => "是否为默认地址"
                 )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户修改收货地址 - end */

        /*用户获取收货地址 - start*/

        $Method = array(
            "serviceName" => "get_user_address",
            "desc" => "用户获取收货地址",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败,user_no_had表示用户不存在）",
            "para" => array (
                array (
                    "field" => "mid",
                    "desc" => "用户id）"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户获取收货地址 - end */

        /*用户删除收货地址 - start*/

        $Method = array(
            "serviceName" => "delete_user_address",
            "desc" => "用户删除收货地址",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败,user_no_had表示用户不存在）",
            "para" => array (
                array (
                    "field" => "mid",
                    "desc" => "用户id）"
                ),
                array (
                    "field" => "aid",
                    "desc" => "地址id）"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户删除收货地址 - end */

        /*通过点击单选框更改默认收货地址 - start*/

        $Method = array(
            "serviceName" => "change_defult_address",
            "desc" => "通过点击单选框更改默认收货地址",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br>result是为保存结果（success表示更改成功，failed表示更改失败）",
            "para" => array (
                array (
                    "field" => "mid",
                    "desc" => "用户id）"
                ),
                array (
                    "field" => "aid",
                    "desc" => "地址aid）"
                ),
                array (
                    "field" => "des",
                    "desc" => "是否为默认地址）"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*通过点击单选框更改默认收货地址 - end */

        /*点击购买添加订单 - start*/

        $Method = array(
            "serviceName" => "set_order_list",
            "desc" => "点击购买添加订单",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br>result是为保存结果（success表示添加成功，failed表示添加失败）",
            "para" => array (
                array (
                    "field" => "mid",
                    "desc" => "（用户id）"
                ),
                array (
                    "field" => "aid",
                    "desc" => "（商品aid）"
                ),
                array (
                    "field" => "title",
                    "desc" => "（商品名称）"
                ),
                array (
                    "field" => "price",
                    "desc" => "（商品单价））"
                ),
                array (
                    "field" => "count",
                    "desc" => "（购买数量）"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*点击购买添加订单 - end */

        /*加入购物车 - start */
        $Method = array(
            "serviceName" => "add_shop_car",
            "desc" => "加入购物车",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br>msg是为保存结果（success表示添加成功，failed表示添加失败）",
            "para" => array (
                array (
                    "field" => "mid",
                    "desc" => "用户id"
                ),
                array (
                    "field" => "id",
                    "desc" => "商品id"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*加入购物车 - end */

        /*获取用户购物车订单 -start*/
        $Method = array(
            "serviceName" => "get_user_shop_car_list",
            "desc" => "获取用户购物车订单",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br>当state为0时是未支付状态在购物车显示",
            "para" => array (
                array (
                    "field" => "userid",
                    "desc" => "用户id"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);
        /*获取用户购物车订单 -end*/

        /*用户购物车提交订单 -start*/
        $Method = array(
            "serviceName" => "buy_from_car",
            "desc" => "用户购物车提交订单",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br><br>msg是为保存结果（success表示购买成功，failed表示购买失败）",
            "para" => array (
                array (
                    "field" => "oid",
                    "desc" => "订单的订单号，必须以数组的方式上传，每个值用逗号分隔"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户购物车提交订单 -end*/


        /*用户删除购物车订单 -start*/
        $Method = array(
            "serviceName" => "delete_user_car_list",
            "desc" => "用户删除购物车订单",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br>msg是为保存结果（success表示添加成功，failed表示添加失败）",
            "para" => array (
                array (
                    "field" => "oid",
                    "desc" => "订单id"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户删除购物车订单 -end*/

        /*通过关键字搜索信息 - start*/
        $Method = array(
            "serviceName" => "select_for_keywords",
            "desc" => "通过关键字搜索信息",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br>result是为保存结果（success表示添加成功，failed表示添加失败）",
            "para" => array (
                array (
                    "field" => "typeid",
                    "desc" => "栏目id"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*通过关键字搜索信息 - end */


        /*用户每次搜素关键字就添加一次记录便于关键字排名 - start*/
        $Method = array(
            "serviceName" => "set_user_search_keywords",
            "desc" => "用户每次搜素关键字就添加一次记录便于关键字排名",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br>result是为保存结果（success表示添加成功，failed表示添加失败）",
            "para" => array (
                array (
                    "field" => "keywords",
                    "desc" => "关键字"
                ),
                array (
                    "field" => "typeid",
                    "desc" => "栏目id"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户每次搜素关键字就添加一次记录便于关键字排名 - end */


        /*页面获取搜索关键字排名 - start*/
        $Method = array(
            "serviceName" => "get_hot_search_keywords",
            "desc" => "页面获取搜索关键字排名",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br>result是为保存结果（success表示添加成功，failed表示添加失败）",
            "para" => array (
                array (
                    "field" => "typeid",
                    "desc" => "栏目id"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*页面获取搜索关键字排名 - end */



        /*用户获取订单 - start*/
        $Method = array(
            "serviceName" => "get_user_order",
            "desc" => "用户获取订单",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "result" => "<br>result是为保存结果（success表示添加成功，failed表示添加失败） sta为订单状态 0：为在购物车，1：为发货中待收货，2：已收货未评论，3：已评论",
            "para" => array (
                array (
                    "field" => "mid",
                    "desc" => "用户id"
                ),
                array (
                    "field" => "page",
                    "desc" => "当前页码(默认：1)"
                ),
                array (
                    "field" => "pagesize",
                    "desc" => "分页数量(默认：10)"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户获取订单 - end */
        /*用户确认收货并修改评论状态 - start*/
        $Method = array(
            "serviceName" => "comment_state",
            "desc" => "用户确认收货并修改评论状态",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "para" => array (
                array (
                    "field" => "buyid",
                    "desc" => "订单号"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户确认收货并修改评论状态 - end */


        /*用户评论订单并修改评论状态 - start*/
        $Method = array(
            "serviceName" => "updatecomment",
            "desc" => "用户评论订单并修改评论状态",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",
            "para" => array (
                array (
                    "field" => "buyid",
                    "desc" => "订单号"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户评论订单并修改评论状态 - end */

        /*用户添加收货地址 - start*/

        $Method = array(
            "serviceName" => "set_member_address",
            "desc" => "收货地址",
            "mothod" => "get",
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
//            "result" => "data内为动态内容字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_addonshop\">dede_addonshop字段</a>",

            "para" => array (
                array (
                    "field" => "mid",
                    "desc" => "用户id）"
                ),
                array(
                    "field" => "consignee",
                    "desc" => "收货人姓名"
                ),
                array(
                    "field" => "address",
                    "desc" => "收货地址"
                ),
                array(
                    "field" => "tel",
                    "desc" => "收货电话号码"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户添加收货地址 - end */


        /*$Method=	array (
            "serviceName" => "get_article_img",
            "desc" => "获得图集文章列表",
            "method" => 'GET',
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
            "result" => "data内为图集文章列表字段，参考<a target = \"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a> <a target = \"blank\" href = \"{$dedecmsDsUrl}#dede_addonimages\" >dede_addonimages字段</a>",
            //data内为文章列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a>
            "para" => array (
                array (
                    "field" => "typeid",
                    "desc" => "栏目id( 默认：2 新闻图集栏目 )"
                ),
                array (
                    "field" => "page",
                    "desc" => "当前页码( 默认：1 )"
                ),
                array (
                    "field" => "pagesize",
                    "desc" => "分页数量( 默认：10 )"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);*/


        /*获取用户发布的动态 -start*/
        $Method=	array (
            "serviceName" => "get_user_dynamic_list",
            "desc" => "获取用户发布的动态列表",
            "method" => 'GET',
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
            "result" => "data内为文章列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a>",
            "para" => array (
                array (
                    "field" => "mid",
                    "desc" => "用户id"
                ),
                array (
                    "field" => "page",
                    "desc" => "当前页码(默认：1)"
                ),
                array (
                    "field" => "pagesize",
                    "desc" => "分页数量(默认：10)"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*获取用户发布的动态 -end*/


        /*用户删除发布的动态 -start*/
        $Method=	array (
            "serviceName" => "delete_user_dynamic",
            "desc" => "用户删除发布的动态",
            "method" => 'GET',
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
            "result" => "data内为文章列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a>",
            "para" => array (
                array (
                    "field" => "id",
                    "desc" => "动态id"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户删除发布的动态 -end*/

        /*用户删除发布的动态 -start*/
        $Method=	array (
            "serviceName" => "deleteImg",
            "desc" => "删除图片",
            "method" => 'GET',
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
            "result" => "data内为文章列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a>",
            "para" => array (
                array (
                    "field" => "id",
                    "desc" => "动态id"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户删除发布的动态 -end*/

		/*获取焦点图片文章列表数据 -start*/
		$Method=	array (
				"serviceName" => "get_article_focus_list",
				"desc" => "获取焦点图片文章列表",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为文章列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a>",
				"para" => array (
						array (
								"field" => "typeid",
								"desc" => "栏目id(默认：0，所有栏目)"
						),
						array (
								"field" => "page",
								"desc" => "当前页码(默认：1)"
						),
						array (
								"field" => "pagesize",
								"desc" => "分页数量(默认：10)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取焦点图片文章列表数据 -end*/
		/*获取文章列表数据 -start*/
		$Method=	array (
						"serviceName" => "get_article_list",
						"desc" => "获取文章列表",
						"method" => 'GET',
						"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
						"result" => "data内为文章列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a>",
						"para" => array (
								array (
										"field" => "typeid",
										"desc" => "栏目id(默认：0，所有栏目)"
								),
								array (
										"field" => "page",
										"desc" => "当前页码(默认：1)"
								),
								array (
										"field" => "pagesize",
										"desc" => "分页数量(默认：10)"
								)
						)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取文章列表数据 -end*/

		/*获取文章内容数据 -start*/
		$Method=	array (
				"serviceName" => "get_article_contents",
				"desc" => "获取文章内容",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为文章内容字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a>",
				"para" => array (
						array (
								"field" => "id",
								"desc" => "文章id(默认：id降序，第一条数据)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取文章详情数据 -end*/

        /*添加文章的浏览量 -start*/
        $Method=	array (
            "serviceName" => "set_article_click",
            "desc" => "添加文章的浏览量",
            "method" => 'GET',
            "format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
            "result" => "data内为文章内容字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a>",
            "para" => array (
                array (
                    "field" => "id",
                    "desc" => "文章id(默认：id降序，第一条数据)"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);
        /*添加文章的浏览量 -end*/

		/*获取文章栏目数据 -start*/
		$Method=	array (
				"serviceName" => "get_article_category",
				"desc" => "获取文章栏目",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为文章栏目字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_arctype\">dede_arctype字段</a>",
				"para" => array (
						array (
								"field" => "id",
								"desc" => "栏目id(默认：0，所有栏目)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取文章栏目数据 -end*/
		/*给文章点赞操作 -start*/
		$Method=	array (
				"serviceName" => "set_article_isgood",
				"desc" => "给文章点赞操作",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","goodpost":"5"}})',
				"result" => "<br>result是为操作结果（success表示操作成功，failed表示操作失败）
										<br>goodpost是为操作后的赞数，操作失败的情况下是-1",
				"para" => array (
						array (
								"field" => "id",
								"desc" => "文章id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*给文章点赞操作 -end*/
		/*获取文章检索列表数据 -start*/
		$Method=	array (
				"serviceName" => "get_article_list_by_keywords",
				"desc" => "获取文章检索列表数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为文章列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a>",
				"para" => array (
						array (
								"field" => "typeid",
								"desc" => "栏目id(默认：0，所有栏目)"
						),
						array (
								"field" => "keywords",
								"desc" => "检索关键词(默认：空)"
						),
						array (
								"field" => "page",
								"desc" => "当前页码(默认：1)"
						),
						array (
								"field" => "pagesize",
								"desc" => "分页数量(默认：10)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取文章检索列表数据 -end*/
		/*获取问答检索列表数据 -start*/
		$Method=	array (
				"serviceName" => "get_ask_list_by_keywords",
				"desc" => "获取问答检索列表",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为问答列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_ask\">dede_ask字段</a>",
				"para" => array (
						array (
								"field" => "tid",
								"desc" => "栏目id(默认：0，所有栏目)"
						),
						array (
								"field" => "keywords",
								"desc" => "检索关键词(默认：空)"
						),
						array (
								"field" => "page",
								"desc" => "当前页码(默认：1)"
						),
						array (
								"field" => "pagesize",
								"desc" => "分页数量(默认：10)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取问答检索列表数据 -end*/
		/*获取问答栏目数据 -start*/
		$Method=	array (
				"serviceName" => "get_ask_category",
				"desc" => "获取问答栏目",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为问答栏目字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_asktype\">dede_asktype字段</a>",
				"para" => array (
						array (
								"field" => "id",
								"desc" => "栏目id(默认：0，所有栏目)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取问答栏目数据 -end*/
		/*获取问答列表数据 -start*/
		$Method=	array (
				"serviceName" => "get_ask_list",
				"desc" => "获取问答列表（通过栏目id）",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为问答列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_ask\">dede_ask字段</a>",
				"para" => array (
						array (
								"field" => "tid",
								"desc" => "栏目id(默认：0，所有栏目)"
						),
						array (
								"field" => "page",
								"desc" => "当前页码(默认：1)"
						),
						array (
								"field" => "pagesize",
								"desc" => "分页数量(默认：10)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取问答列表数据 -end*/
		/*获取问答列表（通过状态） -start*/
		$Method=	array (
				"serviceName" => "get_ask_list_by_status",
				"desc" => "获取问答列表（通过状态）",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为问答列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_ask\">dede_ask字段</a>",
				"para" => array (
						array (
								"field" => "status",
								"desc" => "状态(默认：0：待解决；1：已解决；2：已关闭)"
						),
						array (
								"field" => "mid",
								"desc" => "用户id(默认：0，表示所有用户)"
						),
						array (
								"field" => "page",
								"desc" => "当前页码(默认：1)"
						),
						array (
								"field" => "pagesize",
								"desc" => "分页数量(默认：10)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取问答列表（通过状态） -end*/
		/*获取用户回答过的问题列表 -start*/
		$Method=	array (
				"serviceName" => "get_answered_ask_list_by_mid",
				"desc" => "获取用户回答过的问题列表",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为问答列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_ask\">dede_ask字段</a>",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(默认：0，表示所有用户)"
						),
						array (
								"field" => "page",
								"desc" => "当前页码(默认：1)"
						),
						array (
								"field" => "pagesize",
								"desc" => "分页数量(默认：10)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取用户回答过的问题列表 -end*/
		/*获取问答详细数据 -start*/
		$Method=	array (
				"serviceName" => "get_ask_details",
				"desc" => "获取问答详细数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"askData":{},answerData:[]}})',
				"result" => "<br>data内askData为问答字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_ask\">dede_ask字段</a>
				<br>data内answerData为该问答的回答列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_askanswer\">dede_askanswer字段</a>",
				"para" => array (
						array (
								"field" => "id",
								"desc" => "问题id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取问答详细数据 -end*/
		/*设置问答状态 -start*/
		$Method=	array (
				"serviceName" => "set_ask_status",
				"desc" => "设置问答状态",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败）",
				"para" => array (
						array (
								"field" => "id",
								"desc" => "问答id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "status",
								"desc" => "问答状态(不允许为空！！！必须是数字！！！<br>状态值说明：-1未审核，1已解决，0待解决，2已关闭，3已过期)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*设置问答状态 -end*/
		/*保存用户发布问答数据 -start*/
		$Method=	array (
				"serviceName" => "set_ask_save",
				"desc" => "保存用户发布问答",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","askId":"8"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败，isHad表示已经存在的记录）
										<br>askId是为保存后的问题记录id",
				"para" => array (
						array (
								"field" => "tid",
								"desc" => "问答栏目id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "tidname",
								"desc" => "问答栏目名称(不允许为空！！！必须urlencode处理！！！)"
						),
						array (
								"field" => "tid2",
								"desc" => "问答二级栏目id(默认：0)"
						),
						array (
								"field" => "tid2name",
								"desc" => "问答二级栏目名称(默认：空)"
						),
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "anonymous",
								"desc" => "是否匿名(默认：0，1是匿名，0是不匿名)"
						),
						array (
								"field" => "title",
								"desc" => "问答标题(不允许为空！！！必须urlencode处理！！！)"
						),
						array (
								"field" => "reward",
								"desc" => "悬赏分(默认：0)"
						),
						array (
								"field" => "expiredtime",
								"desc" => "到期时间(默认：当前时间+1天，格式：yyyy-mm-dd)"
						),
						array (
								"field" => "content",
								"desc" => "问答内容(不允许为空！！！必须urlencode处理！！！)"
						)						
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*保存用户发布问答数据 -end*/
		/*保存用户问答问题数据 -start*/
		$Method=	array (
				"serviceName" => "set_answer_save",
				"desc" => "保存用户问答问题",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","answerId":"8"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败，isHad表示已经存在的记录）
										<br>answerId是为保存后的回答记录id",
				"para" => array (
						array (
								"field" => "askid",
								"desc" => "问题id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "content",
								"desc" => "问答内容(不允许为空！！！必须urlencode处理！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*保存用户问答问题数据 -end*/
		/*保存用户收藏文章数据 -start*/
		$Method=	array (
				"serviceName" => "set_article_fav",
				"desc" => "保存用户收藏文章",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","favId":"8"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败，isHad表示该用户已收藏）
										<br>favId是为保存后的收藏记录id",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "aid",
								"desc" => "文章id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*保存用户收藏文章数据 -end*/
		/*取消用户收藏文章数据 -start*/
		$Method=	array (
				"serviceName" => "set_article_fav_cancle",
				"desc" => "取消用户收藏文章数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败）",
				"para" => array (
						array (
								"field" => "id",
								"desc" => "收藏记录id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*取消用户收藏文章数据 -end*/
		/*获取用户收藏列表数据 -start*/
		$Method=	array (
				"serviceName" => "get_user_fav_list",
				"desc" => "获取用户收藏列表",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为问答列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_member_stow\">dede_member_stow字段</a>",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(默认：0，所有用户)"
						),
						array (
								"field" => "page",
								"desc" => "当前页码(默认：1)"
						),
						array (
								"field" => "pagesize",
								"desc" => "分页数量(默认：10)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取用户收藏列表数据 -end*/
		/*用户登录操作 -start*/
		$Method=	array (
				"serviceName" => "op_user_login",
				"desc" => "用户登录操作",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","userData":{…}}})',
				"result" => "<br>result是为保存结果（success表示登录成功，empty表示用户名密码不允许为空，error表示密码错误，notExitis表示用户不存在）
										<br>userData是登录成功后返回的用户数据，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_member\">dede_member字段</a>",
				"para" => array (
						array (
								"field" => "uname",
								"desc" => "用户名(不允许为空！！！可以是用户名，用户id，用户手机或用户email)"
						),
						array (
								"field" => "pwd",
								"desc" => "密码(不允许为空！！！必须是md5 32位加密后的值！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*用户登录操作 -end*/
		/*用户第三方登录操作 -start*/
		$Method=	array (
				"serviceName" => "op_user_third_party_login",
				"desc" => "用户第三方登录操作",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","userData":{…}}})',
				"result" => "<br>result是为保存结果（success表示登录成功，failed表示登录失败）
				<br>userData是登录成功后返回的用户数据，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_member\">dede_member字段</a>",
				"para" => array (
						array (
								"field" => "openid",
								"desc" => "第三方应用返回的openid(不允许为空！！！)"
						),
						array (
								"field" => "gender",
								"desc" => "第三方应用返回性别(默认：男，【男，女，保密】，必须urlencode处理！！！)"
						),
						array (
								"field" => "face",
								"desc" => "第三方应用返回用户头像(默认：空)"
						),
						array (
								"field" => "nickname",
								"desc" => "第三方应用返回用户昵称(默认：未定义)"
						),
						array (
								"field" => "logintype",
								"desc" => "第三方应用登录方式(默认：qq，【qq，weixin】不允许为空！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*用户第三方登录操作 -end*/


        /*忘记密码判断操作 -start*/
        $Method=	array (
            "serviceName" => "inspect_user",
            "desc" => "忘记密码判断操作",
            "method" => 'GET',
            "result" => "<br>result是为保存结果（success数据对比成功，failed表示用户名不存在，isNo手机号码不正确）",
            "para" => array (
                array (
                    "field" => "tel",
                    "desc" => "用户手机号(不允许为空！！！必须是13位长度数字！！！)"
                ),
                array (
                    "field" => "uname",
                    "desc" => "用户名"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*忘记密码判断操作 -end*/

        /*忘记密码判断操作 -start*/
        $Method=	array (
            "serviceName" => "set_new_password",
            "desc" => "忘记密码找回密码",
            "method" => 'GET',
            "result" => "<br>msg是为保存结果（success修改成功，noHad表示用户名不存在，PwdEqually新密码不能跟旧密码相同）",
            "para" => array (
                array (
                     "field" => "uname",
                    "desc" => "用户名"
                ),
                array (
                    "field" => "tel",
                    "desc" => "用户手机号(不允许为空！！！必须是13位长度数字！！！)"
                ),
                array(
                    "field" => "pwd",
                    "desc" => "需要修改的密码"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*忘记密码判断操作 -end*/


        /*用户修改密码操作 -start*/
        $Method=	array (
            "serviceName" => "change_user_pwd",
            "desc" => "用户修改密码操作",
            "method" => 'GET',
            "result" => "<br>msg是为保存结果（success修改成功，no表示旧密码不正确，failed数据出错）",
            "para" => array (
                array (
                    "field" => "mid",
                    "desc" => "用户id"
                ),
                array (
                    "field" => "oldPwd",
                    "desc" => "用户旧密码"
                ),
                array(
                    "field" => "newPwd",
                    "desc" => "用户现在需要修改的密码"
                )
            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);

        /*用户修改密码操作 -end*/


		/*用户注册操作 -start*/
		$Method=	array (
				"serviceName" => "op_user_register",
				"desc" => "用户注册操作",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","shouji":"13xxxxxxxxx"}})',
				"result" => "<br>result是为保存结果（success表示注册成功，failed表示注册失败，isHad表示该用户已存在，error说明传入参数不符合规则）
										<br>shouji是为注册成功后的用户手机号",
				"para" => array (
						array (
								"field" => "shouji",
								"desc" => "用户手机号(不允许为空！！！必须是13位长度数字！！！)"
						),
						array (
								"field" => "pwd",
								"desc" => "用户密码(不允许为空！！！必须是md5加密后的密码！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*用户注册操作 -end*/

        /*获取图片验证码 -start*/
        $Method=	array (
            "serviceName" => "get_img_code",
            "desc" => "获取图片验证码",
            "method" => 'GET',
            "format" => 'callbackName({"msg":"success","code":"2000","data":{"word":"验证码（xxxx）","imgUrl":"验证码图片地址"}})',
            "para" => array (

            )
        );
        array_push($this->webserviceArr["webserviceMethod"], $Method);
        /*获取手机验证码 -end*/


		/*获取手机验证码 -start*/
		$Method=	array (
				"serviceName" => "get_mobile_code",
				"desc" => "通过手机号获取用户详细信息",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","mobile_code":"xxxxxx","mobile_result":"xxxx","mobile_result_code":"xxxx"}})',
				"result" => "<br>result是为保存结果（success表示注册成功，failed表示注册失败）
							<br>mobile_code是自动生成的6位随机验证码，用以本地校验用户输入的验证码
							<br>mobile_result是远程服务器反馈的信息
							<br>mobile_result_code远程服务器反馈的编码",
				"para" => array (
						array (
								"field" => "shouji",
								"desc" => "用户手机号(不允许为空！！！必须是13位长度数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取手机验证码 -end*/


		/*通过手机号获取用户详细信息 -start*/
		$Method=	array (
				"serviceName" => "get_user_detail_by_shouji",
				"desc" => "通过手机号获取用户详细信息",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{……}})',
				"result" => "<br>参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_member\">dede_member字段</a>和参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_member_person\">dede_member_person字段</a>",
				"para" => array (
						array (
								"field" => "shouji",
								"desc" => "用户手机号(不允许为空！！！必须是13位长度数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*通过手机号获取用户详细信息 -end*/
		/*通过mid获取用户详细信息 -start*/
		$Method=	array (
				"serviceName" => "get_user_detail_by_mid",
				"desc" => "通过mid获取用户详细信息",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{……}})',
				"result" => "<br>参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_member\">dede_member字段</a>和参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_member_person\">dede_member_person字段</a>",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id号(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*通过mid获取用户详细信息 -end*/
		/*保存用户数据 -start*/
		$Method=	array (
				"serviceName" => "set_user_detail_save",
				"desc" => "保存用户数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败，emailHad表示email已有存在记录，shoujiHad表示shouji已有存在记录，emailHadAndShoujiHad表示email和shouji均重复，invalidUser表示mid不合法）",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "uname",
								"desc" => "用户昵称(不修改的情况下，赋值0，请urlencode处理)"
						),
						array (
								"field" => "sex",
								"desc" => "用户性别(女0，男1，保密2，不修改的情况下，赋值3)"
						),
						array (
								"field" => "qq",
								"desc" => "用户qq(不修改的情况下，赋值0)"
						),
						array (
								"field" => "email",
								"desc" => "用户email(不修改的情况下，赋值0)"
						),
						array (
								"field" => "shouji",
								"desc" => "用户手机号(不修改的情况下，赋值0)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*保存用户数据 -end*/
		/*保存文章的用户评论数据 -start*/
		$Method=	array (
				"serviceName" => "set_article_feedback_save",
				"desc" => "保存文章的用户评论数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败，isHad表示该用户已经存在同样的评论，msgEmpty表示留言内容为空）
										<br>feedbackid是为保存后的评论记录id",
				"para" => array (
						array (
								"field" => "aid",
								"desc" => "文章id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "isanonymous",
								"desc" => "是否匿名(0表示匿名，1表示不匿名，默认0)"
						),
						array (
								"field" => "goodbad",
								"desc" => "评价(0表示顶，1表示踩，2表示中立，默认0)"
						),
						array (
								"field" => "msg",
								"desc" => "评论内容(不允许为空！！！必须urlencode处理！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*保存文章的用户评论数据 -end*/
		/*获取文章评论列表数据 -start*/
		$Method=	array (
				"serviceName" => "get_article_feedback_list",
				"desc" => "获取文章评论列表数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{…}})',
				"result" => "<br>参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_feedback\">dede_feedback字段</a>",
				"para" => array (
						array (
								"field" => "aid",
								"desc" => "文章id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取文章评论列表数据 -end*/
		/*获取用户评论列表数据 -start*/
		$Method=	array (
				"serviceName" => "get_user_feedback_list",
				"desc" => "获取用户评论列表数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{…}})',
				"result" => "<br>参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_feedback\">dede_feedback字段</a>",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取用户评论列表数据 -end*/
		/*获取评论详细数据 -start*/
		$Method=	array (
				"serviceName" => "get_feedback_details",
				"desc" => "获取评论详细数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{…}})',
				"result" => "<br>参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_feedback\">dede_feedback字段</a>",
				"para" => array (
						array (
								"field" => "id",
								"desc" => "评论记录id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取评论详细数据 -end*/
		/*预留图片上传接口 -start*/
		$Method=	array (
				"serviceName" => "set_upload_img",
				"desc" => "图片上传接口（暂时支持单一图片上传）",
				"method" => 'POST',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{…}})',
				"result" => " 如果上传成功，data内result为success，image字段会有上传成功后的图片访问地址，",
				"para" => array (
						array (
								"field" => "filefields",
								"desc" => "设定为隐藏域，就是你要传图片编码控件的fields值<br>
								身份证号，请将value设置为sfzhimg<br>
								资质证书，请将value设置为zzzsimg<br>
								学历证书，请将value设置为xlzsimg<br>
								头像，请将value设置为face<br>"
						),
						array (
								"field" => "sfzhimg|zzzsimg|xlzsimg|face",
								"desc" => "这是input控件的value值<br>
								身份证号，请将value设置为sfzhimg<br>
								资质证书，请将value设置为zzzsimg<br>
								学历证书，请将value设置为xlzsimg<br>
								头像，请将设置为face<br>对该控件赋值图片的base64编码<br>"
						),
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*预留图片上传接口 -end*/
		/*获取课程列表数据 -start*/
		$Method=	array (
				"serviceName" => "get_lessons_list",
				"desc" => "获取课程列表",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为文章列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a>",
				"para" => array (
						array (
								"field" => "page",
								"desc" => "当前页码(默认：1)"
						),
						array (
								"field" => "pagesize",
								"desc" => "分页数量(默认：10)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取课程列表数据 -end*/
		/*获取课程内容数据 -start*/
		$Method=	array (
				"serviceName" => "get_lessons_contents",
				"desc" => "获取课程内容",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为文章内容字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_archives\">dede_archives字段</a>",
				"para" => array (
						array (
								"field" => "id",
								"desc" => "课程记录id(默认：id降序，第一条数据)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取课程详情数据 -end*/
		/*保存用户收藏课程数据 -start*/
		$Method=	array (
				"serviceName" => "set_lessons_fav",
				"desc" => "保存用户收藏课程",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","favId":"8"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败，isHad表示该用户已收藏）
										<br>favId是为保存后的收藏记录id",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "id",
								"desc" => "课程id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*保存用户收藏课程数据 -end*/
		/*取消用户收藏课程数据 -start*/
		$Method=	array (
				"serviceName" => "set_lessons_fav_cancle",
				"desc" => "取消用户收藏课程数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败）",
				"para" => array (
						array (
								"field" => "id",
								"desc" => "收藏记录id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*取消用户收藏课程数据 -end*/
		/*获取用户收藏课程列表数据 -start*/
		$Method=	array (
				"serviceName" => "get_user_fav_lessons_list",
				"desc" => "获取用户收藏课程列表",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为问答列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_member_stow\">dede_member_stow字段</a>",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(默认：0，所有用户)"
						),
						array (
								"field" => "page",
								"desc" => "当前页码(默认：1)"
						),
						array (
								"field" => "pagesize",
								"desc" => "分页数量(默认：10)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取用户收藏课程列表数据 -end*/
		/*保存咨询师认证数据 -start*/
		$Method=	array (
				"serviceName" => "set_zxs_info_save",
				"desc" => "保存咨询师认证数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败，isHad表示已经是咨询师或者已经是待审咨询师，invalidUser表示用户id非法）",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "xm",
								"desc" => "姓名(不允许为空！！！必须urlencode处理！！！)"
						),
						array (
								"field" => "sfzh",
								"desc" => "身份证(不允许为空！！！18位数字！！！)"
						),
						array (
								"field" => "lxfs",
								"desc" => "联系方式(不允许为空！！！11位手机号！！！)"
						),
						array (
								"field" => "dq",
								"desc" => "所在地区(不允许为空！！！必须urlencode处理！！！)"
						),
						array (
								"field" => "zwjs",
								"desc" => "自我介绍(不允许为空！！！必须urlencode处理！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*保存咨询师认证数据 -end*/
		/*获取咨询师认证状态 -start*/
		$Method=	array (
				"serviceName" => "get_zxs_status",
				"desc" => "获取咨询师认证状态",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败，invalidUser表示用户id不合法，uncheck未审核&未认证，checking审核中，checked已审核）",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "咨询师用户id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取咨询师认证状态 -end*/
		/*获取当前地区咨询师列表数据 -start*/
		$Method=	array (
				"serviceName" => "get_zxs_list_local",
				"desc" => "获取当前地区咨询师列表数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为用户列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_member\">dede_member字段</a>",
				"para" => array (
						array (
								"field" => "page",
								"desc" => "当前页码(默认：1)"
						),
						array (
								"field" => "pagesize",
								"desc" => "分页数量(默认：10)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取当前地区咨询师列表数据 -end*/
		/*获取推荐咨询师列表数据 -start*/
		$Method=	array (
				"serviceName" => "get_zxs_list_recommand",
				"desc" => "获取推荐咨询师列表数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为用户列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_member\">dede_member字段</a>",
				"para" => array (
						array (
								"field" => "page",
								"desc" => "当前页码(默认：1)"
						),
						array (
								"field" => "pagesize",
								"desc" => "分页数量(默认：10)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取推荐咨询师列表数据 -end*/
		/*获取咨询师列表数据 -start*/
		$Method=	array (
				"serviceName" => "get_zxs_list",
				"desc" => "获取咨询师列表数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为用户列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_member\">dede_member字段</a>",
				"para" => array (
						array (
								"field" => "page",
								"desc" => "当前页码(默认：1)"
						),
						array (
								"field" => "pagesize",
								"desc" => "分页数量(默认：10)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取咨询师列表数据 -end*/
		/*获取咨询师详细数据 -start*/
		$Method=	array (
				"serviceName" => "get_zxs_details",
				"desc" => "获取咨询师详细数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"base":{},"rz":{}}})',
				"result" => "data内为用户列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_member\">dede_member字段</a><br>
				base是基础信息字段，rz是认证信息字段（老的认证咨询师用户这个字段可能为null）",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "咨询师的用户id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取咨询师详细数据 -end*/
		/*保存关注咨询师数据 -start*/
		$Method=	array (
				"serviceName" => "set_zxs_follow_save",
				"desc" => "保存关注咨询师数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success"})',
				"result" => "result是为保存结果（success表示保存成功，failed表示保存失败，paraError表示用户id或zxsid错误，isFollow表示已经该咨询师已关注，invalidUser表示用户id非法或咨询师id非法）",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "zxsid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*保存关注咨询师数据 -end*/
		/*获取用户关注的咨询师列表详细数据 -start*/
		$Method=	array (
				"serviceName" => "get_zxs_follow_list",
				"desc" => "获取用户关注的咨询师列表详细数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{})',
				"result" => "data内为用户列表字段信息，参考<a target=\"blank\" href=\"{$dedecmsDsUrl}#dede_member\">dede_member字段</a>",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取用户关注的咨询师列表详细数据 -end*/
		/*给咨询师点赞操作 -start*/
		$Method=	array (
				"serviceName" => "set_zxs_isgood",
				"desc" => "给咨询师点赞操作",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","goodpost":"5"}})',
				"result" => "<br>result是为操作结果（success表示操作成功，failed表示操作失败）
										<br>goodpost是为操作后的赞数，操作失败的情况下是-1",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "咨询师id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*给咨询师点赞操作 -end*/
		/*保存预约咨询师数据 -start*/
		$Method=	array (
				"serviceName" => "set_zxs_appointment_save",
				"desc" => "保存预约咨询师数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","appointmentid":xxxx})',
				"result" => "result是为保存结果（success表示保存成功，failed表示保存失败，isHad表示该问题已经向该咨询师预约，invalidUser表示用户id非法或咨询师id非法）<br>
				appointmentid是新增的预约记录的id",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "zxsid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "nickname",
								"desc" => "称呼(默认：匿名！！！必须urlencode处理！！！)"
						),
						array (
								"field" => "age",
								"desc" => "年龄(默认：0，必须是数字！！！)"
						),
						array (
								"field" => "gender",
								"desc" => "性别(默认：保密，可以为：男|女|保密！！！必须urlencode处理！！！)"
						),array (
								"field" => "phone",
								"desc" => "联系方式(默认：0，必须是数字！！！)"
						),
						array (
								"field" => "content",
								"desc" => "预约咨询描述(不允许为空！！！必须urlencode处理！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*保存预约咨询师数据 -end*/
		/*获取用户预约数据列表 -start*/
		$Method=	array (
				"serviceName" => "get_zxs_appointment_list",
				"desc" => "获取用户预约数据列表",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{…})',
				"result" => "",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*保存预约咨询师数据 -end*/
		
		/*取消用户对咨询师的预约 -start*/
		$Method=	array (
				"serviceName" => "set_zxs_appointment_cancle",
				"desc" => "取消用户对咨询师的预约",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败）",
				"para" => array (
						array (
								"field" => "id",
								"desc" => "预约记录id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*取消用户对咨询师的预约 -end*/
		
		/*取消用户对咨询师的关注 -start*/
		$Method=	array (
				"serviceName" => "set_zxs_follow_cancle",
				"desc" => "取消用户对咨询师的关注",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败）",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "zxsid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*取消用户对咨询师的关注 -end*/
		/*获取测评试卷列表数据 -start*/
		$Method=	array (
				"serviceName" => "get_papers_list",
				"desc" => "获取测评试卷列表",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为文章列表字段信息，papercode试卷编码，papername试卷名称，adduer试卷添加人，addtime添加时间",
				"para" => array (
						array (
								"field" => "page",
								"desc" => "当前页码(默认：1)"
						),
						array (
								"field" => "pagesize",
								"desc" => "分页数量(默认：10)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取测评试卷列表数据 -end*/
		/*获取测评试卷内容数据 -start*/
		$Method=	array (
				"serviceName" => "get_paper_contents",
				"desc" => "获取测评试卷内容",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为文章列表字段信息<br />
							paperInfo：papercode试卷编码，papername试卷名称，adduer试卷添加人，addtime添加时间<br/>
							dimension：dimensioncode维度编码，papercode试卷编码，items维度试题，scorematrix维度对应试题的评分矩阵<br/>
							testItems：testcode试题编码，papercode试卷编码，testname试题名称，testitem[a-f]试题[a-f]选项，testdesc试题说明",
				"para" => array (
						array (
								"field" => "papercode",
								"desc" => "试题编码（不允许为空！！！）"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取测评试卷内容数据 -end*/
		/*获取用户测评结果 -start*/
		$Method=	array (
				"serviceName" => "get_paper_result_by_mid",
				"desc" => "获取用户测评结果",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{}})',
				"result" => "data内为问答列表字段信息：",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "用户id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*获取用户测评结果 -end*/
		/*保存用户测评数据 -start*/
		$Method=	array (
				"serviceName" => "set_paper_result_save",
				"desc" => "保存用户测评数据",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","prId":"8"}})',
				"result" => "<br>result是为保存结果（success表示保存成功，failed表示保存失败，isHad表示已经存在的记录）
										<br>prId是为保存后的测评记录id",
				"para" => array (
						array (
								"field" => "mid",
								"desc" => "测评用户id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "papercode",
								"desc" => "试题编码（不允许为空！！！）"
						),
						array (
								"field" => "resultmatrix",
								"desc" => "测评结果矩阵(不允许为空！！！)"
						),
						array (
								"field" => "score",
								"desc" => "测评结果评分(不允许为空！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*保存用户测评数据 -end*/
		/*给课程点赞操作 -start*/
		$Method=	array (
				"serviceName" => "set_lessons_isgood",
				"desc" => "给课程点赞操作",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","goodpost":"5"}})',
				"result" => "<br>result是为操作结果（success表示操作成功，failed表示操作失败）
										<br>goodpost是为操作后的赞数，操作失败的情况下是-1",
				"para" => array (
						array (
								"field" => "id",
								"desc" => "课程id(不允许为空！！！必须是数字！！！)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*给课程点赞操作 -end*/
		/*支付宝支付接口 -start*/
		$Method=	array (
				"serviceName" => "alipay",
				"desc" => "支付宝支付接口",
				"method" => 'GET',
				"format" => 'callbackName({"msg":"success","code":"2000","data":{"result":"success","oid":"2016xxxxxxxx","url":"xxxxxxxx"}})',
				"result" => "<br>result是为操作结果（success表示操作成功，failed表示操作失败）
							<br>oid是为返回的订单号
							<br>url是生成自动跳转的支付地址",
				"para" => array (
						array (
								"field" => "id",
								"desc" => "课程id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "mid",
								"desc" => "购买用户的id(不允许为空！！！必须是数字！！！)"
						),
						array (
								"field" => "price",
								"desc" => "价格(不允许为空！！！必须是数字！！！可以是浮点型数字！！！)"
						),
						array(
								"field" => "cartcount",
								"desc" => "购买数量(不允许为空！！！必须是数字！！！默认1)"
						)
				)
		);
		array_push($this->webserviceArr["webserviceMethod"], $Method);
		/*支付宝支付接口 -end*/
		$data = array (
				"dataType" => $this->webserviceArr ["dataType"],
				"format" => $this->webserviceArr ["format"],
				"desc" => $this->webserviceArr ["desc"],
				"webservice" => $this->webserviceArr ["webserviceMethod"]
		);
		$this->load->view ( 'webservices_descripton', $data );
	}
}
