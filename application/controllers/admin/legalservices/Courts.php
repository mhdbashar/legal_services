<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Courts extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('legalservices/Courts_model','court');
    }

    public function courts_managment()
    {
        if (!has_permission('courts', '', 'create') && !has_permission('judicial_departments', '', 'create')) {
            access_denied('courts');
        }
        $data['courts'] = $this->court->get_all_courts();
        $data['title']  = _l('CourtsManagement');		
        $this->load->view('admin/legalservices/courts/courts_view',$data);
    }
	
	public function judicial_managment($id)
    {
        if (!has_permission('judicial_departments', '', 'create')) {
            access_denied('judicial_departments');
        }
    	$exist = $this->court->get_court_by_id($id)->num_rows();
        if(!$exist || $id == ''){  		
			set_alert('danger', _l('CourtNofound'));
            redirect(admin_url('courts'));
    	}  
		$data['CourtID']   = $id;
        $data['judicials'] = $this->court->get_judicial_of_courts($id)->result();
        $data['title']     = _l('CourtsManagement');		
        $this->load->view('admin/legalservices/courts/judicial_view',$data);
    }

    public function GetJudicialByCourtID($id)
    {
        $response = $this->court->get_judicial_of_courts($id)->result();
        echo json_encode($response);
    }

    function add_court_from_modal()
    {
        if (!has_permission('courts', '', 'create')) {
            access_denied('courts');
        }
        $data = $this->input->post();
        echo $this->court->add_court_new($data);
    }
	
	public function add_new_court()
    {
        if (!has_permission('courts', '', 'create')) {
            access_denied('courts');
        }
        if ($this->input->post()) {        	
            $data = $this->input->post();
            $cat = $data['cat_id'];
            unset($data['cat_id']);
            $added = $this->court->add_court_new($data);
            if ($added) {
                foreach ($cat as $id){
                    $this->db->insert(db_prefix() . 'my_courts_categories' , ['c_id' => "$added" , 'cat_id' => $id] );
                }
                set_alert('success', _l('added_successfully'));
                redirect(admin_url('courts'));
            }

        }    			
        $data['title']  = _l('NewCourt');	
        $this->load->view('admin/legalservices/courts/add_courts',$data);
    }

    function add_judicial_department_modal($id)
    {
        if (!has_permission('judicial_departments', '', 'create')) {
            access_denied('judicial_departments');
        }
        $data = $this->input->post();
        echo $this->court->add_judicial_for_court($id, $data);
    }
	
	public function Add_new_judicial_department($id)
    {
        if (!has_permission('judicial_departments', '', 'create')) {
            access_denied('judicial_departments');
        }
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
        $this->load->view('admin/legalservices/courts/add_judicial_court',$data);
    }
	
	public function edit_court_data($id)
    {
        if (!has_permission('courts', '', 'edit')) {
            access_denied('courts');
        }
        if (!$id) {
            redirect(admin_url('courts'));
        }			        
		if ($this->input->post()) {        	
            $data = $this->input->post();
            $cat = $data['cat_id'];
            unset($data['cat_id']);
            $success = $this->court->update_court_data($id,$data);
            if ($success) {
                $this->db->where('c_id', $id);
                $this->db->delete(db_prefix() . 'my_courts_categories');
                foreach ($cat as $cat_id){
                    $this->db->insert(db_prefix() . 'my_courts_categories' , ['c_id' => "$id" , 'cat_id' => $cat_id] );
                }
                set_alert('success', _l('updated_successfully', _l('Court')));
				redirect(admin_url('courts'));                
            }else {
            	set_alert('warning', _l('problem_updating', _l('Court')));
				redirect(admin_url('courts'));
        	}         
        }   
       	$data['court'] = $this->court->get_court_by_id($id)->row();
		$data['title']  = _l('EditCourt');
		$this->load->view('admin/legalservices/courts/edit_court',$data);
    }

	public function edit_judicial_data($c_id,$j_id)
    {
        if (!has_permission('judicial_departments', '', 'edit')) {
            access_denied('judicial_departments');
        }
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
		$this->load->view('admin/legalservices/courts/edit_judicial_court',$data);
    }
	
	public function del_court($id)
    {
        if (!has_permission('courts', '', 'delete')) {
            access_denied('courts');
        }
        if (!$id) {
            redirect(admin_url('courts'));
        }
        $response = $this->court->delete_court($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Court')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Court')));
        }
        redirect(admin_url('courts'));
    }
	
	public function del_judicial($c_id,$j_id)
    {
        if (!has_permission('judicial_departments', '', 'delete')) {
            access_denied('judicial_departments');
        }
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
    public function build_dropdown_category() {
        $data = $this->input->post();
        $this->db->where('parent_id', 0);
        $this->db->where('country', $data['country']);
        $category = $this->db->get(db_prefix() . 'my_categories')->result_array();
        if($data['country'] != '')
            $country['country'] = $data['country'];
        else
            $country['country'] = '';
        echo render_select('cat_id[]', build_dropdown_category($country), array('id', 'name'), 'Categories', '', array('multiple'=>true), [], '', '', false);

//        $output = '<div class="form-group" app-field-wrapper="cat_id[]">
//            <label for="cat_id[]" class="control-label">تصنيفات</label>
//            <div class="dropdown bootstrap-select show-tick bs3" style="width: 100%;">
//            <select id="cat_id[]" name="cat_id[]" class="selectpicker" multiple="1" data-width="100%" data-none-selected-text="لم يتم تحديد شيء" data-live-search="true" tabindex="-98">';
//        $selected="";
//        foreach ($category as $row)
//        {
//                $output .= '<option value="'.$row['id'].'" '.$selected.' >'.$row['name'].'</option>';
//        }
//        $output .= '</select>
//            <button type="button" class="btn dropdown-toggle btn-default bs-placeholder" data-toggle="dropdown" role="combobox" aria-owns="bs-select-2" aria-haspopup="listbox" aria-expanded="false" data-id="cat_id[]" title="لم يتم تحديد شيء">
//            <div class="filter-option">
//            <div class="filter-option-inner">
//            <div class="filter-option-inner-inner">لم يتم تحديد شيء</div>
//            </div>
//            </div>
//            <span class="bs-caret">
//            <span class="caret">
//            </span></span>
//            </button>
//            <div class="dropdown-menu open">
//            <div class="bs-searchbox">
//            <input type="search" class="form-control" autocomplete="off" role="combobox" aria-label="Search" aria-controls="bs-select-2" aria-autocomplete="list">
//            </div>
//            <div class="inner open" role="listbox" id="bs-select-2" tabindex="-1" aria-multiselectable="true">
//            <ul class="dropdown-menu inner " role="presentation"></ul>
//            </div>
//            </div>
//            </div>
//            </div>';
//        echo $output;
//        echo json_encode($category);
//        die();
    }
    public function build_dropdown_edit_category() {
        $data = $this->input->post();
        $this->db->where('parent_id', 0);
        $this->db->where('country', $data['country']);
        $category = $this->db->get(db_prefix() . 'my_categories')->result_array();
        $output = [];
        foreach ($category as $cat){
            $this->db->where('c_id', $data['c_id']);
            $this->db->where('cat_id', $cat['id']);
            $success = $this->db->get(db_prefix() . 'my_courts_categories')->row();
            if($success) {

            }else {

            }
        }
        echo json_encode($category);
        die();
    }
    public function build_dropdown_court_category() {
        $data = $this->input->post();
        $this->db->where('c_id', $data['c_id']);
        $c_cat = $this->db->get(db_prefix() . 'my_courts_categories')->result_array();
        $category = [];
        foreach ($c_cat as $cat) {
            $this->db->where('id', $cat['cat_id']);
            $category[] = $this->db->get(db_prefix() . 'my_categories')->row();
        }
        echo json_encode($category);
        die();
    }
    public function build_dropdown_courts() {
        $data = $this->input->post();
        $corts = $this->court->get_courts_by_country_city($data)->result_array();
        echo json_encode($corts);
        die();
    }

}
