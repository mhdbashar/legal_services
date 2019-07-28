<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Case_session_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
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

