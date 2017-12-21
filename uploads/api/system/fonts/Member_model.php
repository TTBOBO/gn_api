<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Member_model extends MY_model {
	public function __construct() {
		parent::__construct ( "dede_member" );
	}
	
	public function get_membet_mid(){
		$this->db->select("mid");
		$this->db->from("dede_member");
		$data=$this->db->get()->result_array();
		$redata=array();
		foreach ($data as $k=>$v){
			array_push($redata, $v["mid"]);
		}
		return $redata;
	}
	
	public function update_zxs($where,$data){
		$this->db->update('dede_member_dszxs', $data, $where);
		return $this->db->affected_rows ();
	}
	
	public function check_zxs($where){
		$fields='*';
		$this->db->select($fields);
		$this->db->from( "dede_member_dszxs" );
		$this->db->where($where);
		$data = $this->db->get()->row_array();
		return $data;
	}
	
	public function add_zxs($data){
		$this->db->insert('dede_member_dszxs', $data);
		return $this->db->insert_id ();
	}
	
	public function get_zxs_list($where,$page=1,$pageSize=10,$isRand=false){
		$fields ='a.mid,a.mtype,a.userid,a.uname,a.sex,a.rank,a.email,a.scores,';
		$fields.='a.matt,a.spacesta,a.face,a.shouji,a.qq,a.myjie,b.birthday,b.good';
		$this->db->select($fields);
		$this->db->from( "dede_member as a" );
		$this->db->join( "dede_member_person as b","a.mid=b.mid" );
		$this->db->where($where);
		//$page=($isRand)?(mt_rand(1,3)):($page);
		//$pageSize=($isRand)?(10):($pageSize);
		$page=($page-1)*$pageSize;
		$this->db->limit($pageSize,$page);
		$this->db->order_by("a.mid desc");
		$data = $this->db->get()->result_array();
		return $data;
	}
	
	public function get_member_info($str,$flag=true){
		$fields='*';
		$this->db->select($fields);
		$this->db->from( "dede_member" );
		if($flag){
			$this->db->like('userid', $str);
			$this->db->or_like('uname', $str);
//			$this->db->or_like('email', $str);
			$this->db->or_like('shouji', $str);
		}
		else{
			$this->db->where(array("mid"=>$str));
		}
		$data = $this->db->get()->row_array();
		return $data;
	}
	
	public function get_zxs_details($mid){
		$zxsBaseData=array();
		$zxsRzData=array();
		$fields ='a.mid,a.mtype,a.userid,a.uname,a.sex,a.rank,a.email,a.scores,';
		$fields.='a.matt,a.spacesta,a.face,a.shouji,a.qq,a.myjie,b.birthday,b.good,a.jointime';
		$this->db->select($fields);
		$this->db->from( "dede_member as a" );
		$this->db->join( "dede_member_person as b","a.mid=b.mid" );
		$this->db->where(array("a.mid"=>$mid));
		$zxsBaseData = $this->db->get()->row_array();
		
		$fields='*';
		$this->db->select($fields);
		$this->db->from( "dede_member_dszxs" );
		$this->db->where(array("mid"=>$mid));
		$zxsRzData = $this->db->get()->row_array();
		
		$data=array(
				"base"=>$zxsBaseData,
				"rz"=>$zxsRzData

		);
		return $data;
	}
	
	public function get_member_details($str,$flag=true){

		$fields ='a.mid,a.mtype,a.userid,a.uname,a.sex,a.rank,a.email,a.scores,';
		$fields.='a.matt,a.spacesta,a.face,a.shouji,a.qq,b.birthday';
		$this->db->select($fields);
		$this->db->from( "dede_member as a" );
		$this->db->join ( "dede_member_person as b", "a.mid=b.mid" );
		if($flag){
			$this->db->like('a.userid', $str);
			$this->db->or_like('a.uname', $str);
			$this->db->or_like('a.email', $str);
			$this->db->or_like('a.shouji', $str);
		}

		else{
			$this->db->where(array("a.mid"=>$str));
		}
		$data = $this->db->get()->row_array();
		return $data;
	}
	
	public function update_user($dataArr,$where){
        $flag=false;
        $this->db->update("dede_member",$dataArr,$where);
        $r1=$this->db->affected_rows ();
        if(isset($dataArr["shouji"])){
            $dataArr["mobile"]=$dataArr["shouji"];
            unset($dataArr["shouji"]);
        }
        if(isset($dataArr["email"])){
            unset($dataArr["email"]);
        }
        $this->db->update("dede_member_person",$dataArr,$where);
        $r2=$this->db->affected_rows ();

        if($r1==1&&$r2==1){
            $flag=true;
        }
        return $flag;
	}
	
	public function add_user($dataArr){
		$insertId=-1;
        //首先向dede_member插入数据
		$insertId=$this->insert($dataArr);
		$dataPerson=array(
				"mid"=>$insertId,"onlynet"=>1,"sex"=>"男","uname"=>"",
				"qq"=>"","msn"=>"","tel"=>"","mobile"=>"","place"=>0,
				"oldplace"=>0,"birthday"=>"1980-01-01","star"=>1,
				"income"=>0,"education"=>0,"height"=>160,"bodytype"=>0,
				"blood"=>0,"vocation"=>0,"smoke"=>0,"marital"=>0,
				"house"=>0,"drink"=>0,"datingtype"=>0,"language"=>NULL,
				"nature"=>NULL,"lovemsg"=>"","address"=>"","uptime"=>0
                //,"good"=>0
		);
		$this->db->insert("dede_member_person",$dataPerson);
		$dataTj = array (
				"mid" => $insertId,"article" => '0',"album" => '0',
				"archives" => '0',"homecount" => '0',"pagecount" => '0',
				"feedback" => '0',"friend" => '0',"stow" => '0'
		);
		$this->db->insert("dede_member_tj",$dataTj);
		$dataSpace = array (
				"mid" => $insertId,"pagesize" => '10',"matt" => '0',
				"spacename" => $dataArr["shouji"]."的空间","spacelogo" => '',
				"spacestyle" => 'person',"sign" => '',"spacenews" => '' 
		);
		$this->db->insert("dede_member_space",$dataSpace);
		$dataFlink = array (
				"mid"=>$insertId, "title"=>'高安O2O', "url"=>'http://www.zhxpsy.com'
		);
		$this->db->insert("dede_member_flink",$dataFlink);
		return $insertId;
	}

	public function update_user_pwd($mid,$pwd){
        $flag = false;
	    $where = array(
	        "mid" => $mid
        );
        $dataArr = array(
            "pwd" =>$pwd
        );
        $this->db->update("dede_member",$dataArr,$where);
        $res = $this->db->affected_rows();
        if($res == 1){
            $flag = true;
        }
        return $flag;
    }

    public function get_old_password($mid){
        $whereArr = array(
            "mid" => $mid
        );
        $this->db->select("*");
        $this->db->from('dede_member');
        $this->db->where($whereArr);
        $data = $this->db->get()->row_array();
        return $data;
    }

    public function change_user_pwd($mid,$newPwd){
        $flag = false;
        $whereArr = array(
            "mid" => $mid
        );
        $dataArr = array(
            "pwd" =>$newPwd
        );
        $this->db->update("dede_member",$dataArr,$whereArr);
        $res = $this->db->affected_rows();
        if($res == 1){
            $flag = true;
        }
        return $flag;

    }

    /*
     *图片验证码 需要的参数是用户id
     */
    public function get_img_code(){
        $this->load->helper("captcha");
        $speed = '0123456789abcdefghijklmnopqrstuvwxyz';
        $img_url = 'http://192.168.0.101:8082/Dedecms/uploads/uploads/codeImg/';
        $wold = "";
        for ($i=0;$i<4;$i++){
            $wold .= $speed[mt_rand(0,strlen($speed)-1)];
        }
        $val = array(
            'word'      =>$wold,
            'img_path'  => '../uploads/codeImg/',
            'img_url'   => $img_url,
            'font_path' => '../api/system/fonts/texb.ttf',
            'img_width' => 150,
            'img_height'    => 30,
            'expiration'    => 20,
            'word_length'   => 4,
            'font_size' => 16,
            'img_id'    => 'Imageid',
//            'pool'      => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'colors'    => array(
                //215 75 40
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(139, 69, 19),
                'grid' => array(175, 238, 238)
            )
        );
        $cap = create_captcha($val);
//        var_dump($cap);
        $imgUrl = $val["img_url"].$cap["time"].".jpg";
        $dataArr = array(
            "captcha_id" => "",
            "captcha_time" => $cap["time"],
            "ip" => getIP(),
            "word" => $cap["word"]
        );
        $where = array(
            "ip" => getIP()
        );
        $select = "ip";
        $this->db->select($select);
        $this->db->from("img_code");
        $this->db->where($where);
        $resultArr = $this->db->get()->result_array();
        $size =  sizeof($resultArr);
        if(sizeof($resultArr) == 0){
            $insertId = $this->db->insert("img_code",$dataArr);
        }else{
            $this->db->delete("img_code",$where);
            $insertId = $this->db->insert("img_code",$dataArr);
        }
        $this->db->delete("img_code",$dataArr);

        $cap["image"] =$imgUrl;
        $arr = array(
            "word" => $cap["word"],
            "imgUrl" =>$imgUrl
        );
        return $arr;
    }






    //添加验证码到数据库里面
    /* public function add_code($dataArr){
         $this->db->insert("dede_member_person",$dataArr);
     }*/
}