<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Contract extends ClientsController
{
    /**
     * Check the contract view restrictions
     *
     * @param  int $id
     * @param  string $hash
     *
     * @return void
     */
    private function check_hr_contract_restrictions($id, $hash)
    {
        $CI = &get_instance();
        $CI->load->model('hr_contracts_model');

        if (!$hash || !$id) {
            show_404();
        }

        if (!is_client_logged_in() && !is_staff_logged_in()) {
            if (get_option('view_contract_only_logged_in') == 1) {
                redirect_after_login_to_current_url();
                redirect(site_url('authentication/login'));
            }
        }

        $contract = $CI->hr_contracts_model->get($id);

        if (!$contract || ($contract->hash != $hash)) {
            show_404();
        }

        // Do one more check
        if (!is_staff_logged_in()) {
            if (get_option('view_contract_only_logged_in') == 1) {
                if ($contract->client != get_staff_user_id()) {
                    show_404();
                }
            }
        }
    }


    /**
     * Generate contract pdf
     * @param  object $contract object db
     * @return mixed object
     */
    private function hr_contract_pdf($contract)
    {
        return app_pdf('hr_contract', LIBSPATH . 'pdf/contract_pdf', $contract);
    }

    private function send_hr_contract_signed_notification_to_staff($contract_id)
    {
        $CI = &get_instance();
        $CI->db->where('id', $contract_id);
        $contract = $CI->db->get(db_prefix() . 'hr_contracts')->row();

        if (!$contract) {
            return false;
        }

        // Get creator
        $CI->db->select('staffid, email');
        $CI->db->where('staffid', $contract->addedfrom);
        $staff_contract = $CI->db->get(db_prefix() . 'staff')->result_array();

        $notifiedUsers = [];

        foreach ($staff_contract as $member) {
            $notified = add_notification([
                'description'     => 'not_contract_signed',
                'touserid'        => $member['staffid'],
                'fromcompany'     => 1,
                'fromuserid'      => 0,
                'link'            => 'contracts/contract/' . $contract->id,
                'additional_data' => serialize([
                    '<b>' . $contract->subject . '</b>',
                ]),
            ]);

            if ($notified) {
                array_push($notifiedUsers, $member['staffid']);
            }

            send_mail_template('contract_signed_to_staff', $contract, $member);
        }

        pusher_trigger_notification($notifiedUsers);
    }

    public function index($id, $hash)
    {

        $this->load->model('hr_contracts_model');
        $this->check_hr_contract_restrictions($id, $hash);
        $contract = $this->hr_contracts_model->get($id);

        if (!$contract) {
            show_404();
        }

        if (!is_client_logged_in()) {
            load_client_language($contract->client);
        }

        if ($this->input->post()) {
            $action = $this->input->post('action');

            switch ($action) {
            case 'contract_pdf':
                    $pdf = $this->hr_contract_pdf($contract);
                    $pdf->Output(slug_it($contract->subject . '-' . get_option('companyname')) . '.pdf', 'D');

                    break;
            case 'sign_contract':
                    process_digital_signature_image($this->input->post('signature', false), HR_CONTRACTS_UPLOADS_FOLDER . $id);
                    $this->db->where('id', $id);
                    $this->db->update(db_prefix().'hr_contracts', array_merge(get_acceptance_info_array(), [
                        'signed' => 1,
                    ]));

                    // Notify contract creator that customer signed the contract
                    $this->send_hr_contract_signed_notification_to_staff($id);

                    set_alert('success', _l('document_signed_successfully'));
                    redirect($_SERVER['HTTP_REFERER']);

            break;
             case 'contract_comment':
                    // comment is blank
                    if (!$this->input->post('content')) {
                        redirect($this->uri->uri_string());
                    }
                    $data                = $this->input->post();
                    $data['contract_id'] = $id;
                    $this->hr_contracts_model->add_comment($data, true);
                    redirect($this->uri->uri_string() . '?tab=discussion');

                    break;
            }
        }

        $this->disableNavigation();
        $this->disableSubMenu();

        $data['title']     = $contract->subject;
        $data['contract']  = hooks()->apply_filters('contract_html_pdf_data', $contract);
        $data['bodyclass'] = 'contract contract-view';

        $data['identity_confirmation_enabled'] = true;
        $data['bodyclass'] .= ' identity-confirmation';
        $this->app_scripts->theme('sticky-js','assets/plugins/sticky/sticky.js');
        $data['comments'] = $this->hr_contracts_model->get_comments($id);
        //add_views_tracking('proposal', $id);
        hooks()->do_action('contract_html_viewed', $id);
        $this->app_css->remove('reset-css','customers-area-default');
        $data                      = hooks()->apply_filters('contract_customers_area_view_data', $data);
        $this->data($data);
        no_index_customers_area();
        $this->view('admin/contracts/my_contracthtml');
        $this->layout();
    }
}
