<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_304 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        if (!$CI->db->field_exists('is_notification', db_prefix() . 'insurance_book_nums')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."insurance_book_nums` ADD `is_notification` int(11) DEFAULT 0;");
        }
        if (!$CI->db->field_exists('recurring_from', db_prefix() . 'insurance_book_nums')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."insurance_book_nums` ADD `recurring_from` int(11) DEFAULT 0;");
        }
        if (!$CI->db->field_exists('deadline_notified', db_prefix() . 'insurance_book_nums')) {
            $CI->db->query("ALTER TABLE `".db_prefix() ."insurance_book_nums` ADD `deadline_notified` int(11) DEFAULT 0;");
        }

    }
}

