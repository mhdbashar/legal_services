<?php

class Api extends CI_Controller{


    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
    }

    public function valid(){
        $key_app = $this->db->get('timesheets_settings')->row()->key_app;
        if($key_app != $this->input->get('key_app')){
            echo json_encode(array_to_object(['status' => false])); exit;
        }
    }

    public function index(){
        $this->valid();
        echo 'You are welcome';
    }

    public function area(){
        $this->db->select(['id', 'name']);
        $areas = $this->db->get(db_prefix() . 'timesheets_workplace')->result();
        $response = ['message' => 'success', 'area' => $areas];
        echo json_encode($response);
    }
}