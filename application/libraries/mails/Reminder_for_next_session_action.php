<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reminder_for_next_session_action extends App_mail_template
{
    protected $for = 'sessions';

    protected $task_id;

    protected $contact;

    public $slug = 'next_session_action';

    public $rel_type = 'sessions';

    public function __construct($contact, $task_id)
    {
        parent::__construct();

        $this->task_id      = $task_id;
        $this->contact      = $contact;
    }

    public function build()
    {
        $this->to($this->contact->email)->set_merge_fields('sessions_merge_fields', $this->task_id);
    }
}
