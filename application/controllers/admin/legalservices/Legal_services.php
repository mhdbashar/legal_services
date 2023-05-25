<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Legal_services extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('legalservices/LegalServicesModel' , 'legal');
        $this->load->model('legalservices/Cases_model','case');
        $this->load->model('legalservices/disputes_cases/Disputes_cases_model','disputes_cases');
        $this->load->model('legalservices/Other_services_model','other');
        $this->load->model('legalservices/Imported_services_model','imported');
        $this->load->model('projects_model');
    }

    public function ShowLegalServices()
    {
        if (!has_permission('legal_services', '', 'create')) {
            access_denied('legal_services');
        }
        $data['services'] = $this->legal->get_all_services();
        $data['title']    = _l('LegalServiceManage');
        $this->load->view('admin/legalservices/basic_services/ShowServices',$data);
    }

    public function all_legal_services()
    {
        $clientid = $this->input->post('clientid') ? $this->input->post('clientid') : '';
        $slug = $this->input->post('slug') ? $this->input->post('slug') : '';
        $ServID = $this->legal->get_service_id_by_slug($slug);
        if ($clientid != '' || $slug != '') {
            if($ServID == 1){
                $res = $this->case->get('', ['clientid' => $clientid]);
            }elseif ($ServID == 22) {
                $res = $this->disputes_cases->get('', ['clientid' => $clientid]);
            }else {
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
        } elseif ($ServID == 22){
            $data['statuses'] = $this->disputes_cases->get_project_statuses();
            $data['model']    = $this->disputes_cases;
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('disputes_cases',$data);
            }
        } else{
            $data['statuses'] = $this->other->get_project_statuses();
            $data['model']    = $this->other;
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('my_other_services',$data);
            }
        }
        $data['title']    = _l('LegalServiceManage');
        $this->load->view('admin/legalservices/basic_services/manage',$data);
    }

    public function ViewImportedService()
    {
        if (!has_permission('imported_services', '', 'view')) {
            access_denied('imported_services');
        }
        close_setup_menu();
        // $data['service'] = $this->legal->get_service_by_id($ServID)->row();
        // $data['ServID']  = $ServID;
        // if ($ServID == 1){
        //     $data['statuses'] = $this->case->get_project_statuses();
        //     $data['model']    = $this->case;
        //     if ($this->input->is_ajax_request()) {
        //         $this->app->get_table_data('cases',$data);
        //     }
        // }else{
        //     $data['statuses'] = $this->other->get_project_statuses();
        //     $data['model']    = $this->other;
        //     if ($this->input->is_ajax_request()) {
        //         $this->app->get_table_data('my_other_services',$data);
        //     }
        // }
        $data['statuses'] = $this->imported->get_project_statuses();
        $service = [
            'name' => 'imported_services',
            'slug' => 'imported_services',
            'prefix' => 'IMPORT',
            'numbering' => 1,
            'is_primary' => 1,
            'show_in_sidbar' => 1,
            'is_module' => 0,
            'date_created' => '2020-01-23 21:03:43'
        ];
        $data['service'] = (object) $service;
        $data['model']    = $this->other;
        $data['ServID']  = 2;
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_imported_services', $data);
        }
        $data['title']    = _l('imported_services');
        $this->load->view('admin/legalservices/imported_services/manage',$data);
    }

    public function PrimaryService($ServID)
    {
        if (!has_permission('legal_services', '', 'active')) {
            access_denied('legal_services');
        }
        $IfExist = $this->legal->CheckExistService($ServID);
        if($IfExist == 0 || !$ServID){
            set_alert('danger', _l('WrongEntry'));
        }
        $response = $this->legal->ActivePrimary($ServID);
        echo $response;
    }

    public function AddNewServices()
    {
        if (!has_permission('legal_services', '', 'create')) {
            access_denied('legal_services');
        }
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
        if (!has_permission('legal_services', '', 'edit')) {
            access_denied('legal_services');
        }
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
        $this->load->view('admin/legalservices/basic_services/EditService',$data);
    }

    public function del_service($ServID)
    {
        if (!has_permission('legal_services', '', 'delete')) {
            access_denied('legal_services');
        }
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
        if (!has_permission('legal_services', '', 'categories')) {
            access_denied('legal_services');
        }
        $ExistServ = $this->legal->CheckExistService($ServID);
        if($ExistServ == 0 || !$ServID){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url('ServicesControl'));
        }
        $data['category'] = $this->legal->GetCategoryByServId($ServID);
        $data['ServID'] = $ServID;
        $data['title'] = _l('Categories');
        $this->load->view('admin/legalservices/categories/ShowAllCategory',$data);
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
        if (!has_permission('legal_services', '', 'categories')) {
            access_denied('legal_services');
        }
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
        if (!has_permission('legal_services', '', 'categories')) {
            access_denied('legal_services');
        }
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
        if (!has_permission('legal_services', '', 'categories')) {
            access_denied('legal_services');
        }
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
        if($data['category']->parent_id != 0)
            $this->load->view('admin/legalservices/categories/EditChildCategory',$data);
        else
            $this->load->view('admin/legalservices/categories/EditCategory',$data);
    }

    public function del_category($ServID,$CatID)
    {
        if (!has_permission('legal_services', '', 'categories')) {
            access_denied('legal_services');
        }
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
        redirect(admin_url("CategoryControl/$ServID"));
    }

    public function legal_recycle_bin($ServID = '')
    {
        if (!has_permission('legal_recycle_bin', '', 'view')) {
            access_denied('legal_recycle_bin');
        }
        $data['ServID'] = $ServID;
        if($ServID == ''){
            //Do Nothing...
        }else if ($ServID == 1){
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('case_recycle_bin',$data);
            }
        }elseif($ServID == 22){
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('disputes_case_recycle_bin',$data);
            }
        }else{
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('oservice_recycle_bin',$data);
            }
        }
        $data['services'] = $this->legal->get_all_services();
        $data['title']    = _l('LService_recycle_bin');
        $this->load->view('admin/legalservices/recycle_bin/recycle_bin',$data);
    }

    public function restore_legal_services($ServID,$id)
    {
        if (!has_permission('legal_recycle_bin', '', 'restore')) {
            access_denied('legal_recycle_bin');
        }
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
        redirect(admin_url('legalservices/legal_services/legal_recycle_bin/'.$ServID));

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
        $this->load->view('admin/legalservices/recycle_bin/confirm_empty', $data);
    }

}
