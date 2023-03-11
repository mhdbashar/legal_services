<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Indicator_model extends App_Model{

    private $table_name = 'tblhr_indicators';

    public function __construct(){
        parent::__construct();
        if(!substr( $this->table_name, 0, 3 ) === "tbl"){
            $this->table_name = 'tbl' . $this->table_name;
        }
    }

    public function get($id=''){
        if(is_numeric($id)){
            $this->db->select('*, '.$this->table_name.'.id');
            $this->db->where($this->table_name.'.id' ,$id);
            $this->db->join(db_prefix() . 'hr_designations', db_prefix() . 'hr_designations.id = '.$this->table_name.'.designation_id', 'inner');
            $this->db->join(db_prefix() . 'branches_services', db_prefix() . 'branches_services.rel_id = '.db_prefix() .'hr_designations.department_id AND '.db_prefix() . 'branches_services.rel_type="departments"', 'inner');
            return $this->db->get($this->table_name)->row();
        }

        $this->db->order_by('id', 'desc');
        return $this->db->get($this->table_name)->result_array();
    }

    public function add($data){
        $this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            log_activity('New ' . $this->table_name . ' added [ID: '.$insert_id.']');
            return $insert_id;
        }
        return false;
    }

    public function update($data, $id){
        $this->db->where('id', $id);
        $this->db->update($this->table_name, $data);
        if($this->db->affected_rows() > 0){
            log_activity($this->table_name . ' updated [ ID: '. $id . ']');
            return true;
        }
        return false;
    }

    public function delete($id, $simpleDelete = false){
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
        if ($this->db->affected_rows() > 0) {
            log_activity($this->table_name . ' Deleted [' . $id . ']'); 
 
            return true;
        } 
 
        return false; 
    }
}