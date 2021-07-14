<?php



defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__.'/REST_Controller.php';


/**
 * 
 */
class Dashboard extends REST_Controller
{
	
	function __construct()
	{
		# code...
  		parent::__construct();
 	 	$this->load->model('Dashboard_model');
	}

	public function Data_get()
	{
		$staff_id=$this->get('staff_id');
	$data = $this->Dashboard_model->Count_leadbystatus($staff_id);
    
    $lead_chart=$this->Dashboard_model->leads_status_stats($staff_id);    
    foreach ($lead_chart as $key => $value) {
            
        for ($i=0; $i < sizeof($value['labels']); $i++) { 
                 $lead_chartdata[] = array('name' =>$value['labels'][$i] ,
                                    'color'=>$value['backgroundColor'][$i],
                                    'total'=>$value['data'][$i],
                                    'status'=>$value['statusLink'][$i] );
        }
               
    }
           
    $project_chart=$this->Dashboard_model->projects_status_stats($staff_id);
    foreach ($project_chart as $key => $value) {
            
        for ($i=0; $i < sizeof($value['labels']); $i++) { 
                 $project_chartdata[] = array('name' =>$value['labels'][$i] ,
                                    'color'=>$value['backgroundColor'][$i],
                                    'total'=>$value['data'][$i],
                                    'status'=>$value['statusLink'][$i] );
        }
               
    }
    $ticketstatus_chart=$this->Dashboard_model->tickets_awaiting_reply_by_status($staff_id);
        foreach ($ticketstatus_chart as $key => $value) {
            
        for ($i=0; $i < sizeof($value['labels']); $i++) { 
                 $ticketstatus_chartdata[] = array('name' =>$value['labels'][$i] ,
                                    'color'=>$value['backgroundColor'][$i],
                                    'total'=>(string)$value['data'][$i],
                                    'status'=>$value['statusLink'][$i] );
        }
               
    }
    $ticketdepartment_chart=$this->Dashboard_model->tickets_awaiting_reply_by_department($staff_id);
     foreach ($ticketdepartment_chart as $key => $value) {
            
        for ($i=0; $i < sizeof($value['labels']); $i++) { 
                 $ticketdepartment_chartdata[] = array('name' =>$value['labels'][$i] ,
                                    'color'=>$value['backgroundColor'][$i],
                                    'total'=>(string)$value['data'][$i],
                                    'status'=>$value['statusLink'][$i] );
        }
               
    }
    $total_leads=$this->Dashboard_model->total_leads($staff_id);
    $total_customer=$this->Dashboard_model->total_customer($staff_id);
    $total_project=$this->Dashboard_model->total_project($staff_id);
		 $S_data = [];
        if ($data || $total_leads || $total_customer || $total_project)
        {
             $S_data =  [
                'data' => $data,
                'lead_chart'=>$lead_chartdata,
                'project_chart'=>$project_chartdata,
                'ticketstatus_chart'=>$ticketstatus_chartdata,
                'ticketdepartment_chart'=>$ticketdepartment_chartdata,
               'total_leads'=>$total_leads,
               'total_customer'=>$total_customer,
               'total_project'=>$total_project,
                'status' => 1,
                'message'=>'success'
              
                ];
           
            $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
             $S_data =  [
                'data' => $data,
                'total_leads'=>$total_leads,
               'total_customer'=>$total_customer,
               'total_project'=>$total_project,
                'status' => 0,
                'message'=>'record not found'
               
                ];
          
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
		# code...
	}
}