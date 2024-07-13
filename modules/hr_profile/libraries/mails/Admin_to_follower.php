<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin_to_follower extends App_mail_template
{
    protected $for = 'follow the leave situation of staff';

    protected $follow;

    protected $staff;

    //protected $additional_data;

    public $slug = 'follow_the_leave';

    public $rel_type = 'hr';

    public function __construct($follow , $staff)
    {
      if (!isset($follow) || !isset($staff)) {
        throw new Exception('Both parameters $leave and $staff are required.');
    }
        parent::__construct();
        $this->timesheets_requisition_leave = $follow;
        $this->staff = $staff;
        //$this->additional_data = $additional_data;
    }

    public function build()
    {
        $this->to($this->staff->email)
            ->set_rel_id($this->timesheets_requisition_leave->id)
            ->set_merge_fields('Follow_leave_merge_fields', $this->timesheets_requisition_leave->id, $this->timesheets_requisition_leave);
    }
}