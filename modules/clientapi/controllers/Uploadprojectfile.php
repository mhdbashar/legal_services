<?php

defined('BASEPATH') or exit('No direct script access allowed');
require __DIR__.'/REST_Controller.php';

class Uploadprojectfile extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
         $this->load->model('Sendnotification');
       
    }

    
  public function data_post($value='')
  {
   $project_id=$this->input->post("project_id");
   $staff_id=$this->input->post("staff_id");
   $contact_id=$this->input->post("contact_id");

       
   $insertrecord=    handle_project_file_uploads($project_id,$staff_id,$contact_id);
  if($insertrecord>0){    
        $this->db->select('staff_id');
        $this->db->where('project_id', $project_id);
        $q = $this->db->get('tblproject_members');
        $data = $q->result();
            foreach ($data as $key ) {
            $tokenid=$this->Api_model->getToken($key->staff_id);
            $tokenkey=$this->Api_model->getKey($key->staff_id);
             if($tokenid){
            $q=$this->Sendnotification->send_fcm('#-'.$insertrecord.'File upload on #'.$project_id,$tokenid,'Project File',$tokenkey);                // success
            }
            }
            }

    if($insertrecord>0){
                $message = array(

                'status' => TRUE,

                'message' => 'File Upload Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);
            }else{

                $message = array(

                'status' => FALSE,

                'message' => 'File Upload Errro.'

                );

                $this->response($message, REST_Controller::HTTP_OK);
            }

  }
    
}
