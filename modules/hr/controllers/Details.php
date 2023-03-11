<?php

class Details extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Salary_model');
		$this->load->model('Commissions_model');
		$this->load->model('Other_payment_model');
		$this->load->model('Loan_model');
		$this->load->model('Overtime_model');
		$this->load->model('Allowances_model');
		$this->load->model('Statutory_deduction_model');

        if (!has_permission('hr', '', 'view') && !has_permission('hr', '', 'view_own')  and !has_permission('hr', '', 'edit'))
            access_denied();
	}

	
    public function general($staff_id){

        $data['staff_id'] = $staff_id;
        $group = '';

        if(!$this->input->get('group')){
            $_GET['group'] = 'basic_information';
        }else{
            $group = $this->input->get('group');
        }
        if ($this->input->is_ajax_request()) {
            if($group == 'qualification'){
                $this->hrmapp->get_table_data('my_qualification_table', ['staff_id' => $staff_id]);
            }elseif($group == 'other_payments'){
                $this->hrmapp->get_table_data('my_other_payments_table', ['staff_id' => $staff_id]);
            }elseif($group == 'loan'){
                $this->hrmapp->get_table_data('my_loan_table', ['staff_id' => $staff_id]);
            }elseif($group == 'overtime'){
                $this->hrmapp->get_table_data('my_overtime_table', ['staff_id' => $staff_id]);
            }elseif($group == 'allowances'){
                $this->hrmapp->get_table_data('my_allowances_table', ['staff_id' => $staff_id]);
            }elseif($group == 'statutory_deductions'){
                $this->hrmapp->get_table_data('my_statutory_deductions_table', ['staff_id' => $staff_id]);
            }
        }
//qualification
        $staff = ['type' => '', 'amount' => 0];

        $data['staff'] = (object)$staff;

        if($this->Salary_model->get($staff_id)){
            $data['staff'] = $this->Salary_model->get($staff_id);
        }

        $data['group'] = $group;
        $data['staff_id'] = $staff_id;
        $data['title'] = _l('salary');

        $this->load->view('details/general/manage', $data);
    }
    
	public function salary($staff_id){

		$group = '';

		if(!$this->input->get('group')){
			$_GET['group'] = 'update_salary';
		}else{
			$group = $this->input->get('group');
		}
		if ($this->input->is_ajax_request()) {
			if($group == 'commissions'){
				$this->hrmapp->get_table_data('my_commissions_table', ['staff_id' => $staff_id]);
			}elseif($group == 'other_payments'){
		        $this->hrmapp->get_table_data('my_other_payments_table', ['staff_id' => $staff_id]);
			}elseif($group == 'loan'){
		        $this->hrmapp->get_table_data('my_loan_table', ['staff_id' => $staff_id]);
			}elseif($group == 'overtime'){
		        $this->hrmapp->get_table_data('my_overtime_table', ['staff_id' => $staff_id]);
			}elseif($group == 'allowances'){
		        $this->hrmapp->get_table_data('my_allowances_table', ['staff_id' => $staff_id]);
			}elseif($group == 'statutory_deductions'){
		        $this->hrmapp->get_table_data('my_statutory_deductions_table', ['staff_id' => $staff_id]);
			}
		}

		$staff = ['type' => '', 'amount' => 0];

		$data['staff'] = (object)$staff;

		if($this->Salary_model->get($staff_id)){
			$data['staff'] = $this->Salary_model->get($staff_id);
		}

		$data['group'] = $group;
		$data['staff_id'] = $staff_id;
		$data['title'] = _l('salary');
		$this->load->view('details/salary/manage', $data);
	}


	public function update_salary(){
        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $staff_id = $this->input->post('staff_id');
        $success = $this->Salary_model->update($data, $staff_id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
	}

	// commission

	public function json_commission($id){
        $data = $this->Commissions_model->get($id);
        echo json_encode($data);
    }
    public function update_commission(){
        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Commissions_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function add_commission(){
        if (!has_permission('hr', '', 'create')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $success = $this->Commissions_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_commission($id)
	{
        if (!has_permission('hr', '', 'delete')) {
            access_denied('hr');
        }
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $response = $this->Allowances_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // statutory_deduction

	public function json_statutory_deduction($id){
        $data = $this->Statutory_deduction_model->get($id);
        echo json_encode($data);
    }
    public function update_statutory_deduction(){
        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Statutory_deduction_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function add_statutory_deduction(){
        if (!has_permission('hr', '', 'create')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $success = $this->Statutory_deduction_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_statutory_deduction($id)
	{
        if (!has_permission('hr', '', 'delete')) {
            access_denied('hr');
        }
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $response = $this->Statutory_deduction_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // allowance

	public function json_allowance($id){
        $data = $this->Allowances_model->get($id);
        echo json_encode($data);
    }
    public function update_allowance(){
        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Allowances_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function add_allowance(){
        if (!has_permission('hr', '', 'create')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $success = $this->Allowances_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_allowance($id)
	{
        if (!has_permission('hr', '', 'delete')) {
            access_denied('hr');
        }
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $response = $this->Allowances_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    // other_payment

    public function json_other_payment($id){
        $data = $this->Other_payment_model->get($id);
        echo json_encode($data);
    }
    public function update_other_payment(){
        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Other_payment_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function add_other_payment(){
        if (!has_permission('hr', '', 'create')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $success = $this->Other_payment_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_other_payment($id)
	{
        if (!has_permission('hr', '', 'delete')) {
            access_denied('hr');
        }
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $response = $this->Other_payment_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
	// loan

    public function json_loan($id){
        $data = $this->Loan_model->get($id);
        echo json_encode($data);
    }
    public function update_loan(){
        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $data['start_date'] = to_sql_date($data['start_date']);
        $data['end_date'] = to_sql_date($data['end_date']);
        $id = $this->input->post('id');
        $success = $this->Loan_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function add_loan(){
        if (!has_permission('hr', '', 'create')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $data['start_date'] = to_sql_date($data['start_date']);
        $data['end_date'] = to_sql_date($data['end_date']);
        $success = $this->Loan_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_loan($id)
	{
        if (!has_permission('hr', '', 'delete')) {
            access_denied('hr');
        }
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $response = $this->Loan_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

	// overtime

    public function json_overtime($id){
        $data = $this->Overtime_model->get($id);
        echo json_encode($data);
    }
    public function update_overtime(){
        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->Overtime_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function add_overtime(){
        if (!has_permission('hr', '', 'create')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $success = $this->Overtime_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete_overtime($id)
	{
        if (!has_permission('hr', '', 'delete')) {
            access_denied('hr');
        }
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $response = $this->Overtime_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }



	public function leaves($staff_id){

		if ($this->input->is_ajax_request()) {
			$this->hrmapp->get_table_data('my_leave_table', ['staff_id' => $staff_id]);
		}
            $ci = &get_instance();
            $ci->load->model('branches/Branches_model');
            $data['branches'] = $ci->Branches_model->getBranches();

		$data['staff_id'] = $staff_id;
		$this->load->view('details/leaves', $data);
	}

	public function projects($staff_id){
		$data['staff_id'] = $staff_id;
		$this->load->view('details/projects', $data);
	}

	public function tasks($staff_id){

		$data['staff_id'] = $staff_id;

		$this->load->view('details/tasks', $data);
	}

	public function payslips($staff_id){

		$data['staff_id'] = $staff_id;
		$this->load->view('details/payslips', $data);
	}
}