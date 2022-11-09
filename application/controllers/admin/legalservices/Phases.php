<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Phases extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('legalservices/Phase_model','phase');
        $this->load->model('legalservices/LegalServicesModel', 'legal');
    }

    public function index()
    {
        if (!has_permission('legal_services_phases', '', 'create')) {
            access_denied('legal_services_phases');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_legal_services_phases');
        }
        $data['title'] = _l('legal_services_phases');
        $this->load->view('admin/legalservices/phases/manage',$data);
    }

        public function add_edit_phase($id = '')
        {
            if (!has_permission('legal_services_phases', '', 'create') || !has_permission('legal_services_phases', '', 'edit')) {
                access_denied('legal_services_phases');
            }
            if ($this->input->post()) {
                $data  = $this->input->post();
                if ($id == '') {
                    $id = $this->phase->add($data);
                    if ($id) {
                        set_alert('success', _l('added_successfully', _l('phase')));
                        redirect(admin_url('legalservices/phases'));
                    }
                } else {
                    $success = $this->phase->update($id, $data);
                    if ($success) {
                        set_alert('success', _l('updated_successfully', _l('phase')));
                    }
                    redirect(admin_url('legalservices/phases'));
                }
            }
            if ($id == '') {
                $title = _l('add_new', _l('phase'));
            } else {
                $data['phase'] = $this->phase->get($id);
                $title         = _l('edit', _l('phase'));
            }
            $data['legal_services'] = $this->legal->get_all_services();
            $data['title'] = $title;
            $this->load->view('admin/legalservices/phases/add_edit', $data);
        }

        public function handle_phases($ServID,$project_id)
        {
            if($ServID == 1){
                $url = 'Case';
            }elseif ($ServID == 22){
                $url = 'Disputes_cases';
            }else{
                $url = 'SOther';
            }
            if ($this->input->post()) {
                $data = $this->input->post();
                $added = $this->phase->handle_phase_data($ServID, $project_id, $data);
                if ($added) {
                    set_alert('success', _l('phase_compleate'));
                    redirect(admin_url($url.'/view/'.$ServID.'/'. $project_id . '?group=Phase'));
                }
            }
        }

        public function activeStatus($id)
        {
            if (!has_permission('legal_services_phases', '', 'active')) {
                access_denied('legal_services_phases');
            }
            $response = $this->phase->changeStatus($id);
            echo $response;
        }

        public function delete_phase($id)
        {
            if (!has_permission('legal_services_phases', '', 'delete')) {
                access_denied('legal_services_phases');
            }
            if (!$id) {
                redirect(admin_url('legalservices/phases'));
            }
            $response = $this->phase->delete($id);
            if ($response == true) {
                set_alert('success', _l('deleted', _l('phase')));
            } else {
                set_alert('warning', _l('problem_deleting', _l('phase')));
            }
            redirect(admin_url('legalservices/phases'));
        }

    public function back_to_previous_phase($relid, $slug1, $slug2 = null)
    {
        $response = $this->phase->return_to_previous_phase($relid, $slug1, $slug2);
        echo $response;
    }

}
