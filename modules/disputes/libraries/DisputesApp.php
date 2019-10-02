<?php

defined('BASEPATH') or exit('No direct script access allowed');

class disputesapp
{

    public function __construct()
    {
        $this->ci = & get_instance();
        // @deprecated
        $this->_instance = $this->ci;
        //$this->init();

    }

    public function get_meta_title($table,$field,$where_field,$id)
    {
        if($table && $field && $where_field && $id){

            $this->ci->db->where($where_field, $id);
            $this->ci->db->limit(1);
            return $this->ci->db->get(db_prefix() . $table)->row()->$field;
        }else{
            return '';
        }
    }
}
