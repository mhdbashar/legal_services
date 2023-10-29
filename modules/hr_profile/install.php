<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!$CI->db->table_exists(db_prefix() . 'hr_profile_option')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_profile_option` (
    `option_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `option_name` varchar(200) NOT NULL,
    `option_val` longtext NULL,
    `auto` tinyint(1) NULL,
    PRIMARY KEY (`option_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_profile_immigration')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_profile_immigration` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `document_type` varchar(255) NOT NULL, 
    `document_number` varchar(255) NOT NULL, 
    `issue_date` date NOT NULL, 
    `date_expiry` date NOT NULL, 
    `document_file` varchar(255) NOT NULL,
    `eligible_review_date` date NOT NULL, 
    `country` varchar(255) NOT NULL,
    `is_notification` int(11) NOT NULL,
    `recurring_from` int(11) NOT NULL,
    `deadline_notified` int(11) NOT NULL, 
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'hr_emergency_contact')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_emergency_contact` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `relation` varchar(255) NOT NULL, 
    `email` varchar(255) NOT NULL, 
    `personal` varchar(255) NOT NULL, 
    `is_primary` int(1) NOT NULL, 
    `is_dependent` int(1) NOT NULL, 
    `name` varchar(255) NOT NULL, 
    `address_1` varchar(255) NOT NULL, 
    `address_2` varchar(255) NOT NULL, 
    `work` varchar(255) NOT NULL,
    `ext` varchar(255) NOT NULL,
    `home` varchar(255) NOT NULL,
    `mobile` varchar(255) NOT NULL,
    `city` varchar(255) NOT NULL, 
    `state` varchar(255) NOT NULL, 
    `zip_code` int(11) NOT NULL,
    `country` varchar(255) NOT NULL, 
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!$CI->db->field_exists('manager_id' ,db_prefix() . 'departments')) { 
  $CI->db->query('ALTER TABLE `' . db_prefix() . "departments`
    ADD COLUMN `manager_id` INT(11) NULL DEFAULT 0;");
}
if (!$CI->db->field_exists('parent_id' ,db_prefix() . 'departments')) { 
  $CI->db->query('ALTER TABLE `' . db_prefix() . "departments`
    ADD COLUMN `parent_id` INT(11) NULL DEFAULT 0;");
}
if (!$CI->db->table_exists(db_prefix() . 'rec_transfer_records')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "rec_transfer_records` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `staffid` int(11) NOT NULL,
    `firstname` varchar(100) NULL,
    `lastname` varchar(100) NULL,
    `birthday` date NULL,
    `gender` varchar(11) NULL,
    `staff_identifi` varchar(20) NULL,
    `creator` int(11) NULL,
    `datecreator` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'setting_transfer_records')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "setting_transfer_records` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`varchar(150),  
    `meta` varchar(50),  
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'rec_set_transfer_record')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "rec_set_transfer_record` (
    `set_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `send_to` varchar(45) NOT NULL,
    `email_to` text NULL,
    `add_from` int(11) NOT NULL,
    `add_date` date NOT NULL,
    `subject` text NOT NULL,
    `content` text NULL,
    `order` int(11) NOT NULL,
    PRIMARY KEY (`set_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'setting_asset_allocation')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "setting_asset_allocation` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(150),     
    `meta` varchar(50),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'records_meta')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "records_meta` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(150),  
    `meta` varchar(100),  
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');

  $data_array = array( 
    array("staff_identifi", "staff_identifi"), 
    array("firstname", "firstname"), 
    array("email", "email"), 
    array("phonenumber", "phonenumber"), 
    array("facebook", "facebook"), 
    array("skype", "skype"), 
    array("birthday", "birthday"), 
    array("birthplace", "birthplace"), 
    array("home_town", "home_town"), 
    array("marital_status", "marital_status"), 
    array("nation", "nation"), 
    array("religion", "religion"), 
    array("identification", "identification"), 
    array("days_for_identity", "days_for_identity"), 
    array("place_of_issue", "place_of_issue"), 
    array("resident", "resident"), 
    array("current_address", "current_address"), 
    array("literacy", "literacy"), 
  ); 
  foreach ($data_array as $key => $value) {
    $data['name']=$value[0];
    $data['meta']=$value[1];
    $CI->db->insert(db_prefix() . 'records_meta', $data);
  }    
}
if (!$CI->db->table_exists(db_prefix() . 'group_checklist')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'group_checklist` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `group_name` VARCHAR(100) NOT NULL,
    `meta` VARCHAR(100) NULL,
    PRIMARY KEY (`id`));');
}
if (!$CI->db->table_exists(db_prefix() . 'setting_training')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'setting_training` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `training_type` INT(11) NOT NULL,
    `position_training` VARCHAR(100) NULL,
    PRIMARY KEY (`id`));');
}
if (!$CI->db->table_exists(db_prefix() . 'rec_criteria')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "rec_criteria` (
    `criteria_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `criteria_type` varchar(45) NOT NULL,
    `criteria_title` varchar(200) NOT NULL,
    `group_criteria` int(11)  NULL,
    `description` text NULL,
    `add_from` int(11) NOT NULL,
    `add_date` date NULL,
    `score_des1` text NULL,
    `score_des2` text NULL,
    `score_des3` text NULL,
    `score_des4` text NULL,
    `score_des5` text NULL,
    PRIMARY KEY (`criteria_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
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

if (!$CI->db->table_exists(db_prefix() . 'p_t_form_question_box_description')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "p_t_form_question_box_description` (
   `questionboxdescriptionid` int(11) NOT NULL AUTO_INCREMENT,
   `description` mediumtext NOT NULL,
   `boxid` mediumtext NOT NULL,
   `questionid` int(11) NOT NULL,
   `correct` int(11) NULL DEFAULT '1' COMMENT'0: correct 1: incorrect',

   PRIMARY KEY (`questionboxdescriptionid`)
 ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');

}
if (!$CI->db->table_exists(db_prefix() . 'checklist')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'checklist` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `group_id` int(11) NULL,
    PRIMARY KEY (`id`));');
}

