<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Clientprofile_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getClientprofile($id,$type)
    {
    	if($id!=''){
    		if($type=='profile'){
    		$this->db->where('userid',$id);
    		return $this->db->get('tblcontacts')->result();
            }
            if($type=='company'){
            $this->db->where('userid',$id);
            return $this->db->get('tblclients')->result();
            }
			
    	}
    }

    public function update_clientdata($userid,$updatedata)
    {
        if($updatedata!=''){
            
                $this->db->where('userid',$userid);
                $this->db->update('tblcontacts',$updatedata);

                 $this->db->where('userid', $userid);
            $q = $this->db->get('tblcontacts');
            $data = $q->row();
            $name = $data->id;
            return $name;
               
        
        }else{
            return 0;
        }
    }

    public function getCountrybyId($id)
    {
        # code...
        if($id){         
            $this->db->where('country_id', $id);
            $q = $this->db->get('tblcountries');
            $data = $q->row();
            $name = $data->short_name;
            return $name;
        }
    }

}