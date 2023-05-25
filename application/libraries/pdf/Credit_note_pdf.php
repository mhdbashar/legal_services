<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/App_pdf.php');

class Credit_note_pdf extends App_pdf
{
    protected $credit_note;

    private $credit_note_number;

    public function __construct($credit_note, $tag = '')
    {
        $this->load_language($credit_note->clientid);
        $GLOBALS['credit_note_pdf'] = $credit_note;

        parent::__construct();

        $this->tag                = $tag;
        $this->credit_note        = $credit_note;
        $this->credit_note_number = format_credit_note_number($this->credit_note->id);

        $this->SetTitle($this->credit_note_number);
    }

    public function prepare()
    {
        $this->with_number_to_word($this->credit_note->clientid);

        $this->set_view_vars([
            'status'             => $this->credit_note->status,
            'credit_note_number' => $this->credit_note_number,
            'credit_note'        => $this->credit_note,
        ]);

        return $this->build();
    }

    protected function type()
    {
        return 'credit_note';
    }

    protected function file_path()
    {
        $customPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/my_credit_note_pdf.php';
        $actualPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/credit_note_pdf.php';

        if (file_exists($customPath)) {
            $actualPath = $customPath;
        }

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
