<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Document_model extends App_Model{

    private $table_name = 'hr_documents';

    public function __construct(){
        parent::__construct();
        if(!substr( $this->table_name, 0, 3 ) === "tbl"){
            $this->table_name = 'tbl' . $this->table_name;
        }
    }

    public function uploadImage($field, $id)
    {
        $this->deleteDirectory("uploads/hr/document/$id");
        mkdir('uploads/hr/document/'.$id, 0777, true);
        $config['upload_path'] = 'uploads/hr/document/'.$id.'/';
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
            // Upload file
            if (!empty($_FILES['document_file']['name'])) {
                $data['id'] = $insert_id;
                $val = $this->uploadImage('document_file', $insert_id);
                $val == TRUE || redirect($_SERVER['HTTP_REFERER']);
                if(!empty($val['path'])){
                    $data['document_file'] = $val['path'];
                }else{
                    $data['document_file'] = null;
                }
                $this->db->where('id', $insert_id);
                $this->db->update($this->table_name, $data);
            }

            if($this->input->post('without_photo') == 'yes'){
                $data['avatar'] = null;
                $this->deleteDirectory("uploads/faces/$id");
            }
            return $insert_id;
        }
        return false;
    }

    public function update($data, $id){
        $this->db->where('id', $id);
        // Upload file
        if (!empty($_FILES['document_file']['name'])) {
            $val = $this->uploadImage('document_file', $id);
            $val == TRUE || redirect($_SERVER['HTTP_REFERER']);
            if(!empty($val['path'])){
                $data['document_file'] = $val['path'];
            }else{
                $data['document_file'] = null;
            }
        }

        if($this->input->post('without_photo') == 'yes'){
            $data['avatar'] = null;
            $this->deleteDirectory("uploads/faces/$id");
        }
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
            $this->deleteDirectory("uploads/hr/document/$id");
            return true;
        } 
 
        return false; 
    }
}