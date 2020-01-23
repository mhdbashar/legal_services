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

    public function add_dialog()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $added = $this->dialog->add($data);
            if($added){
                set_alert('success', _l('open_lock'));
                redirect(admin_url("Case/view/"));
            }
        }
    }

    public function edit_dialog()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $updated = $this->dialog->edit($data);
            if($updated){
                set_alert('success', _l('open_lock'));
                redirect(admin_url("Case/view/"));
            }
        }
    }

    public function disable_dialog($id)
    {
        if($id == 0 || !$id){
            set_alert('danger', _l('WrongEntry'));
        }
        echo $this->dialog->disable($id);
    }
}