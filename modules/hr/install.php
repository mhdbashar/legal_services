<?php

if (!$CI->db->table_exists(db_prefix() . 'hr_holiday')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_holiday` (
    `holiday_id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `event_name` varchar(200) NOT NULL,
    `description` text NOT NULL,
    `start_date` date NOT NULL,
    `end_date` date NOT NULL,
    `location` varchar(200) DEFAULT NULL,
    `color` varchar(200) DEFAULT NULL
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
/*
{"staff_id":"3","type":"1","payment_date":"2019-5-1","amount":"161612","allowances":"80900","commissions":"12","loan":"0","overtime":"600","deductions":"200","other_payment":"300","net_salary":"80000"}
*/
if (!$CI->db->table_exists(db_prefix() . 'hr_payments')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_payments` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `type` int(11) NOT NULL,
    `other_payment` bigint NOT NULL,
    `overtime` bigint NOT NULL,
    `commissions` bigint NOT NULL,
    `deductions` bigint NOT NULL,
    `allowances` bigint NOT NULL,
    `loan` bigint NOT NULL,
    `amount` bigint NOT NULL,
    `net_salary` bigint NOT NULL,
    `payment_date` date NOT NULL,
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

if (!$CI->db->table_exists(db_prefix() . 'hr_immigration')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_immigration` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `document_type` varchar(255) NOT NULL, 
    `document_number` varchar(255) NOT NULL, 
    `issue_date` date NOT NULL, 
    `date_expiry` date NOT NULL, 
    `document_file` varchar(255) NOT NULL,
    `eligible_review_date` date NOT NULL, 
    `country` varchar(255) NOT NULL,
    `recurring_from` int(11) NOT NULL,
    `deadline_notified` int(11) NOT NULL, 
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}
//qualification

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

//social_networking

if (!$CI->db->table_exists(db_prefix() . 'hr_social_networking')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_social_networking` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `twitter` varchar(255) NOT NULL, 
    `blogger` varchar(255) NOT NULL, 
    `google_plus` varchar(255) NOT NULL, 
    `instagram` varchar(255) NOT NULL, 
    `pinterest` varchar(255) NOT NULL, 
    `youtube` varchar(255) NOT NULL, 
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
// Branches
if (!$CI->db->table_exists(db_prefix() . 'branches')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'branches` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `title_en` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
     `title_ar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `branch_type` varchar(255) NOT NULL,
    `legal_traning_name` varchar(255) NOT NULL, 
    `registraion_number` varchar(255) NOT NULL,
    `phone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
    `email` varchar(255) NOT NULL, 
    `city_id` int(11) NOT NULL, 
    `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `state_province` varchar(255) NOT NULL, 
    `zip_code` varchar(255) NOT NULL,
    `username` varchar(255) NOT NULL, 
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

if (!$CI->db->table_exists(db_prefix() . 'hr_designations')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_designations` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `department_id` varchar(200) NOT NULL,
    `designation_name` varchar(200) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_sub_departments')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_sub_departments` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `department_id` varchar(200) NOT NULL,
    `sub_department_name` varchar(200) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
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
    `recurring_from` int(11) NOT NULL,
    `deadline_notified` int(11) NOT NULL, 
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!option_exists('deduction_type')) {
    $value = '[{"key":"Social Security System","value":"Social Security System"},{"key":"Health Insurance Corporation","value":"Health Insurance Corporation"},{"key":"Home Development Mutual Fund","value":"Home Development Mutual Fund"},{"key":"Withholding Tax on Wages","value":"Withholding Tax on Wages"},{"key":"Other Statutory Deduction","value":"Other Statutory Deduction"}]';
    add_option('deduction_type',$value);
}

if (!option_exists('document_type')) {
    $value = '[{"key":" Driving License","value":" Driving License"}]';
    add_option('document_type',$value);
}

if (!option_exists('branch_type')) {
    $value = '[{"key":" Corporation","value":" Corporation"},{"key":" Exempt Organization","value":" Exempt Organization"},{"key":" Partnership","value":" Partnership"},{"key":" Private Foundation","value":" Private Foundation"},{"key":" Limited Liability Company","value":" Limited Liability Company"}]';
    add_option('branch_type',$value);
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

if (!option_exists('hr_document_reminder_notification_before')) {
    $value = '1';
    add_option('hr_document_reminder_notification_before',$value);
}