<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Send_report_session_to_staff extends App_mail_template
{
    protected $for = 'sessions';

    protected $session;

    protected $staff;

    public $slug = 'send_report_session_to_staff';

    public $rel_type = 'sessions';

    public function __construct($staff,$session, $cc = '')
    {
        parent::__construct();

        $this->session      = $session;
        $this->staff     = $staff;
        $this->cc           = $cc;
    }

    public function build()
    {
        $this->to($this->staff->email)
            ->set_rel_id($this->session->id)
            ->set_staff_id($this->staff->staffid)
            ->set_merge_fields('sessions_merge_fields',$this->session->id)
            ->set_merge_fields('staff_merge_fields', $this->staff->staffid);
    }
}
