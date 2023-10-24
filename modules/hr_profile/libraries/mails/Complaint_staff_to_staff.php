<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Complaint_staff_to_staff extends App_mail_template
{
    protected $for = 'complaint';

    protected $complaint;

    protected $staff;

    //protected $additional_data;

    public $slug = 'complaint-staff';

    public $rel_type = 'hr';

    public function __construct($complaint, $staff)
    {
        parent::__construct();
        $this->complaint = $complaint;
        $this->staff = $staff;
        //$this->additional_data = $additional_data;
    }

    public function build()
    {
        $this->to($this->staff->email)
            ->set_rel_id($this->complaint->id)
            ->set_merge_fields('complaint_staff_merge_fields', $this->complaint->id, $this->complaint);
    }
}