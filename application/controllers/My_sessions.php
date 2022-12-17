<?php

defined('BASEPATH') or exit('No direct script access allowed');

class My_sessions extends ClientsController
{
    public function __construct()
    {
        parent::__construct();

    }

    public function session_report($id,$downlod = 0)
    {
        $this->load->model('sessions_model');


        $data=[];
        $session = $this->sessions_model->get_with_session_info($id);
        $session->checklist_items = $this->sessions_model->get_checklist_items($id);
        $session->title         = _l('session_report');
        if($session->rel_type == 'kd-y'){
            $case = get_case_by_id($session->rel_id);
            $session->clientid = $case->clientid;
            $session->opponent_id = $case->opponent_id;
        }elseif ($session->rel_type == 'kdaya_altnfith'){
            $case = get_disputes_case($session->rel_id);
            $session->clientid = $case->clientid;
            $session->opponent_id = $case->opponent_id;
        }
        $data['session'] = $session;
        if ($this->input->post('invoicepdf') || $downlod == 1 ){
            try {
                $pdf = session_report_pdf($session);
            } catch (Exception $e) {
                echo $e->getMessage();
                die;
            }
//            echo '<pre>';echo print_r($pdf);exit();
            $session_name = "$session->name";
            $companyname    = get_option('invoice_company_name');
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
