<?php

class vaction extends App_Model{
	public function __construct(){
		parent::__construct();
	}

    public function getVac($id){
        $this->db->select('*');
        $this->db->from('tblmy_vac');
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
    	$query = $this->db->get_where('tblmy_vac', array('id' => $id));
    	if(empty($query->row_array())){
            unset($data['id']);
	        $this->db->insert('tblmy_vac', $data);
        }else {
        	$this->db->where(['id' => $id]);
        	$this->db->update('tblmy_vac', $data);
        }

        if ($this->db->affected_rows() > 0) {

            $affectedRows++;
            log_activity('Vac Updated [ID: ' . $id . ']');

            return true;
        }

        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }

	public function delete($id, $simpleDelete = false){

        $this->db->where('id', $id);

        $this->db->delete('tblmy_vac');
        if ($this->db->affected_rows() > 0) {
            log_activity('Vac Deleted [' . $id . ']');

            return true;
        }

        return false;
    }

}