if (!$CI->db->table_exists(db_prefix() . 'group_checklist_allocation')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'group_checklist_allocation` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `group_name` VARCHAR(100) NOT NULL,
    `meta` VARCHAR(100) NULL,
    `staffid` INT(11) NULL,
    PRIMARY KEY (`id`));');
}
if (!$CI->db->table_exists(db_prefix() . 'checklist_allocation')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'checklist_allocation` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `group_id` INT(11) NULL,
    `staffid` INT(11) NULL,
    `status` INT(11) NULL DEFAULT 0,
    PRIMARY KEY (`id`));');
}

if (!$CI->db->table_exists(db_prefix() . 'training_allocation')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'training_allocation` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `training_process_id` VARCHAR(100) NOT NULL,
    `staffid` INT(11) NULL,
    `training_type` int(11) NULL,
    `date_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `training_name` varchar(150) NULL,
    PRIMARY KEY (`id`));');
}
if (!$CI->db->table_exists(db_prefix() . 'transfer_records_reception')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "transfer_records_reception` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`varchar(150),  
    `meta` varchar(50), 
    `staffid` int(11) NULL, 
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('question_answers' ,db_prefix() . 'knowledge_base')) { 
  $CI->db->query('ALTER TABLE `' . db_prefix() . "knowledge_base`
    ADD COLUMN `question_answers` INT(11) NULL DEFAULT 0,
    ADD COLUMN `file_name` VARCHAR(255) NULL DEFAULT '',
    ADD COLUMN `curator` VARCHAR(11) NULL DEFAULT '',
    ADD COLUMN `benchmark` INT(11) NULL DEFAULT 0, 
    ADD COLUMN `score` INT(11) NULL DEFAULT 0
    ;");
}
if (!$CI->db->table_exists(db_prefix() . 'rec_job_position')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "rec_job_position` (
    `position_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `position_name` varchar(200) NOT NULL,
    `position_description` text NULL,
    PRIMARY KEY (`position_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'bonus_discipline')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "bonus_discipline` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NULL,
    `id_criteria`  VARCHAR(200)  NULL,
    `type` int(3)  NOT NULL,
    `apply_for` varchar(50) NULL, 
    `from_time` DATETIME NULL ,
    `lever_bonus` int(11)  NULL,
    `approver` int(11)  NULL,
    `url_file` longtext NULL ,
    `create_time` DATETIME NULL,
    `id_admin` int(3) NULL,
    `status` int(3) NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'bonus_discipline_detail')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "bonus_discipline_detail` (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_bonus_discipline` int(11) NOT NULL,
    `from_time` DATETIME NULL ,
    `staff_id` int(11)  NULL,
    `department_id` longtext NULL ,
    `lever_bonus` int(11)  NULL,
    `formality` varchar(50) NULL,
    `formality_value` varchar(100) NULL,
    `description` longtext NULL ,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_workplace')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_workplace` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(200) NOT NULL,
      `workplace_address` varchar(400) NULL,
      `latitude` double,
      `longitude` double,
      `default` bit NOT NULL DEFAULT 0,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

