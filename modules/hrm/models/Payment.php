<?php

class payment extends App_Model{

    public function __construct(){
        parent::__construct();
    }

    public function getSalary($id){
        $this->db->select('*');
        $this->db->from(db_prefix().'salary');
        $this->db->where(db_prefix().'salary.id', $id);
        
        $query = $this->db->get();
        return $query->row_array();
    }

    public function add($id, $data){
        $this->db->where('id', $id);
        $this->db->update('tblsalary', $data);

    }
    public function delete($id){

        $this->db->where('id', $id);

        $this->db->delete(db_prefix() . 'salary');
        if ($this->db->affected_rows() > 0) {
            log_activity('Vac Deleted [' . $id . ']');

            return true;
        }

        return false;
    }
}