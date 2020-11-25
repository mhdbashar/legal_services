<?php

defined('BASEPATH') or exit('No direct script access allowed');

$project_type_feild = $CI->db->query("SHOW COLUMNS FROM `" . db_prefix() . "projects` LIKE 'project_type' ");
if($project_type_feild->num_rows()==0) {
   $CI->db->query('ALTER TABLE `' . db_prefix() . 'projects` ADD `project_type` INT(2) NOT NULL DEFAULT 0 AFTER `addedfrom`;');
}


if (!$CI->db->table_exists(db_prefix() . 'my_projects_meta')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'my_projects_meta` (
  `id` int(12) NOT NULL,
  `project_id` int(12) NOT NULL DEFAULT 0,
  `meta_key` varchar(100) NOT NULL DEFAULT  "",
  `meta_value` varchar(255) NOT NULL DEFAULT  ""
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

    $CI->db->query('ALTER TABLE `' . db_prefix() . 'my_projects_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);');

    $CI->db->query('ALTER TABLE `' . db_prefix() . 'my_projects_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1');
}


if (!$CI->db->table_exists(db_prefix() . 'my_projects_contacts')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'my_projects_contacts` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `contact_type` int(2) NOT NULL DEFAULT 0,
  `contact_name` varchar(50) NOT NULL DEFAULT "",
  `contact_address` varchar(250) NOT NULL DEFAULT "",
  `contact_email` varchar(50) NOT NULL DEFAULT "",
  `contact_phone` varchar(50) NOT NULL DEFAULT ""
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

    $CI->db->query('ALTER TABLE `' . db_prefix() . 'my_projects_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);');

    $CI->db->query('ALTER TABLE `' . db_prefix() . 'my_projects_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1');
}



if (!$CI->db->table_exists(db_prefix() . 'my_projects_statuses')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'my_projects_statuses` (
  `id` int(11) NOT NULL,
  `status_name` varchar(100) NOT NULL DEFAULT ""
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

    $CI->db->query('ALTER TABLE `' . db_prefix() . 'my_projects_statuses`
  ADD PRIMARY KEY (`id`)');

    $CI->db->query('ALTER TABLE `' . db_prefix() . 'my_projects_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1');

}



if (!$CI->db->table_exists(db_prefix() . 'my_project_invoicepaymentrecords')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'my_project_invoicepaymentrecords` (
  `id` int(11) NOT NULL,
  `invoiceid` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `paymentmode` varchar(40) DEFAULT NULL,
  `paymentmethod` varchar(191) DEFAULT NULL,
  `date` date NOT NULL,
  `daterecorded` datetime NOT NULL,
  `note` text NOT NULL,
  `transactionid` mediumtext
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

    $CI->db->query('ALTER TABLE `' . db_prefix() . 'my_project_invoicepaymentrecords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoiceid` (`invoiceid`),
  ADD KEY `paymentmethod` (`paymentmethod`);');

    $CI->db->query('ALTER TABLE `' . db_prefix() . 'my_project_invoicepaymentrecords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');

}


if (!$CI->db->table_exists(db_prefix() . 'my_project_invoices')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'my_project_invoices` (
  `id` int(11) NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT 0,
  `datesend` datetime DEFAULT NULL,
  `clientid` int(11) NOT NULL,
  `deleted_customer_name` varchar(100) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `number_format` int(11) NOT NULL DEFAULT 0,
  `datecreated` datetime NOT NULL,
  `date` date NOT NULL,
  `duedate` date DEFAULT NULL,
  `currency` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `total_tax` decimal(15,2) NOT NULL DEFAULT "0.00",
  `total` decimal(15,2) NOT NULL,
  `adjustment` decimal(15,2) DEFAULT NULL,
  `addedfrom` int(11) DEFAULT NULL,
  `hash` varchar(32) NOT NULL,
  `status` int(11) DEFAULT "1",
  `clientnote` text,
  `adminnote` text,
  `last_overdue_reminder` date DEFAULT NULL,
  `cancel_overdue_reminders` int(11) NOT NULL DEFAULT 0,
  `allowed_payment_modes` mediumtext,
  `token` mediumtext,
  `discount_percent` decimal(15,2) DEFAULT "0.00",
  `discount_total` decimal(15,2) DEFAULT "0.00",
  `discount_type` varchar(30) NOT NULL,
  `recurring` int(11) NOT NULL DEFAULT 0,
  `recurring_type` varchar(10) DEFAULT NULL,
  `custom_recurring` tinyint(1) NOT NULL DEFAULT 0,
  `cycles` int(11) NOT NULL DEFAULT 0,
  `total_cycles` int(11) NOT NULL DEFAULT 0,
  `is_recurring_from` int(11) DEFAULT NULL,
  `last_recurring_date` date DEFAULT NULL,
  `terms` text,
  `sale_agent` int(11) NOT NULL DEFAULT 0,
  `billing_street` varchar(200) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_zip` varchar(100) DEFAULT NULL,
  `billing_country` int(11) DEFAULT NULL,
  `shipping_street` varchar(200) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_state` varchar(100) DEFAULT NULL,
  `shipping_zip` varchar(100) DEFAULT NULL,
  `shipping_country` int(11) DEFAULT NULL,
  `include_shipping` tinyint(1) NOT NULL,
  `show_shipping_on_invoice` tinyint(1) NOT NULL DEFAULT 1,
  `show_quantity_as` int(11) NOT NULL DEFAULT 1,
  `project_id` int(11) DEFAULT 0,
  `rel_sid` int(11) DEFAULT NULL,
  `rel_stype` varchar(20) DEFAULT NULL,
  `subscription_id` int(11) NOT NULL DEFAULT 0
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;');


  $CI->db->query('ALTER TABLE `' . db_prefix() . 'my_project_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency` (`currency`),
  ADD KEY `clientid` (`clientid`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `sale_agent` (`sale_agent`),
  ADD KEY `total` (`total`),
  ADD KEY `rel_stype` (`rel_stype`),
  ADD KEY `rel_sid` (`rel_sid`);');

  $CI->db->query('ALTER TABLE `' . db_prefix() . 'my_project_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');

}

$dispute_services = $CI->db->query("SELECT * FROM ".db_prefix()."my_basic_services WHERE name = 'قضايا مالية'");
if($dispute_services->num_rows() == 0) {
    $date = date('Y-m-d H:i:s');
    $name = 'قضايا مالية';
    $slug = slug_it($name, ['separator' => '_']);
    $CI->db->query("INSERT INTO " . db_prefix() . "my_basic_services (name, slug, prefix, show_on_sidebar, is_module, datecreated) VALUES ('$name', '$slug', 'Dispute', 0, 1, '$date')");
}