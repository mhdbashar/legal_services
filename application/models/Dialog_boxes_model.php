<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dialog_boxes_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '')
    {
        if (is_numeric($id)) {
            return $this->db->get_where(db_prefix().'my_dialog_boxes',array('id' => $id))->row();
        }
        return $this->db->get(db_prefix().'my_dialog_boxes')->result_array();
    }

    public function add($data)
    {
        $this->db->insert('my_dialog_boxes', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New dialog box added [ID: ' . $insert_id . ', URL: '.base_url().$data['page_url'].']');
        }
        return $insert_id;
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('my_dialog_boxes', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Dialog box updated [ID: ' . $id . ', URL: '.base_url().$data['page_url'].']');
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        $this->db->delete('my_dialog_boxes', ['id' => $id]);
        if ($this->db->affected_rows() > 0) {
            log_activity('Dialog box Deleted [ID: ' . $id . ']');
            return true;
        }
        return false;
    }

    public function active($id)
    {
        $old_stat = $this->get($id)->active;
        $new_stat = $old_stat == 0 ? 1 : 0;
        $this->db->set('active', $new_stat);
        $this->db->where('id', $id);
        $this->db->update(db_prefix().'my_dialog_boxes');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
}