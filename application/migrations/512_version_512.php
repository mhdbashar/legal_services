<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_512 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        add_option('invoice_prefix_changed', false);
        add_option('credit_note_prefix_changed', false);
    }
}
