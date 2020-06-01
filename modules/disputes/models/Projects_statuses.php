<?php

defined('BASEPATH') or exit('No direct script access allowed');

class projects_statuses extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_all()
    {
        return $this->db->get('my_projects_statuses')->result();
    }
	
	public function get_by_id($id)
    {         
		return $this->db->get_where('my_projects_statuses', array('id' => $id));
    }
	
	public function add_new($data)
    {
        $this->db->insert('my_projects_statuses', $data);	
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
	public function update($id,$data)
    {  
        $this->db->where('id', $id);
        $this->db->update('my_projects_statuses', $data);
        //if ($this->db->affected_rows() > 0) {
            return true;
        //}
        //return false;
    }
	
	public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('my_projects_statuses');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
	
}
