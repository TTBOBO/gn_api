<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Feedback_model extends MY_model {
	public function __construct() {
		parent::__construct ( "dede_feedback" );
	}
	
	public function get_feedback_list($where,$page=1,$pageSize=10,$orderby="a.dtime@desc"){
		$offset = ($page - 1) * $pageSize;
		$fields='a.id, a.typeid,a.aid, a.username, a.arctitle,';
		$fields.=' a.dtime, a.mid, a.bad,a.good,a.ftype, a.msg ,';
		$fields.='b.face';
		$this->db->select($fields);
		$this->db->from( "dede_feedback as a" );
		$this->db->join("dede_member as b","a.mid=b.mid");
		$this->db->where ( $where );
//		$this->db->limit($pageSize, $offset);
		if (! empty ( $orderby )) {
			$orderby = str_replace ( "@", " ", $orderby );
			$this->db->order_by ( $orderby );
		}

		$data = $this->db->get()->result_array();
		return $data;
	}
}