<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Regular_durations extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('legalservices/regular_duration_model','duration');
    }

    public function index()
    {
        if (!has_permission('legal_services', '', 'create') ) {
           access_denied('legal_services');
        }
        $data['durations']= $this->duration->get_durations_by_id();
        $data['title']  = _l('regular_durations');
        $this->load->view('admin/legalservices/regular_duration/view',$data);
    }

    public function add()
    {
        if (!has_permission('legal_services', '', 'create')) {
            access_denied('legal_services');
        }

        if ($this->input->post()) {
            $data = $this->input->post();
            $added = $this->duration->add_new_duration($data);
            if ($added) {
                set_alert('success', _l('added_successfully'));
                redirect(admin_url("legalservices/regular_durations"));
            }
        }
        $this->load->view('admin/legalservices/regular_duration/add');
    }

    public function edit_duration($id)
    {

        if (!has_permission('legal_services', '', 'edit')) {
            access_denied('legal_services');
        }
        if (!$id) {
            redirect(admin_url('legalservices/regular_durations'));
        }
        $data['title']  = _l('edit_regular_duration');
        $data['regular_duration']=$this->duration->get_duration_by_id($id);

       $this->load->view('admin/legalservices/regular_duration/edit',$data);

        if ($this->input->post())
        {
            $success = $this->duration->update_duration_data($id, $this->input->post());
            if ($success) {
                set_alert('success', _l('updated_successfully', _l('regular_duration')));
              redirect(admin_url('legalservices/regular_durations'));
            }else {
                set_alert('warning', _l('problem_updating', _l('regular_duration')));
              redirect(admin_url('legalservices/regular_durations'));
            }
        }
        }

   //******************************************
    public function delete_duration($id)
    {
        print_r("hello");
        if (!has_permission('legal_services', '', 'delete')) {
            access_denied('legal_services');
        }
        if (!$id) {
            redirect(admin_url('legalservices/regular_durations'));
        }
        $response = $this->duration->delete_duration($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('regular_duration')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('regular_duration')));
        }
        redirect(admin_url('legalservices/regular_durations'));
    }
    //*********tab***************************
    public function add_duration_cases($ServID)
    {
        if (!has_permission('legal_services', '', 'create')) {
            access_denied('legal_services');
        }
        $route = $ServID == 1 ? 'Case' : 'SOther';
        if ($this->input->post()) {
            $data = $this->input->post();
           // print_r($data);
           // exit();
            $added = $this->duration->add_new_duration_cases($data);
            if ($added) {
                set_alert('success', _l('added_successfully'));

                redirect(admin_url($route.'/view/'.$ServID.'/'.$data["id"].'?group=regular_duration'));

            }
        }
        redirect(admin_url($route.'/view/'.$ServID.'/'.$data["id"].'?group=regular_duration'));

        }



}
