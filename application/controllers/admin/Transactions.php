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
//        var_dump($this->input->post());exit;
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
            $dataRow['is_secret']= isset($data['secret'])? 1 : 0;
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
                $success = $this->transactions_model->update($dataRow, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', 'incoming'));
                }
                redirect($redirect);
            }
        }
        if ($id == '') {
            $data['last_id'] = $last_id;
            $title = _l('add_new', _l('incoming_transaction'));
        } else {
            $data['incoming'] = $this->transactions_model->get($id);
            $title                = _l('edit', _l('incoming_transaction'));
        }
        $data['id'] = $id;
        $data['title'] = $title;

        $this->load->view('admin/transactions/incoming', $data);
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
            $dataRow['is_secret']= isset($data['secret'])? 1 : 0;
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
                $success = $this->transactions_model->update($dataRow, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', 'outgoing'));
                }
                redirect($redirect);
            }
        }

        if ($id == '') {
            $data['last_id'] = $last_id;
            $title = _l('add_new', _l('outgoing_transaction'));
        } else {

            $data['outgoing'] = $this->transactions_model->get($id);
            $title                = _l('edit', _l('outgoing_transaction'));
        }
        $data['id'] = $id;
        $data['title'] = $title;
        
        $this->load->view('admin/transactions/outgoing',$data);
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

    public function incoming_side($id = ''){
//var_dump(is_array('ghjghj'));exit();
        $enArray=array();

        if ($this->input->is_ajax_request()) {
            if (option_exists('incoming_side_En') != Null){
                $enArray = json_decode(get_option('incoming_side_En'));
            }else{
                $enArray=array();
            }
//        var_dump($this->input->post('nameEn'));exit();
            if ($this->input->get()) {
                $nameEn['key'] = $this->input->get('nameEn');
                $nameEn['value'] = $this->input->get('nameEn');
            }


            array_push($enArray,$nameEn );
            if (option_exists('incoming_side_En') != Null){
                $en = update_option('incoming_side_En',json_encode($enArray));
            }else{
                $en = add_option('incoming_side_En',json_encode($enArray));
            }
//        var_dump($enArray,$nameEn);exit();




            $success = $en ?true:false;
            $message = $success ? _l('added_successfully', _l('incoming_side')) : '';
            echo json_encode([
                'success' => $success,
                'message' => $message,
                'data' => $nameEn,
            ]);
        }

    }


    public function delete_transaction(){
//        var_dump();exit();
        $id = $_GET["del_id"];
        $success = $this->transactions_model->changeStatus($id);
        if ($success) {
            return set_alert('success', _l('deleted', _l('incoming')));
        } else {
            return set_alert('warning', _l('problem_deleting', _l('incoming')));

        }
    }

    public function add_transaction_attachment($id)
    {
        $direction = $_POST['trans_type'] == 1 ? "outgoing_list" :"incoming_list";
        handle_transaction_attachments($id);
        echo json_encode([
            'url' => admin_url('transactions/'.$direction),
        ]);
    }

    public function delete_transaction_attachment($id, $type = '')
    {
        $direction = $type == 1 ? 'outgoing': 'incoming' ;
//        var_dump();exit();
        $this->db->where('rel_id', $id);
        $this->db->where('rel_type', 'transaction');
        $file = $this->db->get(db_prefix().'files')->row();

        if ($file->staffid == get_staff_user_id() || is_admin()) {
            $success = $this->transactions_model->delete_transaction_attachment($id);
            if ($success) {
                set_alert('success', _l('deleted', _l($direction.'_transaction_file')));
            } else {
                set_alert('warning', _l('problem_deleting', _l('transaction_receipt_lowercase')));
            }
            redirect(admin_url('transactions/'.$direction.'/'.$id));
        } else {
            access_denied('expenses');
        }
    }



}