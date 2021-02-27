<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_505 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        $CI = &get_instance();

        // Add new table tblclients
        if (!$this->db->table_exists(db_prefix() . 'clients')) {
            $this->db->query('CREATE TABLE `' . db_prefix() .  'clients` (
              `userid` int(11) NOT NULL,
              `company` varchar(191) DEFAULT NULL,
              `vat` varchar(50) DEFAULT NULL,
              `phonenumber` varchar(30) DEFAULT NULL,
              `country` int(11) NOT NULL DEFAULT "0",
              `city` varchar(100) DEFAULT NULL,
              `zip` varchar(15) DEFAULT NULL,
              `state` varchar(50) DEFAULT NULL,
              `address` varchar(191) DEFAULT NULL,
              `website` varchar(150) DEFAULT NULL,
              `datecreated` datetime NOT NULL,
              `active` int(11) NOT NULL DEFAULT "1",
              `leadid` int(11) DEFAULT NULL,
              `billing_street` varchar(200) DEFAULT NULL,
              `billing_city` varchar(100) DEFAULT NULL,
              `billing_state` varchar(100) DEFAULT NULL,
              `billing_zip` varchar(100) DEFAULT NULL,
              `billing_country` int(11) DEFAULT "0",
              `shipping_street` varchar(200) DEFAULT NULL,
              `shipping_city` varchar(100) DEFAULT NULL,
              `shipping_state` varchar(100) DEFAULT NULL,
              `shipping_zip` varchar(100) DEFAULT NULL,
              `shipping_country` int(11) DEFAULT "0",
              `longitude` varchar(191) DEFAULT NULL,
              `latitude` varchar(191) DEFAULT NULL,
              `default_language` varchar(40) DEFAULT NULL,
              `default_currency` int(11) NOT NULL DEFAULT "0",
              `show_primary_contact` int(11) NOT NULL DEFAULT "0",
              `stripe_id` varchar(40) DEFAULT NULL,
              `registration_confirmed` int(11) NOT NULL DEFAULT "1",
              `addedfrom` int(11) NOT NULL DEFAULT "0",
              `individual` tinyint(4) NOT NULL DEFAULT "1",
              `branch_id` int(11) NOT NULL DEFAULT "0",
              `client_type` int(11) NOT NULL DEFAULT "0"
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');

            $this->db->query("ALTER TABLE `".db_prefix()."my_judicialdept`
                ADD PRIMARY KEY (`userid`),
                ADD KEY `country` (`country`),
                ADD KEY `leadid` (`leadid`),
                ADD KEY `company` (`company`),
                ADD KEY `active` (`active`);");
        }

    }
}
