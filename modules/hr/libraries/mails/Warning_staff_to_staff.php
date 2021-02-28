<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Warning_staff_to_staff extends App_mail_template
{
    protected $for = 'warning';

    protected $warning;

    protected $staff;

    //protected $additional_data;

    public $slug = 'warning-staff';

    public $rel_type = 'hr';

    public function __construct($warning, $staff)
    {
        parent::__construct();
        $this->warning = $warning;
        $this->staff = $staff;
        //$this->additional_data = $additional_data;
    }

    public function build()
    {
        $this->to($this->staff->email)
            ->set_rel_id($this->warning->id)
            ->set_merge_fields('warning_staff_merge_fields', $this->warning->id, $this->warning);
    }
}