<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Travel_staff_to_staff extends App_mail_template
{
    protected $for = 'travel';

    protected $travel;

    protected $staff;

    //protected $additional_data;

    public $slug = 'travel-staff';

    public $rel_type = 'hr';

    public function __construct($travel, $staff)
    {
        parent::__construct();
        $this->travel = $travel;
        $this->staff = $staff;
        //$this->additional_data = $additional_data;
    }

    public function build()
    {
        $this->to($this->staff->email)
            ->set_rel_id($this->travel->id)
            ->set_merge_fields('travel_staff_merge_fields', $this->travel->id, $this->travel);
    }
}