<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Send_lawyer_daily_agenda_to_staff extends App_mail_template
{ protected $for = 'staff';

    protected $staff_email;

    protected $staffid;

    protected $todo_id;

    public $slug = 'send_lawyer_daily_agenda_to_staff';

    public $rel_type = 'lawyer_daily_agenda';


    public function __construct($staff_email,$staff_id)
    {
        parent::__construct();

        $this->staff_email = $staff_email;
        $this->staffid = $staff_id;
     
      


    }

    public function build()
    {
        $this->to($this->staff_email)
            ->set_rel_id($this->staff_id)
            ->set_merge_fields('staff_merge_fields', $this->staffid)
            ->set_merge_fields('send_lawyer_daily_agenda_merge_fields',  $this->staffid);
    }
}
