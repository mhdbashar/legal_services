<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/App_pdf.php');

class Contract_pdf extends App_pdf
{
    protected $contract;

    public function __construct($contract)
    {
        $this->load_language($contract->client);
        $contract                = hooks()->apply_filters('contract_html_pdf_data', $contract);
        $GLOBALS['contract_pdf'] = $contract;

        parent::__construct();

        $this->contract = $contract;
        $this->SetTitle($this->contract->subject);

        # Don't remove these lines - important for the PDF layout
        $this->contract->content = $this->fix_editor_html($this->contract->content);
    }

    public function prepare()
    {
        $this->set_view_vars('contract', $this->contract);

        return $this->build();
    }

    protected function type()
    {
        return 'contract';
    }

    protected function file_path()
    {
        $customPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/my_contractpdf.php';
        $actualPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/contractpdf.php';

        if (file_exists($customPath)) {
            $actualPath = $customPath;
        }

        return $actualPath;
    }
	
	
	public function Header() {
    $image_file = get_option('custom_pdf_header_image_url');
	
	    if ($image_file != '') {
	

    $this->Image($image_file, 110, 6, 60, '', 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
        
    }
	  }

    public function Footer() {
      $image_file =   get_option('custom_pdf_footer_image_url');
	  
	if ($image_file != '') {

    $this->Image($image_file, 110, 280, 60, "", "PNG", "", "B", false, 300, 'C', false, false, 0, false, false, false);
		}
    }
}
