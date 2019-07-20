<?php

class make_payment extends App_Model{

    public function __construct(){
        parent::__construct();
    }

    public function getSalary($staff_id){
        $this->db->select('*');
        $this->db->from(db_prefix().'my_newstaff');
        $this->db->where(db_prefix().'my_newstaff.staff_id', $staff_id);
        $this->db->join(db_prefix().'my_award',db_prefix().'my_award.staff_id='. $staff_id,'Left');
        $this->db->select(db_prefix().'my_newstaff.staff_id');
        
        $query = $this->db->get();
        return $query->row_array();
    }

    public function add($data){
        $this->db->insert('tblmy_salary', $data);

    }
}