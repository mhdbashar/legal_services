<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Zoom_client extends ClientsController
{
	 public function __construct()
    {
        parent::__construct();

    }
    public function index()
    {
        
        
        $this->load->view('zoom/zoom_client');
    }
    
}