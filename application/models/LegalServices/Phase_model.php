<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Phase_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/Cases_model', 'case');
        $this->load->model('LegalServices/Other_services_model', 'other');
        $this->load->model('LegalServices/LegalServicesModel', 'legal');
    }

	public function get_all($where = [])
    {
        $this->db->where($where);
		return $this->db->get_where(db_prefix() . 'my_service_phases', array('is_active' => 1, 'deleted' => 0))->result();
    }

    public function get($id)
    {
        return $this->db->get_where(db_prefix() . 'my_service_phases', array('id' => $id , 'deleted' => 0))->row();
    }

	public function add($data)
    {
        $this->db->insert(db_prefix() . 'my_service_phases', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $upData = ['slug' =>'legal_phase_'.$insert_id];
            $this->db->where('id', $insert_id);
            $this->db->update(db_prefix() . 'my_service_phases', $upData);
            log_activity('New Phase Added [PhaseID: ' . $insert_id . ']');
        }
        return $insert_id;
    }

	public function update($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('my_service_phases', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Phase Updated [PhaseID: ' . $id . ']');
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        $this->db->set('deleted', 1);
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'my_service_phases');
        if ($this->db->affected_rows() > 0) {
            log_activity('Phase Deleted [PhaseID: ' . $id . ']');
            return true;
        }
        return false;
    }

    public function changeStatus($id)
    {
        $old_stat = $this->db->get_where(db_prefix() . 'my_service_phases', array('id' => $id))->row()->is_active;
        $new_stat = $old_stat == 0 ? 1 : 0;
        $this->db->set('is_active', $new_stat);
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'my_service_phases');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    function handle_phase_data($ServID, $project_id, $data)
    {
        if (isset($data['project_percent'])) {
            unset($data['project_percent']);
        }
        if (isset($data['rel_sid'])) {
            unset($data['rel_sid']);
        }
        if (isset($data['name'])) {
            unset($data['name']);
        }
        if (isset($data['due_date'])) {
            unset($data['due_date']);
        }
        if (isset($data['description'])) {
            unset($data['description']);
        }
        if (isset($data['milestone_order'])) {
            unset($data['milestone_order']);
        }
        if (isset($data['legal_phase'])) {
            $legal_phase = $data['legal_phase'];
            unset($data['legal_phase']);
        }

        $slug             = $this->legal->get_service_by_id($ServID)->row()->slug;
        $affectedRows     = 0;
        $data['rel_id']   = $project_id;
        $data['rel_type'] = $slug;

        foreach ($legal_phase as $phase_id):
            if (isset($data['custom_fields'])) {
                $custom_fields = $data['custom_fields'];
                if (handle_custom_fields_post($project_id, $custom_fields)) {
                    $affectedRows++;
                }
                unset($data['custom_fields']);
            }
            $this->db->where('phase_id', $phase_id);
            $this->db->where('rel_id', $project_id);
            $this->db->where('rel_type', $slug);
            $row = $this->db->get(db_prefix() . 'my_phase_data')->row();
            if($row){
                $this->db->where('phase_id', $phase_id);
                $this->db->where('rel_id', $project_id);
                $this->db->where('rel_type', $slug);
                $this->db->update(db_prefix() . 'my_phase_data', $data);
                if ($this->db->affected_rows() > 0) {
                    $affectedRows++;
                    log_activity('Phase Data Updated [rel_id: ' . $project_id . ' rel_type ' .$slug. ']');
                }
            }else{
                $data['phase_id'] = $phase_id;
                $this->db->insert(db_prefix() . 'my_phase_data', $data);
                $insert_id = $this->db->insert_id();
                if ($insert_id) {
                    $affectedRows++;
                    log_activity('New Phase Data Added [PhaseID: ' . $insert_id . ']');
                }
            }
        endforeach;
        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

    public function return_to_previous_phase($relid, $slug1, $slug2)
    {
        $affectedRows = 0;
        $result1 = $this->db->get_where(db_prefix() . 'customfieldsvalues', array('relid' => $relid, 'fieldto' => $slug1))->result();
        foreach ($result1 as $row1){

            //$this->db->set('relid', $row1->relid);
            $this->db->where('relid', $row1->relid);
            $this->db->where('fieldto', $row1->fieldto);
            $this->db->delete(db_prefix() . 'customfieldsvalues');
            $affectedRows++;
        }

        if(isset($slug2) || $slug2 != null){
            $result2 = $this->db->get_where(db_prefix() . 'customfieldsvalues', array('relid' => $relid, 'fieldto' => $slug2))->result();
            foreach ($result2 as $row2){
                //$this->db->set('relid', $row2->relid);
                $this->db->where('relid', $row2->relid);
                $this->db->where('fieldto', $row2->fieldto);
                $this->db->delete(db_prefix() . 'customfieldsvalues');
                $affectedRows++;
            }
        }

        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

}
