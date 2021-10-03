<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Task_model extends CI_Model

{

    public function __construct() {

        parent::__construct();

        $this->load->model('Api_model');



    }

     public function get_tasks_all($filters = []) {
      
     	if ($filters['lead_id']) {
            $this->db->where('id', $filters['lead_id']);
        }
        if ($filters['customer_id']) {
            $this->db->where('parent_id', $filters['customer_id']);
        }
        if ($filters['startdate']) {
            $this->db->where('startdate >=', $filters['startdate']);
        }
          if ($filters['name']) {
            $this->db->where('name', $filters['name']);
        }
        if ($filters['datefinished']) {
            $this->db->where('datefinished <=', $filters['datefinished']);
        }

        if ($filters['dateadded']) {
            $this->db->where('dateadded <=', $filters['dateadded']);
        }
        if ($filters['status']) {
            $this->db->where('status <=', $filters['status']);
        }
        if ($filters['priority']) {
            $this->db->where('priority', $filters['priority']);
        }
         if ($filters['rel_type']) {
            $this->db->where('rel_type', $filters['rel_type']);
        }
        if ($filters['rel_id']) {
          
            $this->db->where('rel_id', $filters['rel_id']);
        } else {
            $this->db->order_by($filters['order_by'][0], $filters['order_by'][1] ? $filters['order_by'][1] : 'desc');
            $this->db->limit($filters['limit'], ($filters['start']-1));
        }
		
		return $this->db->get("tbltasks")->result();

    }


       public function get_task_priorities()

    {
      
        $q = $this->db->get('tbltickets_priorities');

        return $q->result();

    }
     public function get_staff()

    {
        $this->db->select('*')->from('tblstaff');
$this->db->where('active',1);
$this->db->order_by('firstname','asc');

        return $this->db->get()->result();

    }

}