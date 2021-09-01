<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_510 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        add_option('_fix_staffs_and_contacts_names', false);

        if (!$this->db->field_exists('second_name' ,db_prefix() . 'staff')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'staff`
            ADD COLUMN `second_name` varchar(191) NULL AFTER `firstname`');
        }
        if (!$this->db->field_exists('third_name' ,db_prefix() . 'staff')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'staff`
            ADD COLUMN `third_name` varchar(191) NULL AFTER `second_name`');
        }
    }
}
