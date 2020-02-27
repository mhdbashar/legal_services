<?php

class Timesheet extends AdminController{

	public function __construct(){
		parent::__construct();
	}

	public function holidays(){
		echo _l('holiday');
	}
}