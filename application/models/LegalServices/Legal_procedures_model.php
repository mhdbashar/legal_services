<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Legal_procedures_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $where = [])
    {
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            $this->db->get(db_prefix() . 'my_categories')->row();
        }
        return $this->db->get(db_prefix() . 'my_categories')->result_array();
    }

    public function add($parent_id, $data)
    {
        $data['datecreated'] = date('Y-m-d H:i:s');
        if(isset($parent_id) && $parent_id != ''):
            $data['parent_id'] = $parent_id;
        endif;
        $this->db->insert('my_categories', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Category Added [CatID: ' . $insert_id . ']');
        }
        return $insert_id;
    }
}