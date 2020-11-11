<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Written_reports_model extends App_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '', $where = [])
    {
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where(array('id' => $id));
            return $this->db->get(db_prefix() . 'written_reports')->row();
        }
        return $this->db->get(db_prefix() . 'written_reports')->result_array();
    }

    public function add($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['addedfrom'] = get_staff_user_id();
        $this->db->insert(db_prefix() . 'written_reports', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity ('New written report Added [ID: ' . $insert_id . ']');
            return $insert_id;
        }
        return false;
    }

    public function update($id,$data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updatedfrom'] = get_staff_user_id();
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'written_reports', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Written report Updated [ID: ' . $id . ']');
            return true;
        }
        return false;
    }

}