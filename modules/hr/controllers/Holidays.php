<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Holidays extends AdminController{

    public function __construct(){
        parent::__construct();
        $this->load->model('holidays_model');
        $this->load->model('Branches_model');
    }

    public function index(){
        if(!is_admin()){
            access_denied();
        }

        if($this->input->is_ajax_request()){
            $this->hrmapp->get_table_data('my_holiday_table');
        }
        if($this->app_modules->is_active('branches')) {
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();
        }
        $data['title'] = _l("holiday");
        $this->load->view('timesheet/holidays/manage', $data);
    }
    public function get($id)
    {
        $branch_id = '';
        if($this->Branches_model->get('holidays', $id))
            $branch_id = $this->Branches_model->get_branch('holidays', $id);
        $data = $this->holidays_model->getHolidays($id);
        $data->branch_id = $branch_id;
        echo json_encode($data);
    }


    public function add(){
        if (!is_admin()) {
            access_denied();
        }
        if ($this->input->get()) {
            $data            = $this->input->get();
            $branch_id = $data['branch_id'];
            unset($data['branch_id']);
            // $data['message'] = $this->input->post('message', false);
            $success = $this->holidays_model->add($data);
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
            redirect('hr/holidays');
        }
    }
    
    public function update(){
        if (!is_admin()) {
            access_denied();
        }
        if ($this->input->get()) {
            $data            = $this->input->get();
            $branch_id = $data['branch_id'];
            unset($data['branch_id']);
            $id              = $this->input->get('id');
            // $data['message'] = $this->input->post('message', false);
            $success = $this->holidays_model->update($data, $id);
            $this->Branches_model->update_branch('holidays', $id, $branch_id);
            
            redirect('hr/Holidays');
        }
        if ($id == '')
        redirect('hr/holidays');
    }
    public function delete($id)
    {
        if (!$id) {
            access_denied();
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->holidays_model->delete($id);
        if ($response == true) {
            set_alert('success', "Holiday Deleted Successfully");
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect('hr/Holidays');
    }
}

// class Holidays extends AdminController{

// 	public function __construct(){

// 		parent::__construct();
// 		$this->load->model('Holidays_model');
// 	}

// 	public function index($month = '', $year = ''){

//         if($month == ''){
// 			$date = date_parse_from_format("Y-m-d", date('Y-m-d'));
// 			$month = $date["month"];
//         }

//         if ($this->input->get('year')) {
//             redirect(site_url().'hr/holidays/index/'.$month.'/'.$this->input->get('year'));
//         }

//         if($year == ''){
// 			$date = date_parse_from_format("y-m-d", date('y-m-d'));
// 			$year = $date["year"];
//         }
//         if ($this->input->is_ajax_request()) {
//             $this->hrmapp->get_table_data('my_holiday_table', ['month' => $month, 'year' => $year]);
//         }

// 		$data['title'] = _l("holidays");

// 		$data['month'] = $month;

// 		$data['year'] = $year;

// 		$this->load->view('holiday/manage', $data);
// 	}

// 	public function json($id){
//         $data = $this->Holidays_model->get($id);
//         echo json_encode($data);
//     }

//     public function update(){
//         $data = $this->input->post();
//         $id = $this->input->post('holiday_id');
//         $success = $this->Holidays_model->update($data, $id);
//         if($success)
//             set_alert('success', 'Holiday Updated successfully');
//         else
//             set_alert('warning', 'Problem Updating');
//         redirect($_SERVER['HTTP_REFERER']);
//     }

//     public function add(){
//         $data = $this->input->post();
//         $success = $this->Holidays_model->add($data);
//         if($success)
//             set_alert('success', 'Holiday Added successfully');
//         else
//             set_alert('warning', 'Problem Creating');
//         redirect($_SERVER['HTTP_REFERER']);
//     }

//     public function delete($id)
//     {
//         if (!$id) {
//             redirect(admin_url('hr/holidays'));
//         }
//         if (!is_admin()) {
//             access_denied();
//         }
//         $response = $this->Holidays_model->delete($id);
//         if ($response == true) {
//             set_alert('success', 'Deleted Holiday');
//         } else {
//             set_alert('warning', 'Problem deleting Holiday');
//         }
//         redirect($_SERVER['HTTP_REFERER']);
//     }
// }