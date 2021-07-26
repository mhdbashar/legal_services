<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dialog_boxes extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dialog_boxes_model', 'dialog');
    }

    public function index()
    {
        $data['results'] = $this->dialog->get();
        $data['title'] = _l('dialog_boxes');
        $this->load->view('admin/dialog_boxes/manage',$data);
    }

    public function table()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_dialog_boxes');
        }
    }

    public function add()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $added = $this->dialog->add($data);
            if($added){
                set_alert('success', _l('added_successfully'));
                redirect(admin_url("dialog_boxes"));
            }
        }
    }

    public function edit($id)
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $updated = $this->dialog->update($id, $data);
            if($updated){
                set_alert('success', _l('updated_successfully'));
                redirect(admin_url("dialog_boxes"));
            }
        }
    }

    public function remove($id)
    {
        $response = $this->dialog->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect(admin_url('dialog_boxes'));
    }

    public function active_dialog($id)
    {
        if($id == 0 || !$id){
            set_alert('danger', _l('WrongEntry'));
        }
        echo $this->dialog->active($id);
    }
}