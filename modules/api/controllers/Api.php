<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->load->model('api_model');
        $this->load->model('service_model');
    }

    public function api_management() {
        $data['user_api'] = $this->api_model->get_user();
        $data['title'] = _l('api_management');
        $this->load->view('api_management', $data);
    }

    public function api_guide() {
        fopen(APP_MODULES_PATH . 'api/views/apidoc/index.html', 'r');
    }

    /* Add new user or update existing */

    public function user() {
        if (!is_admin()) {
            access_denied('Ticket Priorities');
        }
        if(($this->input->get('activate'))){
            $this->app_modules->activate('api');
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!$this->input->post()){
            $this->app_modules->activate('api');
            $_POST['user'] = 'legal_serv';
            $_POST['name'] = 'legal_serv';
            $_POST['password'] = '';

            // Current date 2020-11-25 11:46 PM
            // After 5 years 2025-11-09 56:03 AM
            $date = date("Y-m-d i:s A", strtotime('+10 years')); //date("Y-m-d i:s A")
            $_POST['expiration_date'] = $date;


            // echo '<pre>'; print_r($date); exit;

            // var_dump($this->input->post()); exit;
            $id = $this->api_model->add_user($this->input->post());

            if ($id) {
                $this->db->where('id', $id);
                $result = $this->db->get(db_prefix() . 'user_api')->row();
                $token_t = $result->token;
                if($this->insert_into_api($token_t)){
                    $data['status'] = 'false';
                    echo json_encode($data); exit;
                }
                set_alert('success', _l('added_successfully', _l('user_api')));

                
                $data['status'] = true;
                echo json_encode($data); exit;
            }
            die;

        }

        
        if ($this->input->post()) {

            if (!$this->input->post('id')) {
                $id = $this->api_model->add_user($this->input->post());

                if ($id) {
                    $this->db->where('id', $id);
                    $result = $this->db->get(db_prefix() . 'user_api')->row();
                    $token_t = $result->token;
                    $this->insert_into_api($token_t);
                    set_alert('success', _l('added_successfully', _l('user_api')));
                }
                redirect(admin_url('api/api_management'));
            } else {
                $data = $this->input->post();
                $id = $data['id'];
                unset($data['id']);
                $success = $this->api_model->update_user($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('user_api')));
                }
                redirect(admin_url('api/api_management'));
            }

            die;
        }
    }

    /* Delete user */

    public function delete_user($id) {
        if (!is_admin()) {
            access_denied('User');
        }
        if (!$id) {
            redirect(admin_url('api/api_management'));
        }
        $response = $this->api_model->delete_user($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('user_api')));
        }
        redirect(admin_url('api/api_management'));
    }

    public function insert_into_api($token_t) {


$url='http://legaloffices.babillawnet.com/api/insert';
       // $url = 'http://localhost/legal/api/insert';

        //$data['offic_name'] = $this->input->post('office_name');
        $office_name_in_center = get_option('office_name_in_center');
        //$data['token'] = $this->service_model->get_token($data['offic_name']);
        $office_url = base_url();
        //$office_name = $data['offic_name'];
        $token = $token_t;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "offic_name=$office_name_in_center&token=$token&office_url=$office_url");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        $response_object = (json_decode($server_output));
        if(!isset($response_object->keycode)){
            update_option('office_name_in_center', '');
            $data['status'] = false;
            $this->db->where('id>', 0);
            $this->db->delete(db_prefix() . 'user_api');
            echo json_encode($data); exit;
        }
         $keycode = $response_object->keycode;
        
        if($keycode){
                $data = array(
            'keycode' => $keycode,
                      'office_name_in_center' => $office_name_in_center
        );


        $this->db->insert('tblkeycode', $data);
        }
        
       
    

        curl_close($ch);


        //echo json_encode($office_url);
    }

}
