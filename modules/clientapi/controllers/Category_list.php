<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__.'/REST_Controller.php';
/**
 * 
 */
class Category_list extends REST_Controller
{
	
	function __construct()
	{
		# code...
		parent::__construct();
        $this->load->model('Categorylist_model');
	}
private $statuses = [
        UNPAID,
        PAID,
        PARTIALLY,
        OVERDUE,
        CANCELLED,
        DRAFT,
    ];
	public function data_get()
	{
		$id=$this->get('id');
		$category=$this->get('category');
		$s_data=[];
		if($id!='' || $category!=''){
			$data_category=$this->Categorylist_model->getCategorylist($id,$category);
			if($category=='status' || $category=='department' || $category=='priority'){
				$data = $data_category;
			}else{
			 foreach ($data_category as $info) {

                    $info->description = strip_tags($info->description);
                    $info->currency_name = $this->Categorylist_model->getCurrencybyId($info->currency);
                    if($category=='invoice'){
                    	
					         	$info->status_name = $this->statuses[$info->status -1];
                    }elseif($category=='proposal'){
                      $info->content=strip_tags($info->content);
                    $info->status_name=format_proposal_status($info->status, '', false);
                    }elseif($category=='estimate'){
                      $info->status_name=format_estimate_status($info->status, '', false);
                       $info->client_name = $this->Categorylist_model->getclientbyId($info->clientid);
                    }else{
                    $info->status_name = $this->Categorylist_model->getStatusbyId($info->status);
                    $info->client_name = $this->Categorylist_model->getclientbyId($info->client);
                    }
                    

                    $info->addedfrom_name = $this->Categorylist_model->getAddedfrombyId($info->addedfrom);
                    $info->contract_type_name = $this->Categorylist_model->getcontract_typebyId($info->contract_type);
                    $info->assigned_name = $this->Categorylist_model->getassignedbyId($info->assigned);
                  
					$data = $data_category;

                }
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
            'message' =>'pass parameter id and category -invoice / project / contract / proposal / estimate / departmet (without id) / priority (without id)',
            'status' => 0,
             ];
        $this->response($s_data, REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function data_post()
	{
		# code...
	}
}

?>