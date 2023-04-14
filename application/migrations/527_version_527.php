<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_527 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {

        add_option('settings[regular_durations_reminder_notification_before]', '5');


    }
}