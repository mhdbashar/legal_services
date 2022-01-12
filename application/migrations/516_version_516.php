<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_516 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {

        // clients fields
        if (!$this->db->field_exists('district_name', db_prefix() . 'clients')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'clients` ADD `district_name` varchar(255) DEFAULT NULL');
        }
        if (!$this->db->field_exists('building_number', db_prefix() . 'clients')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'clients` ADD `building_number` varchar(255) DEFAULT NULL');
        }
        if (!$this->db->field_exists('street_name', db_prefix() . 'clients')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'clients` ADD `street_name` varchar(255) DEFAULT NULL');
        }
        if (!$this->db->field_exists('additional_number', db_prefix() . 'clients')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'clients` ADD `additional_number` varchar(255) DEFAULT NULL');
        }
        if (!$this->db->field_exists('unit_number', db_prefix() . 'clients')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'clients` ADD `unit_number` varchar(255) DEFAULT NULL');
        }
        if (!$this->db->field_exists('id_number', db_prefix() . 'clients')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'clients` ADD `id_number` varchar(255) DEFAULT NULL');
        }

        // clients billing fields
        if (!$this->db->field_exists('billing_district_name', db_prefix() . 'clients')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'clients` ADD `billing_district_name` varchar(255) DEFAULT NULL');
        }
        if (!$this->db->field_exists('billing_building_number', db_prefix() . 'clients')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'clients` ADD `billing_building_number` varchar(255) DEFAULT NULL');
        }
        if (!$this->db->field_exists('billing_street_name', db_prefix() . 'clients')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'clients` ADD `billing_street_name` varchar(255) DEFAULT NULL');
        }
        if (!$this->db->field_exists('billing_additional_number', db_prefix() . 'clients')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'clients` ADD `billing_additional_number` varchar(255) DEFAULT NULL');
        }
        if (!$this->db->field_exists('billing_unit_number', db_prefix() . 'clients')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'clients` ADD `billing_unit_number` varchar(255) DEFAULT NULL');
        }
    }
}
