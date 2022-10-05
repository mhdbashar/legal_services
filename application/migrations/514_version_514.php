<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_514 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
              if ($this->db->field_exists('file', db_prefix() . 'procurations')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'procurations` MODIFY `file` bigint DEFAULT NULL');
        }
        if (!$this->db->field_exists('file', db_prefix() . 'procurations')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'procurations` ADD `file` varchar(255) NULL DEFAULT NULL');
        }


    }
}
