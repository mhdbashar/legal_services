<?php

defined('BASEPATH') or exit('No direct script access allowed');

class workday extends App_Model
{
    public function getdays()
    {
        $this->db->select('*');
        $this->db->from('tblworkday');
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
    	$this->db->update('tblworkday', $data);
        return true;
    }
}
