<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_309 extends App_module_migration
{
    public function up(){
        $CI = &get_instance();

        if (!$CI->db->table_exists(db_prefix() . 'hr_knowledge_base_groups')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_knowledge_base_groups` (
            `groupid` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(191) NOT NULL,
            `group_slug` text,
            `description` mediumtext,
            `active` tinyint(4) NOT NULL,
            `color` varchar(10) DEFAULT '#28B8DA',
            `group_order` int(11) DEFAULT '0',
        
            PRIMARY KEY (`groupid`)
          ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }



        /*knowledge_base for Q&A*/
        if (!$CI->db->table_exists(db_prefix() . 'hr_knowledge_base')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_knowledge_base` (
            `articleid` int(11) NOT NULL AUTO_INCREMENT,
            `articlegroup` int(11) NOT NULL,
            `subject` mediumtext NOT NULL,
            `description` text NOT NULL,
            `slug` mediumtext NOT NULL,
            `active` tinyint(4) NOT NULL,
            `datecreated` datetime NOT NULL,
            `article_order` int(11) NOT NULL DEFAULT '0',
            `staff_article` int(11) NOT NULL DEFAULT '0',
            `question_answers` int(11) DEFAULT '0',
            `file_name` varchar(255) DEFAULT '',
            `curator` varchar(11) DEFAULT '',
            `benchmark` int(11) DEFAULT '0',
            `score` int(11) DEFAULT '0',
        
            PRIMARY KEY (`articleid`)
          ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }


        if (!$CI->db->table_exists(db_prefix() . 'hr_views_tracking')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_views_tracking` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `rel_id` int(11) NOT NULL,
            `rel_type` varchar(40) NOT NULL,
            `date` datetime NOT NULL,
            `view_ip` varchar(40) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }


        if (!$CI->db->table_exists(db_prefix() . 'hr_knowedge_base_article_feedback')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_knowedge_base_article_feedback` (
            `articleanswerid` int(11) NOT NULL AUTO_INCREMENT,
            `articleid` int(11) NOT NULL,
            `answer` int(11) NOT NULL,
            `ip` varchar(40) NOT NULL,
            `date` datetime NOT NULL,
        
            PRIMARY KEY (`articleanswerid`)
          ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }


    }
}
