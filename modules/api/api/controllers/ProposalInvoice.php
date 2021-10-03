<?php



defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__.'/REST_Controller.php';


/**
 * 
 */
class ProposalInvoice extends REST_Controller
{
	
	function __construct()
	{
		# code...
  		parent::__construct();
            $this->load->model('Api_model');
 	 	$this->load->model('ProposalInvoice_model');
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
	# code...
	$type=$this->get('type');
    $invoiceid=$this->get('invoiceid');
	$staff_id=$this->get('staff_id');
	$ispaid=$this->get('ispaid');
	$check_permission = $this->Api_model->check_permission($type,$staff_id,'view');
    $S_data = [];
    if($check_permission==1){
            $data=$this->ProposalInvoice_model->get_proposalinvoice($staff_id,$type,$invoiceid,$ispaid);
                foreach ($data as $datas) {
                    if($type=='invoices'){
                    $datas->terms = strip_tags($datas->terms);   
                    $datas->status_name = $this->statuses[$datas->status -1]; 
                    }elseif($type=='proposals'){
                          $datas->content=strip_tags($datas->content);

                    $datas->status_name=format_proposal_status($datas->status, '', false);
                    }else{
                    $datas->status_name = $this->Api_model->get_task_status($datas->status);    
                    }
                    
                    $datas->billing_countryname = $this->Api_model->get_country_name($datas->billing_country);
                    $datas->shipping_countryname = $this->Api_model->get_country_name($datas->shipping_country);
                    $datas->currency_name = $this->ProposalInvoice_model->get_currency_name($datas->currency);
                    $datas->invoicepayment=$this->ProposalInvoice_model->get_paymentinvoice($datas->id);
                    $datas->duepayment=(string) ($datas->total -   $datas->invoicepayment);

                    if($type=='payment'){
                        $datas->long_description=strip_tags($datas->long_description);
                    $datas->Invoice_name = $this->ProposalInvoice_model->get_Invoice_name($datas->invoiceid);
                }else{
                    $datas->Invoice_name = $this->ProposalInvoice_model->get_Invoice_name($datas->clientid);
                }
                    $datas->paymentmode_name = $this->ProposalInvoice_model->get_paymentmode_name($datas->paymentmode);
                   $sl_data[] = $datas;
                }
            if ($data)
            {
                 $S_data =  [
                'data' => $data,
                'status' => 1,
                'message'=>'success'
                ];
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
             $S_data =  [
                'data' => $data,
               
                'status' => 0,
                'message'=>'record not found'
               
                ];
          
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
    }else{
         $S_data =  [
                'data' => array(),

              
                'status' => 0,
                'message'=>'No permission'
              
                ];
           
            $this->response($S_data, REST_Controller::HTTP_OK); // 
    }
   
		# code
	
}

}