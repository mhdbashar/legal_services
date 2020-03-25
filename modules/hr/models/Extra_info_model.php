<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Extra_info_model extends App_Model{

    private $table_name = 'hr_extra_info';

    public function __construct(){
        parent::__construct();
        if(!substr( $this->table_name, 0, 3 ) === "tbl"){
            $this->table_name = 'tbl' . $this->table_name;
        }
    }

    public function get($staff_id=''){
        if(is_numeric($staff_id)){
            $this->db->where('staff_id' ,$staff_id);
            $staff = $this->db->get($this->table_name)->row();
            if ($staff) {
                $staff->leaves = $this->get_staffs_leaves($staff_id);
                return $staff;
            }
        }

        return false;
    }

    public function get_staffs_leaves($id){
        $this->db->select('tblhr_leave_type.id, tblhr_leave_type.name');
        $this->db->from('tblhr_staffs_leaves');
        $this->db->join('tblhr_leave_type', 'tblhr_leave_type.id = tblhr_staffs_leaves.leave_id');
        $this->db->where('tblhr_staffs_leaves.staff_id', $id);
        //var_dump($this->CI->db->conn_id->error);
        return $this->db->get()->result_array();
    }

    public function has_extra_info($staff_id){
        if($this->get($staff_id))
            return true;
        return false;
    }

    public function get_staff_department($staff_id=''){
        if(is_numeric($staff_id)){
            $this->db->where('staffid' ,$staff_id);
            $department = $this->db->get('tblstaff_departments')->row();
            if(is_object($department)){
                $departmentid = $department->departmentid;
                return $this->Departments_model->get($departmentid);
            }
            
        }

        return false;
    }

    public function add($data){
        if(isset($data['leaves']))
        {
            $sleaves=$data['leaves'];
        }

        unset($data['leaves']);
        $this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            log_activity('New ' . $this->table_name . ' added [ID: '.$insert_id.']');
            if (isset($sleaves)) {
                foreach ($sleaves as $sid) {
                    if (empty($sid)) {
                        continue;
                    }
                    $this->db->insert(db_prefix() . 'hr_staffs_leaves', [
                        'staff_id' => $data['staff_id'],
                        'leave_id'   => $sid,
                    ]);
                }

            }
            return $insert_id;
        }
        return false;
    }

    public function update($data, $staff_id){
        if(isset($data['leaves']))
        {
            $sleaves=$data['leaves'];
            
        }
        unset($data['leaves']);
        $staffs_leaves_in = $this->get_staffs_leaves($staff_id);
        if (sizeof($staffs_leaves_in) > 0) {
            foreach ($staffs_leaves_in as $leaves_member) {
                if (isset($sleaves)) {
                    if (!in_array($leaves_member['id'], $sleaves)) {
                        $this->db->where('staff_id', $staff_id);
                        $this->db->where('leave_id', $leaves_member['id']);
                        $this->db->delete('tblhr_staffs_leaves');

                    }
                }else
                {
                    $this->db->where('staff_id', $staff_id);
                    $this->db->delete(db_prefix() . 'hr_staffs_leaves');
                }
            }
            if (isset($sleaves)) {
                $notifiedUsers = [];
                foreach ($sleaves as $sid) {
                    $this->db->where('staff_id', $staff_id);
                    $this->db->where('leave_id', $sid);
                    $_exists = $this->db->get(db_prefix() . 'hr_staffs_leaves')->row();
                    if (!$_exists) {
                        if (empty($sid)) {
                            continue;
                        }
                        $this->db->insert(db_prefix() . 'hr_staffs_leaves', [
                            'staff_id' => $staff_id,
                            'leave_id'   => $sid,
                        ]);

                    }

                }


            }




        }else {
            if (isset($sleaves)) {
                foreach ($sleaves as $sid) {
                    if (empty($sid)) {
                        continue;
                    }
                    $this->db->insert(db_prefix() . 'hr_staffs_leaves', [
                        'staff_id' => $data['staff_id'],
                        'leave_id'   => $sid,
                    ]);
                }

            }
        }
        $this->db->where('staff_id', $staff_id);
        $this->db->update($this->table_name, $data);
        if($this->db->affected_rows() > 0){
            log_activity($this->table_name . ' updated [ ID: '. $staff_id . ']');
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