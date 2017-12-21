<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
require_once('sms/restdemo-php/lib/Ucpaas.class.php');
class Webservices extends CI_Controller {
	private $resultJSON;
	private $result_code;
	private $result_msg;
	private $result_data = array ();
	private $callback;
	private $pageSize = 10;
	private $page = 1;
	private $saveFilePath;
	private $saveFileinnerPath;
	private $saveFileName;
	private $sourceURL;
	private $baseServer;
	private $remoteFilePath;
	public function __construct() {
		parent::__construct ();
		$this->db = $this->load->database ( "default", TRUE );
		$this->callback = $this->input->get ( "callback" );
		header ( "content-type:text/html;charset=utf-8" );
        header("Access-Control-Allow-Origin: *");
//        $this->baseServer="http://192.168.1.103:8082";
//        $this->baseServer="http://192.168.1.105:8082";
        $this->baseServer= 'http://'.$_SERVER['SERVER_NAME'];
//        $this->baseServer="http://192.168.1.111:8082";
		$this->sourceURL = $this->baseServer."/Dedecms/";
        //$this->saveFilePath = "../uploads/appup/";
		$this->saveFilePath = "../uploads/appup/";
//		$this->saveFileinnerPath = "/Dedecms/uploads/uploads/appup/";
        $this->saveFileinnerPath = "/uploads/appup/";
		$this->remoteFilePath = $this->sourceURL . "uploads/uploads/appup/";
		$this->saveFileName = date ( "YmdHis" ) . mt_rand ( 100000, 999999 );
		$config ['upload_path'] = $this->saveFilePath;
		$config ['allowed_types'] = 'gif|jpg|jpeg|png';
		$config ['file_name'] = $this->saveFileName;
		$config ['max_size'] = '0';
		$config ['max_width'] = '0';
		$config ['max_height'] = '0';
		
		$this->load->library ( 'upload', $config );
	}
	public function index() {
		header ( "Location:" . base_url () );
	}
	public function urlencodeHandler() {
		$str = $this->input->get ( "str" );
		echo urlencode ( $str );
	}
	public function urldecodeHandler() {
		$str = $this->input->get ( "str" );
		echo urldecode ( $str );
	}
	private function __outmsg($isJSON = false) {
		if (sizeof ( $this->result_data ) == 0) {
			$this->result_code = "4001";
			$this->result_msg = "data empty";
		} else {
			$this->result_code = "2000";
			$this->result_msg = "success";
		}
		$this->resultJSON = array (
				"msg" => $this->result_msg,
				"code" => $this->result_code,
				"data" => $this->result_data 
		);
		if ($isJSON) {
			$str = json_encode ( $this->resultJSON );
		} else {
			$str = $this->callback . "(" . json_encode ( $this->resultJSON ) . ")";
		}
		echo $str;
	}
	private function __getMemberData($where,$thirdFlag=false) {
		$this->load->model ( "member_model" );
		if($thirdFlag){
			$this->db->select("*");
			$this->db->from("dede_member");
			$this->db->where('qqopenid', $where);
			$this->db->or_where('weixinopenid', $where); 
			$reData=$this->db->get()->row_array();
		}
		else{
			$reData = $this->member_model->row ( $where );
		}
		return $reData;
	}


	private function __getAskCategoryData($where) {
		$this->load->model ( "ask_category_model" );
		$reData = $this->ask_category_model->row ( $where );
		return $reData;
	}
	private function __getAskData($where) {
		$this->load->model ( "ask_model" );
		$reData = $this->ask_model->row ( $where );
		return $reData;
	}
	private function __getAnswerData($where) {
		$this->load->model ( "ask_answer_model" );
		$reData = $this->ask_answer_model->row ( $where );
		return $reData;
	}
	private function __getArticleData($where) {
		$this->load->model ( "article_model" );
		$reData = $this->article_model->row ( $where );
		return $reData;
	}
	private function __getUserArticleFavData($where) {
		$this->load->model ( "member_fav_article_model" );
		$reData = $this->member_fav_article_model->row ( $where );
		return $reData;
	}

	private function __getUserDynamicData($where){
	    $this->load->model("article_model");
        $reData = $this->article_model->row($where);
        return $reData;
    }
	private function __getUserAppointmentData($where) {
		$this->load->model ( "zxs_appointment_model" );
		$reData = $this->zxs_appointment_model->row ( $where );
		return $reData;
	}
	private function __getUserFollowData($where) {
		$this->load->model ( "zxs_model" );
		$reData = $this->zxs_model->row ( $where );
		return $reData;
	}
	private function __getPaperData($where) {
		$this->load->model ( "paper_info_model" );
		$reData = $this->paper_info_model->row ( $where );
		return $reData;
	}
	private function __getPaperResultData($where) {
		$this->load->model ( "paper_result_model" );
		$reData = $this->paper_result_model->row ( $where );
		return $reData;
	}
	public function get_article_focus_list() {
		$catrgotyId = filterValue ( $this->input->get ( "typeid" ), 0 );
		$page = filterValue ( $this->input->get ( "page" ), $this->page );
		$pageSize = filterValue ( $this->input->get ( "pagesize" ), $this->pageSize );
		$orderBy = "a.id@desc";
		$this->load->model ( "article_model" );
		$Data = $this->article_model->get_article_focus_list ( $catrgotyId, $page, $pageSize, $orderBy );
		$this->result_data = handlerImgUrl ( $Data, "litpic", "more" );
		$this->__outmsg ();
	}
//    private function __outmsg($isJSON = false) {
//        if (sizeof ( $this->result_data ) == 0) {
//            $this->result_code = "4001";
//            $this->result_msg = "data empty";
//        } else {
//            $this->result_code = "2000";
//            $this->result_msg = "success";
//        }
//        $this->resultJSON = array (
//            "msg" => $this->result_msg,
//            "code" => $this->result_code,
//            "data" => $this->result_data
//        );
//        if ($isJSON) {
//            $str = json_encode ( $this->resultJSON );
//        } else {
//            $str = $this->callback . "(" . json_encode ( $this->resultJSON ) . ")";
//        }
//        echo $str;
//    }
	public function get_article_list() {
		$catrgotyId = filterValue ( $this->input->get ( "typeid" ), 0 );
		$page = filterValue ( $this->input->get ( "page" ), $this->page );
		$pageSize = filterValue ( $this->input->get ( "pagesize" ), $this->pageSize );
		$orderBy = "a.id@desc";
		$this->load->model ( "article_model" );
		$Data = $this->article_model->get_article_list ( $catrgotyId, $page, $pageSize, $orderBy );
		$this->result_data = handlerImgUrl ( $Data, "litpic", "more" );
		$this->__outmsg ();
	}
    //测试
    public function get_article_img(){
        $this->load->model("article_model");
        $Data = $this->article_model->get_article_img();
        $Data["body"] = filterHTMLCode($Data["body"],$this->sourceURL);
        $this->result_data = ImgUrl($Data,"imgurls","more");
        $this->__outmsg ();
    }

    public function get_img_article(){
        $catrgotyId = filterValue( $this->input->get("typeid"),2);
        $page = filterValue($this->input->get("page"),$this->page);
        $pageSize = filterValue($this->input->get("pagesize"),$this->pageSize);
        $orderBy = "a.id@desc";
        $this->load->model("article_model");
        $Data = $this->article_model->get_img_article($catrgotyId,$page,$pageSize,$orderBy);
//        echo sizeof($Data)."<br/>";
        //只有数据大于2条的时候才会添加广告并且只有获取页面typeid为2时才会添加广告
        if(sizeof($Data) >=2 ){
            if ($catrgotyId == 2 ){
                $data =  $this->article_model->get_advertisement(14);
                $data1 = array_rand($data);
                $data_last[] = $data[$data1];
                array_splice($Data,2,0,$data_last);
            }
        }
//        $this->result_data = ImgUrla($Data,"imgurls","more");

        $this->result_data = ImgUrla($Data,"imgurls","more");
        $this->__outmsg ();
    }

    public function get_img_article_content(){
        $id = filterValue($this->input->get("id"),6);
        $whereArr = ($id == 0)?array() :array("a.id" => $id);
        $this->load->model("article_model");
        $Data = $this->article_model->get_img_article_content($whereArr);
        $Data["body"] = filterHTMLCode($Data["body"],$this->sourceURL);
        $this->result_data = $Data;
        $this->__outmsg();
    }

    //测试获取广告列表
    public function get_advertisement(){
        $typeid = filterValue( $this->input->get("typeid"),14);
        $this->load->model("article_model");
        $data = $this->article_model->get_advertisement1($typeid);
        $this->result_data = $data;
        $this->__outmsg();
    }

	public function get_article_contents() {
		$id = filterValue ( $this->input->get ( "id" ), 0 );
		$whereArr = ($id == 0) ? array () : array (
				"a.id" => $id 
		);
		$this->load->model ( "article_model" );
		$Data = $this->article_model->get_article_contents ( $whereArr );
		$Data ["body"] = filterHTMLCode ( $Data ["body"],$this->sourceURL );
		$this->result_data = handlerImgUrl ( $Data, "litpic", "1" );
		$this->__outmsg ();
	}

	public function set_article_click(){
        $id = filterValue ( $this->input->get ( "id" ), 0, true );
        $msg = "failed";
        $click = "-1";
        if($id != 0){
            $whereArr = array(
                "id" => $id
            );
            $field = "click";
            $this->load->model("article_model");
            $affected_rows = $this->article_model->update($field,$whereArr);
            if($affected_rows > 0){
                $msg = "success";
                $re = $this->article_model->row($whereArr);
                $click = $re["click"];
            }
        }
        $this->result_data = array(
            "result" => $msg,
            "click" => $click
        );
        $this->__outmsg();
    }

    //创建文件夹
    public function test(){
        $path = '../uploads/appup/'.date("ymd");
        if (!file_exists($path)){
            mkdir ($path);
            echo '创建文件夹test成功';
        }else {
            echo '需创建的文件夹test已经存在';
        }
        $this->result_data = 1;
        $this->__outmsg();
    }


    public function upload_img(){
        $img = $this->input->get("name");
        $this->result_data = $img;
        $this->__outmsg();
    }

    public function upload_video(){
        $file1 = $this->input->post("file1");
        $msg = "faile";
        $file = $_FILES['file'];
        //重命名
        $size = $file["size"];
        $path = "http://" . $_SERVER ["SERVER_NAME"].":8082";
//        if($file['type']!='video/mp4'&& $file['type']!='video/ogg'){
//            $msg = "no";
//        }
        if($file["size"] > 5000000){
            $msg = "tooBig";
        }
        $newname=time().rand(1,1000).substr($file['name'],strrpos($file['name'],'.'));
        $pack='../uploads/video/'.$newname;
        if(is_uploaded_file($_FILES["file"]["tmp_name"])){
            $msg="success";
        }
        if(move_uploaded_file($_FILES["file"]["tmp_name"],$pack)){
            $msg="success";
        }
        $this->result_data = array(
            "file" => $file,
            "pack" => $pack,
            "msg" => $msg,
            "file1" => $file1
        );
       $this->__outmsg();
    }


