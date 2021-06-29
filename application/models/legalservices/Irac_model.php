<?php defined('BASEPATH') or exit('No direct script access allowed');

class Irac_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('legalservices/Cases_model', 'case');
        $this->load->model('legalservices/Other_services_model', 'other');
        $this->load->model('legalservices/LegalServicesModel', 'legal');
    }

    public function get($id = '', $where = []){
        $this->db->where($where);
        if(is_numeric($id)){
            $this->db->where('id' ,$id);
            return $this->db->get(db_prefix() . 'irac_method')->row();
        }
        return $this->db->get(db_prefix() . 'irac_method')->row();
    }

    public function update($ServID, $id, $data)
    {
        $rel_type = get_legal_service_slug_by_id($ServID);
        $data['rel_id']   = $id;
        $data['rel_type'] = $rel_type;
        $row = $this->get('', ['rel_id' => $id, 'rel_type' => $rel_type]);
        if ($row) {
            $this->db->where(['rel_id' => $id, 'rel_type' => $rel_type]);
            $this->db->update(db_prefix() . 'irac_method', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
            return false;
        }
        $this->db->insert(db_prefix() . 'irac_method', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            return true;
        }
        return false;
    }
}