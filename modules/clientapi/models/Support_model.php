<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Support_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getSupportlist($id,$status,$project_id)
    {
    	
        if($id!='' && $status!=''){
            if($project_id!=''){
            $this->db->where('contactid',$id);
            $this->db->where('project_id',$project_id);
            $this->db->where('status',$status);
            $this->db->order_by('ticketid','desc');
            return $this->db->get('tbltickets')->result(); 
            
            }else{
            $this->db->where('contactid',$id);
            $this->db->where('status',$status);
             $this->db->order_by('ticketid','desc');
            return $this->db->get('tbltickets')->result(); 
            }
        }else{
            if($id!=''){
                if($project_id!=''){
            $this->db->where('project_id',$project_id);

            $this->db->where('contactid',$id);
             $this->db->order_by('ticketid','desc');
            return $this->db->get('tbltickets')->result();
                }else{

            $this->db->where('contactid',$id);
             $this->db->order_by('ticketid','desc');
            return $this->db->get('tbltickets')->result();   
                }
        }
        if($status!=''){
            if($project_id!=''){
            $this->db->where('project_id',$project_id);
            $this->db->where('status',$status);
             $this->db->order_by('ticketid','desc');
            return $this->db->get('tbltickets')->result(); 
            }else{
            $this->db->where('status',$status);
             $this->db->order_by('ticketid','desc');
            return $this->db->get('tbltickets')->result();     
            }
            
        }
        }
    }

public function getSupportlistCount($id)
{
    $this->db->select('Count(tbltickets.ticketid) as total,tbltickets_status.name,tbltickets_status.statuscolor,tbltickets_status.statusorder,tbltickets_status.isdefault,tbltickets_status.ticketstatusid');    
$this->db->from('tbltickets_status');
$this->db->join('tbltickets', 'tbltickets.status = tbltickets_status.ticketstatusid AND tbltickets.contactid='. $id, 'left');
$this->db->group_by('tbltickets_status.ticketstatusid'); 
// $this->db->where('contactid',$id);
$query1= $this->db->get();
$query1= $query1->result();
return $query1;

// echo "<pre>";print_r($query1);echo "</pre>";
// die();

// $this->db->select('tbltickets_status.name');    
// $this->db->from('tbltickets');
// $this->db->distinct();
// $this->db->join('tbltickets_status', 'tbltickets.status = tbltickets_status.ticketstatusid');
// $this->db->group_by('tbltickets_status.name'); 
// $this->db->where('contactid',$id);
// $q1= $this->db->get();
// $q1= $q1->result();




// $this->db->select('0 as total,tbltickets_status.name,tbltickets_status.statuscolor,tbltickets_status.statusorder,tbltickets_status.isdefault,tbltickets_status.ticketstatusid');    
// $this->db->from('tbltickets_status');
//  $this->db->where_not_in('tbltickets_status.name',"'".implode("','", array_column($q1,'name'),)."'");

// $query2= $this->db->get();
// $query2= $query2->result();



// $data =array_merge($query1, $query2);
// return $data;
}
    public function getDepartmentbyId($id)
    {
        # code...
        if($id){         
            $this->db->where('departmentid', $id);
            $q = $this->db->get('tbldepartments');
            $data = $q->row();
            $name = $data->name;
            return $name;
        }
    }

    public function get_contact_Name($id)
        {
   
           $this->db->where('id', $id); 
           $q = $this->db->get('tblcontacts'); 
           $data = $q->row();
           $name = $data->firstname .' '. $data->lastname;
           return $name;

        }
    public function getPrioritybyId($id)
    {
        if($id){
             $this->db->where('priorityid', $id);
            $q = $this->db->get('tbltickets_priorities');
            $data = $q->row();
            $name = $data->name;
            return $name;
          
        }
    }
    public function getStatusbyId($id)
    {
         if($id){
              $this->db->where('ticketstatusid', $id);
            $q = $this->db->get('tbltickets_status');
            $data = $q->row();
            $name = $data->name;
            return $name;
           
        }
    }
    public function getProjectbyId($id)
    {
        if($id){
                 $this->db->where('id', $id);
            $q = $this->db->get('tblprojects');
            $data = $q->row();
            $name = $data->name;
            return $name;
          
        }
    }

}