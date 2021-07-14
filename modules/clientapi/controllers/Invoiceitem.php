<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__.'/REST_Controller.php';

class Invoiceitem extends REST_Controller {

    function __construct()

    {
     // Construct the parent class
        parent::__construct();
        $this->load->model('Invoiceitem_model');
        $this->load->model('Api_model');

    }

public function data_get($value='')
{
    # code...
    $invoiceid=$this->get('invoiceid');
    $S_data = [];

    $data=$this->Invoiceitem_model->get_proposalinvoice($invoiceid);
                foreach ($data as $datas) {
                   
                        $datas->long_description=strip_tags($datas->long_description);
                    $datas->Invoice_name = $this->Invoiceitem_model->get_Invoice_name($datas->rel_id);
                   
               
                   $sl_data[] = $datas;
                }
                  $datapay = $this->Invoiceitem_model->get_Invoice_paidamount($invoiceid);
            if ($data)
            {
                 $S_data =  [
                'data' => $data,
                'payment'=>$datapay,
                'status' => 1,
                'message'=>'success'
                ];
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
             $S_data =  [
                'data' => $data,
                 'payment'=>array(),
                'status' => 0,
                'message'=>'record not found'
               
                ];
          
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
   
}

   

}

