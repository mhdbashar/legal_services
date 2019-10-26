<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Send_report_session_to_customer extends App_mail_template
{
    protected $for = 'sessions';

    protected $session;

    protected $contact;

    public $slug = 'send_report_session';

    public $rel_type = 'sessions';

    public function __construct($contact,$session, $cc = '')
    {
        parent::__construct();

        $this->session = $session;
        $this->contact      = $contact;
        $this->cc           = $cc;
    }

    public function build()
    {
        $this->to($this->contact->email)
            ->set_merge_fields('sessions_merge_fields',$this->session->id);
    }
}
