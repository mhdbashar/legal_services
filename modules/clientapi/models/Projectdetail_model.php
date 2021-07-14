<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Projectdetail_model extends CI_Model

{

    public function __construct() {

        parent::__construct();

     }


    


  public function get_projectdetail($projectid,$project_detailtype)
     {
      # code...
        if($project_detailtype=='project'){
            $this->db->where('id',$projectid);    
            $this->db->select('*')->from('tblprojects');
        }
        if($project_detailtype=='files'){
             $this->db->where('visible_to_customer','1');
         $this->db->where('project_id',$projectid);    
            $this->db->select('*')->from('tblproject_files');   
        }if($project_detailtype=='discussion'){
            $this->db->where('show_to_customer','1');
                     $this->db->where('project_id',$projectid);    
            $this->db->select('*')->from('tblprojectdiscussions');   
        }
      
       return $this->db->get()->result();

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
    public function getProjectDiscussion($id='')
    {
                     $this->db->where('discussion_id',$id);    
            $this->db->select('*')->from('tblprojectdiscussioncomments');   
        
      
       return $this->db->get()->result();
    }
}