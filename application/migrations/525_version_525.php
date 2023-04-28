<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_525 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {

        if(!get_option('calendar_only_assigned_sessions')) {
            add_option('calendar_only_assigned_sessions', 0);
        }

        if(!get_option('show_sessions_on_calendar')) {
            add_option('show_sessions_on_calendar', 1);
        }

        if(!get_option('calendar_sessions_color')) {
            add_option('calendar_sessions_color', '#072377');
        }

    }
}