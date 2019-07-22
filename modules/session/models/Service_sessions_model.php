<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Service_sessions_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function update_details($id, $data)
    {   
            $this->db->where(['id' => $id]);
            $this->db->update('tblmy_service_session', $data);

        if ($this->db->affected_rows() > 0) {
            log_activity('Vac Deleted [' . $id . ']');

            return true;
        }

        return false;
    }

    public function count_sessions($service_id, $rel_id){
        $this->db->select('id');
        $this->db->from(db_prefix() . 'my_service_session');
        $this->db->where(['service_id' => $service_id, 'rel_id' => $rel_id]);
        return $this->db->count_all_results();
    }
   
    
    // tblmy_service_sessions, `id`, `service_id`, `red_id`, `rel_type`, `subject`, `court_id`, `judge_id`, `date`, `details`, `next_action`, `next_date`, `report`, `deleted`

    public function get($id = '')
    {
        if (is_numeric($id)) {
        $this->db->where('id', $id);

        return $this->db->get('tblmy_service_session')->row();
        }
        
        $this->db->order_by('id', 'desc');
        return $this->db->get('tblmy_service_session')->result_array();
    }
    
    public function get_discussion($id = '')
    {
        if (is_numeric($id)) {
        $this->db->where('id', $id);

        return $this->db->get('tblprojectdiscussions')->row();
        }
        
        $this->db->order_by('id', 'desc');
        return $this->db->get('tblprojectdiscussions')->result_array();
    }
    

    public function getStaffName($id){
        $this->db->select('*');
        $this->db->from('tblfiles');
        $this->db->where('id', $id);
        $this->db->join(db_prefix().'staff',db_prefix().'staff.staffid='. 'tblfiles.staffid','Left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getStaff($id){
        $this->db->select('*');
        $this->db->from('tblstaff');
        $this->db->where('staffid', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function add($data)
    {

        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            unset($data['custom_fields']);
        }

        $this->db->insert('tblmy_service_session', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Session [ID: ' . $insert_id . ']');

            if (isset($custom_fields)) {
                handle_custom_fields_post($insert_id, $custom_fields);
            }

            return $insert_id;
        }

        return false;
    }

    public function update($data, $id)
    {

        $affectedRows = 0;
        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            if (handle_custom_fields_post($id, $custom_fields)) {
                $affectedRows++;
            }
            unset($data['custom_fields']);
        }
        
        $this->db->where('id', $id);
        $this->db->update('tblmy_service_session', $data);
        if ($this->db->affected_rows() > 0) {

            $affectedRows++;
            log_activity('Session Updated [ID: ' . $id . ']');

            return true;
        }

        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }


    
    public function delete($id, $simpleDelete = false)
    {
        $this->db->where('id', $id);
        $delete = $this->db->delete(db_prefix() . 'my_service_session');

        // $this->db->where('id', $id);
        // $this->db->delete(db_prefix() . 'my_judges');
        if ($this->db->affected_rows() > 0) {
            log_activity('Session Deleted [' . $id . ']');

            return $delete;
        }

        return false;
    }

    public function get_court($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('c_id', $id);
    
            return $this->db->get('tblmy_courts')->row();
            }
            
            $this->db->order_by('court_name', 'asc');
            return $this->db->get('tblmy_courts')->result_array();
    }

    public function get_judges($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
    
            return $this->db->get('tblmy_judges')->row();
            }
            
            $this->db->order_by('id', 'desc');
            return $this->db->get('tblmy_judges')->result_array();
    }

}

