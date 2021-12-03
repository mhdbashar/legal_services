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
        update_option('view_invoice_only_logged_in', 1);
        update_option('estimate_auto_convert_to_invoice_on_client_accept', 0);
        if ($this->db->field_exists('file_number_court', db_prefix() . 'my_cases')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_cases` MODIFY `file_number_court` bigint DEFAULT NULL');
        }
    }
}
