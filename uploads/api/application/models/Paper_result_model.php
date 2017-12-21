<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Paper_result_model extends MY_model {
	public function __construct() {
		parent::__construct ( "paper_result" );
	}
	
	public function __getPaperTestResult($where,$page,$pageSize,$orderBy){
		$fields ='a.id,a.mid,a.papercode,a.resultmatrix,a.score,a.addtime,b.papername';
		$this->db->select($fields);
		$this->db->from( "paper_result as a" );
		$this->db->join( "paper_info as b","a.papercode=b.papercode" );
		$this->db->where($where);
		$page=($page-1)*$pageSize;
		$this->db->limit($pageSize,$page);
		$this->db->order_by($orderBy);
		$data = $this->db->get()->result_array();
		return $data;
	}
}