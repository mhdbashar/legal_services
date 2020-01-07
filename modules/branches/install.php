<?php
/**
 * Created by PhpStorm.
 * User: Ahmad Zaher Khrezaty
 * Date: 6/4/2019
 * Time: 2:11 PM
 */
defined('BASEPATH') or exit('No direct script access allowed');


// init db
$CI = &get_instance();
// create branch table
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

    $clients = $CI->db->get(db_prefix() . 'clients')->result_array();
    foreach ($clients as $client){
      if($client['client_type'] == 0){
        $data = [
          'branch_id' => 1, 
          'rel_type' => 'clients', 
          'rel_id' => $client['userid']
        ];
        $CI->db->insert('tblbranches_services', $data);
        $insert_id = $CI->db->insert_id();

        if ($insert_id) {
            log_activity('Add Branch ['. $data['branch_id'] .'] To '.$data['rel_type'].' [' . $data['rel_id'] . ']');
        }
      }elseif($client['client_type'] == 1){
        $data = [
          'branch_id' => 1, 
          'rel_type' => 'opponent', 
          'rel_id' => $client['userid']
        ];
        $CI->db->insert('tblbranches_services', $data);
        $insert_id = $CI->db->insert_id();

        if ($insert_id) {
            log_activity('Add Branch ['. $data['branch_id'] .'] To '.$data['rel_type'].' [' . $data['rel_id'] . ']');
        }
      }
    }
    
}
// Add branch_id column to department table
if (!$CI->db->field_exists('branch_id', db_prefix().'departments')){
    $CI->db->query("ALTER TABLE `" . db_prefix() . "departments` ADD `branch_id` INT(11) NOT NULL DEFAULT '0' AFTER `hidefromclient`; ");
}


// Add branch_id column  to client table
if (!$CI->db->field_exists('branch_id', db_prefix().'clients')){
    $CI->db->query("ALTER TABLE `" . db_prefix() . "clients` ADD `branch_id` INT(11) NOT NULL DEFAULT '0' AFTER `individual`;  ");
}

// Add branch_id column to project table
if (!$CI->db->field_exists('branch_id', db_prefix().'projects')) {
    $CI->db->query("ALTER TABLE `" . db_prefix() . "projects` ADD `branch_id` INT NOT NULL DEFAULT '0' AFTER `addedfrom`; ");
}

if (!$CI->db->field_exists('branch_id', db_prefix().'my_other_services')) {
    $CI->db->query("ALTER TABLE `".db_prefix()."my_other_services` ADD `branch_id` INT NOT NULL DEFAULT '0' AFTER `addedfrom`; ");
}

if (!$CI->db->field_exists('branch_id', db_prefix().'my_cases')) {
    $CI->db->query("ALTER TABLE `".db_prefix()."my_cases` ADD `branch_id` INT NOT NULL DEFAULT '0' AFTER `addedfrom`; ");
}

