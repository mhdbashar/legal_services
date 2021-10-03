<?php
defined('BASEPATH') or exit('No direct script access allowed');
if(!$CI->db->table_exists(db_prefix() . 'my_googlesheet_credential')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "my_googlesheet_credential` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`access_token` varchar(255) NOT NULL DEFAULT '',
	`expires_in` int(11) NOT NULL DEFAULT '0',
	`refresh_token` varchar(255) NOT NULL DEFAULT '',
	`scope` varchar(100) NOT NULL DEFAULT '',
	`token_type` varchar(50) NOT NULL DEFAULT '',
	`created` mediumint(9) NOT NULL DEFAULT '0',
	`staff_id` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'my_googlesheet_credential` AUTO_INCREMENT=200');
}
if(!$CI->db->table_exists(db_prefix() . 'my_googlesheets')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "my_googlesheets` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`sheet_id` varchar(255) NOT NULL DEFAULT '',
	`sheet_path` varchar(255) NOT NULL DEFAULT '',
	`staff_id` int(11) NOT NULL DEFAULT '0',
	`sheet_title` varchar(255) NOT NULL DEFAULT '',
	`rel_type` varchar(100) NOT NULL DEFAULT '',
	`rel_id` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'my_googlesheets` AUTO_INCREMENT=200');
}
