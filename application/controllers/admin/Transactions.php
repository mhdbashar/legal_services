<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Transactions extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transactions_model');

    }

    public function incoming(){

        $this->load->view('admin/transactions/incoming');
    }
    public function outgoing(){

        $this->load->view('admin/transactions/outgoing');
    }

    public function table($type = '')
    {

    }

    public function transaction($id = ''){

    }

    public function delete_transaction($id = ''){

    }

}