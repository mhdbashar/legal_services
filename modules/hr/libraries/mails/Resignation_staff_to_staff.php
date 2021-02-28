<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Resignation_staff_to_staff extends App_mail_template
{
    protected $for = 'resignation';

    protected $resignation;

    protected $staff;

    //protected $additional_data;

    public $slug = 'resignation-staff';

    public $rel_type = 'hr';

    public function __construct($resignation, $staff)
    {
        parent::__construct();
        $this->resignation = $resignation;
        $this->staff = $staff;
        //$this->additional_data = $additional_data;
    }

    public function build()
    {
        $this->to($this->staff->email)
            ->set_rel_id($this->resignation->id)
            ->set_merge_fields('resignation_staff_merge_fields', $this->resignation->id, $this->resignation);
    }
}