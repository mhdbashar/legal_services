<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transactions_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '')
    {
        if (is_numeric($id)) {

            $this->db->where('id', $id);
            $transaction = $this->db->get(db_prefix() . 'my_transactions')->row();
            if ($transaction) {
                $transaction->attachment            = '';
                $transaction->filetype              = '';

                $this->db->where('rel_id', $id);
                $this->db->where('rel_type', 'transaction');
                $file = $this->db->get(db_prefix() . 'files')->row();

                if ($file) {
                    $transaction->attachment            = $file->file_name;
                    $transaction->filetype              = $file->filetype;

                }
            }


            return $transaction;
        }

        $this->db->order_by('id', 'desc');
        return $this->db->get(db_prefix().'my_transactions')->result_array();
    }

    public function add($data)
    {
//        var_dump($data);exit();
        $this->db->insert(db_prefix().'my_transactions', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New transaction [ID: ' . $insert_id . ']');

            return $insert_id;
        }

        return false;
    }

    public function update($data, $id)
    {
        $affectedRows = 0;
        //var_dump($data);
        $this->db->where('id', $id);
        $this->db->update(db_prefix().'my_transactions', $data);
        if ($this->db->affected_rows() > 0) {

            $affectedRows++;

            log_activity(' transaction Updated [ID: ' . $id . ']');

            return true;
        }

        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }


    public function changeStatus($id)
    {
        $affectedRows = 0;
        //var_dump($data);
        $data['isDeleted'] = 1;
        $this->db->where('id', $id);
        $this->db->update(db_prefix().'my_transactions', $data);
        if ($this->db->affected_rows() > 0) {

            $affectedRows++;

            log_activity(' transaction Updated [ID: ' . $id . ']');

            return true;
        }

        if ($affectedRows > 0) {
            return true;
        }

        return false;


    }

    public function delete($id, $simpleDelete = false)
    {


        $this->db->where('id', $id);
        $this->db->delete(db_prefix().'my_transactions');
        if ($this->db->affected_rows() > 0) {

            log_activity(' transaction Deleted [ID: ' . $id . ']');

            return true;
        }

        return false;
    }


    public function delete_transaction_attachment($id)
    {
        if (is_dir(get_upload_path_by_type('transaction') . $id)) {
            if (delete_dir(get_upload_path_by_type('transaction') . $id)) {
                $this->db->where('rel_id', $id);
                $this->db->where('rel_type', 'transaction');
                $this->db->delete(db_prefix() . 'files');
                log_activity('transaction Doc Deleted [ProcID: ' . $id . ']');

                return true;
            }
        }

        return false;
    }

}