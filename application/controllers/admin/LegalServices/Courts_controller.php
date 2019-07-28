<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Courts_controller extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/Courts_model','court');
    }

    public function courts_managment()
    {
        $data['courts'] = $this->court->get_all_courts();
        $data['title']  = _l('CourtsManagement');		
        $this->load->view('admin/LegalServices/courts/courts_view',$data);
    }
	
	public function judicial_managment($id)
    {
    	$exist = $this->court->get_court_by_id($id)->num_rows();
        if(!$exist || $id == ''){  		
			set_alert('danger', _l('CourtNofound'));
            redirect(admin_url('courts_control'));
    	}  
		$data['CourtID']   = $id;
        $data['judicials'] = $this->court->get_judicial_of_courts($id)->result();
        $data['title']     = _l('CourtsManagement');		
        $this->load->view('admin/LegalServices/courts/judicial_view',$data);
    }

    public function GetJudicialByCourtID($id)
    {
        $response = $this->court->get_judicial_of_courts($id)->result();
        echo json_encode($response);
    }

    function add_court_from_modal()
    {
        $data = $this->input->post();
        echo $this->court->add_court_new($data);
    }
	
	public function add_new_court()
    {    		
        if ($this->input->post()) {        	
            $data = $this->input->post();                              
            $added = $this->court->add_court_new($data);
            if ($added) {
                set_alert('success', _l('added_successfully'));
                redirect(admin_url('courts_control'));
            }         
        }    			
        $data['title']  = _l('NewCourt');	
        $this->load->view('admin/LegalServices/courts/add_courts',$data);
    }

    function add_judicial_department_modal($id)
    {
        $data = $this->input->post();
        echo $this->court->add_judicial_for_court($id, $data);
    }
	
	public function Add_new_judicial_department($id)
    {
    	$exist = $this->court->get_court_by_id($id)->num_rows();
        if(!$exist || $id == ''){    		
			set_alert('danger', _l('CourtNofound'));
            redirect(admin_url("judicial_control/$id"));
    	}    		
        if ($this->input->post()) {        	
            $data = $this->input->post();                              
            $added = $this->court->add_judicial_for_court($id,$data);
            if ($added) {
                set_alert('success', _l('added_successfully'));
                redirect(admin_url("judicial_control/$id"));
            }         
        }    	
		$CourtName =  $this->court->get_court_by_id($id)->row($id)->court_name;
        $data['title']     = _l('AddJudicialDept').' '._l('Court').' '.$CourtName;	
        $this->load->view('admin/LegalServices/courts/add_judicial_court',$data);
    }
	
	public function edit_court_data($id)
    {    	     
        if (!$id) {
            redirect(admin_url('courts_control'));
        }			        
		if ($this->input->post()) {        	
            $data = $this->input->post();                              
            $success = $this->court->update_court_data($id,$data);
            if ($success) {
                set_alert('success', _l('updated_successfully', _l('Court')));
				redirect(admin_url('courts_control'));                
            }else {
            	set_alert('warning', _l('problem_updating', _l('Court')));
				redirect(admin_url('courts_control'));
        	}         
        }   
       	$data['court'] = $this->court->get_court_by_id($id)->row();
		$data['title']  = _l('EditCourt');
		$this->load->view('admin/LegalServices/courts/edit_court',$data);
    }

	public function edit_judicial_data($c_id,$j_id)
    {    	     
        if (!$c_id || !$j_id) {
            redirect(admin_url("judicial_control/$c_id"));
        }		        
		if ($this->input->post()) {        	
            $data = $this->input->post();                              
            $success = $this->court->update_judicial_data($c_id,$j_id,$data);
            if ($success) {
                set_alert('success', _l('updated_successfully', _l('Court')));
				redirect(admin_url("judicial_control/$c_id"));               
            }else {
            	set_alert('warning', _l('problem_updating', _l('Court')));
				redirect(admin_url("judicial_control/$c_id"));
        	}         
        }   
       	$data['judicial'] = $this->court->get_judicial_by_id($j_id)->row();
		$data['title']  = _l('EditJudicialDept');
		$this->load->view('admin/LegalServices/courts/edit_judicial_court',$data);
    }
	
	public function del_court($id)
    {    	     
        if (!$id) {
            redirect(admin_url('courts_control'));
        }
        $response = $this->court->delete_court($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Court')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Court')));
        }
        redirect(admin_url('courts_control'));
    }
	
	public function del_judicial($c_id,$j_id)
    {    	
        if (!$c_id || !$j_id) {
            redirect(admin_url("judicial_control/$c_id"));
        }
        $response = $this->court->delete_judicial($j_id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Judicial')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Judicial')));
        }
        redirect(admin_url("judicial_control/$c_id"));
    }
	
}
