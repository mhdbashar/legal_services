<?php

class Drive_model extends App_Model
{
    private $table_name = 'tblmy_googlesheet_credential';

    public function __construct()
    {
        parent::__construct();
    }

    public function get($staff_id = ''){
        if(is_numeric($staff_id)){
            $this->db->where('staff_id' ,$staff_id);
            return $this->db->get($this->table_name)->row_array();
        }
        return false;
    }

    public function add($data)
    {
        $this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            log_activity('New ' . $this->table_name . ' added [ID: '.$insert_id.']');
            return $insert_id;
        }
        return false;
    }


    public function update($data, $staff_id)
    {
        $this->db->where('staff_id', $staff_id);
        $this->db->update($this->table_name, $data);
        if($this->db->affected_rows() > 0){
            log_activity($this->table_name . ' staff_id [ ID: '. $staff_id . ']');
            return true;
        }
        return false;
    }

    public function delete($staff_id)
    {
        $this->db->where('staff_id', $staff_id);
        $this->db->delete($this->table_name);

        if($this->db->affected_rows() > 0)
        {
            log_activity($this->table_name . ' staff_id [ ID: '. $staff_id . ']');
            return true;
        }
        return false; 
       
    }

}