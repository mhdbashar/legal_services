<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Procurationstate_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    
    // tblmy_procurationstate, `id`, `procurationstate`
    public function get($id = '')
    {
        if (is_numeric($id)) {
        $this->db->where('id', $id);

        return $this->db->get(db_prefix() . 'my_procurationstate')->row();
        }
        
        $this->db->order_by('id', 'desc');
        return $this->db->get(db_prefix() . 'my_procurationstate')->result_array();
    }


    public function add($data)
    {

        
        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            unset($data['custom_fields']);
        }

        // $data['procurationstate'] = nl2br($data['procurationstate']);
        $this->db->insert(db_prefix() . 'my_procurationstate', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Procuration State [ID: ' . $insert_id . ']');

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
        
        // $data['procurationstate'] = nl2br($data['procurationstate']);
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'my_procurationstate', $data);
        if ($this->db->affected_rows() > 0) {

            $affectedRows++;
            log_activity('Procuration State Updated [ID: ' . $id . ']');

            return true;
        }

        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }


    
    public function delete($id, $simpleDelete = false)
    {

        $this->db->where('relid', $id);
        $this->db->where('fieldto', 'proc_state');
        $this->db->delete(db_prefix() . 'customfieldsvalues');

        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'my_procurationstate');
        if ($this->db->affected_rows() > 0) {
            log_activity('Procuration State Deleted [' . $id . ']');

            return true;
        }

        return false;
    }

}

