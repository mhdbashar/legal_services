<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leave_staff_to_admin extends App_mail_template
{
    protected $for = 'leave';
    protected $leave;
    protected $staff;
    public $slug = 'leave-staff';
    public $rel_type = 'hr';

    public function __construct($params)
    {
        parent::__construct();

        if (!isset($params['leave']) || !isset($params['staff'])) {
            throw new Exception('Both $leave and $staff parameters are required.');
        }

        $this->leave = $params['leave'];
        $this->staff = $params['staff'];
    }

    public function build()
    {
        $this->to($this->staff['email'])
            ->set_rel_id($this->leave['id'])
            ->set_merge_fields('leave_staff_merge_fields', $this->leave['id'], $this->leave);
    }
}
