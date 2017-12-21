<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Article_category_model extends MY_model {
	public function __construct() {
		parent::__construct ( "dede_arctype" );
	}
	
	public function get_category_list($catrgotyId=0){
		$whereArr=($catrgotyId==0)?array():array("id"=>$catrgotyId);
		$fields='id , typename ,ishidden';
		$this->db->select($fields);
		$this->db->from( "dede_arctype" );
		$this->db->where ( $whereArr );
		$data = $this->db->get()->result_array();
		return $data;
	}
}