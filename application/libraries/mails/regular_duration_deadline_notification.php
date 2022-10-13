<?php

defined('BASEPATH') or exit('No direct script access allowed');

class regular_duration_deadline_notification extends App_mail_template
{
    protected $for = 'staff';

    protected $staff_email;

    protected $staffid;

    protected $case_id;

    public $slug = 'regular_duration-deadline-notification';

    public $rel_type = 'regular_duration';

    public function __construct($staff_email, $staffid, $case_id)
    {
        parent::__construct();

        $this->staffemail = $staff_email;
        $this->staff_id     = $staffid;
        $this->caseid     = $case_id;

    }

    public function build()
    {

        $this->set_merge_fields('staff_merge_fields', $this->staff_id);
        $this->set_merge_fields('regular_duration_rem',$this->caseid);

        $this->to($this->staff->email)
            ->set_rel_id($this->staff_id)
            ->set_rel_id($this->caseid)

        ;




    }
}

