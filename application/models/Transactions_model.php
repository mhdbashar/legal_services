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
    //ADDing Transaction to setup Menu****//

    //**********ADDing Transaction type *************//
    public function get_type($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get(db_prefix() . 'transaction_type')->row();
        }
        $this->db->order_by('id', 'desc');
        return $this->db->get(db_prefix() . 'transaction_type')->result_array();
    }
    public function add_type($data)
    {

        $this->db->insert(db_prefix() . 'transaction_type', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Customer Representative State [ID: ' . $insert_id . ']');
            return $insert_id;
        }
        return false;
    }

    public function update_type($data, $id)
    {

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'transaction_type', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Customer Representative Updated [ID: ' . $id . ']');
            return true;
        }

        return false;
    }

    public function delete_type($id, $simpleDelete = false)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'transaction_type');
        if ($this->db->affected_rows() > 0) {
            log_activity('Customer Representative Deleted [' . $id . ']');
            return true;
        }
        return false;
    }
//**********End of Transaction type *************//

    //**********ADDing Transaction origin *************//
    public function get_origin($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get(db_prefix() . 'transaction_origin')->row();
        }
        $this->db->order_by('id', 'desc');
        return $this->db->get(db_prefix() . 'transaction_origin')->result_array();
    }
    public function add_origin($data)
    {

        $this->db->insert(db_prefix() . 'transaction_origin', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Customer Representative State [ID: ' . $insert_id . ']');
            return $insert_id;
        }
        return false;
    }

    public function update_origin($data, $id)
    {

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'transaction_origin', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Customer Representative Updated [ID: ' . $id . ']');
            return true;
        }

        return false;
    }

    public function delete_origin($id, $simpleDelete = false)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'transaction_origin');
        if ($this->db->affected_rows() > 0) {
            log_activity('Customer Representative Deleted [' . $id . ']');
            return true;
        }
        return false;
    }
    //**********End of Transaction origin *************//

    //**********ADDing Transaction importance *************//
    public function get_importance($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get(db_prefix() . 'transaction_importance')->row();
        }
        $this->db->order_by('id', 'desc');
        return $this->db->get(db_prefix() . 'transaction_importance')->result_array();
    }
    public function add_importance($data)
    {

        $this->db->insert(db_prefix() . 'transaction_importance', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Customer Representative State [ID: ' . $insert_id . ']');
            return $insert_id;
        }
        return false;
    }

    public function update_importance($data, $id)
    {

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'transaction_importance', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Customer Representative Updated [ID: ' . $id . ']');
            return true;
        }

        return false;
    }

    public function delete_importance($id, $simpleDelete = false)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'transaction_importance');
        if ($this->db->affected_rows() > 0) {
            log_activity('Customer Representative Deleted [' . $id . ']');
            return true;
        }
        return false;
    }
//**********End of Transaction importance *************//

    //**********ADDing Transaction classification *************//
    public function get_classification($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get(db_prefix() . 'transaction_classification')->row();
        }
        $this->db->order_by('id', 'desc');
        return $this->db->get(db_prefix() . 'transaction_classification')->result_array();
    }
    public function add_classification($data)
    {

        $this->db->insert(db_prefix() . 'transaction_classification', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Customer Representative State [ID: ' . $insert_id . ']');
            return $insert_id;
        }
        return false;
    }

    public function update_classification($data, $id)
    {

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'transaction_classification', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Customer Representative Updated [ID: ' . $id . ']');
            return true;
        }

        return false;
    }

    public function delete_classification($id, $simpleDelete = false)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'transaction_classification');
        if ($this->db->affected_rows() > 0) {
            log_activity('Customer Representative Deleted [' . $id . ']');
            return true;
        }
        return false;
    }
//**********End of Transaction classification *************//


    //**********ADDing Transaction incoming_type *************//
    public function get_incoming_type($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get(db_prefix() . 'transaction_incoming_type')->row();
        }
        $this->db->order_by('id', 'desc');
        return $this->db->get(db_prefix() . 'transaction_incoming_type')->result_array();
    }
    public function add_incoming_type($data)
    {

        $this->db->insert(db_prefix() . 'transaction_incoming_type', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Customer Representative State [ID: ' . $insert_id . ']');
            return $insert_id;
        }
        return false;
    }

    public function update_incoming_type($data, $id)
    {

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'transaction_incoming_type', $data);
        if ($this->db->affected_rows() > 0) {
            log_activity('Customer Representative Updated [ID: ' . $id . ']');
            return true;
        }

        return false;
    }

    public function delete_incoming_type($id, $simpleDelete = false)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'transaction_incoming_type');
        if ($this->db->affected_rows() > 0) {
            log_activity('Customer Representative Deleted [' . $id . ']');
            return true;
        }
        return false;
    }
//**********End of Transaction incoming_type *************//





    //***********************************//

}