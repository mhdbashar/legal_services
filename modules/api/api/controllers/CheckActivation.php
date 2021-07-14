<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__.'/REST_Controller.php';



class CheckActivation extends REST_Controller {
 function __construct()

    {

        // Construct the parent class

        parent::__construct();
    
        $this->load->model('CheckActivation_model');
     
    }

public function data_post($value='')
{
           $BaseUserURL=$this->input->post("BaseUserURL");
           $PurchaseCode=$this->input->post("PurchaseCode");
           $SecretKey=$this->input->post("SecretKey");

           $data=$this->CheckActivation_model->Check_Product($BaseUserURL,$PurchaseCode,$SecretKey);
           if($data==1){
 $data =  [
                'data' => $data,              
                'status' => 1,
                'message'=>'Allow',
                ];
            $this->response($data, REST_Controller::HTTP_OK); 
           }else{
 $data =  [
                'data' => $data,             
                'status' => 0,
                'message'=>'Not Allow'
                ];
            $this->response($data, REST_Controller::HTTP_NOT_FOUND); 
           }

}

}