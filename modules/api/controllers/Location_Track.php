<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__.'/REST_Controller.php';



class Location_Track extends REST_Controller {
 function __construct()

    {

        // Construct the parent class

        parent::__construct();
        $this->load->model('Location_model');
      
    }


public function data_get()
{
 
    $filters = [
        'staffid' => $this->input->get("staffid"),
        'searchbydate' => $this->input->get("searchbydate"),
        ];
    $output=$this->Location_model->getAllData($filters);
          
    if($output > 0 && !empty($output)){
                $s_data = array(
                    'data'=>$output,
                'status' => TRUE,
                'message' => 'Location add successful.'
                );
                $this->response($s_data, REST_Controller::HTTP_OK);
            }else{
                // error
                $message = array(
                'status' => FALSE,
                'message' => 'Location fail.'
                );
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
}

    public function data_post()

    {
              $staffid=$this->input->post("staffid");
              $lat=$this->input->post("lat");
              $log=$this->input->post("log");
              $currentdate=date('Y-m-d H:i:s');

        if($lat!=0 && !empty($lat) && $log!=0 && !empty($log) && $staffid!=0 && !empty($staffid)){
            $locationdata = array('f_staffid' => $staffid,
                                    'lat'=>$lat,
                                    'log'=>$log,
                                    'Currentdate'=>$currentdate );
        $output=$this->Location_model->insertlocation($locationdata);
        if($output > 0 && !empty($output)){
                $s_data = array(
                'status' => TRUE,
                'message' => 'Location add successful.'
                );
                $this->response($s_data, REST_Controller::HTTP_OK);
            }else{
                // error
                $message = array(
                'status' => FALSE,
                'message' => 'Location fail.'
                );
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }else{
                $message = array(
                'status' => FALSE,
                'message' => 'Location fail.'
                );
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
        
    

    }





}

