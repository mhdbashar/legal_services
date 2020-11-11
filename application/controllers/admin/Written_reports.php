<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Written_reports extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Written_reports_model','reports');
    }

    public function index()
    {
        if (!has_permission('case_status', '', 'create')) {
            access_denied('case_status');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_case_status');
        }
        $data['title'] = _l('case_status');
        $this->load->view('admin/case_status/manage', $data);
    }

    public function add($ServID)
    {
        $route = $ServID == 1 ? 'Case' : 'SOther';
        if ($this->input->post()) {
            $data['report'] = $this->input->post('report', false);
            $data = $this->input->post();
            $id = $this->reports->add($data);
            if ($id) {
                set_alert('success', _l('added_successfully'));
                redirect(admin_url($route.'/view/'.$ServID.'/'.$data["rel_id"].'?group=written_reports'));
            }
        }
    }

    public function edit($ServID, $id)
    {
        $route = $ServID == 1 ? 'Case' : 'SOther';
        if ($this->input->post()) {
            $data['report'] = $this->input->post('report', false);
            $data = $this->input->post();
            $id = $this->reports->update($id, $data);
            if ($id) {
                set_alert('success', _l('updated_successfully'));
                redirect(admin_url($route.'/view/'.$ServID.'/'.$data["rel_id"].'?group=written_reports'));
            }
        }
    }

    /* Generates invoice PDF and senting to email of $send_to_email = true is passed */
    public function pdf($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $report = $this->reports->get($id);
        try {
            $pdf = written_reports_pdf($report);
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

        $pdf->Output('Written_report_'.$report->id.'.pdf', $type);
    }

    public function send_mail_to_client($report_id, $service_id)
    {
        $report = $this->reports->get($report_id);
        $rel_id = $report->rel_id;
        if($service_id == 1){
            $client_id = get_client_id_by_case_id($rel_id);
        }else{
            $client_id = get_client_id_by_oservice_id($rel_id);
        }
        $this->db->where('userid', $client_id);
        $contact = $this->db->get(db_prefix() . 'contacts')->row();
        if(isset($contact)){
            send_mail_template('send_written_report_to_customer', $contact, $report);
            log_activity('Send Written Report To Customer [Report ID: ' . $report_id . ']');
            return array(1, _l('Done').' '._l('Send_to_customer'));
        }else{
            return array(2, _l('no_primary_contact')); // This customer doesn't have primary contact
        }
    }

}
