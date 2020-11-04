<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_271 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {

        if (!$this->db->table_exists(db_prefix() . 'my_exported_services')) { 
            $this->db->query('CREATE TABLE `' . db_prefix() .  'my_exported_services` (
              `id` int(11)  NOT NULL AUTO_INCREMENT,
              `service_id` int(11) NOT NULL,
              `rel_id` int(11) NOT NULL,
              `url` text NOT NULL,
              `email` varchar(255) NOT NULL,
              `password` varchar(255) NOT NULL,
              `office_id` int(11) NOT NULL,
              `office_name` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=' . $this->db->char_set . ' AUTO_INCREMENT=1 ;');
        }

    }
}