//table setting staff contract type
if (!$CI->db->table_exists(db_prefix() . 'hr_staff_contract_type')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_staff_contract_type` (
      `id_contracttype` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name_contracttype` varchar(200) NOT NULL,
      `description` longtext NULL ,
      `duration` int(11) NULL,
      `unit` varchar(20) NULL,
      `insurance` boolean NULL,
      PRIMARY KEY (`id_contracttype`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_salary_form')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_salary_form` (
      `form_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `form_name` varchar(200) NOT NULL,
      `salary_val` decimal(15,2) NOT NULL,
      `tax` boolean NOT NULL,
      PRIMARY KEY (`form_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_allowance_type')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_allowance_type` (
      `type_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `type_name` varchar(200) NOT NULL,
      `allowance_val` decimal(15,2) NOT NULL,
      `taxable` boolean NOT NULL,
      PRIMARY KEY (`type_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_procedure_retire')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_procedure_retire` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `rel_name` TEXT DEFAULT NULL,
    `option_name` TEXT DEFAULT NULL,
    `status` int(11) NULL DEFAULT 1,
    `people_handle_id` int(11) NOT NULL,
    `procedure_retire_id` int(11) NOT NULL,

    PRIMARY KEY (`id`)

  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_procedure_retire_manage')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_procedure_retire_manage` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name_procedure_retire` TEXT NOT NULL,
      `department` varchar(250) NOT NULL,
      `datecreator` datetime NOT NULL ,

      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}


//job position table
if (!$CI->db->table_exists(db_prefix() . 'hr_job_p')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_job_p` (
      `job_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `job_name` VARCHAR(100) NULL,
      `description` TEXT NULL,
      PRIMARY KEY (`job_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}


if (!$CI->db->table_exists(db_prefix() . 'hr_job_position')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_job_position` (
      `position_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `position_name` varchar(200) NOT NULL,
      `job_position_description` TEXT NULL,
      `job_p_id` int(11) UNSIGNED NOT NULL,
      `position_code` VARCHAR(50) NULL,
      `department_id` TEXT NULL,

      PRIMARY KEY (`position_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_jp_salary_scale')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_jp_salary_scale` (
      `salary_scale_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `job_position_id` int(11) UNSIGNED NOT NULL ,
      `rel_type` VARCHAR(100) NULL COMMENT 'salary:allowance:insurance',
      `rel_id` int(11) NULL,
      `value` TEXT NULL,

      PRIMARY KEY (`salary_scale_id`)
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

if (!$CI->db->table_exists(db_prefix() . 'hr_allocation_asset')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_allocation_asset` (
      `allocation_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) UNSIGNED NOT NULL ,
      `asset_name` VARCHAR(100) NULL,
      `assets_amount` int(11) UNSIGNED NOT NULL ,
      `status_allocation` int(11) UNSIGNED  NULL DEFAULT 0 COMMENT '1: Allocated 0: Unallocated',

      PRIMARY KEY (`allocation_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_group_checklist_allocation')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_group_checklist_allocation` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `group_name` VARCHAR(100) NOT NULL,
      `meta` VARCHAR(100) NULL,
      `staffid` INT(11) NULL,

      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_checklist_allocation')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_checklist_allocation` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `name` VARCHAR(100) NOT NULL,
      `group_id` INT(11) NULL,
      `status` INT(11) NULL DEFAULT 0,

       PRIMARY KEY (`id`)
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

if (!$CI->db->table_exists(db_prefix() . 'hr_rec_transfer_records')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_rec_transfer_records` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staffid` int(11) NOT NULL,
      `firstname` varchar(100) NULL,
      `lastname` varchar(100) NULL,
      `birthday` date NULL,
      `gender` varchar(11) NULL,
      `staff_identifi` varchar(20) NULL,
      `creator` int(11) NOT NULL,

      PRIMARY KEY (`id`)
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

if (!$CI->db->table_exists(db_prefix() . 'hr_p_t_form_question_box')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_p_t_form_question_box` (
   `boxid` int(11) NOT NULL AUTO_INCREMENT,
    `boxtype` varchar(10) NOT NULL,
    `questionid` int(11) NOT NULL,

  PRIMARY KEY (`boxid`)
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

if (!$CI->db->table_exists(db_prefix() . 'hr_staff_contract')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_staff_contract` (
      `id_contract` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `contract_code` varchar(200) NOT NULL,
      `name_contract` int(11) NOT NULL,
      `staff` int(11) NOT NULL,
      `start_valid` date NULL,
      `end_valid` date NULL,
      `contract_status` varchar(100) NULL,
      `sign_day` date NULL,
      `staff_delegate` int(11) NULL,

      PRIMARY KEY (`id_contract`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('hourly_or_month' ,db_prefix() . 'hr_staff_contract')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'hr_staff_contract`
    ADD COLUMN `hourly_or_month` LONGTEXT NULL ');
}
if (!$CI->db->field_exists('hourly_or_month' ,db_prefix() . 'hr_staff_contract')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'hr_staff_contract`
    ADD COLUMN `subject` varchar(191) NULL ');
}
if (!$CI->db->field_exists('hourly_or_month' ,db_prefix() . 'hr_staff_contract')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'hr_staff_contract`
    ADD COLUMN `contract_value` decimal(15,2)	 NULL ');
}



if (!$CI->db->table_exists(db_prefix() . 'hr_staff_contract_detail')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_staff_contract_detail` (
      `contract_detail_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_contract_id` int(11) UNSIGNED NOT NULL,
      `type` text NULL,
      `rel_type` text NULL,
      `rel_value` decimal(15,2) DEFAULT '0.00',
      `since_date` date NULL,
      `contract_note` text NULL,

      PRIMARY KEY (`contract_detail_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}


//add column for tbl staff
//

if (!$CI->db->field_exists('team_manage' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
    ADD COLUMN `team_manage` int(11) DEFAULT "0" ');
}
if (!$CI->db->field_exists('staff_identifi' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
    ADD COLUMN `staff_identifi` VARCHAR(200) NULL ');
}
if (!$CI->db->field_exists('sub_department' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
    ADD COLUMN `sub_department` int(11) NULL ');
}



//Add new columns to staff table
if (!$CI->db->field_exists('admin' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
    ADD COLUMN `admin` int(11) NULL ');
}
if (!$CI->db->field_exists('two_factor_auth_enabled' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
    ADD COLUMN `two_factor_auth_enabled` int(1) NULL ');
}
if (!$CI->db->field_exists('two_factor_auth_code' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
    ADD COLUMN `two_factor_auth_code` varchar(100) NULL ');
}
if (!$CI->db->field_exists('two_factor_auth_code_requested' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
    ADD COLUMN `two_factor_auth_code_requested` datetime NULL ');
}
if (!$CI->db->field_exists('twitter' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
    ADD COLUMN `twitter` varchar(50) NULL ');
}
if (!$CI->db->field_exists('skype' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
    ADD COLUMN `skype` varchar(50) NULL ');
}

if (!$CI->db->field_exists('appointment' ,db_prefix() . 'staff')) {
  $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
  ADD COLUMN `appointment` varchar(222) NULL ');
}
//************************



if (!$CI->db->field_exists('birthday' ,db_prefix() . 'staff')) { 
  $CI->db->query('ALTER TABLE `' . db_prefix() . "staff`
  ADD COLUMN `birthday` date NULL AFTER `email_signature`,
  ADD COLUMN `birthplace` VARCHAR(200) NULL AFTER `birthday`,
  ADD COLUMN `sex` varchar(15) NULL AFTER `birthplace`,
  ADD COLUMN `marital_status` varchar(25) NULL AFTER `sex`,
  ADD COLUMN `nation` varchar(25) NULL AFTER `marital_status`,
  ADD COLUMN `religion` varchar(50) NULL AFTER `nation`,
  ADD COLUMN `identification` varchar(100) NULL AFTER `religion`,
  ADD COLUMN `days_for_identity` date NULL AFTER `identification`,
  ADD COLUMN `home_town` varchar(200) NULL AFTER `days_for_identity`,
  ADD COLUMN `resident` varchar(200) NULL AFTER `home_town`,
  ADD COLUMN `current_address` varchar(200) NULL AFTER `resident`,
  ADD COLUMN `literacy` varchar(50) NULL AFTER `current_address`,
  ADD COLUMN `orther_infor` text NULL AFTER `literacy`

;");
}


if (!$CI->db->field_exists('place_of_issue' ,db_prefix() . 'staff')) { 
  $CI->db->query('ALTER TABLE `' . db_prefix() . "staff`

    ADD COLUMN `place_of_issue` varchar(50) NULL AFTER `orther_infor`,
    ADD COLUMN `account_number` varchar(50) NULL AFTER `place_of_issue`,
    ADD COLUMN `name_account` varchar(50) NULL AFTER `account_number`,
    ADD COLUMN `issue_bank` varchar(200) NULL AFTER `name_account`,
    ADD COLUMN `Personal_tax_code` varchar(50) NULL AFTER `issue_bank`

;");
}

if (!$CI->db->field_exists('records_received' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
    ADD COLUMN `records_received` LONGTEXT NULL AFTER `issue_bank`');
}

if (!$CI->db->field_exists('status_work' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
    ADD COLUMN `status_work` VARCHAR(100) NULL');
}

if (!$CI->db->field_exists('date_update' ,db_prefix() . 'staff')) { 
  $CI->db->query('ALTER TABLE `' . db_prefix() . "staff`
    ADD COLUMN `date_update` DATE NULL AFTER `status_work`
  ;");
}

if (!$CI->db->field_exists('job_position' ,db_prefix() . 'staff')) {
   $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
  ADD COLUMN `job_position` int(11) NULL AFTER `orther_infor`,
  ADD COLUMN `workplace` int(11) NULL AFTER `job_position`');
}


//general settings
  if (hr_profile_row_options_exists('"job_position_prefix"') == 0){
      $CI->db->query('INSERT INTO `'.db_prefix().'hr_profile_option` (`option_name`,`option_val`, `auto`) VALUES ("job_position_prefix", "#JOB", "1");
    ');
  }

  if (hr_profile_row_options_exists('"job_position_number"') == 0){
      $CI->db->query('INSERT INTO `'.db_prefix().'hr_profile_option` (`option_name`,`option_val`, `auto`) VALUES ("job_position_number", "1", "1");
    ');
  }

  if (hr_profile_row_options_exists('"contract_code_prefix"') == 0){
      $CI->db->query('INSERT INTO `'.db_prefix().'hr_profile_option` (`option_name`,`option_val`, `auto`) VALUES ("contract_code_prefix", "#CONTRACT", "1");
    ');
  }

  if (hr_profile_row_options_exists('"contract_code_number"') == 0){
      $CI->db->query('INSERT INTO `'.db_prefix().'hr_profile_option` (`option_name`,`option_val`, `auto`) VALUES ("contract_code_number", "1", "1");
    ');
  }

  

if (!$CI->db->table_exists(db_prefix() . 'hr_dependent_person')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_dependent_person` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staffid` int(11) UNSIGNED  NULL,
      `dependent_name` varchar(100) NULL ,
      `relationship` varchar(100) NULL ,
      `dependent_bir` date NULL ,
      `start_month` date NULL ,
      `end_month` date NULL ,
      `dependent_iden` varchar(20) NOT NULL ,
      `reason` longtext NULL ,
      `status` int(11) UNSIGNED  NULL DEFAULT 0 ,
      `status_comment` longtext NULL,

      
      PRIMARY KEY (`id`,`dependent_iden`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_list_staff_quitting_work')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_list_staff_quitting_work` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `staffid` int(11) DEFAULT NULL,
    `staff_name` TEXT NULL,
    `department_name` TEXT NULL,
    `role_name` TEXT NULL,
    `email` TEXT NULL,
    `dateoff` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `approval` varchar(100) NULL DEFAULT NULL,

    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}


if (!$CI->db->table_exists(db_prefix() . 'hr_procedure_retire_of_staff')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_procedure_retire_of_staff` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `rel_id` int(11) DEFAULT NULL,
    `option_name` TEXT DEFAULT NULL,
    `status` int(11) NULL DEFAULT 0,
    `staffid` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_procedure_retire_of_staff_by_id')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_procedure_retire_of_staff_by_id` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `rel_name` TEXT DEFAULT NULL,
    `people_handle_id` int(11),
     PRIMARY KEY (`id`)
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


/*knowledge_base for Q&A*/

if (hr_profile_row_options_exists('"staff_code_prefix"') == 0){
      $CI->db->query('INSERT INTO `'.db_prefix().'hr_profile_option` (`option_name`,`option_val`, `auto`) VALUES ("staff_code_prefix", "EC", "1");
    ');
  }

  if (hr_profile_row_options_exists('"staff_code_number"') == 0){
      $CI->db->query('INSERT INTO `'.db_prefix().'hr_profile_option` (`option_name`,`option_val`, `auto`) VALUES ("staff_code_number", "1", "1");
    ');
  }

//Update v102: add Type of training menu
if (!$CI->db->table_exists(db_prefix() . 'hr_type_of_trainings')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_type_of_trainings` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` TEXT NULL,

    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

//Insert default data: Basic training for old customer
if (hr_profile_type_of_training_exists('"Basic training"') == 0){
  $CI->db->query('INSERT INTO `'.db_prefix().'hr_type_of_trainings` (`name`) VALUES ("Basic training");
    ');
}


//V103 add option : additional_training, show result training
if (!$CI->db->field_exists('additional_training' ,db_prefix() . 'hr_jp_interview_training')) { 
  $CI->db->query('ALTER TABLE `' . db_prefix() . "hr_jp_interview_training`
    ADD COLUMN `additional_training` VARCHAR(100) NULL DEFAULT '',
    ADD COLUMN `staff_id` TEXT NULL ,
    ADD COLUMN `time_to_start` DATE NULL ,
    ADD COLUMN `time_to_end` DATE NULL
  ;");
}

//V104: import, export staff, contract pdf
if (!$CI->db->field_exists('hash' ,db_prefix() . 'hr_staff_contract')) { 
  $CI->db->query('ALTER TABLE `' . db_prefix() . "hr_staff_contract`
    ADD COLUMN `content` LONGTEXT NULL,
    ADD COLUMN `hash` VARCHAR(32) NULL,
    ADD COLUMN `signature` VARCHAR(40) NULL,
    ADD COLUMN `signer` INT(11) NULL

  ;");
}

if (!$CI->db->table_exists(db_prefix() . 'hr_contract_template')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_contract_template` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` TEXT NULL,
    `job_position` LONGTEXT NULL,
    `content` LONGTEXT NULL,

    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('staff_signature' ,db_prefix() . 'hr_staff_contract')) { 
  $CI->db->query('ALTER TABLE `' . db_prefix() . "hr_staff_contract`
    ADD COLUMN `staff_signature` VARCHAR(40) NULL,
    ADD COLUMN `staff_sign_day` DATE NULL

  ;");
}


if (!$CI->db->table_exists(db_prefix() . 'hr_setting')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() .  'hr_setting` (
      `id` int(11) PRIMARY KEY AUTO_INCREMENT,
      `active` int(11) NOT NULL,
      `name` varchar(200) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
    $data = [
        'name' => 'sub_department',
        'active' => 0
    ];
    $CI->db->insert('hr_setting', $data);
    $insert_id = $CI->db->insert_id();
    if ($insert_id) {
        log_activity('hr_setting add [' . $data['name'] . ']');
        // return $insert_id;
    }
}


if (!$CI->db->table_exists(db_prefix() . 'hr_sub_departments')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_sub_departments` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `department_id` varchar(200) NOT NULL,
    `sub_department_name` varchar(200) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
//****OLD HR************
if (!$CI->db->table_exists(db_prefix() . 'insurances_type')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "insurances_type` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `insurance_book_id` int(11) UNSIGNED  NULL,
      `for_staff` int(11) UNSIGNED  NULL,
      `name` VARCHAR(15) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'insurance_book_nums')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "insurance_book_nums` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` VARCHAR(15) NULL,
      `company_name` VARCHAR(15) NULL,
      `start_date` date NULL,
      `end_date` date NULL,
      `file` varchar(100) NULL,
    `is_notification` int(11) NOT NULL,
    `recurring_from` int(11) NOT NULL,
    `deadline_notified` int(11) NOT NULL, 
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'staff_insurance')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "staff_insurance` (
      `insurance_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `staff_id` int(11) UNSIGNED NOT NULL,
      `insurance_book_num` varchar(100) NULL,
      `insurance_type` varchar(100) NULL,
      `health_insurance_num` varchar(100) NULL,
      `city_code` varchar(100) NULL,
      `registration_medical` varchar(100) NULL,
      `start_date` date NULL,
      `end_date` date NULL,
      `file` varchar(100) NULL,
        `is_notification` int(11) NOT NULL,
        `recurring_from` int(11) NOT NULL,
        `deadline_notified` int(11) NOT NULL, 
      PRIMARY KEY (`insurance_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'staff_insurance_history')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "staff_insurance_history` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `insurance_id` int(11) UNSIGNED NOT NULL,
      `staff_id` int(11) UNSIGNED  NULL,
      `from_month` date NULL,
      `formality` varchar(50) NULL,
      `reason` varchar(50) NULL,
      `premium_rates` varchar(100) NULL,
      `payment_company` varchar(100) NULL,
      `payment_worker` varchar(100) NULL,
      PRIMARY KEY (`id`,`insurance_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'hr_documents')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_documents` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `document_type` varchar(255) NOT NULL, 
    `document_title` varchar(255) NOT NULL, 
    `description` text NOT NULL, 
    `date_expiry` date NOT NULL, 
    `notification_email` varchar(255) NOT NULL,
    `document_file` varchar(255) NOT NULL,
    `is_notification` int(11) NOT NULL,
    `recurring_from` int(11) NOT NULL,
    `deadline_notified` int(11) NOT NULL, 
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!option_exists('document_type')) {
    $value = '[{"key":" Driving License","value":" Driving License"}]';
    add_option('document_type',$value);
}

if (!$CI->db->table_exists(db_prefix() . 'hr_official_documents')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_official_documents` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `document_type` varchar(255) NOT NULL, 
    `document_title` varchar(255) NOT NULL, 
    `document_number` varchar(255) NOT NULL, 
    `description` text NOT NULL, 
    `date_expiry` date NOT NULL, 
    `document_file` varchar(255) NOT NULL,
    `is_notification` int(11) NOT NULL,
    `notification_email` varchar(222) NOT NULL,
    `recurring_from` int(11) NOT NULL,
    `deadline_notified` int(11) NOT NULL, 
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'hr_work_experience')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_work_experience` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `company_name` varchar(200) NOT NULL,
    `post` varchar(200) NOT NULL,
    `from_date` date NOT NULL,
    `to_date` date NOT NULL,
    `description` text NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_bank_account')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_bank_account` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `account_title` varchar(255) NOT NULL, 
    `account_number` varchar(255) NOT NULL, 
    `bank_name` varchar(255) NOT NULL, 
    `bank_code` varchar(255) NOT NULL, 
    `bank_branch` varchar(255) NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'hr_qualification')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_qualification` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `school_university` varchar(255) NOT NULL, 
    `education_level` varchar(255) NOT NULL, 
    `from_date` date NOT NULL,
    `to_date` date NOT NULL,
    `skill` varchar(255) NOT NULL, 
    `education` varchar(255) NOT NULL, 
    `description` text NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_salary')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_salary` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `type` varchar(200) NOT NULL,
    `amount` bigint NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'hr_commissions')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_commissions` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `title` varchar(200) NOT NULL,
    `amount` bigint NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_other_payments')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_other_payments` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `title` varchar(200) NOT NULL,
    `amount` bigint NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_loan')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_loan` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `title` varchar(200) NOT NULL,
    `amount` bigint NOT NULL,
    `start_date` date NOT NULL,
    `end_date` date NOT NULL,
    `reason` text NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'hr_allowances')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_allowances` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `tax` int(11) NOT NULL,
    `title` varchar(200) NOT NULL,
    `amount` bigint NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_statutory_deductions')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_statutory_deductions` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `deduction_type` varchar(200) NOT NULL,
    `title` varchar(200) NOT NULL,
    `amount` bigint NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_overtime')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_overtime` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `title` varchar(200) NOT NULL,
    `num_days` int(11) NOT NULL,
    `num_hours` int(11) NOT NULL,
    `rate` bigint NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!option_exists('deduction_type')) {
    $value = '[{"key":"Social Security System","value":"Social Security System"},{"key":"Health Insurance Corporation","value":"Health Insurance Corporation"},{"key":"Home Development Mutual Fund","value":"Home Development Mutual Fund"},{"key":"Withholding Tax on Wages","value":"Withholding Tax on Wages"},{"key":"Other Statutory Deduction","value":"Other Statutory Deduction"}]';
    add_option('deduction_type',$value);
}

if (!option_exists('relation_type')) {
    $value = '[{"key":"Self","value":"Self"},{"key":"Parent","value":"Parent"},{"key":"Spouse","value":"Spouse"},{"key":"Child","value":"Child"},{"key":"Sibling","value":"Sibling"},{"key":"In Laws","value":"In Laws"}]';
    add_option('relation_type',$value);
}

if (!option_exists('education_level_type')) {
    $value = '[{"key":"High School Diploma \/ GED","value":"High School Diploma \/ GED"}]';
    add_option('education_level_type',$value);
}
if (!option_exists('skill_type')) {
    $value = '[{"key":"jQuery","value":"jQuery"}]';
    add_option('skill_type',$value);
}

if (!option_exists('education_type')) {
    $value = '[{"key":"English","value":"English"}]';
    add_option('education_type',$value);
}
if (!$CI->db->table_exists(db_prefix() . 'hr_awards')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_awards` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `award_type` varchar(200) NOT NULL,
    `date` date NOT NULL,
    `gift` varchar(200) NOT NULL,
    `cash` bigint NOT NULL,
    `description` text NOT NULL,
    `award_information` text NOT NULL,
    `award_photo` varchar(200) NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'hr_terminations')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_terminations` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `termination_type` varchar(200) NOT NULL,
    `termination_date` date NOT NULL,
    `notice_date` date NOT NULL,
    `description` text NOT NULL,
    `attachment` varchar(200) NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!$CI->db->field_exists('status', db_prefix() . 'hr_terminations')) {
    $CI->db->query("ALTER TABLE `".db_prefix() ."hr_terminations` ADD `status` varchar(200) DEFAULT 0;");
}
if (!$CI->db->table_exists(db_prefix() . 'hr_warnings')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_warnings` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `warning_type` varchar(200) NOT NULL,
    `warning_date` date NOT NULL,
    `subject` varchar(200) NOT NULL,
    `description` text NOT NULL,
    `attachment` varchar(200) NOT NULL,
    `warning_by` int(11) NOT NULL,
    `warning_to` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'hr_complaints')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_complaints` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `complaint_date` date NOT NULL,
    `description` text NOT NULL,
    `attachment` varchar(200) NOT NULL,
    `complaint_title` varchar(200) NOT NULL,
    `complaint_from` int(11) NOT NULL,
    `complaint_againts` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'hr_resignations')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_resignations` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `notice_date` date NOT NULL,
    `resignation_date` date NOT NULL,
    `resignation_reason` text NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!$CI->db->field_exists('status', db_prefix() . 'hr_resignations')) {
    $CI->db->query("ALTER TABLE `".db_prefix() ."hr_resignations` ADD `status` varchar(200) DEFAULT 0;");
}
if (!$CI->db->table_exists(db_prefix() . 'hr_designations')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_designations` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `department_id` varchar(200) NOT NULL,
    `designation_name` varchar(200) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'hr_promotions')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_promotions` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `promotion_date` date NOT NULL,
    `promotion_title` varchar(200) NOT NULL,
    `description` text NOT NULL,
    `designation` int(11) NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'hr_overtime')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_travels` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `start_date` date NOT NULL,
    `end_date` date NOT NULL,
    `expected_budget` varchar(200) NOT NULL,
    `actual_budget` varchar(200) NOT NULL,
    `purpose` varchar(200) NOT NULL,
    `place` varchar(200) NOT NULL,
    `description` text NOT NULL,
    `travel_mode_type` varchar(200) NOT NULL,
    `arrangement_type` varchar(200) NOT NULL,
    `status` varchar(200) NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}




if (!$CI->db->table_exists(db_prefix() . 'hr_extra_info')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_extra_info` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `emloyee_id` varchar(255) NOT NULL, 
  `sub_department` varchar(255) NOT NULL, 
  `designation` varchar(255) NOT NULL, 
  `gender` varchar(255) NOT NULL, 
  `marital_status` varchar(255) NOT NULL, 
  `office_sheft` varchar(255) NOT NULL, 
  `date_birth` date NOT NULL, 
  `state_province` varchar(255) NOT NULL, 
  `city` varchar(255) NOT NULL, 
  `zip_code` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL, 
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}


if (!$CI->db->table_exists(db_prefix() . 'hr_indicators')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_indicators` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `customer_experience` varchar(200) NOT NULL,
    `marketing` varchar(200) NOT NULL,
    `administration` varchar(200) NOT NULL,
    `professionalism` varchar(200) NOT NULL,
    `integrity` varchar(200) NOT NULL,
    `attendance` varchar(200) NOT NULL,
    `added_by` int(11) NOT NULL,
    `created` timestamp NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_appraisal')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_appraisal` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `customer_experience` varchar(200) NOT NULL,
    `marketing` varchar(200) NOT NULL,
    `administration` varchar(200) NOT NULL,
    `professionalism` varchar(200) NOT NULL,
    `integrity` varchar(200) NOT NULL,
    `attendance` varchar(200) NOT NULL,
    `month` varchar(200) NOT NULL,
    `remarks` text NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'type_of_leave')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "type_of_leave` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `male` enum('0','1') NOT NULL,
              `female` enum('0','1') NOT NULL,
              `muslim` enum('0','1') NOT NULL,
              `not_muslim` enum('0','1') NOT NULL,
              `citizen` enum('0','1') NOT NULL,
              `not_citizen` enum('0','1') NOT NULL,
              `name` varchar(255) NOT NULL,
              `number_of_days` int(11) NOT NULL,
              `entitlement_in_months` int(11) NOT NULL,
              `deserving_in_years` int(11) NOT NULL,
              `deserving_before_days` int(11) NOT NULL,
              `deserving_after_days` int(11) NOT NULL,
              `repeat_leave` enum('include','extend') NOT NULL,
              `notify_manager_before_deserving_days` int(11) NOT NULL,
              `notify_staff_before_deserving_days` int(11) NOT NULL,
              `is_deserving_salary` enum('0','1') NOT NULL,
              `salary_type` enum('total_salary','basic_salary') NOT NULL,
              `salary_allocation` enum('true','false') NOT NULL,
              `allow_substitute_employee` enum('0','1') NOT NULL,
              `accumulative`  varchar(200) NOT NULL,
              `code` int(11) NOT NULL,
              `datecreated` DATETIME NOT NULL,
      PRIMARY KEY (`id`)                                                      
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'type_of_leave_allocation')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . "type_of_leave_allocation` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `percent` int(11) NOT NULL DEFAULT 0,
      `days` int(11) NOT NULL DEFAULT 0,
      `type_of_leave_id` int(11) NOT NULL DEFAULT 0,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->table_exists(db_prefix() . 'timesheets_additional_timesheet')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'timesheets_additional_timesheet` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `additional_day` VARCHAR(45) NOT NULL,
    `status` VARCHAR(45) NOT NULL,
    `timekeeping_value` VARCHAR(45) NOT NULL,
    `approver` INT(11) NOT NULL,
    `creator` INT(11) NOT NULL,
    PRIMARY KEY (`id`));');
}

if (!$CI->db->table_exists(db_prefix() . 'timesheets_requisition_leave')) {
	$CI->db->query('CREATE TABLE `' . db_prefix() . "timesheets_requisition_leave` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `staff_id` int(11) NOT NULL,
        `subject` varchar(100) NULL,
        `is_after` varchar(100) NULL,
        `is_before` varchar(100) NULL,
        `start_time` DATETIME NOT NULL,
        `end_time` DATETIME NOT NULL,
        `reason` text NULL,
        `approver_id` int(11) NOT NULL,
        `followers_id` int(11) NULL,
        `rel_type` int(11) NOT NULL COMMENT '1:Leave 2:Late_early 3:Go_out 4:Go_on_bussiness',
        `status` int(11) NULL DEFAULT 0 COMMENT '0:Create 1:Approver 2:Reject',
        PRIMARY KEY (`id`,staff_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('second_name' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
          ADD COLUMN `second_name` varchar(100) NULL AFTER `firstname`');
}
if (!$CI->db->field_exists('third_name' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
          ADD COLUMN `third_name` varchar(100) NULL AFTER `second_name`');
}

if (!$CI->db->field_exists('education_level' ,db_prefix() . 'staff')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'staff`
          ADD COLUMN `education_level` varchar(100) NULL');
}


if (!option_exists('deduction_type')) {
    $value = '[{"key":"Social Security System","value":"Social Security System"},{"key":"Health Insurance Corporation","value":"Health Insurance Corporation"},{"key":"Home Development Mutual Fund","value":"Home Development Mutual Fund"},{"key":"Withholding Tax on Wages","value":"Withholding Tax on Wages"},{"key":"Other Statutory Deduction","value":"Other Statutory Deduction"}]';
    add_option('deduction_type',$value);
}

if (!option_exists('relation_type')) {
    $value = '[{"key":"Self","value":"Self"},{"key":"Parent","value":"Parent"},{"key":"Spouse","value":"Spouse"},{"key":"Child","value":"Child"},{"key":"Sibling","value":"Sibling"},{"key":"In Laws","value":"In Laws"}]';
    add_option('relation_type',$value);
}

if (!option_exists('education_level_type')) {
    $value = '[{"key":"High School Diploma \/ GED","value":"High School Diploma \/ GED"}]';
    add_option('education_level_type',$value);
}
if (!option_exists('skill_type')) {
    $value = '[{"key":"jQuery","value":"jQuery"}]';
    add_option('skill_type',$value);
}

if (!option_exists('education_type')) {
    $value = '[{"key":"English","value":"English"}]';
    add_option('education_type',$value);
}



add_option('hr_profile_hide_menu', 1, 1);

$CI->db->query("CREATE TABLE IF NOT EXISTS `tblhr_contract_renew` (
              `id` int(11) NOT NULL AUTO_INCREMENT, 
              `contract_id` int(11) DEFAULT NULL, 
              `new_start_date` date DEFAULT NULL,
              `new_end_date` date DEFAULT NULL,
              `renewed_by` int(11) NOT NULL,
              `date_renewed` datetime DEFAULT NULL,
                                    PRIMARY KEY (`id`)
              
            ) ENGINE=InnoDB DEFAULT  CHARSET=utf8 AUTO_INCREMENT=1 ;
            ");

$CI->db->query("CREATE TABLE IF NOT EXISTS `tblhr_staff_contract_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
                                      PRIMARY KEY (`id`)

) ENGINE=InnoDB DEFAULT  CHARSET=utf8 AUTO_INCREMENT=1;
            ");


$CI->db->query("CREATE TABLE IF NOT EXISTS `tblhr_staff_contract_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_id` int(11) NOT NULL,
  `content` varchar(255) DEFAULT NULL,
                                        PRIMARY KEY (`id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
");


