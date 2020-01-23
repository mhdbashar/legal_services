<?php

defined('BASEPATH') or exit('No direct script access allowed');

class statuses extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('projects_statuses');
    }

    public function index()
    {
        $data['statuses'] = $this->projects_statuses->get_all();
        $data['title']  = _l('projects_statuses');		
        $this->load->view('projects_statuses',$data);
    }


    function add_from_modal()
    {
        $data = $this->input->post();
        echo $this->projects_statuses->add_new($data);
    }

	public function view($id='')
    {    		
        if ($this->input->post()) {

            if (!$id){

                $data = $this->input->post();                              
                $added = $this->projects_statuses->add_new($data);
                if ($added) {
                    set_alert('success', _l('added_successfully'), _l('disputes'));
                    redirect(admin_url('disputes/statuses'));
                }

            }else{

                $data = $this->input->post();                              
                $success = $this->projects_statuses->update($id,$data);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('disputes')));
                    redirect(admin_url('disputes/statuses'));                
                }else{
                    set_alert('warning', _l('problem_updating', _l('disputes')));
                }

            }
        }

        $data['status'] = $this->projects_statuses->get_by_id($id)->row();
        $data['title']  = _l('projects_status');	
        $this->load->view('manage_statuses',$data);
    }

	public function delete($id)
    {    	     
        if (!$id) {
            redirect(admin_url('disputes/statuses'));
        }
        $response = $this->projects_statuses->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('disputes')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('disputes')));
        }
        redirect(admin_url('disputes/statuses'));
    }
	
}
