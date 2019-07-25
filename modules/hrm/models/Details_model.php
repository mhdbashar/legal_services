<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Details_model extends App_Model
{

    public function add_bank($data){
        $this->db->insert('tblmy_bank', $data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            log_activity('Bank added [ID: '.$insert_id.']');
            return $insert_id;
        }
        return false;
    }

    public function delete_bank($id){
        $this->db->where('id', $id);

        $this->db->delete('tblmy_bank');
        if ($this->db->affected_rows() > 0) {
            log_activity('Bank Deleted [' . $id . ']');

            return true;
        }

        return false;
    }

    public function get_bank($id = '')
    {
        if (is_numeric($id)) {
        $this->db->where('id', $id);

        return $this->db->get('tblmy_bank')->row();
        }
        
        $this->db->order_by('id', 'desc');
        return $this->db->get('tblmy_bank')->result_array();
    }

    public function getstaff($id)
    {
        $this->db->select('staffid, firstname, lastname, facebook, email, phonenumber, hourly_rate, skype');

        $this->db->from('tblstaff');
        $this->db->where(['staffid' => $id]);
        $query = $this->db->get();
		return $query->row_array();
    }
    public function getnewstaff($id)
    {
        $this->db->where('staff_id', $id);
        $this->db->select('main_salary, transportation_expenses, other_expenses, gender, created, job_title');
        $this->db->from('tblmy_newstaff');
        $query = $this->db->get();
		return $query->row_array();
    }
    public function updateStaff($id, $array = null, $array2 = null){

    	$this->db->where(['staffid' => $id]);
    	if ($array != null)$this->db->update('tblstaff', $array);
        if ($this->issetNewDetails($id)){
            $this->db->where(['staff_id' => $id]);
            if ($array2 != null)$this->db->update('tblmy_newstaff', $array2);
        }else{
            $this->db->insert('tblmy_newstaff', $array2);
        }
        if ($this->db->affected_rows() > 0) {
            log_activity('Staff Updated [' . $id . ']');

            return true;
        }

        return false;
    	
    }

    public function issetNewDetails($id){
        $this->db->from('tblmy_newstaff');
        $this->db->where(['staff_id' => $id]);
        $query = $this->db->get()->result();
        if(empty($query)) return false;
        else return true;
    }
}

?>
