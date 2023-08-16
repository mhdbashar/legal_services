<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_529 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        $ids = $this->db->select('id')->get('tblmy_cases')->result_array();

        foreach ($ids as $id) {
            if ($this->db->from(db_prefix() . 'case_settings')->where('case_id', $id)) {

                $this->db->insert(db_prefix() . 'case_settings', [
                    'case_id' => $id['id'],
                    'name'    => 'view_session_customer_report',
                    'value'   => 0
                ]);
            }
        }
    }
}