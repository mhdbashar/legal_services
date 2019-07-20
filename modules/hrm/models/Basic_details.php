<?php

defined('BASEPATH') or exit('No direct script access allowed');

class basic_details extends App_Model
{
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
