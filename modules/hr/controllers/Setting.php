<?php

class Setting extends AdminController{


	public function __construct(){
		parent::__construct();
	}

    public function index(){

        $group = '';

        if(!$this->input->get('group')){
            $_GET['group'] = 'deduction';
            $group = 'deduction';
        }else{
            $group = $this->input->get('group');
        }
        if ($this->input->is_ajax_request()) {
            if($group == 'deduction'){
                $this->hrmapp->get_table_data('types/my_deduction_types_table');
            }elseif($group == 'document'){
                $this->hrmapp->get_table_data('types/my_document_types_table');
            }elseif($group == 'education_level'){
                $this->hrmapp->get_table_data('types/my_education_level_types_table');
            }elseif($group == 'education'){
                $this->hrmapp->get_table_data('types/my_education_types_table');
            }elseif($group == 'skill'){
                $this->hrmapp->get_table_data('types/my_skill_types_table');
            }elseif($group == 'relation'){
                $this->hrmapp->get_table_data('types/my_relation_types_table');
            }elseif($group == 'branch'){
                $this->hrmapp->get_table_data('types/my_branch_types_table');
            }elseif($group == 'award'){
                $this->hrmapp->get_table_data('types/my_award_types_table');
            }elseif($group == 'termination'){
                $this->hrmapp->get_table_data('types/my_termination_types_table');
            }elseif($group == 'warning'){
                $this->hrmapp->get_table_data('types/my_warning_types_table');
            }
        }

        $data['group'] = $group;
        $data['title'] = _l('manage_custom_tabs');
        $this->load->view('settings/manage', $data);
    }

    // type

    public function add_type($type_name){

        $enArray=array();
        if (option_exists($type_name) != Null){
            $enArray = json_decode(get_option($type_name));
        }else{
            $enArray=array();
        }
        if ($this->input->get()){
            $nameEn['key'] = $this->input->get('nameEn');
            $nameEn['value'] = $this->input->get('nameEn');
        }

        array_push($enArray,$nameEn );
        if (option_exists($type_name) != Null){
            $en = update_option($type_name,json_encode($enArray));
        }else{
            $en = add_option($type_name,json_encode($enArray));
        }

        $success = $en ?true:false;
        if($success){
            set_alert('success', _l('added_successfully'));
        }
        redirect($_SERVER['HTTP_REFERER']);
        
    }

    public function delete_type($name, $type_name)
    {
        if (!has_permission('settings', '', 'delete')) {
            access_denied('settings');
        }

        $enArray = json_decode(get_option($type_name));
        
        $new_array = [];

        $name = urldecode($name);

        foreach($enArray as $obj){
            if($obj->key == $name)
                continue;
            $new_array[] = $obj;
        }

        $success = update_option($type_name,json_encode($new_array));
       
        if($success){
            set_alert('success', _l('deleted_successfully'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update_type($type_name)
    {
        if (!has_permission('settings', '', 'delete')) {
            access_denied('settings');
        }

        $old = $this->input->get('old');
        $new = $this->input->get('new');

        $enArray = json_decode(get_option($type_name));
        
        $new_array = [];

        $old = urldecode($old);

        foreach($enArray as $obj){
            if($obj->key == $old)
                continue;
            $new_array[] = $obj;
        }

        update_option($type_name,json_encode($new_array));

        $enArray = $new_array;
        if ($this->input->get()){
            $nameEn['key'] = $this->input->get('new');
            $nameEn['value'] = $this->input->get('new');
        }

        array_push($enArray,$nameEn );
        if (option_exists($type_name) != Null){
            $en = update_option($type_name,json_encode($enArray));
        }else{
            $en = add_option($type_name,json_encode($enArray));
        }

        $success = $en ?true:false;
        if($success){
            set_alert('success', _l('updated_successfully'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}