<?php

class Receive_sms_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public $table = 'tblsaved_sms';

    public function get()
    {

    }

    public function is_set($where = '')
    {
        if(is_array($where))
        {
            $this->db->where($where);
            $this->db->from($this->table);
            $num_results = $this->db->count_all_results();
            if($num_results == 0)
                return true;
        }
        return false;
    }

    public function add($data)
    {
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            log_activity('New ' . $this->table . ' added [ID: '.$insert_id.']');
            return $insert_id;
        }
        return false;
    }
}