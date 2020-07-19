<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Branches_model extends App_Model
{
    private $pdf_fields = ['title'];
    private $client_portal_fields = [];
    private $client_editable_fields = [];
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * @param  integer (optional)
     * @return object
     * Get single custom field
     */
    public function get($id = false)
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get('tblbranches')->row();
        }
        return $this->db->get('tblbranches')->result_array();
    }


    public function get_staffs_by_branch_id($client_id){
        $this->db->where(['rel_type' => 'clients', 'rel_id' => $client_id]);
        $branch = $this->db->get('tblbranches_services')->row();
        if(is_object($branch)){
            $branch_id = $this->db->get('tblbranches_services')->row()->branch_id;
            $this->db->where(['branch_id' => $branch_id, 'rel_type' => 'staff']);
            $this->db->join('tblstaff', 'tblstaff.staffid = tblbranches_services.rel_id', 'inner');
            $staffs = $this->db->get('tblbranches_services')->result_array();
            return $staffs;
        }
        $this->db->order_by('firstname', 'desc');

        return $this->db->get(db_prefix() . 'staff')->result_array();
    }

    public function delete_branch($rel_type, $rel_id){
        $this->db->where(['rel_id'=> $rel_id, 'rel_type' => $rel_type]);
        $this->db->delete('tblbranches_services');
        if ($this->db->affected_rows() > 0) {
            // Delete the values
            log_activity('Branches Services Deleted [' . $rel_id . ']');
            return true;
        }
        return false;
    }
    /**
     * Add new custom field
     * @param mixed $data All $_POST data
     * @return  boolean
     */
    public function add($data)
    {
        $this->db->insert('tblbranches', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Branches Added [' . $data['title_en'] . ']');
            return $insert_id;
        }
        return false;
    }
    
    public function set_branch($data)
    {
        $this->db->insert('tblbranches_services', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            log_activity('Add Branch ['. $data['branch_id'] .'] To '.$data['rel_type'].' [' . $data['rel_id'] . ']');
            return $insert_id;
        }
        return false;
    }

    public function update_branch($rel_type, $rel_id, $branch_id)
    {
        $this->db->where(['rel_id'=> $rel_id, 'rel_type' => $rel_type]);
        $this->db->update('tblbranches_services', ['branch_id' => $branch_id]);

        if ($this->db->affected_rows() > 0) {
            log_activity('Update Branch In '.$rel_type.' [' . $rel_id . ']');
            return true;
        }
        $this->set_branch(['rel_type' => $rel_type, 'rel_id' => $rel_id, 'branch_id' => $branch_id]);
    }

    public function get_branch($rel_type, $rel_id)
    {
        $data = [];
        $this->db->where(['rel_id' => $rel_id, 'rel_type' => $rel_type]);
        $branch_id = $this->db->get('tblbranches_services')->row_array()['branch_id'];
        
        return $branch_id;
    }

    public function get_branch_name($rel_type, $rel_id)
    {
        $branch_id = $this->get_branch($rel_type, $rel_id);
        $this->db->where(['id' => $branch_id]);
        return $this->db->get('tblbranches')->row_array()['title_en'];
    }
    /**
     * Update custom field
     * @param mixed $data All $_POST data
     * @return  boolean
     */
    public function update($data, $id)
    {
        $original_field = $this->get($id);
        $this->db->where('id', $id);
        $this->db->update('tblbranches', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Branches Updated [' . $data['title_en'] . ']');
            return true;
        }
        return false;
    }
    /**
     * @param  integer
     * @return boolean
     * Delete Custom fields
     * All values for this custom field will be deleted from database
     */
    public function delete($id, $transfer_data_to)
    {
        $this->db->where('branch_id', $id);
        $this->db->update('tblbranches_services', ['branch_id' => $transfer_data_to]);
        $this->db->where('id', $id);
        $this->db->delete('tblbranches');
        if ($this->db->affected_rows() > 0) {
            // Delete the values
            log_activity('Branch Deleted [' . $id . ']');
            return true;
        }
        return false;
    }
    /**
     * Return field where Shown on PDF is allowed
     * @return array
     */
    public function get_pdf_allowed_fields()
    {
        return $this->pdf_fields;
    }
    /**
     * Return fields where Show on customer portal is allowed
     * @return array
     */
    public function get_client_portal_allowed_fields()
    {
        return $this->client_portal_fields;
    }
    /**
     * Return fields where are editable in customers area
     * @return array
     */
    public function get_client_editable_fields()
    {
        return $this->client_editable_fields;
    }
    public function getCountries()
    {
        $data = [];
        $rows = $this->db->get('tblcountries')->result_array();
        foreach ($rows as $row) {
            $data[] = ['key'=>$row['country_id'],'value'=>$row['short_name']];
        }
        return $data;
    }
    public function getCitiesForCountry($country_id)
    {
        $data = [];
        $this->db->where('country_id', $country_id);
        $rows = $this->db->get('tblcities')->result_array();
        foreach ($rows as $row) {
            $data[] = ['key' => $row['Id'], 'value' => $row['Name_en']];
        }
        return $data;
    }
    public function getDepatrmentsForBranches($branch_id)
    {
        $data = [];
        if(!$this->app_modules->is_active('branches')){
            $departments = $this->db->get('tbldepartments')->result_array();
            foreach ($departments as $department) {
                $data[] = ['key' => $department['departmentid'], 'value' => $department['name']];
            }
        }else{
            $this->db->where(['branch_id' => $branch_id, 'rel_type' => 'departments']);
            $rows = $this->db->get('tblbranches_services')->result_array();
            foreach ($rows as $row) {
                $this->db->where(['departmentid' => $row['rel_id']]);
                $r = $this->db->get('tbldepartments')->row_array();
                $data[] = ['key' => $r['departmentid'], 'value' => $r['name']];
            }
        }
        
        return $data;
    }
    public function get_office_shift($branch_id)
    {
        $data = [];
        if(!$this->app_modules->is_active('branches')){
            $office_shifts = $this->db->get('tblhr_office_shift')->result_array();
            foreach ($office_shifts as $office_shift) {
                $data[] = ['key' => $office_shift['id'], 'value' => $office_shift['shift_name']];
            }
        }else{
            $this->db->where(['branch_id' => $branch_id, 'rel_type' => 'office_shift']);
            $rows = $this->db->get('tblbranches_services')->result_array();
            foreach ($rows as $row) {
                $this->db->where(['id' => $row['rel_id']]);
                $r = $this->db->get('tblhr_office_shift')->row_array();
                $data[] = ['key' => $r['id'], 'value' => $r['shift_name']];
            }
        }
        
        return $data;
    }
    public function getBranches()
    {
        $data = [];
        $rows = $this->db->get('tblbranches')->result_array();
        foreach ($rows as $row) {
            if(get_staff_default_language() == 'arabic'){
                $title = 'title_ar';
            }else{
                $title ='title_ar';
            }
            $data[] = ['key'=>$row['id'],'value'=>$row[$title]];
        }
        return $data;
    }

}