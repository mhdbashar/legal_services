<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * The file is responsible for handing the chat installation
 */
$CI = &get_instance();

add_option('babil_multi_theme_clients', 1);

if (!$CI->db->table_exists(db_prefix() . '_multi_theme')) {

	$CI->db->query('CREATE TABLE `' . db_prefix() . '_multi_theme` (

		`id` int(11) NOT NULL AUTO_INCREMENT,

		`theme_css` varchar(45) DEFAULT NULL,

		`added_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

		PRIMARY KEY (id)

	) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');


	$color_data = array(
		array(
			'theme_css' => null
		),
	);
	$CI->db->insert_batch(db_prefix() . '_multi_theme', $color_data);

}

