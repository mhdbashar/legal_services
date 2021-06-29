<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/App_pdf.php');

class Irac_pdf extends App_pdf
{
    protected $irac;

    public function __construct($irac, $tag = '')
    {
        $GLOBALS['irac_pdf'] = $irac;

        parent::__construct();

        if (!class_exists('irac_model', false)) {
            $this->ci->load->model('legalservices/irac_model', 'irac');
        }

        $this->irac = $irac;
    }

    public function prepare()
    {
        $this->ci->load->model('legalservices/Courts_model', 'courts');
        $this->ci->load->model('legalservices/Cases_model', 'case');
        $case_info = get_case($this->irac->rel_id);
        $name = get_case_name_by_id($this->irac->rel_id);
        $court = $this->ci->courts->get_court_by_id($case_info->court_id)->row()->court_name;
        $members = $this->ci->case->get_project_members($this->irac->rel_id);
        $this->set_view_vars([
            'name'             => $name,
            'facts'            => $this->irac->facts,
            'legal_authority'  => $this->irac->legal_authority,
            'analysis'         => $this->irac->analysis,
            'result'           => $this->irac->result,
            'irac'             => $this->irac,
            'case_info'        => $case_info,
            'court'            => isset($court) ? $court : '',
            'members'          => isset($members) ? $members : '',
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
}
