<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Workdays extends AdminController{

    public function __construct() {
        parent::__construct();
        $this->load->model('workday');
    }
    public function index(){
        
        $data['data'] = $this->workday->getdays();
        $data['period'] = $this->workday->get_period();
        $data['title'] = "Work Days";
        $this->load->view('settings/workday', $data);
    }

    public function edit(){
        $saturday   = $this->input->get('saturday');
        $sunday     = $this->input->get('sunday');
        $monday     = $this->input->get('monday');
        $tuesday    = $this->input->get('tuesday');
        $wednesday  = $this->input->get('wednesday');
        $thursday   = $this->input->get('thursday');
        $friday     = $this->input->get('friday');
        $success = $this->workday->setdays($saturday, $sunday, $monday, $tuesday, $wednesday, $thursday, $friday);
        $data = [
            'evening' => $this->input->get('start_evening').'-'.$this->input->get('end_evening'), 
            'morning' => $this->input->get('start_morning').'-'.$this->input->get('end_morning')
        ];
        $success2 = $this->workday->update_p($data);
        if ($success or $success2) {
            set_alert('success', "Workdays Updated Successfuly");
        }else{
            set_alert('danger', "Problem Updating");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}