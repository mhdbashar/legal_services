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
class Service extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Api_model');
    }

    /**
     * @api {get} api/projects/:id Request project information
     * @apiName GetProject
     * @apiGroup Project
     *
     * @apiHeader {String} Authorization Basic Access Authentication token.
     *
     * @apiParam {Number} id project unique ID.
     *
     * @apiSuccess {Object} Project information.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": "28",
     *          "name": "Test1",
     *          "description": null,
     *          "status": "1",
     *          "clientid": "11",
     *          "billing_type": "3",
     *          "start_date": "2019-04-19",
     *          "deadline": "2019-08-30",
     *          "project_created": "2019-07-16",
     *          "date_finished": null,
     *          "progress": "0",
     *          "progress_from_tasks": "1",
     *          "project_cost": "0.00",
     *          "project_rate_per_hour": "0.00",
     *          "estimated_hours": "0.00",
     *          "addedfrom": "5",
     *          "rel_type": "lead",
     *          "potential_revenue": "0.00",
     *          "potential_margin": "0.00",
     *          "external": "E",
     *         ...
     *     }
     *
     * @apiError {Boolean} status Request status.
     * @apiError {String} message No data were found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "status": false,
     *       "message": "No data were found"
     *     }
     */
    public function data_get($id = '')
    {
        // If the id parameter doesn't exist return all the
        $data = $this->Api_model->get_table('Service', $id);

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

    /**
     * @api {get} api/projects/search/:keysearch Search Project Information.
     * @apiName GetProjectSearch
     * @apiGroup Project
     *
     * @apiHeader {String} Authorization Basic Access Authentication token.
     *
     * @apiParam {String} keysearch Search keywords.
     *
     * @apiSuccess {Object} Project information.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": "28",
     *          "name": "Test1",
     *          "description": null,
     *          "status": "1",
     *          "clientid": "11",
     *          "billing_type": "3",
     *          "start_date": "2019-04-19",
     *          "deadline": "2019-08-30",
     *          "project_created": "2019-07-16",
     *          "date_finished": null,
     *          "progress": "0",
     *          "progress_from_tasks": "1",
     *          "project_cost": "0.00",
     *          "project_rate_per_hour": "0.00",
     *          "estimated_hours": "0.00",
     *          "addedfrom": "5",
     *          "rel_type": "lead",
     *          "potential_revenue": "0.00",
     *          "potential_margin": "0.00",
     *          "external": "E",
     *         ...
     *     }
     *
     * @apiError {Boolean} status Request status.
     * @apiError {String} message No data were found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "status": false,
     *       "message": "No data were found"
     *     }
     */
    public function data_search_get($key = '')
    {
        $data = $this->Api_model->search('Service', $key);

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
    /**
     * @api {post} api/projects Add New Project
     * @apiName PostProject
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
     * @apiParamExample {Multipart Form} Request-Example:
     *     array (size=15)
     *        'name' => string 'Project Name' (length=12)
     *        'rel_type' => string 'customer' (length=8)
     *        'clientid' => string '3' (length=1)
     *        'progress_from_tasks' => string 'on' (length=2)
     *        'progress' => string '0' (length=1)
     *        'billing_type' => string '3' (length=1)
     *        'status' => string '2' (length=1)
     *        'project_cost' => string '' (length=0)
     *        'project_rate_per_hour' => string '' (length=0)
     *        'estimated_hours' => string '' (length=0)
     *        'project_members' => 
     *          array (size=1)
     *            0 => string '1' (length=1)
     *        'start_date' => string '25/07/2019' (length=10)
     *        'deadline' => string '' (length=0)
     *        'tags' => string '' (length=0)
     *        'description' => string '' (length=0)
     *
     *
     * @apiSuccess {Boolean} status Request status.
     * @apiSuccess {String} message Project add successful.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Project add successful."
     *     }
     *
     * @apiError {Boolean} status Request status.
     * @apiError {String} message Project add fail.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "status": false,
     *       "message": "Project add fail."
     *     }
     * 
     */
    public function data_post()
    {

            // form validation
            $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[600]', array('is_unique' => 'This %s already exists please enter another Name'));
            $this->form_validation->set_rules('service_id', 'Service id', 'trim|required|max_length[11]');
            //$this->form_validation->set_rules('rel_type', 'Related', 'trim|required', array('is_unique' => 'This %s already exists please enter another Project Related'));
            $this->form_validation->set_rules('billing_type', 'Billing Type', 'trim|required', array('is_unique' => 'This %s already exists please enter another Project Billing Type'));
            $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required', array('is_unique' => 'This %s already exists please enter another Start Date'));
            $this->form_validation->set_rules('status', 'Status', 'trim|required', array('is_unique' => 'This %s already exists please enter another Status'));
            $related = $this->input->post('rel_type', TRUE);
            $this->form_validation->set_rules('clientid', ucwords($related), 'trim|required|max_length[11]', array('is_unique' => 'This %s already exists please enter another Project Name'));
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
                $project_members = $this->Api_model->value($this->input->post('project_members', TRUE));
                $insert_data = [
                    'name' => $this->input->post('name', TRUE),
                    'service_id' => $this->input->post('service_id', TRUE),
                    'code' => $this->input->post('code', TRUE), 
                    'country' => $this->input->post('country', TRUE), 
                    'city' => $this->input->post('city', TRUE), 
                    'numbering' => $this->input->post('numbering', TRUE),
                    'cat_id' => $this->input->post('cat_id', TRUE),
                    'subcat_id' => $this->input->post('subcat_id', TRUE),
                    //'rel_type' => $this->input->post('rel_type', TRUE),
                    'clientid' => $this->input->post('clientid', TRUE),
                    'billing_type' => $this->input->post('billing_type', TRUE),
                    'start_date' => $this->input->post('start_date', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'project_cost' => $this->Api_model->value($this->input->post('project_cost', TRUE)),
                    'estimated_hours' => $this->Api_model->value($this->input->post('estimated_hours', TRUE)),
                    'progress_from_tasks' => $this->Api_model->value($this->input->post('progress_from_tasks', TRUE)),
                    'progress' => $this->Api_model->value($this->input->post('progress', TRUE)),
                    'project_rate_per_hour' => $this->Api_model->value($this->input->post('project_rate_per_hour', TRUE)),
                    'deadline' => $this->Api_model->value($this->input->post('deadline', TRUE)),
                    'description' => $this->Api_model->value($this->input->post('description', TRUE)),
                    'service_session_link' => $this->Api_model->value($this->input->post('service_session_link', TRUE)),
                    //'tags' => $this->Api_model->value($this->input->post('tags', TRUE)),
                    
                    'available_features' => $this->Api_model->value($this->input->post('available_features', TRUE)),
                     ];
                    if($project_members != ''){
                        $insert_data['project_members'] = $project_members;
                    }
                // insert data
                    $company_url = $this->Api_model->value($this->input->post('company_url', TRUE));
                    $rel_id = $this->Api_model->value($this->input->post('rel_id', TRUE));           
                    $files = $this->Api_model->value($this->input->post('files', TRUE));
                    if($insert_data['service_id'] == 1){
                        $service_slug = 'cases';
                    }
                    else{
                        $service_slug = 'oservices';
                    }
                    //$this->response($files, REST_Controller::HTTP_NOT_FOUND);
                $this->load->model('Service_model', 'other');             
                $output = $this->other->add($this->input->post('service_id'), $insert_data);                
                if($output > 0 && !empty($output)){
                    handle_project_file_uploads($output);
                    if(!file_exists('uploads/imported_services/'.$output)){
                        mkdir(FCPATH.'uploads/imported_services/'.$output, 0777);
                    }
                    if(!empty($files)){
                        foreach ($files as $key => $value) {
                            $file_url = $company_url.'uploads/'.$service_slug.'/'.$rel_id.'/'.$value['file_name'];
                            $file_content = file_get_contents(str_replace(' ', '%20', $file_url));
                            $myFile = fopen(FCPATH.'uploads/imported_services/'.$output.'/'.$value['file_name'], 'w', true);

                            file_put_contents(FCPATH.'uploads/imported_services/'.$output.'/'.$value['file_name'], $file_content);
                            $file_data = [
                                'file_name' => $value['file_name'],
                                'subject' => $value['subject'],
                                'description' => isset($value['description']) ? $value['description'] : '',
                                'filetype' => $value['filetype'],
                                'dateadded' => $value['dateadded'],
                                'last_activity' => isset($value['last_activity']) ? $value['last_activity'] : '',
                                'iservice_id' => $output,
                                'visible_to_customer' => 0,   //$value['visible_to_customer'],
                                'staffid' => 1,    //$value['staffid'],
                                'contact_id' => 0,   //$value['contact_id'],
                                'external' => isset($value['external']) ? $value['external'] : '',
                                'external_link' => isset($value['external_link']) ? $value['external_link'] : '',
                                'file_name' => isset($value['file_name']) ? $value['file_name'] : '',
                            ];
                            $this->db->insert('tbliservice_files', $file_data);

                        }

                    }
                    // success
                    $message = array(
                    'status' => TRUE,
                    'office_id' => $output,
                    'message' => 'Service add successful.'
                    );
                    $this->response($message, REST_Controller::HTTP_OK);
                }else{
                    // error
                    $message = array(
                    'status' => FALSE,
                    'message' => 'Service add failed.'
                    );
                    $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
            }
    }

    public function deleted_imported_get($id = ''){
        $data = $this->Api_model->get_table('imported_services', $id);
        if($data){
            $this->response([
                'id' => $id
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

    }


    /**
     * @api {delete} api/delete/projects/:id Delete a Project
     * @apiName DeleteProject
     * @apiGroup Project
     *
     * @apiHeader {String} Authorization Basic Access Authentication token.
     *
     * @apiParam {Number} id project unique ID.
     *
     * @apiSuccess {Boolean} status Request status.
     * @apiSuccess {String} message Project Delete successful.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": true,
     *       "message": "Project Delete Successful."
     *     }
     *
     * @apiError {Boolean} status Request status.
     * @apiError {String} message Project Delete Fail.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "status": false,
     *       "message": "Project Delete Fail."
     *     }
     */
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
            $this->load->model('Service_model', 'other');
            $output = $this->other->delete($id);
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
            $this->load->model('Service_model', 'other');
            $output = $this->other->update($update_data, $id);
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
