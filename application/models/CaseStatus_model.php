<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CaseStatus_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // tblmy_CaseStatus, `id`, `name`, `note`
    public function get($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            $this->db->where('is_default', 0);
            return $this->db->get(db_prefix() . 'my_casestatus')->row();
        }
        $this->db->where('is_default', 0);
        $this->db->order_by('id', 'desc');
        return $this->db->get(db_prefix() . 'my_casestatus')->result_array();
    }

    public function add($data)
    {
        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            unset($data['custom_fields']);
        }
        $this->db->insert(db_prefix() . 'my_casestatus', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Judge [ID: ' . $insert_id . ']');

            if (isset($custom_fields)) {
                handle_custom_fields_post($insert_id, $custom_fields);
            }

            return $insert_id;
        }
        return false;
    }

    public function update($data, $id)
    {
        $affectedRows = 0;
        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            if (handle_custom_fields_post($id, $custom_fields)) {
                $affectedRows++;
            }
            unset($data['custom_fields']);
        }
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'my_casestatus', $data);
        if ($this->db->affected_rows() > 0) {
            $affectedRows++;
            log_activity('Case Status Updated [ID: ' . $id . ']');
            return true;
        }
        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }
    
    public function delete($id, $simpleDelete = false)
    {
        $this->db->where('is_default', 1);
        $default = $this->db->get(db_prefix() . 'my_casestatus')->row();
        $this->db->where('case_status', $id);
        $this->db->update(db_prefix() . 'my_cases', ['case_status' => $default->id]);

        $this->db->where('relid', $id);
        $this->db->where('fieldto', 'cstauts'); //cstauts is the name of belong to in custom fields table
        $this->db->delete(db_prefix() . 'customfieldsvalues');
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'my_casestatus');
        if ($this->db->affected_rows() > 0) {
            log_activity('Case Status Deleted [' . $id . ']');
            return true;
        }
        return false;
    }
}