<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_513 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        if ($this->db->field_exists('fieldto', db_prefix() . 'customfieldsvalues')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'customfieldsvalues` MODIFY fieldto VARCHAR(30) DEFAULT NULL');
        }
    }
}
