<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_271 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        add_option('office_name_in_center', '1');


        if (!$this->db->table_exists(db_prefix() . 'iservice_settings')) { 
            $this->db->query('CREATE TABLE `' . db_prefix() .  'iservice_settings` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `oservice_id` int(11) NOT NULL,
              `name` varchar(100) NOT NULL,
              `value` text DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'keycode')) { 
            $this->db->query('CREATE TABLE `' . db_prefix() .  'keycode` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `keycode` varchar(1500) NOT NULL,
              `office_name_in_center` varchar(500) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'iservice_files')) { 
            $this->db->query('CREATE TABLE `' . db_prefix() .  'iservice_files` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `file_name` varchar(191) NOT NULL,
              `subject` varchar(191) DEFAULT NULL,
              `description` text,
              `filetype` varchar(50) DEFAULT NULL,
              `dateadded` datetime NOT NULL,
              `last_activity` datetime DEFAULT NULL,
              `iservice_id` int(11) NOT NULL,
              `visible_to_customer` tinyint(1) DEFAULT "0",
              `staffid` int(11) NOT NULL,
              `contact_id` int(11) NOT NULL DEFAULT "0",
              `external` varchar(40) DEFAULT NULL,
              `external_link` text,
              `thumbnail_link` text,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }


        if (!$this->db->table_exists(db_prefix() . 'my_imported_services')) {           
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_imported_services` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `service_id` int(11) NOT NULL,
              `code` varchar(255) NOT NULL,
              `numbering` int(11) DEFAULT NULL,
              `name` varchar(191) NOT NULL,
              `clientid` int(11) NOT NULL,
              `cat_id` int(11) NOT NULL,
              `subcat_id` int(11) NOT NULL,
              `service_session_link` int(11) NOT NULL DEFAULT "0",
              `billing_type` int(11) NOT NULL,
              `status` int(11) NOT NULL,
              `project_rate_per_hour` int(11) NOT NULL,
              `project_cost` decimal(15,2) DEFAULT NULL,
              `start_date` date NOT NULL,
              `project_created` date NOT NULL,
              `deadline` date DEFAULT NULL,
              `date_finished` date DEFAULT NULL,
              `description` text NOT NULL,
              `country` varchar(255) NOT NULL,
              `city` varchar(255) NOT NULL,
              `contract` int(11) NOT NULL,
              `estimated_hours` decimal(15,2) DEFAULT NULL,
              `progress` int(11) DEFAULT "0",
              `progress_from_tasks` int(11) NOT NULL DEFAULT "1",
              `addedfrom` int(11) NOT NULL,
              `branch_id` int(11) NOT NULL DEFAULT "0",
              `deleted` int(11) NOT NULL DEFAULT "0",
              `imported` int(11) NOT NULL,
              `company_staff_id` int(11) NOT NULL,
              `company_url` varchar(255) NOT NULL,
              `exported_service_id` int(11) NOT NULL,
              `exported_rel_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1;');
        }

    }
}
