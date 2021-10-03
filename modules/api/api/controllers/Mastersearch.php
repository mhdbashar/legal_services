<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__.'/REST_Controller.php';



class Mastersearch extends REST_Controller {
 function __construct()

    {

        // Construct the parent class

        parent::__construct();
        $this->load->model('Mastersearch_model');
        
    }



   

    public function data_post()

    {

$q=$this->input->post("search");
$staffid=$this->input->post("staffid");

$output=$this->Mastersearch_model->perform_search($q,$staffid);
          
            if($output > 0 && !empty($output)){

                // success

       
                $s_data = array(

'data'=>$output,
                'status' => TRUE,

                'message' => 'Search successful.'

                );

                $this->response($s_data, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

'data'=>array(),
                'status' => FALSE,

                'message' => 'Search fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        

    }





}

