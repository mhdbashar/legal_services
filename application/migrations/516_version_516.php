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
        if (!$this->db->field_exists('billing_other_number', db_prefix() . 'clients')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'clients` ADD `billing_other_number` varchar(255) DEFAULT NULL');
        }


        // contacts

        if (!$this->db->field_exists('id_number', db_prefix() . 'contacts')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'contacts` ADD `id_number` varchar(255) DEFAULT NULL');
        }

        // client info
        update_option('customer_info_format', '{company_name} اسم الشركة : <br />
{building_number} رقم المبنى : <br />
{street_name} اسم اشارع:<br />
{district_name}  الحي: <br />
{city}  المدينة: <br />
{country_name} البلد: <br />
{zip_code} الرمز البريدي:<br />
{additional_number} الرقم الاضافي للعنوان: <br />
{vat_number} رقم تسجيل ضريبة القيمة المضافة:<br />
{other_number} معرف اّخر:');

        update_option('company_info_format', '{company_name} اسم الشركة : <br />
{building_number} رقم المبنى : <br />
{street_name} اسم اشارع:<br />
{district_name}  الحي: <br />
{city}  المدينة: <br />
{country} البلد: <br />
{zip_code} الرمز البريدي:<br />
{additional_number} الرقم الاضافي للعنوان: <br />
{vat_number} رقم تسجيل ضريبة القيمة المضافة:<br />
{other_number} معرف اّخر:');

        // company info
        add_option('invoice_company_commercial_register', '');
        add_option('district_name', '');
        add_option('building_number', '');
        add_option('street_name', '');
        add_option('additional_number', '');
        add_option('unit_number', '');
        add_option('other_number', '');


    }
}