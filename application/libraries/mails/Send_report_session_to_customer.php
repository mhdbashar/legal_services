<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Send_report_session_to_customer extends App_mail_template
{
    protected $for = 'sessions';

    protected $subscription;

    protected $contact;

    public $slug = 'send_report_session';

    public $rel_type = 'sessions';

    public function __construct($subscription, $contact, $cc = '')
    {
        parent::__construct();

        $this->subscription = $subscription;
        $this->contact      = $contact;
        $this->cc           = $cc;
    }

    public function build()
    {
        $this->to($this->contact->email)
            ->set_rel_id($this->subscription->id)
            ->set_merge_fields('sessions_merge_fields', $this->subscription->id);
    }
}
