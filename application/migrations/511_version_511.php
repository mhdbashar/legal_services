<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_511 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        if (!$this->db->field_exists('qr_code', db_prefix() . 'invoices')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'invoices` ADD `qr_code` TEXT NULL DEFAULT NULL');
        }
    }
}
