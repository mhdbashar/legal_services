<?php

class Holidays extends AdminController{

	public function __construct(){

		parent::__construct();
		$this->load->model('Holidays_model');
	}

	public function index($month = '', $year = ''){

        if($month == ''){
			$date = date_parse_from_format("Y-m-d", date('Y-m-d'));
			$month = $date["month"];
        }

        if ($this->input->get('year')) {
            redirect(site_url().'hr/holidays/index/'.$month.'/'.$this->input->get('year'));
        }

        if($year == ''){
			$date = date_parse_from_format("y-m-d", date('y-m-d'));
			$year = $date["year"];
        }
        if ($this->input->is_ajax_request()) {
            $this->hrmapp->get_table_data('my_holiday_table', ['month' => $month, 'year' => $year]);
        }

		$data['title'] = _l("holidays");

		$data['month'] = $month;

		$data['year'] = $year;

		$this->load->view('holiday/manage', $data);
	}

	public function json($id){
        $data = $this->Holidays_model->get($id);
        echo json_encode($data);
    }

    public function update(){
        $data = $this->input->post();
        $id = $this->input->post('holiday_id');
        $success = $this->Holidays_model->update($data, $id);
        if($success)
            set_alert('success', 'Holiday Updated successfully');
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add(){
        $data = $this->input->post();
        $success = $this->Holidays_model->add($data);
        if($success)
            set_alert('success', 'Holiday Added successfully');
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        if (!$id) {
            redirect(admin_url('hr/holidays'));
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Holidays_model->delete($id);
        if ($response == true) {
            set_alert('success', 'Deleted Holiday');
        } else {
            set_alert('warning', 'Problem deleting Holiday');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}