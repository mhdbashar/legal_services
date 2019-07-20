<?php

class make_payment extends App_Model{

    public function __construct(){
        parent::__construct();
    }

    public function getSalary($staff_id){
        $this->db->select('*');
        $this->db->from(db_prefix().'newstaff');
        $this->db->where(db_prefix().'newstaff.staff_id', $staff_id);
        $this->db->join(db_prefix().'award',db_prefix().'award.staff_id='. $staff_id,'Left');
        $this->db->select(db_prefix().'newstaff.staff_id');
        
        $query = $this->db->get();
        return $query->row_array();
    }

    public function add($data){
        $this->db->insert('tblsalary', $data);

    }
}