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

        $this->tag = $tag;
        $this->session = $session;

        $this->SetTitle($this->session->name);
    }

    public function prepare()
    {
        $CI = &get_instance();
        $CI->load->library('app_modules');
        $this->session->duedate = $CI->app_modules->is_active('hijri') && $this->session->duedate != '' ? _d($this->session->duedate) . _l('correspond') . to_hijri_date(_d($this->session->duedate)) : _d($this->session->duedate);
        $this->session->next_session_date = $CI->app_modules->is_active('hijri') && $this->session->next_session_date != ''? _d($this->session->next_session_date) . _l('correspond') . to_hijri_date(_d($this->session->next_session_date)) : _d($this->session->next_session_date);
        $this->session->startdate = $CI->app_modules->is_active('hijri') ? _d($this->session->startdate) . _l('correspond') . to_hijri_date(_d($this->session->startdate)) : _d($this->session->startdate);

        $time_format = get_option('time_format');
        $this->session->time = $time_format === '24' ? date('h:i', strtotime($this->session->time)) : date('h:i a', strtotime($this->session->time));
        $this->session->next_session_time = $time_format === '24' ? date('h:i', strtotime($this->session->next_session_time)) : date('h:i a', strtotime($this->session->next_session_time));

        $this->set_view_vars([
            'client' => isset($this->session->clientid) ? get_customer_by_id($this->session->clientid)->company : '',
            'representative' => isset($this->session->representative) ? maybe_translate(_l('nothing_was_specified'), get_representative_by_id($this->session->representative)) : '',
            'opponent' => isset($this->session->opponent_id) && $this->session->opponent_id != 0 ? get_customer_by_id($this->session->opponent_id)->company : '',
            'court' => get_court_by_id($this->session->court_id)->court_name,
            'city'=> $this->session->city ? $this->session->city : _l('nothing_was_specified'),
            'case_name'=> $this->session->case_name ? $this->session->case_name : _l('nothing_was_specified'),
            'cat_id'=>$this->session->cat_id ? get_cat_name_by_id($this->session->cat_id) : '',
            'subcat_id'=>$this->session->subcat_id ? get_cat_name_by_id($this->session->subcat_id) : '',
            'childsubcat_id'=>$this->session->childsubcat_id ? get_cat_name_by_id($this->session->childsubcat_id) : '',
            'file_number_court' => $this->session->file_number_court,
            'dept'=>$this->session->dept ? get_judicialdept_by_id($this->session->dept)->Jud_number : '',
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
