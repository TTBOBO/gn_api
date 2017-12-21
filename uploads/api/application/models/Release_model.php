<?php
/**
 * Created by PhpStorm.
 * User: TAB00
 * Date: 2017/1/3
 * Time: 22:12
 */
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Release_model extends MY_model {
    public function __construct()
    {
        parent::__construct("dede_archives");
    }


    public function set_release_img($mid,$msg,$uname,$imgurls){
        $dataMsg = array(
            /*"typeid" => 10,"typeid2" => 0, "sortrank" => time(),
            "flag" => "p","ismake" => 1,"channel" => 2,"arcrank" => 0,
            "click" => 0,"money" => 0,"title" => $msg,"shorttitle" => "",
            "color" => "","writer" => $uname ,"source" => "","litpic" => "",
            "pubdate" => time(),"senddate" => time(),"mid" =>$mid,"keywords" =>"",
            "lastpost" => 0,"scores" =>0,"goodpost"=> 0,"badpost" => 0,"voteid"=>0,
            "notpost" => 0, "description" =>"","filename" => "","dutyadmin" => 0,
            "tackid" => 0, "mtype" => 0, "weight"=> 0,*/
            "typeid" => 10,"typeid2" => 0, "sortrank" => time(),
            "flag" => "p","ismake" => 1,"channel" => 2,"arcrank" => 0,
            "click" => 0,"money" => 0,"title" => $msg,"shorttitle" => "",
            "color" => "","writer" => $uname ,"source" => "","litpic" => "",
            "pubdate" => time(),"senddate" => time(),"mid" =>$mid,"keywords" =>"",
            "lastpost" => 0,"scores" =>0,"goodpost"=> 0,"badpost" => 0,"voteid"=>0,
            "notpost" => 0, "description" =>"","filename" => "","dutyadmin" => 0,
            "tackid" => 0, "mtype" => 0, "weight"=> 0
        );
        $articleId = $this->insert($dataMsg);
        $re = $this->db->affected_rows();
        $dataImg = array(
            "aid" => $articleId,"typeid" => 10,"pagestyle" => 2,"maxwidth" => 800,
            "imgurls" => $imgurls,"row" => 3,"col" => 4,"isrm" => 1,"ddmaxwidth"=>200,
            "pagepicnum" => 12, "templet" => "","userip" => getIP(),"redirecturl" => "",
            "body" => ""
        );
        $this->db->insert("dede_addonimages",$dataImg);
        $re1 = $this->db->affected_rows();
        if ($re == 1 && $re1 == 1){
            $result = true;
        }
//        $result = array(
//            "msg" => $re,
//            "mid" => $re1,
//            "imgurls" => $imgurls
//        );
        return $result;
    }

    private function __get_release_list($catrgotyId = 10,$page,$pageSize,$orderBy = "a.id@desc"){
        $whereArr = array("a.typeid" => $catrgotyId);

        $fields = "a.id as id,a.typeid as typeid,a.typeid2 as typeid2,a.mid,a.sortrank,a.flag,a.arcrank,b.imgurls";
        $fields.= ",a.click,a.title,a.writer,a.source,a.pubdate,a.goodpost,a.description,a.weight,c.face,c.uname";
        $offset = ($page - 1) * $pageSize;
        $this->db->select($fields);
        $this->db->from("dede_archives as a");
        $this->db->join("dede_addonimages as b","a.id = b.aid");
        $this->db->join("dede_member as c","a.mid = c.mid");
        $this->db->where($whereArr);
        $this->db->limit($pageSize, $offset);
        if(!empty($orderBy)){
            $orderBy = str_replace("@"," ",$orderBy);
            $this->db->order_by($orderBy);
        }
        $data = $this->db->get()->result_array();
        $last = $this->db->last_query();
        /*  求出评论数量
            $feed = "count(b.aid) as count";
            $where  = array("a.id" => "8");
            $this->db->select($feed);
            $this->db->from("dede_archives as a");
            $this->db->join("dede_feedback as b","a.id = b.aid");
            $this->db->where($where);
            $data1 = $this->db->get()->row_array();
         */
        return  $data;
    }

    public function get_release_list($catrgotyId = 10,$page,$pageSize,$orderBy = "a.id@desc"){
       $Data =$this ->__get_release_list($catrgotyId,$page,$pageSize,$orderBy);
        return $Data;
    }

    public function get_release_con($aid) {
        $whereArr = array("a.id" => $aid);
        $fields = "a.id as id,a.typeid as typeid,a.typeid2 as typeid2,a.mid,a.sortrank,a.flag,a.arcrank,b.imgurls";
        $fields.= ",a.click,a.title,a.writer,a.source,a.pubdate,a.goodpost,a.description,a.weight,c.face,c.uname";
        $this->db->select($fields);
        $this->db->from("dede_archives as a");
        $this->db->join("dede_addonimages as b","a.id = b.aid");
        $this->db->join("dede_member as c","a.mid = c.mid");
        $this->db->where($whereArr);
        $data = $this->db->get()->row_array();
        $last = $this->db->last_query();

        return  $data;
    }


}