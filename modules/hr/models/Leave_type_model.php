<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Leave_type_model extends App_Model{

    private $table_name = 'tblhr_leave_type';

    public function __construct(){
        parent::__construct();
        if(!substr( $this->table_name, 0, 3 ) === "tbl"){
            $this->table_name = 'tbl' . $this->table_name;
        }
    }

    public function get_leave_types_by_staff_id($staff_id){
        $this->db->where(['staff_id' => $staff_id]);
        $types = $this->db->get(db_prefix() . 'hr_staffs_leaves')->result_array();
        $data = [];
        foreach ($types as $type) {
            $leave_array = [];

            $this->db->where('id', $type['leave_id']);
            $leave_type = $this->db->get($this->table_name)->row();
            if(isset($leave_type->name )){
                $leave_array['value'] = $leave_type->name;
                $leave_array['key'] = $type['leave_id'];
            }
            else{
                continue;
            }
            $data[] = $leave_array;
        }
        return $data;
    }

    public function add_leave_to_staff($data){
        $this->db->insert(db_prefix() . 'hr_staff_leaves', $data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            log_activity('New tblhr_staff_leaves added [ID: '.$insert_id.']');
            return $insert_id;
        }
        return false;
    }

    public function get_leave_type_days($id){
        $this->db->where('id', $id);
        $leave_type = $this->db->get(db_prefix() . 'hr_leave_type')->row();
        return $leave_type->days;
    }

    public function has_days($staff_id, $leave_id, $days_added, $leave_days, $year){
        $this->db->select_sum('days');
        $this->db->where(['staff_id' => $staff_id, 'leave_id' => $leave_id, 'created' => $year]);
        $days = $this->db->get(db_prefix() . 'hr_staff_leaves')->row()->days;
        if(($days + $days_added) <= $leave_days*2)
            return true;
        //echo "$days , $days_added, $leave_days";exit;
        return false;
    }

    public function get($id=''){
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