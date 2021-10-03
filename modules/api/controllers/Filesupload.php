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

class Filesupload extends REST_Controller {



    function __construct()

    {

        // Construct the parent class

        parent::__construct();

        $this->load->model('Api_model');
        $this->load->model('projects_model');
        $this->load->model('proposals_model');
        $this->load->model('Sendnotification');
        $this->load->model('Invoices_model');




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
   $typeof=$this->input->post("typeof");

   if($typeof=='customer'){
        $insertrecord=handle_client_attachments_upload($project_id,$staff_id);
   }else{
     $insertrecord=    handle_project_file_uploads($project_id,$staff_id,$contact_id);
   }    

 
   
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





   

    public function data_delete($id = '')

    {

        $id = $this->security->xss_clean($id);

        if(empty($id) && !is_numeric($id))

        {

            $message = array(

            'status' => FALSE,

            'message' => 'Invalid Project ID'

        );

        $this->response($message, REST_Controller::HTTP_NOT_FOUND);

        }

        else

        {

            // delete data

            $this->load->model('projects_model');

            $output = $this->projects_model->delete($id);

            if($output === TRUE){

                // success

                $message = array(

                'status' => TRUE,

                'message' => 'Project Delete Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Project Delete Fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        }

    }





    /**

     * @api {put} api/projects/:id Update a project

     * @apiName PutProject

     * @apiGroup Project

     *

     * @apiHeader {String} Authorization Basic Access Authentication token.

     *

     * @apiParam {String} name                                  Mandatory Project Name.

     * @apiParam {string="lead","customer","internal"} rel_type Mandatory Project Related.

     * @apiParam {Number} clientid                              Mandatory Related ID.

     * @apiParam {Number} billing_type                          Mandatory Billing Type.

     * @apiParam {Date} start_date                              Mandatory Project Start Date.

     * @apiParam {Number} status                                Mandatory Project Status.

     * @apiParam {String} [progress_from_tasks]                 Optional on or off progress from tasks.

     * @apiParam {String} [project_cost]                        Optional Project Cost.

     * @apiParam {String} [progress]                            Optional project progress.

     * @apiParam {String} [project_rate_per_hour]               Optional project rate per hour.

     * @apiParam {String} [estimated_hours]                     Optional Project estimated hours.

     * @apiParam {Number[]} [project_members]                   Optional Project members.

     * @apiParam {Date} [deadline]                              Optional Project deadline.

     * @apiParam {String} [tags]                                Optional Project tags.

     * @apiParam {String} [description]                         Optional Project description.

     *

     *

     * @apiParamExample {json} Request-Example:

     *  {

     *     "name": "Test1",

     *     "rel_type": "lead",

     *     "clientid": "9",

     *     "status": "2",

     *     "progress_from_tasks": "on",

     *     "progress": "0.00", 

     *     "billing_type": "3",

     *     "project_cost": "0",

     *     "project_rate_per_hour": "0",

     *     "estimated_hours": "0",

     *     "project_members":

     *      {

     *          "0": "5"

     *      }

     *     "start_date": "19/04/2019",

     *     "deadline": "30/08/2019",

     *     "tags": "",

     *     "description": "",

     *     "settings": 

     *       {

     *         "available_features":

     *           {

     *            "0": "project_overview",

     *             "1": "project_milestones" ,

     *             "2": "project_gantt" ,

     *             "3": "project_tasks" ,

     *             "4": "project_estimates" ,

     *             "5": "project_credit_notes" ,

     *             "6": "project_invoices" ,

     *             "7": "project_expenses",

     *             "8": "project_subscriptions" ,

     *             "9": "project_activity" ,

     *             "10": "project_tickets" ,

     *             "11": "project_timesheets",

     *             "12": "project_files" ,

     *             "13": "project_discussions" ,

     *             "14": "project_notes" 

     *          }

     *      }

     *  }

     *

     * @apiSuccess {Boolean} status Request status.

     * @apiSuccess {String} message Project Update Successful.

     *

     * @apiSuccessExample Success-Response:

     *     HTTP/1.1 200 OK

     *     {

     *       "status": true,

     *       "message": "Project Update Successful."

     *     }

     *

     * @apiError {Boolean} status Request status.

     * @apiError {String} message Project Update Fail.

     *

     * @apiErrorExample Error-Response:

     *     HTTP/1.1 404 Not Found

     *     {

     *       "status": false,

     *       "message": "Project Update Fail."

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

            'message' => 'Invalid Project ID'

            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);

        }

        else

        {



            $update_data = $this->input->post();

            // update data

            $this->load->model('projects_model');

            $output = $this->projects_model->update($update_data, $id);

            if($output == true && !empty($output)){

                // success

                $message = array(

                'status' => TRUE,

                'message' => 'Project Update Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Project Update Fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        }

    }



}

