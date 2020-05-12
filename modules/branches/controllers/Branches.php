<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Branches extends AdminController
{

    private $pdf_fields = [];

    private $client_portal_fields = [];

 
    private $client_editable_fields = [];

    public function __construct()
    {
        parent::__construct();

        $this->load->model('branches_model');


 
        if (!is_admin()) {
            access_denied('Access Branches');
        }
        // Add the pdf allowed fields

        $this->pdf_fields             = $this->branches_model->get_pdf_allowed_fields();
        $this->client_portal_fields   = $this->branches_model->get_client_portal_allowed_fields();
        $this->client_editable_fields = $this->branches_model->get_client_editable_fields();
    }


    /* List all properties */
    public function index()
    {
/*        error_reporting(E_ALL);
        ini_set('display_errors', 1);*/

        if ($this->input->is_ajax_request()) {
            $this->branchapp->get_table_data('branches');
 
        }
        $data['title'] = _l('branches');
        $this->load->view('admin/branches/manage', $data);
    }

    public function departments($id)
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('branch_departments', ['id'=>$id]);
        }
        $data['email_exist_as_staff'] = $this->email_exist_as_staff();
        $data['title']                = _l('departments');
        $this->load->view('admin/departments/manage', $data);
    }

    public function field($id = '')
    {
        if ($this->input->post()) {
            if ($id == '') {
                $id = $this->branches_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('branch')));
                    redirect(admin_url('branches/field/' . $id));
                }
            } else {
                $success = $this->branches_model->update($this->input->post(), $id);
                if (is_array($success) && isset($success['cant_change_option_custom_field'])) {
                    set_alert('warning', _l('cf_option_in_use'));
                } elseif ($success === true) {
                    set_alert('success', _l('updated_successfully', _l('branch')));
                }
                redirect(admin_url('branches/field/' . $id));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('branches_lowercase'));
        } else {
            $data['branch'] = $this->branches_model->get($id);
            $title                = _l('edit', _l('branches_lowercase'));
            $data['city']=$this->branches_model->getCitiesForCountry($data['branch']->country_id);
        }
        $data['pdf_fields']             = $this->pdf_fields;
        $data['client_portal_fields']   = $this->client_portal_fields;
        $data['client_editable_fields'] = $this->client_editable_fields;
        $data['title']                  = $title;
        $data['countries']=$this->branches_model->getCountries();
        $this->load->view('admin/branches/branch', $data);
    }


    /**
    *   Description: Delte Branch
     *  @param: Id int
    */

    /* Delete announcement from database */
 
    public function delete($id)
    {
        if (!$id) {
            redirect(admin_url('branches'));
        }
        $response = $this->branches_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('branch')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('branches_lowercase')));
        }
        redirect(admin_url('branches'));
    }



    /**
     * @param $id
     */

 
    public function getCities($id)
    {
        echo json_encode(['success'=>true,'data'=>$this->branches_model->getCitiesForCountry($id)]);
        die();
    }

    public function getDepartments($id)
    {
        echo json_encode(['success'=>true,'data'=>$this->branches_model->getDepatrmentsForBranches($id)]);
        die();
    }

    public function get_office_shift($id)
    {
        echo json_encode(['success'=>true,'data'=>$this->branches_model->get_office_shift($id)]);
        die();
    }



    /**
     * Descripion: retreive  departments for Branch
     * @param $id
     */


    private function email_exist_as_staff()
    {
        return total_rows('tbldepartments', 'email IN (SELECT email FROM tblstaff)') > 0;
    }


}
 
