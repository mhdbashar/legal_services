<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_520 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `tblmy_knowledge_custom_fielsds_links` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `ct_id` int(11) NOT NULL,
            `ct_link_id` int(11) NOT NULL,
            `knowledge_link_id` int(11) NOT NULL,
            `group_link_id` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `ct_id` (`ct_id`),
            KEY `ct_link_id` (`ct_link_id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
    }
}