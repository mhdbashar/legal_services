<?php


add_option('receive_sms_device', 1);
add_option('receive_sms_token', '');
add_option('sms_senders', '[""]');

$CI = &get_instance();


if (!$CI->db->table_exists(db_prefix() . 'saved_sms')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() .  'saved_sms` (
      `id` int(11) PRIMARY KEY AUTO_INCREMENT,
      `sender` varchar(200) NOT NULL,
      `msg` varchar(200) NOT NULL,
      `created_at` datetime NOT NULL,
      `staff_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}