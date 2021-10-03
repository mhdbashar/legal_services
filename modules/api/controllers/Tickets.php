<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__.'/REST_Controller.php';



class Tickets extends REST_Controller {
 function __construct()

    {

        // Construct the parent class

        parent::__construct();
        $this->load->model('Tickets_model');
        $this->load->model('Api_model');
        $this->load->model('Sendnotification');
    }


public function All_get($value='')
{
    $staff_id=$this->get('staff_id');
     $filters = [
        'staff_id' => $staff_id,  
        'start' => $this->get('start') && is_numeric($this->get('start')) ? $this->get('start') : 1,
        'limit' => $this->get('limit') && is_numeric($this->get('limit')) ? $this->get('limit') : 10,   
        'status' => $this->get('status'),
        ];
     $check_permission = $this->Api_model->check_permission('support',$staff_id,'view');
             
   if ($check_permission == 1) {
       
        $s_data=[];
       
            $datacount=$this->Api_model->getSupportlistCount();
            $supports=$this->Api_model->getSupportlist($filters);
             foreach ($supports as $support) {
                 $support->message = strip_tags($support->message);
                    $support->department_name = $this->Api_model->get_department_Name($support->department);
                    $support->priority_name = $this->Api_model->get_priority_name($support->priority);
                    $support->status_name = $this->Api_model->get_task_status($support->status);
                    $support->status_color = $this->Api_model->get_task_statuscolor($support->status);
                    $support->submitter = $this->Api_model->getStaffbyId($support->admin);
                    // $support->project_id_name = $this->Api_model->getProjectbyId($support->project_id);
                    $support->contact_name = $this->Api_model->get_contact_Name($support->contactid);
                    $support->project_name = $this->Api_model->get_project_Name($support->project_id);
                    $data = $supports;

                }
            if($data){
                $s_data =  [
                        'data' => $data,
                        'status_count'=>$datacount,
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
            'message' =>'no permission',
            'status' => 0,
             ];
        $this->response($s_data, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function data_get($id = '')

    {
        $id=$this->get('id');
         $filters = [
        'reference' => $reference,
        'id' => $id,
        'type'=>$this->get('type')?$this->get('type'):NULL,
        'include' => $this->get('include') ? explode(',', $this->get('include')) : NULL,
        'start' => $this->get('start') && is_numeric($this->get('start')) ? $this->get('start') : 1,
        'limit' => $this->get('limit') && is_numeric($this->get('limit')) ? $this->get('limit') : 10,
        ];
                $data=$this->Api_model->Ticket_List($filters);
                 $S1_data = [];
                foreach ($data as $ticketdata) {
                    $ticketdata->message = str_replace("</p>", "", str_replace("<p>", "", strip_tags($ticketdata->message)));
                    $ticketdata->status_name = $this->Api_model->get_task_status($ticketdata->status);
                    $ticketdata->priority_name = $this->Api_model->get_priority_name($ticketdata->priority);
                    $ticketdata->contact_name = $this->Api_model->get_contact_Name($ticketdata->contactid);
                    $ticketdata->department_name = $this->Api_model->get_department_Name($ticketdata->department);
                    $ticketdata->customer_name = $this->Api_model->get_customer_Name($ticketdata->userid);
                     $ticketdata->status_color = $this->Api_model->get_task_statuscolor($ticketdata->status);
                       $ticketdata->submitter = $this->Api_model->getStaffbyId($ticketdata->admin);
                        
                    $ticketdata->project_name = $this->Api_model->get_project_Name($ticketdata->project_id);
                    $S1_data[] = $ticketdata;
                }
                $data=$S1_data;
                if ($data)
                {
                    $S_data =  [
                        'data' => $data,  
                        'status' => 1,
                        'message'=>'success',
                        'start' => (int) $filters['start'],
                        'limit'=>(int) $filters['limit'], 
                    ];   
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $S_data =  [
                    'data' => $data,
                    'status' => 0,
                    'message'=>'record not found',
                    'start' => (int) $filters['start'],
                    'limit'=>(int) $filters['limit'],
                ];
                  $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
                }
       
        

    }



    public function data_search_get($key = '')

    {

        $data = $this->Api_model->search('ticket', $key);



        // Check if the data store contains

        if ($data)

        {

            // Set the response and exit

            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

        }

        else

        {

            // Set the response and exit

            $this->response([

                'status' => FALSE,

                'message' => 'No data were found'

            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

        }

    }

    

    public function data_post()

    {
                // echo "<pre>";print_r($_FILES);echo "</pre>"; die();
        // echo "<pre>";print_r($_FILES);echo "</pre>";die();

        // form validation

        $this->form_validation->set_rules('subject', 'Ticket Name', 'trim|required', array('is_unique' => 'This %s already exists please enter another Ticket Name'));

        $this->form_validation->set_rules('department', 'Department', 'trim|required', array('is_unique' => 'This %s already exists please enter another Ticket Department'));

        $this->form_validation->set_rules('contactid', 'Contact', 'trim|required', array('is_unique' => 'This %s already exists please enter another Ticket Contact'));

        if ($this->form_validation->run() == FALSE)

        {

            // form validation error

            $message = array(

                'status' => FALSE,

                'error' => $this->form_validation->error_array(),

                'message' => validation_errors() 

            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);

        }

        else

        {

            $insert_data = [

                'subject' => $this->input->post('subject', TRUE),

                'department' => $this->input->post('department', TRUE),

                'contactid' => $this->input->post('contactid', TRUE),

                'userid' => $this->input->post('userid', TRUE),

                'cc' => $this->Api_model->value($this->input->post('cc', TRUE)),

                'tags' => $this->Api_model->value($this->input->post('tags', TRUE)),

                'assigned' => $this->Api_model->value($this->input->post('assigned', TRUE)),

                'priority' => $this->Api_model->value($this->input->post('priority', TRUE)),

                'service' => $this->Api_model->value($this->input->post('service', TRUE)),

                'project_id' => $this->Api_model->value($this->input->post('project_id', TRUE)),

                'message' => $this->Api_model->value($this->input->post('message', TRUE))

             ];


            // insert data

            $this->load->model('tickets_model');


            $output = $this->tickets_model->add($insert_data,$insert_data->userid);
            $s_data=[];

              if($output>0){   
            $this->db->select('staff_id');
                    $this->db->where('project_id', $insert_data['project_id']);
                    $q = $this->db->get('tblproject_members');
                    $data = $q->result();

                    foreach ($data as $key ) {
                   

                            $tokenid=$this->Api_model->getToken($key->staff_id);
                            $tokenkey=$this->Api_model->getKey($key->staff_id);
                            if($tokenid){
                           $q=$this->Sendnotification->send_fcm('New Ticket Created #'.$output,$tokenid,'Ticket',$tokenkey);
                       }

                        $tokeniduser=$this->Api_model->getToken($userid);
                            $tokenkeyuser=$this->Api_model->getKey($userid);
                            if($tokeniduser){
                           $q=$this->Sendnotification->send_fcm('New Ticket Created #'.$output,$tokeniduser,'Ticket',$tokenkeyuser);
                       }
                    }
                 
                }

          
            if($output > 0 && !empty($output)){

                // success

       
                $s_data = array(

                'status' => TRUE,

                'message' => 'Ticket add successful.'

                );

                $this->response($s_data, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Ticket add fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        }

    }





 public function ticketreply_post()
   {
        $ticketid=$this->input->post('ticketid');

        $userid=$this->input->post('userid');
        $replydata=$this->input->post('replydata');

         
        $data['ticket'] = $this->Tickets_model->get_ticket_by_id($ticketid);

       
        

        
$replyfatchdata=[];
$temp=[];
        if ($this->input->post()) {

            // $this->form_validation->set_rules('message', _l('ticket_reply'), 'required');
            // if ($this->form_validation->run() !== false) {
            
                $data = $this->input->post();
           
            if($data['replydata']=='no'){

                    $sendData = array('ticketid' => $ticketid,
                                        'message'=>$data['message'] );

                  $replyid         = $this->Tickets_model->add_reply($sendData,$ticketid,$userid);  // 

                  
                      if($replyid>0){   

                        $this->db->select('project_id');
                        $this->db->where('ticketid', $ticketid);
                        $r = $this->db->get('tbltickets');
                        $dataticket = $r->row();

                         $this->db->select('userid');
                        $this->db->where('ticketid', $ticketid);
                        $r = $this->db->get('tbltickets');
                        $dataticketcustomer = $r->row();
                        $tokenidcustomer=$this->Api_model->getToken($dataticketcustomer->userid);
                        $tokenkeycustomer=$this->Api_model->getKey($dataticketcustomer->userid);

                          if($tokenidcustomer){
                           $q=$this->Sendnotification->send_fcm('Ticket Reply on #'.$ticketid,$tokenidcustomer,'Ticket Reply',$tokenkeycustomer);
                          }

                        $this->db->select('staff_id');
                        $this->db->where('project_id', $dataticket->project_id);
                        $q = $this->db->get('tblproject_members');
                        $data = $q->result();

                    foreach ($data as $key ) {
                   

                            $tokenid=$this->Api_model->getToken($key->staff_id);
                            $tokenkey=$this->Api_model->getKey($key->staff_id);

                            if($tokenid){
                           $q=$this->Sendnotification->send_fcm('Ticket Reply on #'.$ticketid,$tokenid,'Ticket Reply',$tokenkey);
                       }
      
                         $tokeniduser=$this->Api_model->getToken($userid);
                            $tokenkeyuser=$this->Api_model->getKey($userid);

                            if($tokeniduser){
                           $q=$this->Sendnotification->send_fcm('Ticket Reply on #'.$ticketid,$tokeniduser,'Ticket Reply',$tokenkeyuser);
                       }
                    }


                   
                }

                if ($replyid) {
                    $s_data =  [
                      
                        'message' =>'success',
                        'status' => 1,
                        ];
                 $this->response($s_data, REST_Controller::HTTP_OK);

                }else{
                     $s_data =  [
                        // 'data' => array(),
                        'message' =>'error',
                        'status' => 0,
                        ];
                 $this->response($s_data, REST_Controller::HTTP_NOT_FOUND);
                }
            }else{
                     $replyfatchdata=$this->Tickets_model->get_ticket_replies($ticketid);

                    foreach ($replyfatchdata as $ticket) {
$ticket['message'] = strip_tags($ticket['message']);
// $ticket->message = preg_replace('</p>','',preg_replace('<p>','',strip_tags($ticket->message)));
                           
                          
                          $temp[]=$ticket;
                            }
                    $replyfatchdata=$temp;
                            
                          
               $s_data =  [
                        'data'=>$replyfatchdata,
                        'message' =>'success',
                        'status' => 1,
                        ];
                 $this->response($s_data, REST_Controller::HTTP_OK); 
            }
            // }

        }

    }

        

    public function data_delete($id = '')

    {

        $id = $this->security->xss_clean($id);

        if(empty($id) && !is_numeric($id))

        {

            $message = array(

            'status' => FALSE,

            'message' => 'Invalid Ticket ID'

        );

        $this->response($message, REST_Controller::HTTP_NOT_FOUND);

        }

        else

        {

            // delete data

            $this->load->model('tickets_model');

            $output = $this->tickets_model->delete($id);

            if($output === TRUE){

                // success

                $message = array(

                'status' => TRUE,

                'message' => 'Ticket Delete Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Ticket Delete Fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        }

    }





    /**

     * @api {put} api/tickets/:id Update a ticket

     * @apiName PutTicket

     * @apiGroup Ticket

     *

     * @apiHeader {String} Authorization Basic Access Authentication token.

     *

     * @apiParam {String} subject                       Mandatory Ticket name .

     * @apiParam {String} department                    Mandatory Ticket Department.

     * @apiParam {String} contactid                     Mandatory Ticket Contact.

     * @apiParam {String} userid                        Mandatory Ticket user.

     * @apiParam {String} priority                      Mandatory Priority.

     * @apiParam {String} [project_id]                  Optional Ticket Project.

     * @apiParam {String} [message]                     Optional Ticket message.

     * @apiParam {String} [service]                     Optional Ticket Service.

     * @apiParam {String} [assigned]                    Optional Assign ticket.

     * @apiParam {String} [tags]                        Optional ticket tags.

     *

     *

     * @apiParamExample {json} Request-Example:

     *  {

     *       "subject": "Ticket ER",

     *       "department": "1",

     *       "contactid": "0",

     *       "ticketid": "7",

     *       "userid": "0",

     *       "project_id": "5",

     *       "message": "Ticket ER",

     *       "service": "1",

     *       "assigned": "5",

     *       "priority": "2",

     *       "tags": ""

     *   }

     *

     * @apiSuccess {Boolean} status Request status.

     * @apiSuccess {String} message Ticket Update Successful.

     *

     * @apiSuccessExample Success-Response:

     *     HTTP/1.1 200 OK

     *     {

     *       "status": true,

     *       "message": "Ticket Update Successful."

     *     }

     *

     * @apiError {Boolean} status Request status.

     * @apiError {String} message Ticket Update Fail.

     *

     * @apiErrorExample Error-Response:

     *     HTTP/1.1 404 Not Found

     *     {

     *       "status": false,

     *       "message": "Ticket Update Fail."

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

            'message' => 'Invalid Ticket ID'

            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);

        }

        else

        {



            $update_data = $this->input->post();

            // update data

            $this->load->model('tickets_model');

            $update_data['ticketid'] = $id;

            $output = $this->tickets_model->update_single_ticket_settings($update_data);

            if($output > 0 && !empty($output)){

                // success

                $message = array(

                'status' => TRUE,

                'message' => 'Ticket Update Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Ticket Update Fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        }

    }

}

