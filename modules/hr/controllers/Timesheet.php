<?php

class Timesheet extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Branches_model');
		$this->load->model('Staff_model');
		$this->load->model('Holidays_model');
		$this->load->model('Leave_model');
        $this->load->model('Leave_type_model');
	}

	public function holidays(){
		if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_holiday_table');
        }
        if($this->app_modules->is_active('branches')) {
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
        if (!is_admin()) {
            access_denied();
        }
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
        if (!is_admin()) {
            access_denied();
        }
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
        if (!$id) {
            access_denied();
        }
        if (!is_admin()) {
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
            $this->hrmapp->get_table_data('my_leave_table');
        }
        if($this->app_modules->is_active('branches')) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $data['leaves'] = $this->Leave_type_model->get();
        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('leaves');
        $this->load->view('timesheet/leaves/manage', $data);
	}
	public function leave_json($id)
    {
        $data = $this->Leave_model->get($id);
        $branch_id = '';
        if($this->Branches_model->get('staff', $data->staff_id))
            $branch_id = $this->Branches_model->get_branch('staff', $data->staff_id);
        $data->branch_id = $branch_id;
        echo json_encode($data);
    }

    public function get_leave_types_by_staff_id($staff_id){
        echo json_encode(['success'=>true,'data'=>$this->Leave_type_model->get_leave_types_by_staff_id($staff_id)]);
        die();
    }

    public function add_leave(){
    	//var_dump($this->input->post()); exit;
        if (!is_admin()) {
            access_denied();
        }
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
        if (!is_admin()) {
            access_denied();
        }
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
        if (!$id) {
            access_denied();
        }
        if (!is_admin()) {
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