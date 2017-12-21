<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Article_model extends MY_model {
	public function __construct() {
		parent::__construct ( "dede_archives" );
	}
	
	private function __get_list($catrgotyId=0,$page=1,$pageSize=10,$orderby="a.id@desc",$isFlag="",$keywords=""){
		$whereArr=($catrgotyId==0)?array():array("a.typeid"=>$catrgotyId);
		
		$offset = ($page - 1) * $pageSize;
		$fields='a.id as id, a.typeid as typeid,a.typeid2 as typeid2,a.sortrank ,a.flag ,a.arcrank,b.typename,';
		$fields.='a.title,a.shorttitle,a.writer,a.source,a.litpic,a.pubdate,a.goodpost,a.badpost,a.weight,a.description ';
		if($catrgotyId==4){
			$fields.=',c.trueprice ';
		}
		$this->db->select($fields);
		$this->db->from( "dede_archives as a" );
		$this->db->join("dede_arctype as b","a.typeid=b.id");
		if($catrgotyId==1){
			$this->db->join("dede_addonarticle as c" ,"a.id=c.aid");
		}
		else if($catrgotyId==4){
			$this->db->join("dede_addonshop as c" ,"a.id=c.aid");
		}
		
		if($isFlag=="focus"){
			$this->db->like("a.flag", "p");
		}
		if($isFlag=="search"){
			$this->db->like("a.title", $keywords);
		}
		$this->db->where ( $whereArr );
        //从第$offset个选取几个变量
		$this->db->limit($pageSize, $offset);
		if (! empty ( $orderby )) {
			$orderby = str_replace ( "@", " ", $orderby );
			$this->db->order_by ( $orderby );
		}
		$data = $this->db->get()->result_array();
		return $data;
		
	}


	
	public function get_article_list_by_keywords($catrgotyId=1,$page=1,$pageSize=10,$orderby="a.id@desc",$keywords){
		$data=$this->__get_list($catrgotyId,$page,$pageSize,$orderby,"search",$keywords);
		return $data;
	}
	
	public function get_article_focus_list($catrgotyId=1,$page=1,$pageSize=10,$orderby="a.id@desc"){
		$data=$this->__get_list($catrgotyId,$page,$pageSize,$orderby,"focus");
		return $data;
	}
	
	public function get_article_list($catrgotyId=1,$page=1,$pageSize=10,$orderby="a.id@desc"){
		$data=$this->__get_list($catrgotyId,$page,$pageSize,$orderby);
		return $data;
	}
	
	public function get_lessons_list($catrgotyId=4,$page=1,$pageSize=10,$orderby="a.id@desc"){
		$data=$this->__get_list($catrgotyId,$page,$pageSize,$orderby);
		return $data;
	}
	
	private function __get_contents($catrgotyId,$whereArr){
		$fields='a.id as id, a.typeid as typeid, a.sortrank ,a.flag ,a.click ,a.arcrank,b.typename,';
		$fields.='a.title,a.shorttitle,a.writer,a.source,a.litpic,a.pubdate,a.goodpost,a.badpost,a.description,c.body ';
		if($catrgotyId==4){
			$fields.=" , c.trueprice";
		}
		$this->db->select($fields);
		$this->db->where ($whereArr);
		$this->db->from("dede_archives as a");
		$this->db->join("dede_arctype as b" ,"a.typeid=b.id");
		if($catrgotyId==1){
			$this->db->join("dede_addonarticle as c" ,"a.id=c.aid");
		}
		else if($catrgotyId==4){
			$this->db->join("dede_addonshop as c" ,"a.id=c.aid");
		}
		$this->db->order_by("id desc");
		$this->db->limit(1);
		$data = $this->db->get()->row_array();
		//$data["body"]=urlencode($data["body"]);
		return $data;
	
	}

	
	public function get_article_contents($whereArr){	
		$data=$this->__get_contents(1,$whereArr);
		return $data;
	}
	public function get_lessons_contents($whereArr){
		$data=$this->__get_contents(4,$whereArr);
		return $data;
	}


    private function  __get_img_list($catrgotyId=2,$page=2,$pageSize=10,$orderby="a.id@desc",$isFlag="",$keywords=""){
        //$catrgotyId == 0 时 搜索全部栏目
        $whereArr = ($catrgotyId == 0)?array():array("a.typeid" => $catrgotyId);
        $fields = "a.id as id,a.typeid as typeid,a.typeid2 as typeid2,a.sortrank,a.flag,a.arcrank,b.typename";
        $fields.= ",a.click,a.title,a.shorttitle,a.writer,a.source,a.pubdate,a.goodpost,a.description,a.weight";
        $offset = ($page - 1) * $pageSize;
        if($catrgotyId == 2){
            $fields .= ",c.imgurls";
        }
        $this->db->select($fields);
        $this->db->from("dede_archives as a");
        $this->db->join("dede_arctype as b","a.typeid=b.id");
        if($catrgotyId == 2){
            $this->db->join("dede_addonimages as c","a.id = c.aid");
        }
        $this->db->where($whereArr);
       $this->db->limit($pageSize,$offset);
        if(!empty($orderby)){
            $orderby = str_replace("@"," ",$orderby);
            $this->db->order_by($orderby);
        }

        $data = $this->db->get()->result_array();
        return $data;

    }

    public function get_img_article($catrgotyId=2,$page=2,$pageSize=10,$orderby="a.id@desc"){
        /*$data =$this->__article_img($catrgotyId);
        return $data;
        $fields = "*";
        $this->db->select($fields);
        $this->db->from("dede_addonimages");
        $this->db->order_by("aid desc");
        $data = $this->db->get()->row_array();
        return $data;*/
        //$data = $this->__get_list($catrgotyId,$page,$pageSize,$orderby);
        $data = $this->__get_img_list($catrgotyId,$page,$pageSize,$orderby);
        return $data;
    }


    private function  __get_img_content($whereArr){
        $fields = "a.id as id,a.typeid as typeid,a.typeid2 as typeid2,a.sortrank,a.flag,a.arcrank,b.typename";
        $fields .= ",a.click,a.title,a.writer,a.shorttitle,a.source,a.pubdate,a.goodpost,a.description,a.weight,c.body,a.keywords";
        $this->db->select($fields);
        $this->db->from("dede_archives as a");
        $this->db->join("dede_arctype as b","a.typeid = b.id");
        $this->db->join("dede_addonimages as c","a.id = c.aid");
        $this->db->where($whereArr);
        $this->db->order_by("a.id desc");
        $this->db->limit(1);
        $data = $this->db->get()->row_array();
        return $data;
    }

    public function get_img_article_content($whereArr){
        $data =  $this->__get_img_content($whereArr);
       return $data;
    }

   /* private function __article_img(){
        $fields = "*";
        $this->db->select($fields);
        $this->db->from("dede_addonimages");
        $this->db->order_by("aid desc");
        $data = $this->db->get()->row_array();
        return $data;
    }*/

    //原始获取图集图片函数
   /* public function get_article_img($catrgotyId){
        $data =$this->__article_img($catrgotyId);
        return $data;
        $fields = "*";
        $this->db->select($fields);
        $this->db->from("dede_addonimages");
        $this->db->order_by("aid desc");
        $data = $this->db->get()->row_array();
        return $data;
        //$data = $this->__get_list($catrgotyId,$page,$pageSize,$orderby);
       //$data = $this->__get_img_list($catrgotyId,$page,$pageSize,$orderby);
       return $data;
    }*/

   public function set_article_click($id){
       $whereArr = array(
           "id" => $id
       );
//       $updateArr = array(
//
//       )
   }

   public function get_advertisement($typeid){
       $fields = "a.*,b.imgurls";
       $where = array(
           "a.typeid" => $typeid
       );
       $this->db->select($fields);
       $this->db->from("dede_archives as a");
       $this->db->join("dede_addonimages as b","a.id = b.aid");
       $this->db->where($where);
       $data = $this->db->get()->result_array();
//       $data1 = array_rand($data);
//       $data1 = array_rand($data);
       return $data;
   }

   public function get_advertisement1($typeid){
       $num = mt_rand();
   }



}