<?php

defined('BASEPATH') or exit('No direct script access allowed');

class regular_duration_deadline_notification extends App_mail_template
{
    protected $for = 'staff';

    protected $staff_email;

    protected $staffid;

    protected $caseid;

    public $slug = 'regular_duration-deadline-notification';

    public $rel_type = 'regular_duration';

    public function __construct($staffemail, $staff_id, $case_id)
    {
        parent::__construct();

        $this->staff_email = $staffemail;
        $this->staffid     = $staff_id;
        $this->caseid     = $case_id;

    }

    public function build()
    {

        $this->set_merge_fields('staff_merge_fields', $this->staffid);
        $this->set_merge_fields('regular_duration_rem',$this->caseid);

        $this->to($this->staff_email)
            ->set_rel_id($this->staffid)
            ->set_rel_id( $this->caseid)

        ;




    }
}

