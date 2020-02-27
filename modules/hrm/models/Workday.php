<?php

defined('BASEPATH') or exit('No direct script access allowed');

class workday extends App_Model
{
    public function getdays()
    {
        $this->db->select('*');
        $this->db->from('tblmy_workday');
        $query = $this->db->get();
		return $query->row_array();
    }
    public function setdays($saturday, $sunday, $monday, $tuesday, $wednesday, $thursday, $friday){
    	$data = array(
    		'saturday' => $saturday, 
    		'sunday' => $sunday, 
    		'monday' => $monday, 
    		'tuesday' => $tuesday, 
    		'wednesday' => $wednesday, 
    		'thursday' => $thursday, 
    		'friday' => $friday
    	);
    	$this->db->update('tblmy_workday', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function update_p($data){
        $this->db->update('tblmy_workdays_period', $data);
        $this->db->inserted_id();
        if ($this->db->affected_rows() > 0) {
            log_activity('Period Updated [ID: ' . $id . ']');
            return true;
        }
        return false;
    }

    public function get_period(){
        return $this->db->get('tblmy_workdays_period')->row_array();
    }
}
