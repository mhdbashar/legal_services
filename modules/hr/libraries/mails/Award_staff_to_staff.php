<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Award_staff_to_staff extends App_mail_template
{
    protected $for = 'award';

    protected $award;

    protected $staff;

    //protected $additional_data;

    public $slug = 'award-staff';

    public $rel_type = 'hr';

    public function __construct($award, $staff)
    {
        parent::__construct();
        $this->award = $award;
        $this->staff = $staff;
        //$this->additional_data = $additional_data;
    }

    public function build()
    {
        $this->to($this->staff->email)
            ->set_rel_id($this->award->id)
            ->set_merge_fields('award_staff_merge_fields', $this->award->id, $this->award);
    }
}