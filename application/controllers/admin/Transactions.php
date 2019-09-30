<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Transactions extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transactions_model');
//        var_dump($this->load->model('Transactions_model'));exit();

    }

    public function index()
    {
        $this->db->select('max(id)');
        $max = ($this->db->get('tblmy_transactions')->row_array())['max(id)'] + 1;
        if($max != null){
            return $max;
        }else{
            return 0;
        }
    }

    public function incoming($id = ''){
//        var_dump($this->input->post());exit();
//        $this->load->model('Transactions_model');
        if (!is_admin()) {
            access_denied('incoming');
        }
        $redirect = admin_url('transactions/incoming_list');
        $last_id = $this->index();
        if ($this->input->post()) {
            $data            = $this->input->post();

            $dataRow['definition']= $data['trans_type'];
            $dataRow['description']= $data['description'];
            $dataRow['type']= $data['type'];
            $dataRow['origin']= $data['origin'];
            $dataRow['incoming_num']= $data['incoming_num'];
            $dataRow['incoming_source']= $data['incoming_source'];
            $dataRow['incoming_type']= $data['incoming_type'];
            $dataRow['is_secret']= $data['secret'];
            $dataRow['importance']= $data['importance'];
            $dataRow['classification']= $data['class'];
            $dataRow['owner']= $data['owner_name'];
            $dataRow['owner_phone']= $data['owner_phone'];
            $dataRow['source_reporter']= $data['reporter_name'];
            $dataRow['source_reporter_phone']= $data['reporter_phone'];
            $dataRow['email']= $data['email'];
            $dataRow['date']= $data['date'];
            $dataRow['isDeleted']= 0;
            if ($id == '') {
                $data['id'] = $last_id;
                $id = $this->transactions_model->add($dataRow);
                if ($id) {
                    set_alert('success', _l('added_successfully', 'incoming'));
                    redirect($redirect);
                }
            } else {
                $success = $this->transactions_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', 'incoming'));
                }
                redirect($redirect);
            }
        }

        if ($id == '') {
            $data['last_id'] = $last_id;
            $title = _l('add_new', 'incoming');
        } else {
            $data['incoming'] = $this->transactions_model->get($id);
            $title                = _l('edit', 'incoming');
        }
        $this->load->view('admin/transactions/incoming');
    }



    public function outgoing($id=''){

        if (!is_admin()) {
            access_denied('outgoing');
        }
        $redirect = admin_url('transactions/outgoing_list');
        $last_id = $this->index();
        if ($this->input->post()) {
            $data            = $this->input->post();

            $dataRow['definition']= $data['trans_type'];
            $dataRow['description']= $data['description'];
            $dataRow['type']= $data['type'];
            $dataRow['origin']= $data['origin'];
            $dataRow['is_secret']= $data['secret'];
            $dataRow['importance']= $data['importance'];
            $dataRow['classification']= $data['class'];
            $dataRow['owner']= $data['owner_name'];
            $dataRow['owner_phone']= $data['owner_phone'];
            $dataRow['isDeleted']= 0;
            if ($id == '') {
                $data['id'] = $last_id;
                $id = $this->transactions_model->add($dataRow);
                if ($id) {
                    set_alert('success', _l('added_successfully', 'outgoing'));
                    redirect($redirect);
                }
            } else {
                $success = $this->transactions_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', 'outgoing'));
                }
                redirect($redirect);
            }
        }

        if ($id == '') {
            $data['last_id'] = $last_id;
            $title = _l('add_new', 'outgoing');
        } else {
            $data['outgoing'] = $this->transactions_model->get($id);
            $title                = _l('edit', 'outgoing');
        }

        $this->load->view('admin/transactions/outgoing');
    }
    public function incoming_list(){
//

        if ($this->input->is_ajax_request()) {

            $this->app->get_table_data('my_incoming_transactions');
        }
//        var_dump('hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhgjk');exit();
//        var_dump(_l('procuration'));exit();
        $data['title'] = _l('incoming');
//        $this->load->view('admin/procuration/manage', $data);


        $this->load->view('admin/transactions/manage_incoming',$data);
    }
    public function outgoing_list(){
//

        if ($this->input->is_ajax_request()) {

            $this->app->get_table_data('my_outgoing_transactions');
        }
//        var_dump('hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhgjk');exit();
//        var_dump(_l('procuration'));exit();
        $data['title'] = _l('outgoing');
//        $this->load->view('admin/procuration/manage', $data);


        $this->load->view('admin/transactions/manage_outgoing',$data);
    }

    public function table($type = '')
    {

    }

    public function transaction($id = ''){
//
    }

    public function delete_transaction($id = ''){

    }

}