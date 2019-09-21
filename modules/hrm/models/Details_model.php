<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Details_model extends App_Model
{

    public function add_bank($data){
        $this->db->insert('tblmy_bank', $data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            log_activity('Bank added [ID: '.$insert_id.']');
            return true;
        }
        return false;
    }

    public function edit_bank($data, $id){
        $this->db->where('id', $id);
        $this->db->update('tblmy_bank', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Bank Updated [ID: '.$id.']');
            return true;
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
        $this->db->select('*');
        $this->db->from('tblmy_newstaff');
        $query = $this->db->get();
		return $query->row_array();
    }
    public function updateStaff($id, $array = null, $array2 = null){

    	$this->db->where(['staffid' => $id]);
    	if ($array != null)$this->db->update('tblstaff', $array);
        $affacted = 0;
        if ($this->db->affected_rows() > 0) {
            $affacted++;
        }
        if ($this->issetNewDetails($id)){
            $this->db->where(['staff_id' => $id]);
            if ($array2 != null)$this->db->update('tblmy_newstaff', $array2);
        }else{
            $this->db->insert('tblmy_newstaff', $array2);
        }
        if ($this->db->affected_rows() > 0) {
            
            $affacted++;
        }
        if($affacted > 0){
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

    public function get_month_holiday($month){
        $this->db->where('MONTH(start_date)', $month);
        $this->db->from('tblmy_holiday');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_month_vaction($month, $staff_id){
        $this->db->where(['MONTH(start_date)' => $month, 'staff_id' => $staff_id]);
        $this->db->from('tblmy_vac');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function getdays()
    {
        $this->db->select('*');
        $this->db->from('tblmy_workday');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_staff_name($staff_id){
        $this->db->select('firstname, lastname');
        $this->db->where('staffid', $staff_id);
        $query = $this->db->get('tblstaff');
        return $query->row_array();
    }
}

?>
