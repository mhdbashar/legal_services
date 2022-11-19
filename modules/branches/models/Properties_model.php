<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Properties_model extends CRM_Model
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

            return $this->db->get(db_prefix().'properties')->row();
        }

        return $this->db->get(db_prefix().'properties')->result_array();
    }

    /**
     * Add new custom field
     * @param mixed $data All $_POST data
     * @return  boolean
     */
    public function add($data)
    {

        $this->db->insert(db_prefix().'properties', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            logActivity('New Properties Added [' . $data['title'] . ']');

            return $insert_id;
        }

        return false;
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
        $this->db->update(db_prefix().'properties', $data);
        if ($this->db->affected_rows() > 0) {
            logActivity('Properties Updated [' . $data['title'] . ']');
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
        $this->db->delete(db_prefix().'properties');
        if ($this->db->affected_rows() > 0) {
            // Delete the values
            $this->db->where('property_id', $id);
            $this->db->delete(db_prefix().'clientproperties');
            logActivity('Property Deleted [' . $id . ']');

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
}
