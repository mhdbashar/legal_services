<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Designation_model extends App_Model{

    private $table_name = 'hr_designations';

    public function __construct(){
        parent::__construct();
        if(!substr( $this->table_name, 0, 3 ) === "tbl"){
            $this->table_name = 'tbl' . $this->table_name;
        }
    }

    public function get_designations($department_id){
        $data = [];
        $this->db->where(['department_id' => $department_id]);
        $rows = $this->db->get($this->table_name)->result_array();
        foreach ($rows as $row) {
            $data[] = ['key' => $row['id'], 'value' => $row['designation_name']];
        }
        return $data;
    }

    public function to_designation($staff, $designation){
        $this->db->where('staff_id', $staff);
        $this->db->update(db_prefix() . 'hr_extra_info', ['designation' => $designation]);
        if($this->db->affected_rows() > 0){
            log_activity('tblhr_extra_info' . ' updated [ designation: '. $designation . ']');
            return true;
        }
        return false;
    }

    public function get_designations_by_staff_id($staff_id){
        $department_id = $this->Departments_model->get_staff_departments($staff_id)[0]['departmentid'];
        $data = [];
        $this->db->where(['department_id' => $department_id]);
        $rows = $this->db->get($this->table_name)->result_array();
        foreach ($rows as $row) {
            // if($this->Extra_info_model->get($staff_id)->designation == $row['id']){
            //     continue;
            // }
            $data[] = ['key' => $row['id'], 'value' => $row['designation_name']];
        }
        return $data;
    }

    public function get_staffs_by_branch_id($branch_id){
        $this->db->where(['branch_id' => $branch_id, 'rel_type' => 'staff']);
        $this->db->join(db_prefix() . 'hr_extra_info', db_prefix() . 'hr_extra_info.staff_id = '.db_prefix().'branches_services.rel_id', 'inner');
        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid = '.db_prefix() .'hr_extra_info.staff_id', 'inner');
        $staffs = $this->db->get(db_prefix() . 'branches_services')->result_array();
        $data = [];
        foreach ($staffs as $staff) {
            $staff_array = [];
            $staff_array['key'] = $staff['staffid'];
            $staff_array['value'] = $staff['firstname'];
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

            
            $row->department = $row2;
            
            return $row;
        }

        $this->db->order_by('id', 'desc');
        return $this->db->get($this->table_name)->result_array();
    }

    public function get_designation_group($id = ''){
        if(is_numeric($id)){
            $this->db->where('id' ,$id);
            return $this->db->get(db_prefix() . 'hr_designations_groups')->row();
        }

        $this->db->order_by('id', 'desc');
        return $this->db->get(db_prefix() . 'hr_designations_groups')->result_array();
    }

    public function get_designation($id=''){
        if(is_numeric($id)){
            $this->db->where('id' ,$id);
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

    public function add_designation_group($data){

        $this->db->insert(db_prefix() . 'hr_designations_groups', $data);
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

    public function update_designation_group($data, $id){
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'hr_designations_groups', $data);
        if($this->db->affected_rows() > 0){
            log_activity(db_prefix() . 'hr_designations_groups' . ' updated [ ID: '. $id . ']');
            return true;
        }
        return false;
    }

    public function delete($id, $simpleDelete = false){
        if (is_reference_in_table('designation', db_prefix() . 'hr_extra_info', $id)) {
            return [
                'referenced' => true,
            ];
        }
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
        if ($this->db->affected_rows() > 0) {
            if($this->app_modules->is_active('branches')){
                $this->db->where(['rel_id' => $id, 'rel_type' => 'designations']);
                $this->db->delete(db_prefix() . 'branches_services');
            }
            log_activity($this->table_name . ' Deleted [' . $id . ']'); 
 
            return true;
        } 
 
        return false; 
    }
}