    public function set_release_img(){
//        $upFileFields = $this->input->post ( "filefields" );
        $name = ["name"];
        $baseImgCode = $this->input->post ( "img" );
        $mid = $this->input->post ( "mid" );
        $msg = $this->input->post("msg");
        $uname = $this->input->post("uname");
        $result = "failed";
        $imgurls = "";
        $image = "";
        $error = "no data upload";
        //时间戳来命名
        $fileName = $this->saveFileName;
        $filePath = $this->saveFilePath .date("ymd")."/". $fileName;

        if (! empty ( $baseImgCode )) {
            //$img  = preg_match ( '/^(data:\s*image\/(\w+);base64,)/', $baseImgCode, $result );
            //除  data:image/jpeg;base64, 之外
            for($i=0;$i<sizeof($baseImgCode);$i++){
                if (preg_match ( '/^(data:\s*image\/(\w+);base64,)/', $baseImgCode[$i], $result )) {
                    $type = $result [2]; //jpge格式
                    $new_file = $filePath .$i . "." . $type;
                    //$fileName = $fileName . "." . $type;
                    // 例如： 20161219120134999700  .jpeg  把一个字符串写入文件中。
                    //判断图片目录里面有没有该当天上传日期的文件夹，如果没有就创建该文件夹，有的话就不创建 直接插入图片
                    if(!file_exists($this->saveFilePath.date("ymd"))){
                        mkdir($this->saveFilePath.date("ymd"));
                    }
                    if (file_put_contents ( $new_file, base64_decode ( str_replace ( $result [1], '', $baseImgCode[$i]) ) )) {
//                        $image = $this->remoteFilePath . $fileName;
                        $imageInnerUrl = $this->saveFileinnerPath .date("ymd")."/". $fileName.$i.".".$type;
                    }

                }
                    $imgurls .= $imageInnerUrl .",";

            }
            /*for($i = 0; $i < sizeof($baseImgCode);$i++){
                 if (preg_match ( '/^(data:\s*image\/(\w+);base64,)/', $baseImgCode[$i], $result )) {
                     $type = $result [2]; //jpge格式
                     $new_file = $filePath . "." . $type;
                     $fileName = $fileName . "." . $type;
                     // 例如： 20161219120134999700  .jpeg  把一个字符串写入文件中。
                     if (file_put_contents ( $new_file, base64_decode ( str_replace ( $result [1], '', $baseImgCode[$i] ) ) )) {

                         $image = $this->remoteFilePath . $fileName;
                         $imageInnerUrl = $this->saveFileinnerPath . $fileName;
                         //  /Dedecms/uploads/uploads/appup/ 20161219121150703264.jpeg
                         //this->__handlerUpRelImg ( $imageInnerUrl, $mid );
                     }
                 }
                 $flag = "success";
             }*/
        }
        $this->load->model ( "release_model" );
        $result1 = $this->release_model->set_release_img($mid,$msg,$uname,$imgurls);
        if($result1 == true){
            $result = "success";
        }
        $reDataArr = array (
            "result" => $result,
            "res" => $result1
        );
        $this->result_data = $reDataArr;
        $this->__outmsg ();
    }

    public function get_release_list(){
        $catrgotyId = filterValue($this->input->get("typeid"),10);
        $page = filterValue($this->input->get("page"),$this->page);
        $pageSize = filterValue($this->input->get("pageSize"),$this->pageSize);
        $orderBy = "a.id@desc";
        $this->load->model("release_model");
        $Data = $this->release_model->get_release_list($catrgotyId,$page,$pageSize,$orderBy);
        $Data = releaseImg($Data,"face");
        $this->result_data = releaseImg($Data,"imgurls");
        //$this->result_data = $Data;
        $this->__outmsg();
    }

    public function get_release_con() {
        $aid = filterValue($this->input->get("aid"),230);
        $this->load->model("release_model");
        $Data = $this->release_model->get_release_con($aid);
        $Data = handlerImgUrl($Data,"face");
        $this->result_data = ImgUrl($Data,"imgurls");
        $this->__outmsg();
    }
    /*public function get_release_list1(){
        $catrgotyId = filterValue($this->input->get("typeid"),10);
        $page = filterValue($this->input->get("page"),$this->page);
        $pageSize = filterValue($this->input->get("pageSize"),$this->pageSize);
        $orderBy = "a.id@desc";
        $this->load->model("release_model");
        $Data = $this->release_model->get_release_list1($catrgotyId,$page,$pageSize,$orderBy);
        $Data["imgurls"] =
        $this->result_data = $Data;
        $this->__outmsg();
    }*/

    public function get_shop_subClass(){
        $catrgotyId = filterValue($this->input->get("typeid"),3);
        $this->load->model("shop_model");
        $result =$this->shop_model->get_shop_subClass($catrgotyId);
        $this->result_data =array(
            "result" => $result
        );
        $this->__outmsg();
    }

    public function get_shop_subClass_list(){
        $catrgotyId = $this->input->get("typeid");
        $page = $this->input->get("page");
        $pageSize = $this->input->get("pagesize");
        $orderby = "a.id@desc";
        $this->load->model("shop_model");
        $resiltData = $this->shop_model->get_shop_subClass_list($catrgotyId,$page,$pageSize,$orderby);
        $this->result_data = handlerImgUrl ( $resiltData, "litpic", "more" );
        $this->__outmsg();
    }

    public function get_shop_list(){
        $catrgotyId = filterValue($this->input->get("typeid"),3);
        $page = filterValue($this->input->get("page"),$this->page);
        $pageSize = filterValue($this->input->get("pagesize"),$this->pageSize);
        $orderby = "a.id@desc";
        $this->load->model("shop_model");
        $Data = $this->shop_model->get_shop_list($catrgotyId,$page,$pageSize,$orderby);
        $this->result_data = handlerImgUrl ( $Data, "litpic", "more" );
        $this->__outmsg();
    }


    public function get_car_about(){
        $catrgotyId = $this->input->get("id");
        $this->load->model("shop_model");
        $resultData = $this->shop_model->get_car_about($catrgotyId);
        $this->result_data = handlerImgUrl ( $resultData, "litpic", "1" );
        $this->__outmsg();
    }

    public function get_shop_detail(){
        $shopid = $this->input->get("shopid");
        $this->load->model("shop_model");
        $resultData = $this->shop_model->get_shop_detail($shopid);
        $this->result_data = handlerImgUrl ( $resultData, "litpic", "1" );
        $this->__outmsg();
    }

    public function get_shop_about(){
        $aid = filterValue($this->input->get("aid"),12);
        $this->load->model("shop_model");
        $Data = $this->shop_model->get_shop_about($aid);
        $Data["body"] = filterHTMLCode($Data["body"],$this->sourceURL );
        $this->result_data = $Data;
        $this->__outmsg();
    }

    public function select_for_keywords(){
        $msg = "failed";
        $keywords = $this->input->get("keywords");
        $this->load->model("shop_model");
        $data = $this->shop_model->select_for_keywords($keywords);
        $this->result_data = $data;
        $this->__outmsg();
    }

    public function set_user_search_keywords(){
        $keywords = $this->input->get("keywords");
        $typeid = $this->input->get("typeid");
        $this->load->model("shop_model");
        $data = $this->shop_model->set_user_search_keywords($keywords,$typeid);
        $this->result_data = array(
            "msg" => $data
        );
        $this->__outmsg();
    }

    public function get_hot_search_keywords(){
        $typeid = $this->input->get("typeid");
        $this->load->model("shop_model");
        $data = $this->shop_model->get_hot_search_keywords($typeid);
        $this->result_data = $data;
        $this->__outmsg();
    }




	public function get_article_category() {
		$catrgotyId = filterValue ( $this->input->get ( "id" ), 0 );
		$this->load->model ( "article_category_model" );
		$Data = $this->article_category_model->get_category_list ( $catrgotyId );
		$filterCategoryArr=array(3,4,5);//array(2,3,4,5,6,14,15,16,17);
		if($catrgotyId==0){
			foreach ($Data as $k => $v){
				if(in_array( $v["id"],$filterCategoryArr)){
					unset($Data[$k]);
				}
        }
        }
        sort($Data,true);
        $this->result_data=$Data;
        $this->__outmsg ();
	}
	public function set_article_isgood() {
		$id = filterValue ( $this->input->get ( "id" ), 0, true );
		$msg = "failed";
		$goodpost = "-1";
		if ($id != 0) {
			$whereArr = array (
					"id" => $id 
			);
			$field = "goodpost";
			$this->load->model ( "article_model" );
			$affected_rows = $this->article_model->update ( $field, $whereArr );
			if ($affected_rows > 0) {
				$msg = "success";
				$re = $this->article_model->row ( $whereArr );
				$goodpost = $re ["goodpost"];
			}
		}
		$this->result_data = array (
				"result" => $msg,
				"goodpost" => $goodpost 
		);
		$this->__outmsg ();
	}
	public function get_article_list_by_keywords() {
		$catrgotyId = filterValue ( $this->input->get ( "typeid" ), 0 );
		$keywords = filterValue ( $this->input->get ( "keywords" ), "" );
		$page = filterValue ( $this->input->get ( "page" ), $this->page );
		$pageSize = filterValue ( $this->input->get ( "pagesize" ), $this->pageSize );
		$orderBy = "a.id@desc";
		$this->load->model ( "article_model" );
		$Data = $this->article_model->get_article_list_by_keywords ( $catrgotyId, $page, $pageSize, $orderBy ,$keywords);
		$this->result_data = handlerImgUrl ( $Data, "litpic", "more" );
		$this->__outmsg ();
	}
	public function get_ask_list_by_keywords() {
		$catrgotyId = filterValue ( $this->input->get ( "tid" ), 0 );
		$keywords = filterValue ( $this->input->get ( "keywords" ), "" );
		$where = ($catrgotyId == 0) ? array () : array (
				"a.tid" => $catrgotyId
		);
		$page = filterValue ( $this->input->get ( "page" ), $this->page );
		$pageSize = filterValue ( $this->input->get ( "pagesize" ), $this->pageSize );
		$orderBy = "a.disorder@desc,a.dateline@desc";
		$this->load->model ( "ask_model" );
		$this->result_data = $this->ask_model->get_ask_list ( $where, $page, $pageSize, $orderBy,true ,"search",$keywords);
		$this->__outmsg ();
	}
	public function get_ask_category() {
		$catrgotyId = filterValue ( $this->input->get ( "id" ), 0 );
		$this->load->model ( "ask_category_model" );
		$this->result_data = $this->ask_category_model->get_category_list ( $catrgotyId );
		$this->__outmsg ();
	}

	public function get_ask_list() {
		$catrgotyId = filterValue ( $this->input->get ( "tid" ), 0 );
		$where = ($catrgotyId == 0) ? array () : array (
				"a.tid" => $catrgotyId
		);
		$page = filterValue ( $this->input->get ( "page" ), $this->page );
		$pageSize = filterValue ( $this->input->get ( "pagesize" ), $this->pageSize );
		$orderBy = "a.disorder@desc,a.dateline@desc";
		$this->load->model ( "ask_model" );
		$this->result_data = $this->ask_model->get_ask_list ( $where, $page, $pageSize, $orderBy,true );
		$this->__outmsg ();
	}

