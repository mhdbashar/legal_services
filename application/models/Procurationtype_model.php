<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Procurationtype_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    
    // tblmy_procurationtype, `id`, `procurationtype`
    public function get($id = '')
    {

        if (is_numeric($id)) {
        $this->db->where('id', $id);

        return $this->db->get('tblmy_procurationtype')->row();
        }
        
        $this->db->order_by('id', 'desc');
        return $this->db->get('tblmy_procurationtype')->result_array();
    }


    public function add($data)
    {
        // $data['procurationtype'] = nl2br($data['procurationtype']);
        $this->db->insert('tblmy_procurationtype', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Procuration Type  [ID: ' . $insert_id . ']');

            return $insert_id;
        }

        return false;
    }

    public function update($data, $id)
    {
        // $data['procurationtype'] = nl2br($data['procurationtype']);
        $this->db->where('id', $id);
        $this->db->update('tblmy_procurationtype', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Procuration Type Updated [ID: ' . $id . ']');
            return true;
        }

        return false;
    }


    
    public function delete($id, $simpleDelete = false)
    {
        $this->db->where('id', $id);
        $this->db->delete('tblmy_procurationtype');
        if ($this->db->affected_rows() > 0) {
            log_activity('Procuration Type Deleted [' . $id . ']');

            return true;
        }

        return false;
    }

}

