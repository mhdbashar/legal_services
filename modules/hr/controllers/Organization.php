<?php

class Organization extends AdminController{

	public function __construct(){
		parent::__construct();
	}

	public function officail_documents(){

	}

	public function location(){
		$data['title'] = 'Location';
		$this->load->view('organization/location', $data);
	}

	public function designation(){

	}
}