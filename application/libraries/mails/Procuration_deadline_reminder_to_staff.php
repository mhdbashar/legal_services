<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Procuration_deadline_reminder_to_staff extends App_mail_template
{
    protected $for = 'staff';

    protected $staff_email;

    protected $staffid;

    protected $procuration_id;

    public $slug = 'procuration-deadline-notification';

    public $rel_type = 'procuration';

    public function __construct($staff_email,$staff_id, $case_id, $proc_id)
    {
        parent::__construct();

        $this->staff_email = $staff_email;
        $this->staff_id = $staff_id;
        $this->case_id     = $case_id;
        $this->proc_id    = $proc_id;


    }

    public function build()
    {
        $this->to($this->staff_email)
            ->set_rel_id($this->staff_id)
            ->set_merge_fields('staff_merge_fields', $this->staffid)
            ->set_merge_fields('procuration_rem', $this->case_id, $this->proc_id);
    }
}
