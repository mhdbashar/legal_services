<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__.'/REST_Controller.php';
/**
 * 
 */
class Support extends REST_Controller
{
	
	function __construct()
	{
		# code...
		parent::__construct();
        $this->load->model('Support_model');
	}

	public function data_get()
	{
		$id=$this->get('id');
		$status=$this->get('status');
		$project_id=$this->get('project_id');
		       
		$s_data=[];
		if($id!='' || $status!=''){
			$datacount=$this->Support_model->getSupportlistCount($id);

			$supports=$this->Support_model->getSupportlist($id,$status,$project_id);

			 foreach ($supports as $support) {
			 	    $support->message = strip_tags($support->message);
                
                    $support->department_name = $this->Support_model->getDepartmentbyId($support->department);
                    $support->priority_name = $this->Support_model->getPrioritybyId($support->priority);
                    $support->status_name = $this->Support_model->getStatusbyId($support->status);
                    $support->project_id_name = $this->Support_model->getProjectbyId($support->project_id);
                      $support->submitter = $this->Api_model->getStaffbyId($support->admin);
                    $support->contact_name = $this->Support_model->get_contact_Name($support->contactid);
					$data = $supports;

                }
			if($data){
				$s_data =  [
 		   				'data' => $data,
 		   				'status_count'=>$datacount,
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
            'message' =>'pass parameter id and status',
            'status' => 0,
             ];
        $this->response($s_data, REST_Controller::HTTP_NOT_FOUND);
		}
	}
}

?>