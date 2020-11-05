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
}
