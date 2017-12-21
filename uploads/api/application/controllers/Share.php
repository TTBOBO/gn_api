<?php

/**
 * Created by PhpStorm.
 * User: TAB00
 * Date: 2017/3/18
 * Time: 17:10
 */
class Share extends CI_Controller
{
    public function index(){
        $id = $_GET["id"];
//        $this
        $whereArr = array(
            "id" => $id
        );
        $this->load->model("show_model");
        $data = $this->show_model->get_page_content($whereArr);
        $arr = array(
            "data" => $data
        );
        $this->load->view("share",$arr);
    }
}