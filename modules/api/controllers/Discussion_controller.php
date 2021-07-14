<?php

defined('BASEPATH') OR exit('No direct script access allowed');



// This can be removed if you use __autoload() in config.php OR use Modular Extensions

/** @noinspection PhpIncludeInspection */

require __DIR__.'/REST_Controller.php';


class Discussion_controller extends REST_Controller {



    function __construct()

    {

        // Construct the parent class

        parent::__construct();

        $this->load->model('Api_model');
        $this->load->model('Sendnotification');
       $this->load->model('Discussion_model');




    }

public function comment_post()
{
    
    $discussion_id=$this->input->post("discussion_id");
    $discussion_type='regular';
    $content=$this->input->post("content");
    $staff_id=$this->input->post("staff_id");
    $contact_id=$this->input->post("contact_id");
    $fullname=$this->input->post("fullname");
       $DiscussionData = array('discussion_id' =>$discussion_id ,
                            'discussion_type'=>$discussion_type,
                            'content'=>$content,
                            'created'=>date('Y-m-d H:i:s'),
                            'staff_id'=>$staff_id,
                            'contact_id'=>$contact_id,
                            'fullname'=>$fullname );
       $insertrecord=$this->Discussion_model->DiscussionCommentInsert($DiscussionData);
        if($insertrecord>0){    

        $this->db->select('project_id');
        $this->db->where('id', $discussion_id);
        $r = $this->db->get('tblprojectdiscussions');
        $datadiscussion = $r->row();

        $this->db->select('staff_id');
        $this->db->where('project_id', $datadiscussion->project_id);
        $q = $this->db->get('tblproject_members');
        $data = $q->result();
            foreach ($data as $key ) {
            $tokenid=$this->Api_model->getToken($key->staff_id);
            $tokenkey=$this->Api_model->getKey($key->staff_id);
            $q=$this->Sendnotification->send_fcm('#-'.$discussion_id.'--'.$content,$tokenid,'New Discussion Comment',$tokenkey);                // success
            
            }
            }
       if($insertrecord!=0){

        $message = array(

                'status' => TRUE,

                'message' => 'Discussion Comment Insert Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);
       }else{
        $message = array(

                'status' => FALSE,

                'message' => 'Discussion Comment Failed.'

                );

                $this->response($message, REST_Controller::HTTP_OK);
       }
   
}

      public function data_post()
    {
       $projectid=$this->input->post("projectid");
       $subject=$this->input->post("subject");
       $description=$this->input->post("description");
       $staffid=$this->input->post("staffid");
       $contact_id=$this->input->post("contact_id");
       $DiscussionData = array('project_id' =>$projectid ,
                            'subject'=>$subject,
                            'description'=>$description,
                            'show_to_customer'=>'1',
                            'datecreated'=>date('Y-m-d H:i:s'),
                            'staff_id'=>$staffid,
                            'contact_id'=>$contact_id );
       $insertrecord=$this->Discussion_model->InsertData($DiscussionData);
         if($insertrecord>0){    
        $this->db->select('staff_id');
        $this->db->where('project_id', $projectid);
        $q = $this->db->get('tblproject_members');
        $data = $q->result();
            foreach ($data as $key ) {
            $tokenid=$this->Api_model->getToken($key->staff_id);
            $tokenkey=$this->Api_model->getKey($key->staff_id);
            $q=$this->Sendnotification->send_fcm('#-'.$insertrecord.'--'.$subject,$tokenid,'New Discussion',$tokenkey);                // success
            
            }
            }
       if($insertrecord!=0){
        $message = array(

                'status' => TRUE,

                'message' => 'Discussion Insert Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);
       }else{
        $message = array(

                'status' => FALSE,

                'message' => 'Discussion Failed.'

                );

                $this->response($message, REST_Controller::HTTP_OK);
       }
   
        

    }





   


}

