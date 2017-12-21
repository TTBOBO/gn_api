<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Ask_answer_model extends MY_model {
	public function __construct() {
		parent::__construct ( "dede_askanswer" );
	}
	public function get_ask_answer_list($askId = 0, $orderby = "a.dateline@desc") {
		$whereArr = array ("a.askid" => $askId,"a.ifcheck" => 1);
		//$fields = 'a.id as id, a.askid ,b.uname,b.userid,b.mtype,';
		$fields = 'a.id as id, a.askid ,b.uname,a.uid,b.mtype ,';
		$fields .= 'a.goodrate,a.badrate,a.dateline,a.content';
		$this->db->select ( $fields );
		$this->db->from ( "dede_askanswer as a" );
		$this->db->join ( "dede_member as b", "a.uid=b.mid" );
		$this->db->where ( $whereArr );
		if (! empty ( $orderby )) {
			$orderby = str_replace ( "@", " ", $orderby );
			$this->db->order_by ( $orderby );
		}
		$data = $this->db->get ()->result_array ();
		return $data;
	}
	
	public function get_ask_list_by_mid($mid,$page,$pageSize){
		$sql="select * from dede_ask where id in ";
		$sql.="(select distinct (askid) from dede_askanswer where uid = {$mid} order by askid desc)";
		$sql.=" order by id desc ";
		$sql.=" limit {$page},{$pageSize} ";
		$data=$this->db->query($sql)->result_array();
		return $data;
	}
}