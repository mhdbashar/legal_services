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
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Timesheets extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }


    public function area_get($id = '')
    {
        $this->db->select(['id', 'name']);
        $areas = $this->db->get(db_prefix() . 'timesheets_workplace')->result();

        // Check if the data store contains
        if ($areas)
        {
            $response = ['message' => 'success', 'area' => $areas];
            // Set the response and exit
            $this->response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
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

    public function verify_token()
    {
        $headers = $this->input->request_headers();
        if(!isset($headers['Authtoken'])){
            $this->response(['message' => 'Unauthorized'], 401);
        }
        $result = $this->authorization_token->validateToken();
        $a = 0;
        $email = $result['data']->$a;

        $this->db->select('email,latitude,longitude,'.db_prefix().'staff.staffid as staff_id');
        $this->db->where('email', $email);
        $this->db->join(db_prefix() . 'timesheets_workplace_assign', db_prefix().'timesheets_workplace_assign.staffid='.db_prefix().'staff.staffid', 'left');
        $this->db->join(db_prefix().'timesheets_workplace', db_prefix().'timesheets_workplace.id='.db_prefix().'timesheets_workplace_assign.workplace_id', 'left');
        $staff = $this->db->get(db_prefix().'staff')->row();

        return $staff;

    }

    public function attend_post()
    {
        $staff = $this->verify_token();
        $this->form_validation->set_rules('key', 'Key', 'required');
        $this->form_validation->set_rules('lat', 'Lat', 'required');
        $this->form_validation->set_rules('longt', 'Longt', 'required');
//        $this->form_validation->set_rules('area_id', 'area_id', 'required');
        $this->form_validation->set_rules('q', 'q', 'required');
        // $this->form_validation->set_rules('worker_id', 'worker_id', 'required');
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
            $data = $this->input->post();
            $settings = $this->db->get(db_prefix() . 'timesheets_settings')->row();
            if($data['key'] != $settings->key_app)
                $this->response([
                    'status' => false,
                    'message' => 'The KEY is Wrong!'
                ], 401
                );


            $this->load->model('timesheets/Timesheets_model', 'timesheets_model');
            $this->load->model('departments_model');
            $this->load->helper('timesheets/timesheets');

            $attend_data = [
                'staff_id' =>  $staff->staff_id,
                'type_check' => $data['q'] == 'in' ? 1 : 2,
                'edit_date' => '',
                'point_id' => '',
                'location_user' => $data['lat'] . ',' . $data['longt']
            ];

            $type = $attend_data['type_check'];
            $re = $this->timesheets_model->check_in($attend_data);
            $message = '';
            $status = true;
            if(is_numeric($re)){
                if($re == 2){
                    $message = _l('your_current_location_is_not_allowed_to_take_attendance');
                    $status = false;
                }
                if($re == 3){
                    $message = _l('location_information_is_unknown');
                    $status = false;
                }
                if($re == 4){
                    $message = _l('route_point_is_unknown');
                    $status = false;
                }
            }
            else{
                if($re == true){
                    if($type == 1){
                        $message = _l('check_in_successfull');
                        $status = true;
                    }
                    else{
                        $message = _l('check_out_successfull');
                        $status = true;
                    }
                }
                else{
                    if($type == 1){
                        $message = _l('check_in_not_successfull');
                        $status = false;
                    }
                    else{
                        $message = _l('check_out_not_successfull');
                        $status = false;
                    }
                }
            }

            $this->response([
                    'status' => $status,
                    'message' => $message
                ]
            );
        }
    }

    public function timekeeper_post()
    {

        if(!has_permission('finger_api', '', 'timekeeper'))
            $this->response([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        $this->form_validation->set_rules('key', 'Key', 'required');
        $this->form_validation->set_rules('q', 'q', 'required');
        $this->form_validation->set_rules('lat', 'Lat', 'required');
        $this->form_validation->set_rules('longt', 'Longt', 'required');
        $this->form_validation->set_rules('staff_id', 'Staff ID', 'required');
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
            $data = $this->input->post();


            $this->load->model('timesheets/Timesheets_model', 'timesheets_model');
            $this->load->model('departments_model');
            $this->load->helper('timesheets/timesheets');

            $attend_data = [
                'staff_id' =>  $data['staff_id'],
                'type_check' => $data['q'] == 'in' ? 1 : 2,
                'edit_date' => '',
                'point_id' => '',
                'location_user' => $data['lat'] . ',' . $data['longt']
            ];

            $type = $attend_data['type_check'];
            $re = $this->timesheets_model->check_in($attend_data);
            $message = '';
            $status = true;
            if(is_numeric($re)){
                if($re == 2){
                    $message = _l('your_current_location_is_not_allowed_to_take_attendance');
                    $status = false;
                }
                if($re == 3){
                    $message = _l('location_information_is_unknown');
                    $status = false;
                }
                if($re == 4){
                    $message = _l('route_point_is_unknown');
                    $status = false;
                }
            }
            else{
                if($re == true){
                    if($type == 1){
                        $message = _l('check_in_successfull');
                        $status = true;
                    }
                    else{
                        $message = _l('check_out_successfull');
                        $status = true;
                    }
                }
                else{
                    if($type == 1){
                        $message = _l('check_in_not_successfull');
                        $status = false;
                    }
                    else{
                        $message = _l('check_out_not_successfull');
                        $status = false;
                    }
                }
            }

            $this->response([
                    'status' => $status,
                    'message' => $message
                ]
            );
        }
    }

}
