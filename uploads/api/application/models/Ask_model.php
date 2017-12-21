<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Ask_model extends MY_model {
	public function __construct() {
		parent::__construct ( "dede_ask" );
	}
	
	public function replies_add($id,$num=1,$addflag=false){
		if($addflag){
			$condition=$num;
		}
		else{
			$condition="replies+".$num;
		}
		$sql="update dede_ask set replies = {$condition} where id=".$id;
		$this->db->query($sql);
		return  $this->db->affected_rows(); 
	}
	
	public function get_ask_list($whereArr,$page=1,$pageSize=10,$orderby="a.dateline@desc",$isAll=false,$isFlag="",$keywords=""){
		$offset = ($page - 1) * $pageSize; 
		$fields='a.id as id, a.tid ,a.tidname ,a.tid2 ,a.tid2name ,a.anonymous ,b.uname,b.userid,b.mtype,';
		$fields.='a.title,a.reward,a.status,a.views,a.replies,a.dateline';
		$this->db->select($fields);
		$this->db->from( "dede_ask as a" );
		$this->db->join("dede_member as b","a.uid=b.mid");
		if($isFlag=="search"){
			$this->db->like("a.title", $keywords);
		}
		
		$this->db->where ( $whereArr );
		if($isAll){
			$this->db->where ( "a.status !=",2 );
		}
		$this->db->limit($pageSize, $offset);
		if (! empty ( $orderby )) {
			$orderby = str_replace ( "@", " ", $orderby );
			$this->db->order_by ( $orderby );
		}
		echo $this->db->last_query();
		$data = $this->db->get()->result_array();
		return $data;
	}
	
	public function get_ask_details($id=0){
		$whereArr=array("id"=>$id);
		$fields='a.id as id, a.tid ,a.tidname ,a.tid2 ,a.tid2name ,a.anonymous ,b.uname,b.userid,b.mtype,';
		$fields.='a.title,a.digest,a.reward,a.dateline,a.expiredtime,a.solvetime,a.bestanswer,a.status,a.disorder,';
		$fields.='a.views,a.replies,a.content ';		
		$this->db->select($fields);
		$this->db->from( "dede_ask as a" );
		$this->db->join("dede_member as b","a.uid=b.mid");
		$this->db->where ( $whereArr );
		$data = $this->db->get()->row();
		return $data;
	}
}