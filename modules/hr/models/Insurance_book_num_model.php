<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Insurance_book_num_model extends App_Model{

    private $table_name = 'tblinsurance_book_nums';

    public function __construct(){
        parent::__construct();
        if(!substr( $this->table_name, 0, 3 ) === "tbl"){
            $this->table_name = 'tbl' . $this->table_name;
        }
    }

    public function uploadImage($field, $id)
    {
        $this->deleteDirectory("uploads/hr/insurance_book_num/$id");
        mkdir('uploads/hr/insurance_book_num/'.$id, 0777, true);
        $config['upload_path'] = 'uploads/hr/insurance_book_num/'.$id.'/';
        //png, jpg, jpeg, gif, txt, pdf, xls, xlsx, doc, docx
        $config['allowed_types'] = 'gif|jpg|png|jpeg|txt|pdf|xls|xlsx|doc|docs';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($field)) {
            $error = $this->upload->display_errors();
            $type = "error";
            $message = $error;
            echo $message;
            exit;
            // uploading failed. $error will holds the errors.
        } else {
            $fdata = $this->upload->data();
            $file['path'] = $config['upload_path'] . $fdata['file_name'];
            return $file;
            // uploading successfull, now do your further actions
        }
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

    public function get($id=''){
        if(is_numeric($id)){
            $this->db->where('id' ,$id);
            return $this->db->get($this->table_name)->row();
        }

        $this->db->order_by('id', 'desc');
        return $this->db->get($this->table_name)->result_array();
    }

    public function add($data){
        $this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        if($insert_id){
            log_activity('New ' . $this->table_name . ' added [ID: '.$insert_id.']');
            if (!empty($_FILES['file']['name'])) {
                $data['id'] = $insert_id;
                $val = $this->uploadImage('file', $insert_id);
                $val == TRUE || redirect($_SERVER['HTTP_REFERER']);
                if(!empty($val['path'])){
                    $data['file'] = $val['path'];
                }else{
                    $data['file'] = null;
                }
                $this->db->where('id', $insert_id);
                $this->db->update($this->table_name, $data);
            }
            return $insert_id;
        }
        return false;
    }

    public function update($data, $id){
        // Upload file
        if (!empty($_FILES['file']['name'])) {
            $val = $this->uploadImage('file', $id);
            $val == TRUE || redirect($_SERVER['HTTP_REFERER']);
            if(!empty($val['path'])){
                $data['file'] = $val['path'];
            }else{
                $data['file'] = null;
            }
        }
        $this->db->where('id', $id);
        $this->db->update($this->table_name, $data);
        if($this->db->affected_rows() > 0){
                log_activity($this->table_name . ' updated [ ID: '. $id . ']');
            return true;
        }
        return false;
    }

    public function delete($id, $simpleDelete = false){
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
        if ($this->db->affected_rows() > 0) {
            log_activity($this->table_name . ' Deleted [' . $id . ']');
            $this->deleteDirectory("uploads/hr/insurance_book_num/$id");
            return true;
        }

        return false;
    }
}