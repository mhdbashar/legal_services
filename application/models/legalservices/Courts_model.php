<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Courts_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_all_courts()
    {
        return $this->db->get_where(db_prefix() . 'my_courts',array('is_default' => 0))->result();
    }
	
	public function get_court_by_id($id)
    {         
		return $this->db->get_where(db_prefix() . 'my_courts', array('c_id' => $id));
    }

    public function get_courts_by_country_city($data)
    {
        $this->db->where('country', $data['country']);
        $this->db->where('city', $data['city']);
        $this->db->where('is_default', 0);
        return $this->db->get(db_prefix() . 'my_courts');
    }
	
	public function get_judicial_by_id($id)
    {         
		return $this->db->get_where(db_prefix() . 'my_judicialdept', array('j_id' => $id, 'is_default' => 0));
    }
	
	public function get_judicial_of_courts($id)
    {    
    	$this->db->select('*');
		$this->db->from(db_prefix() . 'my_judicialdept');
		$this->db->join(db_prefix() . 'my_courts', db_prefix() . 'my_courts.c_id = '.db_prefix().'my_judicialdept.c_id');
		$this->db->where(db_prefix() . 'my_judicialdept.c_id', $id);
		$this->db->where(db_prefix() . 'my_judicialdept.is_default', 0);
		return $this->db->get();
    }
	
	public function add_court_new($data)
    {
        $data['datecreated'] = date('Y-m-d H:i:s');               
        $this->db->insert(db_prefix() . 'my_courts', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Court Added [CourtID: ' . $insert_id . ' CourtName: ' . $data['court_name'] . ']');
        }
        return $insert_id;
    }
		
	public function add_judicial_for_court($id,$data)
    {
    	$data['datecreated'] = date('Y-m-d H:i:s');	    
        $data['c_id'] = $id;	          
        $this->db->insert(db_prefix() . 'my_judicialdept', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Court Added [JudID: ' . $insert_id . ' JudNumber: ' . $data['Jud_number'] . ']');
        }
        return $insert_id;
    }
	public function update_court_data($id,$data)
    {  
        $this->db->where('c_id', $id);
        $this->db->update(db_prefix() . 'my_courts', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Court Updated [CourtID: ' . $id . ']');
            return true;
        }
        return false;
    }
	
	public function update_judicial_data($c_id,$j_id,$data)
    {  
        $this->db->where('j_id', $j_id,'c_id', $c_id);
        $this->db->update(db_prefix() . 'my_judicialdept', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Judicial Updated [JudID: ' . $j_id . ']');
            return true;
        }
        return false;
    }
	
	public function delete_court($id)
    {
        $this->db->where('is_default', 1);
        $default = $this->db->get(db_prefix() . 'my_courts')->row();
        $this->db->where('court_id', $id);
        $this->db->update(db_prefix() . 'my_cases', ['court_id' => $default->c_id]);

        // get my_judicialdept
        $this->db->where('c_id', $id);
        $judicials = $this->db->get(db_prefix() . 'my_judicialdept')->result();

        // get default my_judicialdept
        $this->db->where('is_default', 1);
        $default = $this->db->get(db_prefix() . 'my_judicialdept')->row();

        // unlink cases
        foreach ($judicials as $judicial){
            $this->db->where('jud_num', $judicial->j_id);
            $this->db->update(db_prefix() . 'my_cases', ['jud_num' => $default->j_id]);

        }
        return true;
        $this->db->where('c_id', $id);
        $this->db->delete(db_prefix() . 'my_courts');
        if ($this->db->affected_rows() > 0) {
            $this->db->where('c_id', $id);
            $this->db->delete(db_prefix() . 'my_judicialdept');
            log_activity('Court Deleted [CourtID: ' . $id . ']');
            return true;
        }
        return false;
    }
	
	public function delete_judicial($id)
    {

        $this->db->where('is_default', 1);
        $default = $this->db->get(db_prefix() . 'my_judicialdept')->row();
        $this->db->where('jud_num', $id);
        $this->db->update(db_prefix() . 'my_cases', ['jud_num' => $default->c_id]);
        $this->db->where('j_id', $id);
        $this->db->delete(db_prefix() . 'my_judicialdept');
        if ($this->db->affected_rows() > 0) {     
            log_activity('Judicial Deleted [JudID: ' . $id . ']');
            return true;
        }
        return false;
    }


}
