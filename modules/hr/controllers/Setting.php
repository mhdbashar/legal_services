<?php

class Setting extends AdminController{


	public function __construct(){
		parent::__construct();
	}

	public function deduction_type(){

		$enArray=array();
		if (option_exists('deduction_type') != Null){
            $enArray = json_decode(get_option('deduction_type'));
        }else{
            $enArray=array();
        }
//        var_dump($this->input->post('nameEn'));exit();

        if ($this->input->get()){
	        $nameEn['key'] = $this->input->get('nameEn');
	        $nameEn['value'] = $this->input->get('nameEn');
        }

        array_push($enArray,$nameEn );
        if (option_exists('deduction_type') != Null){
            $en = update_option('deduction_type',json_encode($enArray));
        }else{
            $en = add_option('deduction_type',json_encode($enArray));
        }

        $success = $en ?true:false;
        if($success){
        	set_alert('success', 'Added successfully');
        }
        /*
        $message = $success ? _l('added_successfully', _l('incoming_side')) : '';
        echo json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $nameEn,
        ]);
        */
		redirect($_SERVER['HTTP_REFERER']);
		
	}

	public function delete_deduction_type($name)
    {
        if (!has_permission('settings', '', 'delete')) {
            access_denied('settings');
        }

        $enArray = json_decode(get_option('deduction_type'));
        
        $new_array = [];

        $name = urldecode($name);

        foreach($enArray as $obj){
        	if($obj->key == $name)
        		continue;
        	$new_array[] = $obj;
        }

        $success = update_option('deduction_type',json_encode($new_array));
       
        if($success){
        	set_alert('success', 'Deleted successfully');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function deduction(){
		if ($this->input->is_ajax_request()) {
			$this->hrmapp->get_table_data('my_deduction_types_table');
		}
        $data['title'] = 'Manage Deduction Tabs';
		$this->load->view('settings/tabs/deduction');
	}
}