<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Project_contacts extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_all($project_id)
    {
        $this->db->order_by('contact_type');
        return $this->db->get_where('my_projects_contacts', array('project_id' => $project_id))->result();
    }

    public function update_project_temp_contact($project_id)
    {
        //return $this->db->query('UPDATE `' . db_prefix() . 'my_projects_contacts` SET project_id='.$project_id.' WHERE project_id=-1');
        $data = array('project_id'=>$project_id);
        $this->db->where('project_id', -1);
        $this->db->update('my_projects_contacts', $data);
        return true;
    }
	
	public function get_by_id($id)
    {         
		return $this->db->get_where('my_projects_contacts', array('id' => $id));
    }
	
	public function add_new($data)
    {
        $this->db->insert('my_projects_contacts', $data);	
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
	public function update($id,$data)
    {  
        $this->db->where('id', $id);
        $this->db->update('my_projects_contacts', $data);
        //if ($this->db->affected_rows() > 0) {
            return true;
        //}
        //return false;
    }
	
	public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('my_projects_contacts');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
	
}
