<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_517 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        // jawad

        if (!$this->db->field_exists('time', db_prefix() . 'reminders')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'reminders` ADD `time` varchar(255) DEFAULT NULL');
        }

        $this->db->where('is_default', 1);
        $default = $this->db->get(db_prefix() . 'my_judicialdept')->row_array();
        if((empty($default))){
            $this->db->where('is_default', 1);
            $default = $this->db->get(db_prefix() . 'my_courts')->row();

            $this->db->insert(db_prefix() . 'my_judicialdept', [
                'Jud_number' => 'nothing_was_specified',
                'c_id' => $default->c_id,
                'is_default' => 1,
                'datecreated' => '2022-02-22 03:31:15'
            ]);
        }
    }
}
