<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__.'/REST_Controller.php';

class Projectdetail extends REST_Controller {

    function __construct()

    {
     // Construct the parent class
        parent::__construct();
        $this->load->model('Projectdetail_model');
        $this->load->model('Api_model');
   $this->load->model('misc_model');
        $this->load->model('projects_model');
        $this->load->model('proposals_model');
    }

public function data_get($value='')
{
    # code...
    $projectid=$this->get('projectid');
    $project_detailtype=$this->get('project_detailtype');
    $S_data = [];
    $data=$this->Projectdetail_model->get_projectdetail($projectid,$project_detailtype);
    $projectstatus=$this->projects_model->get_project_statuses();
   
                foreach ($data as $datas) {                   
                    $datas->description=strip_tags($datas->description);
                   $datas->addedfrom_name=$this->Api_model->get_addedfrom_name($datas->addedfrom);
                  $datas->projectstatusname=$this->getProjectStatusname($datas->status);      
                   $datas->clientid_name=$this->Api_model->get_customer_Name($datas->clientid);        
                   $datas->staffid_name=$this->Api_model->getStaffbyId($datas->staff_id);        
                   $datas->project_id_name=$this->Api_model->getProjectname($datas->project_id); 
                   $datas->extra_field=$this->Projectdetail_model->getExtraField($datas->id);
                    $datas->tags_field=$this->Projectdetail_model->getTagsField($datas->id);       
                   if($project_detailtype=='discussion'){
                   $datas->project_Discussion=$this->Projectdetail_model->getProjectDiscussion($datas->id);
     
                   $s2_data[]=$datas;       
                   }
                   if($project_detailtype=='files'){
                     $datas->filepath = $this->Api_model->GetPath($projectid,'customer');             
                    $S1_data[] = $datas;
                   }
                        
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
public function getProjectStatusname($id)
{
 // $id = 2;
   $projectstatus=$this->projects_model->get_project_statuses();
   foreach ($projectstatus as $key => $status) {
     if ($status['id'] == $id) {
       return $status;
     }
   }
   return false;
}

   

}

