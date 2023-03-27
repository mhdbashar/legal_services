<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_526 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmessages` (
            `id` int(11) NOT NULL,
            `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Untitled',
            `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
            `created_at` datetime NOT NULL DEFAULT current_timestamp(),
            `from_user_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            `to_user_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            `status` enum('unread','read') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unread',
            `message_id` int(11) NOT NULL DEFAULT 0,
            `deleted` int(1) NOT NULL DEFAULT 0,
            `files` longtext COLLATE utf8_unicode_ci NOT NULL,
            `deleted_by_users` text COLLATE utf8_unicode_ci NOT NULL,
             PRIMARY KEY (`id`)
          )  ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

    }
}