    public function  get_user_dynamic_list(){
        $mid = filterValue ( $this->input->get ( "mid" ), 1);
        $page = filterValue ( $this->input->get ( "page" ), $this->page );
        $pageSize = filterValue ( $this->input->get ( "pagesize" ), $this->pageSize );
        $this->load->model("member_fav_article_model");
        $Data =  $this->member_fav_article_model->get_user_dynamic_list($mid,$page,$pageSize);
        $Data = releaseImg($Data,"face");
        $this->result_data = releaseImg($Data,"imgurls");
        $this->__outmsg();
    }

    public function delete_user_dynamic(){
        $id = $this->input->get("id");
        $msg = "faild";
        $whereData = array(
            "id" => $id
        );
        $result = $this->__getUserDynamicData($whereData);
        if(sizeof($result) != 0){
            $this->load->model("member_fav_article_model");
            $msg1 = $this->member_fav_article_model->unlinkImg($id);
            $this->load->model("article_model");
            $affectedRows = $this->article_model->delete($whereData);
            $affectedRow1s = $this->member_fav_article_model->deleteImage($id);
            if($affectedRows > 0 && $affectedRow1s > 0){
                $msg = "success";
            }
        }

        $this->result_data = array(
            "msg" => $msg,
            "msg1" => $msg1
        );
        $this->__outmsg();
    }

    function deleteImg(){
//        201703092040158344510.jpeg
//        /Dedecms/uploads/uploads/appup/201703092040158344510.jpeg
        //../uploads/appup/201703092040158344510.jpeg
        $msg = "faild";
         $str = "../uploads/appup/201703092040161675480.jpeg";
        $str = "/Dedecms/uploads/uploads/appup/201703111723132972430.jpeg,/Dedecms/uploads/uploads/appup/201703110802477201610.jpeg,";
//        unlink(" ../uploads/appup/201703092040158344510.jpeg");
        $str = unlinkImg($str);
//        $len = sizeof($str);
        foreach ($str as $v){
//            unlink($v);
            if(file_exists($v)){

            unlink($v);
                $msg = "success";

            }else{
                $msg = "bad";
            }
        }
//        if(file_exists($str)){
//
////            unlink($str);
//            $msg = "success";
//
//        }else{
//            $msg = "bad";
//        }
        $this->result_data = array(
            "msg" => $msg,
            "str" =>$str
//            "len" => $len
        );
        $this->__outmsg();
    }
	public function get_ask_list_by_status() {
		$status = filterValue ( $this->input->get ( "status" ), 0 );
		$mid = filterValue ( $this->input->get ( "mid" ), 0 );
		if ($mid == 0) {
			$where = array (
					"a.status" => $status 
			);
		} else {
			$where = array (
					"a.status" => $status,
					"a.uid" => $mid 
			);
		}
		$page = filterValue ( $this->input->get ( "page" ), $this->page );
		$pageSize = filterValue ( $this->input->get ( "pagesize" ), $this->pageSize );
		$orderBy = "a.disorder@desc,a.dateline@desc";
		$this->load->model ( "ask_model" );
		$this->result_data = $this->ask_model->get_ask_list ( $where, $page, $pageSize, $orderBy );
		$this->__outmsg ();
	}
	public function get_ask_details() {
		$id = filterValue ( $this->input->get ( "id" ), 0, true );
		if ($id != 0) {
			$this->load->model ( "ask_model" );
			$this->load->model ( "ask_answer_model" );
			$answerData = $this->ask_answer_model->get_ask_answer_list ( $id );
			$affectedRows = $this->ask_model->replies_add ( $id, sizeof ( $answerData ), true );
			$askData = $this->ask_model->get_ask_details ( $id );
			$this->result_data = array (
					"askData" => $askData,
					"answerData" => $answerData 
			);
		}
		$this->__outmsg ();
	}
	public function get_answered_ask_list_by_mid() {
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$page = filterValue ( $this->input->get ( "page" ), $this->page );
		$pageSize = filterValue ( $this->input->get ( "pagesize" ), $this->pageSize );
		if ($mid != 0) {
			$this->load->model ( "ask_answer_model" );
			$page = ($page - 1) * $pageSize;
			$answerData = $this->ask_answer_model->get_ask_list_by_mid ( $mid, $page, $pageSize );
			$this->result_data = $answerData;
		}
		$this->__outmsg ();
	}
	public function set_ask_status() {
		$id = filterValue ( $this->input->get ( "id" ), 0, true );
		$status = filterValue ( $this->input->get ( "status" ), 0, true );
		$msg = "failed";
		if ($id != 0) {
			$this->load->model ( "ask_model" );
			$dataArr = array (
					"status" => $status 
			);
			$where = array (
					"id" => $id 
			);
			$affected_rows = $this->ask_model->update ( $dataArr, $where );
			if ($affected_rows > 0) {
				$msg = "success";
			}
		}
		$this->result_data = array (
				"result" => $msg 
		);
		$this->__outmsg ();
	}
	public function set_ask_save() {
		$insertData = array ();
		$checkHadData = array ();
		$tid = filterValue ( $this->input->get ( "tid" ), 0, true );
		$insertData ["tid"] = $tid;
		$checkHadData ["tid"] = $tid;
		$tidname = handlerChineseStr ( $this->input->get ( "tidname" ) );
		$insertData ["tidname"] = $tidname;
		$tid2 = filterValue ( $this->input->get ( "tid2" ), 0, true );
		$insertData ["tid2"] = $tid2;
		$tid2name = handlerChineseStr ( $this->input->get ( "tid2name" ) );
		$insertData ["tid2name"] = $tid2name;
		$uid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$insertData ["uid"] = $uid;
		$checkHadData ["uid"] = $uid;
		$anonymous = filterValue ( $this->input->get ( "anonymous" ), 0, true );
		$insertData ["anonymous"] = $anonymous;
		$title = handlerChineseStr ( $this->input->get ( "title" ) );
		$insertData ["title"] = $title;
		$checkHadData ["title"] = $title;
		$digest = 0;
		$insertData ["digest"] = $digest;
		$reward = filterValue ( $this->input->get ( "reward" ), 0, true );
		$insertData ["reward"] = $reward;
		$dateline = time ();
		$insertData ["dateline"] = $dateline;
		$expiredtime = strtotime ( filterValue ( $this->input->get ( "expiredtime" ), '+1 day' ) );
		$insertData ["expiredtime"] = $expiredtime;
		$solvetime = 0;
		$bestanswer = 0;
		$status = 0;
		$disorder = 0;
		$views = 0;
		$replies = 0;
		$insertData ["solvetime"] = $solvetime;
		$insertData ["bestanswer"] = $bestanswer;
		$insertData ["status"] = $status;
		$insertData ["disorder"] = $disorder;
		$insertData ["views"] = $views;
		$insertData ["replies"] = $replies;
		$ip = getIP ();
		$insertData ["ip"] = $ip;
		$content = handlerChineseStr ( $this->input->get ( "content" ) );
		$insertData ["content"] = $content;
		$lastanswer = 0;
		$insertData ["lastanswer"] = $lastanswer;
		
		$msg = "failed";
		$askId = "-1";
		$askCategoryData = $this->__getAskCategoryData ( array (
				"id" => $tid 
		) );
		$memberData = $this->__getMemberData ( array (
				"mid" => $uid 
		) );
		if (sizeof ( $askCategoryData ) != 0 && sizeof ( $memberData ) != 0) {
			
			$askData = $this->__getAskData ( $checkHadData );
			if (sizeof ( $askData ) != 0) {
				$msg = "isHad";
			} else {
				$this->load->model ( "ask_model" );
				$insertID = $this->ask_model->insert ( $insertData );
				if ($insertID > 0) {
					$msg = "success";
					$askId = $insertID;
				}
			}
		}
		$this->result_data = array (
				"result" => $msg,
				"askId" => $askId 
		);
		$this->__outmsg ();
	}
	public function set_answer_save() {
		$insertData = array ();
		$checkHadData = array ();
		$askid = filterValue ( $this->input->get ( "askid" ), 0, true );
		$insertData ["askid"] = $askid;
		$checkHadData ["askid"] = $askid;
		$ifanswer = 0;
		$insertData ["ifanswer"] = $ifanswer;
		$askname = "";
		$insertData ["askname"] = $askname;
		
		$uid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$insertData ["uid"] = $uid;
		$checkHadData ["uid"] = $uid;
		// username到模型数据获取
		$anonymous = filterValue ( $this->input->get ( "anonymous" ), 0, true );
		$insertData ["anonymous"] = $anonymous;
		$goodrate = 0;
		$badrate = 0;
		$insertData ["goodrate"] = $goodrate;
		$insertData ["badrate"] = $badrate;
		$userip = getIP ();
		$insertData ["userip"] = $userip;
		$dateline = time ();
		$insertData ["dateline"] = $dateline;
		$content = handlerChineseStr ( $this->input->get ( "content" ) );
		$insertData ["content"] = $content;
		$checkHadData ["content"] = $content;
		$ifcheck = 1;
		$insertData ["ifcheck"] = $ifcheck;
		
		$msg = "failed";
		$answerId = "-1";
		
		$askData = $this->__getAskData ( array (
				"id" => $askid 
		) );
		$memberData = $this->__getMemberData ( array (
				"mid" => $uid 
		) );
		if (sizeof ( $askData ) != 0 && sizeof ( $memberData ) != 0) {
			
			$answerData = $this->__getAnswerData ( $checkHadData );
			if (sizeof ( $answerData ) != 0) {
				$msg = "isHad";
			} else {
				
				$username = filterValue ( $memberData ["uname"], "" );
				$insertData ["username"] = $username;
				
				$tid = filterValue ( $askData ["tid"], 0, true );
				$insertData ["tid"] = $tid;
				$tid2 = filterValue ( $askData ["tid2"], 0, true );
				$insertData ["tid2"] = $tid2;
				
				$this->load->model ( "ask_answer_model" );
				$this->load->model ( "ask_model" );
				$affectedRows = $this->ask_model->replies_add ( $askid );
				$insertID = $this->ask_answer_model->insert ( $insertData );
				if ($insertID > 0 && $affectedRows > 0) {
					$msg = "success";
					$answerId = $insertID;
				}
			}
		}
		$this->result_data = array (
				"result" => $msg,
				"answerId" => $answerId 
		);
		$this->__outmsg ();
	}
	public function set_article_fav() {
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$checkHadData ["mid"] = $mid;
		$aid = filterValue ( $this->input->get ( "aid" ), 0, true );
		$checkHadData ["aid"] = $aid;
		$msg = "failed";
		$favId = "-1";
		$articleData = $this->__getArticleData ( array (
				"id" => $aid 
		) );
		$memberData = $this->__getMemberData ( array (
				"mid" => $mid 
		) );
		if (sizeof ( $articleData ) != 0 && sizeof ( $memberData ) != 0) {
			
			$favData = $this->__getUserArticleFavData ( $checkHadData );
			if (sizeof ( $favData ) != 0) {
				$msg = "isHad";
			} else {
			
				$this->load->model ( "member_fav_article_model" );
				$insertData = array (
						"mid" => $mid,
						"aid" => $aid,
						"title" => $articleData ["title"],
						"addtime" => time () 
				);
				$insertID = $this->member_fav_article_model->insert ( $insertData );
				if ($insertID > 0) {
					$msg = "success";
					$favId = $insertID;
				}
			}
		}
		$this->result_data = array (
				"result" => $msg,
                "insertID" =>$memberData,
				"favId" => $favId 
		);
		$this->__outmsg ();
	}
	public function set_article_fav_cancle() {
		$id = filterValue ( $this->input->get ( "id" ), 0, true );
		$msg = "failed";
		$whereData = array (
				"id" => $id 
		);
		$articleData = $this->__getUserArticleFavData ( $whereData );
		if (sizeof ( $articleData ) != 0) {
			$this->load->model ( "member_fav_article_model" );
			$affectedRows = $this->member_fav_article_model->delete ( $whereData );
			if ($affectedRows > 0) {
				$msg = "success";
			}
		}
		$this->result_data = array (
				"result" => $msg 
		);
		$this->__outmsg ();
	}
	public function get_user_fav_list() {
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$page = filterValue ( $this->input->get ( "page" ), $this->page );
		$pageSize = filterValue ( $this->input->get ( "pagesize" ), $this->pageSize );
		$this->load->model ( "member_fav_article_model" );
		$where = ($mid == 0) ? array () : array (
				"a.mid" => $mid 
		);
		$orderBy = "a.addtime@desc";
		$Data = $this->member_fav_article_model->get_fav_article_list ( $where, $page, $pageSize, $orderBy );
		$this->result_data = ImgUrla($Data,"imgurls","more");
		$this->__outmsg ();
	}
	public function op_user_third_party_login(){
		$msg = "failed";
		$openid=filterValue ( $this->input->get ( "openid" ),"0");
		$gender=handlerChineseStr( $this->input->get ( "gender" ),"男");
		$face=filterValue( $this->input->get ( "face" ),"");
		$nickname=handlerChineseStr ( $this->input->get ( "nickname" ),"未定义");
		$loginType=filterValue ( $this->input->get ( "logintype" ),"qq");//qq，weixin
        //取出第2到8位值
		$userid = substr($openid,2,8);

		$uname = $nickname;

		$where_check=$openid;
        //什么类型的第三方openid
		$where=array(
				$loginType."openid"=>$openid
		);

		//$memberInfo=$this->__getMemberData($where_check,true);
		$memberInfo=$this->__getMemberData($where);

		if((sizeof($memberInfo)== 0|| $memberInfo==NULL ) && $openid!="0"){
			$insertData = array ();
			$shouji = "";
			$insertData ["userid"] = $userid;
			$insertData[$loginType."openid"] = $openid;
			$insertData ["uname"] = $uname;
			$insertData ["shouji"] = $shouji;
			$mtype = "个人";
			$insertData ["mtype"] = $mtype;
			$pwd = "";
			$insertData ["pwd"] = $pwd;
			$sex = $gender;
			$insertData ["sex"] = $sex;
			$rank = 10;
			$insertData ["rank"] = $rank;
			$uptime = 0;
			$insertData ["uptime"] = $uptime;
			$exptime = 0;
			$insertData ["exptime"] = $exptime;
			$money = 0;
			$insertData ["money"] = $money;
			$email = "";
			$insertData ["email"] = $email;
			$scores = 100;
			$insertData ["scores"] = $scores;
			$matt = 0;
			$insertData ["matt"] = $matt;
			$spacesta = 2;
			$insertData ["spacesta"] = $spacesta;
			$insertData ["face"] = $face;
			$safequestion = 0;
			$insertData ["safequestion"] = $safequestion;
			$safeanswer = "0";
			$insertData ["safeanswer"] = $safeanswer;
			$jointime = time ();
			$insertData ["jointime"] = $jointime;
			$joinip = getIP ();
			$insertData ["joinip"] = $joinip;
			$logintime = time ();
			$insertData ["logintime"] = $logintime;
			$loginip = getIP ();
			$insertData ["loginip"] = $loginip;
			$qq = "";
			$insertData ["qq"] = $qq;
//			$lovemsg = "";
//			$insertData ["lovemsg"] = $lovemsg;
//			$myjie = "";
//			$insertData ["myjie"] = $myjie;
			$this->load->model ( "member_model" );
			$insertId = $this->member_model->add_user ( $insertData );
			if ($insertId > 0) {
				$reData=$insertData;
				$reData = handlerImgUrl ( $reData, "face" );
				unset ( $reData ["pwd"] );
				$userData = $reData;
				$userData["mid"]=$insertId;
				$msg = "success";
			}
		}
		else{
			$reData=$memberInfo;
			$reData["face"] = handlerImgUrl ( $reData["face"], "face" );
			unset ( $reData ["pwd"] );
			$userData = $reData;
			$msg = "success";
		}
		$this->result_data = array (
				"result" => $msg,
				"userData" => $userData
		);
		$this->__outmsg ();
	}
	
