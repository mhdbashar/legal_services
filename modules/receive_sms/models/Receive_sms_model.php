<?php

class Receive_sms_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public $table = 'tblsaved_sms';

    public function get($id)
    {
        if(is_numeric($id))
        {
            $this->db->where('id', $id);
            $data = $this->db->get($this->table)->row();
            return $data;
        }
        return false;

    }

    public function is_set($where = '')
    {
        if(is_array($where))
        {
            $this->db->where($where);
            $this->db->from($this->table);
            $num_results = $this->db->count_all_results();
            if($num_results != 0)
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

    public function update($msg_id, $data)
    {
        $this->db->where('msg_id', $msg_id);
        $this->db->update($this->table, $data);
        if($this->db->affected_rows() > 0){
            log_activity($this->table . ' updated [ Message ID: '. $msg_id . ']');
            return true;
        }
        return false;

    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        if ($this->db->affected_rows() > 0) {
            log_activity($this->table . ' Deleted [' . $id . ']');
            return true;
        }

        return false;
    }
}