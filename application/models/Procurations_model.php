<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Procurations_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public $table_name = 'tblprocurations';

    public function uploadImage($field, $id)
    {
        $this->deleteDirectory("uploads/procurations/$id");
        mkdir('uploads/procurations/'.$id, 0777, true);
        $config['upload_path'] = 'uploads/procurations/'.$id.'/';
        //png, jpg, jpeg, gif, txt, pdf, xls, xlsx, doc, docx
        $config['allowed_types'] = 'gif|jpg|png|jpeg|txt|pdf|xls|xlsx|doc|docs|docx';
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

    // tblprocurations, `id`, `procurations`
    public function get($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            $procuration = $this->db->get(db_prefix() . 'procurations')->row();
            if ($procuration) {
                $procuration->attachment            = '';
                $procuration->filetype              = '';
                $procuration->attachment_added_from = 0;
                $procuration->cases = $this->get_procurations_cases($id);
                $this->db->where('rel_id', $id);
                $this->db->where('rel_type', 'procuration');
                $file = $this->db->get(db_prefix() . 'files')->row();
                if ($file) {
                    $procuration->attachment            = $file->file_name;
                    $procuration->filetype              = $file->filetype;
                    $procuration->attachment_added_from = $file->staffid;
                }
            }
            return $procuration;
        }
        $this->db->order_by('id', 'desc');
        return $this->db->get(db_prefix() . 'procurations')->result_array();
    }

    public function get_procurations($client_id = '')
    {
        if ($client_id != '') {
            $this->db->where('client', $client_id);
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get(db_prefix() . 'procurations')->result_array();
    }

    public function get_procurations_cases($id)
    {
        $this->db->select('my_cases.id, my_cases.code');
        $this->db->from('procuration_cases');
        $this->db->join('my_cases', 'my_cases.id = procuration_cases._case');
        $this->db->where('procuration_cases.procuration', $id);
        return $this->db->get()->result_array();
        //return $this->db->get(db_prefix() . 'procuration_cases')->result_array();
    }

    public function get_procuration_cases($id)
    {
        $this->db->select('my_cases.id as id,my_cases.numbering as numbering, my_cases.code as code');
        $this->db->from('my_cases');
        $this->db->join('procuration_cases', 'my_cases.id = procuration_cases._case');
        $this->db->where('procuration_cases.procuration', $id);
        return $this->db->get()->result_array();
    }

    public function getProcurationCases($id)
    {
        $this->db->select('my_cases.id as id,my_cases.numbering as numbering, my_cases.code as code');
        $this->db->from('my_cases');
        $this->db->join('procuration_cases', 'my_cases.id = procuration_cases._case');
        $this->db->where('procuration_cases.procuration', $id);
        return $this->db->get()->result();
    }

    public function add($data)
    {
        $affectedRows = 0;
        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            unset($data['custom_fields']);
        }
        if(isset($data['cases']))
        {
            $pcases=$data['cases'];
            unset($data['cases']);
        }

        //start Baraa alahalabi
        if(isset($data['status_name']))
        {
            $data['status'] = $data['status_name'];
            unset($data['status_name']);
        }
        //end Baraa alahalabi

//        $data['start_date'] = force_to_AD_date(($data['start_date']));
//        $data['end_date'] = force_to_AD_date($data['end_date']);
            
        $data['addedfrom'] = get_staff_user_id();
        $this->db->insert('tblprocurations', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $affectedRows++;
            log_activity('New procuration [ID: ' . $insert_id . '] for client [ID: '.$data["client"].'');

            if (isset($custom_fields)) {
                handle_custom_fields_post($insert_id, $custom_fields);
            }

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
            if (isset($pcases)) {
                foreach ($pcases as $pid) {
                    if (empty($pid)) {
                        continue;
                    }
                    $this->db->insert(db_prefix() . 'procuration_cases', [
                        'procuration' => $insert_id,
                        '_case'   => $pid,
                    ]);
                    if ($this->db->affected_rows() > 0) {

                        $affectedRows++;
                    }
                }
            }
            return $insert_id;
        }
        return false;
    }

    public function update($data, $id)
    {
        $affectedRows = 0;

        if (!empty($_FILES['file']['name'])) {
            $val = $this->uploadImage('file', $id);
            $val == TRUE || redirect($_SERVER['HTTP_REFERER']);
            if(!empty($val['path'])){
                $data['file'] = $val['path'];
            }else{
                $data['file'] = null;
            }
        }
        //start Baraa alahalabi
        if(isset($data['status_name']))
        {
            $data['status'] = $data['status_name'];
            unset($data['status_name']);
        }
        //end Baraa alahalabi

        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            if (handle_custom_fields_post($id, $custom_fields)) {
                $affectedRows++;
            }
            unset($data['custom_fields']);
        }
        if(isset($data['cases']))
        {
            $pcases=$data['cases'];
            unset($data['cases']);
        }

        $data['start_date'] = to_sql_date($data['start_date']);
        $data['end_date'] = to_sql_date($data['end_date']);

        $case_procurations_in = $this->get_procuration_cases($id);
        if (sizeof($case_procurations_in) > 0) {
            foreach ($case_procurations_in as $case_member) {
                if (isset($pcases)) {
                    if (!in_array($case_member['id'], $pcases)) {
                        $this->db->where('procuration', $id);
                        $this->db->where('_case', $case_member['id']);
                        $this->db->delete('tblprocuration_cases');
                    }
                }else
                {
                    $this->db->where('procuration', $id);
                    $this->db->delete(db_prefix() . 'procuration_cases');
                    if ($this->db->affected_rows() > 0) {
                        $affectedRows++;
                    }
                }
            }
            if (isset($pcases)) {
                $notifiedUsers = [];
                foreach ($pcases as $pid) {
                    $this->db->where('procuration', $id);
                    $this->db->where('_case', $pid);
                    $_exists = $this->db->get(db_prefix() . 'procuration_cases')->row();
                    if (!$_exists) {
                        if (empty($pid)) {
                            continue;
                        }
                        $this->db->insert(db_prefix() . 'procuration_cases', [
                            'procuration' => $id,
                            '_case'   => $pid,
                        ]);
                    }
                }
            }
        }else {
            if (isset($pcases)) {
                foreach ($pcases as $pid) {
                    if (empty($pid)) {
                        continue;
                    }
                    $this->db->insert(db_prefix() . 'procuration_cases', [
                        'procuration' => $id,
                        '_case'   => $pid,
                    ]);
                    if ($this->db->affected_rows() > 0) {

                        $affectedRows++;
                    }
                }

            }
        }
        $this->db->where('id', $id);
        $this->db->update('tblprocurations', $data);
        if ($this->db->affected_rows() > 0) {
            $affectedRows++;

            log_activity(' procuration Updated [ID: ' . $id . '] for client [ID: '.$data["client"].'');

            return true;
        }
        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

    public function delete($id, $simpleDelete = false)
    {
        $this->delete_procuration_attachment($id);
        $this->db->where('relid', $id);
        //table name in custom field table is procurations
        $this->db->where('fieldto', 'procurations');
        $this->db->delete(db_prefix() . 'customfieldsvalues');
        $this->db->where('id', $id);
        $this->db->delete('tblprocurations');
        if ($this->db->affected_rows() > 0) {
            $this->db->where('procuration', $id);
            $this->db->delete(db_prefix() . 'procuration_cases');
            log_activity(' procuration Deleted [ID: ' . $id . ']');
            $this->deleteDirectory("uploads/procurations/$id");
            return true;
        }
        return false;
    }

    public function delete_procuration_attachment($id)
    {
        if (is_dir(get_upload_path_by_type('procuration') . $id)) {
            if (delete_dir(get_upload_path_by_type('procuration') . $id)) {
                $this->db->where('rel_id', $id);
                $this->db->where('rel_type', 'procuration');
                $this->db->delete(db_prefix() . 'files');
                log_activity('Procuration Doc Deleted [ProcID: ' . $id . ']');

                return true;
            }
        }
        return false;
    }
}