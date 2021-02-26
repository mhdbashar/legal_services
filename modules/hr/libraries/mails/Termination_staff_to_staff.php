<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Termination_staff_to_staff extends App_mail_template
{
    protected $for = 'termination';

    protected $termination;

    protected $staff;

    //protected $additional_data;

    public $slug = 'termination-staff';

    public $rel_type = 'hr';

    public function __construct($termination, $staff)
    {
        parent::__construct();
        $this->termination = $termination;
        $this->staff = $staff;
    }

    public function build()
    {
        $this->to($this->staff->email)
            ->set_rel_id($this->termination->id)
            ->set_merge_fields('termination_staff_merge_fields', $this->termination->id, $this->termination);
    }
}