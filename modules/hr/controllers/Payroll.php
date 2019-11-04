<?php

class Payroll extends AdminController{


	public function __construct(){
		parent::__construct();
		$this->load->model('Salary_model');
		$this->load->model('Commissions_model');
		$this->load->model('Other_payment_model');
		$this->load->model('Lean_model');
		$this->load->model('Overtime_model');
		$this->load->model('Allowances_model');
		$this->load->model('Statutory_deduction_model');
		$this->load->model('Payments_model');
	}

	public function count_result($staff_id){
		
		$other_payments = $this->Other_payment_model->count_results($staff_id);
		$data['total_other_payments'] = 0;
		foreach ($other_payments as $other_payment) {
			$data['total_other_payments'] += $other_payment['amount'];
		}

		$deductions = $this->Statutory_deduction_model->count_results($staff_id);
		$data['total_deductions'] = 0;
		foreach ($deductions as $deduction) {
			$data['total_deductions'] += $deduction['amount'];
		}

		$overtimes = $this->Overtime_model->count_results($staff_id);
		$data['total_overtime'] = 0;
		foreach ($overtimes as $overtime) {
			$data['total_overtime'] += $overtime['rate'] * $overtime['num_days'] * $overtime['num_hours'];
		}

		$commissions = $this->Commissions_model->count_results($staff_id);
		$data['total_commissions'] = 0;
		foreach ($commissions as $commission) {
			$data['total_commissions'] += $commission['amount'];
		}

		$salary = $this->Salary_model->count_results($staff_id);
		if(isset($salary->amount)){
			$data['salary'] = $salary->amount;
			$data['type'] = $salary->type;
		}else{
			$data['salary'] = 0;
		}

		$data['staff_id'] = $staff_id;
		$allowances = $this->Allowances_model->count_results($staff_id);
		$data['total_allowances'] = 0;
		foreach ($allowances as $allowance) {
			$data['total_allowances'] += $allowance['amount'];
		}

		$data['payment_amount'] = $data['salary'] + $data['total_commissions'] + $data['total_allowances'] + $data['total_overtime'] + $data['total_other_payments'] - $data['total_deductions'];
        echo json_encode($data);
	}

	public function make_payment(){
        $data = $this->input->post();
        unset($data['payment_amount']);
        $success = $this->Payments_model->add($data);
        if($success)
            set_alert('success', 'Payed successfully');
        else
            set_alert('warning', 'Problem Paying');
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function index($month = '', $year = ''){
		if($month == ''){
			$date = date_parse_from_format("Y-m-d", date('Y-m-d'));
			$month = $date["month"];
        }

        if($year == ''){
			$date = date_parse_from_format("y-m-d", date('y-m-d'));
			$year = $date["year"];
        }

        if ($this->input->get('year') and $this->input->get('month')) {
            redirect(site_url().'hr/payroll/index/'.$this->input->get('month').'/'.$this->input->get('year'));
        }

		if ($this->input->is_ajax_request()) {
            $this->hrmapp->get_table_data('my_payroll_table', ['month' => $month, 'year' => $year]);
        }

        $data['title'] = "Payroll";

		$data['month'] = $month;

		$data['year'] = $year;

		$this->load->view('payroll/manage', $data);
	}
}