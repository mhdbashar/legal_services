<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_117 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        //Version 1.1.2


        if (!$CI->db->field_exists('type' ,db_prefix() . 'acc_journal_entries')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_journal_entries`
            ADD COLUMN `type` INT(11) NOT NULL DEFAULT 0;');
        }
        
    }
}
