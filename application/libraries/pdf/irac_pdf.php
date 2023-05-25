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
 
    public function Header()
    {

        $image_file = get_option('custom_pdf_header_image_url');
        $width = get_option('pdf_header_logo_width');

        if ($image_file != '') {

            $this->SetMargins(10, 60, 10, true);
            if ($width != '') {

                $this->Image($image_file, 0, 0, $width, 0, 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
            } else {
                $width = 210;
                $this->Image($image_file, 0, 0, $width, 50, 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
            }

        }
    }

    public function Footer()
    {
        $width_footer = '';
        $image_file_footer = '';
        $image_file_footer = get_option('custom_pdf_footer_image_url');

        $width_footer = get_option('pdf_footer_logo_width');

        if ($image_file_footer != '') {
            $this->SetMargins(10, 60, 10, true);
            $this->SetAutoPageBreak(true, 60);
            if ($width_footer != '') {

                $this->Image($image_file_footer, 0, 280, $width_footer, 0, 'PNG', '', 'B', false, 300, 'C', false, false, 0, false, false, false);

            } else {
                $width_footer = 210;

                $this->Image($image_file_footer, 0, 265, $width_footer, 0, 'PNG', '', 'B', false, 300, 'C', false, false, 0, false, false, false);

            }

        }
    }
}
