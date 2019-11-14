<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Salary_model extends App_Model{

    private $table_name = 'tblhr_salary';

    public function __construct(){
        parent::__construct();
        if(!substr( $this->table_name, 0, 3 ) === "tbl"){
            $this->table_name = 'tbl' . $this->table_name;
        }
    }

    public function get($staff_id=''){
        if(is_numeric($staff_id)){
            $this->db->where('staff_id' ,$staff_id);
            return $this->db->get($this->table_name)->row();
        }

        $this->db->order_by('staff_id', 'desc');
        return $this->db->get($this->table_name)->result_array();
    }

    public function count_results($staff_id){
        if(is_numeric($staff_id)){
            $this->db->select('*');
            $this->db->from($this->table_name);
            $this->db->where('staff_id' ,$staff_id);
            return $this->db->get()->row();
        }
    }

    public function create($data){
        $this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            log_activity('New ' . $this->table_name . ' added [ID: '.$insert_id.']');
            return $insert_id;
        }
        return false;
    }

    public function update($data, $staff_id){
        $this->db->where('staff_id', $staff_id);
        $this->db->update($this->table_name, $data);
        if($this->db->affected_rows() > 0){
            log_activity($this->table_name . ' updated [ID: '. $staff_id . ']');
            return true;
        }
        if(!$this->get($staff_id)){
            $this->create($data);
            return true;
        }
        return false;
    }
/*
    public function delete($id, $simpleDelete = false){
        $this->db->where('holiday_id', $id);
        $this->db->delete($this->table_name);
        if ($this->db->affected_rows() > 0) {
            log_activity($this->table_name . ' Deleted [' . $id . ']'); 
 
            return true;
        } 
 
        return false; 
    }
*/
}