	public function op_user_login() {
		$uname = filterValue ( $this->input->get ( "uname" ), NULL );
		$pwd = filterValue ( $this->input->get ( "pwd" ), NULL );
		$msg = "empty";
		$userData = array ();
		if ($uname != NULL && $pwd != NULL) {
			$this->load->model ( "member_model" );
			$reData = $this->member_model->get_member_info ( $uname );
			if (sizeof ( $reData ) != 0) {
				// if($reData["pwd"]==md5($pwd)){
				if ($reData ["pwd"] == $pwd) {
					$reData = handlerImgUrl ( $reData, "face" );
					unset ( $reData ["pwd"] );
					$userData = $reData;
					$msg = "success";
				} else {
					$msg = "error";
				}
			} else {
				$msg = "notExitis";
			}
		}
		$this->result_data = array (
				"result" => $msg,
				"userData" => $userData 
		);
		$this->__outmsg ();
	}

	public function inspect_user(){
	    $uname = filterValue($this->input->get("uname"),"tab520");
        $tel = filterValue($this->input->get("tel"),"13698006448");
        $msg = "failed";
        $this->load->model("member_model");
        $memberResult = $this->member_model->get_member_info($uname);
        if(sizeof($memberResult) != 0){
            if($uname == $memberResult["uname"] && $tel == $memberResult["shouji"]){
                $msg = "success";
            }else if($uname == $memberResult["uname"] && $tel != $memberResult["shouji"]){
                $msg = "isNo";
            }
        }else{
            $msg = "failed";
        }
        $this->result_data = array(
            "msg" =>$msg,
            "result" => $memberResult["uname"],
            "tel" => $memberResult["shouji"]
        );
        $this->__outmsg();
    }

    public function set_new_password(){
        $uname = $this->input->get("uname");
        $pwd = $this->input->get("pwd");
        $msg = "failed";
        $this->load->model("member_model");
        $memberResult = $this->member_model->get_member_info($uname);
        if(sizeof($memberResult) == 0) {
            $msg = "noHad";
        }elseif (sizeof($memberResult) != 0){
            if($pwd == $memberResult["pwd"]){
                $msg = "PwdEqually";
            }else{
                $result = $this->member_model->update_user_pwd($memberResult["mid"],$pwd);
                if($result){
                    $msg = "success";
                }
            }
        }
        $this->result_data = array(
            "msg" => $msg
        );
        $this->__outmsg();
    }

    public function change_user_pwd(){
        $mid = $this->input->get("mid");
        $msg = "failed";
        $oldPwd = $this->input->get("oldPwd");
        $newPwd = $this->input->get("newPwd");
        $this->load->model("member_model");
        $oldData = $this->member_model->get_old_password($mid);
        if($oldData["pwd"] != $oldPwd){
            $msg = 'no';
        }else{
            $newData = $this->member_model->change_user_pwd($mid,$newPwd);
            if($newData){
                $msg = 'success';
            }else{
                $msg = "failed";
            }
        }
        $this->result_data = array(
            "msg" => $msg
        );
        $this->__outmsg();
    }


	public function op_user_register() {
		$insertData = array ();
		$checkHadData = array ();
		// 手机号检测，不等于-1
		$shouji = checkMobileNum ( $this->input->get ( "shouji" ) );
		$insertData ["userid"] = $shouji;
		$insertData ["uname"] = $shouji;
		$insertData ["shouji"] = $shouji;
		$checkHadData ["shouji"] = $shouji;
		$checkHadData ["userid"] = $shouji;
		$checkHadData ["uname"] = $shouji;
		$mtype = "个人";
		$insertData ["mtype"] = $mtype;
		// md5加密后的密码，不等于-1
		$pwd = checkPwd ( $this->input->get ( "pwd" ) );
		$insertData ["pwd"] = $pwd;
		
		$sex = "";
		$insertData ["sex"] = $sex;
		$rank = 10;
		$insertData ["rank"] = $rank;
		$uptime = 0;
		$insertData ["uptime"] = $uptime;
		$exptime = 0;
		$insertData ["exptime"] = $exptime;
		$money = 0;
		$insertData ["money"] = $money;
		
		// email检测，不等于-1
		// $email=checkEmail($this->input->get("email"));
		$email = "";
		$insertData ["email"] = $email;
		$checkHadData ["email"] = $email;
		$scores = 100;
		$insertData ["scores"] = $scores;
		$matt = 0;
		$insertData ["matt"] = $matt;
		$spacesta = 2;
		$insertData ["spacesta"] = $spacesta;
		$face = "";
		$insertData ["face"] = $face;
		$safequestion = 0;
		$insertData ["safequestion"] = $safequestion;
		$safeanswer = "0";
		$insertData ["safeanswer"] = $safeanswer;
		$jointime = time ();
		$insertData ["jointime"] = $jointime;
		$joinip = getIP ();
		$insertData ["joinip"] = $joinip;
		$logintime = time ();
		$insertData ["logintime"] = $logintime;
		$loginip = getIP ();
		$insertData ["loginip"] = $loginip;

        //额外添加的
		/*$qq = "";
		$insertData ["qq"] = $qq;
		$lovemsg = "";
		$insertData ["lovemsg"] = $lovemsg;
		$myjie = "";
		$insertData ["myjie"] = $myjie;*/
		
		$msg = "failed";
		//$memberId = "-1";
		
		// if($shouji!=-1 && $pwd!=-1 && $email!=-1){
		if ($shouji != - 1 && $pwd != - 1) {
			$this->load->model ( "member_model" );
			$memberData = $this->member_model->get_member_info ( $shouji );
			if (sizeof ( $memberData ) == 0) {
				$insertId = $this->member_model->add_user ( $insertData );
				if ($insertId > 0) {
					//$memberId = $insertId;
					$msg = "success";
				}
			} else {
				$msg = "isHad";
			}
		} else {
			$msg = "error";
		}
		
		$this->result_data = array (
				"result" => $msg,
				"shouji" => $shouji 
		);
		$this->__outmsg ();
	}
	public function get_user_detail_by_shouji() {
		// 手机号检测，不等于-1
		$shouji = checkMobileNum ( $this->input->get ( "shouji" ) );
		if ($shouji != - 1) {
			$this->load->model ( "member_model" );
			$reData = $this->member_model->get_member_info ( $shouji );
			unset ( $reData ["pwd"] );
			$reData ["face"] = handlerImgUrl ( $reData ["face"] );
			$this->result_data = $reData;
		}
		$this->__outmsg ();
	}
	public function get_user_detail_by_mid() {
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		if ($mid != 0) {
			$this->load->model ( "member_model" );
			$reData = $this->member_model->get_member_info ( $mid, false );
			unset ( $reData ["pwd"] );
			$reData ["face"] = handlerImgUrl ( $reData ["face"] );
			$this->result_data = $reData;
		}
		$this->__outmsg ();
	}
	public function set_user_detail_save() {
		$updateData = array ();
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$where = array (
				"mid" => $mid 
		);

		$uname = filterValue ( $this->input->get ( "uname" ), "0" );
		if ($uname != "0") {
			$updateData ["uname"] = handlerChineseStr ( $uname );
		}

		$sexArr = array (
				"女",
				"男",
				"保密" 
		);

		$sex = filterValue ( ( int ) $this->input->get ( "sex" ), 3 );

		if ($sex < 3 && $sex >= 0) {
			$updateData ["sex"] = $sexArr [$sex];
		}

		$qq = filterValue ( $this->input->get ( "qq" ), "0" );
		if ($qq != "0") {
			$updateData ["qq"] = $qq;
		}

		$emailData = array ();
		$email = filterValue ( $this->input->get ( "email" ), "0" );
		if ($email != "0") {
			$updateData ["email"] = $email;
			$emailData = $this->__getMemberData ( array (
					"email" => $email
			) );
		}

		$shoujiData = array ();
		$shouji = checkMobileNum ( $this->input->get ( "shouji" ) );
		if ($shouji != - 1) {
			$updateData ["shouji"] = $shouji;
			$shoujiData = $this->__getMemberData ( array (
					"shouji" => $shouji 
			) );
		}

		$msg = "failed";
		if (sizeof ( $emailData ) != 0) {
			$msg = "emailHad";
		}

		if (sizeof ( $shoujiData ) != 0) {
			if ($msg != "failed") {
				$msg .= "AndShoujiHad";
			} else {
				$msg = "shoujiHad";
			}
		}

		if (sizeof ( $emailData ) == 0 && sizeof ( $shoujiData ) == 0) {
			$this->load->model ( "member_model" );
			$reData = $this->member_model->get_member_details ( $mid, false );
			if (sizeof ( $reData ) != 0) {
				$re = $this->member_model->update_user ( $updateData, $where );
				if ($re) {
					$msg = "success";
				}
			} else {
				$msg = "invalidUser";
			}
		}
		$this->result_data = array (
				"result" => $msg
		);
		$this->__outmsg ();
	}

