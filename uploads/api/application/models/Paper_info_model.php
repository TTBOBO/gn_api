<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Paper_info_model extends MY_model {
	public function __construct() {
		parent::__construct ( "paper_info" );
	}
	
	public function getPapersList($where=array(),$page=1,$pageSize=10,$orderby="id@desc"){
		$offset = ($page - 1) * $pageSize;
		$fields='a.id,a.papercode,a.papername,b.uname as adduser,a.addtime';
		$this->db->select($fields);
		$this->db->from( "paper_info as a" );
		$this->db->join("dede_member as b","a.adduser=b.mid");
		//$this->db->join("dede_addonarticle as c" ,"a.id=c.aid");
		$this->db->where ( $where );
		$this->db->limit($pageSize, $offset);
		if (! empty ( $orderby )) {
			$orderby = str_replace ( "@", " ", $orderby );
			$this->db->order_by ( $orderby );
		}
		$data = $this->db->get()->result_array();
		return $data;
	}
	
	public function getPaperContents($where=array()){
		$this->load->model ( "paper_test_item_model" );
		$testItemsData=$this->paper_test_item_model->result($where,1,100,"CAST(testcode as SIGNED)@asc");
		
		$this->load->model ( "paper_dimension_model" );
		$dimensionData=$this->paper_dimension_model->result($where,1,100,"CAST(dimensioncode as SIGNED)@asc");
		
		$data=array(
			"testItems"=>$testItemsData,
			"dimension"=>$dimensionData
		);
		return $data;
	}
}