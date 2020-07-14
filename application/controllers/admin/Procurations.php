<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Procurations extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Procurations_model');
        $this->load->model('Procurationtype_model');
        $this->load->model('Procurationstate_model');
        $this->load->model('LegalServices/Cases_model');
        $client_id=-1;
    }

    /* List all Procurations */

    /* List all client Procurations */
    public function table($clientid = '')
    {
        // if (!has_permission('procurations', '', 'view') && !has_permission('procurations', '', 'view_own')) {
        //     ajax_access_denied();
        // }

        $this->app->get_table_data('my_procurations', [
            'clientid' => $clientid,
        ]);
    }
    /* Edit Procuration or Add new if passed id */
    public function procuration($id = '')
    {
        // if (!is_admin()) {
        //     access_denied('procurations');
        // }
        $client_id=$this->input->get('client_id');
        if ($this->input->post()) {
            $data            = $this->input->post();
            $data['addedfrom']=get_staff_user_id();
            // $data['message'] = $this->input->post('message', false);
            if ($id == '') {
                $id = $this->Procurations_model->add($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('procuration')));
                    echo json_encode([
                        'url'       => admin_url('clients/client/'.$client_id.'?group=procurations'),
                        'id' => $id,
                    ]);
                    die;
                    //redirect(admin_url('clients/client/'.$client_id.'?group=procurations'));
                }
            } else {
                $success = $this->Procurations_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('procuration')));
                }
                echo json_encode([
                    'url'       => admin_url('clients/client/'.$client_id.'?group=procurations'),
                    'id' => $id,
                ]);
                die;
                // redirect(admin_url('clients/client/'.$client_id.'?group=procurations'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('procuration'));
        } else {
            $data['procurations'] = $this->Procurations_model->get($id);
            $data['procuration_cases'] = $this->Procurations_model->get_procuration_cases($id);


            $title                = _l('edit', _l('procuration'));
        }
        $data['client'] = $client_id;
        $data['title'] = $title;
        $data['types'] = $this->Procurationtype_model->get();
        $data['cases'] = $this->Cases_model->GetClientCases($client_id);
        //$data['cases'] = $this->Cases_model->getCases_or_Case();

        $data['states'] = $this->Procurationstate_model->get();
        $this->load->view('admin/procurations/procurations', $data);
    }

    /* Delete Procuration from database */
    public function procurationd($id,$client_id)
    {
        if (!$id) {
            redirect(admin_url('clients/client/'.$client_id.'?group=procurations'));
        }
        // if (!is_admin()) {
        //     access_denied('procurations');
        // }
        $response = $this->Procurations_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('procuration')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('procuration')));
        }
        // redirect($_SERVER['HTTP_REFERER']);
        redirect(admin_url('clients/client/'.$client_id.'?group=procurations'));
    }
    public function add_procuration_attachment($id,$client_id)
    {
        handle_procuration_attachments($id);
        echo json_encode([
            'url' => admin_url('clients/client/'.$client_id.'?group=procurations'),
        ]);
    }

    public function delete_procuration_attachment($id, $client_id, $preview = '')
    {
        $this->db->where('rel_id', $id);
        $this->db->where('rel_type', 'procurations');
        $file = $this->db->get(db_prefix().'files')->row();

        if ($file->staffid == get_staff_user_id() || is_admin()) {
            $success = $this->Procurations_model->delete_procuration_attachment($id);
            if ($success) {
                set_alert('success', _l('deleted', _l('procuration_doc')));
            } else {
                set_alert('warning', _l('problem_deleting', _l('procuration_doc_lowercase')));
            }
            if ($preview == '') {
                redirect(admin_url('procurations/procuration/'. $id.'?client_id='.$client_id));
            }
        } else {
            access_denied('procurations');
        }
    }

}
