<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transfer_staff_to_staff extends App_mail_template
{
    protected $for = 'transfer';

    protected $transfer;

    protected $staff;

    //protected $additional_data;

    public $slug = 'transfer-staff';

    public $rel_type = 'hr';

    public function __construct($transfer, $staff)
    {
        parent::__construct();
        $this->transfer = $transfer;
        $this->staff = $staff;
        //$this->additional_data = $additional_data;
    }

    public function build()
    {
        $this->to($this->staff->email)
            ->set_rel_id($this->transfer->id)
            ->set_merge_fields('transfer_staff_merge_fields', $this->transfer->id, $this->transfer);
    }
}