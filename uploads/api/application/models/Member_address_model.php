<?php
/**
 * Created by PhpStorm.
 * User: TAB00
 * Date: 2017/1/20
 * Time: 14:40
 */
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Member_address_model extends MY_Model {
    public function __construct()
    {
        parent::__construct("dede_member_address");
    }

    public function set_member_address($userid ,$consignee,$address,$tel){
        $addArr = array(
            "aid" => "",
            "userid" => $userid,
            "consignee" =>$consignee,
            "address" =>$address,
            "tel" => $tel,
            "des" => ""
        );
        $data = $this->db->insert("dede_member_address",$addArr);
        $last = $this->db->last_query();
        return $data;
    }

    public function add_user_address($user_id,$consignee,$address,$city,$tel,$des){
        if($des == 1){
            $whereArr = array(
                'userid' => $user_id,
                'des' => $des
            );
            $this->db->select('*');
            $this->db->from("dede_member_address");
            $this->db->where($whereArr);
            $resdata = $this->db->get()->result_array();
            $addArr = array(
                'userid' => $user_id,
                'consignee' => $consignee,
                'address' => $address,
                "city" => $city,
                'tel' => $tel,
                'des' => $des
            );
            if(sizeof($resdata) == 0){
               $date = $this->db->insert("dede_member_address",$addArr);
            }else{
                $desArr = array(
                    'des' => '0'
                );
                $whereArr1 = array(
                    'userid' => $user_id,
                    'des' => $des
                );
                $this->db->update("dede_member_address",$desArr,$whereArr1);
                $addArr = array(
                    'userid' => $user_id,
                    'consignee' => $consignee,
                    'address' => $address,
                    "city" => $city,
                    'tel' => $tel,
                    'des' => $des
                );
                $date = $this->db->insert("dede_member_address",$addArr);
            }

        }else{
            $addArr = array(
                'userid' => $user_id,
                'consignee' => $consignee,
                'address' => $address,
                "city" => $city,
                'tel' => $tel,
                'des' => $des
            );
            $date = $this->db->insert("dede_member_address",$addArr);
        }
        $datet =  $date;
        return $datet;
    }

    public function delete_user_address($aid){
        $whereArr = array(
            "aid" => $aid
        );
        $this->db->delete("dede_member_address",$whereArr);
        $result =  $this->db->affected_rows ();
        return $result;
    }

    public function update_user_address($mid,$aid,$consignee,$address,$city,$tel,$des){
        $flag = false;
        $whereArr = array(
            "aid" => $aid
        );
        $dataArr = array(
            "consignee" => $consignee,
            "address" => $address,
            "city" => $city,
            "tel" => $tel,
            "des" => $des,
        );
        if($dataArr["des"] == 0){
            $this->db->update("dede_member_address",$dataArr,$whereArr);
            $res = $this->db->affected_rows();
            if($res == 1){
                $flag = true;
            }
        }else{
            $whereArr = array(
                "userid" => $mid,
                "des" => 1
            );
            $updataArr = array(
                "des" => 0
            );
            $this->db->update("dede_member_address",$updataArr,$whereArr);
            $res = $this->db->affected_rows();
            $dataArr1 = array(
                "consignee" => $consignee,
                "address" => $address,
                "city" => $city,
                "tel" => $tel,
                "des" => $des,
            );
            $whereArr1 = array(
                "aid" => $aid
            );
            $this->db->update("dede_member_address",$dataArr1,$whereArr1);
            $res2 = $this->db->affected_rows();
            if($res == 1 && $res2 == 1){
                $flag = true;
            }

        }


        return $flag;
    }


    public function get_user_address($mid){
        $whereArr = array(
            "userid" => $mid
        );
        $fields = '*';
        $this->db->select($fields);
        $this->db->from("dede_member_address");
        $this->db->where($whereArr);
        $this->db->order_by("aid desc");
        $data = $this->db->get()->result_array();
//        $data = $this->db->last_query();
        return $data;

    }


    public function change_defult_address($mid,$aid,$des){
        $flage = false;
        $whereArr = array(
            "userid" => $mid,
            "des" => 1
        );
        $this->db->select("*");
        $this->db->from("dede_member_address");
        $this->db->where($whereArr);
        $result = $this->db->get()->row_array();
        if(sizeof($result) != 0){
            $whereArr1 = array(
                "aid" => $result["aid"]
            );
            $dataArr1 = array(
                "des" => $des
            );
            $this->db->update("dede_member_address",$dataArr1,$whereArr1);
            $res = $this->db->affected_rows();
            $whereArr2 = array(
                "aid" => $aid
            );
            $dataArr2 = array(
                "des" => 1
            );
            $this->db->update("dede_member_address",$dataArr2,$whereArr2);
            $res1 = $this->db->affected_rows();
            if($res == 1 && $res1 == 1){
                $flage = true;
            }
        }else{
            $whereArr = array(
                "aid" => $result["aid"]
            );
            $dataArr = array(
                "des" => $des
            );
            $this->db->update("dede_member_address",$dataArr,$whereArr);
            $res = $this->db->affected_rows();
            if($res == 1 ){
                $flage = true;
            }
        }
        return $flage;

    }




}