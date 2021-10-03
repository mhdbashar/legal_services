<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Discussion_model extends CI_Model

{

    public function __construct() {

        parent::__construct();

        }


public function InsertData($data)
{
    if($data){
        $this->db->insert('tblprojectdiscussions',$data);
        $insert_id = $this->db->insert_id();
         return  $insert_id;
    }
    return 0;
    # code...
}

public function DiscussionCommentInsert($data)
{

        if($data){
         
        $this->db->insert('tblprojectdiscussioncomments',$data);
     $insert_id = $this->db->insert_id();
         return  $insert_id;   
         
    }
    return 0;
}
   
}