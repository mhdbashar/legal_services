<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Send_report_session_to_customer extends App_mail_template
{
    protected $for = 'sessions';

    protected $session;

    protected $contact;

    protected $client_id;

    public $slug = 'send_report_session';

    public $rel_type = 'sessions';

    public function __construct($client_id,$contact,$session, $cc = '')
    {
        parent::__construct();

        $this->session      = $session;
        $this->contact      = $contact;
        $this->client_id    = $client_id;
        $this->cc           = $cc;
    }

    public function build()
    {
        $this->to($this->contact->email)->set_merge_fields('sessions_merge_fields',$this->session->id)
            ->set_merge_fields('client_merge_fields',$this->client_id, $this->contact->id);
    }
}
