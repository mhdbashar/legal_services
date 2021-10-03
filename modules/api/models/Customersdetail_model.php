<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Customersdetail_model extends CI_Model

{

    public function __construct() {

        parent::__construct();

     }

        public function getcustomerinvoice($filters)
        {
            $this->db->select('id,number,prefix,date,currency,subtotal,total_tax,total,hash,duedate,status')->from('tblinvoices');
            $this->db->where('clientid',$filters['customer_id']);
            //$this->db->limit($filters['limit'], ($filters['start']-1));
            return $this->db->get()->result();
         # code...
        }
       public function getcustomerestimate($filters)
        {
            $this->db->select('id,number,prefix,date,currency,subtotal,total_tax,total,hash,status,expirydate,addedfrom')->from('tblestimates');
            $this->db->where('clientid',$filters['customer_id']);
            //$this->db->limit($filters['limit'], ($filters['start']-1));
            return $this->db->get()->result();
         # code...
        }
        public function getestimatecount($filters)
        {
             
            $this->db->select('tblestimates.status,COUNT(*) as total')->from('tblestimates');
            $this->db->where('clientid',$filters['customer_id']);
            $this->db->group_by('tblestimates.status');
            //$this->db->limit($filters['limit'], ($filters['start']-1));
            return $this->db->get()->result();
        }
        public function getcustomerproject($filters)
        {
            if($filters['typeof']=='customer'){
            $this->db->select('*')->from('tblprojects');
            $this->db->where('clientid',$filters['customer_id']);
            $this->db->order_by('id','desc');
            //$this->db->limit($filters['limit'], ($filters['start']-1));
            return $this->db->get()->result();
        }else{

             $this->db->select('*')->from('tblprojects');
            $this->db->order_by('id','desc');
            //$this->db->limit($filters['limit'], ($filters['start']-1));
            return $this->db->get()->result();
        }
         # code...
        
        }

        public function getExtraField($id='')
        {
            $this->db->select('tblcustomfields.name,tblcustomfieldsvalues.value')->from('tblcustomfieldsvalues');
            $this->db->where('tblcustomfieldsvalues.relid',$id);
            $this->db->where('tblcustomfieldsvalues.fieldto','projects');
            $this->db->join('tblcustomfields','tblcustomfields.id=tblcustomfieldsvalues.fieldid');
            return $this->db->get()->result();
        }
        public function getTagsField($id='')
        {
            $this->db->select('tbltaggables.tag_id,tbltaggables.tag_order,tbltags.name')->from('tbltaggables');
            $this->db->where('tbltaggables.rel_id',$id);
            $this->db->where('tbltaggables.rel_type','project');
            $this->db->join('tbltags','tbltaggables.tag_id=tbltags.id');
            $this->db->order_by('tbltaggables.tag_order','asc');
            return $this->db->get()->result();
        }
        public function getcustomerprojectmember($id)
        {
             $this->db->select('tblproject_members.id,tblproject_members.project_id,tblproject_members.staff_id,tblstaff.profile_image')->from('tblproject_members');
            $this->db->join('tblstaff', 'tblproject_members.staff_id = tblstaff.staffid');
            $this->db->where('tblproject_members.project_id',$id);
            //$this->db->limit($filters['limit'], ($filters['start']-1));
            return $this->db->get()->result();
        }
          public function getcustomercontact($filters)
        {
             $this->db->select('id,userid,is_primary,firstname,lastname,email,phonenumber,datecreated,active,last_login')->from('tblcontacts');
            $this->db->where('userid',$filters['customer_id']);
            //$this->db->limit($filters['limit'], ($filters['start']-1));
            return $this->db->get()->result();
        }
        public function getdiscussionDetail($filters)
        {
            $this->db->select('*')->from('tblprojectdiscussions');
            $this->db->where('project_id',$filters['customer_id']);
            //$this->db->limit($filters['limit'], ($filters['start']-1));
            return $this->db->get()->result();
        }

public function getComments($id='')
{
      $this->db->select('*')->from('tblprojectdiscussioncomments');
            $this->db->where('discussion_id',$id);
            //$this->db->limit($filters['limit'], ($filters['start']-1));
            return $this->db->get()->result();
}

         public function getcustomerfile($filters)
        {
            if($filters['typeof']=='project'){
            $this->db->select('*')->from('tblproject_files');
            $this->db->where('project_id',$filters['customer_id']);
            $this->db->order_by('id','desc');
            //$this->db->limit($filters['limit'], ($filters['start']-1));
            return $this->db->get()->result();
            }
        else{
            $this->db->select('id,rel_id,rel_type,file_name,filetype,visible_to_customer,dateadded')->from('tblfiles');
            $this->db->where('rel_id',$filters['customer_id']);
            $this->db->where('rel_type','customer');
                        $this->db->order_by('id','desc');

            //$this->db->limit($filters['limit'], ($filters['start']-1));
            return $this->db->get()->result();
}

            
        }
       
}