<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Categorylist_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getCategorylist($id,$category)
    {
    	if($id!='' || $category!=''){
    		if($category=='invoice'){
    		$this->db->where('clientid',$id);
    		return $this->db->get('tblinvoices')->result();
			}
			if($category=='project'){
                
    		$this->db->where('clientid',$id);
    		return $this->db->get('tblprojects')->result();
			}
			if($category=='contract'){
    		$this->db->where('client',$id);
    		return $this->db->get('tblcontracts')->result();
			}
			if($category=='estimate'){
    		$this->db->where('clientid',$id);
    		return $this->db->get('tblestimates')->result();
			}
			if($category=='proposal'){
    		$this->db->where('rel_id',$id);
    		$this->db->where('rel_type','customer');
    		return $this->db->get('tblproposals')->result();
			}
            if($category=='department'){
            $this->db->select('departmentid,name');
            return $this->db->get('tbldepartments')->result();
            }
              if($category=='priority'){
            return $this->db->get('tbltickets_priorities')->result();
            }
              if($category=='status'){
            return $this->db->get('tbltickets_status')->result();
            }
    	}
    }

        public function getCurrencybyId($id)
    {
        # code...
        if($id){         
            $this->db->where('id', $id);
            $q = $this->db->get('tblcurrencies');
            $data = $q->row();
            $name = $data->name;
            return $name;
        }
    }
          public function getStatusbyId($id)
    {
        # code...
        if($id){         
            $this->db->where('ticketstatusid', $id);
            $q = $this->db->get('tbltickets_status');
            $data = $q->row();
            $name = $data->name;
            return $name;
        }
    }
       public function getAddedfrombyId($id)
    {
        # code...
        if($id){         
            $this->db->where('staffid', $id);
            $q = $this->db->get('tblstaff');
            $data = $q->row();
            $name = $data->firstname ." ". $data->lastname;
            return $name;
        }
    }

         public function getassignedbyId($id)
    {
        # code...
        if($id){         
            $this->db->where('staffid', $id);
            $q = $this->db->get('tblstaff');
            $data = $q->row();
            $name = $data->firstname ." ". $data->lastname;
            return $name;
        }
    }

      public function getcontract_typebyId($id)
    {
        # code...
        if($id){         
            $this->db->where('id', $id);
            $q = $this->db->get('tblcontracts_types');
            $data = $q->row();
            $name = $data->name;
            return $name;
        }
    }
         public function getclientbyId($id)
    {
        # code...
        if($id){         
            $this->db->where('userid', $id);
            $q = $this->db->get('tblclients');
            $data = $q->row();
            $name = $data->company;
            return $name;
        }
    }

}