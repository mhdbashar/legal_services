<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_272 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        add_option('wathq_api_key', 'eaQFFTW5oOLH5a908nkCcK78Z1PQ1FAx');

        if (!$this->db->field_exists('description', 'procurations')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'procurations` ADD `description` TEXT NULL;');
        }

        if (!$this->db->field_exists('principalId', 'procurations')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'procurations` ADD `principalId` TEXT NULL;');
        }

        if (!$this->db->field_exists('agentId', 'procurations')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'procurations` ADD `agentId` TEXT NULL;');
        }

    }
}
