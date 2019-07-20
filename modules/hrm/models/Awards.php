<?php

class awards extends App_Model{
	public function __construct(){
		parent::__construct();
	}

    public function getAward($id){
        $this->db->select('*');
        $this->db->from('tblmy_award');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();

    }
    public function getStaff(){
        $this->db->select('*');
        $this->db->from('tblstaff');
        return $this->db->get()->result_array();
    }

    public function add($data){
        $this->db->insert('tblmy_vac', $data);
    }

    public function update($data, $id)
    {   
    	$query = $this->db->get_where('tblmy_award', array('id' => $id));
    	if(empty($query->row_array())){
            unset($data['id']);
	        $this->db->insert('tblmy_award', $data);
        }else {
        	$this->db->where(['id' => $id]);
        	$this->db->update('tblmy_award', $data);
        }

        if ($this->db->affected_rows() > 0) {

            return true;
        }

        return false;
    }

	public function delete($id, $simpleDelete = false){

        $this->db->where('id', $id);

        $this->db->delete('tblmy_award');
        if ($this->db->affected_rows() > 0) {
            log_activity('Award Deleted [' . $id . ']');

            return true;
        }

        return false;
    }

}