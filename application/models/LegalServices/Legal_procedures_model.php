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
        $contract_data['subject'] = get_cat_name_by_id($data['subcat_id']);
        $contract_data['type_id'] = 2;
        $contract_data['datestart'] = date('Y-m-d');
        $contract_data['contract_type'] = 0;
        $contract_data['client'] = get_staff_user_id();
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


///////////////////////////////////////////////////////
    /* Contract Controlletr */

    /**
     * Get contract/s
     * @param  mixed  $id         contract id
     * @param  array   $where      perform where
     * @param  boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get_contract($id = '', $where = [], $for_editor = false)
    {
        $this->db->select('*,' /*. db_prefix() . 'contracts_types.name as type_name,' */. db_prefix() . 'contracts.id as id, ' . db_prefix() . 'contracts.addedfrom');
        $this->db->where($where);
        //$this->db->join(db_prefix() . 'contracts_types', '' . db_prefix() . 'contracts_types.id = ' . db_prefix() . 'contracts.contract_type', 'left');
        //$this->db->join(db_prefix() . 'clients', '' . db_prefix() . 'clients.userid = ' . db_prefix() . 'contracts.client');
        if (is_numeric($id)) {
            $this->db->where(db_prefix() . 'contracts.id', $id);
            $contract = $this->db->get(db_prefix() . 'contracts')->row();
            if ($contract) {
                $contract->attachments = $this->contracts_model->get_contract_attachments('', $contract->id);
                if ($for_editor == false) {
                    $this->load->library('merge_fields/client_merge_fields');
                    $this->load->library('merge_fields/contract_merge_fields');
                    $this->load->library('merge_fields/other_merge_fields');

                    $merge_fields = [];
                    $merge_fields = array_merge($merge_fields, $this->contracts_model->contract_merge_fields->format($id));
                    $merge_fields = array_merge($merge_fields, $this->contracts_model->client_merge_fields->format($contract->client));
                    $merge_fields = array_merge($merge_fields, $this->contracts_model->other_merge_fields->format());
                    foreach ($merge_fields as $key => $val) {
                        if (stripos($contract->content, $key) !== false) {
                            $contract->content = str_ireplace($key, $val, $contract->content);
                        } else {
                            $contract->content = str_ireplace($key, '', $contract->content);
                        }
                    }
                }
            }

            return $contract;
        }
        $contracts = $this->db->get(db_prefix() . 'contracts')->result_array();
        $i         = 0;
        foreach ($contracts as $contract) {
            $contracts[$i]['attachments'] = $this->contracts_model->get_contract_attachments('', $contract['id']);
            $i++;
        }

        return $contracts;
    }

}