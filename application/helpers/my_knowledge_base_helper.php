<?php
defined('BASEPATH') or exit('No direct script access allowed');

function kb_group_name($id){
    $CI = & get_instance();
    $CI->db->where('groupid', $id);
    $group = $CI->db->get(db_prefix() . 'knowledge_base_groups')->row();
    if($group)
        return $group;
    else
        return false;
}


function kb_all_main_group_name($parent_id){
    $CI = & get_instance();
    $data = [];
    if($parent_id == 0){
        $data[]= _l('main_group');;
    }else {
        for ($i = 0; $i < 11; $i++) {
            $CI->db->where('groupid', $parent_id);
            $val = $CI->db->get(db_prefix() . 'knowledge_base_groups')->row();
            if ($val) {
                $data[$i] = $val->name;
                $parent_id = $val->parent_id;
            } else {
                break;
            }
        }
    }
        $data = implode(' >> ',$data);
        return $data;
}


function kb_all_main_group($parent_id){
    $CI = & get_instance();
    $data = [];
    if($parent_id == 0){
        return $data;
    }else {
        for ($i = 0; $i < 11; $i++) {
            $CI->db->where('groupid', $parent_id);
            $val = $CI->db->get(db_prefix() . 'knowledge_base_groups')->row();
            if ($val) {
                $data[$i] = $val;
                $parent_id = $val->parent_id;
            } else {
                break;
            }
        }
    }
    return $data;
}

function kb_all_childe_group($id){
    $CI = & get_instance();
    $CI->db->where('main_group_id', $id);
    $CI->db->order_by('groupid', 'asc');
    $data = $CI->db->get(db_prefix() . 'knowledge_base_groups')->result_array();

    $CI->db->where('groupid', $id);
    $main = $CI->db->get(db_prefix() . 'knowledge_base_groups')->row_array();
    array_unshift($data,$main);

    return $data;
}

function kb_main_groups(){
    $CI = & get_instance();
    $CI->db->where(['is_main'=> '1','active'=>'1']);
    $groups = $CI->db->get(db_prefix() . 'knowledge_base_groups')->result();
    if($groups)
        return $groups;
    else
        return false;

}

function get_kb_main_groups(){
    $CI = & get_instance();
    $CI->db->where(['parent_id'=> '0','active'=>'1']);
    $main_group = $CI->db->get(db_prefix() . 'knowledge_base_groups')->result();
    if($main_group)
        return $main_group;
    else
        return false;
}

function kb_childe_group($id){
    $CI = & get_instance();
    $CI->db->where(['parent_id'=> $id,'active'=>'1']);
    $CI->db->order_by('group_order', 'asc');
    $val = $CI->db->get(db_prefix() . 'knowledge_base_groups')->result();
        if ($val)
            return $val;

    return false;
}

function get_all_article_by_type($type){
    $CI = & get_instance();
    $CI->db->where(['type'=> $type]);
    $val = $CI->db->get(db_prefix() . 'knowledge_base')->result();
    if ($val)
        return $val;

    return false;
}

function is_staff($email,$firstname,$lastname){
    $CI = & get_instance();
    $CI->db->select('staffid,password,firstname,lastname,email');
    $CI->db->where('email', $email);
    $CI->db->where('firstname', $firstname);
    $CI->db->where('lastname', $lastname);
    $result = $CI->db->get(db_prefix() . 'staff')->row();
    if($result)
        return $result;

    return false;
}

function get_knowledge_article($id){
    $CI = & get_instance();
    $CI->db->where('articleid', $id);
    $article = $CI->db->get(db_prefix() . 'knowledge_base')->row();
    if($article)
        return $article;
    else
        return false;
}

function get_knowledge_custom_field($id){
    $CI = & get_instance();
    $CI->db->where('id', $id);
    $article = $CI->db->get(db_prefix() . 'knowledge_custom_fields')->row();
    if($article)
        return $article;
    else
        return false;
}

