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
            'start_date'    => $this->procuration->start_date,
            'name'    => $this->procuration->name,
            'end_date'      => $this->procuration->end_date
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
}
