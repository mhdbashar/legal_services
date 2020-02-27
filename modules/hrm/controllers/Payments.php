<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payments extends AdminController{

	public function __construct(){
		parent::__construct();
        $this->load->model('payment');
	}

	public function index(){
        if(!is_admin()){
            access_denied();
        }

        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_payment_table');
        }
        $data['statuses'] = $this->projects_model->get_project_statuses();
        $data['title'] = 'Payments';
        
        $this->load->view('payments/payment', $data);
    }
    public function get($id){
        $data = $this->payment->getSalary($id);
        echo json_encode($data);
    }
    public function update(){
        if (!is_admin()) {
            access_denied();
        }
        if ($this->input->get()) {
                $data            = $this->input->get();

                $success = $this->payment->add($data['id'], $data);
                if ($this->db->affected_rows() > 0) {

                    set_alert('success', 'Payment Updated Successfuly');
                }else{
                    set_alert('warning', 'Problem Updating Payment');
                }
            
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete($id)
    {
        if (!$id) {
            access_denied();
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->payment->delete($id);
        if ($response == true) {
            set_alert('success', 'Payment Deleted Successfuly');
        } else {
            set_alert('warning', _l('problem_deleting', "Payment"));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}