	public function get_img_code(){
        $this->load->model("member_model");
        $data = $this->member_model->get_img_code();
//       $str = " http://192.168.0.101:8082/Dedecms/uploads/uploads/codeImg/1489806503.6558.jpg";
        $this->result_data = $data;
        $this->__outmsg();
    }

	public function get_mobile_code() {
		try {
        $options['accountsid']='504d056eca8627dac2a7f77649244aa6';
        $options['token']='226db99dab9b85dcd598062a00be2a43';
        $ucpass = new Ucpaas($options);
        $appId = "693ec3ae294646e79ee1453bcdc4dde1";
        $templateId = "13356";
        //验证码。
        $mobile_code = getRandomNum ( 4, 1 );
        //短信参数。
        //$param=$mobile_code;
        $param=$mobile_code.",2";
        //手机号
        $to = checkMobileNum ( $this->input->get ( "shouji" ) );
        //发送短信。

        $resultStr= $ucpass->templateSMS($appId,$to,$templateId,$param);
       //默认值为：$resultStr= {"resp":{"respCode":"000000","templateSMS":{"createDate":"20161026175440","smsId":"a81403178c3a0c58375488f2d8c8fc21"}}}
        //$result=json_decode($resultStr);


        //将下列数据保存到数据库。1.手机号码，2短信创建时间3短信发送码4，发送的验证码。
        /*$smsSendTime=$result->resp->templateSMS->createDate;//创建时间。
        $smsID=$result->resp->templateSMS->smsId;//短信编码。服务端编码。*/
        $resultCode=$resultStr->resp->respCode;
        $msg = "failed";
        $mobileResult = "";
        $mobileResultCode = "";
        if($resultCode=="000000")//成功。
        {
            $msg = "success";
        }else{//获取短信失败。
           $mobileResultCode = "100015";
           $mobileResult = "错误";
           $mobile_code = "-1";
        }
        //添加获取验证码的记录到数据库里面以便于资金的计算
            /*   $this->load->model ( "member_model" );

              $insertArr = array(
                   "tel"=>$to,
                   "code"=>$mobile_code,
                   "sendTime"=>"$smsSendTime",
                   "smsID"=>"$smsID"
               );
               $this->member_model->add_code($insertArr);*/
		$this->result_data = array (
				"result" => $msg,
				"mobile_code" => $mobile_code,
				"mobile_result" => $mobileResult,
				"mobile_result_code" => $mobileResultCode 
		);
		$this->__outmsg ();

       } catch (Exception $e) {
         echo $e->getMessage();
         exit();
      }
	}
	public function set_article_feedback_save() {
		$aid = filterValue ( $this->input->get ( "aid" ), 0, true );
		$insertData ["aid"] = $aid;
		$checkHadData ["aid"] = $aid;
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$insertData ["mid"] = $mid;
		$checkHadData ["mid"] = $mid;
		$articleData = $this->__getArticleData ( array (
				"id" => $aid 
		) );
		$memberData = $this->__getMemberData ( array (
				"mid" => $mid 
		) );
		$msg = "failed";
		$feedbackId = "-1";
		if (sizeof ( $articleData ) != 0 && sizeof ( $memberData ) != 0) {
			$ip = getIP ();
			$insertData ["ip"] = $ip;
			//$isAnonymous = filterValue ( $this->input->get ( "isanonymous" ), "0" );
			//$insertData ["username"] = ($isAnonymous == "0") ? "匿名" : $memberData ["uname"];
            $insertData ["username"] = $memberData ["uname"];
			$insertData ["typeid"] = $articleData ["typeid"];
			$insertData ["arctitle"] = $articleData ["title"];
			$insertData ["ischeck"] = "1";
			$insertData ["dtime"] = time ();
			$goodbad = filterValue ( $this->input->get ( "goodbad" ), "0" );
			$insertData ["bad"] = "0";
			$insertData ["good"] = "0";
			$insertData ["ftype"] = "feedback";
			if ($goodbad == "0") {
				$insertData ["ftype"] = "good";
			}
			if ($goodbad == "1") {
				$insertData ["ftype"] = "bad";
			}
			$insertData ["face"] = "1";
			$msg = handlerChineseStr ( $this->input->get ( "msg" ) );
			if (empty ( $msg )) {
				$msg = "msgEmpty";
			} else {
				$insertData ["msg"] = $msg;
				$checkHadData ["msg"] = $msg;
				$this->load->model ( "feedback_model" );
				$checkData = $this->feedback_model->row ( $checkHadData );
				if (sizeof ( $checkData ) != 0) {
					$msg = "isHad";
				} else {
					$insertId = $this->feedback_model->insert ( $insertData );
					if ($insertId > 0) {
						$msg = "success";
						$feedbackId = $insertId;
					}
				}
			}
		}
		$this->result_data = array (
				"result" => $msg,
				"feedbackid" => $feedbackId 
		);
		$this->__outmsg ();
	}
	/*
	 * $id = filterValue ( $this->input->get ( "id" ), 0, true );
		$msg = "failed";
		$goodpost = "-1";
		if ($id != 0) {
			$whereArr = array (
					"id" => $id
			);
			$field = "goodpost";
			$this->load->model ( "article_model" );
			$affected_rows = $this->article_model->update ( $field, $whereArr );
			if ($affected_rows > 0) {
				$msg = "success";
				$re = $this->article_model->row ( $whereArr );
				$goodpost = $re ["goodpost"];
			}
		}
		$this->result_data = array (
				"result" => $msg,
				"goodpost" => $goodpost
		);
		$this->__outmsg ();
	 * */

    public function set_feedback_isgood(){
        $id = filterValue ( $this->input->get ( "id" ), 0, true );
        $msg = "failed";
        $good = "-1";
        if ($id != 0) {
            $whereArr = array (
                "id" => $id
            );
            $field = "good";
            $this->load->model ( "feedback_model" );
            $affected_rows = $this->feedback_model->update ( $field, $whereArr );
            if ($affected_rows > 0) {
                $msg = "success";

            }
        }
        $this->result_data = array (
            "result" => $msg
        );
        $this->__outmsg ();
    }

	public function updatecomment(){
	    $buyid = $this->input->get("buyid");
        $this->load->model("shop_model");
        $data = $this->shop_model->updatecomment($buyid);
        $this->result_data = array(
            "msg" => $buyid,
            "data" => $data
        );
        $this->__outmsg();
    }

	public function get_feedback_details() {
		$id = filterValue ( $this->input->get ( "id" ), 0, true );
		$this->load->model ( "feedback_model" );
		$reData = $this->feedback_model->row ( array (
				"id" => $id 
		) );
		$memberData = $this->__getMemberData ( array (
				"mid" => $reData ["mid"] 
		) );
		if (sizeof ( $reData ) != 0) {
			$reData ["face"] = handlerImgUrl ( $memberData ["face"] );
		}
		$this->result_data = $reData;
		$this->__outmsg ();
	}
	public function get_user_feedback_list() {
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$this->load->model ( "feedback_model" );
		$reData = $this->feedback_model->get_feedback_list ( array (
				"a.mid" => $mid
		) );
		$reData = handlerImgUrl ( $reData, "face", "more" );
		$this->result_data = $reData;
		$this->__outmsg ();
	}
	public function get_article_feedback_list() {
		$aid = filterValue ( $this->input->get ( "aid" ), 0, true );
		$this->load->model ( "feedback_model" );
		$reData = $this->feedback_model->get_feedback_list ( array (
				"a.aid" => $aid 
		) );
		$reData = handlerImgUrl ( $reData, "face", "more" );
		$this->result_data = $reData;
		$this->__outmsg ();
	}
	private function __handlerUpImg($imgurl, $type, $mid) {
		$this->load->model ( "member_model" );
		$where = array (
				"mid" => $mid 
		);
		$data = array (
				$type => $imgurl 
		);
		switch ($type) {
			case "sfzhimg" :
			case "zzzsimg" :
			case "xlzsimg" :
				$this->member_model->update_zxs ( $where, $data );
				break;
			case "face" :
				$this->member_model->update (  $data ,$where );
				break;
		}
	}



	
	// 预留图片上传接口
	public function set_upload_img() {
		$upFileFields = $this->input->post ( "filefields" );
		$baseImgCode = $this->input->post ( $upFileFields );
		$mid = $this->input->post ( "mid" );
		$flag = "failed";
		$data = array ();
		$image = "";
		$error = "no data upload";
        //时间戳来命名
		$fileName = $this->saveFileName;
		$filePath = $this->saveFilePath . $fileName;
		
		if (! empty ( $upFileFields ) && ! empty ( $baseImgCode )) {
			
			if (preg_match ( '/^(data:\s*image\/(\w+);base64,)/', $baseImgCode, $result )) {
				$type = $result [2];
				$new_file = $filePath . "." . $type;
				$fileName = $fileName . "." . $type;
                // 例如： 20161219120134999700  .jpeg  把一个字符串写入文件中。
				if (file_put_contents ( $new_file, base64_decode ( str_replace ( $result [1], '', $baseImgCode ) ) )) {
					$flag = "success";
					$image = $this->remoteFilePath . $fileName;
                    // http://192.168.1.122:8082/Dedecms/uploads/uploads/appup/2 0161219121150703264.jpeg
					$imageInnerUrl = $this->saveFileinnerPath . $fileName;
                    //  /Dedecms/uploads/uploads/appup/ 20161219121150703264.jpeg
					$this->__handlerUpImg ( $imageInnerUrl, $upFileFields, $mid );
				}
			}
		}
		$reDataArr = array (
				"result" => $flag,
				"error" => $error
		);
		$this->result_data = $reDataArr;
		$this->__outmsg ( true );
	}



