<?php



if (!$CI->db->table_exists(db_prefix() . 'hr_holiday')) {           
    $CI->db->query('CREATE TABLE `' . db_prefix() .  'hr_holiday` (
      `id` int(11) PRIMARY KEY AUTO_INCREMENT,
      `event_name` varchar(200) NOT NULL,
      `description` text NOT NULL,
      `start_date` date NOT NULL,
      `end_date` date NOT NULL,
      `status` varchar(200) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
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
        log_activity('hr_setting add [' . $data['sub_department'] . ']');
        return $insert_id;
    }
}

if (!$CI->db->table_exists(db_prefix() . 'hr_leaves')) {           
    $CI->db->query('CREATE TABLE `' . db_prefix() .  'hr_leaves` (
      `id` int(11) PRIMARY KEY AUTO_INCREMENT,
      `leave_type` varchar(200) NOT NULL,
      `leave_reason` text NOT NULL,
      `remarks` text NOT NULL,
      `start_date` date NOT NULL,
      `end_date` date NOT NULL,
      `half_day` int(11) NOT NULL,
      `status` varchar(200) NOT NULL,
      `attachment` varchar(200) NOT NULL,
      `created` timestamp NOT NULL,
      `staff_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_leave_type')) {           
    $CI->db->query('CREATE TABLE `' . db_prefix() .  'hr_leave_type` (
      `id` int(11) PRIMARY KEY AUTO_INCREMENT,
      `name` varchar(200) NOT NULL,
      `days` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_staffs_leaves')) {           
    $CI->db->query('CREATE TABLE `' . db_prefix() .  'hr_staffs_leaves` (
      `id` int(11) PRIMARY KEY AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `leave_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_staff_leaves')) {           
    $CI->db->query('CREATE TABLE `' . db_prefix() .  'hr_staff_leaves` (
      `id` int(11) PRIMARY KEY AUTO_INCREMENT,
      `staff_id` int(11) NOT NULL,
      `leave_id` int(11) NOT NULL,
      `leaveid` int(11) NOT NULL,
      `days` int(11) NOT NULL,
      `created` int(11) NOT NULL
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

if (!$CI->db->table_exists(db_prefix() . 'hr_indicators')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_indicators` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `designation_id` int(11) NOT NULL,
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

if (!$CI->db->table_exists(db_prefix() . 'hr_overtime_request')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_overtime_request` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `date` date NOT NULL,
    `in_time` varchar(200) NOT NULL,
    `out_time` varchar(200) NOT NULL,
    `reason` text NOT NULL,
    `status` varchar(200) NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_office_shift')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_office_shift` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `shift_name` varchar(200) NOT NULL,
    `saturday_in` time default NULL,
    `saturday_out` time default NULL,
    `sunday_in` time default NULL,
    `sunday_out` time default NULL,
    `monday_in` time default NULL,
    `monday_out` time default NULL,
    `tuesday_in` time default NULL,
    `tuesday_out` time default NULL,
    `wednesday_in` time default NULL,
    `wednesday_out` time default NULL,
    `thursday_in` time default NULL,
    `thursday_out` time default NULL,
    `friday_in` time default NULL,
    `friday_out` time default NULL,
    `default` int(11) NOT NULL,
    `created` timestamp NOT NULL
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
    `created` timestamp NOT NULL,
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
    `is_notification` int(11) NOT NULL,
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

if (!$CI->db->table_exists(db_prefix() . 'hr_transfers')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_transfers` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `transfer_date` date NOT NULL,
    `description` text NOT NULL,
    `to_department` int(11) NOT NULL,
    `to_sub_department` int(11) NOT NULL,
    `status` varchar(200) NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_travels')) {
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

if (!$CI->db->table_exists(db_prefix() . 'hr_resignations')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'hr_resignations` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `notice_date` date NOT NULL,
    `resignation_date` date NOT NULL,
    `resignation_reason` text NOT NULL,
    `staff_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_attendance')) {           
    $CI->db->query('CREATE TABLE `' . db_prefix() .  'hr_attendance` (
      `id` int(11) PRIMARY KEY AUTO_INCREMENT,
      `time_in` time NOT NULL,
      `time_out` time NOT NULL,
      `created` date NOT NULL,
      `staff_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'hr_attendances')) {           
    $CI->db->query('CREATE TABLE `' . db_prefix() .  'hr_attendances` (
      `id` int(11) PRIMARY KEY AUTO_INCREMENT,
      `time` time NOT NULL,
      `type` varchar(200) NOT NULL,
      `created` date NOT NULL,
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
if (!option_exists('organizational_competencies_type')) {
    $value = '[{"key":"Beginner","value":"Beginner"},{"key":"Intermediate","value":"Intermediate"},{"key":"Advanced","value":"Advanced"}]';
    add_option('organizational_competencies_type',$value);
}
if (!option_exists('technical_competencies_type')) {
    $value = '[{"key":"Beginner","value":"Beginner"},{"key":"Intermediate","value":"Intermediate"},{"key":"Advanced","value":"Advanced"},{"key":"Expert / Leader","value":"Expert / Leader"}]';
    add_option('technical_competencies_type',$value);
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

// branch

if (!$CI->db->table_exists(db_prefix() . 'branches')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'branches` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `title_en` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
     `title_ar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `legal_traning_name` varchar(255) NOT NULL, 
    `registraion_number` varchar(255) NOT NULL,
    `website` varchar(255) NOT NULL,
    `phone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `branch_email` varchar(255) NOT NULL, 
    `city_id` int(11) NOT NULL, 
    `country_id` int(11) NOT NULL,
    `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `state_province` varchar(255) NOT NULL, 
    `zip_code` varchar(255) NOT NULL,
    `username` varchar(255) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');

  $data = [
    'title_en' => 'General branch', 
    'title_ar' => 'الفرع العام', 
    'city_id' => '338', 
    'country_id' => '217', 
    'registraion_number' => '1'
  ];
  $CI->db->insert('tblbranches', $data);
  $insert_id = $CI->db->insert_id();
  if ($insert_id) {
      log_activity('New Branches Added [' . $data['title_en'] . ']');
      return $insert_id;
  }
}


if (!$CI->db->table_exists(db_prefix() . 'branches_services')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'branches_services` (                   
     `id` int(11) PRIMARY KEY AUTO_INCREMENT,
     `branch_id` int(11) NOT NULL,
     `rel_type` varchar(25) NOT NULL,
     `rel_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');


    $staffs = $CI->db->get(db_prefix() . 'staff')->result_array();
    foreach ($staffs as $staff){
      $data = [
        'branch_id' => 1, 
        'rel_type' => 'staff', 
        'rel_id' => $staff['staffid']
      ];
      $CI->db->insert('tblbranches_services', $data);
      $insert_id = $CI->db->insert_id();

      if ($insert_id) {
          log_activity('Add Branch ['. $data['branch_id'] .'] To '.$data['rel_type'].' [' . $data['rel_id'] . ']');
      }
    }

    $departments = $CI->db->get(db_prefix() . 'departments')->result_array();
    foreach ($departments as $department){
      $data = [
        'branch_id' => 1, 
        'rel_type' => 'departments', 
        'rel_id' => $department['departmentid']
      ];
      $CI->db->insert('tblbranches_services', $data);
      $insert_id = $CI->db->insert_id();

      if ($insert_id) {
          log_activity('Add Branch ['. $data['branch_id'] .'] To '.$data['rel_type'].' [' . $data['rel_id'] . ']');
      }
    }

    
}
