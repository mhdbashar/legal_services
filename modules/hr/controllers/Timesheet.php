<?php

class Timesheet extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Branches_model');
		$this->load->model('Staff_model');
		$this->load->model('Holidays_model');
		$this->load->model('Leave_model');
        $this->load->model('Leave_type_model');
        $this->load->model('Overtime_request_model');
        $this->load->model('Office_shift_model');
        $this->load->model('No_branch_model');
        $this->load->model('Extra_info_model');
	}

    private function dateDiffInDays($date1, $date2)  
    { 
        // Calulating the difference in timestamps 
        $diff = strtotime($date2) - strtotime($date1); 
          
        // 1 day = 24 hours 
        // 24 * 60 * 60 = 86400 seconds 
        return abs(round($diff / 86400)); 
    }

    public function calendar(){
        if (!has_permission('hr', '', 'view'))
            access_denied();
        $month = date("m");
        $year = date("Y");
        $data['office_shift_days'] = [];
        if(!empty($this->input->get())){
            $year_month = DateTime::createFromFormat('Y-m', $this->input->get('month'));
            $year = $year_month->format('Y');
            $month = $year_month->format('m');
            $staff_id = $this->input->get('staff_id');
            $attendances = $this->Office_shift_model->get_attendance_for_staff($staff_id, $month);
            $times_in = [];
            if(!empty($attendances)){
                foreach ($attendances as $attendance) {
                    $times_in[] = $attendance['created'];
                }
            }
            //var_dump($times_in); exit;


            $number_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            

            $start = $year . '-' . $month . '-' . '1';
            $end = $year . '-' . $month . '-' . $number_of_days;

            $office_shift = $this->Office_shift_model->get_office_shift_for_staff($staff_id);

            $staff_leaves = $this->Leave_model->get_leaves_for_staff($staff_id, $start, $end);

            $leaves = [];
            foreach ($staff_leaves as $leave) {
                $days_diffs = $this->dateDiffInDays($leave['start_date'], $leave['end_date']) + 1;
                for ($i = 0; $i < $days_diffs; $i++){
                    $leaves[] = date('Y-m-d', strtotime($leave['start_date']. " + $i days"));
                }
            } 

            $sat = false; $sun = false; $mon = false; $tue = false; $wed = false; $thu = false; $fri = false;
            if(!empty($office_shift->saturday_in))
                $sat = true;
            if(!empty($office_shift->sunday_in))
                $sun = true;
            if(!empty($office_shift->monday_in))
                $mon = true;
            if(!empty($office_shift->tuesday_in))
                $tue = true;
            if(!empty($office_shift->wednesday_in))
                $wed = true;
            if(!empty($office_shift->thursday_in))
                $thu = true;
            if(!empty($office_shift->friday_in))
                $fri = true;

            $office_shift_days = [];
            for($i = 1; $i <= $number_of_days; $i++){
                if($i < 10)
                    $i = "0$i";
                else
                    $i = "$i";
                $datetime = DateTime::createFromFormat('Ymd', "$year$month$i");
                $standard_date = $datetime->format('Y-m-d');
                $day_name = $datetime->format('D');
                //echo $day_name; exit;
                if($day_name == 'Sat' and $sat){
                    if(in_array($standard_date, $leaves))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-warning">Leave</span>';
                    elseif(in_array($standard_date, $times_in))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-primary">Present</span>';
                    else
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-danger">Absent</span>';
                }
                elseif($day_name == 'Sun' and $sun == true){
                    if(in_array($standard_date, $leaves))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-warning">Leave</span>';
                    elseif(in_array($standard_date, $times_in))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-primary">Present</span>';
                    else
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-danger">Absent</span>';
                }
                elseif($day_name == 'Mon' and $mon == true){
                    if(in_array($standard_date, $leaves))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-warning">Leave</span>';
                    elseif(in_array($standard_date, $times_in))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-primary">Present</span>';
                    else
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-danger">Absent</span>';
                }
                elseif($day_name == 'Tue' and $tue == true){
                    if(in_array($standard_date, $leaves))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-warning">Leave</span>';
                    elseif(in_array($standard_date, $times_in))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-primary">Present</span>';
                    else
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-danger">Absent</span>';
                }
                elseif($day_name == 'Wed' and $wed == true){
                    if(in_array($standard_date, $leaves))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-warning">Leave</span>';
                    elseif(in_array($standard_date, $times_in))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-primary">Present</span>';
                    else
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-danger">Absent</span>';
                }
                elseif($day_name == 'Thu' and $thu == true){
                    if(in_array($standard_date, $leaves))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-warning">Leave</span>';
                    elseif(in_array($standard_date, $times_in))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-primary">Present</span>';
                    else
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-danger">Absent</span>';
                }
                elseif($day_name == 'Fri' and $fri == true){
                    if(in_array($standard_date, $leaves))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-warning">Leave</span>';
                    elseif(in_array($standard_date, $times_in))
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-primary">Present</span>';
                    else
                        $office_shift_days[(int)$i] = '<span class="circle mtop20 text-center bg-danger">Absent</span>';
                }
            }
            $data['office_shift_days'] = $office_shift_days;
        }

        $data['month'] = $month;
        $data['year'] = $year;
        $data['staff_members'] = $this->staff_model->get('', ['active' => 1]);
        //var_dump($office_shift_days); exit;
        $this->load->view('timesheet/attendance/calendar', $data);
    }

    //attendance
    public function attendance(){
        if (!has_permission('hr', '', 'view'))
            access_denied();
        if(!empty($this->input->get('date')))
            $date = $this->input->get('date');
        else
            $date = date("Y-m-d");
        //echo $date; exit;
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_attendance_table', ['date' => $date]);
        }
        $data['title'] = _l('attendance');
        if(true) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $this->load->view('timesheet/attendance/manage', $data);
    }

    //date_wise_attendance
    public function date_wise_attendance(){
        if (!has_permission('hr', '', 'view'))
            access_denied();
        if(!empty($this->input->get('start_date')) and !empty($this->input->get('end_date'))  and !empty($this->input->get('staff_id'))){
            $start_date = $this->input->get('start_date');
            $end_date = $this->input->get('end_date');
            $staff_id = $this->input->get('staff_id');
        }
        else{
            $start_date = date("Y-m-d");
            $end_date = date("Y-m-d");
            $staff_id = 1;
        }
        //echo $date; exit;
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_date_wise_attendance_table', ['start_date' => $start_date, 'end_date' => $end_date, 'staff_id' => $staff_id]);
        }
        //echo $start_date.' '.$end_date;exit;
        $data['title'] = _l('attendance');
        $data['staff_members'] = $this->staff_model->get('', ['active' => 1]);
        if(true) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $this->load->view('timesheet/attendance/date_wise_attendance', $data);
    }

    //office_shift
    public function office_shift(){
        if (!has_permission('hr', '', 'view'))
            access_denied();
        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_office_shift_table');
        }
        $data['title'] = _l('office_shift');
        $data['staffes'] = $this->Extra_info_model->get_staffs();
        if($this->app_modules->is_active('branches')) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $this->load->view('timesheet/office_shift/manage', $data);
    }

    public function json_office_shift($id){
        $branch_id = '';
        if($this->Branches_model->get('office_shift', $id))
            $branch_id = $this->Branches_model->get_branch('office_shift', $id);
        $data = $this->Office_shift_model->get($id);
        $data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_office_shift(){
        if (!has_permission('hr', '', 'view'))
            access_denied();
        $data = $this->input->post();
        if($this->app_modules->is_active('branches'))
            $branch_id = $data['branch_id'];
        else
            $branch_id = $this->No_branch_model->get_general_branch();
        if($data['default'] == 1){
            $this->db->where('default', 1);
            $this->db->update(db_prefix() . 'hr_office_shift', ['default'=>0]);
        }
        unset($data['branch_id']);
        foreach ($data as $key => $value) {
            if($value == '')
                $data[$key] = null;
        }
        $id = $this->input->post('id');
        $success = $this->Office_shift_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

            $this->Branches_model->update_branch('office_shift', $id, $branch_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_office_shift(){
        if (!has_permission('hr', '', 'view'))
            access_denied();
        $data = $this->input->post();
        if($this->app_modules->is_active('branches'))
            $branch_id = $data['branch_id'];
        else
            $branch_id = $this->No_branch_model->get_general_branch();
        if($data['default'] == 1){
            $this->db->where('default', 1);
            $this->db->update(db_prefix() . 'hr_office_shift', ['default'=>0]);
        }
        unset($data['branch_id']);
        foreach ($data as $key => $value) {
            if($value == '')
                $data[$key] = null;
        }
        //var_dump($data);exit;

        $success = $this->Office_shift_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');


        if(is_numeric($branch_id)){
            $branch_data = [
                'branch_id' => $branch_id, 
                'rel_type' => 'office_shift', 
                'rel_id' => $success
            ];
            $this->Branches_model->set_branch($branch_data);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_office_shift($id)
    {
        if (!has_permission('hr', '', 'view'))
            access_denied();
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $response = $this->Office_shift_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    //overtime_requests
    public function overtime_requests(){

        if($this->input->is_ajax_request()){
            if (has_permission('hr', '', 'view'))
                $this->hrmapp->get_table_data('my_overtime_requests_table');
            else
                $this->hrmapp->get_table_data('my_overtime_requests_table', ['staff_id' => get_staff_user_id()]);
        }
        $data['title'] = _l('overtime_requests');
        $data['staffes'] = $this->Extra_info_model->get_staffs();
        if($this->app_modules->is_active('branches')) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $this->load->view('timesheet/overtime_request/manage', $data);
    }

    public function json_overtime_request($id){
        $data = $this->Overtime_request_model->get($id);
        echo json_encode($data);
    }
    public function update_overtime_request(){
        if (!has_permission('hr', '', 'view'))
            access_denied();
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Overtime_request_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_overtime_request(){
        $data = $this->input->post();
        $success = $this->Overtime_request_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_overtime_request($id)
    {
        if (!has_permission('hr', '', 'view'))
            access_denied();
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $response = $this->Overtime_request_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function holidays(){
        if (!has_permission('hr', '', 'view'))
            access_denied();
		if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_holiday_table');
        }
        if(true) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('holidays');
        $this->load->view('timesheet/holidays/manage', $data);
	}
	public function holiday_json($id)
    {
    	$branch_id = '';
    	if($this->Branches_model->get('holidays', $id))
            $branch_id = $this->Branches_model->get_branch('holidays', $id);
        $data = $this->Holidays_model->getHolidays($id);
        $data->branch_id = $branch_id;
        echo json_encode($data);
    }

    public function add_holiday(){
        if (!has_permission('hr', '', 'view'))
            access_denied();
        if ($this->input->get()) {
            $data            = $this->input->get();
            $branch_id = $data['branch_id'];
            unset($data['branch_id']);
            // $data['message'] = $this->input->post('message', false);
            $success = $this->Holidays_model->add($data);
            if(is_numeric($branch_id)){
                $branch_data = [
                    'branch_id' => $branch_id, 
                    'rel_type' => 'holidays', 
                    'rel_id' => $success
                ];
                $this->Branches_model->set_branch($branch_data);
            }
            if ($success) {
                set_alert('success', 'Holiday Added Successfully');
            }
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function update_holiday(){
        if (!has_permission('hr', '', 'view'))
            access_denied();
        if ($this->input->get()) {
            $data            = $this->input->get();
            $branch_id = $data['branch_id'];
            unset($data['branch_id']);
            $id              = $this->input->get('id');
            // $data['message'] = $this->input->post('message', false);
            $success = $this->Holidays_model->update($data, $id);
            $this->Branches_model->update_branch('holidays', $id, $branch_id);
            
            redirect('hr/Holidays');
        }
        if ($id == '')
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function delete_holiday($id)
    {
        if (!has_permission('hr', '', 'view'))
            access_denied();
        if (!$id) {
            access_denied();
        }
        $response = $this->Holidays_model->delete($id);
        if ($response == true) {
            set_alert('success', "Holiday Deleted Successfully");
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    //leaves

    public function leaves(){
		if($this->input->is_ajax_request()){
            if (has_permission('hr', '', 'view'))
                $this->hrmapp->get_table_data('my_leave_table');
            else
                $this->hrmapp->get_table_data('my_leave_table', ['staff_id' => get_staff_user_id()]);
        }
        if(true) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $data['leaves'] = $this->Leave_type_model->get();
        $data['staffes'] = $this->Extra_info_model->get_staffs();
        $data['title'] = _l('leaves');
        $this->load->view('timesheet/leaves/manage', $data);
	}
	public function leave_json($id)
    {
        $data = $this->Leave_model->get($id);
        $branch_id = '';
        if($this->Branches_model->get('staff', $data->staff_id))
            $branch_id = $this->Branches_model->get_branch('staff', $data->staff_id);
            if(!$this->app_modules->is_active('branches'))
                $branch_id = $this->No_branch_model->get_branch('staff', $data->staff_id);
        $data->branch_id = $branch_id;
        echo json_encode($data);
    }

    public function get_leave_types_by_staff_id($staff_id){
        echo json_encode(['success'=>true,'data'=>$this->Leave_type_model->get_leave_types_by_staff_id($staff_id)]);
        die();
    }

    public function add_leave(){
    	
        if ($this->input->post()) {
            $data            = $this->input->post();
            $branch_id = $data['branch_id'];
            unset($data['branch_id']);

            $start_date = strtotime($data['start_date']);
            $end_date = strtotime($data['end_date']);
            $datediff = $end_date - $start_date;
            $all_date = round($datediff / (60 * 60 * 24)) + 1;
            if (isset($data['half_day'])){
                if($data['half_day'] == 'true'){
                    if($all_date != 1){
                        set_alert('warning', _l('apply_halfday_leave_for_more_than_one_day'));
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            }else{
                $all_date *= 2;
            }
            //echo $all_date; exit;
            if(!$this->Leave_type_model->has_days(
                $data['staff_id'],
                $data['leave_type'],
                $all_date,
                $this->Leave_type_model->get_leave_type_days($data['leave_type']),
                date('Y')
            )){
                set_alert('warning', _l("you_cannot_add_this_leave_for_this_staff"));
                redirect($_SERVER['HTTP_REFERER']);
            }
            // $data['message'] = $this->input->post('message', false);
            $success = $this->Leave_model->add($data);
            if ($success) {
                $success2 = $this->Leave_type_model->add_leave_to_staff(
                    [
                        'staff_id' => $data['staff_id'],
                        'leave_id' => $data['leave_type'],
                        'leaveid' => $success,
                        'days' => $all_date, //$this->Leave_type_model->get_leave_type_days($data['leave_type'])
                        'created' => date('Y')
                    ]
                );
                if($success2){
                    set_alert('success', _l('added_successfully'));
                }else{
                    set_alert('warning', _l('problem_adding'));
                }
            }
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function update_leave(){
        if (!has_permission('hr', '', 'view'))
            access_denied();
        if ($this->input->post()) {
            $data            = $this->input->post();
            if (!isset($data['half_day'])) {
                $data['half_day'] = 0;
            }else{
                $data['half_day'] = 1;
            }
            $branch_id = $data['branch_id'];
            unset($data['branch_id']);
            $id              = $this->input->post('id');
            if($data['half_day'] == 1){
                $start_date = strtotime($data['start_date']);
                $end_date = strtotime($data['end_date']);
                $datediff = $end_date - $start_date;
                $all_date = round($datediff / (60 * 60 * 24));
                if($all_date != 0){
                    set_alert('warning', 'You can not apply for more than Day');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            // $data['message'] = $this->input->post('message', false);
            $success = $this->Leave_model->update($data, $id);
            
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($id == '')
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function delete_leave($id)
    {
        if (!has_permission('hr', '', 'view'))
            access_denied();
        if (!$id) {
            access_denied();
        }
        $response = $this->Leave_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}