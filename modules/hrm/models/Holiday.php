<?php

class holiday extends App_Model{
	public function __construct(){
		parent::__construct();
	}

	public function setNewHoliday($event_name, $description, $start_date, $end_date){
		$data = array(
    		'event_name' => $event_name, 
    		'description' => $description, 
    		'start_date' => $start_date, 
    		'end_date' => $end_date
    	);
    	$this->db->insert('tblmy_holiday', $data);
	}
    public function getHolidays($id){
        $this->db->where('id', $id);
        $this->db->from('tblmy_holiday');
        $query = $this->db->get();
        return $query->row();
    }

    public function add($data){
        $this->db->insert('tblmy_holiday', $data);
        $insert_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            log_activity('Holiday Added [' . $insert_id . ']');

            return true;
        }

        return false;
    }

    public function update($data, $id)
    {   
        $query = $this->db->get_where('tblmy_holiday', array('id' => $id));
        if(empty($query->row_array())){
            unset($data['id']);
            $this->db->insert('tblmy_holiday', $data);
        }else {
            $this->db->where(['id' => $id]);
            $this->db->update('tblmy_holiday', $data);
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

        $this->db->delete('tblmy_holiday');
        if ($this->db->affected_rows() > 0) {
            log_activity('Holiday Deleted [' . $id . ']');

            return true;
        }

        return false;
    }

}