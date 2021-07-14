<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__.'/REST_Controller.php';
/**
 * 
 */
class Forgetpassword extends REST_Controller
{
	
	function __construct()
	{
		# code...
		parent::__construct();
        $this->load->model('Forgetpassword_model');
	}

	
	public function data_post()
	{
		$userid=$this->input->post('userid');
		$newpassword=$this->input->post('newpassword');
		
		$s_data=[];

			
			$data=$this->Forgetpassword_model->password_update($userid,$newpassword);
			if($data==1){
				$s_data =  [
 		   				
          				'message' =>'successful update',
            			'status' => 1,
             			];
       			 $this->response($s_data, REST_Controller::HTTP_OK);
			}else{
				$s_data =  [
 		   				
           				 'message' =>'error',
           				 'status' => 0,
          			   ];
       			 $this->response($s_data, REST_Controller::HTTP_NOT_FOUND);
			}

		
	}
}

?>