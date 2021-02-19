<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Hr extends AdminController{

    public function __construct(){
        parent::__construct();
        $this->load->model('hrm_model');
        if (!has_permission('hr', '', 'view'))
            access_denied();
    }

    public function index()
    {
        if (!has_permission('hr', '', 'view')) {
            access_denied('hr');
        }
        $this->load->model('departments_model');

        $data['title']                 = _l('hrm');
        $this->load->view('hrm_dashboard', $data);
    }

    public function contracts($id = '')
    {
        $this->load->model('departments_model');
        $this->load->model('staff_model');

        $data['hrmcontractid'] = $id;
        $data['positions'] = $this->hrm_model->get_job_position();
        $data['workplace'] = $this->hrm_model->get_workplace();
        $data['contract_type'] = $this->hrm_model->get_contracttype();
        $data['staff'] = $this->staff_model->get();
        $data['allowance_type'] = $this->hrm_model->get_allowance_type();
        $data['salary_form'] = $this->hrm_model->get_salary_form();
        $data['duration'] = $this->hrm_model->get_duration();

        $data['dep_tree'] = json_encode($this->hrm_model->get_department_tree());

        $data['title']                 = _l('staff_contract');
        $this->load->view('manage_contract', $data);
    }

    public function contract_code_exists()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                // First we need to check if the email is the same
                $contractid = $this->input->post('contractid');

                if ($contractid != '') {
                    $this->db->where('id_contract', $contractid);
                    $staff = $this->db->get('tblstaff_contract')->row();
                    if ($staff->contract_code == $this->input->post('contract_code')) {
                        echo json_encode(true);
                        die();
                    }
                }
                $this->db->where('contract_code', $this->input->post('contract_code'));
                $total_rows = $this->db->count_all_results('tblstaff_contract');
                if ($total_rows > 0) {
                    echo json_encode(false);
                } else {
                    echo json_encode(true);
                }
                die();
            }
        }
    }

    public function contract_type($id = '')
    {

        if ($this->input->post()) {
            $message          = '';
            $data             = $this->input->post();
            $data             = $this->input->post();

            if (!$this->input->post('id')) {
                $id = $this->hrm_model->add_contract_type($data);
                if ($id) {
                    $success = true;
                    $message = _l('added_successfully', _l('contract_type'));
                    set_alert('success',$message);
                }

                redirect(admin_url('hr/setting?group=contract_type'));
            } else {
                $id = $data['id'];
                unset($data['id']);
                $success = $this->hrm_model->update_contract_type($data, $id);
                if ($success) {
                    $message = _l('updated_successfully', _l('contract_type'));
                }
                redirect(admin_url('hr/setting?group=contract_type'));
                echo json_encode([
                    'success'              => $success,
                    'message'              => $message,
                ]);

            }
            die;
        }
    }
    public function delete_contract_type($id)
    {
        if (!$id) {
            redirect(admin_url('hr/setting?group=contract_type'));
        }
        $response = $this->hrm_model->delete_contract_type($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('contract_type')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('contract_type')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('contract_type')));
        }
        redirect(admin_url('hr/setting?group=contract_type'));
    }

    public function table_contract()
    {
        $this->app->get_table_data(module_views_path('hr', 'table_contract'));
    }

    public function contract($id = '')
    {
        if (!has_permission('hr', '', 'view')) {
            access_denied('hr');
        }

        $this->load->model('hrm_model');
        if ($this->input->post()) {
            $data = $this->input->post();
            if ($id == '') {
                if (!has_permission('hr', '', 'create')) {
                    access_denied('hr');
                }
                $id = $this->hrm_model->add_contract($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('contract')));
                    redirect(admin_url('hr/contract/' . $id));
                }
            } else {
                if (!has_permission('hr', '', 'edit')) {
                    access_denied('hr');
                }

                $response = $this->hrm_model->update_contract($data, $id);
                if (is_array($response)) {
                    if (isset($response['cant_remove_main_admin'])) {
                        set_alert('warning', _l('staff_cant_remove_main_admin'));
                    } elseif (isset($response['cant_remove_yourself_from_admin'])) {
                        set_alert('warning', _l('staff_cant_remove_yourself_from_admin'));
                    }
                } elseif ($response == true) {
                    set_alert('success', _l('updated_successfully', _l('contract')));
                }
                redirect(admin_url('hr/contract/' . $id));
            }
        }

        if ($id == '') {
            $title = _l('add_new', _l('contract'));
            $data['title'] = $title;
        } else {

            $contract = $this->hrm_model->get_contract($id);
            $contract_detail = $this->hrm_model->get_contract_detail($id);
            if (!$contract) {
                blank_page('Contract Not Found', 'danger');
            }

            $data['contracts']            = $contract;
            if(isset($contract[0]['staff_delegate'])){
                $data['staff_delegate_role'] = $this->hrm_model->get_staff_role($contract[0]['staff_delegate']);
            }
            $data['contract_details']            = $contract_detail;
            if(isset($contract[0]['name_contract'])){

                $title                     = $this->hrm_model->get_contracttype_by_id($contract[0]['name_contract']);
                if(isset($title[0]['name_contracttype'])){
                    $data['title']         = $title[0]['name_contracttype'];
                }
            }

        }

        $data['positions'] = $this->hrm_model->get_job_position();
        $data['workplace'] = $this->hrm_model->get_workplace();
        $data['contract_type'] = $this->hrm_model->get_contracttype();
        $data['staff'] = $this->staff_model->get();
        $data['allowance_type'] = $this->hrm_model->get_allowance_type();
        $data['salary_form'] = $this->hrm_model->get_salary_form();

        $this->load->view('hr/contract', $data);
    }

    public function delete_contract($id)
    {
        if (!$id) {
            redirect(admin_url('hr/contracts'));
        }
        $response = $this->hrm_model->delete_contract($id);
        redirect(admin_url('hr/contracts'));
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('contract')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('contract')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('contract')));
        }

    }
    public function contract_form(){
        if($this->input->post('contract_form')){
            $this->hrm_model->contract_form($this->input->post('contract_form'));
            $success = true;
            $message = _l('added_successfully', _l('contract_form'));
            echo json_encode([
                'success' => $success,
                'message' => $message,
                'id'      => $this->input->post('contract_form'),
                'name'    => $this->input->post('contract_form'),
            ]);
        }
    }


    public function upload_file()
    {
        if ($this->input->post()) {
            $staffid  = $this->input->post('staffid');
            $id  = $this->input->post('id');
            $files   = handle_hrm_attachments_array($staffid, 'file');
            $success = false;
            $count_id = 0 ;
            $message ='';
            if ($files) {
                $i   = 0;
                $len = count($files);
                foreach ($files as $file) {
                    $insert_id = $this->hrm_model->add_attachment_to_database($staffid, 'hrm_staff_file', [$file], false);
                    if($insert_id > 0){
                        $count_id ++ ;
                    }
                    $i++;
                }
                if($insert_id == $i){
                    $message = 'Upload file success';
                }
            }
            $hrm_staff   = $this->hrm_model->get_hrm_attachments($staffid);
            $data ='';
            foreach($hrm_staff as $key => $attachment) {
                $href_url = site_url('modules/hrm/uploads/'.$attachment['rel_id'].'/'.$attachment['file_name']).'" download';
                if(!empty($attachment['external'])){
                    $href_url = $attachment['external_link'];
                }
                $data .= '<div class="display-block contract-attachment-wrapper">';
                $data .= '<div class="col-md-10">';
                $data .= '<div class="col-md-1">';
                $data .= '<a name="preview-btn" onclick="preview_file_staff(this); return false;" rel_id = "'.$attachment['rel_id'].'" id = "'.$attachment['id'].'" href="Javascript:void(0);" class="mbot10 btn btn-success pull-left" data-toggle="tooltip" title data-original-title="'._l("preview_file").'">';
                $data .= '<i class="fa fa-eye"></i>';
                $data .= '</a>';
                $data .= '</div>';
                $data .= '<div class=col-md-9>';
                $data .= '<div class="pull-left"><i class="'.get_mime_class($attachment['filetype']).'"></i></div>';
                $data .= '<a href="'.$href_url.'>'.$attachment['file_name'].'</a>';
                $data .= '<p class="text-muted">'.$attachment["filetype"].'</p>';
                $data .= '</div>';
                $data .= '</div>';
                $data .= '<div class="col-md-2 text-right">';
                if($attachment['staffid'] == get_staff_user_id() || is_admin()){
                    $data .= '<a href="#" class="text-danger" onclick="delete_contract_attachment(this,'.$attachment['id'].'); return false;"><i class="fa fa fa-times"></i></a>';
                }
                $data .= '</div>';
                $data .= '<div class="clearfix"></div><hr/>';
                $data .= '</div>';
            }
            echo json_encode([
                'message'  => 'Upload file success',
                'data'     => $data
            ]);
        }
    }

    public function get_hrm_contract_data_ajax($id)
    {
        $contract = $this->hrm_model->get_contract($id);
        $contract_detail = $this->hrm_model->get_contract_detail($id);
        if (!$contract) {
            blank_page('Contract Not Found', 'danger');
        }

        $data['contracts']            = $contract;
        if(isset($contract[0]['staff_delegate'])){
            $data['staff_delegate_role'] = $this->hrm_model->get_staff_role($contract[0]['staff_delegate']);
        }
        $data['contract_details']            = $contract_detail;
        $title                     = $this->hrm_model->get_contracttype_by_id($contract[0]['name_contract']);
        $data['title']         = $title[0]['name_contracttype'];
        $data['positions'] = $this->hrm_model->get_job_position();
        $data['workplace'] = $this->hrm_model->get_workplace();
        $data['contract_type'] = $this->hrm_model->get_contracttype();
        $data['staff'] = $this->staff_model->get();
        $data['allowance_type'] = $this->hrm_model->get_allowance_type();
        $data['salary_form'] = $this->hrm_model->get_salary_form();


        $this->load->view('hr/contract_preview_template', $data);
    }

    public function get_hrm_formality(){
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('formality') == 'increase') {
                echo json_encode([
                    'sign_a_labor_contract'  => get_hrm_option('sign_a_labor_contract'),
                    'maternity_leave_to_return_to_work'  => get_hrm_option('maternity_leave_to_return_to_work'),
                    'unpaid_leave_to_return_to_work'  => get_hrm_option('unpaid_leave_to_return_to_work'),
                    'increase_the_premium'  => get_hrm_option('increase_the_premium'),
                ]);
                die();

            }elseif ($this->input->post('formality') == 'decrease') {
                echo json_encode([
                    'contract_paid_for_unemployment'  => get_hrm_option('contract_paid_for_unemployment'),
                    'maternity_leave_regime'  => get_hrm_option('maternity_leave_regime'),
                    'reduced_premiums'  => get_hrm_option('reduced_premiums'),
                ]);
                die();

            }

        }
    }

    public function allowance_type($id = '')
    {

        if ($this->input->post()) {
            $message          = '';
            $data             = $this->input->post();
            $data             = $this->input->post();

            if (!$this->input->post('id')) {
                $id = $this->hrm_model->add_allowance_type($data);
                if ($id) {
                    $success = true;
                    $message = _l('added_successfully', _l('allowance_type'));
                }
                redirect(admin_url('hr/setting?group=allowance_type'));
                echo json_encode([
                    'success'              => $success,
                    'message'              => $message,
                ]);

            } else {
                $id = $data['id'];
                unset($data['id']);
                $success = $this->hrm_model->update_allowance_type($data, $id);
                if ($success) {
                    $message = _l('updated_successfully', _l('allowance_type'));
                }
                redirect(admin_url('hr/setting?group=allowance_type'));
                echo json_encode([
                    'success'              => $success,
                    'message'              => $message,
                ]);

            }
            die;
        }
    }
    public function delete_allowance_type($id)
    {
        if (!$id) {
            redirect(admin_url('hr/setting?group=allowance_type'));
        }
        $response = $this->hrm_model->delete_allowance_type($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('allowance_type')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('allowance_type')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('allowance_type')));
        }
        redirect(admin_url('hr/setting?group=allowance_type'));
    }

    public function get_staff_allowance_type(){
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {

                $id = $this->input->post('id');
                $name_object = $this->db->query('select at.allowance_val from '.db_prefix().'allowance_type as at  where at.type_id = ' .$id)->row();
            }
        }
        if($name_object){
            echo json_encode([
                'allowance_val'  => $name_object->allowance_val,
            ]);
        }

    }



}
