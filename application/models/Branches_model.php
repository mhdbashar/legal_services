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
            log_activity('New Branches Added [' . $data['title'] . ']');
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
        if (!is_numeric($this->get_branch($rel_type, $rel_id))){
            $data = [
                'branch_id' => $branch_id, 
                'rel_type' => 'clients', 
                'rel_id' => $rel_id
            ];
            $this->Branches_model->set_branch($data);
        }
        return false;
    }
    public function get_branch($rel_type, $rel_id)
    {
        $data = [];
        $this->db->where(['rel_id' => $rel_id, 'rel_type' => $rel_type]);
        $branch_id = $this->db->get('tblbranches_services')->row_array()['branch_id'];
        if($branch_id){
            return $branch_id;
        }
        return false;
    }
    /** vvvv vvvvccc639
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
            log_activity('Branches Updated [' . $data['title'] . ']');
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
    public function delete($id)
    {
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
    public function getBranches()
    {
        $data = [];
        $rows = $this->db->get('tblbranches')->result_array();
        foreach ($rows as $row) {
            $data[] = ['key'=>$row['id'],'value'=>$row['title_en']];
        }
        return $data;
    }

}