<?php

class manage_salary extends App_Model{
    public function __construct(){
        parent::__construct();
    }
    public function getStaff(){
        $this->db->select('*');
        $this->db->from('tblstaff');
        return $this->db->get()->result_array();
    }
    public function getSalary($user_id){
        $this->db->select('*');
        $this->db->from(db_prefix() .'newstaff');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->row_array();

    }

    public function update($user_id, $data)
    {   
        	$this->db->where(['user_id' => $user_id]);
        	$this->db->update('tblnewstaff', $data);

        if ($this->db->affected_rows() > 0) {
            log_activity('Vac Deleted [' . $id . ']');

            return true;
        }

        return false;
    }
}