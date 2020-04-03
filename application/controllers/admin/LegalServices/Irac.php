<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Irac extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/irac_model', 'irac');
    }

    public function edit($ServID, $id)
    {
        if ($this->input->post()) {
            $data                    = $this->input->post();
            $data['facts']           = html_purify($this->input->post('facts', false));
            $data['legal_authority'] = html_purify($this->input->post('legal_authority', false));
            $data['analysis']        = html_purify($this->input->post('analysis', false));
            $data['result']          = html_purify($this->input->post('result', false));
            $success                 = $this->irac->update($ServID, $id, $data);
            if ($success) {
                set_alert('success', _l('updated_successfully'));
            }else {
                set_alert('warning', _l('problem_updating'));
            }
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /* Generates invoice PDF and senting to email of $send_to_email = true is passed */
    public function pdf($ServID, $id)
    {
        if (!$id || !$ServID) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $service_name = get_case_name_by_id($id);
        $rel_type = get_legal_service_slug_by_id($ServID);
        $irac = $this->irac->get('', ['rel_id' => $id, 'rel_type' => $rel_type]);
        //$invoice_number = format_invoice_number($irac->id);
        try {
            $pdf = irac_pdf($irac);
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

        $pdf->Output(mb_strtoupper(slug_it($invoice_number)) . '.pdf', $type);
    }

}