<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_506 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        update_option('task_biillable_checked_on_creation',0);
        update_option('calendar_first_day', 0);
    }
}
