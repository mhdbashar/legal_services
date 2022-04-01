<?php

class Sheets_model extends App_Model
{
    private $table_name = 'tblmy_googlesheets';

    public function __construct()
    {
        parent::__construct();
    }

    public function add($data)
    {
        $this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            log_activity('New ' . $this->table_name . ' added [ID: '.$insert_id.']');
            return $insert_id;
        }
        return false;
    }

    public function delete($id)
    {
        $this->db->where('file_id', $id);
        $this->db->delete($this->table_name);

        if($this->db->affected_rows() > 0)
        {
            log_activity($this->table_name . ' id [ ID: '. $id . ']');
            return true;
        }
        return false; 

    }
    
    public function get($data)
    {
        if(is_string($data)){
            $this->db->where('file_id' ,$data);
            return $this->db->get($this->table_name)->row_array();
        }
        return false;
    }

    public function update($data)
    {
        $this->db->where('file_id' ,$data['file_id']);
        $this->db->update($this->table_name ,$data);
        if($this->db->affected_rows() > 0){
            return true;
        }
        return false;
    }

    public function get_google_sheets($data)
    {
        $this->db->where('rel_type', 'project');
        $this->db->where('rel_id', $data);
        return $this->db->get($this->table_name)->result_array();
    }

    public function get_all_fils()
    {
        return $this->db->get($this->table_name)->result_array();
    }

    public function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }
}
