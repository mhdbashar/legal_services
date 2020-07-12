<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Promotion_model extends App_Model{

    private $table_name = 'hr_promotions';

    public function __construct(){
        parent::__construct();
        if(!substr( $this->table_name, 0, 3 ) === "tbl"){
            $this->table_name = 'tbl' . $this->table_name;
        }
    }

    public function get($id=''){
        if(is_numeric($id)){
            $this->db->where('id' ,$id);
            $row = $this->db->get($this->table_name)->row();
            $this->db->where('id' ,$row->designation);
            $row2 = $this->db->get('tblhr_designations')->row();
            $this->db->where('staffid' ,$row->staff_id);
            $row3 = $this->db->get('tblstaff')->row();
            $row->designation = $row2;
            $row->staff = $row3;
            return $row;

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
            if($this->app_modules->is_active('branches')){
                $this->db->where(['rel_id' => $id, 'rel_type' => 'promotions']);
                $this->db->delete('tblbranches_services');
            }
            return true;
        } 
 
        return false; 
    }
}