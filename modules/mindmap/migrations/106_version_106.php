<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_106 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        $mindmap = db_prefix() . 'mindmap';


        // //v1


        if (!$CI->db->field_exists('rel_stype', $mindmap)) {

            $CI->db->query("ALTER TABLE `" . $mindmap . "` ADD `rel_stype` INT(11) DEFAULT '0'  AFTER `description`;");

        }


        if (!$CI->db->field_exists('rel_sid', $mindmap)) {

            $CI->db->query("ALTER TABLE `" . $mindmap . "` ADD `rel_sid` INT(11) DEFAULT '0'  AFTER `description`;");

        }
    }
}
?>
