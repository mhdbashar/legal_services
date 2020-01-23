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
            return $this->db->get_where(db_prefix().'my_dialog_boxes')->row();
        }
        return $this->db->get_where(db_prefix().'my_dialog_boxes', array('disable' => 0))->result_array();
    }

    public function disable($id)
    {
        $old_stat = $this->get($id)->disable;
        $new_stat = $old_stat == 0 ? 1 : 0;
        $this->db->set('disable', $new_stat);
        $this->db->where('id', $id);
        $this->db->update(db_prefix().'my_dialog_boxes');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
}