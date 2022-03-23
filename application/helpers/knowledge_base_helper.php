<?php
defined('BASEPATH') or exit('No direct script access allowed');

function get_kb_group($id){
    $CI = &get_instance();
    $CI->db->where('groupid', $id);
    return $CI->db->get(db_prefix() . 'knowledge_base_groups')->row();
}

function get_kb_base_group(){
    $CI = &get_instance();
    $CI->db->where('parent_id', 0);
    return $CI->db->get(db_prefix() . 'knowledge_base_groups')->result_array();
}
