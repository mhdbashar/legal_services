<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Regular_duration_deadline_notification  extends App_mail_template
{

    protected $for = 'staff';

    protected $staff_email;

    protected $caseid;

    protected $staffid;

    public $slug = 'regular-duration-deadline-notification';


    public $rel_type = 'regular_duration';

    public function __construct($staff_email, $staffid, $caseid ,$reg_id)
    {
        parent::__construct();
        $this->staff_email       = $staff_email;
        $this->staffid           = $staffid;
        $this->caseid = $caseid;
        $this->reg_id = $reg_id;
    }

    public function build()
    {
        $this->to($this->staff_email)
            ->set_rel_id($this->staffid)
            ->set_merge_fields('staff_merge_fields', $this->staffid)
        ->set_merge_fields('regular_duration_rem', $this->caseid, $this->reg_id);
    }
}
