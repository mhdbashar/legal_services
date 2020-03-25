<?php

defined('BASEPATH') or exit('No direct script access allowed');

class  case_movement_controller extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/Case_movement_model', 'movement');
        $this->load->model('LegalServices/LegalServicesModel', 'legal');
        $this->load->model('LegalServices/Cases_model', 'case');
        $this->load->helper('date');
    }

    public function edit($ServID, $id)
    {
        if (!$id) {
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("Service/$ServID"));
        }
        if ($this->input->post()) {
            $data = $this->input->post();
            $success = $this->movement->update($ServID, $id, $data);
            if ($success) {
                $id = $this->movement->add($ServID,$id, $data);
                if ($id) {
                    set_alert('success', _l('updated_successfully'));
                    redirect(admin_url("Service/$ServID"));
                }
            } else {
                set_alert('warning', _l('problem_updating'));
                redirect(admin_url("Service/$ServID"));
            }
        }
        $data['case']                  = $this->case->get($id);
        $data['case_members']          = $this->case->get_project_members($id);
        $data['case_judges']           = $this->case->get_case_judges($id);
        $data['service']               = $this->legal->get_service_by_id($ServID)->row();
        $data['statuses']              = $this->case->get_project_statuses();
        $data['staff']                 = $this->staff_model->get('', ['active' => 1]);
        $data['ServID']                = $ServID;
        $data['title']                 = _l("CaseMovement");
        $this->load->view('admin/LegalServices/cases/case_movement_edit', $data);
    }

    public function delete($ServID,$case_id,$id)
    {
        if(!$id){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("Case/view/$ServID/$case_id?group=CaseMovement"));
        }
        $response = $this->movement->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect(admin_url("Case/view/$ServID/$case_id?group=CaseMovement"));
    }

}