<?php
/**
 * Created by PhpStorm.
 * User: TAB00
 * Date: 2017/1/17
 * Time: 16:15
 */
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Shop_model extends MY_Model {
    public function __construct()
    {
        parent::__construct ("dede_addonshop");
    }

    private function __shop_list($catrgotyId = 3,$page,$pageSize,$orderby = "a.id@desc"){

        $whereArr = array("a.typeid" => $catrgotyId);
        $fields = "a.id as id,a.typeid as typeid,a.typeid2 as typeid2,a.sortrank,a.flag";
        $fields .= ",a.title,a.writer,a.source,a.litpic,a.pubdate,a.weight,b.price,b.trueprice,b.brand";
        $fields  .= ",b.units,b.userip";
        $offect = ($page-1) * $pageSize;
        $this->db->select($fields);
        $this->db->from("dede_archives as a");

        $this->db->join("dede_addonshop as b","a.id = b.aid");

        $this->db->where($whereArr);

        $this->db->limit($pageSize, $offect);
        if (! empty ( $orderby )) {
            $orderby = str_replace ( "@", " ", $orderby );
            $this->db->order_by ( $orderby );
        }
        $data = $this->db->get()->result_array();
        return $data;
    }


    public function get_shop_list($catrgotyId = 3,$page,$pageSize,$orderby = "a.id@desc"){
        $data = $this->__shop_list($catrgotyId,$page,$pageSize,$orderby);
        return $data;
    }

    public function get_shop_detail($aid){
        $fields = "a.id,a.title,a.litpic,b.price,b.trueprice";
        $where = array(
            "aid" => $aid
        );
        $this->db->select($fields);
        $this->db->from("dede_archives as a");
        $this->db->join("dede_addonshop as b","a.id = b.aid");
        $this->db->where($where);
        $data = $this->db->get()->row_array();
        return $data;
    }



    private function __shop_subClass($catrgotyId){
        //dede_arctype
        $whereArr = array(
            "reid" => $catrgotyId
        );
        $fields = "id,reid,topid,typename";
        $this->db->select($fields);
        $this->db->from("dede_arctype");
        $this->db->where($whereArr);
        $this->db->order_by("id");
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function get_shop_subClass($catrgotyId){
        $data = $this->__shop_subClass($catrgotyId);
        return $data;
    }

    public function get_shop_about($aid){
        $whereArr = array("aid" => $aid);
        $fields = "body";
        $this->db->select($fields);
        $this->db->from("dede_addonshop");
        $this->db->where($whereArr);
        $data = $this->db->get()->row_array();
        return $data;
    }


    public function get_shop_subClass_list($typeid,$page,$pageSize,$orderby){
        $whereArr = array(
            "a.typeid2" => $typeid
        );
        $fields = "a.id as id,a.typeid as typeid,a.typeid2 as typeid2,a.sortrank,a.flag";
        $fields .= ",a.title,a.writer,a.source,a.litpic,a.pubdate,a.weight,b.price,b.trueprice,b.brand";
        $fields  .= ",b.units,b.userip";
        $offect = ($page-1) * $pageSize;
        $this->db->select($fields);
        $this->db->from("dede_archives as a");
        $this->db->join("dede_addonshop as b","a.id = b.aid");
        $this->db->where($whereArr);
        $this->db->limit($pageSize, $offect);
        if (! empty ( $orderby )) {
            $orderby = str_replace ( "@", " ", $orderby );
            $this->db->order_by ( $orderby );
        }
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function set_order_list($aid,$mid,$title,$price,$count){
        $buyid=date("YmdHis").mt_rand(100000,999999);
        $time = time();
        $dataArr = array(
            "aid" => "",
            "buyid" => $buyid,
            "pname" => $title,
            "product" => "",
            "money" => $price,
            "mtime" => $time,
            "pid" => $aid,
            "mid" => $mid,
            "sta" => 1,
            "oldinfo" => ""
        );
        $aid1 = $this->db->insert("dede_member_operation",$dataArr);

        $orderArr = array(
            "oid" => $buyid,
            "userid" => $mid,
            "pid" => "",
            "paytype" => "",
            "cartcount" => $count,
            "dprice" => "",
            "price" => $price,
            "priceCount" => $price * $count,
            "state" => 1,
            "ip" => getIP(),
            "stime" => $time
        );
        $this->db->insert("dede_shops_orders",$orderArr);

//        $proArr = array(
//            "aid" => $aid,
//            "oid" => $buyid,
//            "userid" => $mid,
//            "title" => $title,
//            "price" => $price,
//            "buynum" => $count
//        );
//        $this->db->insert("dede_shops_products",$proArr);
        return $aid1;
    }


    public function get_user_order($mid,$page,$pagesize){
        $whereArr = array(
            "a.mid" => $mid
        );
        $offset = ($page-1) * $pagesize;
        $fields = "a.aid as aid, a.buyid as buyid, a.pname, a.money,a.mtime,a.pid,";
        $fields .= "a.mid, a.sta,a.oldinfo, b.price,b.cartcount,b.priceCount,.c.litpic";
        $this->db->select($fields);
        $this->db->from("dede_member_operation as a");
        $this->db->join("dede_shops_orders as b","a.buyid = b.oid" );
        $this->db->join("dede_archives as c" ,"a.pid = c.id");
        $this->db->where($whereArr);
        $this->db->limit($pagesize, $offset);
        $this->db->order_by("aid desc");
        $data = $this->db->get()->result_array();
//        $data = $this->db->last_query();
        return $data;
    }

    public function comment_state($buyid){
        $flag = false;
        $upadteArr = array(
            "sta" => 2
        );
        $whereArr = array(
            "buyid" => $buyid
        );
        $this->db->update("dede_member_operation",$upadteArr,$whereArr);
        $re = $this->db->affected_rows();
        if($re == 1){
            $flag = true;
        }
        return $flag;
    }

    public function updatecomment($buyid){
        $flag = false;
        $upadteArr = array(
            "sta" => 3
        );
        $whereArr = array(
            "buyid" => $buyid
        );
        $this->db->update("dede_member_operation",$upadteArr,$whereArr);
        $re = $this->db->affected_rows();
        if($re == 1){
            $flag = true;
        }
        return $flag;
    }


    public function get_car_about($catrgotyId){
        $whereArr = array(
            "a.id" => $catrgotyId
        );
        $fields = "a.id as id,a.typeid as typeid,a.sortrank,a.title,a.description,a.litpic";
        $fields .= ",b.price,b.body,b.trueprice,b.brand";
        $this->db->select($fields);
        $this->db->from("dede_archives as a");
        $this->db->join("dede_addonshop as b","a.id = b.aid");
        $this->db->where($whereArr);
        $data = $this->db->get()->row_array();
        return $data;
    }

    public function add_shop_car($id,$userid){
        $result = false;
        $whereArr = array(
            "a.id" => $id
        );
        $fields = "a.id as id,a.title,b.price,b.trueprice";
        $this->db->select($fields);
        $this->db->from("dede_archives as a");
        $this->db->join("dede_addonshop as b","a.id = b.aid");
        $this->db->where($whereArr);
        $data = $this->db->get()->row_array();

        $insertArr = array();
        $buyid=date("YmdHis").mt_rand(100000,999999);
        $insertArr["aid"] = $id;
        $insertArr["oid"] = $buyid;
        $insertArr["userid"] = $userid;
        $insertArr["title"] = $data["title"];
        $insertArr["price"] = $data["price"];
        $insertArr["buynum"] = 1;
        $this->db->insert("dede_shops_products",$insertArr);
        $re = $this->db->affected_rows();


        $addOrderArr=array(
            "oid"=>$buyid,
            "userid"=>$userid,
            "pid"=>0,
            "paytype"=>3,
            "cartcount"=>1,
            "dprice"=>0,
            "price"=>$data["price"],
            "priceCount"=>$data["price"],
            "state"=>0,
            "ip"=>getIP(),
            "stime"=>time()
        );
        $this->db->insert("dede_shops_orders",$addOrderArr);
        $re1 = $this->db->affected_rows();
        if ($re == 1 && $re1 ==1){
            $result = true;
        }
//        $re = $this->db->row();
//        $data = array(
//            "mid" => $userid,
////            "title" => $re["title"],
//        );
        return $result;
    }

    public function get_user_shop_car_list($userid){
        $whereArr = array(
            "a.userid" => $userid
        );
        $fields = "a.aid as aid,a.oid,a.userid,,a.title,a.price,a.buynum,b.litpic";
        $fields .= ",c.trueprice,c.price,d.state";
        $this->db->select($fields);
        $this->db->from("dede_shops_products as a");
//        $this->db->from("dede_archives as a");
//        $this->db->join("dede_addonshop as b","a.id = b.aid");
        $this->db->join("dede_archives as b","a.aid = b.id");
        $this->db->join("dede_addonshop as c","a.aid = c.aid");
        $this->db->join("dede_shops_orders as d","a.oid = d.oid");
        $this->db->where($whereArr);
        $data = $this->db->get()->result_array();
        return $data;
    }


    public function buy_from_car($oid){
        $flag = false;
        $where1 = array(
            "a.oid" => $oid
        );
        $fields = "a.*,b.title,b.aid";
        $this->db->select($fields);
        $this->db->from("dede_shops_orders as a");
        $this->db->join("dede_shops_products as b","a.oid =b.oid");
        $this->db->where($where1);
        $result = $this->db->get()->row_array();

        $dataArr = array(
        "aid" => "",
        "buyid" => $result["oid"],
        "pname" => $result["title"],
        "product" => "",
        "money" => $result["price"],
        "mtime" => $result["stime"],
        "pid" => $result["aid"],
        "mid" => $result["userid"],
        "sta" => 1,
        "oldinfo" => ""
        );
        //添加到我的订单数据表里面
        $this->db->insert("dede_member_operation",$dataArr);

        $updateArr = array(
            "state" => 1
        );
        $where = array(
            "oid" => $oid
        );
        //修改订单状态
        $this->db->update("dede_shops_orders",$updateArr,$where);
        $re = $this->db->affected_rows();
        if($re == 1){
            $flag = true;
        }
        return $flag;
    }

    public function get_car_row($where){
        $this->db->where ( $where );
        $query = $this->db->get ( "dede_shops_products" );
        return $query->row_array ();
    }

    public function delete_user_car_list($where){
        $flag = false;
        $this->db->delete("dede_shops_products",$where);
        $re =  $this->db->affected_rows ();
        $this->db->delete("dede_shops_orders",$where);
        $re1 =  $this->db->affected_rows ();
        if($re > 0 && $re1 > 0){
            $flag = true;
        }
        return $flag;
    }

    public function select_for_keywords($key){
        $whereArr = array(
            "typeid" => 7
        );
        $this->db->select("*");
        $this->db->from("dede_archives");
        $this->db->where($whereArr);
        $this->db->like("title",$key);
        $data = $this->db->get()->result_array();
        return $data;
    }
    public function get_hot_search_keywords($typeid){
        $where = array(
            "typeid" => $typeid
        );
        $this->db->select("*");
        $this->db->from("dede_search_keywords");
        $this->db->where($where);
        $this->db->limit(10);
        $this->db->order_by("count desc");

        $data = $this->db->get()->result_array();
        return $data;
    }

    public function set_user_search_keywords($keywords,$typeid){
        $data = false;
        $whereArr = array(
            "keyword" => $keywords
        );
        $this->db->select("*");
        $this->db->from("dede_search_keywords");
        $this->db->where($whereArr);
        $result = $this->db->get()->row_array();
        if(sizeof($result) > 0){
            $updateArr = array(
                "count" => $result["count"]+1
            );
            $whereArr = array(
                "keyword" => $keywords
            );
            $this->db->update("dede_search_keywords",$updateArr,$whereArr);
//            $query = $this->db->last_query();
            $re = $this->db->affected_rows();
        }else if (sizeof($result) == 0){
            $insertArr = array();
            $insertArr["aid"] = "";
            $insertArr["keyword"] = $keywords;
            $insertArr["spwords"] = "";
            $insertArr["count"] = 1;
            $insertArr["result"] = 0;
            $insertArr["lasttime"] = time();
            $insertArr["channelid"] = 0;
            $insertArr["typeid"] = $typeid;
            $this->db->insert("dede_search_keywords",$insertArr);

            $re = $this->db->affected_rows();
        }

        if($re > 0){
            $data = true;
        }
        return $data;
    }
}