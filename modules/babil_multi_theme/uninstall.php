<?php

defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

// delete option from here if any
delete_option('babil_multi_theme_clients', 1);

$CI->db->query('DROP TABLE `' . db_prefix() . '_multi_theme`');
