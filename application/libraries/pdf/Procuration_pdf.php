<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/App_pdf.php');

class Procuration_pdf extends App_pdf
{
    protected $procuration;

    public function __construct($procuration, $tag = '')
    {
        $GLOBALS['procuration_pdf'] = $procuration;

        parent::__construct();

        if (!class_exists('procurations_model', false)) {
            $this->ci->load->model('procurations_model');
        }

        $this->procuration = $procuration;
    }

    public function prepare()
    {
        $this->set_view_vars([
            'description'            => nl2br($this->procuration->description),
            'principalId'  => $this->procuration->principalId,
            'agentId'         => $this->procuration->agentId,
            'NO'           => $this->procuration->NO,
            'procuration'             => $this->procuration,
            'start_date'    => ($this->procuration->start_date),
            'name'    => $this->procuration->name,
            'end_date'      => ($this->procuration->end_date)
        ]);

        return $this->build();
    }

    protected function type()
    {
        return 'procuration';
    }

    protected function file_path()
    {
        $actualPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/procurationpdf.php';
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
