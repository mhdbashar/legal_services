<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Transactions extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transactions_model');
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
        $data['title'] = _l('incoming');
//        $this->load->view('admin/procuration/manage', $data);


        $this->load->view('admin/transactions/manage_incoming',$data);
    }
    public function outgoing_list(){
//

        if ($this->input->is_ajax_request()) {

            $this->app->get_table_data('my_outgoing_transactions');
        }
        $data['title'] = _l('outgoing');
//        $this->load->view('admin/procuration/manage', $data);


        $this->load->view('admin/transactions/manage_outgoing',$data);
    }

    public function table($type = '')
    {

    }

    public function incoming_side($id = ''){
        $enArray=array();

        if ($this->input->is_ajax_request()) {
            if (option_exists('incoming_side_En') != Null){
                $enArray = json_decode(get_option('incoming_side_En'));
            }else{
                $enArray=array();
            }

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





            $success = $en ?true:false;
            $message = $success ? _l('added_successfully', _l('incoming_side')) : '';
            echo json_encode([
                'success' => $success,
                'message' => $message,
                'data' => $nameEn,
            ]);
        }

    }


    public function delete_transaction()
    {
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

    //********ADDing transactions to setup_items ****************//

    //**********ADDing transactions_type*************************//
    public function transaction_type()
    {
        $this->load->model('transactions_model');
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_transaction_type');
        }
        $data['title'] = _l('transaction_type');
        $this->load->view('admin/transactions_setup/manage', $data);
    }
    /* Edit transaction_type or Add new if passed id */
    public function add_type($id = '')
    {

        $this->load->model('transactions_model');
        if ($this->input->post()) {
            $data            = $this->input->post();
            if ($id == '') {
                $id = $this->transactions_model->add_type($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('transaction_type')));
                    redirect(admin_url('Transactions/transaction_type'));
                }
            } else {
                $success = $this->transactions_model->update_type($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('transaction_type')));
                }
                redirect(admin_url('Transactions/transaction_type'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('transaction_type'));
        } else {
            $data['transaction_type'] = $this->transactions_model->get_type($id);
            $title                = _l('edit', _l('transaction_type'));
        }
        $data['title'] = $title;

        $this->load->view('admin/transactions_setup/transaction_type', $data);
    }

    /* Delete Customer representative from database */
    public function delete_type($id)
    {
        $this->load->model('transactions_model');

        if (!$id) {
            redirect(admin_url('Transactions/transaction_type'));
        }
        $response = $this->transactions_model->delete_type($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('transaction_type')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('transaction_type')));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    //**********End of transaction_type**************//


    //**********ADDing transactions_origin*************************//
    public function transaction_origin()
    {
        $this->load->model('transactions_model');
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_transaction_origin');
        }
        $data['title'] = _l('origin');
        $this->load->view('admin/transactions_setup/origin', $data);
    }
    /* Edit transaction_type or Add new if passed id */
    public function add_origin($id = '')
    {
        $this->load->model('transactions_model');
        if ($this->input->post()) {
            $data            = $this->input->post();
            if ($id == '') {
                $id = $this->transactions_model->add_origin($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('origin')));
                    redirect(admin_url('Transactions/transaction_origin'));
                }
            } else {
                $success = $this->transactions_model->update_origin($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('origin')));
                }
                redirect(admin_url('Transactions/transaction_origin'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('origin'));
        } else {
            $data['transaction_origin'] = $this->transactions_model->get_origin($id);
            $title                = _l('edit', _l('origin'));
        }
        $data['title'] = $title;

        $this->load->view('admin/transactions_setup/transaction_origin', $data);
    }

    /* Delete Customer representative from database */
    public function delete_origin($id)
    {
        $this->load->model('transactions_model');

        if (!$id) {
            redirect(admin_url('transactions/transaction_origin'));
        }
        $response = $this->transactions_model->delete_origin($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('origin')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('origin')));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    //**********End of transaction_origin**************//

    //**********ADDing transactions_importance*************************//
    public function transaction_importance()
    {
        $this->load->model('transactions_model');
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_transaction_importance');
        }
        $data['title'] = _l('origin');
        $this->load->view('admin/transactions_setup/importance', $data);
    }
    /* Edit transaction_type or Add new if passed id */
    public function add_importance($id = '')
    {
        $this->load->model('transactions_model');
        if ($this->input->post()) {
            $data            = $this->input->post();
            if ($id == '') {
                $id = $this->transactions_model->add_importance($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('importance')));
                    redirect(admin_url('Transactions/transaction_importance'));
                }
            } else {
                $success = $this->transactions_model->update_importance($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('importance')));
                }
                redirect(admin_url('Transactions/transaction_importance'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('importance'));
        } else {
            $data['transaction_importance'] = $this->transactions_model->get_importance($id);
            $title                = _l('edit', _l('importance'));
        }
        $data['title'] = $title;

        $this->load->view('admin/transactions_setup/transaction_importance', $data);
    }

    /* Delete Customer representative from database */
    public function delete_importance($id)
    {
        $this->load->model('transactions_model');

        if (!$id) {
            redirect(admin_url('transactions/transaction_importance'));
        }
        $response = $this->transactions_model->delete_importance($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('importance')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('importance')));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    //**********End of transaction_origin**************//

    //**********ADDing transactions_classification*************************//
    public function transaction_classification()
    {
        $this->load->model('transactions_model');
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_transaction_classification');
        }
        $data['title'] = _l('classification');
        $this->load->view('admin/transactions_setup/classification', $data);
    }
    /* Edit transaction_type or Add new if passed id */
    public function add_classification($id = '')
    {
        $this->load->model('transactions_model');
        if ($this->input->post()) {
            $data            = $this->input->post();
            if ($id == '') {
                $id = $this->transactions_model->add_classification($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('classification')));
                    redirect(admin_url('Transactions/transaction_classification'));
                }
            } else {
                $success = $this->transactions_model->update_classification($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('classification')));
                }
                redirect(admin_url('Transactions/transaction_classification'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('classification'));
        } else {
            $data['transaction_classification'] = $this->transactions_model->get_classification($id);
            $title                = _l('edit', _l('classification'));
        }
        $data['title'] = $title;

        $this->load->view('admin/transactions_setup/transaction_classification', $data);
    }

    /* Delete Customer representative from database */
    public function delete_classification($id)
    {
        $this->load->model('transactions_model');

        if (!$id) {
            redirect(admin_url('transactions/transaction_classification'));
        }
        $response = $this->transactions_model->delete_classification($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('classification')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('classification')));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    //**********End of transaction_classification**************//

    //**********ADDing transactions_incoming_type*************************//
    public function transaction_incoming_type()
    {
        $this->load->model('transactions_model');
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_transaction_incoming_type');
        }
        $data['title'] = _l('classification');
        $this->load->view('admin/transactions_setup/incoming_type', $data);
    }
    /* Edit transaction_incoming_type or Add new if passed id */
    public function add_incoming_type($id = '')
    {
        $this->load->model('transactions_model');
        if ($this->input->post()) {
            $data            = $this->input->post();
            if ($id == '') {
                $id = $this->transactions_model->add_incoming_type($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('incoming_type')));
                    redirect(admin_url('Transactions/transaction_incoming_type'));
                }
            } else {
                $success = $this->transactions_model->update_incoming_type($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('incoming_type')));
                }
                redirect(admin_url('Transactions/transaction_incoming_type'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('incoming_type'));
        } else {
            $data['transaction_incoming_type'] = $this->transactions_model->get_incoming_type($id);
            $title                = _l('edit', _l('incoming_type'));
        }
        $data['title'] = $title;

        $this->load->view('admin/transactions_setup/transaction_incoming_type', $data);
    }

    /* Delete Customer representative from database */
    public function delete_incoming_type($id)
    {
        $this->load->model('transactions_model');

        if (!$id) {
            redirect(admin_url('transactions/transaction_incoming_type'));
        }
        $response = $this->transactions_model->delete_incoming_type($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('incoming_type')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('incoming_type')));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    //**********End of transaction_classification**************//


    //********End of ADDing transactions to setup_items ****************//





}