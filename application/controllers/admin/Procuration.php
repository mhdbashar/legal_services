<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Procuration extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('procurationstate_model');
        $this->load->model('procurationtype_model');
        $this->load->model('procurations_model');
        $this->load->model('Staff_model');
        $this->load->model('LegalServices/Cases_model', 'case');
    }

    /* List all Procuration */
    public function index()
    {
        $this->db->select('max(id)');
        $max = ($this->db->get('tblprocurations')->row_array())['max(id)'] + 1;
        if($max != null){
            return $max;
        }else{
            return 0;
        }
    }

    public function all(){
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_procurations', [
                'client_id' => '', 
                'request' => 'no_request'
            ]);
        }
        $data['title'] = _l('procuration');
        $this->load->view('admin/procuration/manage', $data);
    }


    /* List all Procuration state */
    public function state()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_procurationstate');
        }
        $data['title'] = _l('procuration_state');
        $this->load->view('admin/procuration/managestate', $data);
    }

    /* List all Procuration Type */
    public function type()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_procurationtype');
        }
        $data['title'] = _l('procuration_type');
        $this->load->view('admin/procuration/managetype', $data);
    }

    /* Edit Procuration or add new if passed id */
    public function procurationcu($request = '', $id = '', $case = '')
    {
        if (!is_admin()) {
            access_denied('Procuration');
        }
        
        $last_id = $this->index();
        

        if ($this->input->post()) {
            $data            = $this->input->post();
            // $data['message'] = $this->input->post('message', false);
            if(is_numeric($request)){
                // URL Example : http://localhost/legal/admin/clients/client/3?group=procurations
                $redirect = admin_url('clients/client/' . $request) . '?group=procurations';
            }elseif(is_numeric($case)){
                // URL Example : http://localhost/legal/admin/Case/view/1/4?group=procuration
                $redirect = admin_url('Case/view/1/' . $case) . '?group=procuration';
            }else{
                $redirect = admin_url('procuration/all');
            }
            
            if ($id == '' or !is_numeric($id)) {
                $data['id'] = $last_id;
                $id = $this->procurations_model->add($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('procuration')));
                    redirect($redirect);
                }
            } else {
                $success = $this->procurations_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('procuration')));
                }
                redirect($redirect);
            }
        }
        if ($id == '') {
            $title = _l('add_new_procuration');
        } else {
            $data['procuration'] = $this->procurations_model->get($id);
            $title                = _l('edit_procuration');
        }
        $data['last_id'] = $last_id;
        $data['case_r'] = $case;
        $data['request'] = $request;
        $data['states'] = $this->procurationstate_model->get();
        $data['types'] = $this->procurationtype_model->get();
        $data['cases'] = $this->case->get();
        $data['id'] = $id;
        $data['title'] = $title;

        $this->load->view('admin/procuration/procuration', $data);
    }

    /* Edit Procuration state or add new if passed id */
    public function statecu($id = '')
    {
        if (!is_admin()) {
            access_denied('Procuration State');
        }
        if ($this->input->post()) {
            $data            = $this->input->post();
            // $data['message'] = $this->input->post('message', false);
            if ($id == '') {
                $id = $this->procurationstate_model->add($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', 'Procuration State'));
                    redirect(admin_url('procuration/state'));
                }
            } else {
                $success = $this->procurationstate_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', 'Procuration State'));
                }
                redirect(admin_url('procuration/state'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('procuration_state'));
        } else {
            $data['procurationstate'] = $this->procurationstate_model->get($id);
            $title                = _l('edit', _l('procuration_state'));
        }
        $data['title'] = $title;
        $this->load->view('admin/procuration/procurationstate', $data);
    }

    /* Edit Procuration type or add new if passed id */
    public function typecu($id = '')
    {
        if (!is_admin()) {
            access_denied('Procuration Type');
        }
        if ($this->input->post()) {
            $data            = $this->input->post();
            // $data['message'] = $this->input->post('message', false);
            if ($id == '') {
                $id = $this->procurationtype_model->add($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('procuration_type')));
                    redirect(admin_url('procuration/type'));
                }
            } else {
                $success = $this->procurationtype_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('procuration_type')));
                }
                redirect(admin_url('procuration/type'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('procuration_type'));
        } else {
            $data['procurationtype'] = $this->procurationtype_model->get($id);
            $title                = _l('edit', _l('procuration_type'));
        }
        $data['title'] = $title;
        $this->load->view('admin/procuration/procurationtype', $data);
    }

    /* Delete procurationstate from database */
    public function stated($id)
    {
        if (!$id) {
            redirect(admin_url('procuration/state'));
        }
        if (!is_admin()) {
            access_denied('Procuration State');
        }
        $response = $this->procurationstate_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', 'Procuration State'));
        } else {
            set_alert('warning', _l('problem_deleting', 'Procuration State'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

      /* Delete procurationtype from database */
      public function typed($id)
      {
          if (!$id) {
              redirect(admin_url('procuration/type'));
          }
          if (!is_admin()) {
              access_denied('Procuration Type');
          }
          $response = $this->procurationtype_model->delete($id);
          if ($response == true) {
              set_alert('success', _l('deleted', 'Procuration Type'));
          } else {
              set_alert('warning', _l('problem_deleting', 'Procuration Type'));
          }
          redirect($_SERVER['HTTP_REFERER']);
      }

      public function delete($id)
      {
          if (!$id) {
              redirect(admin_url('procuration/type'));
          }
          if (!is_admin()) {
              access_denied('Procuration Type');
          }
          $response = $this->procurations_model->delete($id);
          if ($response == true) {
              set_alert('success', _l('deleted', 'Procuration'));
          } else {
              set_alert('warning', _l('problem_deleting', 'Procuration'));
          }
          redirect($_SERVER['HTTP_REFERER']);
      }

      public function add_procuration_attachment($id)
    {
        handle_procuration_attachments($id);
        echo json_encode([
            'url' => admin_url('procuration/all'),
        ]);
    }

    public function delete_procuration_attachment($id, $preview = '')
    {
        $this->db->where('rel_id', $id);
        $this->db->where('rel_type', 'procuration');
        $file = $this->db->get(db_prefix().'files')->row();

        if ($file->staffid == get_staff_user_id() || is_admin()) {
            $success = $this->procurations_model->delete_procuration_attachment($id);
            if ($success) {
                set_alert('success', _l('deleted', _l('procuration_receipt')));
            } else {
                set_alert('warning', _l('problem_deleting', _l('procuration_receipt_lowercase')));
            }
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            access_denied('expenses');
        }
    }

}
