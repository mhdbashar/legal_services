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
        $automatically_send_lawyer_daily_agenda = '0'.get_option('automatically_send_lawyer_daily_agenda').':00';
        $automatically_send_lawyer_daily_agenda = date('H:i', strtotime($automatically_send_lawyer_daily_agenda . 'PM'));
        update_option('automatically_send_lawyer_daily_agenda', $automatically_send_lawyer_daily_agenda);
        add_option('daily_agenda_last_check', date('Y-m-d'));
    }
}
