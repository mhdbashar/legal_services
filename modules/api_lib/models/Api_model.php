<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function search_like_title($text,$type =''){
        $this->db->select('articleid as id');
        if($type!='')$this->db->where(['type' => $type]);
        $this->db->where(['active' => 1]);
        $this->db->like('subject',$text);
        $this->db->from(db_prefix() . 'knowledge_base');
        return $this->db->get()->result_array();
    }

    public function search_like_informations($text,$type =''){
        $this->db->select('relid as id');
        if($type!='')$this->db->where(['fieldto' => 'kb_'.$type]);
        $this->db->like('value',$text);
        $this->db->from(db_prefix() . 'customfieldsvalues');
        return $this->db->get()->result_array();
    }

    public function search_like_custom_fields_values($text,$type ='',$fieldid){
        $this->db->select('id as id');
        if($type!='')$this->db->where(['fieldto' => 'kb_'.$type,'fieldid' => $fieldid]);
        $this->db->like('value',$text);
        $this->db->from(db_prefix() . 'customfieldsvalues');
        return $this->db->get()->result_array();
    }

    public function search_like_description($text,$type =''){
        $this->db->select('id as id');
        if($type!='')$this->db->where(['type' => $type]);
        $this->db->like('description',' '.$text.' ');
        $this->db->from(db_prefix() . 'knowledge_custom_fields');
        return $this->db->get()->result_array();

//        $sql = 'SELECT id as id
//            FROM tblknowledge_custom_fields
//            WHERE (type = '.$type.') AND ( MATCH (description) AGAINST ("'."$text".'" IN BOOLEAN MODE))';
//        return $this->db->query($sql)->result_array();

    }

    public function search_like_content($text,$type =''){
        $this->db->select('knowledge_id as id');
        if($type!='')$this->db->where(['type' => $type]);
        $this->db->like('description',' '.$text.' ');
        $this->db->from(db_prefix() . 'knowledge_custom_fields');
        return $this->db->get()->result_array();

//        $sql = 'SELECT knowledge_id as id
//            FROM tblknowledge_custom_fields
//            WHERE (type = '.$type.') AND ( MATCH (description) AGAINST ("'."$text".'" IN BOOLEAN MODE))';
//        return $this->db->query($sql)->result_array();

    }

    public function get_knowledge_custom_fields($id){
        $this->db->where(['id' => $id]);
        $this->db->from(db_prefix() . 'knowledge_custom_fields');
        return $this->db->get()->row();
    }

    public function get_custom_fields_values($id){
        $this->db->where(['id' => $id]);
        $this->db->from(db_prefix() . 'customfieldsvalues');
        return $this->db->get()->row();
    }

    public function get_custom_fields($id){
        $this->db->where(['id' => $id]);
        $this->db->from(db_prefix() . 'customfields');
        return $this->db->get()->row();
    }

    public function search_in_nezams($fieldid,$value){
        $sql = 'SELECT *
            FROM tblcustomfieldsvalues
            WHERE (fieldid = '.$fieldid.') AND (fieldto = "kb_2" ) 
            AND ( MATCH (value) AGAINST ("'."$value".'" IN BOOLEAN MODE))';
        $row = $this->db->query($sql)->row();

//        $this->db->where(['fieldto' => 'kb_2']);
//        $this->db->where(['fieldid' => $fieldid]);
//        $this->db->like(['value' => $value]);
//        $this->db->from(db_prefix() . 'customfieldsvalues');
//        $row =$this->db->get()->row();
        if($row)
            return $row;

        return false;
    }

    public function search_like_content_where_knowledge_id($text,$type ='',$knowledge_ids){
        $this->db->select('id as id');
        if($type!='')$this->db->where(['type' => $type]);
        $this->db->where_in('knowledge_id' , $knowledge_ids);
        if($text != ' ')$this->db->like('description',' '.$text.' ');
        $this->db->from(db_prefix() . 'knowledge_custom_fields');
        $result = $this->db->get()->result_array();
        if($result)
            return $result;

        return false;
    }

    public function copy(){
        $affected_rows = 0;
        $this->db->select('type,articleid');
        $this->db->from(db_prefix() . 'knowledge_base');
        $data = $this->db->get()->result_array();
        foreach ($data as $d){
            $this->db->where('knowledge_id',$d['articleid']);
            $this->db->update(db_prefix() . 'knowledge_custom_fields', ['type' => $d['type']]);
            if ($this->db->affected_rows() > 0) {
                $affected_rows++;
            }
        }
        return $affected_rows;
    }







}