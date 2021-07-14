<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__.'/REST_Controller.php';
/**
 * 
 */
class Clientprofile extends REST_Controller
{
	
	function __construct()
	{
		# code...
		parent::__construct();
        $this->load->model('Clientprofile_model');
	}

	public function data_get()
	{
		$id=$this->get('id');
		$type=$this->get('type');
		
		$s_data=[];
		if($id!=''){
			$data=$this->Clientprofile_model->getClientprofile($id,$type);
			foreach ($data as $datas) {
                    $datas->Country_name = $this->Clientprofile_model->getCountrybyId($datas->country);
                   
					$data = $datas;

                }
			if($data){
				$s_data =  [
 		   				'data' => $data,
          				'message' =>'success',
            			'status' => 1,
             			];
       			 $this->response($s_data, REST_Controller::HTTP_OK);
			}else{
				$s_data =  [
 		   				'data' => array(),
           				 'message' =>'error',
           				 'status' => 0,
          			   ];
       			 $this->response($s_data, REST_Controller::HTTP_NOT_FOUND);
			}

		}else{
 		$s_data =  [
 		    'data' => array(),
            'message' =>'pass parameter id ',
            'status' => 0,
             ];
        $this->response($s_data, REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function data_post()
	{
		$userid=$this->input->post('userid');
		 $filters = [
       'firstname'=>$this->input->post('firstname')?$this->input->post('firstname'):NULL,
       'lastname'=>$this->input->post('lastname')?$this->input->post('lastname'):NULL,
       'email'=>$this->input->post('email')?$this->input->post('email'):NULL,
       'phonenumber'=>$this->input->post('phonenumber')?$this->input->post('phonenumber'):NULL,
       
        ];
		
		$s_data=[];

		if($filters['firstname']!='' || $filters['lastname']!='' || $filters['email']!='' || $filters['phonenumber']!=''){
			if($filters['firstname']!=''){
					$arrayName['firstname'] = $filters['firstname'];
			}
			if($filters['lastname']!=''){
					$arrayName['lastname'] = $filters['lastname'];
			}
			if($filters['email']!=''){
					$arrayName['email'] = $filters['email'];
			}
			if($filters['phonenumber']!=''){
					$arrayName['phonenumber'] = $filters['phonenumber'];
			}	
			         
			$data=$this->Clientprofile_model->update_clientdata($userid,$arrayName);
			handle_contact_profile_image_upload($data);
			
			if($data>0){
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

		}else{
 		$s_data =  [
 		    
            'message' =>'no parameter pass to update ',
            'status' => 0,
             ];
        $this->response($s_data, REST_Controller::HTTP_NOT_FOUND);
		}
	}
}

?>