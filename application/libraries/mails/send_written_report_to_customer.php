<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Send_written_report_to_customer extends App_mail_template
{
    protected $for = 'written_report';

    protected $report;

    protected $contact;

    public $slug = 'send_written_report_to_customer';

    public $rel_type = 'written_report';

    public function __construct($contact,$report, $cc = '')
    {
        parent::__construct();

        $this->report       = $report;
        $this->contact      = $contact;
        $this->cc           = $cc;
    }

    public function build()
    {
        $this->to($this->contact->email)->set_merge_fields('wreports_merge_fields',$this->report->id);
    }
}
