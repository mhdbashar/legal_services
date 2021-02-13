<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sub_department_model extends App_Model{

    private $table_name = 'hr_sub_departments';

    public function __construct(){
        parent::__construct();
        if(!substr( $this->table_name, 0, 3 ) === "tbl"){
            $this->table_name = 'tbl' . $this->table_name;
        }
    }

    public function get_sub_departments($department_id){
        $data = [];
        $this->db->where(['department_id' => $department_id]);
        $rows = $this->db->get($this->table_name)->result_array();
        foreach ($rows as $row) {
            $data[] = ['key' => $row['id'], 'value' => $row['sub_department_name']];
        }
        return $data;
    }

    public function get_departments_by_branch_id($branch_id){
        $this->db->where(['branch_id' => $branch_id, 'rel_type' => 'departments']);
        $branches = $this->db->get(db_prefix() . 'branches_services')->result_array();
        $data = [];
        foreach ($branches as $branch) {
            $staff_array = [];
            $staff_array['key'] = $branch['rel_id'];

            $this->db->where('departmentid', $branch['rel_id']);
            $department = $this->db->get(db_prefix() . 'departments')->row();
            $staff_array['value'] = $department->name;
            $data[] = $staff_array;
        }
        return $data;
    }

    public function get($id=''){
        if(is_numeric($id)){
            $this->db->where('id' ,$id);
            $row = $this->db->get($this->table_name)->row();
            $this->db->where('departmentid' ,$row->department_id);
            $row2 = $this->db->get(db_prefix() . 'departments')->row();
            $this->db->where(['rel_id' => $id, 'rel_type' => 'sub_departments']);
            $row3 = $this->db->get(db_prefix() . 'branches_services')->row();
            $row->department = $row2;
            $row->branch = $row3;
            return $row;
        }
        return false;
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
        if (is_reference_in_table('sub_department', db_prefix() . 'hr_extra_info', $id)) {
            return [
                'referenced' => true,
            ];
        }
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
        if ($this->db->affected_rows() > 0) {
            log_activity($this->table_name . ' Deleted [' . $id . ']'); 
            if($this->app_modules->is_active('branches')){
                $this->db->where(['rel_id' => $id, 'rel_type' => 'sub_departments']);
                $this->db->delete(db_prefix() . 'branches_services');
            }
            return true;
        } 
 
        return false; 
    }
}