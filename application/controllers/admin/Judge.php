<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Judge extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Judges_model');
    }

    public function index()
    {
        if (!has_permission('judges_manage', '', 'create')) {
            access_denied('Judge');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_judges');
        }
        $data['title'] = _l('Judges');
        $this->load->view('admin/judges/manage', $data);
    }

    function add()
    {
        if (!has_permission('judges_manage', '', 'create')) {
            access_denied('Judge');
        }
        $data = $this->input->post();
        echo  $this->Judges_model->add($data);
    }

    public function judgecu($id = '')
    {
        if (!has_permission('judges_manage', '', 'create') && !has_permission('judges_manage', '', 'edit')) {
            access_denied('Judge');
        }
        if ($this->input->post()) {
            $data            = $this->input->post();
            // $data['message'] = $this->input->post('message', false);
            if ($id == '') {
                $id = $this->Judges_model->add($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('Judge')));
                    redirect(admin_url('Judge'));
                }
            } else {
                $success = $this->Judges_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Judge')));
                }
                redirect(admin_url('Judge'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('judge'));
        } else {
            $data['Judge'] = $this->Judges_model->get($id);
            $title                = _l('edit', _l('judge'));
        }
        $data['title'] = $title;
        $this->load->view('admin/judges/judge', $data);
    }

    public function judged($id)
    {
        if (!has_permission('judges_manage', '', 'delete')) {
            access_denied('Judge');
        }
        if (!$id) {
            redirect(admin_url('Judge/judgecu'));
        }
        $response = $this->Judges_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Judge')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Judge')));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}
