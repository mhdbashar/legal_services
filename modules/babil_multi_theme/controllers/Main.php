<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends AdminController
{

 public function __construct()
 {
    parent::__construct();
    $this->load->model('main_model');

}

public function update_color()
{

    if ($this->input->is_ajax_request()) {
        $success = $this->main_model->update_color($this->input->get());
        echo $success;
    }
}

}