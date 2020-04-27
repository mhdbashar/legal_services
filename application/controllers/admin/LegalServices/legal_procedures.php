<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Legal_procedures extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/Legal_procedures_model' , 'procedures');
        $this->load->model('LegalServices/LegalServicesModel' , 'legal');
        $this->load->model('contracts_model');
    }

    public function index()
    {
        $data['category'] = $this->procedures->get('',
           array(
               'type_id'   => 2,
               'parent_id' => 0
               )
        );
        $data['legal_services'] = $this->legal->get_all_services(['is_module' => 0], false);
        $data['title'] = _l('legal_procedures_management');
        $this->load->view('admin/LegalServices/legal_procedures/manage',$data);
    }

    public function get_sub_cat($parent_id)
    {
        $response = $this->procedures->get('',
            array(
                'type_id'   => 2,
                'parent_id' => $parent_id
            ));
        echo json_encode($response);
    }

    public function add($parent_id='')
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $id = $this->procedures->add($parent_id,$data);
            if ($id) {
                set_alert('success', _l('added_successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function edit($CatID)
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $success = $this->legal->update_category_data($CatID,$data);
            if ($success) {
                set_alert('success', _l('updated_successfully'));
            }else {
                set_alert('warning', _l('problem_updating'));
            }
            redirect(admin_url('LegalServices/Legal_procedures'));
        }
        $data['category'] = $this->legal->GetCategoryById($CatID)->row();
        $data['title']  = _l('EditCategory');
        $this->load->view('admin/LegalServices/categories/EditCategory',$data);
    }

    public function delete($CatID)
    {
        $response = $this->legal->delete_category($CatID);
        if ($response == true) {
            set_alert('success', _l('deleted'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect(admin_url('LegalServices/Legal_procedures'));
    }

    public function add_list()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $id = $this->procedures->add_list($data);
            if ($id) {
                set_alert('success', _l('added_successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                set_alert('danger', _l('procedure_list_exist'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function delete_list($id)
    {
        if(!$id || $id == ''){
            set_alert('warning', _l('problem_deleting'));
            return false;
        }
        $res = $this->procedures->delete_list($id);;
        if($res){
            set_alert('success', _l('deleted_successfully'));
        }else{
            set_alert('warning', _l('problem_deleting'));
            return false;
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_legal_procedure()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $id = $this->procedures->add_legal_procedure($data);
            if ($id) {
                set_alert('success', _l('added_successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function delete_procedure($id)
    {
        if(!$id || $id == ''){
            set_alert('warning', _l('problem_deleting'));
            return false;
        }
        $res = $this->procedures->delete_procedure($id);;
        if($res){
            set_alert('success', _l('deleted_successfully'));
        }else{
            set_alert('warning', _l('problem_deleting'));
            return false;
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    ///////////////////////////////////////////////////////
    /* Contract Controlletr */

    /* Edit contract or add new contract */
    public function procedure_text($id = '')
    {
        if ($this->input->post()) {
            if ($id == '') {
                /*if (!has_permission('contracts', '', 'create')) {
                    access_denied('contracts');
                }*/
                $id = $this->contracts_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('legal_procedure')));
                    redirect(admin_url('LegalServices/legal_procedures/procedure_text/' . $id));
                }
            } else {
                /*if (!has_permission('contracts', '', 'edit')) {
                    access_denied('contracts');
                }*/
                $success = $this->contracts_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('legal_procedure')));
                }
                redirect(admin_url('LegalServices/legal_procedures/procedure_text/' . $id));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('legal_procedure'));
        } else {
            $data['contract']                 = $this->procedures->get_contract($id, ['type_id' => 2], true);
            //$data['contract_renewal_history'] = $this->contracts_model->get_contract_renewal_history($id);
            $data['totalNotes']               = total_rows(db_prefix() . 'notes', ['rel_id' => $id, 'rel_type' => 'contract']);
            if (!$data['contract'] || (!has_permission('contracts', '', 'view') && $data['contract']->addedfrom != get_staff_user_id())) {
                blank_page(_l('procedure_not_found'));
            }

            $data['contract_merge_fields'] = $this->app_merge_fields->get_flat('contract', ['other', 'client'], '{email_signature}');

            $title = $data['contract']->subject;

            $data = array_merge($data, prepare_mail_preview_data('contract_send_to_customer', $data['contract']->client));
        }

        if ($this->input->get('customer_id')) {
            $data['customer_id'] = $this->input->get('customer_id');
        }

        //$this->load->model('currencies_model');
        //$data['base_currency'] = $this->currencies_model->get_base_currency();
        //$data['types']         = $this->contracts_model->get_contract_types();
        $data['legal_services'] = $this->legal->get_all_services(['is_module' => 0], true);
        $data['title']         = $title;
        $data['bodyclass']     = 'contract';
        $this->load->view('admin/LegalServices/legal_procedures/procedure_text', $data);
    }

    /*public function save_text()
    {
        $success = false;
        $message = '';
        $can_add = false;
        if(html_purify($this->input->post('content', false)) != ''){
            $can_add = true;
        }
        if ($can_add){
            $data = array(
                'text'         => html_purify($this->input->post('content', false)),
                'edit_by'      => get_staff_user_id(),
                'ref_table_id' => $this->input->post('contract_id'),
                'date'         => date('Y-m-d H:i:s')
            );
            $this->db->insert('procedures_log', $data);
        }

        $this->db->where('id', $this->input->post('contract_id'));
        $this->db->update(db_prefix() . 'contracts', [
            'content' => html_purify($this->input->post('content', false)),
        ]);

        $success = $this->db->affected_rows() > 0;
        $message = _l('updated_successfully', _l('legal_procedure'));

        echo json_encode([
            'success' => $success,
            'message' => $message,
        ]);
    }*/

    public function save_contract_data()
    {
        /*if (!has_permission('contracts', '', 'edit')) {
            header('HTTP/1.0 400 Bad error');
            echo json_encode([
                'success' => false,
                'message' => _l('access_denied'),
            ]);
            die;
        }*/

        $success = false;
        $message = '';
        $this->db->where('id', $this->input->post('contract_id'));
        $this->db->update(db_prefix() . 'contracts', [
            'content' => html_purify($this->input->post('content', false)),
            'dateadded' => date('Y-m-d H:i:s')
        ]);

        $success = $this->db->affected_rows() > 0;
        $message = _l('updated_successfully', _l('legal_procedure'));

        echo json_encode([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function pdf($id)
    {
        /*if (!has_permission('contracts', '', 'view') && !has_permission('contracts', '', 'view_own')) {
            access_denied('contracts');
        }*/
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $contract = $this->procedures->get_contract($id, ['type_id' => 2], true);

        try {
            $pdf = contract_pdf($contract);
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }

        $type = 'D';

        if ($this->input->get('output_type')) {
            $type = $this->input->get('output_type');
        }

        if ($this->input->get('print')) {
            $type = 'I';
        }

        $pdf->Output(slug_it($contract->subject) . '.pdf', $type);
    }

    public function add_comment()
    {
        if ($this->input->post()) {
            echo json_encode([
                'success' => $this->procedures->add_comment($this->input->post()),
            ]);
        }
    }

    /* Delete contract from database */
    public function delete_contract($id)
    {
        /*if (!has_permission('contracts', '', 'delete')) {
            access_denied('contracts');
        }*/
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $response = $this->procedures->delete_contract($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('legal_procedure')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('legal_procedure')));
        }
        if (strpos($_SERVER['HTTP_REFERER'], 'clients/') !== false) {
            redirect(admin_url());
        } else {
            redirect(admin_url());
        }
    }

    /**
     * @return mixed
     */
    public function save_as_template()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $list_data = array(
                'cat_id' => $data['cat_id'],
                'rel_type' => $data['rel_type'],
                'rel_id' => $data['rel_id']
            );
            $list_id = $this->procedures->add_list($list_data);
            if($list_id){
                $proc_data = array(
                    'subcat_id' => $data['subcat_id'],
                    'list_id' => $list_id,
                    'content' => $data['content']
                );
                $id = $this->procedures->add_legal_procedure($proc_data);
                if ($id) {
                    set_alert('success', _l('procedure_template_assigned_to_service'));
                    redirect($_SERVER['HTTP_REFERER']);
                }else{
                    set_alert('danger', _l('Faild'));
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }else{
                set_alert('danger', _l('procedure_list_exist'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

}