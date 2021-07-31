<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Contracts extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('hr_contracts_model');
        $this->load->model('legalservices/LegalServicesModel', 'legal');
        $this->load->model('templates_model');
    }

    function validate_contract_number($id = '')
    {
        $number = $this->input->post('number');


        $query = $this->db->get_where(db_prefix().'hr_contracts', array('number' => $number, 'id!=' => $id));
        if($query->num_rows() < 1){
            $data['status'] = TRUE;
        }else{
            $data['status'] = false;
        }
        echo json_encode($data);
    }

    /* List all contracts */
    public function index()
    {

        if (!has_permission('hr_contracts', '', 'view') && !has_permission('hr_contracts', '', 'view_own')) {
            access_denied('contracts');
        }

        $data['expiring']               = $this->hr_contracts_model->get_contracts_about_to_expire(get_staff_user_id());
        $data['count_active']           = count_active_contracts();
        $data['count_expired']          = count_expired_contracts();
        $data['count_recently_created'] = count_recently_created_contracts();
        $data['count_trash']            = count_trash_contracts();
        $data['chart_types']            = json_encode($this->hr_contracts_model->get_contracts_types_chart_data());
        $data['chart_types_values']     = json_encode($this->hr_contracts_model->get_contracts_types_values_chart_data());
        $data['contract_types']         = $this->hr_contracts_model->get_contract_types();
        $data['years']                  = $this->hr_contracts_model->get_contracts_years();
        $this->load->model('currencies_model');
        $data['base_currency'] = $this->currencies_model->get_base_currency();
        $data['title']         = _l('contracts');
        $this->load->view('admin/contracts/manage', $data);
    }

    public function table($clientid = '')
    {
        if (!has_permission('hr_contracts', '', 'view') && !has_permission('hr_contracts', '', 'view_own')) {
            ajax_access_denied();
        }
        $this->hrmapp->get_table_data('hr_contracts', [
            'clientid' => $clientid,
        ]);
    }

    public function table_services($clientid = '',$rel_sid='', $rel_stype = '')
    {
        if (!has_permission('hr_contracts', '', 'view') && !has_permission('hr_contracts', '', 'view_own')) {
            ajax_access_denied();
        }
        if($clientid == 0){
            $clientid = '';
        }
        $this->app->get_table_data('contracts', [
            'clientid'  => $clientid,
            'rel_sid'   => $rel_sid,
            'rel_stype' => $rel_stype,
        ]);
    }

    /* Edit contract or add new contract */
    public function contract($id = '')
    {
        if ($this->input->post()) {
            if ($id == '') {
                if (!has_permission('hr_contracts', '', 'create')) {
                    access_denied('contracts');
                }
                $id = $this->hr_contracts_model->add($this->input->post());
                if ($id) {
                    update_option('next_hr_contract_number', get_option('next_hr_contract_number') + 1);
                    set_alert('success', _l('added_successfully', _l('contract')));
                    redirect(admin_url('hr/contracts/contract/' . $id));
                }
            } else {
                if (!has_permission('hr_contracts', '', 'edit')) {
                    access_denied('contracts');
                }
                $success = $this->hr_contracts_model->update($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('contract')));
                }
                redirect(admin_url('hr/contracts/contract/' . $id));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('contract_lowercase'));
        } else {
            $data['contract']                 = $this->hr_contracts_model->get($id, [], true);
            $data['contract_renewal_history'] = $this->hr_contracts_model->get_contract_renewal_history($id);
            $data['totalNotes']               = total_rows(db_prefix() . 'notes', ['rel_id' => $id, 'rel_type' => 'hr_contract']);
            if (!$data['contract'] || (!has_permission('hr_contracts', '', 'view') && $data['contract']->client != get_staff_user_id() && $data['contract']->addedfrom != get_staff_user_id())) {
                blank_page(_l('contract_not_found'));
            }

            $contract_merge_fields = $this->app_merge_fields->get_flat('contract', ['other', 'staff'], '{email_signature}');

            $salary_merge_fileds = [
                'name' => _l('salary'),
                'key' => '{salary}',
                'fromoption' => 1,
                'avilable' => [],
                'format' => []
            ];
            $allowance_merge_fileds = [
                'name' => _l('allowances'),
                'key' => '{allowances}',
                'fromoption' => 1,
                'avilable' => [],
                'format' => []
            ];
            $total_salary_merge_fileds = [
                'name' => _l('total_salary'),
                'key' => '{total_salary}',
                'fromoption' => 1,
                'avilable' => [],
                'format' => []
            ];
            $contract_merge_fields[0][] = $salary_merge_fileds;
            $contract_merge_fields[0][] = $total_salary_merge_fileds;
            $contract_merge_fields[0][] = $allowance_merge_fileds;
            unset($contract_merge_fields[1][5]);
            $data['contract_merge_fields'] = $contract_merge_fields;

            $title = $data['contract']->subject;

            $data = array_merge($data, prepare_mail_preview_data('contract_send_to_customer', $data['contract']->client));
        }

        if ($this->input->get('customer_id')) {
            $data['customer_id'] = $this->input->get('customer_id');
        }

        $this->load->model('currencies_model');
        $data['base_currency'] = $this->currencies_model->get_base_currency();
        $data['types']         = $this->hr_contracts_model->get_contract_types();
        $data['legal_services'] = $this->legal->get_all_services([], true);
        $data['title']         = $title;
        $data['bodyclass']     = 'contract';
        $this->load->model('staff_model');
        $data['staffs'] = $this->staff_model->get();
        $this->load->view('admin/contracts/contract', $data);
    }

    public function get_template()
    {
        $name = $this->input->get('name');
        echo $this->load->view('admin/hr/contracts/templates/' . $name, [], true);
    }
    public function templates($id = null)
    {
        $data['rel_type'] = $this->input->post('rel_type');
        $data['rel_id']   = $this->input->post('rel_id');

        $where             = ['type' => $data['rel_type']];
        $data['templates'] = $this->templates_model->get($id, $where);

        if (is_numeric($id)) {
            $template = $this->templates_model->get($id);

            echo json_encode([
                'data' => $template,
            ]);
            die;
        }

        $this->load->view('admin/contracts/templates', $data);
    }
    protected function authorize($id)
    {
        $template = $this->templates_model->get($id);

        if ($template->addedfrom != get_staff_user_id() && !is_admin()) {
            ajax_access_denied();
        }
    }
    public function delete_hr_template($id)
    {
        $this->authorize($id);

        $this->templates_model->delete($id);

        echo json_encode([
            'success' => true,
        ]);
    }
    public function template($id = null)
    {
        $content = $this->input->post('content', false);
        $content = html_purify($content);

        $data['name']      = $this->input->post('name');
        $data['content']   = $content;
        $data['addedfrom'] = get_staff_user_id();
        $data['type']      = $this->input->post('rel_type');

        // so when modal is submitted, it returns to the proposal/contract that was being edited.
        $rel_id = $this->input->post('rel_id');

        if (is_numeric($id)) {
            $this->authorize($id);
            $success = $this->templates_model->update($id, $data);
            $message = _l('template_updated');
        } else {
            $success = $this->templates_model->create($data);
            $message = _l('template_added');
        }

        if ($success) {
            set_alert('success', $message);
        }

        redirect(
            $data['type'] == 'hr_contracts' ?
                admin_url('hr/contracts/contract/' . $rel_id) :
                admin_url('proposals/list_proposals/' . $rel_id)
        );
    }
    public function modal()
    {
        $data['rel_type'] = $this->input->post('rel_type');

        // When modal is submitted, it returns to the proposal/contract that was being edited.
        $data['rel_id'] = $this->input->post('rel_id');

        if ($this->input->post('slug') == 'new') {
            $data['title'] = _l('add_template');
        } elseif ($this->input->post('slug') == 'edit') {
            $data['title'] = _l('edit_template');
            $data['id']    = $this->input->post('id');
            $this->authorize($data['id']);
            $data['template'] = $this->templates_model->get($data['id']);
        }

        $this->load->view('admin/contracts/modals/template', $data);
    }

    public function mark_as_signed($id)
    {
        if (!staff_can('edit', 'hr_contracts')) {
            access_denied('mark contract as signed');
        }

        $this->hr_contracts_model->mark_as_signed($id);

        redirect(admin_url('hr/contracts/contract/' . $id));
    }

    public function unmark_as_signed($id)
    {
        if (!staff_can('edit', 'hr_contracts')) {
            access_denied('mark contract as signed');
        }

        $this->hr_contracts_model->unmark_as_signed($id);

        redirect(admin_url('hr/contracts/contract/' . $id));
    }

    public function pdf($id)
    {
        if (!has_permission('hr_contracts', '', 'view') && !has_permission('hr_contracts', '', 'view_own')) {
            access_denied('contracts');
        }

        if (!$id) {
            redirect(admin_url('hr/contracts'));
        }

        $contract = $this->hr_contracts_model->get($id);

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

    public function send_to_email($id)
    {
        if (!has_permission('hr_contracts', '', 'view') && !has_permission('hr_contracts', '', 'view_own')) {
            access_denied('contracts');
        }
        $success = $this->hr_contracts_model->send_contract_to_client($id, $this->input->post('attach_pdf'), $this->input->post('cc'));
        if ($success) {
            set_alert('success', _l('contract_sent_to_client_success'));
        } else {
            set_alert('danger', _l('contract_sent_to_client_fail'));
        }
        redirect(admin_url('hr/contracts/contract/' . $id));
    }

    public function add_note($rel_id)
    {
        if ($this->input->post() && (has_permission('hr', '', 'view') || has_permission('hr', '', 'view_own'))) {
            $this->misc_model->add_note($this->input->post(), 'hr_contract', $rel_id);
            echo $rel_id;
        }
    }

    public function get_notes($id)
    {
        if ((has_permission('hr', '', 'view') || has_permission('hr', '', 'view_own'))) {
            $data['notes'] = $this->misc_model->get_notes($id, 'hr_contract');
            $this->load->view('admin/includes/sales_notes_template', $data);
        }
    }

    public function clear_signature($id)
    {
        if (has_permission('hr_contracts', '', 'delete')) {
            $this->hr_contracts_model->clear_signature($id);
        }

        redirect(admin_url('hr/contracts/contract/' . $id));
    }

    public function save_contract_data()
    {
        if (!has_permission('hr_contracts', '', 'edit')) {
            header('HTTP/1.0 400 Bad error');
            echo json_encode([
                'success' => false,
                'message' => _l('access_denied'),
            ]);
            die;
        }

        $success = false;
        $message = '';

        $this->db->where('id', $this->input->post('contract_id'));
        $this->db->update(db_prefix() . 'hr_contracts', [
                'content' => html_purify($this->input->post('content', false)),
        ]);

        $success = $this->db->affected_rows() > 0;
        $message = _l('updated_successfully', _l('contract'));

        echo json_encode([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function add_comment()
    {
        if ($this->input->post()) {
            echo json_encode([
                'success' => $this->hr_contracts_model->add_comment($this->input->post()),
            ]);
        }
    }

    public function edit_comment($id)
    {
        if ($this->input->post()) {
            echo json_encode([
                'success' => $this->hr_contracts_model->edit_comment($this->input->post(), $id),
                'message' => _l('comment_updated_successfully'),
            ]);
        }
    }

    public function get_comments($id)
    {
        $data['comments'] = $this->hr_contracts_model->get_comments($id);
        $this->load->view('admin/contracts/comments_template', $data);
    }

    public function remove_comment($id)
    {
        $this->db->where('id', $id);
        $comment = $this->db->get(db_prefix() . 'contract_comments')->row();
        if ($comment) {
            if ($comment->staffid != get_staff_user_id() && !is_admin()) {
                echo json_encode([
                    'success' => false,
                ]);
                die;
            }
            echo json_encode([
                'success' => $this->hr_contracts_model->remove_comment($id),
            ]);
        } else {
            echo json_encode([
                'success' => false,
            ]);
        }
    }

    public function renew()
    {
        if (!has_permission('hr_contracts', '', 'create') && !has_permission('hr_contracts', '', 'edit')) {
            access_denied('contracts');
        }
        if ($this->input->post()) {
            $data    = $this->input->post();
            $success = $this->hr_contracts_model->renew($data);
            if ($success) {
                set_alert('success', _l('contract_renewed_successfully'));
            } else {
                set_alert('warning', _l('contract_renewed_fail'));
            }
            redirect(admin_url('hr/contracts/contract/' . $data['contractid'] . '?tab=renewals'));
        }
    }

    public function delete_renewal($renewal_id, $contractid)
    {
        $success = $this->hr_contracts_model->delete_renewal($renewal_id, $contractid);
        if ($success) {
            set_alert('success', _l('contract_renewal_deleted'));
        } else {
            set_alert('warning', _l('contract_renewal_delete_fail'));
        }
        redirect(admin_url('hr/contracts/contract/' . $contractid . '?tab=renewals'));
    }

    public function copy($id)
    {
        if (!has_permission('hr_contracts', '', 'create')) {
            access_denied('contracts');
        }
        if (!$id) {
            redirect(admin_url('hr/contracts'));
        }
        $newId = $this->hr_contracts_model->copy($id);
        if ($newId) {
            set_alert('success', _l('contract_copied_successfully'));
        } else {
            set_alert('warning', _l('contract_copied_fail'));
        }
        redirect(admin_url('hr/contracts/contract/' . $newId));
    }

    /* Delete contract from database */
    public function delete($id)
    {
        if (!has_permission('hr_contracts', '', 'delete')) {
            access_denied('contracts');
        }
        if (!$id) {
            redirect(admin_url('hr/contracts'));
        }
        $response = $this->hr_contracts_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('contract')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('contract_lowercase')));
        }
        if (strpos($_SERVER['HTTP_REFERER'], 'clients/') !== false) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect(admin_url('hr/contracts'));
        }
    }

    /* Manage contract types Since Version 1.0.3 */
    public function type($id = '')
    {
        if (!is_admin() && get_option('staff_members_create_inline_contract_types') == '0') {
            access_denied('contracts');
        }
        if ($this->input->post()) {
            if (!$this->input->post('id')) {
                $id = $this->hr_contracts_model->add_contract_type($this->input->post());
                if ($id) {
                    $success = true;
                    $message = _l('added_successfully', _l('contract_type'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                    'id'      => $id,
                    'name'    => $this->input->post('name'),
                ]);
            } else {
                $data = $this->input->post();
                $id   = $data['id'];
                unset($data['id']);
                $success = $this->hr_contracts_model->update_contract_type($data, $id);
                $message = '';
                if ($success) {
                    $message = _l('updated_successfully', _l('contract_type'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
        }
    }

    public function types()
    {
        if (!is_admin()) {
            access_denied('contracts');
        }
        if ($this->input->is_ajax_request()) {
            $this->hrmapp->get_table_data('hr_contract_types');
        }
        $data['title'] = _l('contract_types');
        $this->load->view('admin/contracts/manage_types', $data);
    }

    /* Delete announcement from database */
    public function delete_contract_type($id)
    {
        if (!$id) {
            redirect(admin_url('hr/contracts/types'));
        }
        if (!is_admin()) {
            access_denied('contracts');
        }
        $response = $this->hr_contracts_model->delete_contract_type($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('contract_type_lowercase')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('contract_type')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('contract_type_lowercase')));
        }
        redirect(admin_url('hr/contracts/types'));
    }

    public function add_contract_attachment($id)
    {
        handle_hr_contract_attachment($id);
    }

    public function add_external_attachment()
    {
        if ($this->input->post()) {
            $this->misc_model->add_attachment_to_database(
                $this->input->post('contract_id'),
                'hr_contract',
                $this->input->post('files'),
                $this->input->post('external')
            );
        }
    }

    public function delete_contract_attachment($attachment_id)
    {
        $file = $this->misc_model->get_file($attachment_id);
        if ($file->staffid == get_staff_user_id() || is_admin()) {
            echo json_encode([
                'success' => $this->hr_contracts_model->delete_contract_attachment($attachment_id),
            ]);
        }
    }
}
