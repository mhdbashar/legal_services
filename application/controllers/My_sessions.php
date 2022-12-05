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
//        $this->load->model('projects_model');
//        $this->load->model('legalservices/LegalServicesModel', 'legal');
//        $this->load->model('legalservices/Cases_model', 'case');


        $data=[];
        $session = $this->sessions_model->get_with_session_info($id);
        $session->title         = _l('session_report');
        if($session->rel_type == 'kd-y'){
            $case = get_case_by_id($session->rel_id);
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

//        $session = hooks()->apply_filters('before_client_view_invoice', $session);

//        if (!is_client_logged_in()) {
//            load_client_language($invoice->clientid);
//        }

        // Handle Invoice PDF generator
//        if ($this->input->post('invoicepdf')) {
//            try {
//                $pdf = invoice_pdf($invoice);
//            } catch (Exception $e) {
//                echo $e->getMessage();
//                die;
//            }
//
//            $invoice_number = format_invoice_number($invoice->id);
//            $companyname    = get_option('invoice_company_name');
//            if ($companyname != '') {
//                $invoice_number .= '-' . mb_strtoupper(slug_it($companyname), 'UTF-8');
//            }
//            $pdf->Output(mb_strtoupper(slug_it($invoice_number), 'UTF-8') . '.pdf', 'D');
//            die();
//        }

        // Handle $_POST payment
//        if ($this->input->post('make_payment')) {
//            $this->load->model('payments_model');
//            if (!$this->input->post('paymentmode')) {
//                set_alert('warning', _l('invoice_html_payment_modes_not_selected'));
//                redirect(site_url('invoice/' . $id . '/' . $hash));
//            } elseif ((!$this->input->post('amount') || $this->input->post('amount') == 0) && get_option('allow_payment_amount_to_be_modified') == 1) {
//                set_alert('warning', _l('invoice_html_amount_blank'));
//                redirect(site_url('invoice/' . $id . '/' . $hash));
//            }
//            $this->payments_model->process_payment($this->input->post(), $id);
//        }

//        if ($this->input->post('paymentpdf')) {
//            $payment = $this->payments_model->get($this->input->post('paymentpdf'));
//            // Confirm that the payment is related to the invoice.
//            if ($payment->invoiceid == $id) {
//                $payment->invoice_data = $this->invoices_model->get($payment->invoiceid);
//                $paymentpdf            = payment_pdf($payment);
//                $paymentpdf->Output(mb_strtoupper(slug_it(_l('payment') . '-' . $payment->paymentid), 'UTF-8') . '.pdf', 'D');
//                die;
//            }
//        }

        $this->app_scripts->theme('sticky-js', 'assets/plugins/sticky/sticky.js');
//        $this->load->library('app_number_to_word', [
//            'clientid' => $invoice->clientid,
//        ], 'numberword');
//        $this->load->model('payment_modes_model');
//        $this->load->model('payments_model');
//        $data['payments']      = $this->payments_model->get_invoice_payments($id);
//        $data['payment_modes'] = $this->payment_modes_model->get();

        $this->disableNavigation();
        $this->disableSubMenu();
//        $data['hash']      = $hash;
//        $data['invoice']   = hooks()->apply_filters('invoice_html_pdf_data', $invoice);
//        $data['bodyclass'] = 'viewinvoice';
//        add_views_tracking('invoice', $id);
//        hooks()->do_action('invoice_html_viewed', $id);
//        no_index_customers_area();
        $this->data($data);
        $this->view('session_report');
        $this->layout();
    }

}
