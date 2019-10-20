<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Session_new_attachment_to_customer extends App_mail_template
{
    protected $for = 'sessions';

    protected $contact_email;

    protected $client_id;

    protected $contact_id;

    protected $task_id;

    public $slug = 'session-added-attachment-to-contacts';

    public $rel_type = 'sessions';

    public function __construct($contact_email, $client_id, $contact_id, $task_id)
    {
        parent::__construct();

        $this->contact_email = $contact_email;
        $this->client_id     = $client_id;
        $this->contact_id    = $contact_id;
        $this->task_id       = $task_id;
    }

    public function build()
    {
        $this->to($this->contact_email)
        ->set_rel_id($this->task_id)
        ->set_merge_fields('sessions_merge_fields', $this->client_id, $this->contact_id);
    }
}
