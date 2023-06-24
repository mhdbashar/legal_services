<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_109 extends App_module_migration
{
	public function up()
	{
        $CI = &get_instance();

        //V108: //Add new columns to staff table

        if (!$CI->db->field_exists('notification_email' ,db_prefix() . 'hr_documents')) {
            $CI->db->query("ALTER TABLE `' . db_prefix() . 'hr_documents`
            ADD COLUMN `notification_email` varchar(255) NOT NULL ");
        }


	}


}
