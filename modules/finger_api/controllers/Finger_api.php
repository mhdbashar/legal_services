<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Finger_api extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_model');
        if (!has_permission('finger_api', '', 'timekeeper')) {
            access_denied('timekeeper');
        }
//        $this->load->library('app_modules');
//        if(!$this->app_modules->is_active('figner_api')){
//            access_denied("Api");
//        }

    }
    public function api_management()
    {

        $data['user_api'] = $this->api_model->get_user();
        $data['title'] = _l('api_management');
        $this->load->view('api_management', $data);
    }

    public function qr_management()
    {
        $this->load->model('staff_model');
        $data['staffs'] = $this->staff_model->get();
        $data['user_api'] = $this->api_model->get_user();
        $data['title'] = _l('api_management');
        $this->load->view('qr_management', $data);
    }

    public function api_guide()
    { 
        fopen(APP_MODULES_PATH . 'finger_api/views/apidoc/index.html', 'r');
    }

    /* Add new user or update existing*/
    public function user()
    {

        if (!is_admin()) {
            access_denied('Ticket Priorities');
        }
        if ($this->input->post()) {

            if (!$this->input->post('id')) {
                $id = $this->api_model->add_user($this->input->post());
               
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('user_api')));
                }
                 redirect(admin_url('finger_api/api_management'));
            } else {
                $data = $this->input->post();
                $id   = $data['id'];
                unset($data['id']);
                $success = $this->api_model->update_user($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('user_api')));
                }
                redirect(admin_url('finger_api/api_management'));
            }
            die;
        }
    }

    /* Delete user */
    public function delete_user($id)
    {

        if (!is_admin()) {
            access_denied('User');
        }
        if (!$id) {
            redirect(admin_url('finger_api/api_management'));
        }
        $response = $this->api_model->delete_user($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('user_api')));
        }
        redirect(admin_url('finger_api/api_management'));
    }

}