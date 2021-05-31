<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_Version_113 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        if (!$CI->db->table_exists(db_prefix() . 'timesheets_settings')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "timesheets_settings` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `key_app` text NOT NULL,
                  `timezone` varchar(200) DEFAULT NULL,
                  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');

            $CI->db->query("
                INSERT INTO `".db_prefix().'timesheets_settings'."` (`id`, `key_app`, `timezone`, `created_at`, `updated_at`) VALUES
                (1, '3k3u2oW2zX13xyPJiyBQwSE2QyFRvF0Cf2FbovqG', 'Asia/Makassar', '2021-04-08 13:48:26', '2021-04-11 16:06:52');
			");
        }
    }
}