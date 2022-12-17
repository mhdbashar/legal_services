<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/App_pdf.php');

class Session_report_pdf extends App_pdf
{
    protected $session;


    public function __construct($session, $tag = '')
    {
        $this->load_language(isset($session->clientid) ? $session->clientid : '');
        $session = hooks()->apply_filters('session_report_html_pdf_data', $session);
        $GLOBALS['session_report'] = $session;

        parent::__construct();

        if (!class_exists('Sessions_model', false)) {
            $this->ci->load->model('sessions_model');

        }

        $this->tag = $tag;
        $this->session = $session;

        $this->SetTitle($this->session->name);
    }

    public function prepare()
    {
        $CI = &get_instance();
        $CI->load->library('app_modules');
        $this->session->duedate = $CI->app_modules->is_active('hijri') ? _d($this->session->duedate) . '  &  ' . to_hijri_date(_d($this->session->duedate)) : _d($this->session->duedate);
        $this->session->next_session_date = $CI->app_modules->is_active('hijri') ? _d($this->session->next_session_date) . '  &  ' . to_hijri_date(_d($this->session->next_session_date)) : _d($this->session->next_session_date);
        $this->session->startdate = $CI->app_modules->is_active('hijri') ? _d($this->session->startdate) . '  &  ' . to_hijri_date(_d($this->session->startdate)) : _d($this->session->startdate);

        $time_format = get_option('time_format');
        $this->session->time = $time_format === '24' ? date('h:i', strtotime($this->session->time)) : date('h:i a', strtotime($this->session->time));
        $this->session->next_session_time = $time_format === '24' ? date('h:i', strtotime($this->session->next_session_time)) : date('h:i a', strtotime($this->session->next_session_time));

        $this->set_view_vars([
            'client' => isset($this->session->clientid) ? get_customer_by_id($this->session->clientid)->company : '',
            'opponent' => isset($this->session->opponent_id) && $this->session->opponent_id != 0 ? get_customer_by_id($this->session->opponent_id)->company : '',
            'court' => get_court_by_id($this->session->court_id)->court_name,
            'file_number_court' => $this->session->file_number_court,
            'duedate' => $this->session->startdate,
            'time' => $this->session->time,
            'session_information' => $this->session->session_information,
            'court_decision' => $this->session->court_decision,
            'next_session_date' => $this->session->next_session_date,
            'next_session_time' => $this->session->next_session_time,
            'name' => $this->session->name,
            'type' => $this->session->session_type,
            'checklist_items' => $this->session->checklist_items
        ]);

        return $this->build();
    }

    protected function type()
    {
        return 'session_report';
    }

    protected function file_path()
    {
        $actualPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/session_report_pdf.php';
        return $actualPath;
    }

}
