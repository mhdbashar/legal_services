<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__.'/REST_Controller.php';

class Customers extends REST_Controller {

    function __construct()

    {
     // Construct the parent class
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->model('Api_model');

    }

public function customerpayment_get($value='')
{
    # code...
    $invoiceid=$this->get('invoiceid');
    $S_data = [];
    $data=$this->Customer_model->get_proposalinvoice($invoiceid);
                foreach ($data as $datas) {
                   
                        $datas->long_description=strip_tags($datas->long_description);
                    $datas->Invoice_name = $this->Customer_model->get_Invoice_name($datas->rel_id);
               
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
   
}

public function Customfield_get()
{
	 
 		$filters = [
        'type' => $this->get('type'),
        'userid' => $this->get('userid'),
        ];
		$S_data=[];
		$output=$this->Customer_model->Customer_customfield_get($filters);
	
		if($output){
		  $S_data =  [
                'data' => $output,
                'status' => 1,
                'message'=>'success'
                ];
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (20
		}else{
		  $S_data =  [
                'data' => $output,
                'status' => 1,
                'message'=>'success'
                ];
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (20
	}
}
    public function data_get($id = '')

    {

        $staff_id=$this->get('staff_id');
       
        $filters = [
        'staff_id' => $staff_id,  
        'start' => $this->get('start') && is_numeric($this->get('start')) ? $this->get('start') : 1,
        'limit' => $this->get('limit') && is_numeric($this->get('limit')) ? $this->get('limit') : 10,   
        'order_by' => $this->get('order_by') ? explode(',', $this->get('order_by')) : ['id', 'decs'],
        ];
        // $check_permission = $this->Api_model->check_permission('customers',$staff_id,'view');
        // if ($check_permission == 1) {
                $data = $this->Customer_model->Count_Customer();
                $data1=$this->Customer_model->Customer_List($filters);
                
                 $S1_data = [];
        foreach ($data1 as $datacustomer) {
            $datacustomer->address = strip_tags($datacustomer->address);
            $datacustomer->billing_street = strip_tags($datacustomer->billing_street);
            $datacustomer->shipping_street = strip_tags($datacustomer->shipping_street);
            $datacustomer->primary_contact_name = $this->Customer_model->getPrimarynamebyId($datacustomer->userid);
            $datacustomer->primary_email = $this->Customer_model->getPrimaryemailbyId($datacustomer->userid);
            $datacustomer->country_name = $this->Api_model->get_country_name($datacustomer->country);
            $datacustomer->billing_country_name = $this->Api_model->get_country_name($datacustomer->billing_country);
            $datacustomer->shipping_country_name = $this->Api_model->get_country_name($datacustomer->shipping_country);
            $datacustomer->default_currency_name = $this->Api_model->get_currency_name($datacustomer->default_currency);
            $datacustomer->Customer_customfield=$this->Customer_model->Customer_customfield($datacustomer->userid);
             foreach ($datacustomer->Customer_customfield as $customer) {
 $customer->value = strip_tags($customer->value);
             }
            $S1_data[] = $datacustomer;
        }
        $data['customer_data']=$S1_data;

               
                if ($data)
                {
                    $S_data =  [
                        'data' => $data,
                        
                        'status' => 1,
                        'message'=>'success',
                        'start' => (int) $filters['start'],
                        'limit'=>(int) $filters['limit'],
                        'total_data'=>$this->Customer_model->Total_Customer(),
                    ];   
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $S_data =  [
                    'data' => $data,
                    'status' => 0,
                    'message'=>'record not found',
                    'start' => (int) $filters['start'],
                    'limit'=>(int) $filters['limit'],
                    'total_data'=>0,
                ];
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
       
        

    }


public function Check_get()
{
     $email=$this->get('email');
     $data=$this->Customer_model->getCheckemail($email);
         if ($data==0)
                {
                    $S_data =  [
                       
                        'status' => 1,
                        'message'=>'success',
                        
                    ];   
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $S_data =  [
                   
                    'status' => 0,
                    'message'=>'already exist',
                    
                ];
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
}

   
    public function data_post()

    {

        
           
       $inputtype=$this->input->post('inputtype',TRUE);
       $isupdate=$this->input->post('isupdate',TRUE);
               if ($this->input->post()){
                   
                   if($inputtype!=''){
                    if($inputtype=='profile'){
                    	
                    	
                         $insert_data = [

                            'company' => $this->input->post('company', TRUE),
                            'vat' => $this->Api_model->value($this->input->post('vat', TRUE)),
                            'phonenumber' => $this->Api_model->value($this->input->post('phonenumber', TRUE)),
                            'website' => $this->Api_model->value($this->input->post('website', TRUE)),
                            'default_currency' => $this->Api_model->value($this->input->post('default_currency', TRUE)),
                            'default_language' => $this->Api_model->value($this->input->post('default_language', TRUE)),
                            'address' => $this->Api_model->value($this->input->post('address', TRUE)),
                            'city' => $this->Api_model->value($this->input->post('city', TRUE)),
                            'state' => $this->Api_model->value($this->input->post('state', TRUE)),
                            'zip' => $this->Api_model->value($this->input->post('zip', TRUE)),
                            'country' => $this->Api_model->value($this->input->post('country', TRUE)),
                            'datecreated'=> date('Y-m-d H:i:s'),
                            'active'=>'1',
                            'registration_confirmed'=>'1',
                            'addedfrom'=>$this->input->post('addedfrom', TRUE),
                        ];
						if($isupdate==true){
                    	$userid=$this->input->post('userid');	
                    	$output=$this->Customer_model->Insert_CustomerDetail($userid,$inputtype,$insert_data);
                    	}else{
						$output=$this->Customer_model->Insert_CustomerDetail('',$inputtype,$insert_data);
                    	}
                    
                    }
                   
                    if($inputtype=='fielddata'){
                        $userid=$this->input->post('userid');
                    	$customData=$this->input->post('customData');
                        $customer_data = json_decode($customData);
                        if($isupdate==true){
                        $output= $this->Customer_model->Insert_CustomerDetail($userid,$inputtype,$customData);
                        }else{
                        $output= $this->Customer_model->Insert_CustomerDetail('',$inputtype,$customData);     
                        }
                       
                    
               
                     
                   
                    }
                    if($inputtype=='address'){
                        
                        $userid=$this->input->post('userid');
                        $insert_data = [

                            'billing_street' => $this->Api_model->value($this->input->post('billing_street', TRUE)),
                            'billing_city' => $this->Api_model->value($this->input->post('billing_city', TRUE)),
                            'billing_state' => $this->Api_model->value($this->input->post('billing_state', TRUE)),
                            'billing_zip' => $this->Api_model->value($this->input->post('billing_zip', TRUE)),
                            'billing_country' => $this->Api_model->value($this->input->post('billing_country', TRUE)),

                            'shipping_street' => $this->Api_model->value($this->input->post('shipping_street', TRUE)),
                            'shipping_city' => $this->Api_model->value($this->input->post('shipping_city', TRUE)),
                            'shipping_state' => $this->Api_model->value($this->input->post('shipping_state', TRUE)),
                            'shipping_zip' => $this->Api_model->value($this->input->post('shipping_zip', TRUE)),
                            'shipping_country' => $this->Api_model->value($this->input->post('shipping_country', TRUE))
                              ];
                               $output=$this->Customer_model->Insert_CustomerDetail($userid,$inputtype,$insert_data);
                    }
                    if($inputtype=='contact'){
                        $customer_id=$this->input->post('customer_id');
                        $insert_data = [
                            'firstname' => $this->input->post('firstname', TRUE),
                            'lastname' => $this->Api_model->value($this->input->post('lastname', TRUE)),
                            'email' => $this->Api_model->value($this->input->post('email', TRUE)),
                            'phonenumber' => $this->Api_model->value($this->input->post('phonenumber', TRUE)),
                            'password' => $this->Api_model->value($this->input->post('password', TRUE)),
                            'invoice_emails' => $this->Api_model->value($this->input->post('invoice_emails', TRUE)),
                            'estimate_emails' => $this->Api_model->value($this->input->post('estimate_emails', TRUE)),
                            'credit_note_emails' => $this->Api_model->value($this->input->post('credit_note_emails', TRUE)),
                            'contract_emails' => $this->Api_model->value($this->input->post('contract_emails', TRUE)),
                            'task_emails' => $this->Api_model->value($this->input->post('task_emails', TRUE)),
                            'project_emails' => $this->Api_model->value($this->input->post('project_emails', TRUE)),
                            'ticket_emails' => $this->Api_model->value($this->input->post('ticket_emails', TRUE)),
                            'is_primary' =>'1',
                           
                            'active'=>'1',
                            
                            
                        ];
 						$data=$this->Customer_model->getCheckemail($insert_data['email']);
         				if ($data==1){
         		 		$S_data =  [
                   
                    	'status' => 0,
                    	'message'=>'already exist',
                    
            	    	];
            			$this->response($S_data, REST_Controller::HTTP_NOT_FOUND);
         				}else{
         	      		$output=$this->Customer_model->add_contact($insert_data, $customer_id, $not_manual_request = false);
         				}
            
            		}
                   
                  
                  if ($output!=0)
                    {
                    $S_data =  [
                        
                        'id'=>$output,
                        'status' => 1,
                        'message'=>$isupdate==true?'update success':'insert success',
                        
                    ];   
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $S_data =  [
                    	  'id'=>0,
                    'status' => 0,
                    'message'=>'record not found',
                    
                ];
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
        }else{
         $S_data =  [
                    'status' => 0,
                    'message'=>'Pass inputtype - profile / address / field',
                    
                ];
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); 
          }
               }else{
                    $message = array(
                        'status' => FALSE,
                        'message' => 'Error in api.'
                    );
                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

               }

    }





    /**

     * @api {delete} api/delete/customers/:id Delete a Customer

     * @apiName DeleteCustomer

     * @apiGroup Customer

     *

     * @apiHeader {String} Authorization Basic Access Authentication token.

     *

     * @apiParam {Number} id Customer unique ID.

     *

     * @apiSuccess {String} status Request status.

     * @apiSuccess {String} message Customer Delete Successful.

     *

     * @apiSuccessExample Success-Response:

     *     HTTP/1.1 200 OK

     *     {

     *       "status": true,

     *       "message": "Customer Delete Successful."

     *     }

     *

     * @apiError {Boolean} status Request status.

     * @apiError {String} message Customer Delete Fail.

     *

     * @apiErrorExample Error-Response:

     *     HTTP/1.1 404 Not Found

     *     {

     *       "status": false,

     *       "message": "Customer Delete Fail."

     *     }

     */

    public function data_delete($id = '')

    { 

        $id = $this->security->xss_clean($id);

        if(empty($id) && !is_numeric($id))

        {

            $message = array(

            'status' => FALSE,

            'message' => 'Invalid Customer ID'

        );

        $this->response($message, REST_Controller::HTTP_NOT_FOUND);

        }

        else

        {

            // delete data

            $this->load->model('clients_model');

            $output = $this->clients_model->delete($id);

            if($output === TRUE){

                // success

                $message = array(

                'status' => TRUE,

                'message' => 'Customer Delete Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Customer Delete Fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        }

    }





    /**

     * @api {put} api/customers/:id Update a Customer

     * @apiName PutCustomer

     * @apiGroup Customer

     *

     * @apiHeader {String} Authorization Basic Access Authentication token.

     *

     * @apiParam {String} company               Mandatory Customer company.

     * @apiParam {String} [vat]                 Optional Vat.

     * @apiParam {String} [phonenumber]         Optional Customer Phone.

     * @apiParam {String} [website]             Optional Customer Website.

     * @apiParam {Number[]} [groups_in]         Optional Customer groups.

     * @apiParam {String} [default_language]    Optional Customer Default Language.

     * @apiParam {String} [default_currency]    Optional default currency.

     * @apiParam {String} [address]             Optional Customer address.

     * @apiParam {String} [city]                Optional Customer City.

     * @apiParam {String} [state]               Optional Customer state.

     * @apiParam {String} [zip]                 Optional Zip Code.

     * @apiParam {String} [country]             Optional country.

     * @apiParam {String} [billing_street]      Optional Billing Address: Street.

     * @apiParam {String} [billing_city]        Optional Billing Address: City.

     * @apiParam {Number} [billing_state]       Optional Billing Address: State.

     * @apiParam {String} [billing_zip]         Optional Billing Address: Zip.

     * @apiParam {String} [billing_country]     Optional Billing Address: Country.

     * @apiParam {String} [shipping_street]     Optional Shipping Address: Street.

     * @apiParam {String} [shipping_city]       Optional Shipping Address: City.

     * @apiParam {String} [shipping_state]      Optional Shipping Address: State.

     * @apiParam {String} [shipping_zip]        Optional Shipping Address: Zip.

     * @apiParam {String} [shipping_country]    Optional Shipping Address: Country.

     *

     * @apiParamExample {json} Request-Example:

     *  {

     *     "company": "Công ty A",

     *     "vat": "",

     *     "phonenumber": "0123456789",

     *     "website": "",

     *     "default_language": "",

     *     "default_currency": "0",

     *     "country": "243",

     *     "city": "TP London",

     *     "zip": "700000",

     *     "state": "Quận 12",

     *     "address": "hẻm 71, số 34\/3 Đường TA 16, Phường Thới An, Quận 12",

     *     "billing_street": "hẻm 71, số 34\/3 Đường TA 16, Phường Thới An, Quận 12",

     *     "billing_city": "TP London",

     *     "billing_state": "Quận 12",

     *     "billing_zip": "700000",

     *     "billing_country": "243",

     *     "shipping_street": "",

     *     "shipping_city": "",

     *     "shipping_state": "",

     *     "shipping_zip": "",

     *     "shipping_country": "0"

     *   }

     *

     * @apiSuccess {Boolean} status Request status.

     * @apiSuccess {String} message Customer Update Successful.

     *

     * @apiSuccessExample Success-Response:

     *     HTTP/1.1 200 OK

     *     {

     *       "status": true,

     *       "message": "Customer Update Successful."

     *     }

     *

     * @apiError {Boolean} status Request status.

     * @apiError {String} message Customer Update Fail.

     *

     * @apiErrorExample Error-Response:

     *     HTTP/1.1 404 Not Found

     *     {

     *       "status": false,

     *       "message": "Customer Update Fail."

     *     }

     */

    public function data_put($id = '')

    {

        $_POST = json_decode($this->security->xss_clean(file_get_contents("php://input")), true);

        $this->form_validation->set_data($_POST);

        

        if(empty($id) && !is_numeric($id))

        {

            $message = array(

            'status' => FALSE,

            'message' => 'Invalid Customers ID'

            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);

        }

        else

        {



            $update_data = $this->input->post();

            // update data

            $this->load->model('clients_model');

            $output = $this->clients_model->update($update_data, $id);

            if($output > 0 && !empty($output)){

                // success

                $message = array(

                'status' => TRUE,

                'message' => 'Customers Update Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Customers Update Fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        }

    }

}

