<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Locks_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_password($rel_sid, $rel_stype)
    {
        $this->db->select('password');
        $this->db->where(array('rel_sid' => $rel_sid,'rel_stype' => $rel_stype));
        return $this->db->get(db_prefix() .'my_locks_services')->row()->password;
    }

    public function add($password, $rel_sid, $rel_stype)
    {
        $data = array(
            'password' => $password,
            'rel_sid' => $rel_sid,
            'rel_stype' => $rel_stype
        );
        $this->db->insert(db_prefix() . 'my_locks_services', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity ('Service are locked [id: ' . $insert_id . ' reltype: ' . $rel_stype . 'relid: ' . $rel_sid . ']');
            return $insert_id;
        }
        return false;
    }

    public function update($password, $rel_sid, $rel_stype)
    {
        $this->db->set('password', $password);
        $this->db->where(array('rel_sid' => $rel_sid,'rel_stype' => $rel_stype));
        $this->db->update(db_prefix() . 'my_locks_services');
        if ($this->db->affected_rows() > 0) {
            log_activity('Service locked Updated [reltype: ' . $rel_stype . 'relid: ' . $rel_sid . ']');
            return true;
        }
        return false;
    }

    public function unlock($password, $rel_sid, $rel_stype)
    {
        $this->db->set('locked', 0);
        $this->db->where(array('rel_sid' => $rel_sid,'rel_stype' => $rel_stype, 'password' => $password['password']));
        $this->db->update(db_prefix() . 'my_locks_services');
        if ($this->db->affected_rows() > 0) {
            log_activity('The service lock has been opened [reltype: ' . $rel_stype . 'relid: ' . $rel_sid . ']');
            return true;
        }
        return false;
    }

    public function lock($rel_sid, $rel_stype)
    {
        $this->db->set('locked', 1);
        $this->db->where(array('rel_sid' => $rel_sid, 'rel_stype' => $rel_stype));
        $this->db->update(db_prefix() . 'my_locks_services');
        if ($this->db->affected_rows() > 0) {
            log_activity('The service lock has been closed [reltype: ' . $rel_stype . 'relid: ' . $rel_sid . ']');
            return true;
        }
        return false;
    }

    public function check_services_if_has_password($rel_sid, $rel_stype)
    {
        $num_rows = $this->db->get_where(db_prefix() .'my_locks_services', array('rel_sid' => $rel_sid, 'rel_stype' => $rel_stype, 'locked' => 1))->num_rows();
        return $num_rows > 0 ? TRUE : FALSE;
    }
}