<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Zxs_model extends MY_model {
	public function __construct() {
		parent::__construct ( "dede_zxs_follow" );
	}
	
	public function is_follow($mid,$zxsid){
		$data=$this->row(array("mid"=>$mid,"zxsid"=>$zxsid));
		return (sizeof($data)!=0);
	}
	
	public function get_follow_list($mid){
		$reData=array();
		$this->db->select("zxsid");
		$this->db->from("dede_zxs_follow");
		$this->db->where(array("mid"=>$mid));
		$data = $this->db->get()->result_array();
		$zxsidData=array();
		foreach ($data as $key=>$value){
			array_push($zxsidData,$value["zxsid"]);
		}
		if(sizeof($zxsidData)!=0){
			$fields ='a.mid,a.mtype,a.userid,a.uname,a.sex,a.rank,a.email,a.scores,';
			$fields.='a.matt,a.spacesta,a.face,a.shouji,a.qq,a.myjie,b.birthday,b.good,a.jointime';
			$this->db->select($fields);
			$this->db->from("dede_member as a");
			$this->db->join( "dede_member_person as b","a.mid=b.mid" );
			$this->db->where_in("a.mid",$zxsidData);
			$zxsdata = $this->db->get()->result_array();
			$reData=$zxsdata;
		}
		return $reData;
	}
}