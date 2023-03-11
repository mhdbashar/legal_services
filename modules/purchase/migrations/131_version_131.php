<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Migration_Version_131 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        $CI->db->query('ALTER TABLE tblpur_request CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;');
        $CI->db->query('ALTER TABLE tblpur_orders CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;');

        if (!$CI->db->field_exists('rel_id', db_prefix() . 'pur_request')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'pur_request` ADD `rel_id` int(11) NULL DEFAULT NULL');
        }


        if (!$CI->db->field_exists('rel_type', db_prefix() . 'pur_request')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'pur_request` ADD `rel_type` varchar(30) NULL DEFAULT NULL');
        }

        if (!$CI->db->field_exists('rel_id', db_prefix() . 'pur_orders')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'pur_orders` ADD `rel_id` int(11) NULL DEFAULT NULL');
        }


        if (!$CI->db->field_exists('rel_type', db_prefix() . 'pur_orders')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . 'pur_orders` ADD `rel_type` varchar(30) NULL DEFAULT NULL');
        }
    }
}