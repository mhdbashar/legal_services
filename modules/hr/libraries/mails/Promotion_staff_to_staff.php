<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Promotion_staff_to_staff extends App_mail_template
{
    protected $for = 'promotion';

    protected $promotion;

    protected $staff;

    //protected $additional_data;

    public $slug = 'promotion-staff';

    public $rel_type = 'hr';

    public function __construct($promotion, $staff)
    {
        parent::__construct();
        $this->promotion = $promotion;
        $this->staff = $staff;
        //$this->additional_data = $additional_data;
    }

    public function build()
    {
        $this->to($this->staff->email)
            ->set_rel_id($this->promotion->id)
            ->set_merge_fields('promotion_staff_merge_fields', $this->promotion->id, $this->promotion);
    }
}