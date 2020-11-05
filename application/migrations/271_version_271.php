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

        if (!$this->db->table_exists(db_prefix() . 'my_link_services')) { 
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_link_services` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `rel_id` int(11) NOT NULL,
              `service_id` int(11) NOT NULL,
              `to_rel_id` int(11) NOT NULL,
              `to_service_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'procuration_cases')) { 
            $this->db->query('CREATE TABLE `' . db_prefix() .  'procuration_cases` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `procuration` int(11) NOT NULL,
              `_case` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'procurations')) { 
            $this->db->query('CREATE TABLE `' . db_prefix() .  'procurations` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `NO` varchar(255) NOT NULL,
              `start_date` date NOT NULL,
              `end_date` date NOT NULL,
              `come_from` varchar(255) NOT NULL,
              `folder_no` varchar(255) NOT NULL,
              `file_doc` varchar(255) NOT NULL,
              `recurring_from` int(11) NOT NULL,
              `type` int(11) NOT NULL,
              `status` int(11) NOT NULL,
              `client` int(11) NOT NULL,
              `not_visible_to_client` tinyint(1) NOT NULL DEFAULT 0,
              `addedfrom` int(11) NOT NULL,
              `case_id` int(11) DEFAULT NULL,
              `deadline_notified` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'my_procurationtype')) { 
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_procurationtype` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `procurationtype` varchar(100) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

        if (!$this->db->table_exists(db_prefix() . 'my_procurationstate')) { 
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_procurationstate` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `procurationstate` varchar(100) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

    }
}
