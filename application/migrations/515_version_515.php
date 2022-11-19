<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_515 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        $this->db->where('module_name', 'hijri');
        $this->db->update(db_prefix() . 'modules', ['active' => 1]);
    }
}
