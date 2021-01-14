<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_504 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        $CI = &get_instance();

        add_option('show_services_on_calendar', 1);

        add_option('calendar_service_color', '#B72974');

    }
}
