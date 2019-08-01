<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LegalServicesModel extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_all_services()
    {
        return $this->db->get('my_basic_services')->result();
    }
    public function get_service_by_id($ServID)
    {
        return $this->db->get_where('my_basic_services', array('id' => $ServID));
    }
    public function get_service_id_by_slug($slug)
    {
        return $this->db->get_where('my_basic_services', array('slug' => $slug))->row()->id;
    }
    public function CheckExistCategory($CatID)
    {
        return $this->db->get_where('my_categories', array('id' => $CatID))->num_rows();
    }
    public function CheckExistService($ServID)
    {
        return $this->db->get_where('my_basic_services', array('id' => $ServID))->num_rows();
    }

    public function ActivePrimary($ServID)
    {
        $old_stat = $this->get_service_by_id($ServID)->row()->is_primary;
        $new_stat = $old_stat == 0 ? 1 : 0;
        $this->db->set('is_primary', $new_stat);
        $this->db->where('id', $ServID);
        $this->db->update('my_basic_services');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
    public function InsertServices($data)
    {
        $data['datecreated'] = date('Y-m-d H:i:s');
        $data['slug'] = slug_it($data['name']);
        $this->db->insert('my_basic_services', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Service Added [ServID: ' . $insert_id . ']');
        }
        return $insert_id;
    }
    public function update_service_data($ServID,$data)
    {
        $data['slug'] = slug_it($data['name']);
        $this->db->where('id', $ServID);
        $this->db->update('my_basic_services', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Service Updated [ServID: ' . $ServID . ']');
            return true;
        }
        return false;
    }
    public function delete_service($ServID)
    {
        $this->db->where('id', $ServID);
        $this->db->delete('my_basic_services');
        if ($this->db->affected_rows() > 0) {
            log_activity('Service Deleted [ServID: ' . $ServID . ']');
            return true;
        }
        return false;
    }
    public function GetCategoryByServId($ServID)
    {
        return $this->db->get_where('my_categories', array('service_id' => $ServID , 'parent_id' => 0))->result();
    }
    public function GetCategoryById($CatID)
    {
        return $this->db->get_where('my_categories', array('id' => $CatID));
    }
    public function GetChildByCategory($CatID)
    {
        return $this->db->get_where('my_categories', array('parent_id' => $CatID))->result();
    }
    public function InsertCategory($ServID,$data)
    {
        $data['datecreated'] = date('Y-m-d H:i:s');
        $data['service_id']  = $ServID;
        $this->db->insert('my_categories', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Category Added [CatID: ' . $insert_id . ']');
        }
        return $insert_id;
    }
    public function InsertChildCategory($ServID,$CatID,$data)
    {
        $data['datecreated'] = date('Y-m-d H:i:s');
        $data['parent_id']   = $CatID;
        $data['service_id']  = $ServID;
        $this->db->insert('my_categories', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New SubCategory Added [CatID: ' . $insert_id . ']');
        }
        return $insert_id;
    }
    public function update_category_data($CatID,$data)
    {
        $this->db->where('id', $CatID);
        $this->db->update('my_categories', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Category Updated [CatID: ' . $CatID . ']');
            return true;
        }
        return false;
    }
    public function delete_category($CatID)
    {
        $this->db->delete('my_categories', ['id' => $CatID]);
        if ($this->db->affected_rows() > 0) {
            log_activity('Category Deleted [CatID: ' . $CatID . ']');
        }
        $query = $this->db->where('parent_id', $CatID)->get('my_categories');
        foreach( $query->result() as $Child ) {
            $this->delete_category($Child->id);
        }
        return true;
    }
}
