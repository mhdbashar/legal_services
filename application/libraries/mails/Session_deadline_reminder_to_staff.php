<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Session_deadline_reminder_to_staff extends App_mail_template
{
    protected $for = 'sessions';

    protected $staff_email;

    protected $staffid;

    protected $task_id;

    public $slug = 'session-deadline-notification';

    public $rel_type = 'sessions';

    public function __construct($staff_email, $staffid, $task_id)
    {
        parent::__construct();

        $this->staff_email = $staff_email;
        $this->staffid     = $staffid;
        $this->task_id     = $task_id;
    }

    public function build()
    {
        $this->to($this->staff_email)
        ->set_rel_id($this->task_id)
        ->set_staff_id($this->staffid)
        ->set_merge_fields('sessions_merge_fields', $this->task_id)
        ->set_merge_fields('staff_merge_fields', $this->staffid);

    }
}
