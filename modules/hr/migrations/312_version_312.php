<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_312 extends App_module_migration
{
    public function up(){
        $CI = &get_instance();



        if (!$CI->db->table_exists(db_prefix() . 'hr_education')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_education` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `staff_id` INT(11) NOT NULL,
              `admin_id` INT(11) NOT NULL,
              `programe_id` INT(11) NULL,
              `training_programs_name` text NOT NULL,
              `training_places` text NULL,
              `training_time_from` DATETIME  NULL,
              `training_time_to` DATETIME  NULL,
              `date_create` DATETIME NULL,
              `training_result` VARCHAR(150) NULL,
              `degree` VARCHAR(150) NULL,
              `notes` text NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }
        if (!$CI->db->table_exists(db_prefix() . 'setting_training')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . 'setting_training` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `training_type` INT(11) NOT NULL,
            `position_training` VARCHAR(100) NULL,
            PRIMARY KEY (`id`));');
        }
        if (!$CI->db->table_exists(db_prefix() . 'position_training_question_form')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "position_training_question_form` (
            `questionid` int(11) NOT NULL AUTO_INCREMENT,
            `rel_id` int(11) NOT NULL,
            `rel_type` varchar(20) DEFAULT NULL,
            `question` mediumtext NOT NULL,
            `required` tinyint(1) NOT NULL DEFAULT '0',
            `question_order` int(11) NOT NULL,
            `point`int(11) NOT NULL,
        
            PRIMARY KEY (`questionid`)
          ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }

        if (!$CI->db->table_exists(db_prefix() . 'hr_training_allocation')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_training_allocation` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `training_process_id` VARCHAR(100) NOT NULL,
            `staffid` INT(11) NULL,
            `training_type` int(11) NULL,
            `date_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `training_name` varchar(150) NULL,
        
             PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }
        if (!$CI->db->table_exists(db_prefix() . 'hr_jp_interview_training')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_jp_interview_training` (
              `training_process_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
              `job_position_id` LONGTEXT NULL,
              `training_name` VARCHAR(100) NULL,
              `training_type` int(11) NULL,
              `description` TEXT NULL,
              `date_add` datetime NULL,
              `position_training_id` TEXT NULL,
              `mint_point` INT(11) NULL,
        
              PRIMARY KEY (`training_process_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }

        if (!$CI->db->field_exists('jp_interview_training_id' ,db_prefix() . 'hr_training_allocation')) {
            $CI->db->query('ALTER TABLE `' . db_prefix() . "hr_training_allocation`
            ADD COLUMN `jp_interview_training_id` INT(11) NULL ;");
        }
        if (!$CI->db->table_exists(db_prefix() . 'hr_p_t_surveyresultsets')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_p_t_surveyresultsets` (
           `resultsetid` int(11) NOT NULL AUTO_INCREMENT,
            `trainingid` int(11) NOT NULL,
            `ip` varchar(40) NOT NULL,
            `useragent` varchar(150) NOT NULL,
            `date` datetime NOT NULL,
            `staff_id` int(11) UNSIGNED NOT NULL,
        
             PRIMARY KEY (`resultsetid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }

        if (!$CI->db->table_exists(db_prefix() . 'hr_position_training')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_position_training` (
            `training_id` int(11) NOT NULL AUTO_INCREMENT,
            `subject` mediumtext NOT NULL,
            `training_type` int(11) UNSIGNED NOT NULL,
            `slug` mediumtext NOT NULL,
            `description` text  NULL,
            `viewdescription` text,
            `datecreated` datetime NOT NULL,
            `redirect_url` varchar(100) DEFAULT NULL,
            `send` tinyint(1) NOT NULL DEFAULT '0',
            `onlyforloggedin` int(11) DEFAULT '0',
            `fromname` varchar(100) DEFAULT NULL,
            `iprestrict` tinyint(1) NOT NULL,
            `active` tinyint(1) NOT NULL DEFAULT '1',
            `hash` varchar(32) NOT NULL,
            `mint_point` VARCHAR(20) NULL,
        
            PRIMARY KEY (`training_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }
        if (!$CI->db->table_exists(db_prefix() . 'hr_p_t_form_question_box')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_p_t_form_question_box` (
           `boxid` int(11) NOT NULL AUTO_INCREMENT,
            `boxtype` varchar(10) NOT NULL,
            `questionid` int(11) NOT NULL,
        
          PRIMARY KEY (`boxid`)
          ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }


        if (!$CI->db->table_exists(db_prefix() . 'hr_p_t_form_results')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_p_t_form_results` (
      
            `resultid` int(11) NOT NULL AUTO_INCREMENT,
            `boxid` int(11) NOT NULL,
            `boxdescriptionid` int(11) DEFAULT NULL,
            `rel_id` int(11) NOT NULL,
            `rel_type` varchar(20) DEFAULT NULL,
            `questionid` int(11) NOT NULL,
            `answer` text,
            `resultsetid` int(11) NOT NULL,
        
            PRIMARY KEY (`resultid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');

        }

        if (!$CI->db->table_exists(db_prefix() . 'hr_p_t_form_question_box_description')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_p_t_form_question_box_description` (
            `questionboxdescriptionid` int(11) NOT NULL AUTO_INCREMENT,
            `description` mediumtext NOT NULL,
            `boxid` mediumtext NOT NULL,
            `questionid` int(11) NOT NULL,
            `correct` int(11) NULL DEFAULT '1' COMMENT'0: correct 1: incorrect',
        
          PRIMARY KEY (`questionboxdescriptionid`)
        
          ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }

        if (!$CI->db->table_exists(db_prefix() . 'hr_position_training_question_form')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_position_training_question_form` (
            `questionid` int(11) NOT NULL AUTO_INCREMENT,
            `rel_id` int(11) NOT NULL,
            `rel_type` varchar(20) DEFAULT NULL,
            `question` mediumtext NOT NULL,
            `required` tinyint(1) NOT NULL DEFAULT '0',
            `question_order` int(11) NOT NULL,
            `point`int(11) NOT NULL,
        
            PRIMARY KEY (`questionid`)

  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }



    }
}