    /*private function __handlerUpReImg($imgurl, $type, $mid) {
        $this->load->model ( "member_model" );
        $where = array (
            "mid" => $mid
        );
        $data = array (
            $type => $imgurl
        );
        switch ($type) {
            case "sfzhimg" :
            case "zzzsimg" :
            case "xlzsimg" :
                $this->member_model->update_zxs ( $where, $data );
                break;
            case "face" :
                $this->member_model->update (  $data ,$where );
                break;
        }
    }*/



	// 预留图片上传接口
	public function set_upload_img_bak() {
		$upFileFields = $this->input->post ( "filefields" );
		$mid = $this->input->post ( "mid" );
		$flag = "success";
		$data = array ();
		$error = "";
		if (! $this->upload->do_upload ( $upFileFields )) {
			$error = $this->upload->display_errors ();
			$flag = "failed";
		} else {
			$data = array (
					'upload_data' => $this->upload->data () 
			);
			$image = $this->remoteFilePath . $data ["upload_data"] ["file_name"];
			$imageInnerUrl = $this->saveFileinnerPath . $data ["upload_data"] ["file_name"];
			$this->__handlerUpImg ( $imageInnerUrl, $upFileFields, $mid );
		}
		if ($flag == "success") {
			$reDataArr = array (
					"save_result" => $flag,
					"data" => $image,
					"error" => $error 
			);
		} else {
			$reDataArr = array (
					"save_result" => $flag,
					"data" => $data,
					"error" => $error 
			);
		}
		$this->result_data = $reDataArr;
		$this->__outmsg ( $reDataArr );
	}
	
	// 课程开始
	public function get_lessons_list() {
		$catrgotyId = 4;
		$page = filterValue ( $this->input->get ( "page" ), $this->page );
		$pageSize = filterValue ( $this->input->get ( "pagesize" ), $this->pageSize );
		$orderBy = "a.id@desc";
		$this->load->model ( "article_model" );
		$Data = $this->article_model->get_lessons_list ( $catrgotyId, $page, $pageSize, $orderBy );
		$this->result_data = handlerImgUrl ( $Data, "litpic", "more" );
		$this->__outmsg ();
	}
	public function get_lessons_contents() {
		$id = filterValue ( $this->input->get ( "id" ), 0 );
		$whereArr = ($id == 0) ? array () : array (
				"a.id" => $id 
		);
		$this->load->model ( "article_model" );
		$Data = $this->article_model->get_lessons_contents ( $whereArr );
		$Data ["body"] = filterHTMLCode ( $Data ["body"],$this->sourceURL );
		$this->result_data = handlerImgUrl ( $Data, "litpic", "1" );
		
		$this->__outmsg ();
	}
	
	public function set_lessons_fav() {		
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$checkHadData ["mid"] = $mid;
		$aid = filterValue ( $this->input->get ( "id" ), 0, true );
		$checkHadData ["aid"] = $aid;
		
		$msg = "failed";
		$favId = "-1";
		$articleData = $this->__getArticleData ( array (
				"id" => $aid
		) );
		$memberData = $this->__getMemberData ( array (
				"mid" => $mid
		) );
		if (sizeof ( $articleData ) != 0 && sizeof ( $memberData ) != 0) {
			
			$favData = $this->__getUserArticleFavData ( $checkHadData );
			if (sizeof ( $favData ) != 0) {
				$msg = "isHad";
			} else {
				$this->load->model ( "member_fav_article_model" );
				$insertData = array (
						"mid" => $mid,
						"aid" => $aid,
						"title" => $articleData ["title"],
						"addtime" => time ()
				);
				$insertID = $this->member_fav_article_model->insert ( $insertData );
				if ($insertID > 0) {
					$msg = "success";
					$favId = $insertID;
				}
			}
		}
		$this->result_data = array (
				"result" => $msg,
				"favId" => $favId
		);
		$this->__outmsg ();
	}
	public function set_lessons_fav_cancle() {
		$id = filterValue ( $this->input->get ( "id" ), 0, true );
		$msg = "failed";
		$whereData = array (
				"id" => $id
		);
		$articleData = $this->__getUserArticleFavData ( $whereData );
		if (sizeof ( $articleData ) != 0) {
			$this->load->model ( "member_fav_article_model" );
			$affectedRows = $this->member_fav_article_model->delete ( $whereData );
			if ($affectedRows > 0) {
				$msg = "success";
			}
		}
		$this->result_data = array (
				"result" => $msg
		);
		$this->__outmsg ();
	}
	public function get_user_fav_lessons_list() {
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$page = filterValue ( $this->input->get ( "page" ), $this->page );
		$pageSize = filterValue ( $this->input->get ( "pagesize" ), $this->pageSize );
		$this->load->model ( "member_fav_article_model" );
		$where = ($mid == 0) ? array () : array (
				"a.mid" => $mid
		);
		$orderBy = "a.addtime@desc";
		$reData = $this->member_fav_article_model->get_fav_lessons_list ( $where, $page, $pageSize, $orderBy );
		$this->result_data = handlerImgUrl ( $reData, "litpic", "more" );
		$this->__outmsg ();
	}
	
	// 咨询师
	public function get_zxs_status(){
		$msg="failed";
		$mid = filterValue ( $this->input->get ( "mid" ), 0 );
		$memberInfo = $this->__getMemberData ( array (
				"mid" => $mid
		) );
		if (sizeof ( $memberInfo ) != 0) {
			if ($memberInfo ["mtype"] == "个人" ) {
				$msg = "uncheck";
			}
			if ($memberInfo ["mtype"] == "待审咨询师"){
				$msg = "checking";
			}
			if($memberInfo["mtype"]=="咨询师"){
				$msg="checked";
			}
		}
		else{
			$msg="invalidUser";
		}
		
		$this->result_data = array (
				"result" => $msg
		);
		$this->__outmsg ();
	}
	
	public function set_zxs_info_save() {
		$mid = filterValue ( $this->input->get ( "mid" ), 0 );
		$xm = filterValue ( $this->input->get ( "xm" ), 0 );
		$sfzh = filterValue ( $this->input->get ( "sfzh" ), 0 );
		$lxfs = filterValue ( $this->input->get ( "lxfs" ), 0 );
		$dq = filterValue ( $this->input->get ( "dq" ), 0 );
		$zwjs = filterValue ( $this->input->get ( "zwjs" ), 0 );
		
		$msg = "failed";
		
		$memberInfo = $this->__getMemberData ( array (
				"mid" => $mid 
		) );
		if (sizeof ( $memberInfo ) != 0) {
			if ($memberInfo ["mtype"] == "咨询师" || $memberInfo ["mtype"] == "待审咨询师") {
				$msg = "isHad";
			} else {
				$this->load->model ( "member_model" );
				$where = array (
						"mid" => $mid 
				);
				$zxsInfo = $this->member_model->check_zxs ( $where );
				if (sizeof ( $zxsInfo ) == 0) {
					$this->member_model->insert ( array (
							"mid" => $mid,
							"xm" => "",
							"sfzh" => "",
							"lxfs" => "",
							"dq" => "",
							"zwjs" => "",
							"sfzhimg" => "",
							"zzzsimg" => "",
							"xlzsimg" => "" 
					) );
				}
				$data = array ();
				if ($xm != 0) {
					$data ["xm"] = handlerChineseStr ( $xm );
				}
				if ($sfzh != 0) {
					$data ["sfzh"] = $sfzh;
				}
				if ($lxfs != 0) {
					$data ["lxfs"] = $lxfs;
				}
				if ($dq != 0) {
					$data ["dq"] = handlerChineseStr ( $dq );
				}
				if ($zwjs != 0) {
					$data ["zwjs"] = handlerChineseStr ( $zwjs );
				}
				$rows = $this->member_model->update_zxs ( $where, $data );
				if ($rows > 0) {
					$msg = "success";
				}
			}
		} else {
			$msg = "invalidUser";
		}
		$this->result_data = array (
				"result" => $msg 
		);
		$this->__outmsg ();
	}
	public function get_zxs_list_local() {
		$this->get_zxs_list ( true );
	}
	public function get_zxs_list_recommand() {
		$this->get_zxs_list_local ();
	}
	public function get_zxs_list($randflag = false) {
		$this->load->model ( "member_model" );
		$where = array (
				"a.mtype" => "咨询师" 
		);
		$page = filterValue ( $this->input->get ( "page" ), $this->page );
		$pageSize = filterValue ( $this->input->get ( "pagesize" ), $this->pageSize );
		$data = $this->member_model->get_zxs_list ( $where, $page, $pageSize, $randflag );
		$data = handlerImgUrl ( $data,"face",2);
		$this->result_data = $data;
		$this->__outmsg ();
	}
	public function get_zxs_details() {
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		if ($mid != 0) {
			$this->load->model ( "member_model" );
			$reData = $this->member_model->get_zxs_details ( $mid );
			unset ( $reData ["base"] ["pwd"] );
			$reData ["base"] ["face"] = handlerImgUrl ( $reData ["base"] ["face"] );
			if (isset ( $reData ["sfzhimg"] )) {
				$reData ["sfzhimg"] = handlerImgUrl ( $reData ["sfzhimg"] );
			}
			if (isset ( $reData ["zzzsimg"] )) {
				$reData ["zzzsimg"] = handlerImgUrl ( $reData ["zzzsimg"] );
			}
			if (isset ( $reData ["xlzsimg"] )) {
				$reData ["xlzsimg"] = handlerImgUrl ( $reData ["xlzsimg"] );
			}
			$this->result_data = $reData;
		}
		$this->__outmsg ();
	}
	public function set_zxs_follow_save() {
		$msg = "failed";
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$zxsid = filterValue ( $this->input->get ( "zxsid" ), 0, true );
		$this->load->model ( "zxs_model" );
		if ($mid != 0 && $zxsid != 0) {
			$memberData = $this->__getMemberData ( array (
					"mid" => $mid 
			) );
			$zxsData = $this->__getMemberData ( array (
					"mid" => $zxsid,
					"mtype"=>"咨询师"
			) );
			if (sizeof ( $memberData ) != 0 && sizeof($zxsData) !=0) {
				$flag = $this->zxs_model->is_follow ( $mid, $zxsid );
				if ($flag) {
					$msg = "isFollow";
				} else {
					$insertArr = array (
							"mid" => $mid,
							"zxsid" => $zxsid,
							"addtime" => time () 
					);
					$insertid = $this->zxs_model->insert ( $insertArr );
					if ($insertid > 0) {
						$msg = "success";
					}
				}
			} else {
				$msg="invalidUser";
			}
		} else {
			$msg = "paraError";
		}
		$this->result_data = array (
				"result" => $msg 
		);
		$this->__outmsg ();
	}
	
