<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/App_pdf.php');

class Irac_pdf extends App_pdf
{
    protected $irac;

    //private $invoice_number;

    public function __construct($irac, $tag = '')
    {
        $GLOBALS['irac_pdf'] = $irac;

        parent::__construct();

        if (!class_exists('irac_model', false)) {
            $this->ci->load->model('LegalServices/irac_model', 'irac');
        }

//        $this->tag            = $tag;
        $this->irac        = $irac;
        //$this->invoice_number = format_invoice_number($this->invoice->id);
        //$this->load_language($this->invoice->clientid);
        //$this->SetTitle($this->invoice_number);
    }

    public function prepare()
    {
        //$this->with_number_to_word($this->invoice->clientid);
        $name = get_case_name_by_id($this->irac->rel_id);
        $this->set_view_vars([
            'name'             => $name,
            'facts'            => $this->irac->facts,
            'legal_authority'  => $this->irac->legal_authority,
            'analysis'         => $this->irac->analysis,
            'result'           => $this->irac->result,
            'irac'             => $this->irac,
        ]);

        return $this->build();
    }

    protected function type()
    {
        return 'irac';
    }

    protected function file_path()
    {
        $actualPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/iracpdf.php';
        return $actualPath;
    }

    /*private function get_payment_modes()
    {
        $this->ci->load->model('payment_modes_model');
        $payment_modes = $this->ci->payment_modes_model->get();

        // In case user want to include {invoice_number} or {client_id} in PDF offline mode description
        foreach ($payment_modes as $key => $mode) {
            if (isset($mode['description'])) {
                $payment_modes[$key]['description'] = str_replace('{invoice_number}', $this->invoice_number, $mode['description']);
                $payment_modes[$key]['description'] = str_replace('{client_id}', $this->invoice->clientid, $mode['description']);
            }
        }

        return $payment_modes;
    }*/
}
