<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Countries_model extends App_Model{

    private $table_name = 'tblcountries';

    public function __construct(){
        parent::__construct();
        if(!substr( $this->table_name, 0, 3 ) === "tbl"){
            $this->table_name = 'tbl' . $this->table_name;
        }
    }

    public function get($id=''){
        if(is_numeric($id)){
            $this->db->where('country_id' ,$id);
            return $this->db->get($this->table_name)->row();
        }

        $this->db->order_by('country_id', 'desc');
        return $this->db->get($this->table_name)->result_array();
    }

    public function add($data){
        $this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            log_activity('New ' . $this->table_name . ' added [ID: '.$insert_id.']');
            return $insert_id;
        }
        return false;
    }

    public function update_country($data, $id){
        $this->db->where('country_id', $id);
        $this->db->update($this->table_name, $data);
        if($this->db->affected_rows() > 0){
            log_activity($this->table_name . ' updated [Country ID: '. $id . ']');
            return true;
        }
        return false;
    }

    public function add_country($data){
        $this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        if($this->db->affected_rows() > 0){
            log_activity($this->table_name . ' Added [Country ID: '. $insert_id . ']');
            return true;
        }
        return false;
    }

    public function delete($id, $simpleDelete = false){
        $this->db->where('country_id', $id);
        $this->db->delete($this->table_name);
        if ($this->db->affected_rows() > 0) {
            log_activity($this->table_name . ' Deleted [' . $id . ']');

            return true;
        }

        return false;
    }
}