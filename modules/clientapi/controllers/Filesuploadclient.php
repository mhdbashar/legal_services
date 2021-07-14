<?php



defined('BASEPATH') OR exit('No direct script access allowed');



// This can be removed if you use __autoload() in config.php OR use Modular Extensions

/** @noinspection PhpIncludeInspection */

require __DIR__.'/REST_Controller.php';



/**

 * This is an example of a few basic user interaction methods you could use

 * all done with a hardcoded array

 *

 * @package         CodeIgniter

 * @subpackage      Rest Server

 * @category        Controller 

 */

class Filesuploadclient extends REST_Controller {



    function __construct()

    {

        // Construct the parent class

        parent::__construct();

        $this->load->model('Api_model');
        
        $this->load->model('Sendnotification');
        



    }


public function data_get()
{

 
   
    $id=$this->get('id');
$tokenid=$this->Api_model->getToken($id);


    $q=$this->Sendnotification->send_fcm('Create new Ticket',$tokenid,'Ticket');
    // $q=$this->Sendnotification->push_notification_android($id,$message);
    print_r($q);
    die();
}

  public function visibletocustomer_post($id='')
  {
      # code...
    $id=$this->input->post('id');
    $type=$this->input->post('type');
    if($type=='customer'){
  $q=$this->Api_model->projectfiles($id,$type);

$this->db->where('id', $id);
    $data=$this->db->update('tblfiles', array('visible_to_customer' => !$q));
    }
if($type=='project'){
    $q=$this->Api_model->projectfiles($id,$type);

$this->db->where('id', $id);
    $data=$this->db->update('tblproject_files', array('visible_to_customer' => !$q));
    }
  
    if($data){

                // success

                $message = array(

                'status' => TRUE,

                'message' => 'File update Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'File update Fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }
 

}
    
    
 

       public function data_post()
    {
   $project_id=$this->input->post("project_id");
   $staff_id=$this->input->post("staff_id");
   $contact_id=$this->input->post("contact_id");

 
       handle_project_file_uploads($project_id,$staff_id,$contact_id);
   
                $message = array(

                'status' => TRUE,

                'message' => 'File Upload Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

    }



}

