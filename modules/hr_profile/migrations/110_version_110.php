<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_110 extends App_module_migration
{
	public function up()
	{
        $CI = &get_instance();


        $CI->db->query("CREATE TABLE IF NOT EXISTS `tblhr_contract_renew` (
              `id` int(11) NOT NULL AUTO_INCREMENT, 
              `contract_id` int(11) DEFAULT NULL, 
              `new_start_date` date DEFAULT NULL,
              `new_end_date` date DEFAULT NULL,
              `renewed_by` int(11) NOT NULL,
              `date_renewed` datetime DEFAULT NULL,
                                    PRIMARY KEY (`id`)
              
            ) ENGINE=InnoDB DEFAULT  CHARSET=utf8 AUTO_INCREMENT=1 ;
            ");

        $CI->db->query("CREATE TABLE IF NOT EXISTS `tblhr_staff_contract_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
                                      PRIMARY KEY (`id`)

) ENGINE=InnoDB DEFAULT  CHARSET=utf8 AUTO_INCREMENT=1;
            ");


        $CI->db->query("CREATE TABLE IF NOT EXISTS `tblhr_staff_contract_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_id` int(11) NOT NULL,
  `content` varchar(255) DEFAULT NULL,
                                        PRIMARY KEY (`id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
");


	}


}
