<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customer_representative extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_representative_model');
    }

    /* List all Customer representative */
    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_customer_representative');
        }
        $data['title'] = _l('customer_representative');
        $this->load->view('admin/customer_representative/manage', $data);
    }


    /* Edit Customer representative or Add new if passed id */
    public function cust_representativecu($id = '')
    {
        if (!is_admin()) {
            access_denied('customer_representative');
        }
        if ($this->input->post()) {
            $data            = $this->input->post();
            // $data['message'] = $this->input->post('message', false);
            if ($id == '') {
                $id = $this->Customer_representative_model->add($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('customer_representative')));
                    redirect(admin_url('customer_representative'));
                }
            } else {
                $success = $this->Customer_representative_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('customer_representative')));
                }
                redirect(admin_url('customer_representative'));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('customer_representative'));
        } else {
            $data['customer_representative'] = $this->Customer_representative_model->get($id);
            $title                = _l('edit', _l('customer_representative'));
        }
        $data['title'] = $title;
        $this->load->view('admin/customer_representative/customer_representative', $data);
    }

    /* Delete Customer representative from database */
    public function cust_representatived($id)
    {
        if (!$id) {
            redirect(admin_url('customer_representative/cust_representativecu'));
        }
        if (!is_admin()) {
            access_denied('customer_representative');
        }
        $response = $this->Customer_representative_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('customer_representative')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('customer_representative')));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}
