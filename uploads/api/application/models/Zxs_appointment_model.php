<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Zxs_appointment_model extends MY_model {
	public function __construct() {
		parent::__construct ( "dede_zxs_appointment" );
	}
	
	public function get_appointment_list_detail($where){
		$fields ="a.id as id, a.mid as mid, a.zxsid as zxsid,a.nickname as nickname,a.age as age,";
		$fields.="a.gender as gender,a.phone as phone, a.content as content,a.addtime as addtime,";
		$fields.="b.mtype as mtype,b.userid as userid, b.uname as uname,b.face as face";
		$this->db->select($fields);
		$this->db->from("dede_zxs_appointment as a");
		$this->db->join("dede_member as b", "a.zxsid=b.mid");
		$this->db->where($where);
		$data=$this->db->get()->result_array();
		return $data;
	}
}