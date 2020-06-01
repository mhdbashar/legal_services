<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Phases_controller extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/Phase_model','phase');
        $this->load->model('LegalServices/LegalServicesModel', 'legal');
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_legal_services_phases');
        }
        $data['title'] = _l('legal_services_phases');
        $this->load->view('admin/LegalServices/phases/manage',$data);
    }

        public function add_edit_phase($id = '')
        {
            if (!is_admin()) {
                access_denied('Phase View');
            }
            if ($this->input->post()) {
                $data  = $this->input->post();
                if ($id == '') {
                    $id = $this->phase->add($data);
                    if ($id) {
                        set_alert('success', _l('added_successfully', _l('phase')));
                        redirect(admin_url('LegalServices/Phases_controller'));
                    }
                } else {
                    $success = $this->phase->update($id, $data);
                    if ($success) {
                        set_alert('success', _l('updated_successfully', _l('phase')));
                    }
                    redirect(admin_url('LegalServices/Phases_controller'));
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
            $this->load->view('admin/LegalServices/phases/add_edit', $data);
        }

        public function handle_phases($ServID,$project_id)
        {
            $url = $ServID == 1 ? 'Case' : 'SOther';
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
            $response = $this->phase->changeStatus($id);
            echo $response;
        }

        public function delete_phase($id)
        {
            if (!$id) {
                redirect(admin_url('LegalServices/Phases_controller'));
            }
            $response = $this->phase->delete($id);
            if ($response == true) {
                set_alert('success', _l('deleted', _l('phase')));
            } else {
                set_alert('warning', _l('problem_deleting', _l('phase')));
            }
            redirect(admin_url('LegalServices/Phases_controller'));
        }

    public function back_to_previous_phase($relid, $slug1, $slug2 = null)
    {
        $response = $this->phase->return_to_previous_phase($relid, $slug1, $slug2);
        echo $response;
    }

}
