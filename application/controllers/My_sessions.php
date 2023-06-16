<?php

defined('BASEPATH') or exit('No direct script access allowed');

class My_sessions extends ClientsController
{
    public function __construct()
    {
        parent::__construct();

    }

    public function session_report($id, $downlod = 0)
    {
        $this->load->model('sessions_model');
        $data = [];
        $session = $this->sessions_model->get($id);
        $session->title = _l('session_report');
        if ($session->rel_type == 'kd-y') {
            if ($session->clientid == null) {
                $session->clientid = get_client_id_by_case_id($session->rel_id);
                $session->representative = get_representative_id_by_case_id($session->rel_id);
            }
            $session->opponent_id = get_opponent_id_by_case_id($session->rel_id);
        } elseif ($session->rel_type == 'kdaya_altnfith') {
            if ($session->clientid == null) {
                $session->clientid = get_client_id_by_disputes_case_id($session->rel_id);
                $session->representative = get_representative_id_by_case_id($session->rel_id);
            }
            $opponents = get_disputes_cases_opponents_by_case_id($session->rel_id);
            foreach ($opponents as $opponent) {
                if ($opponent->opponent_id > 0) $session->opponent_id = $opponent->opponent_id;
                break;
            }
        } else if ($session->rel_type == 'customer') {
            if ($session->clientid == null) {
                $session->clientid = get_customer_by_id($session->rel_id);
            }
            $session->opponent_id = 0;
        } else {
            if ($session->clientid == null) {
                $session->clientid = get_client_id_by_oservice_id($session->rel_id);
            }
            $session->opponent_id = 0;
        }

        $data['session'] = $session;
        if ($this->input->post('invoicepdf') || $downlod == 1) {
            try {
                $pdf = session_report_pdf($session);
            } catch (Exception $e) {
                echo $e->getMessage();
                die;
            }
            $session_name = "$session->name";
            $companyname = get_option('invoice_company_name');
            if ($companyname != '') {
                $session_name .= '-' . mb_strtoupper(slug_it($companyname), 'UTF-8');
            }
            $pdf->Output(mb_strtoupper(slug_it($session_name), 'UTF-8') . '.pdf', 'D');
            die();
        }

        $this->app_scripts->theme('sticky-js', 'assets/plugins/sticky/sticky.js');
        $this->disableNavigation();
        $this->disableSubMenu();
        $this->data($data);
        $this->view('session_report');
        $this->layout();
    }

}
