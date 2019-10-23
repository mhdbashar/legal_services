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
        $data['slug'] = slug_it($data['name'], ['separator' => '_']);

        $this->db->insert('my_basic_services', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Legal Service Added [ServID: ' . $insert_id . ']');
        }
        return $insert_id;
    }

    public function update_service_data($ServID,$data)
    {
        $this->db->where('id', $ServID);
        $this->db->update('my_basic_services', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Legal Service Updated [ServID: ' . $ServID . ']');
            return true;
        }
        return false;
    }

    public function delete_service($ServID)
    {
        $this->db->where('id', $ServID);
        $this->db->delete('my_basic_services');
        if ($this->db->affected_rows() > 0) {
            log_activity('Legal Service Deleted [ServID: ' . $ServID . ']');
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

    public function restore_from_recycle_bin($ServID,$id)
    {
        $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
        $ServiceName = $this->legal->get_service_by_id($ServID)->row()->name;

        $text  = $ServID == 1 ? 'Case' : $ServiceName;
        $table = $ServID == 1 ? 'my_cases' : 'my_other_services';
        $where = $ServID == 1 ? $this->db->where(array('id' => $id, 'deleted' => 1)) : $this->db->where(array('id' => $id, 'deleted' => 1, 'service_id' => $ServID));

        $this->db->set('deleted', 0);
        $where;
        $this->db->update(db_prefix() . $table);
        if ($this->db->affected_rows() > 0) {

            $this->db->where(array('rel_id' => $id, 'rel_type' => $slug , 'deleted' => 1));
            $this->db->update(db_prefix() . 'tasks', [
                'deleted' => 0,
            ]);

            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug , 'deleted' => 1));
            $this->db->update(db_prefix() . 'expenses', [
                'deleted' => 0,
            ]);

            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug , 'deleted' => 1));
            $this->db->update(db_prefix() . 'invoices', [
                'deleted' => 0,
            ]);

            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug , 'deleted' => 1));
            $this->db->update(db_prefix() . 'creditnotes', [
                'deleted' => 0,
            ]);

            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug , 'deleted' => 1));
            $this->db->update(db_prefix() . 'estimates', [
                'deleted' => 0,
            ]);

            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug, 'deleted' => 1));
            $this->db->update(db_prefix() . 'tickets', [
                'deleted' => 0,
            ]);

            log_activity($text.' Restore From Recycle Bin [CaseID: ' . $id . ']');
            return true;
        }
        return false;
    }

    public function confirm_empty_recycle_bin()
    {
        $this->db->where('deleted =', 1);
        $cases = $this->db->get(db_prefix() . 'my_cases')->num_rows();
        if($cases > 0){
            $this->db->set('deleted', 2);
            $this->db->where('deleted', 1);
            $this->db->update(db_prefix() . 'my_cases');
            if ($this->db->affected_rows() > 0) {
                log_activity(' Confirm Empty Legal Services Recycle Bin');
                return true;
            }
        }

        $this->db->where('deleted =', 1);
        $oservices = $this->db->get(db_prefix() . 'my_other_services')->num_rows();
        if($oservices > 0){
            $this->db->set('deleted', 2);
            $this->db->where('deleted', 1);
            $this->db->update(db_prefix() . 'my_other_services');
            if ($this->db->affected_rows() > 0) {
                log_activity(' Confirm Empty Legal Services Recycle Bin');
                return true;
            }
        }
        return false;
    }
}
