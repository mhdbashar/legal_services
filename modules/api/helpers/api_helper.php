<?php 
defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('insert')) 
{
    function insert($table_name, $insert_data)
    {
        $CI =& get_instance();
        return $CI->db->insert($table_name, $insert_data);
    }
}
