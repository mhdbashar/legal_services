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

    public function __construct($staff_email, $staffid, $task_id)
    {
        parent::__construct();

        $this->staff_email = $staff_email;
        $this->staffid     = $staffid;
        $this->task_id     = $task_id;
    }

    public function build()
    {
        $test=$this->to($this->staff_email)
        ->set_rel_id($this->procuration_id)
        ->set_staff_id($this->staffid)
        ->set_merge_fields('staff_merge_fields', $this->staffid)
        ->set_merge_fields('tasks_merge_fields', $this->task_id);
        print_r($test);
        exit();
    }
}