	public function get_zxs_follow_list(){
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$reData=array();
		if($mid!=0){
			$this->load->model ( "zxs_model" );
			$reData=$this->zxs_model->get_follow_list($mid);
			foreach ($reData as $key=>$value){
				unset ( $reData[$key ]["pwd"] );
				$reData[$key ] ["face"]= handlerImgUrl ( $reData[$key ]["face"]);
			}
		}
		$this->result_data = $reData;
		$this->__outmsg ();
	}
	
	public function set_zxs_isgood() {
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$msg = "failed";
		$goodpost = "-1";
		if ($mid != 0) {
			$whereArr = array (
					"mid" => $mid
			);
			$field = "good";
			$this->load->model ( "member_person_model" );
			$this->member_person_model->checkHadPerson($mid);
			$affected_rows = $this->member_person_model->update ( $field, $whereArr );
			if ($affected_rows > 0) {
				$msg = "success";
				$re = $this->member_person_model->row ( $whereArr );
				$goodpost = $re ["good"];
			}
		}
		$this->result_data = array (
				"result" => $msg,
				"goodpost" => $goodpost
		);
		$this->__outmsg ();
	}
	// 咨询师预约
	public function set_zxs_appointment_save() {
		$msg = "failed";
		$insertId=-1;
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$insertData["mid"]=$mid;
		$checkHadData ["mid"] = $mid;
		$zxsid = filterValue ( $this->input->get ( "zxsid" ), 0, true );
		$insertData["zxsid"]=$zxsid;
		$checkHadData ["zxsid"] = $zxsid;
		$nickname = handlerChineseStr( $this->input->get ( "nickname" ));
		$nickname=(empty($nickname))?"匿名":$nickname;
		$insertData["nickname"]=$nickname;
		$age = filterValue ( $this->input->get ( "age" ), 0,true );
		$insertData["age"]=$age;
		$gender = handlerChineseStr( $this->input->get ( "gender" ));
		$gender=(empty($gender))?"保密":$gender;
		$insertData["gender"]=$gender;
		$phone = filterValue ( $this->input->get ( "phone" ), 0 );
		$insertData["phone"]=$phone;
		$content = handlerChineseStr ( $this->input->get ( "content" ));
		$insertData["content"]=$content;
		$checkHadData ["content"] = $content;
		$insertData["addtime"]=time();
		
		$memberInfo = $this->__getMemberData ( array (
				"mid" => $mid
		) );
		$zxsInfo = $this->__getMemberData ( array (
				"mid" => $zxsid
		) );
		if (sizeof ( $memberInfo ) != 0 && sizeof($zxsInfo) !=0) {
			$this->load->model("zxs_appointment_model");
			$appointmentData=$this->zxs_appointment_model->row($checkHadData);
			if (sizeof($appointmentData)!=0) {
				$msg = "isHad";
			} else {
				$insertId=$this->zxs_appointment_model->insert($insertData);
				if($insertId>0){
					$msg="success";
				}
			}
		} else {
			$msg = "invalidUser";
		}
		$this->result_data = array (
				"result" => $msg,
				"appointmentid"=>$insertId
		);
		$this->__outmsg ();
	}
	public function get_zxs_appointment_list() {
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		if($mid!=0){
			$this->load->model("zxs_appointment_model");
			$reData=$this->zxs_appointment_model->get_appointment_list_detail(array("a.mid"=>$mid));
			$reData = handlerImgUrl ( $reData,"face","more" );
			$this->result_data=$reData;
		}
		$this->__outmsg ();
	}
	
	public function set_zxs_appointment_cancle() {
		$id = filterValue ( $this->input->get ( "id" ), 0, true );
		$msg = "failed";
		$whereData = array (
				"id" => $id
		);
		$appointmentData = $this->__getUserAppointmentData ( $whereData );
		if (sizeof ( $appointmentData ) != 0) {
			$this->load->model ( "zxs_appointment_model" );
			$affectedRows = $this->zxs_appointment_model->delete ( $whereData );
			if ($affectedRows > 0) {
				$msg = "success";
			}
		}
		$this->result_data = array (
				"result" => $msg
		);
		$this->__outmsg ();
	}
	
	public function set_zxs_follow_cancle() {
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$zxsid = filterValue ( $this->input->get ( "zxsid" ), 0, true );
		$msg = "failed";
		$whereData = array (
				"mid" => $mid,
				"zxsid"=>$zxsid
		);
		$followData = $this->__getUserFollowData( $whereData );
		if (sizeof ( $followData ) != 0) {
			$this->load->model ( "zxs_model" );
			$affectedRows = $this->zxs_model->delete ( $whereData );
			if ($affectedRows > 0) {
				$msg = "success";
			}
		}
		$this->result_data = array (
				"result" => $msg
		);
		$this->__outmsg ();
	}

	public function get_papers_list(){
		$this->load->model ( "paper_info_model" );
		$where = array ();
		$page = filterValue ( $this->input->get ( "page" ), $this->page );
		$pageSize = filterValue ( $this->input->get ( "pagesize" ), $this->pageSize );
		$orderBy = "id@desc";
		$this->result_data=$this->paper_info_model->getPapersList($where,$page,$pageSize,$orderBy);
		$this->__outmsg ();
	}
	
	public function get_paper_contents(){
		$this->load->model ( "paper_info_model" );
		$papercode = filterValue ( $this->input->get ( "papercode" ),-1 );
		if($papercode!=-1){
			$where = array ("papercode"=>$papercode);
			$page = 1;
			$pageSize = 1;
			$orderBy = "id@desc";
			$paperInfo=$this->paper_info_model->getPapersList($where,$page,$pageSize,$orderBy);
			$paperContents=$this->paper_info_model->getPaperContents($where);
			$paperContents["paperInfo"]=$paperInfo;
			$this->result_data=$paperContents;
		}
		$this->__outmsg ();
	}
	
	public function get_paper_result_by_mid(){
		$this->load->model ( "paper_result_model" );
		$mid = filterValue ( $this->input->get ( "mid" ),-1 );
		if($mid!=-1){
			$where = array ("mid"=>$mid);
			$page = 1;
			$pageSize = 100;
			$orderBy = "id desc";
			$data=$this->paper_result_model->__getPaperTestResult($where,$page,$pageSize,$orderBy);
			$this->result_data=$data;
		}
		$this->__outmsg ();
	}
	
	public function set_paper_result_save() {
		$insertData = array ();
		$checkHadData = array ();
		$mid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$insertData ["mid"] = $mid;
		$checkHadData ["mid"] = $mid;
		
		$papercode = filterValue ( $this->input->get ( "papercode" ), "-1" );
		$insertData ["papercode"] = $papercode;
		$checkHadData ["papercode"] = $papercode;
		
		$resultmatrix = filterValue ( $this->input->get ( "resultmatrix" ), "-1" );
		$insertData ["resultmatrix"] = $resultmatrix;
		$checkHadData ["resultmatrix"] = $resultmatrix;
		
		$score = filterValue ( $this->input->get ( "score" ), "-1" );
		$insertData ["score"] = $score;
		
		$insertData ["addtime"] = time();
		
		$msg = "failed";
		$prId = "-1";
		$paperData = $this->__getPaperData ( array (
				"papercode" => $papercode 
		) );
		$memberData = $this->__getMemberData ( array (
				"mid" => $mid 
		) );
		if (sizeof ( $paperData ) != 0 && sizeof ( $memberData ) != 0) {
			
			$paperResultData = $this->__getPaperResultData ( $checkHadData );
			if (sizeof ( $paperResultData ) != 0) {
				$msg = "isHad";
			} else {
				$this->load->model ( "paper_result_model" );
				$insertID = $this->paper_result_model->insert ( $insertData );
				if ($insertID > 0) {
					$msg = "success";
					$prId = $insertID;
				}
			}
		}
		$this->result_data = array (
				"result" => $msg,
				"prId" => $prId 
		);
		$this->__outmsg ();
	}
	
	public function set_lessons_isgood() {
		$id = filterValue ( $this->input->get ( "id" ), 0, true );
		$msg = "failed";
		$goodpost = "-1";
		if ($id != 0) {
			$whereArr = array (
					"id" => $id
			);
			$field = "goodpost";
			$this->load->model ( "article_model" );
			$affected_rows = $this->article_model->update ( $field, $whereArr );
			if ($affected_rows > 0) {
				$msg = "success";
				$re = $this->article_model->row ( $whereArr );
				$goodpost = $re ["goodpost"];
			}
		}
		$this->result_data = array (
				"result" => $msg,
				"goodpost" => $goodpost
		);
		$this->__outmsg ();
	}



    private function __member_address($where){
        $this->load->model("Member_address_model");
       $Data =  $this->Member_address_model->row($where);
        return $Data;
    }
    public function set_member_address(){
        $msg = "failed";
        $userid = $this->input->get("mid");
        $addressData = $this->__member_address(array("userid" => $userid));
        if(sizeof($addressData) == 0){
            $consignee = $this->input->get("consignee");
            $address = $this->input->get("address");
            $tel = $this->input->get("tel");
            $this->load->model ( "Member_address_model" );
            $Data = $this->Member_address_model->set_member_address($userid,$consignee,$address,$tel);
            if(sizeof($Data != 0)){
                $msg = "success";
            }
        }else{
            $msg = "failed";

        }

        $this->result_data = array(
            "msg" => $msg,
            "addressData" =>$addressData
        );
        $this->__outmsg();
    }

    public function get_user_address(){

        $mid = $this->input->get("mid");

        $this->load->model('member_address_model');
        $addressData = $this->member_address_model->get_user_address($mid);
        $this->result_data = array(
            "mid" => $mid,
            "addressData" => $addressData
        );
        $this->__outmsg();
    }

    public function add_user_address(){
        $msg = "failed";
        $user_id = $this->input->get("userid");
        $consignee = $this->input->get("consignee");
        $address = $this->input->get("address");
        $tel = $this->input->get("tel");
        $city = $this->input->get("city");
        $des = $this->input->get("des");
        $addressData = $this->__getMemberData(array("mid" => $user_id));
        if (sizeof($addressData) == 0){
            $msg = "user_no_had";
        }else{
            $this->load->model("member_address_model");
            $resultData = $this->member_address_model->add_user_address($user_id,$consignee,$address,$city,$tel,$des);
            if(sizeof($resultData != 0)){
                $msg = "success";
            }
        }
        $this->result_data = array(
            'msg' => $msg
        );
        $this->__outmsg();
    }

