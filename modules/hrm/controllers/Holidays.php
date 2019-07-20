<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Holidays extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('holiday');
	}

	public function index(){
		if(!is_admin()){
            access_denied();
        }

		if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_holiday_table');
        }
        $data['title'] = "Holidays";
		$this->load->view('settings/holiday', $data);
	}
    public function get($id)
    {
        $data = $this->holiday->getHolidays($id);
        echo json_encode($data);
    }


    public function add(){
        if (!is_admin()) {
            access_denied();
        }
        if ($this->input->get()) {
            $data            = $this->input->get();
            // $data['message'] = $this->input->post('message', false);
            $success = $this->holiday->add($data);
            if ($success) {
                set_alert('success', 'Holiday Added Successfully');
            }
            redirect('hrm/holidays');
        }
    }
	
	public function update(){
        if (!is_admin()) {
            access_denied();
        }
        if ($this->input->get()) {
            $data            = $this->input->get();
            $id 			 = $this->input->get('id');
            // $data['message'] = $this->input->post('message', false);
            $success = $this->holiday->update($data, $id);
            
            redirect('hrm/Holidays');
        }
        if ($id == '')
        redirect('hrm/holidays');
    }
	public function delete($id)
    {
        if (!$id) {
            access_denied();
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->holiday->delete($id);
        if ($response == true) {
            set_alert('success', "Holiday Deleted Successfully");
        } else {
            set_alert('warning', _l('problem_deleting', "Holiday"));
        }
        redirect('hrm/Holidays');
    }
}