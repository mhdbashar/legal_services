<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Legal_procedures extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/Legal_procedures_model' , 'procedures');
        $this->load->model('LegalServices/LegalServicesModel' , 'legal');
    }

    public function index()
    {
        $data['category'] = $this->procedures->get('',
           array(
               'type_id'   => 2,
               'parent_id' => 0
               )
        );
        $data['legal_services'] = $this->legal->get_all_services(['is_module' => 0], false);
        $data['title'] = _l('legal_procedures_management');
        $this->load->view('admin/LegalServices/legal_procedures/manage',$data);
    }

    public function get_sub_cat($parent_id)
    {
        $response = $this->procedures->get('',
            array(
                'type_id'   => 2,
                'parent_id' => $parent_id
            ));
        echo json_encode($response);
    }

    public function add($parent_id='')
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $id = $this->procedures->add($parent_id,$data);
            if ($id) {
                set_alert('success', _l('added_successfully'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function edit($CatID)
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $success = $this->legal->update_category_data($CatID,$data);
            if ($success) {
                set_alert('success', _l('updated_successfully'));
            }else {
                set_alert('warning', _l('problem_updating'));
            }
            redirect(admin_url('LegalServices/Legal_procedures'));
        }
        $data['category'] = $this->legal->GetCategoryById($CatID)->row();
        $data['title']  = _l('EditCategory');
        $this->load->view('admin/LegalServices/categories/EditCategory',$data);
    }

    public function delete($CatID)
    {
        $response = $this->legal->delete_category($CatID);
        if ($response == true) {
            set_alert('success', _l('deleted'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect(admin_url('LegalServices/Legal_procedures'));
    }

}