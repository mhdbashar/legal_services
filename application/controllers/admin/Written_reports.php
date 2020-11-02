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

}
