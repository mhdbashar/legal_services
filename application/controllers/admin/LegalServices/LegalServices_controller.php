<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LegalServices_controller extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/LegalServicesModel' , 'legal');
        $this->load->model('LegalServices/Cases_model','case');
        $this->load->model('LegalServices/Other_services_model','other');
        $this->load->model('projects_model');
    }

    public function ShowLegalServices()
    {
        $data['services'] = $this->legal->get_all_services();
        $data['title']    = _l('LegalServiceManage');
        $this->load->view('admin/LegalServices/basic_services/ShowServices',$data);
    }

    public function ViewSubService($ServID)
    {
        close_setup_menu();
        $data['service']  = $this->legal->get_service_by_id($ServID)->row();
        $data['statuses'] = $this->case->get_project_statuses();
        $data['ServID']   = $ServID;
        if ($ServID == 1){
            $data['model'] = $this->case;
            $data['cases'] = $this->case->get();
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('cases',$data);
            }
        }else{
            $data['model'] = $this->other;
            //$data['cases'] = $this->case->get();
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('other_services',$data);
            }
        }
        $data['title']    = _l('LegalServiceManage');
        $this->load->view('admin/LegalServices/basic_services/manage',$data);
    }

    public function PrimaryService($ServID)
    {
        $IfExist = $this->legal->CheckExistService($ServID);
        if($IfExist == 0 || !$ServID){
            set_alert('danger', _l('WrongEntry'));
        }
        $response = $this->legal->ActivePrimary($ServID);
        echo $response;
    }

    public function AddNewServices()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $added = $this->legal->InsertServices($data);
            if ($added) {
                set_alert('success', _l('added_successfully', _l('LegalService')));
                redirect(admin_url('ServicesControl'));
            }
        }
    }

    public function edit_service_data($ServID)
    {
        $ExistServ = $this->legal->CheckExistService($ServID);
        if($ExistServ == 0 || !$ServID){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url('ServicesControl'));
        }
        if ($this->input->post()) {
            $data = $this->input->post();
            $success = $this->legal->update_service_data($ServID,$data);
            if ($success) {
                set_alert('success', _l('updated_successfully', _l('LegalService')));
                redirect(admin_url('ServicesControl'));
            }else {
                set_alert('warning', _l('problem_updating', _l('LegalService')));
                redirect(admin_url('ServicesControl'));
            }
        }
        $data['service'] = $this->legal->get_service_by_id($ServID)->row();
        $data['title']  = _l('EditLegalService');
        $this->load->view('admin/LegalServices/basic_services/EditService',$data);
    }

    public function del_service($ServID)
    {
        $ExistServ = $this->legal->CheckExistService($ServID);
        if($ExistServ == 0 || !$ServID){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url('ServicesControl'));
        }
        $response = $this->legal->delete_service($ServID);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('LegalService')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('LegalService')));
        }
        redirect(admin_url('ServicesControl'));
    }

    public function CategoriesManagment($ServID)
    {
        $ExistServ = $this->legal->CheckExistService($ServID);
        if($ExistServ == 0 || !$ServID){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url('ServicesControl'));
        }
        $data['category'] = $this->legal->GetCategoryByServId($ServID);
        $data['ServID'] = $ServID;
        $data['title'] = _l('Categories');
        $this->load->view('admin/LegalServices/categories/ShowAllCategory',$data);
    }

    public function GetChildCat($ServID,$CatID)
    {
        $ExistServ = $this->legal->CheckExistService($ServID);
        $ExistCat = $this->legal->CheckExistCategory($CatID);
        if($ExistServ == 0 || $ExistCat == 0 || !$CatID){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url('ServicesControl'));
        }
        $response = $this->legal->GetChildByCategory($CatID);
        echo json_encode($response);
    }

    public function AddNewCategory($ServID)
    {
        $ExistServ = $this->legal->CheckExistService($ServID);
        if($ExistServ == 0 || !$ServID){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url('ServicesControl'));
        }
        if ($this->input->post()) {
            $data = $this->input->post();
            $added = $this->legal->InsertCategory($ServID,$data);
            if ($added) {
                set_alert('success', _l('added_successfully', _l('Categories')));
                redirect(admin_url("CategoryControl/$ServID"));
            }
        }
    }

    public function AddChildCategory($ServID,$CatID)
    {
        $ExistServ = $this->legal->CheckExistService($ServID);
        $ExistCat = $this->legal->CheckExistCategory($CatID);
        if($ExistServ == 0 || $ExistCat == 0 || !$ServID || !$CatID){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url('ServicesControl'));
        }
        if ($this->input->post()) {
            $data = $this->input->post();
            $added = $this->legal->InsertChildCategory($ServID,$CatID,$data);
            if ($added) {
                set_alert('success', _l('added_successfully', _l('Categories')));
                redirect(admin_url("CategoryControl/$ServID"));
            }
        }
    }

    public function edit_category_data($ServID,$CatID)
    {
        $ExistServ = $this->legal->CheckExistService($ServID);
        $ExistCat = $this->legal->CheckExistCategory($CatID);
        if($ExistServ == 0 || $ExistCat == 0 || !$ServID || !$CatID){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url('ServicesControl'));
        }
        if ($this->input->post()) {
            $data = $this->input->post();
            $success = $this->legal->update_category_data($CatID,$data);
            if ($success) {
                set_alert('success', _l('updated_successfully', _l('Categories')));
                redirect(admin_url("CategoryControl/$ServID"));
            }else {
                set_alert('warning', _l('problem_updating', _l('Categories')));
                redirect(admin_url("CategoryControl/$ServID"));
            }
        }
        $data['category'] = $this->legal->GetCategoryById($CatID)->row();
        $data['title']  = _l('EditCategory');
        $this->load->view('admin/LegalServices/categories/EditCategory',$data);
    }

    public function del_category($ServID,$CatID)
    {
        $ExistServ = $this->legal->CheckExistService($ServID);
        $ExistCat = $this->legal->CheckExistCategory($CatID);
        if($ExistServ == 0 || $ExistCat == 0 || !$ServID || !$CatID){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url('ServicesControl'));
        }
        $response = $this->legal->delete_category($CatID);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Categories')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Categories')));
        }
        redirect(admin_url("CategoryControl/$ServID"));
    }
}
