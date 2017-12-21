<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Member_person_model extends MY_model {
	public function __construct() {
		parent::__construct ( "dede_member_person" );
	}
	
	public function checkHadPerson($mid){
		$data=$this->row(array("mid"=>$mid));
		if(sizeof($data)==0){
			$dataPerson=array(
					"mid"=>$mid,"onlynet"=>1,"sex"=>"男","uname"=>"",
					"qq"=>"","msn"=>"","tel"=>"","mobile"=>"","place"=>0,
					"oldplace"=>0,"birthday"=>"1980-01-01","star"=>1,
					"income"=>0,"education"=>0,"height"=>160,"bodytype"=>0,
					"blood"=>0,"vocation"=>0,"smoke"=>0,"marital"=>0,
					"house"=>0,"drink"=>0,"datingtype"=>0,"language"=>NULL,
					"nature"=>NULL,"lovemsg"=>"","address"=>"","uptime"=>0,"good"=>0
			);
			$this->insert($dataPerson);
		}
	}
}