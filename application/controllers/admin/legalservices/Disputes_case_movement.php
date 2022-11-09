<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Disputes_case_movement extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('legalservices/disputes_cases/Disputes_case_movement_model', 'Dmovement');
        $this->load->model('legalservices/LegalServicesModel', 'legal');
        $this->load->model('legalservices/disputes_cases/Disputes_cases_model', 'Dcase');
        $this->load->helper('date');
        $this->load->helper('disputes_cases_helper');
    }

    public function edit($ServID, $id)
    {
        if (!$id) {
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("Service/$ServID"));
        }
        if ($this->input->post()) {
            $data = $this->input->post();
//            echo '<pre>';echo print_r($data);exit();
            if (!isset($data['childsubcat_id'])) $data['childsubcat_id'] = '0';
            if (!isset($data['subcat_id'])) $data['subcat_id'] = '0';
            $success = $this->Dmovement->update($ServID, $id, $data);
            if ($success) {
                $success = $this->Dmovement->add($ServID,$id, $data);
                if ($success) {
                    set_alert('success', _l('updated_successfully'));
                    redirect(admin_url("Disputes_cases/view/$ServID/$id?group=CaseMovement"));
                }
            } else {
                set_alert('warning', _l('problem_updating'));
                redirect(admin_url("Service/$ServID"));
            }
        }
        $data['case']                  = $this->Dcase->get($id);
        $data['case_members']          = $this->Dcase->get_project_members($id);
        $data['case_judges']           = $this->Dcase->get_case_judges($id);
        $data['case_opponents']        = $this->Dcase->get_case_opponents($id);
        $data['service']               = $this->legal->get_service_by_id($ServID)->row();
        $data['statuses']              = $this->Dcase->get_project_statuses();
        $data['staff']                 = $this->staff_model->get('', ['active' => 1]);
        $data['ServID']                = $ServID;
        $data['title']                 = _l("CaseMovement");
        $this->load->view('admin/legalservices/disputes_cases/case_movement_edit', $data);
    }

    public function delete($ServID,$case_id,$id)
    {
        if(!$id){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("Disputes_cases/view/$ServID/$case_id?group=CaseMovement"));
        }
        $response = $this->Dmovement->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect(admin_url("Disputes_cases/view/$ServID/$case_id?group=CaseMovement"));
    }

}