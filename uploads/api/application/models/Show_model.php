<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Created by PhpStorm.
 * User: TAB00
 * Date: 2017/3/18
 * Time: 17:16
 */
class Show_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct("dede_archives");
    }

    private function __get__content($whereArr){
        $fields = "a.id as id,a.typeid as typeid,a.typeid2 as typeid2,a.sortrank,a.flag,a.arcrank";
        $fields .= ",a.click,a.title,a.writer,a.source,a.pubdate,a.weight,c.body";
        $this->db->select($fields);
        $this->db->from("dede_archives as a");
        $this->db->join("dede_addonimages as c","a.id = c.aid");
        $this->db->where($whereArr);
        $this->db->order_by("a.id desc");
        $this->db->limit(1);
        $data = $this->db->get()->row_array();
        return $data;
    }
    public function get_page_content($whereArr){
        $data = $this->__get__content($whereArr);
        return $data;
    }


}