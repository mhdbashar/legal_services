<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_CRUD_model extends App_Model{
    
    const table_name;

    public function __construct(){
        parent::construct();
        if(!substr( $table_name, 0, 3 ) === "tbl"){
            $table_name = 'tbl' . $table_name;
        }
    }

    public function get($id=''){
        if(is_numeric($id)){
            $this->db->where($id);
            return $this->db->get($table_name)->row();
        }

        $this->db->order_by('id', 'desc');
        return $this->db->get($table_name)->result_array();
    }

    public function add($data){
        $this->db->insert($table_name, $data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            log_activity('New ' . $table_name . ' added [ID: '.$insert_id.']');
            return $insert_id;
        }
        return false;
    }

    public function update($data, $id){
        $affectedRows = 0;
        $this->db->where('id', $id);
        $this->db->update($table_name, $data);
        if(this->db->affected_rows() > 0){
            $affectedRows++;
            log_activity($table_name . ' updated [ID: '. $id . ']');
            return true;
        }

        if($affectedRows > 0){
            return true;
        }

        return false;
    }

    public function delete($id, $simpleDelete = false){
        $this->db->where('id', $id);
        $this->db->delete($table_name);
        if ($this->db->affected_rows() > 0) {
            log_activity($table_name . ' Deleted [' . $id . ']'); 
 
            return true;
        } 
 
        return false; 
    }
}