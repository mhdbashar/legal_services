<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reminder_for_next_session_action extends App_mail_template
{
    protected $for = 'sessions';

    protected $task_id;

    protected $contact;

    protected $client_id;

    public $slug = 'next_session_action';

    public $rel_type = 'sessions';

    public function __construct($client_id,$contact, $task_id)
    {
        parent::__construct();

        $this->task_id      = $task_id;
        $this->contact      = $contact;
        $this->client_id    = $client_id;
    }

    public function build()
    {
        $this->to($this->contact->email)->set_merge_fields('sessions_merge_fields', $this->task_id)
            ->set_merge_fields('client_merge_fields',$this->client_id, $this->contact->id);
    }
}
