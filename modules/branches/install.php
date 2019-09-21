<?php
/**
 * Created by PhpStorm.
 * User: Eng ANAS MATAR
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
     `country_id` int(11) NOT NULL,
     `city_id` int(11) NOT NULL,
     `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
     `phone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'branches_services')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'branches_services` (                   
     `id` int(11) PRIMARY KEY AUTO_INCREMENT,
     `branch_id` int(11) NOT NULL,
     `rel_type` varchar(25) NOT NULL,
     `rel_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
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

