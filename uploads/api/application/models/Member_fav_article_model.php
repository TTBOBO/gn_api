<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Member_fav_article_model extends MY_model {
	public function __construct() {
		parent::__construct ( "dede_member_stow" );
	}
	
	private function __get_list($where,$page=1,$pageSize=10,$orderby="a.id@desc",$isLessons=false){
		$offset = ($page - 1) * $pageSize;
		$fields='a.id as id,b.id as id1,a.mid as mid,a.aid as aid, a.title as title,a.addtime as addtime, ';
		$fields.='b.writer,b.source ,b.goodpost,b.badpost,b.description,d.imgurls';
		if($isLessons){
			$fields.=',c.trueprice ';
		}
		$this->db->select($fields);
		$this->db->from( "dede_member_stow as a" );
		$this->db->join("dede_archives as b","a.aid=b.id");
        $this->db->join("dede_addonimages as d","a.aid = d.aid");
		if($isLessons){
			$this->db->join("dede_addonshop as c","a.aid=c.aid");
		}
		$typeFlag=($isLessons)?"":" !=";
		$where["b.typeid".$typeFlag]="4";
		$this->db->where ( $where );
		$this->db->limit($pageSize, $offset);
		if (! empty ( $orderby )) {
			$orderby = str_replace ( "@", " ", $orderby );
			$this->db->order_by ( $orderby );
		}
		$data = $this->db->get()->result_array();
		return $data;
	}
	
	public function get_fav_lessons_list($where,$page=1,$pageSize=10,$orderby="a.id@desc"){
		return $this->__get_list($where,$page,$pageSize,$orderby,true);
	}
	
	public function get_fav_article_list($where,$page=1,$pageSize=10,$orderby="a.id@desc"){
		return $this->__get_list($where,$page,$pageSize,$orderby,false);
	}

	private function __fav_list($mid ,$page=1,$pageSize=2,$order="b.id@desc"){
        $offset = ($page - 1) * $pageSize;
        $where = array(
            "a.mid" => $mid,
            "a.typeid" => 10
        );
        $fileds = "a.id as id,a.typeid as typeid,a.sortrank,a.flag,a.title,a.writer,a.pubdate,a.mid,c.face";
        $fileds .= ",a.goodpost,b.imgurls";
        $this->db->select($fileds);
        $this->db->from("dede_archives as a");
        $this->db->join("dede_addonimages as b","a.id=b.aid");
        $this->db->join("dede_member as c","a.mid=c.mid");
        $this->db->where($where);
        $this->db->limit($pageSize, $offset);
        if (! empty ( $order )) {
            $order = str_replace ( "@", " ", $order );
            $this->db->order_by ( $order );
        }
        $data = $this->db->get()->result_array();
        return $data;

    }

	public function get_user_dynamic_list($mid,$page=1,$pageSize=10,$order){
        return $this->__fav_list($mid,$page,$pageSize,$order);
    }

    private function __unlinkImg($id){
        $where = array(
            "aid" => $id
        );
        $fileds = "imgurls";
        $this->db->select($fileds);
        $this->db->from("dede_addonimages");
        $this->db->where($where);
        $data = $this->db->get()->row_array();
        foreach ($data as $k=>$v){
            //处理图片
            $data = unlinkImg($v);
        }
        foreach ($data as $v){
            //判断图片是否在路径下
            if(file_exists($v)){
                //存在就删除
                unlink($v);
            }
        }
        return $data;
    }

    public function unlinkImg($id){
       $data =  $this->__unlinkImg($id);
        return $data;
    }

    public function deleteImage($id){
        $where = array(
            "aid" => $id
        );
        $this->db->delete("dede_addonimages",$where);
        return $this->db->affected_rows ();
    }


}