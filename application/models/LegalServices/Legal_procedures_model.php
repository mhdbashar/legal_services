<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Legal_procedures_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('contracts_model');
    }

    public function get($id = '', $where = [])
    {
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            $this->db->get(db_prefix() . 'my_categories')->row();
        }
        return $this->db->get(db_prefix() . 'my_categories')->result_array();
    }

    public function add($parent_id, $data)
    {
        $data['datecreated'] = date('Y-m-d H:i:s');
        if(isset($parent_id) && $parent_id != ''):
            $data['parent_id'] = $parent_id;
        endif;
        $this->db->insert('my_categories', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Category Added [CatID: ' . $insert_id . ']');
        }
        return $insert_id;
    }

    public function add_list($data)
    {
        $check = $this->db->get_where('legal_procedures_lists', array('cat_id' => $data['cat_id'] ,'rel_id' => $data['rel_id']  ,'rel_type' => $data['rel_type']))->num_rows();
        if($check > 0){
            return false;
        }else{
            $data['datecreated'] = date('Y-m-d H:i:s');
            $this->db->insert('legal_procedures_lists', $data);
            $insert_id = $this->db->insert_id();
            if ($insert_id) {
                log_activity('New Legal procedure list Added [ID: ' . $insert_id . ']');
            }
            return $insert_id;
        }
    }

    public function add_legal_procedure($data)
    {
        $contract_data = array();
        $data['datecreated'] = date('Y-m-d H:i:s');
        if(isset($data['cat_id'])):
            unset($data['cat_id']);
        endif;
        $contract_data['type_id'] = 2;
        $ref_id = $this->contracts_model->add($contract_data);
        if ($ref_id) {
            $data['reference_id'] = $ref_id;
            $this->db->insert(db_prefix() . 'legal_procedures', $data);
            $insert_id = $this->db->insert_id();
            if ($insert_id) {
                log_activity('New legal procedure Added [ID: ' . $insert_id . ']');
            }
            return $insert_id;
        }
        return false;
    }


    public function delete_procedure($id)
    {
        $this->db->where(array('id' => $id));
        $this->db->delete(db_prefix() . 'legal_procedures');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function get_lists_procedure($id = '', $where = [])
    {
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            $this->db->select(db_prefix() . 'legal_procedures_lists.*,cat.name AS cat_name');
            $this->db->join(db_prefix() . 'my_categories AS cat', 'cat.id = ' . db_prefix() . 'legal_procedures_lists.cat_id', 'left');
            return $this->db->get(db_prefix() . 'legal_procedures_lists')->row();
        }
        $this->db->select(db_prefix() . 'legal_procedures_lists.*,cat.name AS cat_name');
        $this->db->join(db_prefix() . 'my_categories AS cat', 'cat.id = ' . db_prefix() . 'legal_procedures_lists.cat_id', 'left');
        return $this->db->get(db_prefix() . 'legal_procedures_lists')->result_array();
    }



}