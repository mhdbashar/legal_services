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

    public function all_legal_services()
    {
        $clientid = $this->input->post('clientid') ? $this->input->post('clientid') : '';
        $slug = $this->input->post('slug') ? $this->input->post('slug') : '';
        $ServID = $this->legal->get_service_id_by_slug($slug);
        if ($clientid != '' || $slug != '') {
            if($ServID == 1){
                $res = $this->case->get('', ['clientid' => $clientid]);
            }else{
                $res = $this->other->get($ServID ,'', ['clientid' => $clientid]);
            }
            echo json_encode($res);
        }
    }

    public function ViewSubService($ServID)
    {
        close_setup_menu();
        $data['service'] = $this->legal->get_service_by_id($ServID)->row();
        $data['ServID']  = $ServID;
        if ($ServID == 1){
            $data['statuses'] = $this->case->get_project_statuses();
            $data['model']    = $this->case;
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('cases',$data);
            }
        }else{
            $data['statuses'] = $this->other->get_project_statuses();
            $data['model']    = $this->other;
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('my_other_services',$data);
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

    public function getChildCatModules($CatID)
    {
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
                redirect($_SERVER['HTTP_REFERER']);
            }else {
                set_alert('warning', _l('problem_updating', _l('Categories')));
                redirect($_SERVER['HTTP_REFERER']);
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
        $RelatedService = $this->legal->CheckExistRelatedServices($ServID,$CatID);
        if($RelatedService > 0){
            set_alert('danger', _l('problem_deleting_rel_serv'));
            redirect(admin_url('ServicesControl'));
        }
        $response = $this->legal->delete_category($CatID);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Categories')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Categories')));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function legal_recycle_bin($ServID = '')
    {
        $data['ServID'] = $ServID;
        if($ServID == ''){
            //Do Nothing...
        }else if ($ServID == 1){
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('case_recycle_bin',$data);
            }
        }else{
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('oservice_recycle_bin',$data);
            }
        }
        $data['services'] = $this->legal->get_all_services();
        $data['title']    = _l('LService_recycle_bin');
        $this->load->view('admin/LegalServices/recycle_bin/recycle_bin',$data);
    }

    public function restore_legal_services($ServID,$id)
    {
        $ExistServ = $this->legal->CheckExistService($ServID);
        if($ExistServ == 0 || !$ServID){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url('ServicesControl'));
        }
        $restore = $this->legal->restore_from_recycle_bin($ServID,$id);
        if ($restore == true) {
            set_alert('success', _l('LegalServicesRestored'));
        } else {
            set_alert('warning', _l('ProblemRestored'));
        }
        redirect(admin_url('LegalServices/LegalServices_controller/legal_recycle_bin/'.$ServID));

    }

    public function confirm_empty_recycle_bin($confirm = '')
    {
        if($confirm == 'yes'){
            $confirmed = $this->legal->confirm_empty_recycle_bin();
            if ($confirmed == true) {
                set_alert('success', _l('Done'));
                redirect(admin_url());
            } else {
                set_alert('warning', _l('Faild'));
                redirect(admin_url());
            }
        }elseif ($confirm == 'no'){
            set_alert('warning', _l('Done'));
            redirect(admin_url());
        }
        $data['title'] = _l('ConfirmEmptyLegalServicesRecycleBin');
        $this->load->view('admin/LegalServices/recycle_bin/confirm_empty', $data);
    }

}
