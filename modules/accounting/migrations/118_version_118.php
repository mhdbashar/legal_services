<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_118 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        //Version 1.1.2


        if (!$CI->db->field_exists('account_type_master' ,db_prefix() . 'acc_accounts')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'acc_accounts`
            ADD COLUMN `account_type_master` INT(11) NOT NULL DEFAULT 0;');
        }
        
    }
}
