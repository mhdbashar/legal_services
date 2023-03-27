<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/App_pdf.php');

class written_reports_pdf extends App_pdf
{
    protected $irac;

    public function __construct($report, $tag = '')
    {
        $GLOBALS['written_reports'] = $report;

        parent::__construct();

        if (!class_exists('written_reports', false)) {
            $this->ci->load->model('Written_reports_model', 'reports');
        }

        $this->report = $report;
    }

    public function prepare()
    {
        $this->set_view_vars([
            'report' => $this->report,
        ]);

        return $this->build();
    }

    protected function type()
    {
        return 'written_reports';
    }

    protected function file_path()
    {
        $actualPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/written_reportspdf.php';
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
