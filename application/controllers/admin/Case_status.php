<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Case_status extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CaseStatus_model');
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_case_status');
        }
        $data['title'] = _l('case_status');
        $this->load->view('admin/case_status/manage', $data);
    }


    public function cstatuscu($id = '')
    {
        if (!is_admin()) {
            access_denied('CaseStatus_model');
        }
        if ($this->input->post()) {
            $data            = $this->input->post();
            // $data['message'] = $this->input->post('message', false);
            if ($id == '') {
                $id = $this->CaseStatus_model->add($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('case_status')));
                    redirect(admin_url('Case_status'));
                }
            } else {
                $success = $this->CaseStatus_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('case_status')));
                }
                redirect(admin_url('Case_status'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('case_status'));
        } else {
            $data['Status'] = $this->CaseStatus_model->get($id);
            $title                = _l('edit', _l('case_status'));
        }
        $data['title'] = $title;
        $this->load->view('admin/case_status/case_status', $data);
    }

    public function cstatusd($id)
    {
        if (!$id) {
            redirect(admin_url('Case_status/cstatuscu'));
        }
        if (!is_admin()) {
            access_denied('case_status');
        }
        $response = $this->CaseStatus_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('case_status')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('case_status')));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}
