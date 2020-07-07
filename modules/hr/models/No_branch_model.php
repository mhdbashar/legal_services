<?php

defined('BASEPATH') or exit('No direct script access allowed');

class No_branch_model extends App_Model{

    private $table_name = 'branches_services';

    public function __construct(){
        parent::__construct();
        if(!substr( $this->table_name, 0, 3 ) === "tbl"){
            $this->table_name = 'tbl' . $this->table_name;
        }
    }

    public function get_branch($rel_type, $rel_id)
    {
        $data = [];
        $this->db->where(['rel_id' => $rel_id, 'rel_type' => $rel_type]);
        $branch_id = $this->db->get('tblbranches_services')->row_array()['branch_id'];
        if($branch_id == null){
            $this->add_to_branch($rel_type, $rel_id);
        }
        return $branch_id;
    }
    public function get_general_branch()
    {
            $this->db->where('title_en', 'المركز الرئيسي');
            if($this->db->get('tblbranches')->row())
                $branch_id = $this->db->get('tblbranches')->row()->id;
            else{
                $data = [
                    'title_en' => 'المركز الرئيسي', 
                    'title_ar' => 'المركز الرئيسي', 
                    'city_id' => '338', 
                    'country_id' => '217', 
                    'registraion_number' => '1'
                ];
                $this->db->insert('tblbranches', $data);
                $branch_id = $this->db->insert_id();
            }
            return $branch_id;
    }
    
    public function add_to_branch($rel_type, $rel_id){
        $this->db->insert($this->table_name, [
            'rel_type' => $rel_type, 
            'rel_id' => $rel_id,
            'branch_id' => $this->get_general_branch()
        ]);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            log_activity('New ' . $this->table_name . ' added [ID: '.$insert_id.']');
            return $insert_id;
        }
        return false;
    }
}