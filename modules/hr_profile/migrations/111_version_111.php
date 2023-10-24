<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_111 extends App_module_migration
{
	public function up()
	{
        $CI = &get_instance();


        $CI->db->query("CREATE TABLE IF NOT EXISTS `tblhr_type_warnings` (
              `id` int(11) NOT NULL AUTO_INCREMENT, 
              `name_warnings` varchar(255) NOT NULL,
                                    PRIMARY KEY (`id`)
              
            ) ENGINE=InnoDB DEFAULT  CHARSET=utf8 AUTO_INCREMENT=1 ;
            ");

	}


}
