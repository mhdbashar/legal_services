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
        $this->load->model('legalservices/Cases_model', 'case');
        $this->load->model('legalservices/Disputes_cases_model', 'Dcase');
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

    public function build_dropdown_cases($select=0) {

        // $select=$this->input->post('select');
        // $this->db->where('clientid', $select);
        // $cases = $this->db->get(db_prefix() . 'my_cases')->result();
        // $output = '<option value=""></option>';
        // foreach ($cases as $row)
        // {
        //     if($row->clientid==$select)$selected="selected";else $selected="";
        //     $staff_language = get_staff_default_language(get_staff_user_id());
            
        //         $output .= '<option value="'.$row->id.'" '.$selected.' >'.$row->name.'</option>';
            
        // }
        // echo $output;

        // $select=$this->input->post('select');
        if ($select != 0) {
            $this->db->where('clientid', $select);
        }
        $cases = $this->db->get(db_prefix() . 'my_cases')->result_array();
        $data = [];
        foreach ($cases as $case) {
            $_array = [];
            $_array['key'] = $case['id'];
            $_array['value'] = $case['name'];
            $data[] = $_array;
        }
        // return $data;

        echo json_encode(['success'=>true,'data'=>$data]);
        die();
    }

    public function all(){
        if (!has_permission('procurations', '', 'view') && !is_admin()) {
            access_denied('Procurations');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_procurations', [
                'client_id' => '', 
                'request' => 'no_request',
                'all' => 1
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

    public function file($id){
        $procuration = $this->procurations_model->get($id);
        echo json_encode(site_url($procuration->file));
        die();
    }

    public function pdf($id)
    {
        if (!$id) {
            redirect(admin_url('procuration/all'));
        }

        if (!has_permission('procurations', '', 'view') && !is_admin()) {
            access_denied('Procurations');
        }



            $procuration = $this->procurations_model->get($id);
        if ( !get_option('wathq_api_key'))
            if ($procuration->file != null)
                redirect(site_url($procuration->file));
            else{
                set_alert('warning', 'No file!');
                redirect(admin_url('procuration/all'));
            }

        $procuration        = hooks()->apply_filters('before_admin_view_procuration_pdf', $procuration);

        // $invoice_number = format_invoice_number($invoice->id);

        try {
            $pdf = procuration_pdf($procuration);
        } catch (Exception $e) {
            $message = $e->getMessage();
            echo $message;
            if (strpos($message, 'Unable to get the size of the image') !== false) {
                show_pdf_unable_to_get_image_size_error();
            }
            die;
        }

        $type = 'D';

        if ($this->input->get('output_type')) {
            $type = $this->input->get('output_type');
        }

        if ($this->input->get('print')) {
            $type = 'I';
        }

        $pdf_name = $procuration->name;
        $pdf->Output(mb_strtoupper(slug_it($pdf_name)) . '.pdf', $type);

    }

    /* Edit Procuration or add new if passed id */
    public function procurationcu($request = '', $id = '', $case = '')
    {
        
        $last_id = $this->index();
        

        if ($this->input->post()) {
            $data            = $this->input->post();
            // $data['start_date'] = to_sql_date($data['start_date']);
            // $data['end_date'] = to_sql_date($data['end_date']);
            // $data['message'] = $this->input->post('message', false);

            $data['description'] = $this->input->post('description', false);
            $redirect = admin_url('procuration/all');
            if(is_numeric($request)){
                $redirect = admin_url('clients/client/' . $request) . '?group=procurations';
            }
            if(is_numeric($case)){
                $redirect = admin_url('Case/view/1/' . $case) . '?group=procuration';
            }
            
            if ($id == '' or !is_numeric($id)) {
                $data['id'] = $last_id;
                if (has_permission('procurations', '', 'create') or is_admin()){
                    $id = $this->procurations_model->add($data);
                    if ($id) {
                        set_alert('success', _l('added_successfully'));
                        redirect($redirect);
                    }
                }
            } else {
                if (has_permission('procurations', '', 'edit') or is_admin()) {
                    $success = $this->procurations_model->update($data, $id);
                    if ($success) {
                        set_alert('success', _l('updated_successfully'));
                    }
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
        if(is_numeric($request)){
            $data['cases'] = $this->case->get('', ['clientid' => $request]);
        }
        $data['id'] = $id;
        $data['title'] = $title;

        $this->load->view('admin/procuration/procuration', $data);
    }

    /* Edit Procuration state or add new if passed id */
    public function statecu($id = '')
    {
        if (!has_permission('procurations', '', 'create') && !is_admin()) {
            access_denied('Procuration State');
        }
        if ($this->input->post()) {
            $data            = $this->input->post();
            // $data['message'] = $this->input->post('message', false);
            if ($id == '') {
                $id = $this->procurationstate_model->add($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('procuration_state')));
                    redirect(admin_url('procuration/state'));
                }
            } else {
                $success = $this->procurationstate_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('procuration_state')));
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
        if (!has_permission('procurations', '', 'create') && !is_admin()) {
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
        if (!has_permission('procurations', '', 'create') && !is_admin()) {
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
          if (!has_permission('procurations', '', 'create') && !is_admin()) {
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
          if (!has_permission('procurations', '', 'delete') && !is_admin()) {
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

        if ($file->staffid == get_staff_user_id() || has_permission('procurations', '', 'delete') ) {
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
