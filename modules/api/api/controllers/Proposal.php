<?php



defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__.'/REST_Controller.php';

/**
 * 
 */
class Proposal extends REST_Controller
{
	
	function __construct()
	{
		# code...
		  parent::__construct();
   
        $this->load->model('Proposal_model');
	}


    public function data_get($id = '')

    {
    	$rel_id = $this->get('rel_id');
    	$rel_type=$this->get('rel_type');
   //  	$check_permission = $this->Api_model->check_permission('leads',$staff_id,'view');
 		// if($check_permission == 1){
  			if ($info =$this->Proposal_model->get_Proposal($rel_id,$rel_type)) {
				$sl_data = [];
                $sl_data = $info;
                $data =  [
                'data' => $sl_data,
                'status' => 1,
                'message'=>'Success'
                ];
				$this->response($data, REST_Controller::HTTP_OK);
  			}else{
  				$this->response([

                'status' => FALSE,

                'message' => 'No data were found'

            ], REST_Controller::HTTP_NOT_FOUND); 
  			}
		// }
    	  

    }
}