<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_512 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        add_option('invoice_prefix_changed', false);
        add_option('credit_note_prefix_changed', false);
        add_option('number_padding_prefixes_changed', false);
        if ($this->db->field_exists('file_number_court', db_prefix() . 'my_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` MODIFY `file_number_court` bigint DEFAULT NULL');
        }
    }
}
