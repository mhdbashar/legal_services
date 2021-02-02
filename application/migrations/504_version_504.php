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

        if (!$this->db->field_exists('deleted', db_prefix() . 'tasks')) {
            $this->db->query("ALTER TABLE `tbltasks` ADD `deleted` int(11) DEFAULT '0';");
          }

          if (!$this->db->field_exists('deleted', db_prefix() . 'creditnotes')) {
            $this->db->query("ALTER TABLE `tblcreditnotes` ADD `deleted` int(11) DEFAULT '0';");
          }

          if (!$this->db->field_exists('deleted', db_prefix() . 'estimates')) {
            $this->db->query("ALTER TABLE `tblestimates` ADD `deleted` int(11) DEFAULT '0';");
          }

          if (!$this->db->field_exists('deleted', db_prefix() . 'expenses')) {
            $this->db->query("ALTER TABLE `tblexpenses` ADD `deleted` int(11) DEFAULT '0';");
          }

          if (!$this->db->field_exists('deleted', db_prefix() . 'invoices')) {
            $this->db->query("ALTER TABLE `tblinvoices` ADD `deleted` int(11) DEFAULT '0';");
          }

          if (!$this->db->field_exists('deleted', db_prefix() . 'tickets')) {
            $this->db->query("ALTER TABLE `tbltickets` ADD `deleted` int(11) DEFAULT '0';");
          }

    }
}
