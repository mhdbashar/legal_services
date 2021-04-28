<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Class Hr profile
 */
class Hr_profile extends AdminController
{
    /**
     * __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('hr_profile_model');
        $this->load->model('departments_model');
        $this->load->model('staff_model');
    }
    /**
     * email exist as staff
     * @return integer
     */
    private function email_exist_as_staff()
    {
        return total_rows(db_prefix().'departments', 'email IN (SELECT email FROM '.db_prefix().'staff)') > 0;
    }
    /**
     * get data department
     * @return json
     */
    public function get_data_department(){
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('hr', 'organizational/include/department_table'));
        }
    }
    public function organizational_chart(){
        if (!has_permission('staffmanage_orgchart', '', 'view')) {
            access_denied('hr_profile');
        }
        $this->load->model('staff_model');

        $data['list_department'] = $this->departments_model->get();
        $data['deparment_chart'] = json_encode( $this->hr_profile_model->get_data_departmentchart());
        $data['staff_members_chart'] = json_encode($this->hr_profile_model->get_data_chart());
        $data['list_staff'] = $this->staff_model->get();
        $data['email_exist_as_staff'] = $this->email_exist_as_staff();
        $data['title']                = _l('hr_organizational_chart');
        $data['dep_tree'] = json_encode($this->hr_profile_model->get_department_tree());
        $this->load->view('organizational/organizational_chart', $data);
    }

    /**
     * approval status
     * @return [type]
     */
    public function approval_status()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                $data = $this->input->post();

                $success = $this->hr_profile_model->update_approval_status($data);
                if ($success) {
                    $message = _l('hr_updated_successfully');
                    echo json_encode([
                        'success'              => true,
                        'message'              => $message,
                    ]);
                }else{
                    $message = _l('hr_updated_failed');
                    echo json_encode([
                        'success'              => false,
                        'message'              => $message,
                    ]);
                }
            }
        }
    }
    /**
     * table dependent person
     * @return [type]
     */
    public function table_dependent_person()
    {
        $this->app->get_table_data(module_views_path('hr', 'hr_profile/dependent_person/table_dependent_person'));
    }
    /**
     * import xlsx dependent person
     * @return [type]
     */
    public function import_xlsx_dependent_person()
    {
        if(!is_admin() && !has_permission('hrm_dependent_person','','create')) {
            access_denied('you_do_not_have_permission_create_dependent_person');
        }

        $data_staff = $this->hr_profile_model->get_staff(get_staff_user_id());

        /*get language active*/
        if($data_staff){
            if($data_staff->default_language != ''){
                $data['active_language'] = $data_staff->default_language;

            }else{

                $data['active_language'] = get_option('active_language');
            }

        }else{
            $data['active_language'] = get_option('active_language');
        }

        $this->load->view('hr_profile/dependent_person/import_dependent_person', $data);
    }

    /**
     * delete_error file day before
     * @return [type]
     */
    public function delete_error_file_day_before()
    {
        //Delete old file before 7 day
        $date = date_create(date('Y-m-d H:i:s'));
        date_sub($date,date_interval_create_from_date_string("7 days"));
        $before_7_day = strtotime(date_format($date,"Y-m-d H:i:s"));

        foreach(glob(HR_ERROR. '*') as $file) {

            $file_arr = explode("/",$file);
            $filename = array_pop($file_arr);

            if(file_exists($file)) {
                //don't delete index.html file
                if($filename != 'index.html'){
                    $file_name_arr = explode("_",$filename);
                    $date_create_file = array_pop($file_name_arr);
                    $date_create_file =  str_replace('.xlsx', '', $date_create_file);

                    if((float)$date_create_file <= (float)$before_7_day){
                        unlink(HR_PROFILE_ERROR.$filename);
                    }
                }
            }
        }
        return true;
    }
    /**
     * import dependent person excel
     * @return [type]
     */
    public function import_dependent_person_excel()
    {
        if(!class_exists('XLSXReader_fin')){
            require_once(module_dir_path(HR_MODULE_NAME).'/assets/plugins/XLSXReader/XLSXReader.php');
        }
        require_once(module_dir_path(HR_MODULE_NAME).'/assets/plugins/XLSXWriter/xlsxwriter.class.php');


        $filename ='';
        if($this->input->post()){
            if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {

                $this->delete_error_file_day_before();

                // Get the temp file path
                $tmpFilePath = $_FILES['file_csv']['tmp_name'];
                // Make sure we have a filepath
                if (!empty($tmpFilePath) && $tmpFilePath != '') {
                    $rows          = [];
                    $arr_insert          = [];

                    $tmpDir = TEMP_FOLDER . '/' . time() . uniqid() . '/';

                    if (!file_exists(TEMP_FOLDER)) {
                        mkdir(TEMP_FOLDER, 0755);
                    }

                    if (!file_exists($tmpDir)) {
                        mkdir($tmpDir, 0755);
                    }

                    // Setup our new file path
                    $newFilePath = $tmpDir . $_FILES['file_csv']['name'];

                    if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                        //Writer file
                        $writer_header = array(
                            _l('hr_hr_code') 			=>'string',
                            _l('hr_dependent_name') 	=>'string',
                            _l('hr_hr_relationship') 	=>'string',
                            _l('hr_dependent_bir') 		=>'string',
                            _l('hr_dependent_iden') 	=>'string',
                            _l('hr_reason_label') 		=>'string',
                            _l('hr_start_month') 		=>'string',
                            _l('hr_end_month') 			=>'string',
                            _l('hr_status_label') 		=>'string',
                            _l('error') 				=>'string'
                        );
                        $rowstyle[] =array('widths'=>[10,20,30,40]);

                        $writer = new XLSXWriter();
                        $writer->writeSheetHeader('Sheet1', $writer_header,  $col_options = ['widths'=>[40,40,40,50,40,40,40,40,50,50]]);

                        //Reader file
                        $xlsx = new XLSXReader_fin($newFilePath);
                        $sheetNames = $xlsx->getSheetNames();
                        $data = $xlsx->getSheetData($sheetNames[1]);

                        $arr_header = [];

                        $arr_header['staffid'] = 0;
                        $arr_header['dependent_name'] = 1;
                        $arr_header['relationship'] = 2;
                        $arr_header['dependent_bir'] = 3;
                        $arr_header['dependent_iden'] = 4;
                        $arr_header['reason'] = 5;
                        $arr_header['start_month'] = 6;
                        $arr_header['end_month'] = 7;
                        $arr_header['status'] = 8;


                        $total_rows = 0;
                        $total_row_false    = 0;

                        for ($row = 1; $row < count($data); $row++) {

                            $total_rows++;

                            $rd = array();
                            $flag = 0;
                            $flag2 = 0;

                            $string_error ='';
                            $flag_position_group;
                            $flag_department = null;

                            $value_staffid 	= isset($data[$row][$arr_header['staffid']]) ? $data[$row][$arr_header['staffid']] : '' ;
                            $value_dependent_name 	= isset($data[$row][$arr_header['dependent_name']]) ? $data[$row][$arr_header['dependent_name']] : '' ;
                            $value_relationship 	= isset($data[$row][$arr_header['relationship']]) ? $data[$row][$arr_header['relationship']] : '' ;
                            $value_dependent_bir 	= isset($data[$row][$arr_header['dependent_bir']]) ? $data[$row][$arr_header['dependent_bir']] : '' ;
                            $value_dependent_iden 	= isset($data[$row][$arr_header['dependent_iden']]) ? $data[$row][$arr_header['dependent_iden']] : '' ;
                            $value_reason 	= isset($data[$row][$arr_header['reason']]) ? $data[$row][$arr_header['reason']] : '' ;
                            $value_start_month 	= isset($data[$row][$arr_header['start_month']]) ? $data[$row][$arr_header['start_month']] : '' ;
                            $value_end_month 	= isset($data[$row][$arr_header['end_month']]) ? $data[$row][$arr_header['end_month']] : '' ;
                            $value_status 	= isset($data[$row][$arr_header['status']]) ? $data[$row][$arr_header['status']] : '' ;


                            /*check null*/
                            if(is_null($value_staffid) == true){
                                $string_error .=_l('hr_hr_code'). _l('not_yet_entered');
                                $flag = 1;
                            }

                            $flag_staff_id = 0 ;
                            //check hr_code exist 
                            if(is_null($value_staffid) != true){
                                $this->db->where('staff_identifi', $value_staffid);
                                $hrcode = $this->db->get(db_prefix() . 'staff')->row();
                                if($hrcode){
                                    $flag_staff_id = $hrcode->staffid;
                                }else{
                                    $string_error .=_l('hr_hr_code'). _l('does_not_exist');
                                    $flag2 = 1;
                                }

                            }


                            //check start_time
                            if(is_null($value_dependent_bir) != true && $value_dependent_bir != ''){

                                if (is_null($value_dependent_bir) != true) {

                                    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", trim($value_dependent_bir, " "))) {
                                        $test = true;

                                    } else {
                                        $flag2 = 1;
                                        $string_error .= _l('hr_dependent_bir') . _l('invalid');
                                    }
                                }
                            }

                            //check start_time
                            if(is_null($value_start_month) != true && $value_start_month != ''){

                                if (is_null($value_start_month) != true) {

                                    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", trim($value_start_month, " "))) {
                                        $test = true;

                                    } else {
                                        $flag2 = 1;
                                        $string_error .= _l('hr_start_month') . _l('invalid');
                                    }
                                }
                            }

                            if(is_null($value_end_month) != true && $value_end_month != ''){

                                if (is_null($value_end_month) != true) {

                                    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", trim($value_end_month, " "))) {
                                        $test = true;

                                    } else {
                                        $flag2 = 1;
                                        $string_error .= _l('hr_end_month') . _l('invalid');
                                    }
                                }
                            }


                            if(($flag == 1) || $flag2 == 1 ){
                                //write error file
                                $writer->writeSheetRow('Sheet1', [
                                    $value_staffid,
                                    $value_dependent_name,
                                    $value_relationship,
                                    $value_dependent_bir,
                                    $value_dependent_iden,
                                    $value_reason,
                                    $value_start_month,
                                    $value_end_month,
                                    $value_status,
                                    $string_error,
                                ]);

                                // $numRow++;
                                $total_row_false++;
                            }

                            if($flag == 0 && $flag2 == 0){

                                if(is_numeric($value_status) && ($value_status == '2')){
                                    /*reject*/
                                    $rd['status'] = 2;
                                }else {
                                    /*approval*/
                                    $rd['status'] = 1;
                                }

                                $rd['staffid'] 				= $flag_staff_id;
                                $rd['dependent_name'] 		= $value_dependent_name;
                                $rd['relationship'] 		= $value_relationship;
                                $rd['dependent_bir'] 		= $value_dependent_bir;
                                $rd['dependent_iden'] 		= $value_dependent_iden;
                                $rd['reason'] 				= $value_reason;
                                $rd['start_month'] 			= $value_start_month;
                                $rd['end_month'] 			= $value_end_month;

                                $rows[] = $rd;
                                array_push($arr_insert, $rd);

                            }

                        }

                        //insert batch
                        if(count($arr_insert) >0 ){

                            $this->db->insert_batch(db_prefix().'hr_dependent_person', $arr_insert);
                        }

                        $total_rows = $total_rows;
                        $total_row_success = isset($rows) ? count($rows) : 0;
                        $dataerror = '';
                        $message ='Not enought rows for importing';

                        if($total_row_false != 0){
                            $filename = 'Import_dependent_person_error_'.get_staff_user_id().'_'.strtotime(date('Y-m-d H:i:s')).'.xlsx';
                            $writer->writeToFile(str_replace($filename, HR_ERROR.$filename, $filename));
                        }


                    }
                }
            }
        }


        if (file_exists($newFilePath)) {
            @unlink($newFilePath);
        }

        echo json_encode([
            'message'           => $message,
            'total_row_success' => $total_row_success,
            'total_row_false'   => $total_row_false,
            'total_rows'        => $total_rows,
            'site_url'          => site_url(),
            'staff_id'          => get_staff_user_id(),
            'filename'          => HR_ERROR.$filename,
        ]);
    }

    /**
     * dependent person modal
     * @return [type]
     */
    public function dependent_person_modal()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $this->load->model('staff_model');

        $data['staff_members'] = $this->staff_model->get('', ['active' => 1]);

        if ($this->input->post('slug') === 'create') {
            $data['manage'] = $this->input->post('manage');
            $this->load->view('hr_profile/dependent_person/dependent_person_modal', $data);
        } else if ($this->input->post('slug') === 'update') {

            $data['manage'] = $this->input->post('manage');
            $data['dependent_person_id'] = $this->input->post('dependent_person_id');
            $data['dependent_person'] = $this->hr_profile_model->get_dependent_person($data['dependent_person_id']);

            if (isset($data['notes'])) {
                $data['notes'] = htmlentities($data['notes']);
            }

            $this->load->view('hr_profile/dependent_person/dependent_person_modal', $data);
        }
    }

    /**
     * approval dependents
     * @return [type]
     */
    public function dependent_persons()
    {

        if( !is_admin() && !has_permission('hrm_dependent_person', '', 'view')){
            access_denied('You_do_not_have_permission_to_approve');
        }

        $data['approval'] = $this->hr_profile_model->get_dependent_person();
        $data['staff'] = $this->staff_model->get();

        $this->load->view('hr_profile/dependent_person/manage_dependent_person', $data);
    }
    /**
     * dependent person
     * @param  string $id
     * @return [type]
     */
    public function dependent_person($id = '')
    {
        if ($this->input->post()) {
            $message          = '';
            $data             = $this->input->post();

            if ($this->input->post('id') == null) {
                $manage = $this->input->post('manage');
                unset($data['manage']);

                $id = $this->hr_profile_model->add_dependent_person($data);
                if ($id) {
                    $success = true;
                    $message = _l('added_successfully', _l('hr_dependent_persons'));
                    set_alert('success', $message);
                }else{
                    $message = _l('added_failed', _l('hr_dependent_persons'));
                    set_alert('warning', $message);
                }

                if($manage){
                    redirect(admin_url('hr/hr_profile/dependent_persons'));
                }else{
                    redirect(admin_url('hr/hr_profile/member/'.get_staff_user_id().'/dependent_person'));
                }
            } else {
                $manage = $this->input->post('manage');
                $id = $data['id'];
                unset($data['id']);
                unset($data['manage']);
                $success = $this->hr_profile_model->update_dependent_person($data, $id);

                if ($success) {
                    $message = _l('updated_successfully', _l('hr_dependent_persons'));
                    set_alert('success', $message);
                }else{
                    $message = _l('updated_failed', _l('hr_dependent_persons'));
                    set_alert('warning', $message);
                }

                if($manage){
                    redirect(admin_url('hr/hr_profile/dependent_persons'));
                }else{
                    redirect(admin_url('hr/hr_profile/member/'.get_staff_user_id().'/dependent_person'));
                }
            }
        }
    }
}