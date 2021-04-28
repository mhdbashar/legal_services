<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_308 extends App_module_migration
{
    public function up(){
        $CI = &get_instance();
        if (!$CI->db->table_exists(db_prefix() . 'hr_dependent_person')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "hr_dependent_person` (
              `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
              `staffid` int(11) UNSIGNED  NULL,
              `dependent_name` varchar(100) NULL ,
              `relationship` varchar(100) NULL ,
              `dependent_bir` date NULL ,
              `start_month` date NULL ,
              `end_month` date NULL ,
              `dependent_iden` varchar(20) NOT NULL ,
              `reason` longtext NULL ,
              `status` int(11) UNSIGNED  NULL DEFAULT 0 ,
              `status_comment` longtext NULL,
        
              
              PRIMARY KEY (`id`,`dependent_iden`)
            ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }


    }
}