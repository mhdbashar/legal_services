<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Written_reports extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Written_reports_model','reports');
    }

    public function add($ServID)
    {
        if (!has_permission('written_reports', '', 'create')) {
            access_denied('written_reports');
        }
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
        if (!has_permission('written_reports', '', 'edit')) {
            access_denied('written_reports');
        }
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

    public function delete($ServID, $rel_id, $report_id)
    {
        if (!has_permission('written_reports', '', 'delete')) {
            access_denied('written_reports');
        }
        $route = $ServID == 1 ? 'Case' : 'SOther';
        if(!$report_id){
            set_alert('danger', _l('WrongEntry'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        $response = $this->reports->delete($report_id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect(admin_url($route.'/view/'.$ServID.'/'.$rel_id.'?group=written_reports'));
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
        if (!has_permission('written_reports', '', 'send_to_customer')) {
            access_denied('written_reports');
        }
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