    public function update_user_address(){
        $msg = "failed";
        $mid = $this->input->get("mid");
        $aid = $this->input->get("aid");
        $consignee = $this->input->get("consignee");
        $address = $this->input->get("address");
        $city = $this->input->get("city");
        $tel  = $this->input->get("tel");
        $des = $this->input->get("des");
        $this->load->model("member_address_model");
        $resultData = $this->member_address_model->update_user_address($mid,$aid,$consignee,$address,$city,$tel,$des);
        if($resultData){
            $msg = "success";
        }else{
            $msg = "failed";
        }
        $this->result_data = array(
            "mid" =>$mid,
            "msg" =>$msg
        );
        $this->__outmsg();
    }


    public function delete_user_address(){
        $msg = "failed";
        $userid = $this->input->get("mid");
        $aid = $this->input->get("aid");
        $addressData = $this->__getMemberData(array("mid" => $userid));
        if (sizeof($addressData) == 0){
            $msg = "user_no_had";
        }else{
            $this->load->model("member_address_model");
            $resultData = $this->member_address_model->delete_user_address($aid);
            if ($resultData > 0){
                $msg = 'success';
            }
        }
        $this->result_data  = array(
            'msg' => $msg,
            "aid" => $aid,
            "mid" =>  $userid,
            'resultData' => $resultData
        );

        $this->__outmsg();
    }

    public function change_defult_address(){
        $msg = "failed";
        $mid = $this->input->get("mid");
        $aid = $this->input->get("aid");
        $des = $this->input->get("des");
        $this->load->model("member_address_model");
        $resultDate = $this->member_address_model->change_defult_address($mid,$aid,$des);
        if($resultDate){
            $msg = "success";
        }
        $this->result_data = array(
            "msg" => $msg
        );
        $this->__outmsg();
    }


    public function get_member_address(){
        $userid = $this->input->get("mid");
        $whereArr = array(
            "userid" => $userid,
            "des" => 1
        );
        $addressData = $this->__member_address($whereArr);
        if(sizeof($addressData) == 0){
            $msg = "no";
        }else{
            $msg = "success";
        }
        $this->result_data = array(
            "msg"=> $msg,
            "addressData" =>$addressData
        );
        $this->__outmsg();
    }

    public function set_order_list(){
        $msg = "failed";
        $mid = $this->input->get("mid");
        $aid = $this->input->get("aid");
        $title = $this->input->get("title");
        $price = $this->input->get("price");
        $count = $this->input->get("count");
        $this->load->model("shop_model");
        $data = $this->shop_model->set_order_list($aid,$mid,$title,$price,$count);
        if($data){
            $msg = "success";
        }
        $this->result_data = array(
            "msg" => $msg,
            "mid" => $mid,
//            "buyid" => $buyid,
            "data" => $data,
            "aid" => $aid,
            "title" => $title,
            "price" => $price,
            "count" => $count
        );
        $this->__outmsg();
    }

    //加入购物车

    public function add_shop_car(){
        $msg = "failed";
        $id = $this->input->get("id");
        $userid = $this->input->get("mid");
        if($id != 0){
            $this->load->model("shop_model");
            $resultData = $this->shop_model->add_shop_car($id,$userid);
            if($resultData){
                $msg = "success";
            }
        }
        $this->result_data = array(
            "msg" => $msg
        );
        $this->__outmsg();
    }


    public function get_user_shop_car_list(){
        $userid = $this->input->get("userid");
        $this->load->model("shop_model");
        $data = $this->shop_model-> get_user_shop_car_list($userid);
        $this->result_data = handlerImgUrl($data,"litpic","more");
//        $this->result_data = array(
//            "data" => $data
//        );
        $this->__outmsg();
    }

    public function delete_user_car_list(){
        $oid = $this->input->get("oid");
        $msg = "failed";
        $where = array(
            "oid" => $oid
        );
        $this->load->model("shop_model");
        $resultData = $this->shop_model->get_car_row($where);
        if(sizeof($resultData) != 0){
            $affected_rows = $this->shop_model->delete_user_car_list($where);
            if($affected_rows){
                $msg = "success";
            }
        }
        $this->result_data = array(
            "oid" => $oid,
            "msg" => $msg
        );
        $this->__outmsg();
    }


    public function buy_from_car(){
        $msg = "faild";
        $oid = $this->input->get("oid");
        $oid = explode(",",$oid);
        $this->load->model("shop_model");
       if(sizeof($oid) == 1){
           $data = $this->shop_model->buy_from_car($oid[0]);
           if($data){
               $msg = "success";
           }

       }else{
            for ($i = 0; $i < sizeof($oid); $i++){
                $data = $this->shop_model->buy_from_car($oid[$i]);
               if($data){
                   $msg = "success";
               }
            }
        }

        $this->result_data = array(
            "msg" => $msg
        );
        $this->__outmsg();
    }


    public function get_user_order(){

        $mid = $this->input->get("mid");
        $page = $this->input->get("page");
        $pagesize = $this->input->get("pagesize");
        $this->load->model("shop_model");
        $resultData = $this->shop_model->get_user_order($mid,$page,$pagesize);
         $this->result_data = handlerImgUrl ( $resultData, "litpic", "more" );

        $this->__outmsg();
    }

    public function comment_state(){
        $msg = "faild";
        $buyid =  $this->input->get("buyid");
        $this->load->model("shop_model");
        $data = $this->shop_model->comment_state($buyid);
        if($data){
            $msg = "success";
        }
        $this->result_data = $msg;
        $this->__outmsg();
    }




    /*public  function  alipay(){
	    $aid = filterValue($this->input->get("id"),0,true);
        $userId = filterValue( $this->input->get("mid"),0,true);
        $price = filterValue($this->input->get("price"),0.01,true);
        $cartcount = filterValue($this->input->get("cartcount",1));
        $this->result_data = array(
            "aid" => $aid,
            "userId" =>$userId,
            "price" => $price,
            "cartcount" => $cartcount
        );
        $this->__outmsg();
	}*/
    //支付测试参数
    /*public  function payfor(){
        $payMode = filterValue($this->input->get("payMode"),"alipay");
        $aid = filterValue($this->input->get("aid"),12);
        $userid = filterValue($this->input->get("mid"),5);
        $price = filterValue($this->input->get("price"),0.01);
        $cartcount = filterValue($this->input->get("cartcount"),1);
        $this->result_data = array(
            "payMode" => $payMode,
            "aid" => $aid,
            "mid" => $userid,
            "price" => $price,
            "cartcount" => $cartcount
        );
        $this->__outmsg();
    }*/


    public  function pay(){
        $aid = filterValue($this->input->get("id"),0,true);
        $userid = filterValue($this->input->get("mid"),0,true);
        $price = filterValue($this->input->get("price"),0.01);
        $carcount = filterValue($this->input->get("carconut"),1);
        $msg = "failed";
        $oid = "-1";
        $url = "";
        $para = array(
            "price" => $price,
            "userid" => $userid,
            "aid" => $aid,
            "carcount" => $carcount,
            "ip" => getIP()
        );
        $shopData = $this->__getArticleData(array("id"=>$aid));
        $memberData = $this->__getMemberData(array("mid"=>$userid));
        if(sizeof($shopData) != 0 && sizeof($memberData) != 0){
            $para["title"] = $shopData["title"];
            $this->load->model("Alipay_model");
            $payData = $this->Alipay_model->pay($para);
           // $url = $payData["url"];
            //$oid = $payData["oid"];
            $msg = "success";
        }

        $this->result_data =array(
           /*"url" => $url,
            "oid" => $oid,
            "msg" => $msg,*/
           "payData" => $payData,
            "aid" => $aid,
            "mid" => $userid,
            "price" => $price,
            "cartcount" => $carcount
        );
        $this->__outmsg();
    }

    public function userPay(){
        $aid = filterValue($this->input->get("id"),0,true);
        $userid = filterValue($this->input->get("mid"),0,true);
        $price = filterValue($this->input->get("price"),0.01);
        $cartcount = filterValue($this->input->get("cartcount"),1);
        $msg = "failed";
        $oid = "-1";
        $url = "";
        $para = array(
            "price" => $price,
            "userid" => $userid,
            "cartcount" =>$cartcount,
            "aid" => $aid,
            "id" => getIP()
        );
        $shopData = $this->__getArticleData(array("id"=>$aid));
        $memberData = $this->__getMemberData(array("mid"=>$userid));
        if(sizeof($shopData)!=0 && sizeof($memberData)!=0){
            $para["title"] = $shopData["title"];
            $this->load->model("Alipay_model");
            $relustData = $this->Alipay_model->pay($para);
            $url = $relustData["url"];
            $oid = $relustData["oid"];
        }
        $this->result_data = array(
            "msg" => $msg,
            "oid" => $oid,
            "url" => $url
        );
        $this->__outmsg();
    }

	public function alipay(){
		$aid = filterValue ( $this->input->get ( "id" ), 0, true );
		$userid = filterValue ( $this->input->get ( "mid" ), 0, true );
		$price = filterValue ( $this->input->get ( "price" ), 0.01);
		$cartcount = filterValue ( $this->input->get ( "cartcount" ), 1);
		$msg = "failed";
		$oid = "-1";
		$url = "";
		$para=array(
				"price"=>$price,
				"userid"=>$userid,
				"cartcount"=>$cartcount,
				"aid"=>$aid,
				"ip"=>getIP()
		);
		
		$lessonsData=$this->__getArticleData(array("id"=>$aid));
		$memberData=$this->__getMemberData(array("mid"=>$userid));

		/*echo "aid:".$aid."<br>";
		echo "userid:".$userid."<br>";
		echo "price:".$price."<br>";
		echo "cartcount:".$cartcount."<br>";
		echo "lessonData：<pre>";
		print_r($lessonsData);
		echo "memberData：";
		print_r($memberData);
		echo "</pre>";
		exit();*/

		if(sizeof($lessonsData)!=0 && sizeof($memberData)!=0){
			$para["title"]=$lessonsData["title"];
			$this->load->model ( "alipay_model" );
			$returnData=$this->alipay_model->pay($para);
			$url=$returnData["url"];
			$oid=$returnData["oid"];
		}
		$this->result_data = array (
				"url"=>$url,
				"result" => $msg,
				"oid" => $oid
//                "mid" => $aid,
//                "userid" => $userid,
//                "price" => $price,
//                "cartcount" => $cartcount
		);
		$this->__outmsg ();
	}
	
	public function userdatahandler(){
		//迁移到服务器上执行一次即可
		$this->load->model ( "member_model" );
		$reMid=$this->member_model->get_membet_mid();
		$this->load->model ( "member_person_model" );
		foreach ($reMid as $k=>$v){
			$this->member_person_model->checkHadPerson($v);
		}
		
	}
}
