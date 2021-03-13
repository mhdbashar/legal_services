<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Hr extends AdminController{

    public function __construct(){
        parent::__construct();
        $this->load->model('hrm_model');
        $this->load->model('Insurance_type_model');
        $this->load->model('Insurance_book_num_model');
        if (!has_permission('hr', '', 'view_own') && !has_permission('hr', '', 'view'))
            access_denied();

        $total_complete_staffs = $this->db->count_all_results(db_prefix() . 'hr_extra_info');
        $total_staffs = $this->db->count_all_results(db_prefix() . 'staff');
        if($total_complete_staffs != $total_staffs) {
            set_alert('warning', _l('you_have_to_complete_staff_informations'));
            redirect(admin_url('hr/general/staff'));
        }
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

        $data['hrmcontractid'] = $id;
        $data['positions'] = $this->hrm_model->get_job_position();
        // $data['workplace'] = $this->hrm_model->get_workplace();
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

    public function table_insurance()
    {
        $this->app->get_table_data(module_views_path('hr', 'table_insurance'));
    }

    public function insurance_conditions_setting(){
        if($this->input->post()){
            $data = $this->input->post();
            $success = $this->hrm_model->update_insurance_conditions($data);
            if($success > 0){
                set_alert('success', _l('setting_update_successfully'));
            }
            redirect(admin_url('hrm/setting?group=insurrance'));
        }
    }

    public function insurances(){

        $this->load->model('departments_model');
        $this->load->model('staff_model');
        $this->load->model('hrm_model');

        $data['month'] = $this->hrm_model->get_month();

        $data['title'] = _l('insurrance');
        $data['dep_tree'] = json_encode($this->hrm_model->get_department_tree());

        $this->load->view('hr/insurance/manage_insurance', $data);
    }

    //function add,delete,update insurrance
    public function insurance($id = ''){

        if (!has_permission('hr', '', 'view')) {
            access_denied('hr');
        }
        if ($this->input->post()) {
            $data = $this->input->post();
            if ($this->input->post('insurance_id') == '') {
                // $data['insurance_book_num'] = get_option('insurance_book_number');
                if (!has_permission('hr', '', 'create')) {
                    access_denied('hr');
                }
                $id = $this->hrm_model->add_insurance($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('insurance_history')));
                    redirect(admin_url('hr/insurances'));
                }
            } else {
                if (!has_permission('hr', '', 'edit')) {
                    access_denied('hr');
                }

                $response = $this->hrm_model->update_insurance($data, $this->input->post('insurance_id'));
                if (is_array($response)) {
                    if (isset($response['cant_remove_main_admin'])) {
                        set_alert('warning', _l('staff_cant_remove_main_admin'));
                    } elseif (isset($response['cant_remove_yourself_from_admin'])) {
                        set_alert('warning', _l('staff_cant_remove_yourself_from_admin'));
                    }
                } elseif ($response == true) {

                    set_alert('success', _l('updated_successfully', _l('insurance_history')));
                }
                redirect(admin_url('hr/insurances'));
            }
        }

        if ($id == '') {
            $title = _l('add_new', _l('insurrance'));
            $data['title'] = $title;
        } else {
            $title = _l('edit', _l('insurrance'));
            $insurance = $this->hrm_model->get_insurance($id);
            $insurance_history = $this->hrm_model->get_insurance_history($id);


            $data['insurances']            = $insurance;
            $data['insurance_history']            = $insurance_history;



        }
        $data['insurance_types'] = $this->Insurance_type_model->get('', ['for_staff' => 1]);
        $data['insurance_book_nums'] = $this->Insurance_book_num_model->get();
        // var_dump($data['insurance_book_nums']); exit;
        $data['month'] = $this->hrm_model->get_month();
        $data['staff'] = $this->staff_model->get('');
        $this->load->view('hr/insurance/insurance', $data);
    }

    public function build_insurance_types_relations() {

        $types = $this->Insurance_type_model->get('', ['insurance_book_id' => $this->input->post('insurance_book_num'), 'for_staff' => 1]);
        $output = '<option value=""></option>';
        $select=$this->input->post('selected');
        foreach ($types as $row)
        {
            if($row['id']==$select)$selected="selected";else $selected="";
            $output .= '<option value="'.$row['id'].'" '.$selected.' >'.$row['name'].'</option>';
        }
        echo $output;
    }

    public function insurance_book_exists(){
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                // First we need to check if the email is the same
                $insurance_id = $this->input->post('insurance_id');

                if ($insurance_id != '') {
                    $this->db->where('insurance_id', $insurance_id);
                    $staff = $this->db->get('tblstaff_insurance')->row();
                    if ($staff->insurance_book_num == $this->input->post('insurance_book_num')) {
                        echo json_encode(true);
                        die();
                    }
                }
                $this->db->where('insurance_book_num', $this->input->post('insurance_book_num'));
                $total_rows = $this->db->count_all_results('tblstaff_insurance');
                if ($total_rows > 0) {
                    echo json_encode(false);
                } else {
                    echo json_encode(true);
                }
                die();
            }
        }
    }
    public function health_insurance_exists(){
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                // First we need to check if the email is the same
                $insurance_id = $this->input->post('insurance_id');

                if ($insurance_id != '') {
                    $this->db->where('insurance_id', $insurance_id);
                    $staff = $this->db->get('tblstaff_insurance')->row();
                    if ($staff->health_insurance_num == $this->input->post('health_insurance_num')) {
                        echo json_encode(true);
                        die();
                    }
                }
                $this->db->where('health_insurance_num', $this->input->post('health_insurance_num'));
                $total_rows = $this->db->count_all_results('tblstaff_insurance');
                if ($total_rows > 0) {
                    echo json_encode(false);
                } else {
                    echo json_encode(true);
                }
                die();
            }
        }
    }

    public function delete_insurance_history(){
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {

                $insurance_history_id = $this->input->post('insurance_history_id');
                if ($insurance_history_id != '') {
                    $this->db->where('id', $insurance_history_id);
                    $this->db->delete(db_prefix() . 'staff_insurance_history');
                    if ($this->db->affected_rows() > 0 ){

                        echo json_encode([
                            'data' => true,
                            'message' => _l('delete_insurance_history_success'),
                        ]);
                    }else{

                        echo json_encode([
                            'data' => false,
                            'message' => _l('delete_insurance_history_false'),

                        ]);

                    }
                }
            }
        }
    }

    public function insurance_type(){
        if($this->input->post()){
            $data = $this->input->post();
            if (!$this->input->post('id')) {
                $add = $this->hrm_model->add_insurance_type($data);
                if($add){
                    $message = _l('added_successfully', _l('insurance_type'));
                    set_alert('success',$message);
                }
                redirect(admin_url('hr/setting?group=insurrance'));
            }else{
                $id = $data['id'];
                unset($data['id']);
                $success = $this->hrm_model->update_insurance_type($data,$id);
                if($success == true){
                    $message = _l('updated_successfully', _l('insurance_type'));
                    set_alert('success', $message);
                }
                redirect(admin_url('hr/setting?group=insurrance'));
            }

        }
    }
    public function delete_insurance_type($id){
        if (!$id) {
            redirect(admin_url('hr/setting?group=insurrance'));
        }
        $response = $this->hrm_model->delete_insurance_type($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('insurance_type')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('insurance_type')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('insurance_type')));
        }
        redirect(admin_url('hr/setting?group=insurrance'));
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
                $href_url = site_url('modules/hr/uploads/'.$attachment['rel_id'].'/'.$attachment['file_name']).'" download';
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


    public function get_hrm_staff(){
        if ($this->input->is_ajax_request()) {

            $staffid = $this->input->get('staffid');

            $total_rows = $this->db->query('select si.insurance_id from '.db_prefix().'staff_insurance as si where si.staff_id = '.$staffid)->result_array();
            if (count($total_rows) > 0) {
                $id = $total_rows[0]['insurance_id'];

                $insurance = $this->hrm_model->get_insurance($id);
                if(isset($insurance)){
                    foreach ($insurance as $key => $insuran) {
                        $insurance_book_num = $insuran['insurance_book_num'];
                        $health_insurance_num = $insuran['health_insurance_num'];
                        $city_code = $insuran['city_code'];
                        $registration_medical = $insuran['registration_medical'];
                        $start_date = $insuran['start_date'];
                        $end_date = $insuran['end_date'];
                        $file = $insuran['file'];
                    }
                }
                $insurance_history = $this->hrm_model->get_insurance_history($id);
                $month = $this->hrm_model->get_month();
                $staff = $this->staff_model->get();

                $data_insert ='';
                if(isset($insurance_history) && count($insurance_history) != 0){
                    foreach ($insurance_history as $keydetails => $value) {
                        $keydetails = $keydetails +1;

                        $data_insert .= '<div class="row insurance-history ">';
                        $data_insert .=     '<div class="col-md-2">';
                        $from_month = (isset($value['from_month']) ? $value['from_month'] : '');
                        $data_insert .=   '<label for="from_month['.$keydetails .']">'. _l('from_month').'</label>';

                        $data_insert .=   '<select name="from_month['. $keydetails.']" class="selectpicker"';
                        $data_insert .=    'id="from_month['.$keydetails.']" data-width="100%"';
                        $data_insert .=    'data-none-selected-text="'. _l('dropdown_non_selected_tex').'">' ;

                        $data_insert .=   '<option value=""></option>';
                        if(isset($from_month)){
                            $exploded = explode("-", $from_month);
                            $exploded = array_reverse($exploded);
                            $newFormat = implode("/", $exploded);
                        }
                        foreach($month as $m){
                            $data_insert .=    '<option value="'. $m['id'].'"';
                            if(isset($from_month) && $newFormat == $m['id'] ){

                                $data_insert .=         'selected';
                            }
                            $data_insert .=        '>'. $m['name'].'</option>';
                        }
                        $data_insert .=         '</select>';

                        $data_insert .=         '</div>';
                        $data_insert .=        '<div class="col-md-3">';
                        $formality = isset($value['formality']) ? $value['formality'] : '' ;
                        $data_insert .=         '<label for="formality['. $keydetails .']" class="control-label">'._l(                      'formality').'</label>';

                        $data_insert .=    '<select onchange="OnSelectReason (this)"';
                        $data_insert .=      'name="formality['. $keydetails .']" class="selectpicker"';
                        $data_insert .=     'id="formality['. $keydetails .']" data-width="100%" data-none-selected-text="'._l('fillter_by_status').'">';
                        $data_insert .=     '  <option value=""></option>';
                        $data_insert .=     '  <option value="increase"';
                        if(isset($formality) && $formality == 'increase'){
                            $data_insert .=         'selected';
                        }
                        $data_insert .=        '>'._l('increase').'</option><option value="decrease"';
                        if(isset($formality) && $formality == 'decrease'){
                            $data_insert .=       'selected';
                        }
                        $data_insert .=        '>'. _l('decrease').'</option></select></div>                      
                                            <div class="col-md-3">';
                        $reason = isset($value['reason']) ? $value['reason'] : '';
                        $data_insert .=         '<label for="reason['.$keydetails .']" class="control-label">'. _l('reason_').'</label><select  name="reason['.$keydetails .']" class="selectpicker" id="reason['.$keydetails .']" data-width="100%" data-none-selected-text="'. _l('fillter_by_formality').'"><option value=""></option><option value="'.$reason.'"  selected><'._l(''.$reason.'') .'></option></select></div>';

                        $data_insert .=           '<div class="col-md-3">';
                        $premium_rates = isset($value['premium_rates']) ? $value['premium_rates'] : '' ;
                        $attr = array();
                        $attr = ['data-type' => 'currency'];

                        $data_insert .= render_input('premium_rates['. $keydetails .']','premium_rates', app_format_money((int)$premium_rates,''),'text', $attr);
                        $data_insert .=        '</div>';
                        if($keydetails == 1){
                            $data_insert .= '<div class="col-md-1 hrm-nowrap hrm-lineheight84" name="add_insurance_history">';
                            $data_insert .= '<button name="add_new_insurance_history" class="btn new_insurance_history btn-success hrm-radius20" data-ticket="true" type="button"php title="'. _l('add') .'" ><i class="fa fa-plus" ></i>';
                            $data_insert .=    form_hidden('id_history['.$keydetails.']',$value['id']);
                            $data_insert .=     '</button>';
                            $data_insert .=     '</div>';
                        } else {
                            $data_insert .=     '<div class="col-md-1 hrm-nowrap hrm-lineheight84" name="add_insurance_history">';
                            $data_insert .=    '<button name="add_new_insurance_history" class="btn remove_insurance_history btn-danger hrm-radius20" data-ticket="true" type="button" title="'._l('delete').'" ><i class="fa fa-minus"></i>';
                            $data_insert .=     form_hidden('id_history['.$keydetails.']',$value['id']);
                            $data_insert .=     '</button>';
                            $data_insert .=     '</div>';
                        }
                        $data_insert .=     '</div>';

                    }
                }


                echo json_encode([
                    'id' => $id,
                    'data' => $data_insert,
                    'insurance_book_num'   => $insurance_book_num,
                    'health_insurance_num' => $health_insurance_num,
                    'city_code'            => $city_code,
                    'registration_medical'  => $registration_medical,
                    'start_date'  => $start_date,
                    'end_date'  => $end_date,
                    'file'  => $file,

                ]);
                die();
            }else{
                $month = $this->hrm_model->get_month();
                $staff = $this->staff_model->get();
                $data_null ='';
                $data_null  .=    '<div class="row insurance-history ">';
                $data_null  .=    '<div class="col-md-2">';
                $from_month = (isset($from_month) ? $from_month : '');
                $data_null  .=        '<div class="form-group">';
                $data_null  .=        '<label for="from_month[1]">'. _l('from_month').'</label>';
                $data_null  .=      '<select name="from_month[1]" class="selectpicker" id="from_month[1]" data-width="100%"';

                $data_null  .= 'data-none-selected-text="'. _l('dropdown_non_selected_tex').'">' ;
                $data_null  .=        '<option value=""></option>' ;

                foreach($month as $s){
                    $data_null  .=         '<option value="'.$s['id'].'">'.$s['name'].'</option>';
                }
                $data_null  .=     '</select>';
                $data_null  .=        '</div>';
                $data_null  .=    '</div>';
                $data_null  .=   '<div class="col-md-3">';
                $formality = isset($formality) ? $formality : '' ;
                $data_null  .=    '<label for="formality[1]" class="control-label">'. _l('formality').'</label>';
                $data_null  .=    '<select onchange="OnSelectReason (this)" name="formality[1]" class="selectpicker" id="';
                $data_null  .= 'formality[1]" data-width="100%" data-none-selected-text="'. _l('fillter_by_status').'">';
                $data_null  .=        '<option value=""></option>';
                $data_null  .=        '<option value="increase">'. _l('increase').'</option>';
                $data_null  .=        '<option value="decrease">'._l('decrease').'</option>';
                $data_null  .=    '</select>';
                $data_null  .=    '</div>';

                $data_null  .=    '<div class="col-md-3">';
                $reason = isset($reason) ? $reason : '' ;
                $data_null  .=    '<label for="reason[1]" class="control-label">'. _l('reason_').'</label>';
                $data_null  .=    '<select  name="reason[1]" class="selectpicker" id="reason[1]" data-width="100%"';

                $data_null  .= 'data-none-selected-text="'. _l('fillter_by_formality').'">' ;
                $data_null  .=        '<option value=""></option>';
                $data_null  .=    '</select>';
                $data_null  .=    '</div>';

                $data_null  .=    '<div class="col-md-3">';
                $premium_rates = isset($premium_rates) ? $premium_rates : '' ;

                $attr = array();
                $attr = ['data-type' => 'currency'];
                $data_null  .=    render_input('premium_rates[1]','premium_rates', $premium_rates,'text', $attr);
                $data_null  .=    '</div>';

                $data_null  .= '<div class="col-md-1 hrm-nowrap hrm-lineheight84" name="add_insurance_history">';
                $data_null  .=    '<button name="add_new_insurance_history" class="btn new_insurance_history btn-success hrm-radius20"';
                $data_null  .=  'data-ticket="true" type="button" title="'. _l('add') .'"><i class="fa fa-plus"></i></button>';
                $data_null  .=    '</div>';

                $data_null  .= '</div>';
                echo json_encode([
                    'id' => '',
                    'data_null' => $data_null,
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
