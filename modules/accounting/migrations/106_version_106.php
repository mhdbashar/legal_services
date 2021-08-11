<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_106 extends App_module_migration
{
     public function up()
     {
        $CI = &get_instance();
        
        //Version 1.0.6
         $CI->db->query("DELETE FROM tblacc_accounts WHERE key_name = 'acc_interest_income'");

     }
}
