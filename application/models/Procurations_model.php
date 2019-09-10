<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Procurations_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
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
        return $this->db->get('tblprocurations')->result_array();
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
        //var_dump($this->CI->db->conn_id->error);
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

        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            unset($data['custom_fields']);
        }
        $data['addedfrom'] = get_staff_user_id();
        $this->db->insert('tblprocurations', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New procuration [ID: ' . $insert_id . '] for client [ID: '.$data["client"].'');

            if (isset($custom_fields)) {
                handle_custom_fields_post($insert_id, $custom_fields);
            }

            return $insert_id;
        }

        return false;
    }

    public function update($data, $id)
    {

        $affectedRows = 0;
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
        //var_dump($data);
        $this->db->where('id', $id);
        $this->db->update('tblprocurations', $data);
        if ($this->db->affected_rows() > 0) {

            $affectedRows++;

            log_activity(' procuration Updated [ID: ' . $insert_id . '] for client [ID: '.$data["client"].'');

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