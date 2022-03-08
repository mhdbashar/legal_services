<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_518 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        add_option('daily_agenda_last_check', date('Y-m-d'));
    }
}
