<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Class Hr profile
 */
class Hr_profile extends AdminController {
	/**
	 * __construct
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('hr_profile_model');
		$this->load->model('departments_model');
		$this->load->model('staff_model');
		 $this->load->model('hr_profile/timesheets_model');
        //********old hr********
        $this->load->model('insurance_book_num_model');
        $this->load->model('insurance_type_model');
        $this->load->model('hrm_model');
        $this->load->model('Document_model');

//		hooks()->do_action('hr_profile_init');
	}

	/* List all announcements */
	public function dashboard() {
		if (!has_permission('hrm_dashboard', '', 'view')) {
			access_denied('hr_profile');
		}
		$this->app_scripts->add('circle-progress-js', 'assets/plugins/jquery-circle-progress/circle-progress.min.js');
		$data['google_ids_calendars'] = $this->misc_model->get_google_calendar_ids();
		$data['title'] = 'HR Profile';
		$this->load->view('hr_profile_dashboard', $data);
	}

	/**
	 * Organizational chart
	 * @return view
	 */
	public function organizational_chart() {
		if (!has_permission('staffmanage_orgchart', '', 'view') && !has_permission('staffmanage_orgchart', '', 'view_own')) {
			access_denied('hr_profile');
		}
		$this->load->model('staff_model');

		$data['list_department'] = $this->departments_model->get();

		//load deparment by manager
		if (!is_admin() && !has_permission('staffmanage_orgchart', '', 'view')) {
			//View own
			$data['deparment_chart'] = json_encode($this->hr_profile_model->get_data_departmentchart_v2());
		} else {
			//admin or view global
			$data['deparment_chart'] = json_encode($this->hr_profile_model->get_data_departmentchart());
		}

		$data['staff_members_chart'] = json_encode($this->hr_profile_model->get_data_chart());
		$data['list_staff'] = $this->staff_model->get();
		$data['email_exist_as_staff'] = $this->email_exist_as_staff();
		$data['title'] = _l('hr_organizational_chart');
		$data['dep_tree'] = json_encode($this->hr_profile_model->get_department_tree());
		$this->load->view('organizational/organizational_chart', $data);
	}
	public function table_registration_leave()
	{
		$data = $this->app->get_table_data(module_views_path('hr_profile', 'table_registration_leave'));
      return $data ;
	}
	  public function table_registration_leave_by_staff()
    {
        $this->app->get_table_data(module_views_path('hr_profile', 'table_registration_leave_by_staff'));
    }

	/**
	 * email exist as staff
	 * @return integer
	 */
	private function email_exist_as_staff() {
		return total_rows(db_prefix() . 'departments', 'email IN (SELECT email FROM ' . db_prefix() . 'staff)') > 0;
	}

	/**
	 * get data department
	 * @return json
	 */
	public function get_data_department() {
		if ($this->input->is_ajax_request()) {
			$this->app->get_table_data(module_views_path('hr_profile', 'organizational/include/department_table'));
		}
	}

	/**
	 * Delete department from database
	 * @param  integer $id
	 */
	public function delete($id) {
		if (!$id) {
			redirect(admin_url('hr_profile/organizational_chart'));
		}
		$response = $this->departments_model->delete($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('hr_is_referenced', _l('department_lowercase')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('hr_department')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('department_lowercase')));
		}
		redirect(admin_url('hr_profile/organizational_chart'));
	}

	/* Edit or add new department */
	public function department($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();
			$data = $this->input->post();
			$data['password'] = $this->input->post('password', false);

			if (isset($data['fakeusernameremembered']) || isset($data['fakepasswordremembered'])) {
				unset($data['fakeusernameremembered']);
				unset($data['fakepasswordremembered']);
			}
			if (!$this->input->post('id')) {
				$id = $this->departments_model->add($data);
				if ($id) {
					$success = true;
					$message = _l('added_successfully', _l('department'));
				}
				echo json_encode([
					'success' => $success,
					'message' => $message,
					'email_exist_as_staff' => $this->email_exist_as_staff(),
				]);
			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->departments_model->update($data, $id);
				if ($success) {
					$message = _l('updated_successfully', _l('department'));
				}
				echo json_encode([
					'success' => $success,
					'message' => $message,
					'email_exist_as_staff' => $this->email_exist_as_staff(),
				]);
			}
			die;
		}
	}

	/**
	 * email exists
	 * @return [type]
	 */
	public function email_exists() {
		// First we need to check if the email is the same
		$departmentid = $this->input->post('departmentid');
		if ($departmentid) {
			$this->db->where('departmentid', $departmentid);
			$_current_email = $this->db->get(db_prefix() . 'departments')->row();
			if ($_current_email->email == $this->input->post('email')) {
				echo json_encode(true);
				die();
			}
		}
		$exists = total_rows(db_prefix() . 'departments', [
			'email' => $this->input->post('email'),
		]);
		if ($exists > 0) {
			echo 'false';
		} else {
			echo 'true';
		}
	}

	/**
	 * test imap connection
	 * @return [type]
	 */
	public function test_imap_connection() {
		app_check_imap_open_function();

		$email = $this->input->post('email');
		$password = $this->input->post('password', false);
		$host = $this->input->post('host');
		$imap_username = $this->input->post('username');
		if ($this->input->post('encryption')) {
			$encryption = $this->input->post('encryption');
		} else {
			$encryption = '';
		}

		require_once APPPATH . 'third_party/php-imap/Imap.php';

		$mailbox = $host;

		if ($imap_username != '') {
			$username = $imap_username;
		} else {
			$username = $email;
		}

		$password = $password;
		$encryption = $encryption;
		// open connection
		$imap = new Imap($mailbox, $username, $password, $encryption);
		if ($imap->isConnected() === true) {
			echo json_encode([
				'alert_type' => 'success',
				'message' => _l('lead_email_connection_ok'),
			]);
		} else {
			echo json_encode([
				'alert_type' => 'warning',
				'message' => $imap->getError(),
			]);
		}
	}

	/**
	 * reception_staff
	 * @return view
	 */
	public function reception_staff() {
		$this->app_scripts->add('circle-progress-js', 'assets/plugins/jquery-circle-progress/circle-progress.min.js');

		if (!is_admin() && !has_permission('hrm_reception_staff', '', 'view') && !has_permission('hrm_reception_staff', '', 'view_own')) {
			access_denied('reception_staff');
		}
		$this->load->model('hr_profile/hr_profile_model');
		$this->load->model('roles_model');
		$this->load->model('staff_model');
		$data['staff_members'] = $this->hr_profile_model->get_staff('', ['active' => 1]);
		$data['title'] = _l('staff_infor');
		$data['list_staff_not_record'] = $this->hr_profile_model->get_all_staff_not_in_record();
		$data['list_reception_staff_transfer'] = $this->hr_profile_model->get_setting_transfer_records();
		$data['staff_dep_tree'] = json_encode($this->hr_profile_model->get_staff_tree());
		$data['staff_members_chart'] = json_encode($this->hr_profile_model->get_data_chart());
		$data['list_training'] = $this->hr_profile_model->get_all_jp_interview_training();
		$data['list_reception_staff_asset'] = $this->hr_profile_model->get_setting_asset_allocation();
		$data['list_record_meta'] = $this->hr_profile_model->get_list_record_meta();
		$data['group_checklist'] = $this->hr_profile_model->group_checklist();
		$data['setting_training'] = $this->hr_profile_model->get_setting_training();
		$data['type_of_trainings'] = $this->hr_profile_model->get_type_of_training();

		$data['title'] = _l('hr_reception_staff');
		$this->load->view('reception_staff/reception_staff', $data);
	}
    public function staff()
    {
//        if (!has_permission('staff', '', 'view')) {
//            access_denied('staff');
//        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/staff'));

        }
        $data['staff_members'] = $this->staff_model->get('', ['active' => 1]);
        $data['title']         = _l('staff_members');
        //$data['departments']   = $this->Departments_model->get();
        $this->load->view('staff/manage', $data);
    }

    public function staff_table(){
        $this->load->library("hr_profile/HrmApp");
        $this->hrmapp->get_table_data('staff');
    }

    /**
	 * table reception staff
	 */
	public function table_reception_staff() {
		if ($this->input->is_ajax_request()) {
			$this->app->get_table_data(module_views_path('hr_profile', 'reception_staff/reception_staff_table'));
		}
	}

	/**
	 * setting
	 * @return view
	 */
	public function setting() {

		if (!has_permission('hrm_setting', '', 'view')) {
			access_denied('hr_profile');
		}

		$this->load->model('staff_model');
        if(!$this->input->get('group')){
            $_GET['group'] = 'deduction';
            $group = 'deduction';
        }else{
            $group = $this->input->get('group');}
        $this->load->model('hrm_model');
        $this->load->model('Insurance_book_num_model');
		$data['group'] = $this->input->get('group');
		$data['title'] = _l('setting');
		$data['tab'][] = 'contract_type';
		$data['tab'][] = 'salary_type';
		$data['tab'][] = 'allowance_type';
		$data['tab'][] = 'procedure_retire';
		$data['tab'][] = 'type_of_training';
		$data['tab'][] = 'reception_staff';
		$data['tab'][] = 'workplace';
		$data['tab'][] = 'contract_template';
        $data['tab'][] = 'document';
        $data['tab'][] = 'education_level';
        $data['tab'][] = 'relation';
        $data['tab'][] = 'deductions';
        $data['tab'][] = 'warnings';

        //****OLD HR****//
        $data['tab'][] = 'insurance_type';
        $data['tab'][] = 'insurance_book_number';
        //**************

        if ($this->input->is_ajax_request()) {

            if($group == 'deductions'){
               // $this->load->library("hr_profile/HrmApp");

                $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/types/my_deduction_types_table'));

            }
            if($data['group'] == 'document'){
                //$this->load->library("hr_profile/HrmApp");
                $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/types/my_document_types_table'));

            }

            if($data['group'] == 'education_level'){
               // $this->load->library("hr_profile/HrmApp");
                $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/types/my_education_level_types_table'));

            }
            if($data['group'] == 'education'){
                $this->load->library("hr_profile/HrmApp");
                $this->hrmapp->get_table_data('types/my_education_types_table');

            }
            if($data['group'] == 'skill'){
                $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/types/my_skill_types_table'));

            }
            if($data['group'] == 'relation'){
                $this->load->library("hr_profile/HrmApp");
                $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/types/my_relation_types_table'));

            }


        }
		if (is_admin()) {
			$data['tab'][] = 'hr_profile_permissions';
		}
		$data['tab'][] = 'prefix_number';
		//reset data
		if (is_admin()) {
			$data['tab'][] = 'reset_data';
		}

		if ($data['group'] == '') {
			$data['group'] = 'contract_type';
			$data['contract'] = $this->hr_profile_model->get_contracttype();
		} elseif ($data['group'] == 'contract_type') {
			$data['contract'] = $this->hr_profile_model->get_contracttype();

		} elseif ($data['group'] == 'salary_type') {
			$data['salary_form'] = $this->hr_profile_model->get_salary_form();

		} elseif ($data['group'] == 'allowance_type') {
			$data['allowance_type'] = $this->hr_profile_model->get_allowance_type();

		} elseif ($data['group'] == 'procedure_retire') {
			$data['allowance_type'] = $this->hr_profile_model->get_allowance_type();

		} elseif ($data['group'] == 'type_of_training') {
			$data['type_of_trainings'] = $this->hr_profile_model->get_type_of_training();

		} elseif ($data['group'] == 'reception_staff') {
			$data['type_of_trainings'] = $this->hr_profile_model->get_type_of_training();
			$data['list_reception_staff_transfer'] = $this->hr_profile_model->get_setting_transfer_records();
			$data['list_reception_staff_asset'] = $this->hr_profile_model->get_setting_asset_allocation();
			$data['setting_training'] = $this->hr_profile_model->get_setting_training();

			$data['group_checklist'] = $this->hr_profile_model->group_checklist();
			$data['max_checklist'] = $this->hr_profile_model->count_max_checklist();

		} elseif ($data['group'] == 'workplace') {
			$data['workplace'] = $this->hr_profile_model->get_workplace();
		} elseif ($data['group'] == 'contract_template') {
			$data['contract_templates'] = $this->hr_profile_model->get_contract_template();

	    } elseif ($data['group'] == 'warnings') {
             $data['warnings'] = $this->hr_profile_model->get_warnings_template();
            }

//***OLD HR***//
        if ($this->input->is_ajax_request()) {
            if ($data['group'] == 'insurance_book_number') {

                $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_insurance_book_number_table'));

            } elseif ($data['group'] == 'insurance_type') {
                $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_insurance_type_table'));

            }


        }
        if ($data['group'] == 'insurance_type') {
            $data['insurance_book_numbers'] = $this->Insurance_book_num_model->get();
        }
        //*************

		$data['job_position'] = $this->hr_profile_model->get_job_position();
		$data['contract_type'] = $this->hr_profile_model->get_contracttype();
		$data['positions'] = $this->hr_profile_model->get_job_position();

		$data['staff'] = $this->staff_model->get();
		$data['department'] = $this->departments_model->get();
		$data['procedure_retire'] = $this->hr_profile_model->get_procedure_retire();
		$data['str_allowance_type'] = $this->hr_profile_model->get_allowance_type_tax();

		$this->load->model('currencies_model');
		$data['base_currency'] = $this->currencies_model->get_base_currency();
		$data['title'] = _l('hr_settings');
		$data['tabs']['view'] = 'includes/' . $data['group'];
		$this->load->view('manage_setting', $data);
	}

	/**
	 * contract_type
	 * @param  integer $id
	 */
	public function contract_type($id = '') {

		if ($this->input->post()) {
			$message = '';

			$data = $this->input->post();
			$data['description'] = $this->input->post('description', false);

			if (!$this->input->post('id')) {

				$id = $this->hr_profile_model->add_contract_type($data);
				if ($id) {
					$success = true;
					$message = _l('added_successfully', _l('contract_type'));
					set_alert('success', $message);
				}

				redirect(admin_url('hr_profile/setting?group=contract_type'));
			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->hr_profile_model->update_contract_type($data, $id);
				if ($success) {
					$message = _l('updated_successfully', _l('contract_type'));
					set_alert('success', $message);
				} else {
					$message = _l('hr_updated_failed', _l('contract_type'));
					set_alert('warning', $message);
				}

				redirect(admin_url('hr_profile/setting?group=contract_type'));
			}
			die;
		}
	}
	/**
	 * delete contract type
	 * @param  integer $id
	 */
	public function delete_contract_type($id) {
		if (!$id) {
			redirect(admin_url('hr_profile/setting?group=contract_type'));
		}
		$response = $this->hr_profile_model->delete_contract_type($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('hr_is_referenced', _l('contract_type')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('contract_type')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('contract_type')));
		}
		redirect(admin_url('hr_profile/setting?group=contract_type'));
	}
	/**
	 * allowancetype
	 * @param  integer $id
	 */
	public function allowance_type($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();
			if (!$this->input->post('id')) {
				$id = $this->hr_profile_model->add_allowance_type($data);
                if ($id) {
                    $message = _l('added_successfully', _l('hr_allowance_type'));
                    set_alert('success', $message);
                }
				redirect(admin_url('hr_profile/setting?group=allowance_type'));
			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->hr_profile_model->update_allowance_type($data, $id);
				if ($success) {
					$message = _l('updated_successfully', _l('hr_allowance_type'));
					set_alert('success', $message);
				} else {
					$message = _l('hr_updated_failed', _l('hr_allowance_type'));
					set_alert('warning', $message);
				}
				redirect(admin_url('hr_profile/setting?group=allowance_type'));
			}
			die;
		}
	}
	/**
	 * delete_allowance_type
	 * @param  integer $id
	 */
	public function delete_allowance_type($id) {
		if (!$id) {
			redirect(admin_url('hr_profile/setting?group=allowance_type'));
		}
		$response = $this->hr_profile_model->delete_allowance_type($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('hr_is_referenced', _l('hr_allowance_type')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('hr_allowance_type')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('hr_allowance_type')));
		}
		redirect(admin_url('hr_profile/setting?group=allowance_type'));
	}
	/**
	 * insurance type
	 */
	public function insurance_type() {
		if ($this->input->post()) {
			$data = $this->input->post();
			if (!$this->input->post('id')) {
				$add = $this->hr_profile_model->add_insurance_type($data);
				if ($add) {
					$message = _l('added_successfully', _l('insurance_type'));
					set_alert('success', $message);
				}
				redirect(admin_url('hr_profile/setting?group=insurrance'));
			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->hr_profile_model->update_insurance_type($data, $id);
				if ($success == true) {
					$message = _l('updated_successfully', _l('insurance_type'));
					set_alert('success', $message);
				}
				redirect(admin_url('hr_profile/setting?group=insurrance'));
			}

		}
	}
	/**

	/**
	 * insurance conditions setting
	 */
	public function insurance_conditions_setting() {
		if ($this->input->post()) {
			$data = $this->input->post();
			$success = $this->hr_profile_model->update_insurance_conditions($data);
			if ($success > 0) {
				set_alert('success', _l('setting_updated_successfullyfully'));
			}
			redirect(admin_url('hr_profile/setting?group=insurrance'));
		}
	}
	/**
	 * salary form
	 * @param  integer $id
	 */
	public function salary_form($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {
				$id = $this->hr_profile_model->add_salary_form($data);
                if ($id) {
                    $message = _l('added_successfully', _l('hr_salary_form'));
                    set_alert('success', $message);
                }
				redirect(admin_url('hr_profile/setting?group=salary_type'));
			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->hr_profile_model->update_salary_form($data, $id);
				if ($success) {
					$message = _l('updated_successfully', _l('hr_salary_form'));
					set_alert('success', $message);
				} else {
					$message = _l('hr_updated_failed', _l('hr_allowance_type'));
					set_alert('warning', $message);
				}
				redirect(admin_url('hr_profile/setting?group=salary_type'));
			}
			die;
		}
	}

	/**
	 * delete salary form
	 * @param  integer $id
	 */
	public function delete_salary_form($id) {
		if (!$id) {
			redirect(admin_url('hr_profile/setting?group=salary_type'));
		}

		if (!has_permission('hrm_setting', '', 'delete') && !is_admin()) {
			access_denied('hr_profile');
		}

		$response = $this->hr_profile_model->delete_salary_form($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('hr_is_referenced', _l('hr_salary_form')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('hr_salary_form')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('hr_salary_form')));
		}
		redirect(admin_url('hr_profile/setting?group=salary_type'));
	}

	/**
	 * table procedure retire
	 */
	public function table_procedure_retire() {
		$this->app->get_table_data(module_views_path('hr_profile', 'procedure_retire/table_procedure_retire'));
	}

	/**
	 * add procedure form manage
	 */
	public function add_procedure_form_manage() {
		$data = $this->input->post();

		if ($data['id'] == '') {
			$response = $this->hr_profile_model->add_procedure_form_manage($data);

			if ($response) {
				set_alert('success', _l('added_successfully'));
				redirect(admin_url('hr_profile/procedure_procedure_retire_details/' . $response));
			} else {
				set_alert('warning', _l('hr_added_failed'));
			}

		} else {
			$id = $data['id'];
			unset($data['id']);

			$response = $this->hr_profile_model->update_procedure_form_manage($data, $id);
			if ($response) {
				set_alert('success', _l('hr_updated_successfully'));
			} else {
				set_alert('warning', _l('hr_update_failed'));
			}
		}

		redirect(admin_url('hr_profile/setting?group=procedure_retire'));
	}

	/**
	 * delete procedure form manage
	 * @param  integer $id
	 */
	public function delete_procedure_form_manage($id) {
		if (!has_permission('hrm_setting', '', 'delete') && !is_admin()) {
			access_denied('hr_profile');
		}

		$success = $this->hr_profile_model->delete_procedure_form_manage($id);
		if ($success == true) {
			$message = _l('hr_deleted');
			echo json_encode([
				'success' => true,
				'message' => $message,
			]);
			set_alert('success', $message);

		} else {
			$message = _l('problem_deleting');
			echo json_encode([
				'success' => true,
				'message' => $message,
			]);
			set_alert('warning', $message);

		}
		redirect(admin_url('hr_profile/setting?group=procedure_retire'));
	}

	/**
	 * procedure procedure retire details
	 * @param  integer $id
	 * @return view
	 */
	public function procedure_procedure_retire_details($id = '') {
		if (!$id) {
			blank_page(_l('hr_procedure_retire'), 'danger');
		}

		$data['title'] = _l('hr_procedure_retire');
		$data['id'] = $id;
		$data['procedure_retire'] = $this->hr_profile_model->get_procedure_retire($id);
		$data['staffs'] = $this->staff_model->get();
		$this->load->view('hr_profile/procedure_retire/details', $data);
	}

	/**
	 * procedure form
	 */
	public function procedure_form() {
		$data = $this->input->post();
		$result = $this->hr_profile_model->add_procedure_retire($data);

		if ($result) {
			set_alert('success', _l('hr_added_successfully'));
		} else {
			set_alert('warning', _l('hr_added_failed'));
		}
		redirect(admin_url('hr_profile/procedure_procedure_retire_details/' . $data['procedure_retire_id']));
	}

	/**
	 * delete procedure retire
	 * @param  integer $id
	 * @return integer
	 */
	public function delete_procedure_retire($id_detail, $id) {
		$result = $this->hr_profile_model->delete_procedure_retire($id_detail);

		if ($result) {
			set_alert('success', _l('hr_deleted'));
		} else {
			set_alert('warning', _l('problem_deleting'));
		}
		redirect(admin_url('hr_profile/procedure_procedure_retire_details/' . $id));

	}

	/**
	 * edit procedure retire
	 * @param  integer $id
	 */
	public function edit_procedure_retire($id) {
		$data = $this->hr_profile_model->get_edit_procedure_retire($id);
		$id = $data->id;
		$procedure_retire_id = $data->procedure_retire_id;
		$people_handle_id = $data->people_handle_id;
		$option_name = json_decode($data->option_name);

		$count_option_value = count(get_object_vars(json_decode($data->option_name))) + 1;

		$rel_name = $data->rel_name;

		echo json_encode([
			'id' => $id,
			'option_name' => $option_name,
			'rel_name' => $rel_name,
			'procedure_retire_id' => $procedure_retire_id,
			'people_handle_id' => $people_handle_id,
			'count_option_value' => $count_option_value,
		]);

	}

	/**
	 * edit procedure form
	 */
	public function edit_procedure_form() {
		$data = $this->input->post();
		if (isset($data['id'])) {
			$id = $data['id'];
			unset($data['id']);
		}
		$success = $this->hr_profile_model->edit_procedure_retire($data, $id);
		if ($success) {
			set_alert('success', _l('hr_updated_successfully'));
		} else {
			set_alert('warning', _l('hr_update_false'));
		}
		redirect(admin_url('hr_profile/procedure_procedure_retire_details/' . $data['procedure_retire_id']));

	}

	/**
	 * training
	 * @return view
	 */
	public function training() {
		if (!has_permission('staffmanage_training', '', 'view') && !has_permission('staffmanage_training', '', 'view_own') && !is_admin()) {
			access_denied('job_position');
		}
		$data['group'] = $this->input->get('group');
		$data['title'] = _l('hr_training');
		$data['tab'][] = 'training_program';
		$data['tab'][] = 'training_library';
		$data['tab'][] = 'training_result';

		if ($data['group'] == '') {
			$data['group'] = 'training_program';
		}
		$data['tabs']['view'] = 'training/' . $data['group'];

		$data['training_table'] = $this->hr_profile_model->get_job_position_training_process();
		$data['get_job_position'] = $this->hr_profile_model->get_job_position();
		$data['hr_profile_get_department_name'] = $this->departments_model->get();
		$data['type_of_trainings'] = $this->hr_profile_model->get_type_of_training();
		$data['staffs'] = $this->hr_profile_model->get_staff_active();

		$data['list_staff'] = $this->staff_model->get();
		$data['training_libraries'] = $this->hr_profile_model->get_training_library();
		$data['training_programs'] = $this->hr_profile_model->get_job_position_training_process();

		$this->load->view('training/manage_training', $data);
	}

	/**
	 * Add new position training or update existing
	 * @param integer id
	 */
	public function position_training($id = '') {
		if (!has_permission('staffmanage_training', '', 'view')) {
			access_denied('job_position');
		}
		if ($this->input->post()) {
			$data = $this->input->post();
			$data['description'] = $this->input->post('description', false);
			$data['viewdescription'] = $this->input->post('viewdescription', false);

			if ($id == '') {
				if (!has_permission('staffmanage_training', '', 'create')) {
					access_denied('job_position');
				}
				$id = $this->hr_profile_model->add_position_training($data);
				if ($id) {
					set_alert('success', _l('added_successfully', _l('hr_training')));
					redirect(admin_url('hr_profile/position_training/' . $id));
				}
			} else {
				if (!has_permission('staffmanage_training', '', 'edit')) {
					access_denied('job_position');
				}
				$success = $this->hr_profile_model->update_position_training($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully', _l('hr_training')));
				}
				redirect(admin_url('hr_profile/position_training/' . $id));
			}
		}
		if ($id == '') {
			$title = _l('add_new', _l('hr_training'));
		} else {
			$position_training = $this->hr_profile_model->get_position_training($id);
			$data['position_training'] = $position_training;
			$title = $position_training->subject;
		}
		if (is_gdpr() && (get_option('gdpr_enable_consent_for_contacts') == '1' || get_option('gdpr_enable_consent_for_leads') == '1')) {
			$this->load->model('gdpr_model');
			$data['purposes'] = $this->gdpr_model->get_consent_purposes();
		}
		$data['title'] = $title;
		$data['type_of_trainings'] = $this->hr_profile_model->get_type_of_training();
		$this->app_scripts->add('surveys-js', module_dir_url('surveys', 'assets/js/surveys.js'), 'admin', ['app-js']);
		$this->app_css->add('surveys-css', module_dir_url('hr_profile', 'assets/css/training/training_post.css'), 'admin', ['app-css']);

		$this->load->view('hr_profile/training/job_position_manage/position_training', $data);
	}

	/* New survey question */
	public function add_training_question() {
		if (!has_permission('staffmanage_training', '', 'edit') && !has_permission('staffmanage_training', '', 'create')) {
			echo json_encode([
				'success' => false,
				'message' => _l('access_denied'),
			]);
			die();
		}
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {
				echo json_encode([
					'data' => $this->hr_profile_model->add_training_question($this->input->post()),
					'survey_question_only_for_preview' => _l('hr_survey_question_only_for_preview'),
					'survey_question_required' => _l('hr_survey_question_required'),
					'survey_question_string' => _l('hr_question_string'),
				]);
				die();
			}
		}
	}

	/* Update question */
	public function update_training_question() {
		if (!has_permission('staffmanage_training', '', 'edit') && !has_permission('staffmanage_training', '', 'create')) {
			echo json_encode([
				'success' => false,
				'message' => _l('access_denied'),
			]);
			die();
		}
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {
				$this->hr_profile_model->update_question($this->input->post());
			}
		}
	}

	/* Reorder surveys */
	public function update_training_questions_orders() {
		if (has_permission('staffmanage_training', '', 'edit') || has_permission('staffmanage_training', '', 'create')) {
			if ($this->input->is_ajax_request()) {
				if ($this->input->post()) {
					$this->hr_profile_model->update_survey_questions_orders($this->input->post());
				}
			}
		}
	}
	/* Remove survey question */
	public function remove_question($questionid) {
		if (!has_permission('staffmanage_training', '', 'edit') && !has_permission('staffmanage_training', '', 'create')) {
			echo json_encode([
				'success' => false,
				'message' => _l('access_denied'),
			]);
			die();
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode([
				'success' => $this->hr_profile_model->remove_question($questionid),
			]);
		}
	}

	/* Removes survey checkbox/radio description*/
	public function remove_box_description($questionboxdescriptionid) {
		if (!has_permission('staffmanage_training', '', 'edit') && !has_permission('staffmanage_training', '', 'create')) {
			echo json_encode([
				'success' => false,
				'message' => _l('access_denied'),
			]);
			die();
		}
		if ($this->input->is_ajax_request()) {
			echo json_encode([
				'success' => $this->hr_profile_model->remove_box_description($questionboxdescriptionid),
			]);
		}
	}

	/* Add box description */
	public function add_box_description($questionid, $boxid) {
		if (!has_permission('staffmanage_training', '', 'edit') && !has_permission('staffmanage_training', '', 'create')) {
			echo json_encode([
				'success' => false,
				'message' => _l('access_denied'),
			]);
			die();
		}
		if ($this->input->is_ajax_request()) {
			$boxdescriptionid = $this->hr_profile_model->add_box_description($questionid, $boxid);
			echo json_encode([
				'boxdescriptionid' => $boxdescriptionid,
			]);
		}
	}
	/* Update question */
	public function update_training_question_answer() {
		if (!has_permission('staffmanage_training', '', 'edit') && !has_permission('staffmanage_training', '', 'create')) {
			echo json_encode([
				'success' => false,
				'message' => _l('access_denied'),
			]);
			die();
		}
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {

				$this->hr_profile_model->update_answer_question($this->input->post());
			}
		}
	}
	/**
	 * get training type child
	 * @param  integer $id
	 * @return json
	 */
	public function get_training_type_child($id) {
		$list = $this->hr_profile_model->get_child_training_type($id);
		$html = '';
		foreach ($list as $li) {
			$html .= '<option value="' . $li['training_id'] . '">' . $li['subject'] . '</option>';
		}
		echo json_encode([
			'html' => $html,
		]);
	}

	/**
	 * job position training add edit
	 */
	public function job_position_training_add_edit() {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id_training')) {
				$job_position_id = $this->input->post('job_position_id');
				$id = $this->hr_profile_model->add_job_position_training_process($data);
				if ($id) {
					$success = true;
					$message = _l('added_successfully');
					set_alert('success', $message);
				}
				redirect(admin_url('hr_profile/training/?group=training_program'));
			} else {
				$job_position_id = $data['job_position_id'];
				$id = $data['id_training'];
				unset($data['id_training']);
				$success = $this->hr_profile_model->update_job_position_training_process($data, $id);

				if ($success) {
					$message = _l('hr_updated_successfully');
					set_alert('success', $message);
				} else {
					$message = _l('hr_updated_failed');
					set_alert('warning', $message);
				}
				redirect(admin_url('hr_profile/training/?group=training_program'));
			}
			die;
		}
	}

	/**
	 * get jobposition fill data
	 * @return json
	 */
	public function get_jobposition_fill_data() {
		$data = $this->input->post();
		if ($data['status'] == 'true') {
			$job_position = $this->hr_profile_model->get_position_by_department($data['department_id'], true);

		} else {
			$job_position = $this->hr_profile_model->get_position_by_department(1, false);

		}
		echo json_encode([
			'job_position' => $job_position,
		]);
	}

	/**
	 * job position manage
	 * @return view
	 */
	public function job_position_manage() {
		if (!has_permission('staffmanage_job_position', '', 'view') && !is_admin() && !has_permission('staffmanage_job_position', '', 'view_own')) {
			access_denied('job_position');
		}
		$this->load->model('staff_model');

		$data['job_p'] = $this->hr_profile_model->get_job_p();
		$data['get_job_position'] = $this->hr_profile_model->get_job_position();
		$data['hr_profile_get_department_name'] = $this->departments_model->get();
		$this->load->view('hr_profile/job_position_manage/job_manage/job_manage', $data);
	}

	/**
	 * table job
	 */
	public function table_job() {
		$this->app->get_table_data(module_views_path('hr_profile', 'table_job'));
	}

	/**
	 * add job position
	 * @param  integer $id
	 */
	public function job_p($id = '') {

		if ($this->input->post()) {

			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {
				$data['description'] = $this->input->post('description', false);
				$id = $this->hr_profile_model->add_job_p($data);

				if ($id) {
					$message = _l('added_successfully', _l('job'));
					set_alert('success', $message);
				}
				redirect(admin_url('hr_profile/job_position_manage'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$data['description'] = $this->input->post('description', false);
				$success = $this->hr_profile_model->update_job_p($data, $id);

				if ($success) {
					set_alert('success', _l('updated_successfully', _l('job')));
				} else {
					set_alert('warning', _l('updated_false', _l('job')));
				}

				redirect(admin_url('hr_profile/job_position_manage'));
			}
			die;
		}
	}

	/**
	 * get job position edit
	 * @param  integer $id
	 * @return json
	 */
	public function get_job_p_edit($id) {

		$list = $this->hr_profile_model->get_job_p($id);

		if (isset($list)) {
			$description = $list->description;
		} else {
			$description = '';
		}

		echo json_encode([
			'description' => $description,
		]);

	}

	/**
	 * delete job position
	 * @param  integer $id
	 */
	public function delete_job_p($id) {
		if (!$id) {
			redirect(admin_url('hr_profile/job_position_manage'));
		}

		$response = $this->hr_profile_model->delete_job_p($id);
		if ($response) {
			set_alert('success', _l('deleted', _l('job')));
			redirect(admin_url('hr_profile/job_position_manage'));
		} else {
			set_alert('warning', _l('problem_deleting', _l('job')));
			redirect(admin_url('hr_profile/job_position_manage'));
		}

	}

	/**
	 * import job p, Import Job
	 * @return [type]
	 */
	public function import_job_p() {
		$data['departments'] = $this->departments_model->get();
		$data['job_positions'] = $this->hr_profile_model->get_job_position();

		$data_staff = $this->hr_profile_model->get_staff(get_staff_user_id());

		/*get language active*/
		if ($data_staff) {
			if ($data_staff->default_language != '') {
				$data['active_language'] = $data_staff->default_language;

			} else {

				$data['active_language'] = get_option('active_language');
			}

		} else {
			$data['active_language'] = get_option('active_language');
		}

		$this->load->view('hr_profile/job_position_manage/job_manage/import_job', $data);
	}

	/**
	 * import job p excel
	 * @return [type]
	 */
	public function import_job_p_excel() {
		if (!is_admin() && !has_permission('staffmanage_job_position', '', 'create')) {
			access_denied('Leads Import');
		}
		$total_row_false = 0;
		$total_rows = 0;
		$dataerror = 0;
		$total_row_success = 0;
		$filename = '';

		if ($this->input->post()) {
			// $simulate = $this->input->post('simulate');
			if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {
				//do_action('before_import_leads');

				// Get the temp file path
				$tmpFilePath = $_FILES['file_csv']['tmp_name'];
				// Make sure we have a filepath
				if (!empty($tmpFilePath) && $tmpFilePath != '') {
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
						$import_result = true;
						$rows = [];

						$objReader = new PHPExcel_Reader_Excel2007();
						$objReader->setReadDataOnly(true);
						$objPHPExcel = $objReader->load($newFilePath);
						$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
						$sheet = $objPHPExcel->getActiveSheet();

						//init file error start
						$dataError = new PHPExcel();
						$dataError->setActiveSheetIndex(0);
						//create title
						$dataError->getActiveSheet()->setTitle('error');
						$dataError->getActiveSheet()->getColumnDimension('A')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('B')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('D')->setWidth(20);
						//Set bold for header
						$dataError->getActiveSheet()->getStyle('A1:AA1')->getFont()->setBold(true);

						$dataError->getActiveSheet()->setCellValue('A1', _l('job_name'));
						$dataError->getActiveSheet()->setCellValue('B1', _l('description'));
						$dataError->getActiveSheet()->setCellValue('C1', _l('hr_create_job_position_default'));
						$dataError->getActiveSheet()->setCellValue('D1', _l('error'));
						//init file error end

						// start Write data error from line 2
						$styleArray = array(
							'font' => array(
								'bold' => true,
								'color' => array('rgb' => 'ff0000'),
							));

						$numRow = 2;
						$total_rows = 0;
						//get data for compare

						foreach ($rowIterator as $row) {
							$rowIndex = $row->getRowIndex();
							if ($rowIndex > 1) {

								$rd = array();
								$flag = 0;

								$string_error = '';

								$value_job_name = $sheet->getCell('A' . $rowIndex)->getValue();
								$value_description = $sheet->getCell('B' . $rowIndex)->getValue();
								$value_create_default = $sheet->getCell('C' . $rowIndex)->getValue();

								if (is_null($value_job_name) == true) {
									$string_error .= _l('job_name') . _l('not_yet_entered');
									$flag = 1;
								}

								if (is_null($value_description) == true) {
									$string_error .= _l('description') . _l('not_yet_entered');
									$flag = 1;
								}

								if (($flag == 1)) {
									$dataError->getActiveSheet()->setCellValue('A' . $numRow, $sheet->getCell('A' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('B' . $numRow, $sheet->getCell('B' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('C' . $numRow, $sheet->getCell('C' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('D' . $numRow, $string_error)->getStyle('D' . $numRow)->applyFromArray($styleArray);

									$numRow++;
								}

								if (($flag == 0)) {

									if (is_numeric($value_create_default) && $value_create_default == '0') {
										$rd['create_job_position'] = 'on';
									}
									$rd['job_name'] = $sheet->getCell('A' . $rowIndex)->getValue();
									$rd['description'] = $sheet->getCell('B' . $rowIndex)->getValue();

								}

								if (get_staff_user_id() != '' && $flag == 0) {
									$rows[] = $rd;
									$this->hr_profile_model->add_job_p($rd);
								}
								$total_rows++;
							}
						}

						$total_rows = $total_rows;
						$data['total_rows_post'] = count($rows);
						$total_row_success = count($rows);
						$total_row_false = $total_rows - (int) count($rows);
						$dataerror = $dataError;
						$message = 'Not enought rows for importing';

						if ($total_row_false != 0) {

							$objWriter = new PHPExcel_Writer_Excel2007($dataError);

							$filename = 'Import_job_error_' . get_staff_user_id() . strtotime(date('Y-m-d H:i:s')) . '.xlsx';
							$objWriter->save(str_replace($filename, HR_PROFILE_ERROR . $filename, $filename));

						}
						$import_result = true;
						@delete_dir($tmpDir);

					}
				} else {
					set_alert('warning', _l('import_upload_failed'));
				}
			}

		}
		echo json_encode([
			'message' => $message,
			'total_row_success' => $total_row_success,
			'total_row_false' => $total_row_false,
			'total_rows' => $total_rows,
			'site_url' => site_url(),
			'staff_id' => get_staff_user_id(),
			'filename' => HR_PROFILE_ERROR . $filename,
		]);

	}

	/**
	 * job positions
	 * @param  integer $id
	 * @return view
	 */
	public function job_positions($id = '') {
		if (!has_permission('staffmanage_job_position', '', 'view') && !has_permission('staffmanage_job_position', '', 'view_own')) {
			access_denied('job_position');
		}
		$get_department_by_manager = $this->hr_profile_model->get_department_by_manager();

		$data['job_p_id'] = $this->hr_profile_model->get_job_p();
		$data['hr_profile_get_department_name'] = $this->departments_model->get();
		$data['get_job_position'] = $this->hr_profile_model->get_job_position();
		$data['title'] = _l('hr_job_descriptions');

		$this->load->view('hr_profile/job_position_manage/position_manage/position_manage', $data);
	}

	/**
	 * add or update job position
	 * @param  integer $id
	 */
	public function job_position($id = '') {

		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();
			if (!$this->input->post('id')) {
				$data['job_position_description'] = $this->input->post('job_position_description', false);
				$id = $this->hr_profile_model->add_job_position($data);
				if ($id) {
					$_id = $id;
					$uploadedFiles = handle_hr_profile_job_position_attachments_array($id, 'file');

					if ($uploadedFiles && is_array($uploadedFiles)) {
						foreach ($uploadedFiles as $file) {
							$insert_file_id = $this->hr_profile_model->add_attachment_to_database($id, 'job_position', [$file]);
						}
					}
				}

				if ($id) {
					$message = _l('added_successfully', _l('job_position'));
					set_alert('success', $message);
				} else {
					$message = _l('added_failed', _l('job_position'));
					set_alert('warning', $message);
				}

				redirect(admin_url('hr_profile/job_position_view_edit/' . $id));
			} else {
				$job_p_id = $this->input->post('job_p_id');

				$id = $data['id'];
				unset($data['id']);
				$data['job_position_description'] = $this->input->post('job_position_description', false);
				$success = $this->hr_profile_model->update_job_position($data, $id);

				//upload file
				if ($id) {
					$_id = $id;
					$message = _l('added_successfully', _l('job_position'));
					$uploadedFiles = handle_hr_profile_job_position_attachments_array($id, 'file');
					if ($uploadedFiles && is_array($uploadedFiles)) {
						$len = count($uploadedFiles);

						foreach ($uploadedFiles as $file) {
							$insert_file_id = $this->hr_profile_model->add_attachment_to_database($id, 'job_position', [$file]);
							if ($insert_file_id > 0) {
								$count_file++;
							}
						}
						if ($count_file == $len) {
							$response = true;
						}
					}
				}

				if ($success) {
					$message = _l('updated_successfully', _l('job_position'));
					set_alert('success', $message);
				} else {
					$message = _l('updated_failed', _l('job_position'));
					set_alert('warning', $message);
				}
				redirect(admin_url('hr_profile/job_positions'));
			}
			die;
		}
	}

	/**
	 * table job position
	 * @return [type]
	 */
	public function table_job_position() {
		$this->app->get_table_data(module_views_path('hr_profile', 'job_position_manage/position_manage/table_job_position'));
	}

	/**
	 * job position delete tag item
	 * @param  String $tag_id
	 * @return json
	 */
	public function job_position_delete_tag_item($tag_id) {

		$result = $this->hr_profile_model->delete_tag_item($tag_id);
		if ($result == 'true') {
			$message = _l('hr_deleted');
			$status = 'true';
		} else {
			$message = _l('problem_deleting');
			$status = 'fasle';
		}

		echo json_encode([
			'message' => $message,
			'status' => $status,
		]);
	}

	/**
	 * hrm preview jobposition file
	 * @param  [type] $id
	 * @param  [type] $rel_id
	 * @return [type]
	 */
	public function preview_job_position_file($id, $rel_id) {
		$data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
		$data['current_user_is_admin'] = is_admin();
		$data['file'] = $this->hr_profile_model->get_file($id, $rel_id);
		if (!$data['file']) {
			header('HTTP/1.0 404 Not Found');
			die;
		}
		$this->load->view('hr_profile/job_position_manage/position_manage/preview_position_file', $data);
	}

	public function delete_hr_profile_job_position_attachment_file($attachment_id) {
		if (!has_permission('staffmanage_job_position', '', 'delete') && !is_admin()) {
			access_denied('job_position');
		}

		$file = $this->misc_model->get_file($attachment_id);
		echo json_encode([
			'success' => $this->hr_profile_model->delete_hr_job_position_attachment_file($attachment_id),
		]);
	}

	/**
	 * job position view edit
	 * @param  string $id
	 * @return view
	 */
	public function job_position_view_edit($id = '', $parent_id = '') {

		if (!has_permission('staffmanage_job_position', '', 'view') && !has_permission('staffmanage_job_position', '', 'view_own')) {
			access_denied('job_position');
		}
		if ($id == '') {
			$title = _l('add_new', _l('hr_training'));
		} else {

			$data['job_position_general'] = $this->hr_profile_model->get_job_position($id);
			$data['job_position_tag'] = $this->hr_profile_model->get_job_position_tag($id);
			$data['job_position_id'] = $id;

			$data_salary_scale = $this->hr_profile_model->get_job_position_salary_scale($id);
			$data['salary_insurance'] = $data_salary_scale['insurance'];
			$data['salary_form_edit'] = $data_salary_scale['salary'];
			$data['salary_allowance'] = $data_salary_scale['allowance'];

			$data['count_salary_form'] = count($data_salary_scale['salary']);
			$data['count_salary_allowance'] = count($data_salary_scale['allowance']);

			$data['job_position_attachment'] = $this->hr_profile_model->get_hr_profile_attachments_file($id, 'job_position');

		}

		$data['list_job_p'] = $this->hr_profile_model->get_job_p();
		$data['list_staff'] = $this->staff_model->get();

		$data['allowance_type'] = $this->hr_profile_model->get_allowance_type();
		$data['salary_form'] = $this->hr_profile_model->get_salary_form();
		$data['parent_id'] = $parent_id;
		$data['hr_profile_get_department_name'] = $this->departments_model->get();

		$this->load->view('hr_profile/job_position_manage/view_edit_jobposition', $data);
	}

	/**
	 * get list job position tags file
	 * @param  [type] $id
	 * @return [type]
	 */
	public function get_list_job_position_tags_file($id) {
		$list = $this->hr_profile_model->get_list_job_position_tags_file($id);

		$job_position_de = $this->hr_profile_model->get_job_position($id);
		if (isset($job_position_de)) {
			$description = $job_position_de->job_position_description;

			$job_p = $this->hr_profile_model->get_job_p($job_position_de->job_p_id);
			$job_p = isset($job_p) ? $job_p->job_id : 0;
		} else {
			$description = '';
			$job_p = 0;

		}

		if((get_tags_in($id,'job_position') != null)){
			$item_value = implode(',', get_tags_in($id,'job_position')) ;
		}else{

			$item_value = '';
		}

		echo json_encode([
			'description' => $description,
			'htmltag' => $list['htmltag'],
			'htmlfile' => $list['htmlfile'],
			'job_position_html' => render_tags(get_tags_in($id, 'job_position')),
			'job_p' => $job_p,
    		'item_value' => $item_value,

		]);
	}

	/**
	 * get position by department
	 * @return json
	 */
	public function get_position_by_department() {
		$data = $this->input->post();
		if ($data['status'] == 'true') {
			$job_position = $this->hr_profile_model->get_position_by_department($data['department_id'], true);
		} else {
			$job_position = $this->hr_profile_model->get_position_by_department(1, false);
		}
		echo json_encode([
			'job_position' => $job_position,
		]);

	}

	/**
	 * delete job position
	 * @param  integer $id
	 * @param  integer $job_p_id
	 */
	public function delete_job_position($id) {
		if (!$id) {
			redirect(admin_url('hr_profile/job_positions'));
		}
		$response = $this->hr_profile_model->delete_job_position($id);

		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('hr_is_referenced', _l('hr_hr_job_position')));
		} elseif ($response == true) {
			set_alert('success', _l('hr_deleted'));
		} else {
			set_alert('warning', _l('problem_deleting'));
		}
		redirect(admin_url('hr_profile/job_positions'));
	}

	/**
	 * get staff salary form
	 * @return json
	 */
	public function get_staff_salary_form() {
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {
				$id = $this->input->post('id');
				$name_object = $this->hr_profile_model->get_salary_form($id);
			}
		}
		if ($name_object) {
			echo json_encode([
				'salary_val' => (String) hr_profile_reformat_currency($name_object->salary_val),
			]);
		}

	}

	/**
	 * get staff allowance type
	 * @return json
	 */
	public function get_staff_allowance_type() {
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {
				$id = $this->input->post('id');
				$name_object = $this->hr_profile_model->get_allowance_type($id);
			}
		}

		if ($name_object) {
			echo json_encode([
				'allowance_val' => (String) hr_profile_reformat_currency($name_object->allowance_val),
			]);
		}
	}

	/**
	 * job position salary add edit
	 */
	public function job_position_salary_add_edit() {
		if (!has_permission('staffmanage_job_position', '', 'create')) {
			access_denied('job_position');
		}

		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();
			if ($this->input->post()) {
				$job_position_id = $data['job_position_id'];
				$id = $this->hr_profile_model->job_position_add_update_salary_scale($data);
				if ($id) {
					$success = true;
					$message = _l('added_successfully');
					set_alert('success', $message);
				}
				redirect(admin_url('hr_profile/job_position_view_edit/' . $job_position_id . '?tab=salary_scale'));
			}
			die;
		}
	}

	/**
	 * save setting reception staff
	 */
	public function save_setting_reception_staff() {
		if ($this->input->post()) {
			$data = $this->input->post();
			$data_asset['name'] = $data['asset_name'];
			$data_training['training_type'] = $data['training_type'];
			$this->hr_profile_model->add_manage_info_reception($data);
			$this->hr_profile_model->add_setting_training($data_training);
//			$this->hr_profile_model->add_setting_transfer_records($data_transfer);
			$this->hr_profile_model->add_setting_asset_allocation($data_asset);
			$message = _l('hr_updated_successfully');
			set_alert('success', $message);
			redirect(admin_url('hr_profile/setting?group=reception_staff'));
		}
	}

	/**
	 * add new reception
	 */
	public function add_new_reception() {
		if ($this->input->post()) {

			$data = $this->input->post();
			$list_staff = $this->hr_profile_model->get_staff_info_id($data['staff_id']);
			$data_rec_tranfer['staffid'] = $list_staff->staffid;
			$data_rec_tranfer['firstname'] = isset($list_staff->firstname) ? $list_staff->firstname : '';
			$data_rec_tranfer['birthday'] = isset($list_staff->birthday) ? $list_staff->birthday : '';
			$data_rec_tranfer['staffidentifi'] = isset($list_staff->staffidentifi) ? $list_staff->staffidentifi : '';

			// Create records for management reception
			$this->hr_profile_model->add_rec_transfer_records($data_rec_tranfer);

			//1 Reception information board
			$this->hr_profile_model->add_manage_info_reception_for_staff($list_staff->staffid, $data);

			//2 Create a property allocation record
			if (isset($data['asset_name'])) {
				$list_asset = [];
				foreach ($data['asset_name'] as $key => $value) {
					array_push($list_asset, ['name' => $value]);
				}
				if ($list_asset) {
					$this->hr_profile_model->add_asset_staff($list_staff->staffid, $list_asset);
				}
			}

			//3 Create a training record

			if ($list_staff->job_position != '') {

				$jp_interview_training = $this->hr_profile_model->get_job_position_training_de($data['training_program']);
				//TO DO
				// $list_training = $this->hr_profile_model->get_jp_interview_training($list_staff->job_position,$data['training_type']);
				if ($jp_interview_training) {
					$this->hr_profile_model->add_training_staff($jp_interview_training, $list_staff->staffid);
					if (isset($list_staff->email)) {
						if ($list_staff->email != '') {
							$this->send_training_staff($list_staff->email, $list_staff->job_position, $data['training_type'], $jp_interview_training->position_training_id, $list_staff->staffid);
						}
					}
				}
			}

			//4 Create a record with additional profile information
			if (isset($data['info_name'])) {
				if ($data['info_name']) {
					$this->hr_profile_model->add_transfer_records_reception($data['info_name'], $data['staff_id']);
				}
			}

			$message = _l('added_successfully');
			set_alert('success', $message);
			redirect(admin_url('hr_profile/reception_staff'));
		}

	}

	/**
	 * send training staff
	 * @param  [type] $email
	 * @param  [type] $position_id
	 * @param  string $training_type
	 * @return [type]
	 */
	public function send_training_staff($email, $position_id, $training_type = '', $position_training_id = '', $staffid = '') {
		if ($position_training_id != '') {
			$data_training = $this->hr_profile_model->get_list_position_training_by_id_training($position_training_id);

			$data['description'] = '
			<div >
			<div> ' . _l('hr_please_complete_the_tests_below_to_complete_the_training_program') . '</div><br>
			<div> ' . _l('hr_please_log_in_training') . '</div>
			<div></div>';
			foreach ($data_training as $key => $value) {
				$data['description'] .= '<div>';
				$data['description'] .= '&#9755; <a href="' . site_url() . 'hr_profile/participate/index/' . $value['training_id'] . '/' . $value['hash'] . '">' . site_url() . '' . $value['slug'] . '</a>';
				$data['description'] .= '</div><br>';
			}

			$data['description'] .= '</div>';

			//send notification
			$notified = add_notification([
				'description' => $data['description'],
				'touserid' => $staffid,
				'additional_data' => serialize([
					$data['description'],
				]),
			]);
			if ($notified) {
				pusher_trigger_notification([$staffid]);
			}

			//send mail
			$this->hr_profile_model->send_mail_training($email, get_option('companyname'), '' . get_option('companyname') . ': ' . _l('hr_new_training_for_you'), $data['description']);
		}
	}

	/**
	 * get percent complete
	 * @param  string $id
	 * @return [type]
	 */
	public function get_percent_complete($id = '') {
		if ($id != '') {
			$this->load->model('hr_profile/hr_profile_model');
			$this->load->model('departments_model');
			$this->load->model('staff_model');

			$data['staff'] = $this->staff_model->get($id);
			$data['list_reception_staff_transfer'] = $this->hr_profile_model->get_setting_transfer_records();
			$staff_array = json_decode(json_encode($data['staff']), true);
			$count_info = 0;
			$count_info_total = 0;
			$count_effect_total = 0;
			$count_total = 0;
			//check list
			$checklist_effect = 0;
			$listchecklist = $this->hr_profile_model->get_group_checklist_allocation_by_staff_id($id);
			$count_total = count($listchecklist);

			foreach ($listchecklist as $value) {
				$checklist = $this->hr_profile_model->get_checklist_allocation_by_group_id($value['id']);
				$total = count($checklist);
				$effect_checklist = 0;
				foreach ($checklist as $item) {
					if ((int) $item['status'] == 1) {
						$effect_checklist += 1;
					}
				}
				if ($effect_checklist == $total) {
					$count_effect_total += 1;
				}
			}

			//recpetion
			foreach ($data['list_reception_staff_transfer'] as $value) {
				$count_info_total += 1;
				if ($staff_array[$value['meta']] != '') {
					$count_info += 1;
				}
			}

			$percent_info_total = $this->hr_profile_model->getPercent($count_info_total, $count_info);
			if ($percent_info_total >= 100) {
				$count_effect_total += 1;
			}
			if ($count_info_total > 0) {
				$count_total += 1;
			}

			$data['list_staff_asset'] = $this->hr_profile_model->get_allocation_asset($id);
			$count_asset = 0;
			$count_asset_total = 0;
			foreach ($data['list_staff_asset'] as $value) {
				$count_asset_total += 1;
				if ($value['status_allocation'] == 1) {
					$count_asset += 1;
				}
			}

			$percent_asset_total = $this->hr_profile_model->getPercent($count_asset_total, $count_asset);
			if ($percent_asset_total >= 100) {
				$count_effect_total += 1;
			}
			if ($count_asset_total > 0) {
				$count_total += 1;
			}

			//Get the latest employee's training result.
			$list_training_allocation = $this->hr_profile_model->get_training_allocation_staff($id);
			if ($list_training_allocation) {

				$data_marks = $this->get_mark_staff($id, $list_training_allocation->training_process_id);

				if (count($data_marks['staff_training_result']) > 0) {
					$count_total += 1;

					$training_allocation_min_point = 0;

					if (isset($list_training_allocation)) {

						$job_position_training = $this->hr_profile_model->get_job_position_training_de($list_training_allocation->jp_interview_training_id);

						if ($job_position_training) {
							$training_allocation_min_point = $job_position_training->mint_point;
						}
					}

					if ((float) $data_marks['training_program_point'] >= (float) $training_allocation_min_point) {
						$count_effect_total += 1;
					}

				}
			}

			return $this->hr_profile_model->getPercent($count_total, $count_effect_total);
		}
	}

	/**
	 * get mark staff
	 * @param  integer $id_staff
	 * @return array
	 */
	public function get_mark_staff($id_staff, $training_process_id) {
		$array_training_point = [];
		$training_program_point = 0;

		//Get the latest employee's training result.
		$trainig_resultset = $this->hr_profile_model->get_resultset_training($id_staff, $training_process_id);

		$array_training_resultset = [];
		$array_resultsetid = [];
		$list_resultset_id = '';

		foreach ($trainig_resultset as $item) {
			if (count($array_training_resultset) == 0) {
				array_push($array_training_resultset, $item['trainingid']);
				array_push($array_resultsetid, $item['resultsetid']);

				$list_resultset_id .= '' . $item['resultsetid'] . ',';
			}
			if (!in_array($item['trainingid'], $array_training_resultset)) {
				array_push($array_training_resultset, $item['trainingid']);
				array_push($array_resultsetid, $item['resultsetid']);

				$list_resultset_id .= '' . $item['resultsetid'] . ',';
			}
		}

		$list_resultset_id = rtrim($list_resultset_id, ",");
		$count_out = 0;
		if ($list_resultset_id == "") {
			$list_resultset_id = '0';
		} else {
			$count_out = count($array_training_resultset);
		}

		$array_result = [];
		foreach ($array_training_resultset as $key => $training_id) {
			$total_question = 0;
			$total_question_point = 0;

			$total_point = 0;
			$training_library_name = '';
			$training_question_forms = $this->hr_profile_model->hr_get_training_question_form_by_relid($training_id);
			$hr_position_training = $this->hr_profile_model->get_board_mark_form($training_id);
			$total_question = count($training_question_forms);
			if ($hr_position_training) {
				$training_library_name .= $hr_position_training->subject;
			}

			foreach ($training_question_forms as $question) {
				$flag_check_correct = true;

				$get_id_correct = $this->hr_profile_model->get_id_result_correct($question['questionid']);
				$form_results = $this->hr_profile_model->hr_get_form_results_by_resultsetid($array_resultsetid[$key], $question['questionid']);

				if (count($get_id_correct) == count($form_results)) {
					foreach ($get_id_correct as $correct_key => $correct_value) {
						if (!in_array($correct_value, $form_results)) {
							$flag_check_correct = false;
						}
					}
				} else {
					$flag_check_correct = false;
				}

				$result_point = $this->hr_profile_model->get_point_training_question_form($question['questionid']);
				$total_question_point += $result_point->point;

				if ($flag_check_correct == true) {
					$total_point += $result_point->point;
					$training_program_point += $result_point->point;
				}

			}

			array_push($array_training_point, [
				'training_name' => $training_library_name,
				'total_point' => $total_point,
				'training_id' => $training_id,
				'total_question' => $total_question,
				'total_question_point' => $total_question_point,
			]);
		}

		$response = [];
		$response['training_program_point'] = $training_program_point;
		$response['staff_training_result'] = $array_training_point;

		return $response;
	}

	/**
	 * delete reception
	 * @param  integer $id
	 */
	public function delete_reception($id) {
		$this->hr_profile_model->delete_manage_info_reception($id);
		$this->hr_profile_model->delete_setting_training($id);
		$this->hr_profile_model->delete_setting_asset_allocation($id);
		// $this->hr_profile_model->delete_tranining_result_by_staffid($id);

		$success = $this->hr_profile_model->delete_reception($id);
		if ($success == true) {
			$message = _l('hr_deleted');
			set_alert('success', $message);
		}
		redirect(admin_url('hr_profile/reception_staff'));
	}

	/**
	 * get reception
	 * @param  integer $id
	 * @return json
	 */
	public function get_reception($id = '') {
		$this->load->model('departments_model');
		$this->load->model('staff_model');
		$data['staff'] = $this->staff_model->get($id);

		if (isset($data['staff'])) {
			$data['position'] = $this->hr_profile_model->get_job_position($data['staff']->job_position);
			$data['department'] = $this->hr_profile_model->get_department_by_staffid($data['staff']->staffid);
			$data['group_checklist'] = $this->hr_profile_model->get_group_checklist_allocation_by_staff_id($data['staff']->staffid);
			$data['list_staff_asset'] = $this->hr_profile_model->get_allocation_asset($data['staff']->staffid);

			if (($data['staff']->job_position) && (is_numeric($data['staff']->job_position))) {
				$has_training = 1;
				$data['training_allocation_min_point'] = 0;
				$data['list_training_allocation'] = $this->hr_profile_model->get_training_allocation_staff($data['staff']->staffid);

				if (isset($data['list_training_allocation'])) {

					$job_position_training = $this->hr_profile_model->get_job_position_training_de($data['list_training_allocation']->jp_interview_training_id);

					if ($job_position_training) {
						$data['training_allocation_min_point'] = $job_position_training->mint_point;
					}

					if ($data['list_training_allocation']) {
						$training_process_id = $data['list_training_allocation']->training_process_id;

						$data['list_training'] = $this->hr_profile_model->get_list_position_training_by_id_training($data['list_training_allocation']->training_process_id);

						//Get the latest employee's training result.
						$training_results = $this->get_mark_staff($data['staff']->staffid, $training_process_id);

						$data['training_program_point'] = $training_results['training_program_point'];

						//have not done the test data
						$staff_training_result = [];
						foreach ($data['list_training'] as $key => $value) {
							$staff_training_result[$value['training_id']] = [
								'training_name' => $value['subject'],
								'total_point' => 0,
								'training_id' => $value['training_id'],
								'total_question' => 0,
								'total_question_point' => 0,
							];
						}

						//did the test
						if (count($training_results['staff_training_result']) > 0) {

							foreach ($training_results['staff_training_result'] as $result_key => $result_value) {
								if (isset($staff_training_result[$result_value['training_id']])) {
									unset($staff_training_result[$result_value['training_id']]);
								}
							}

							$data['staff_training_result'] = array_merge($training_results['staff_training_result'], $staff_training_result);

						} else {
							$data['staff_training_result'] = $staff_training_result;
						}

						if ((float) $training_results['training_program_point'] >= (float) $data['training_allocation_min_point']) {
							$data['complete'] = 0;
						} else {
							$data['complete'] = 1;
						}

					}
				}
			}

			echo json_encode([
				'data' => $this->load->view('reception_staff/reception_staff_sidebar', $data, true),
				'success' => true,
			]);
		}
	}

/**
 * change status checklist
 * @return json
 */
	public function change_status_checklist() {
		if ($this->input->post()) {
			$data = $this->input->post();
			$success = $this->hr_profile_model->update_checklist($data);
			if ($success == true) {
				echo json_encode([
					'success' => true,
				]);
			}
		}
	}
/**
 * add new asset
 * @param integer $id
 */
	public function add_new_asset($id) {
		if ($this->input->post()) {
			$data = $this->input->post();
			$list_tt = explode(',', $data['name']);
			$this->hr_profile_model->add_new_asset_staff($id, $list_tt);
			$list_asset = $this->hr_profile_model->get_allocation_asset($id);

			$html = '';
			foreach ($list_asset as $value) {
				$checked = '';
				if ($value['status_allocation'] == 1) {
					$checked = 'checked';
				}
				$html .= '<div class="row item_hover">
	  <div class="col-md-7">
	  <div class="checkbox">
	  <input data-can-view="" type="checkbox" class="capability" id="' . $value['asset_name'] . '" name="asset_staff[]" data-id="' . $value['allocation_id'] . '" value="' . $value['status_allocation'] . '" ' . $checked . ' onclick="active_asset(this);">
	  <label for="' . $value['asset_name'] . '">
	  ' . $value['asset_name'] . '
	  </label>
	  </div>
	  </div>
	  <div class="col-md-3 pt-10">
	  <a href="#" class="text-danger" onclick="delete_asset(this);"  data-id="' . $value['allocation_id'] . '" >' . _l('delete') . '</a>
	  </div>
	  </div>';
			}
			echo json_encode([
				'data' => $html,
				'success' => true,
			]);
		}
	}
/**
 * change status allocation asset
 * @return json
 */
	public function change_status_allocation_asset() {
		if ($this->input->post()) {
			$data = $this->input->post();
			$success = $this->hr_profile_model->update_asset_staff($data);
			if ($success == true) {
				echo json_encode([
					'success' => true,
				]);
			}
		}
	}
/**
 * delete asset
 * @param  integer $id
 * @param  integer $id2
 * @return json
 */
	public function delete_asset($id, $id2) {
		$success = $this->hr_profile_model->delete_allocation_asset($id);
		if ($success == true) {

			$list_asset = $this->hr_profile_model->get_allocation_asset($id2);

			$html = '';
			foreach ($list_asset as $value) {
				$checked = '';
				if ($value['status_allocation'] == 1) {
					$checked = 'checked';
				}
				$html .= '<div class="row item_hover">
	<div class="col-md-7">
	<div class="checkbox">
	<input data-can-view="" type="checkbox" class="capability" name="asset_staff[]" data-id="' . $value['allocation_id'] . '" value="' . $value['status_allocation'] . '" ' . $checked . ' onclick="active_asset(this);">
	<label>
	' . $value['asset_name'] . '
	</label>
	</div>
	</div>
	<div class="col-md-3 pt-10">
	<a href="#" class="text-danger" onclick="delete_asset(this);"  data-id="' . $value['allocation_id'] . '" >' . _l('delete') . '</a>
	</div>
	</div>';
			}
			echo json_encode([
				'data' => $html,
				'success' => true,
			]);
		} else {
			echo json_encode([
				'success' => false,
			]);
		}
	}

	/**
	 * staff infor
	 * @return view
	 */
	public function staff_infor() {
		if (!has_permission('hrm_hr_records', '', 'view') && !has_permission('hrm_hr_records', '', 'view_own')) {
			access_denied('staff');
		}
		$this->load->model('roles_model');
		$this->load->model('staff_model');
		if ($this->input->is_ajax_request()) {
			$this->app->get_table_data(module_views_path('hr_profile', 'table_staff'));
		}
		$data['departments'] = $this->departments_model->get();
		$data['staff_members'] = $this->hr_profile_model->get_staff('', ['active' => 1]);
		$data['title'] = _l('hr_hr_profile');
		$data['dep_tree'] = json_encode($this->hr_profile_model->get_department_tree());
		$data['staff_dep_tree'] = json_encode($this->hr_profile_model->get_staff_tree());

		//load deparment by manager
		if (!is_admin() && !has_permission('hrm_hr_records', '', 'view')) {
			//View own
			$data['staff_members_chart'] = json_encode($this->hr_profile_model->get_data_chart_v2());

		} else {
			//admin or view global
			$data['staff_members_chart'] = json_encode($this->hr_profile_model->get_data_chart());
		}

		$data['staff_role'] = $this->hr_profile_model->get_job_position();

		$this->load->view('hr_record/manage_staff', $data);
	}

	/**
	 * table
	 */
	public function table() {
		$this->app->get_table_data(module_views_path('hr_profile', 'table_staff'));
	}

	/**
	 * importxlsx
	 * @return view
	 */
	public function importxlsx() {
		$data['departments'] = $this->departments_model->get();
		$data['job_positions'] = $this->hr_profile_model->get_job_position();
		$data['workplaces'] = $this->hr_profile_model->get_workplace();
		/*get language active*/
		$data_staff = $this->hr_profile_model->get_staff(get_staff_user_id());
		if ($data_staff) {
			if ($data_staff->default_language != '') {
				$data['active_language'] = $data_staff->default_language;
			} else {
				$data['active_language'] = get_option('active_language');
			}
		} else {
			$data['active_language'] = get_option('active_language');
		}
		$this->load->view('hr_profile/import_xlsx', $data);
	}

	/**
	 * import employees excel
	 * @return [type]
	 */
	public function import_employees_excel() {
		if (!has_permission('hrm_hr_records', '', 'create') && !has_permission('hrm_hr_records', '', 'edit') && !is_admin()) {
			access_denied('hrm_hr_records');
		}

		if (!class_exists('XLSXReader_fin')) {
			require_once module_dir_path(HR_PROFILE_MODULE_NAME) . '/assets/plugins/XLSXReader/XLSXReader.php';
		}
		require_once module_dir_path(HR_PROFILE_MODULE_NAME) . '/assets/plugins/XLSXWriter/xlsxwriter.class.php';

		$filename = '';
		if ($this->input->post()) {
			if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {

				$this->delete_error_file_day_before(1);

				// Get the temp file path
				$tmpFilePath = $_FILES['file_csv']['tmp_name'];
				// Make sure we have a filepath
				if (!empty($tmpFilePath) && $tmpFilePath != '') {
					$rows = [];
					$arr_insert = [];
					$arr_update = [];

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

							_l('id') => 'string',
							_l('hr_staff_code') => 'string',
							_l('hr_firstname') => 'string',
							_l('hr_lastname') => 'string',
							_l('hr_sex') => 'string',
							_l('hr_hr_birthday') => 'string',
							_l('Email') => 'string',
							_l('staff_add_edit_phonenumber') => 'string',
							_l('hr_hr_workplace') => 'string',
							_l('hr_status_work') => 'string',
							_l('hr_hr_job_position') => 'string',
							_l('hr_team_manage') => 'string',
							_l('staff_add_edit_role') => 'string',
							_l('hr_hr_literacy') => 'string',
							_l('staff_hourly_rate') => 'string',
							_l('staff_add_edit_departments') => 'string',
							_l('staff_add_edit_password') => 'string',
							_l('hr_hr_home_town') => 'string',
							_l('hr_hr_marital_status') => 'string',
							_l('hr_current_address') => 'string',
							_l('hr_hr_nation') => 'string',
							_l('hr_hr_birthplace') => 'string',
							_l('hr_hr_religion') => 'string',
							_l('hr_citizen_identification') => 'string',
							_l('hr_license_date') => 'string',
							_l('hr_hr_place_of_issue') => 'string',
							_l('hr_hr_resident') => 'string',
							_l('hr_bank_account_number') => 'string',
							_l('hr_bank_account_name') => 'string',
							_l('hr_bank_name') => 'string',
							_l('hr_Personal_tax_code') => 'string',
							_l('staff_add_edit_facebook') => 'string',
							_l('staff_add_edit_linkedin') => 'string',
							_l('staff_add_edit_twitter') => 'string',

							_l('error') => 'string',
						);

						$writer = new XLSXWriter();
						// $writer->writeSheetHeader('Sheet1', $writer_header,  $col_options = ['widths'=>[40,40,40,50,40,40,40,40,50,50,50,50,50,50,50,50,50,50,50,50,50,50,50,50,50,50,50,50,50,50,50,50,50,50,50]]);

						$widths = [40, 40, 40, 50, 40, 40, 40, 40, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50];
						//orange: do not update
						$col_style1 = [0, 1];
						$style1 = ['widths' => $widths, 'fill' => '#fc2d42', 'font-style' => 'bold', 'color' => '#0a0a0a', 'border' => 'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13];

						//red: required
						$col_style2 = [2, 3, 6, 9, 10];
						$style2 = ['widths' => $widths, 'fill' => '#ff9800', 'font-style' => 'bold', 'color' => '#0a0a0a', 'border' => 'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13];

						//otherwise blue: can be update

						$writer->writeSheetHeader_v2('Sheet1', $writer_header, $col_options = ['widths' => $widths, 'fill' => '#03a9f46b', 'font-style' => 'bold', 'color' => '#0a0a0a', 'border' => 'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13],
							$col_style1, $style1, $col_style2, $style2);

						$row_style1 = array('fill' => '#F8CBAD', 'height' => 25, 'border' => 'left,right,top,bottom', 'border-color' => '#FFFFFF', 'font-size' => 12, 'font' => 'Calibri', 'color' => '#000000');
						$row_style2 = array('fill' => '#FCE4D6', 'height' => 25, 'border' => 'left,right,top,bottom', 'border-color' => '#FFFFFF', 'font-size' => 12, 'font' => 'Calibri', 'color' => '#000000');

						//Reader file
						$xlsx = new XLSXReader_fin($newFilePath);
						$sheetNames = $xlsx->getSheetNames();
						$data = $xlsx->getSheetData($sheetNames[1]);
						$arr_header = [];

						$arr_header['staffid'] = 0;
						$arr_header['staff_identifi'] = 1;
						$arr_header['firstname'] = 2;
						$arr_header['lastname'] = 3;
						$arr_header['sex'] = 4;
						$arr_header['birthday'] = 5;
						$arr_header['email'] = 6;
						$arr_header['phonenumber'] = 7;
						$arr_header['workplace'] = 8;
						$arr_header['status_work'] = 9;
						$arr_header['job_position'] = 10;
						$arr_header['team_manage'] = 11;
						$arr_header['role'] = 12;
						$arr_header['literacy'] = 13;
						$arr_header['hourly_rate'] = 14;
						$arr_header['department'] = 15;
						$arr_header['password'] = 16;
						$arr_header['home_town'] = 17;
						$arr_header['marital_status'] = 18;
						$arr_header['current_address'] = 19;
						$arr_header['nation'] = 20;
						$arr_header['birthplace'] = 21;
						$arr_header['religion'] = 22;
						$arr_header['identification'] = 23;
						$arr_header['days_for_identity'] = 24;
						$arr_header['place_of_issue'] = 25;
						$arr_header['resident'] = 26;
						$arr_header['account_number'] = 27;
						$arr_header['name_account'] = 28;
						$arr_header['issue_bank'] = 29;
						$arr_header['Personal_tax_code'] = 30;
						$arr_header['facebook'] = 31;
						$arr_header['linkedin'] = 32;
						$arr_header['twitter'] = 33;

						$pattern = '#^[a-z][a-z0-9\._]{2,31}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$#';
						$reg_day = '#^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$#';

						$staff_str_result = '';
						$staff_prefix_str = '';
						$staff_prefix_str .= get_hr_profile_option('staff_code_prefix');
						$staff_next_number = (int) get_hr_profile_option('staff_code_number');
						$staff_str_result .= $staff_prefix_str . str_pad($staff_next_number, 5, '0', STR_PAD_LEFT);

						//job position data
						$job_position_data = [];
						$job_positions = $this->hr_profile_model->get_job_position();

						foreach ($job_positions as $key => $job_position) {
							$job_position_data[$job_position['position_code']] = $job_position;
						}

						//direct manager
						$staff_data = [];
						$list_staffs = $this->hr_profile_model->get_staff();
						foreach ($list_staffs as $key => $list_staff) {
							$staff_data[$list_staff['staff_identifi']] = $list_staff;
						}

						//get role data
						$roles_data = [];
						$this->load->model('role/roles_model');
						$list_roles = $this->roles_model->get();
						foreach ($list_roles as $list_role) {
							$roles_data[$list_role['roleid']] = !empty($list_role['permissions']) ? unserialize($list_role['permissions']) : [];
						}

						//get workplace data
						$list_workplaces = $this->hr_profile_model->get_workplace();

						//get list department
						$this->load->model('department/departments_model');
						$list_departments = $this->departments_model->get();

						$total_rows = 0;
						$total_row_false = 0;
						$total_row_success = 0;

						$column_key = $data[1];

						//write the next row (row2)
						$writer->writeSheetRow('Sheet1', array_keys($arr_header));

						for ($row = 2; $row < count($data); $row++) {

							$total_rows++;

							$rd = array();
							$flag = 0;
							$flag2 = 0;
							$flag_mail = 0;

							$string_error = '';

							$flag_value_job_position = 0;
							$flag_value_team_manage = 0;
							$flag_value_workplace = 0;
							$flag_value_role = 0;
							$flag_value_department = [];
							$permissions = [];

							$value_staffid = isset($data[$row][$arr_header['staffid']]) ? $data[$row][$arr_header['staffid']] : '';
							$value_staff_identifi = isset($data[$row][$arr_header['staff_identifi']]) ? $data[$row][$arr_header['staff_identifi']] : '';
							$value_firstname = isset($data[$row][$arr_header['firstname']]) ? $data[$row][$arr_header['firstname']] : '';
							$value_lastname = isset($data[$row][$arr_header['lastname']]) ? $data[$row][$arr_header['lastname']] : '';
							$value_sex = isset($data[$row][$arr_header['sex']]) ? $data[$row][$arr_header['sex']] : '';

							$value_birthday = isset($data[$row][$arr_header['birthday']]) ? $data[$row][$arr_header['birthday']] : '';
							$value_email = isset($data[$row][$arr_header['email']]) ? $data[$row][$arr_header['email']] : '';
							$value_phonenumber = isset($data[$row][$arr_header['phonenumber']]) ? $data[$row][$arr_header['phonenumber']] : '';
							$value_workplace = isset($data[$row][$arr_header['workplace']]) ? $data[$row][$arr_header['workplace']] : '';
							$value_status_work = isset($data[$row][$arr_header['status_work']]) ? $data[$row][$arr_header['status_work']] : '';
							$value_job_position = isset($data[$row][$arr_header['job_position']]) ? $data[$row][$arr_header['job_position']] : '';
							$value_team_manage = isset($data[$row][$arr_header['team_manage']]) ? $data[$row][$arr_header['team_manage']] : '';
							$value_role = isset($data[$row][$arr_header['role']]) ? $data[$row][$arr_header['role']] : '';
							$value_literacy = isset($data[$row][$arr_header['literacy']]) ? $data[$row][$arr_header['literacy']] : '';
							$value_hourly_rate = isset($data[$row][$arr_header['hourly_rate']]) ? $data[$row][$arr_header['hourly_rate']] : '';
							$value_department = isset($data[$row][$arr_header['department']]) ? $data[$row][$arr_header['department']] : '';
							$value_password = isset($data[$row][$arr_header['password']]) ? $data[$row][$arr_header['password']] : '';
							$value_home_town = isset($data[$row][$arr_header['home_town']]) ? $data[$row][$arr_header['home_town']] : '';
							$value_marital_status = isset($data[$row][$arr_header['marital_status']]) ? $data[$row][$arr_header['marital_status']] : '';
							$value_current_address = isset($data[$row][$arr_header['current_address']]) ? $data[$row][$arr_header['current_address']] : '';
							$value_nation = isset($data[$row][$arr_header['nation']]) ? $data[$row][$arr_header['nation']] : '';
							$value_birthplace = isset($data[$row][$arr_header['birthplace']]) ? $data[$row][$arr_header['birthplace']] : '';
							$value_religion = isset($data[$row][$arr_header['religion']]) ? $data[$row][$arr_header['religion']] : '';
							$value_identification = isset($data[$row][$arr_header['identification']]) ? $data[$row][$arr_header['identification']] : '';
							$value_days_for_identity = isset($data[$row][$arr_header['days_for_identity']]) ? $data[$row][$arr_header['days_for_identity']] : '';
							$value_place_of_issue = isset($data[$row][$arr_header['place_of_issue']]) ? $data[$row][$arr_header['place_of_issue']] : '';
							$value_resident = isset($data[$row][$arr_header['resident']]) ? $data[$row][$arr_header['resident']] : '';
							$value_account_number = isset($data[$row][$arr_header['account_number']]) ? $data[$row][$arr_header['account_number']] : '';
							$value_name_account = isset($data[$row][$arr_header['name_account']]) ? $data[$row][$arr_header['name_account']] : '';
							$value_issue_bank = isset($data[$row][$arr_header['issue_bank']]) ? $data[$row][$arr_header['issue_bank']] : '';
							$value_Personal_tax_code = isset($data[$row][$arr_header['Personal_tax_code']]) ? $data[$row][$arr_header['Personal_tax_code']] : '';
							$value_facebook = isset($data[$row][$arr_header['facebook']]) ? $data[$row][$arr_header['facebook']] : '';
							$value_linkedin = isset($data[$row][$arr_header['linkedin']]) ? $data[$row][$arr_header['linkedin']] : '';
							$value_twitter = isset($data[$row][$arr_header['skype']]) ? $data[$row][$arr_header['skype']] : '';

							/*check null*/
							if (is_null($value_firstname) == true || $value_firstname == '') {
								$string_error .= _l('hr_firstname') . ' ' . _l('not_yet_entered') . '; ';
								$flag = 1;
							}

							/*check null*/
							if (is_null($value_lastname) == true || $value_lastname == '') {
								$string_error .= _l('hr_lastname') . ' ' . _l('not_yet_entered') . '; ';
								$flag = 1;
							}

							if (is_null($value_status_work) == true || $value_status_work == '') {
								$string_error .= _l('hr_status_work') . ' ' . _l('not_yet_entered') . '; ';
								$flag = 1;
							}

							if (is_null($value_job_position) == true || $value_job_position == '') {
								$string_error .= _l('hr_hr_job_position') . ' ' . _l('not_yet_entered') . '; ';
								$flag = 1;
							}

							if (is_null($value_sex) != true && $value_sex != '') {

								if ($value_sex != 'male' && $value_sex != 'female') {
									$string_error .= _l('hr_sex') . ' ' . _l('does_not_exist') . '; ';
									$flag2 = 1;
								}
							}

							if (is_null($value_email) == true || $value_email == '') {
								$string_error .= _l('email') . ' ' . _l('not_yet_entered') . '; ';
								$flag = 1;
							} else {
								if (preg_match($pattern, $value_email, $match) != 1) {
									$string_error .= _l('email') . ' ' . _l('invalid') . '; ';
									$flag = 1;
								} else {
									$flag_mail = 1;
								}
							}

							//check mail exist
							if ($flag_mail == 1) {

								if ($value_staffid == '' || is_null($value_staffid) == true) {

									$this->db->where('email', $value_email);
									$total_rows_email = $this->db->count_all_results(db_prefix() . 'staff');
									if ($total_rows_email > 0) {
										$string_error .= _l('email') . ' ' . _l('exist') . '; ';
										$flag2 = 1;
									}
								}

							}

							//check start_time
							if (is_null($value_birthday) != true && $value_birthday != '') {

								if (is_null($value_birthday) != true) {

									if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", trim($value_birthday, " "))) {
										$test = true;

									} else {
										$flag2 = 1;
										$string_error .= _l('hr_hr_birthday') . ' ' . _l('invalid') . '; ';
									}
								}
							}

							//check start_time
							if (is_null($value_days_for_identity) != true && $value_days_for_identity != '') {

								if (is_null($value_days_for_identity) != true) {

									if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", trim($value_days_for_identity, " "))) {
										$test = true;

									} else {
										$flag2 = 1;
										$string_error .= _l('days_for_identity') . ' ' . _l('invalid') . '; ';
									}
								}
							}

							//check position is int
							if (is_null($value_job_position) != true && strlen($value_job_position) > 0) {

								if (!isset($job_position_data[$value_job_position])) {
									$string_error .= _l('hr_hr_job_position') . ' ' . _l('does_not_exist') . '; ';
									$flag2 = 1;
								} else {
									$flag_value_job_position = $job_position_data[$value_job_position]['position_id'];
								}

							}

							//value_team_manage
							if (is_null($value_team_manage) != true && strlen($value_team_manage) > 0) {

								if (!isset($staff_data[$value_team_manage])) {
									$string_error .= _l('hr_team_manage') . ' ' . _l('does_not_exist') . '; ';
									$flag2 = 1;
								} else {

									$flag_value_team_manage = $staff_data[$value_team_manage]['staffid'];
								}
							}

							//check workplace is int
							if (is_null($value_workplace) != true && strlen($value_workplace) > 0) {

								$workplaces_flag = false;
								foreach ($list_workplaces as $list_workplace) {
									if ($list_workplace['name'] == $value_workplace) {
										$workplaces_flag = true;

										$flag_value_workplace = $list_workplace['id'];
									}
								}

								if ($workplaces_flag == false) {
									$string_error .= _l('hr_hr_workplace') . ' ' . _l('does_not_exist') . '; ';
									$flag2 = 1;

								} else {
								}

							}

							//check role
							if (is_null($value_role) != true && strlen($value_role) > 0) {

								$roles_flag = false;
								foreach ($list_roles as $list_role) {
									if ($list_role['name'] == $value_role) {
										$roles_flag = true;

										$flag_value_role = $list_role['roleid'];

										if (isset($roles_data[$list_role['roleid']])) {
											$permissions = $roles_data[$list_role['roleid']];

										}

									}
								}

								if ($roles_flag == false) {
									$string_error .= _l('staff_add_edit_role') . ' ' . _l('does_not_exist') . '; ';
									$flag2 = 1;

								}

							}

							//check department
							if (is_null($value_department) != true && strlen($value_department) > 0) {
								$arr_department_value = explode(';', $value_department);

								$deparments_flag = true;
								$str_deparments_not_exist = '';
								$temp_str_deparments_not_exist = explode(';', $value_department);

								foreach ($list_departments as $list_department) {

									if (in_array($list_department['name'], $arr_department_value)) {

										$flag_value_department[] = $list_department['departmentid'];

										foreach ($temp_str_deparments_not_exist as $key => $str_deparments_not_exist) {
											if ($str_deparments_not_exist == $list_department['name']) {

												unset($temp_str_deparments_not_exist[$key]);

											}
										}
									}

								}

								if (count($temp_str_deparments_not_exist) > 0) {
									$string_error .= _l('staff_add_edit_departments') . ': ' . implode(';', $temp_str_deparments_not_exist) . ' ' . _l('does_not_exist');
									$flag2 = 1;

								}

							}

							if (($flag == 1) || $flag2 == 1) {
								//write error file
								$writer->writeSheetRow('Sheet1', [
									$value_staffid,
									$value_staff_identifi,
									$value_firstname,
									$value_lastname,
									$value_sex,
									$value_birthday,
									$value_email,
									$value_phonenumber,
									$value_workplace,
									$value_status_work,
									$value_job_position,
									$value_team_manage,
									$value_role,
									$value_literacy,
									$value_hourly_rate,
									$value_department,
									$value_password,
									$value_home_town,
									$value_marital_status,
									$value_current_address,
									$value_nation,
									$value_birthplace,
									$value_religion,
									$value_identification,
									$value_days_for_identity,
									$value_place_of_issue,
									$value_resident,
									$value_account_number,
									$value_name_account,
									$value_issue_bank,
									$value_Personal_tax_code,
									$value_facebook,
									$value_linkedin,
									$value_twitter,
									$string_error,
								]);

								// $numRow++;
								$total_row_false++;
							}

							if ($flag == 0 && $flag2 == 0) {

								$rd['staffid'] = $value_staffid;
								$rd['staff_identifi'] = $staff_prefix_str . str_pad($staff_next_number, 5, '0', STR_PAD_LEFT);
								$rd['firstname'] = $value_firstname;
								$rd['lastname'] = $value_lastname;
								$rd['sex'] = $value_sex;
								$rd['birthday'] = $value_birthday;
								$rd['email'] = $value_email;
								$rd['phonenumber'] = $value_phonenumber;
								$rd['workplace'] = $flag_value_workplace;
								$rd['status_work'] = $value_status_work;
								$rd['job_position'] = $flag_value_job_position;
								$rd['team_manage'] = $flag_value_team_manage;
								$rd['role'] = $flag_value_role;
								$rd['literacy'] = $value_literacy;
								$rd['hourly_rate'] = $value_hourly_rate;
								$rd['departments'] = $flag_value_department;

								if (strlen($value_password) > 0) {
									$rd['password'] = $value_password;
								} else {
									$rd['password'] = '123456';
								}

								$rd['home_town'] = $value_home_town;
								$rd['marital_status'] = $value_marital_status;
								$rd['current_address'] = $value_current_address;
								$rd['nation'] = $value_nation;
								$rd['birthplace'] = $value_birthplace;
								$rd['religion'] = $value_religion;
								$rd['identification'] = $value_identification;
								$rd['days_for_identity'] = $value_days_for_identity;
								$rd['place_of_issue'] = $value_place_of_issue;
								$rd['resident'] = $value_resident;
								$rd['account_number'] = $value_account_number;
								$rd['name_account'] = $value_name_account;
								$rd['issue_bank'] = $value_issue_bank;
								$rd['Personal_tax_code'] = $value_Personal_tax_code;
								$rd['facebook'] = $value_facebook;
								$rd['linkedin'] = $value_linkedin;
								$rd['twitter'] = $value_twitter;

								$rd['permissions'] = $permissions;

								$rows[] = $rd;
								array_push($arr_insert, $rd);

								$staff_next_number++;

							}

							if ($flag == 0 && $flag2 == 0) {

								// $rd = array_combine($column_key, $data[$row]);

								if ($rd['staffid'] == '' || $rd['staffid'] == 0) {

									$rd['email_signature'] = '';
									//insert staff
									$response = $this->hr_profile_model->add_staff($rd);
									if ($response) {
										$total_row_success++;
									}
								} else {
									//update staff
									unset($data['staff_identifi']);
									unset($data['password']);

									$rd['email_signature'] = '';
									$response = $this->hr_profile_model->update_staff($rd, $rd['staffid']);
									if ($response) {
										$total_row_success++;
									}
								}

							}

						}

						$total_rows = $total_rows;
						$total_row_success = $total_row_success;
						$dataerror = '';
						$message = 'Not enought rows for importing';

						if ($total_row_false != 0) {
							$filename = 'Import_employee_error_' . get_staff_user_id() . '_' . strtotime(date('Y-m-d H:i:s')) . '.xlsx';
							$writer->writeToFile(str_replace($filename, HR_PROFILE_ERROR . $filename, $filename));
						}

					}
				}
			}
		}

		if (file_exists($newFilePath)) {
			@unlink($newFilePath);
		}

		echo json_encode([
			'message' => $message,
			'total_row_success' => $total_row_success,
			'total_row_false' => $total_row_false,
			'total_rows' => $total_rows,
			'site_url' => site_url(),
			'staff_id' => get_staff_user_id(),
			'filename' => HR_PROFILE_ERROR . $filename,
		]);
	}

	/**
	 * importxlsx2
	 * @return  json
	 */
	public function importxlsx2() {
		if (!is_admin() && get_option('allow_non_admin_members_to_import_leads') != '1') {
			access_denied('Leads Import');
		}
		$total_row_false = 0;
		$total_rows = 0;
		$dataerror = 0;
		$total_row_success = 0;
		if ($this->input->post()) {
			if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {
				// Get the temp file path
				$tmpFilePath = $_FILES['file_csv']['tmp_name'];
				// Make sure we have a filepath
				if (!empty($tmpFilePath) && $tmpFilePath != '') {
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
						$import_result = true;
						$rows = [];

						$objReader = new PHPExcel_Reader_Excel2007();
						$objReader->setReadDataOnly(true);
						$objPHPExcel = $objReader->load($newFilePath);
						$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
						$sheet = $objPHPExcel->getActiveSheet();

						$dataError = new PHPExcel();
						$dataError->setActiveSheetIndex(0);
						$dataError->getActiveSheet()->setTitle('Data is not allowed');
						$dataError->getActiveSheet()->getColumnDimension('A')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('B')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('D')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('E')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('F')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('G')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('H')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('I')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('J')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('K')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('L')->setWidth(30);
						$dataError->getActiveSheet()->getColumnDimension('M')->setWidth(30);
						$dataError->getActiveSheet()->getColumnDimension('N')->setWidth(30);
						$dataError->getActiveSheet()->getColumnDimension('O')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('P')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('R')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('S')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('T')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('U')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('V')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('W')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('X')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
						$dataError->getActiveSheet()->getStyle('A1:AA1')->getFont()->setBold(true);

						$dataError->getActiveSheet()->setCellValue('A1', _l('hr_staff_code'));
						$dataError->getActiveSheet()->setCellValue('B1', _l('hr_firstname'));
						$dataError->getActiveSheet()->setCellValue('C1', _l('hr_lastname'));
						$dataError->getActiveSheet()->setCellValue('D1', _l('email'));
						$dataError->getActiveSheet()->setCellValue('E1', _l('hr_gender'));
						$dataError->getActiveSheet()->setCellValue('F1', _l('birthday'));
						$dataError->getActiveSheet()->setCellValue('G1', _l('phonenumber'));
						$dataError->getActiveSheet()->setCellValue('H1', _l('nation'));
						$dataError->getActiveSheet()->setCellValue('I1', _l('religion'));
						$dataError->getActiveSheet()->setCellValue('J1', _l('birthplace'));
						$dataError->getActiveSheet()->setCellValue('K1', _l('home_town'));
						$dataError->getActiveSheet()->setCellValue('L1', _l('resident'));
						$dataError->getActiveSheet()->setCellValue('M1', _l('hr_current_address'));
						$dataError->getActiveSheet()->setCellValue('N1', _l('marital_status'));
						$dataError->getActiveSheet()->setCellValue('O1', _l('identification'));
						$dataError->getActiveSheet()->setCellValue('P1', _l('days_for_identity'));
						$dataError->getActiveSheet()->setCellValue('Q1', _l('place_of_issue'));
						$dataError->getActiveSheet()->setCellValue('R1', _l('literacy'));
						$dataError->getActiveSheet()->setCellValue('S1', _l('job_position'));
						$dataError->getActiveSheet()->setCellValue('T1', _l('hr_job_rank'));
						$dataError->getActiveSheet()->setCellValue('U1', _l('workplace'));
						$dataError->getActiveSheet()->setCellValue('V1', _l('departments'));
						$dataError->getActiveSheet()->setCellValue('W1', _l('account_number'));
						$dataError->getActiveSheet()->setCellValue('X1', _l('hr_name_account'));
						$dataError->getActiveSheet()->setCellValue('Y1', _l('hr_issue_bank'));
						$dataError->getActiveSheet()->setCellValue('Z1', _l('hr_Personal_tax_code'));
						$dataError->getActiveSheet()->setCellValue('AA1', _l('hr_status_work'));
						$dataError->getActiveSheet()->setCellValue('AB1', _l('password'));
						$dataError->getActiveSheet()->setCellValue('AC1', _l('error'));

						$styleArray = array(
							'font' => array(
								'bold' => true,
								'color' => array('rgb' => 'ff0000'),

							));
						$numRow = 2;
						$total_rows = 0;

						//get data for compare
						foreach ($rowIterator as $row) {

							$rowIndex = $row->getRowIndex();

							if ($rowIndex > 1) {
								$rd = array();
								$flag = 0;
								$flag2 = 0;
								$flag_mail = 0;
								$string_error = '';
								$value_cell_hrcode = $sheet->getCell('A' . $rowIndex)->getValue();
								$value_cell_first_name = $sheet->getCell('B' . $rowIndex)->getValue();
								$value_cell_last_name = $sheet->getCell('C' . $rowIndex)->getValue();
								$value_cell_email = $sheet->getCell('D' . $rowIndex)->getValue();
								$value_cell_sex = $sheet->getCell('E' . $rowIndex)->getValue();
								$value_cell_birthday = $sheet->getCell('F' . $rowIndex)->getValue();
								$value_cell_maries_status = $sheet->getCell('N' . $rowIndex)->getValue();

								$value_cell_status = $sheet->getCell('AA' . $rowIndex)->getValue();
								$value_cell_day_identity = $sheet->getCell('P' . $rowIndex)->getValue();
								$value_cell_position = $sheet->getCell('S' . $rowIndex)->getValue();
								$value_cell_workplace = $sheet->getCell('U' . $rowIndex)->getValue();
								$value_cell_password = $sheet->getCell('AB' . $rowIndex)->getValue();
								$pattern = '#^[a-z][a-z0-9\._]{2,31}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$#';
								$reg_day = '#^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$#';
								$position_array = $this->hr_profile_model->get_job_position_arrayid();
								$workplace_array = $this->hr_profile_model->get_workplace_array_id();
								$sex_array = ['0', '1'];
								$status_array = ['0', '1', '2'];

								if (is_null($value_cell_hrcode) == true) {
									$string_error .= _l('hr_hr_code') . _l('not_yet_entered');
									$flag = 1;
								}

								if (is_null($value_cell_first_name) == true) {
									$string_error .= _l('hr_firstname') . _l('not_yet_entered');
									$flag = 1;
								}

								if (is_null($value_cell_last_name) == true) {
									$string_error .= _l('hr_lastname') . _l('not_yet_entered');
									$flag = 1;
								}

								if (is_null($value_cell_email) == true) {
									$string_error .= _l('email') . _l('not_yet_entered');
									$flag = 1;
								} else {
									if (preg_match($pattern, $value_cell_email, $match) != 1) {
										$string_error .= _l('email') . _l('invalid');
										$flag = 1;
									} else {
										$flag_mail = 1;
									}
								}

								//check hr_code exist
								if (is_null($value_cell_hrcode) != true) {
									$this->db->where('staff_identifi', $value_cell_hrcode);
									$hrcode = $this->db->count_all_results('tblstaff');
									if ($hrcode > 0) {
										$string_error .= _l('hr_hr_code') . _l('exist');
										$flag2 = 1;
									}

								}
								//check mail exist
								if ($flag_mail == 1) {
									$this->db->where('email', $value_cell_email);
									$total_rows_email = $this->db->count_all_results(db_prefix() . 'staff');
									if ($total_rows_email > 0) {
										$string_error .= _l('email') . _l('exist');
										$flag2 = 1;
									}
								}

								//check sex is int
								if (is_null($value_cell_sex) != true) {
									if (is_string($value_cell_sex)) {
										$string_error .= _l('hr_sex') . _l('invalid');
										$flag2 = 1;

									} elseif (in_array($value_cell_sex, $sex_array) != true) {
										$string_error .= _l('hr_sex') . _l('does_not_exist');
										$flag2 = 1;
									}
								}

								//check position is int
								if (is_null($value_cell_position) != true) {
									if (is_string($value_cell_position)) {
										$string_error .= _l('job_position') . _l('invalid');
										$flag2 = 1;

									} elseif (in_array($value_cell_position, $position_array) != true) {
										$string_error .= _l('job_position') . _l('does_not_exist');
										$flag2 = 1;
									}

								}
								//check status is int
								if (is_null($value_cell_status) != true) {
									if (is_string($value_cell_status)) {
										$string_error .= _l('hr_status_work') . _l('invalid');
										$flag2 = 1;

									} elseif (in_array($value_cell_status, $status_array) != true) {
										$string_error .= _l('hr_status_work') . _l('does_not_exist');
										$flag2 = 1;
									}
								}
								//check workplace is int
								if (is_null($value_cell_workplace) != true) {
									if (!is_numeric($value_cell_workplace)) {
										$string_error .= _l('workplace') . _l('invalid');
										$flag2 = 1;
									} elseif (in_array($value_cell_workplace, $workplace_array) != true) {
										$string_error .= _l('workplace') . _l('does_not_exist');
										$flag2 = 1;
									}
								}

								//check birday input
								if (is_null($value_cell_birthday) != true) {
									if (preg_match($reg_day, $value_cell_birthday, $match) != 1) {
										$string_error .= _l('birthday') . _l('invalid');
										$flag = 1;
									}
								}
								//check day identity
								if (is_null($value_cell_day_identity) != true) {
									if (preg_match($reg_day, $value_cell_day_identity, $match) != 1) {
										$string_error .= _l('days_for_identity') . _l('invalid');
										$flag = 1;
									}

								}

								if (($flag == 1) || ($flag2 == 1)) {
									$dataError->getActiveSheet()->setCellValue('A' . $numRow, $sheet->getCell('A' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('B' . $numRow, $sheet->getCell('B' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('C' . $numRow, $sheet->getCell('C' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('D' . $numRow, $sheet->getCell('D' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('E' . $numRow, $sheet->getCell('E' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('F' . $numRow, $sheet->getCell('F' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('G' . $numRow, $sheet->getCell('G' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('H' . $numRow, $sheet->getCell('H' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('I' . $numRow, $sheet->getCell('I' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('J' . $numRow, $sheet->getCell('J' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('K' . $numRow, $sheet->getCell('K' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('L' . $numRow, $sheet->getCell('L' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('M' . $numRow, $sheet->getCell('M' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('N' . $numRow, $sheet->getCell('N' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('O' . $numRow, $sheet->getCell('O' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('P' . $numRow, $sheet->getCell('P' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('Q' . $numRow, $sheet->getCell('Q' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('R' . $numRow, $sheet->getCell('R' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('S' . $numRow, $sheet->getCell('S' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('T' . $numRow, $sheet->getCell('T' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('U' . $numRow, $sheet->getCell('U' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('V' . $numRow, $sheet->getCell('V' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('W' . $numRow, $sheet->getCell('W' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('X' . $numRow, $sheet->getCell('X' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('Y' . $numRow, $sheet->getCell('Y' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('Z' . $numRow, $sheet->getCell('Z' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('AA' . $numRow, $sheet->getCell('AA' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('AB' . $numRow, $sheet->getCell('AB' . $rowIndex)->getValue());

									$dataError->getActiveSheet()->setCellValue('AC' . $numRow, $string_error)->getStyle('AC' . $numRow)->applyFromArray($styleArray);

									$numRow++;
								}

								if (($flag == 0) && ($flag2 == 0)) {

									if (is_null($value_cell_sex)) {
										$rd['sex'] = '';
									} else {
										if ($value_cell_sex == 0) {
											$rd['sex'] = 'male';
										} else {
											$rd['sex'] = 'female';
										}
									}

									if (is_null($value_cell_status)) {
										$rd['status_work'] = '';
									} else {
										if ($value_cell_status == 0) {
											$rd['status_work'] = 'Working';
										} elseif ($value_cell_status == 1) {
											$rd['status_work'] = 'Maternity leave';
										} else {
											$rd['status_work'] = 'Inactivity';

										}
									}

									if (is_null($value_cell_maries_status)) {
										$rd['marital_status'] = '';
									} else {
										if ($value_cell_sex == 0) {
											$rd['marital_status'] = 'single';
										} else {
											$rd['marital_status'] = 'married';
										}
									}

									if (is_null($value_cell_birthday) == true) {
										$rd['birthday'] = '';
									} else {
										$rd['birthday'] = $value_cell_birthday;
									}

									if (is_null($value_cell_day_identity) == true) {
										$rd['days_for_identity'] = '';
									} else {
										$rd['days_for_identity'] = $value_cell_birthday;
									}

									if (is_null($value_cell_email) == true) {
										$rd['email'] = '';
									} else {
										$rd['email'] = $value_cell_email;
									}

									if (is_null($value_cell_position) == true) {
										$rd['job_position'] = '';
									} else {
										$rd['job_position'] = $value_cell_position;
									}

									if (is_null($value_cell_workplace) == true) {
										$rd['workplace'] = '';
									} else {
										$rd['workplace'] = $value_cell_workplace;
									}

									if (is_null($value_cell_password) == true) {
										$rd['password'] = '123456a@';
									} else {
										$rd['password'] = $value_cell_password;
									}
									$rd['staff_identifi'] = $sheet->getCell('A' . $rowIndex)->getValue();
									$rd['firstname'] = $sheet->getCell('B' . $rowIndex)->getValue();
									$rd['lastname'] = $sheet->getCell('C' . $rowIndex)->getValue();
									$rd['email'] = $sheet->getCell('D' . $rowIndex)->getValue();
									$rd['sex'] = $sheet->getCell('E' . $rowIndex)->getValue();
									$rd['birthday'] = $sheet->getCell('F' . $rowIndex)->getValue();
									$rd['phonenumber'] = $sheet->getCell('G' . $rowIndex)->getValue();
									$rd['nation'] = $sheet->getCell('H' . $rowIndex)->getValue();
									$rd['religion'] = $sheet->getCell('I' . $rowIndex)->getValue();
									$rd['birthplace'] = $sheet->getCell('J' . $rowIndex)->getValue();
									$rd['home_town'] = $sheet->getCell('K' . $rowIndex)->getValue();
									$rd['resident'] = $sheet->getCell('L' . $rowIndex)->getValue();
									$rd['current_address'] = $sheet->getCell('M' . $rowIndex)->getValue();
									$rd['marital_status'] = $sheet->getCell('N' . $rowIndex)->getValue();
									$rd['identification'] = $sheet->getCell('O' . $rowIndex)->getValue();
									$rd['days_for_identity'] = $sheet->getCell('P' . $rowIndex)->getValue();
									$rd['place_of_issue'] = $sheet->getCell('Q' . $rowIndex)->getValue();
									$rd['literacy'] = $sheet->getCell('R' . $rowIndex)->getValue();
									$rd['job_position'] = $sheet->getCell('S' . $rowIndex)->getValue();
									$rd['workplace'] = $sheet->getCell('U' . $rowIndex)->getValue();
									$rd['departments'] = explode(",", $sheet->getCell('V' . $rowIndex)->getValue());
									$rd['account_number'] = $sheet->getCell('W' . $rowIndex)->getValue();
									$rd['name_account'] = $sheet->getCell('X' . $rowIndex)->getValue();
									$rd['issue_bank'] = $sheet->getCell('Y' . $rowIndex)->getValue();
									$rd['Personal_tax_code'] = $sheet->getCell('Z' . $rowIndex)->getValue();
									$rd['status_work'] = $sheet->getCell('AA' . $rowIndex)->getValue();
									$rd['password'] = $sheet->getCell('AB' . $rowIndex)->getValue();
								}

								if (get_staff_user_id() != '' && $flag == 0 && $flag2 == 0) {
									$rows[] = $rd;
									$this->hr_profile_model->add_staff($rd);
								}
								$total_rows++;
							}
						}

						$total_rows = $total_rows;
						$data['total_rows_post'] = count($rows);
						$total_row_success = count($rows);
						$total_row_false = $total_rows - (int) count($rows);
						$dataerror = $dataError;
						$message = 'Not enought rows for importing';

						if ($total_row_false != 0) {

							$objWriter = new PHPExcel_Writer_Excel2007($dataError);
							$filename = 'file_error_hr_profile' . get_staff_user_id() . '.xlsx';
							$objWriter->save($filename);

						}
						$import_result = true;
						@delete_dir($tmpDir);

					}
				} else {
					set_alert('warning', _l('import_upload_failed'));
				}
			}

		}
		echo json_encode([
			'message' => $message,
			'total_row_success' => $total_row_success,
			'total_row_false' => $total_row_false,
			'total_rows' => $total_rows,
			'site_url' => site_url(),
			'staff_id' => get_staff_user_id(),
		]);

	}
/**
 * delete staff
 */
	public function delete_staff() {
		if (!is_admin() && is_admin($this->input->post('id'))) {
			die('Busted, you can\'t delete administrators');
		}
		if (has_permission('hrm_hr_records', '', 'delete')) {
			$success = $this->hr_profile_model->delete_staff($this->input->post('id'), $this->input->post('transfer_data_to'));
			if ($success) {
				set_alert('success', _l('deleted', _l('staff_member')));
			}
		}
		redirect(admin_url('hr_profile/staff_infor'));
	}

	/**
	 * member
	 * @param  integer $id
	 * @param  integer $group
	 * @return view
	 */
	public function member($id = '', $group = '') {

		$data['staffid'] = $id;
		$data['group'] = $group;

		$data['tab'][] = 'profile';
		$data['tab'][] = 'contract';
		$data['tab'][] = 'dependent_person';
		$data['tab'][] = 'training';
		$data['tab'][] = 'staff_project';
		$data['tab'][] = 'attach';
        $data['tab'][] = 'immigration';
        $data['tab'][] = 'document';
        $data['tab'][] = 'qualification';
        $data['tab'][] = 'work_experience';
        $data['tab'][] = 'emergency_contacts';
        $data['tab'][] = 'bank_account';
		$data['tab'][] = 'warning';


		$data['tab'] = hooks()->apply_filters('hr_profile_tab_name', $data['tab']);

		if ($data['group'] == '') {
			$data['group'] = 'profile';
		}
		$data['hr_profile_member_add'] = false;
		if ($id == '') {
			if (!is_admin() && !has_permission('hrm_hr_records', '', 'create') && !has_permission('hrm_hr_records', '', 'edit')) {
				access_denied('staff');
			}
			$data['hr_profile_member_add'] = true;
			$title = _l('add_new', _l('staff_member_lowercase'));
		} else {
			//View own
			$staff_ids = $this->hr_profile_model->get_staff_by_manager();

			if (!in_array($id, $staff_ids) && get_staff_user_id() != $id && !is_admin() && !has_permission('hrm_hr_records', '', 'edit') && !has_permission('hrm_hr_records', '', 'view') && !has_permission('hrm_hr_records', '', 'create')) {
				access_denied('staff');
			}

			$member = $this->hr_profile_model->get_staff($id);
			if (!$member) {
				blank_page('Staff Member Not Found', 'danger');
			}
			$data['member'] = $member;
			$title = $member->firstname . ' ' . $member->lastname;
            $data['datecreated']=$member->datecreated;
			if ($data['group'] == 'profile') {
				$data['staff_departments'] = $this->departments_model->get_staff_departments($id);
				$data['list_staff'] = $this->staff_model->get();

				$recordsreceived = $this->hr_profile_model->get_records_received($id);
				$data['records_received'] = json_decode($recordsreceived->records_received, true);
				$data['checkbox'] = [];
				if (isset($data['records_received'])) {
					foreach ($data['records_received'] as $value) {
						$data['checkbox'][$value['datakey']] = $value['value'];
					}
				}
				$data['staff_departments'] = $this->departments_model->get_staff_departments($member->staffid);
				$data['staff_avatar'] = $this->hr_profile_model->get_hr_profile_profile_file($id);
				$data['staff_cover_image'] = $this->hr_profile_model->get_hr_profile_profile_file($id);

				$data['logged_time'] = $this->staff_model->get_logged_time_data($id);
				$data['staff_p'] = $this->staff_model->get($id);
				$data['staff_departments'] = $this->departments_model->get_staff_departments($data['staff_p']->staffid);
				// notifications
				$total_notifications = total_rows(db_prefix() . 'notifications', [
					'touserid' => get_staff_user_id(),
				]);
				$data['total_pages'] = ceil($total_notifications / $this->misc_model->get_notifications_limit());

			}
			if ($data['group'] == 'dependent_person') {
				$data['dependent_person'] = $this->hr_profile_model->get_dependent_person_bytstaff($id);
			}
            if ($this->input->is_ajax_request()) {
                if($group == 'immigration'){
                    $this->load->library("hr_profile/HrmApp");
                   // $this->hrmapp->get_table_data('my_immigrations_table', ['staff_id' => $id]);
                    $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_immigrations_table'), ['staff_id' => $id]);

                }
                elseif($group == 'bank_account'){
                    $this->load->library("hr_profile/HrmApp");
                    //$this->hrmapp->get_table_data('my_bank_account_table', ['staff_id' => $id]);
                  $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_bank_account_table'), ['staff_id' => $id]);

                }
                if($group == 'work_experience'){
                    $this->load->library("hr_profile/HrmApp");
                   // $this->hrmapp->get_table_data('my_work_experience_table', ['staff_id' => $id]);
                    $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_work_experience_table'), ['staff_id' => $id]);
                }

                elseif($group == 'emergency_contacts'){
                    $this->load->library("hr_profile/HrmApp");
                 //  $this->hrmapp->get_table_data('my_emergency_contacts_table', ['staff_id' => $id]);
                    $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_emergency_contacts_table'), ['staff_id' => $id]);
                }

                if($group == 'qualification'){
                    $this->load->library("hr_profile/HrmApp");
                   // $this->hrmapp->get_table_data('my_qualifications_table', ['staff_id' => $id]);
                    $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_qualifications_table'), ['staff_id' => $id]);

                }


				if($group == 'document'){
					$this->load->library("hr_profile/HrmApp");
					//  $this->hrmapp->get_table_data('my_document_table', ['staff_id' => $id]);
					$this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_document_table'), ['staff_id' => $id]);

				}

				if($group == 'warning'){
					$this->load->library("hr_profile/HrmApp");
					//  $this->hrmapp->get_table_data('my_document_table', ['staff_id' => $id]);
					$this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_warnings_table'), ['staff_id' => $id]);

				}
            }
			if ($data['group'] == 'attach') {
				$data['hr_profile_staff'] = $this->hr_profile_model->get_hr_profile_attachments($id);
			}
			if ($data['group'] == 'staff_project') {
				$data['logged_time'] = $this->staff_model->get_logged_time_data($id);
				$data['staff_p'] = $this->staff_model->get($id);
				$data['staff_departments'] = $this->departments_model->get_staff_departments($data['staff_p']->staffid);
				//
				$total_notifications = total_rows(db_prefix() . 'notifications', [
					'touserid' => get_staff_user_id(),
				]);
				$data['total_pages'] = ceil($total_notifications / $this->misc_model->get_notifications_limit());

			}

			if ($data['group'] == 'training') {

				$training_data = [];
				//Onboarding training
				$training_allocation_staff = $this->hr_profile_model->get_training_allocation_staff($id);

				if ($training_allocation_staff != null) {

					$training_data['list_training_allocation'] = get_object_vars($training_allocation_staff);
				}

				if (isset($training_allocation_staff) && $training_allocation_staff != null) {
					$training_data['training_allocation_min_point'] = 0;

					$job_position_training = $this->hr_profile_model->get_job_position_training_de($training_allocation_staff->jp_interview_training_id);

					if ($job_position_training) {
						$training_data['training_allocation_min_point'] = $job_position_training->mint_point;
					}

					if ($training_allocation_staff) {
						$training_process_id = $training_allocation_staff->training_process_id;

						$training_data['list_training'] = $this->hr_profile_model->get_list_position_training_by_id_training($training_process_id);

						//Get the latest employee's training result.
						$training_results = $this->get_mark_staff($id, $training_process_id);

						$training_data['training_program_point'] = $training_results['training_program_point'];
						$training_data['staff_training_result'] = $training_results['staff_training_result'];

						//have not done the test data
						$staff_training_result = [];
						foreach ($training_data['list_training'] as $key => $value) {
							$staff_training_result[$value['training_id']] = [
								'training_name' => $value['subject'],
								'total_point' => 0,
								'training_id' => $value['training_id'],
								'total_question' => 0,
								'total_question_point' => 0,
							];
						}

						//did the test
						if (count($training_results['staff_training_result']) > 0) {

							foreach ($training_results['staff_training_result'] as $result_key => $result_value) {
								if (isset($staff_training_result[$result_value['training_id']])) {
									unset($staff_training_result[$result_value['training_id']]);
								}
							}

							$training_data['staff_training_result'] = array_merge($training_results['staff_training_result'], $staff_training_result);

						} else {
							$training_data['staff_training_result'] = $staff_training_result;
						}

						if ((float) $training_results['training_program_point'] >= (float) $training_data['training_allocation_min_point']) {
							$training_data['complete'] = 0;
						} else {
							$training_data['complete'] = 1;
						}

					}
				}

				if (count($training_data) > 0) {
					$data['training_data'][] = $training_data;
				}

				//Additional training
				$additional_trainings = $this->hr_profile_model->get_additional_training($id);

				foreach ($additional_trainings as $key => $value) {
					$training_temp = [];

					$training_temp['training_allocation_min_point'] = $value['mint_point'];
					$training_temp['list_training_allocation'] = $value;
					$training_temp['list_training'] = $this->hr_profile_model->get_list_position_training_by_id_training($value['position_training_id']);

					//Get the latest employee's training result.
					$training_results = $this->get_mark_staff($id, $value['position_training_id']);

					$training_temp['training_program_point'] = $training_results['training_program_point'];
					$training_temp['staff_training_result'] = $training_results['staff_training_result'];

					//have not done the test data
					$staff_training_result = [];
					foreach ($training_temp['list_training'] as $key => $value) {
						$staff_training_result[$value['training_id']] = [
							'training_name' => $value['subject'],
							'total_point' => 0,
							'training_id' => $value['training_id'],
							'total_question' => 0,
							'total_question_point' => 0,
						];
					}

					//did the test
					if (count($training_results['staff_training_result']) > 0) {

						foreach ($training_results['staff_training_result'] as $result_key => $result_value) {
							if (isset($staff_training_result[$result_value['training_id']])) {
								unset($staff_training_result[$result_value['training_id']]);
							}
						}

						$training_temp['staff_training_result'] = array_merge($training_results['staff_training_result'], $staff_training_result);

					} else {
						$training_temp['staff_training_result'] = $staff_training_result;
					}

					if ((float) $training_results['training_program_point'] >= (float) $training_temp['training_allocation_min_point']) {
						$training_temp['complete'] = 0;
					} else {
						$training_temp['complete'] = 1;
					}

					if (count($training_temp) > 0) {
						$data['training_data'][] = $training_temp;
					}

				}

			}
		}
		$this->load->model('currencies_model');
		$data['positions'] = $this->hr_profile_model->get_job_position();
		$data['workplace'] = $this->hr_profile_model->get_workplace();
		$data['base_currency'] = $this->currencies_model->get_base_currency();

		$data['roles'] = $this->roles_model->get();
		$data['user_notes'] = $this->misc_model->get_notes($id, 'staff');
		$data['departments'] = $this->departments_model->get();
		$data['title'] = $title;

		$data['contract_type'] = $this->hr_profile_model->get_contracttype();
		$data['staff'] = $this->staff_model->get();
		$data['allowance_type'] = $this->hr_profile_model->get_allowance_type();
		$data['salary_form'] = $this->hr_profile_model->get_salary_form();
		$data['list_staff'] = $this->staff_model->get();

		$data['tabs']['view'] = 'hr_record/includes/' . $data['group'];
        $data['staff_id']=$id;
		$data['tabs']['view'] = hooks()->apply_filters('hr_profile_tab_content', $data['tabs']['view']);

		$this->load->view('hr_record/member', $data);
	}

	/**
	 * table education position
	 */
	public function table_education_position() {
		$this->app->get_table_data(module_views_path('hr_profile', 'hr_record/table_education_by_position'));
	}

	/**
	 * table education
	 */
	public function table_education($staff_id = '') {
		$this->app->get_table_data(module_views_path('hr_profile', 'hr_record/table_education'), ['staff_id' => $staff_id]);
	}

	/**
	 * save update education
	 * @return json
	 */
	public function save_update_education() {
		if ($this->input->post()) {
			$data = $this->input->post();
			$data['training_time_from'] = to_sql_date($data['training_time_from'], true);
			$data['training_time_to'] = to_sql_date($data['training_time_to'], true);
			$data['admin_id'] = get_staff_user_id();
			$data['programe_id'] = '';
			$data['date_create'] = date('Y-m-d');
			if ($data['id'] == '') {
				$success = $this->hr_profile_model->add_education($data);
				$message = _l('added_successfully', _l('hr_education'));
				$message_f = _l('hr_added_failed', _l('hr_education'));
				if ($success) {
					echo json_encode([
						'success' => true,
						'message' => $message,
					]);
				} else {
					echo json_encode([
						'success' => false,
						'message' => $message_f,
					]);
				}
			} else {
				$success = $this->hr_profile_model->update_education($data);
				$message = _l('updated_successfully', _l('hr_education'));
				$message_f = _l('hr_update_failed', _l('hr_education'));
				if ($success) {
					echo json_encode([
						'success' => true,
						'message' => $message,
					]);
				} else {
					echo json_encode([
						'success' => false,
						'message' => $message_f,
					]);
				}
			}
		}

		die;
	}

/**
 * delete education
 * @return json
 */
	public function delete_education() {
		if ($this->input->post()) {
			$data = $this->input->post();
			$success = $this->hr_profile_model->delete_education($data['id']);
			if ($success == true) {
				$message = _l('hr_deleted');
				echo json_encode([
					'success' => true,
					'message' => $message,
				]);
			} else {
				$message = _l('problem_deleting');
				echo json_encode([
					'success' => true,
					'message' => $message,
				]);
			}
		}
	}
/**
 * table reception
 */
	public function table_reception() {
		if ($this->input->is_ajax_request()) {
			$this->app->get_table_data(module_views_path('hr_profile', 'includes/reception_table'));
		}
	}
/**
 * general bonus
 * @param  integer $id
 * @return json
 */
	public function general_bonus($id) {
		$select = [
			db_prefix() . 'bonus_discipline_detail.id',
			db_prefix() . 'bonus_discipline_detail.id',
			db_prefix() . 'bonus_discipline_detail.id',
			db_prefix() . 'bonus_discipline_detail.id',
			db_prefix() . 'bonus_discipline_detail.id',
		];
		$where = [' where staff_id = ' . $id . ' and type = 1 and status = 2'];
		$aColumns = $select;
		$sIndexColumn = 'id';
		$sTable = db_prefix() . 'bonus_discipline_detail';
		$join = [' LEFT JOIN ' . db_prefix() . 'bonus_discipline ON ' . db_prefix() . 'bonus_discipline.id = ' . db_prefix() . 'bonus_discipline_detail.id_bonus_discipline'];

		$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
			db_prefix() . 'bonus_discipline_detail.id',
			db_prefix() . 'bonus_discipline_detail.from_time',
			'staff_id',
			'apply_for',
			db_prefix() . 'bonus_discipline_detail.lever_bonus',
			db_prefix() . 'bonus_discipline.name',
			db_prefix() . 'bonus_discipline.type',
			db_prefix() . 'bonus_discipline.id_criteria',
			db_prefix() . 'bonus_discipline_detail.formality',
			db_prefix() . 'bonus_discipline_detail.formality_value',
			db_prefix() . 'bonus_discipline_detail.description',
		]);

		$output = $result['output'];
		$rResult = $result['rResult'];
		foreach ($rResult as $aRow) {
			$row = [];
			$row[] = $aRow['name'];
			$criterial = '';
			$list_criteria = json_decode($aRow['id_criteria']);
			if ($list_criteria) {
				foreach ($list_criteria as $key => $criteria) {
					$criterial = '<span class="badge inline-block project-status" class="bg-white text-dark"> ' . $this->hr_profile_model->get_criteria($criteria)->kpi_name . ' </span>  ';
				}
			}

			$row[] = $criterial;
			$row[] = _l($aRow['from_time']);
			$formality = '';
			$value_formality = '';
			if (isset($aRow['formality'])) {
				if ($aRow['formality'] == 'bonus_money') {
					$formality = _l('bonus_money');
					$value_formality = app_format_money($aRow['formality_value'], '');
				}
				if ($aRow['formality'] == 'indemnify') {
					$formality = _l('indemnify');
					$t = explode(',', $aRow['formality_value']);
					$value_formality = _l('amount_of_damage') . ': ' . app_format_money((int) $t[0], '') . '<br>' . _l('indemnify') . ': ' . app_format_money((int) $t[1], '');
				}
				if ($aRow['formality'] == 'commend') {
					$formality = _l('commend');
				}
				if ($aRow['formality'] == 'remind') {
					$formality = _l('remind');
				}
			}
			$row[] = $formality;
			$row[] = $value_formality;

			$output['aaData'][] = $row;
		}
		echo json_encode($output);
		die();
	}
/**
 * general discipline
 * @param  integer $id
 * @return json
 */
	public function general_discipline($id) {
		$select = [
			db_prefix() . 'bonus_discipline_detail.id',
			db_prefix() . 'bonus_discipline_detail.id',
			db_prefix() . 'bonus_discipline_detail.id',

			db_prefix() . 'bonus_discipline_detail.id',
			db_prefix() . 'bonus_discipline_detail.id',
		];
		$where = [' where staff_id = ' . $id . ' and type = 2 and status = 2'];
		$aColumns = $select;
		$sIndexColumn = 'id';
		$sTable = db_prefix() . 'bonus_discipline_detail';
		$join = [' LEFT JOIN ' . db_prefix() . 'bonus_discipline ON ' . db_prefix() . 'bonus_discipline.id = ' . db_prefix() . 'bonus_discipline_detail.id_bonus_discipline'];

		$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
			db_prefix() . 'bonus_discipline_detail.id',
			db_prefix() . 'bonus_discipline_detail.from_time',
			'staff_id',
			'apply_for',
			db_prefix() . 'bonus_discipline_detail.lever_bonus',
			db_prefix() . 'bonus_discipline.name',
			db_prefix() . 'bonus_discipline.type',
			db_prefix() . 'bonus_discipline.id_criteria',
			db_prefix() . 'bonus_discipline_detail.formality',
			db_prefix() . 'bonus_discipline_detail.formality_value',
			db_prefix() . 'bonus_discipline_detail.description',
		]);

		$output = $result['output'];
		$rResult = $result['rResult'];
		foreach ($rResult as $aRow) {
			$row = [];
			$row[] = $aRow['name'];
			$criterial = '';
			$list_criteria = json_decode($aRow['id_criteria']);
			if ($list_criteria) {
				foreach ($list_criteria as $key => $criteria) {
					$criterial = '<span class="badge inline-block project-status" class="bg-white text-dark"> ' . $this->hr_profile_model->get_criteria($criteria)->kpi_name . ' </span>  ';
				}
			}
			$row[] = $criterial;
			$row[] = _l($aRow['from_time']);
			$formality = '';
			$value_formality = '';
			if (isset($aRow['formality'])) {
				if ($aRow['formality'] == 'bonus_money') {
					$formality = _l('bonus_money');
					$value_formality = app_format_money($aRow['formality_value'], '') . 'đ';
				}
				if ($aRow['formality'] == 'indemnify') {
					$formality = _l('indemnify');
					$t = explode(',', $aRow['formality_value']);
					$value_formality = _l('amount_of_damage') . ': ' . app_format_money((int) $t[0], '') . 'đ<br>' . _l('indemnify') . ': ' . app_format_money((int) $t[1], '');
				}
				if ($aRow['formality'] == 'commend') {
					$formality = _l('commend');
				}
				if ($aRow['formality'] == 'remind') {
					$formality = _l('remind');
				}
			}
			$row[] = $formality;
			$row[] = $value_formality;

			$output['aaData'][] = $row;
		}
		echo json_encode($output);
		die();
	}
/**
 * records received
 * @return json
 */
	public function records_received() {
		if ($this->input->is_ajax_request()) {
			if ($this->input->post() != null) {
				$data = $this->input->post();
				$data1 = $data['dt_record'];
				$this->db->set('records_received', $data1);
				$this->db->where('staffid', $data['staffid']);
				$this->db->update(db_prefix() . 'staff');
				$affected_rows = $this->db->affected_rows();
				if ($affected_rows > 0) {
					$message = 'Add records received success';
				} else {
					$message = 'Add records received false';
				}
				echo json_encode([
					'message' => $message,
				]);
			}
		}
	}

	/**
	 * upload file
	 * @return json
	 */
	public function upload_file() {
		$staffid = $this->input->post('staffid');
		$files = handle_hr_profile_attachments_array($staffid, 'file');
		$success = false;
		$count_id = 0;
		$message = '';

		if ($files) {
			$i = 0;
			$len = count($files);
			foreach ($files as $file) {
				$insert_id = $this->hr_profile_model->add_attachment_to_database($staffid, 'hr_staff_file', [$file], false);
				if ($insert_id > 0) {
					$count_id++;
				}
				$i++;
			}
			if ($insert_id == $i) {
				$message = 'Upload file success';
			}
		}

		$hr_profile_staff = $this->hr_profile_model->get_hr_profile_attachments($staffid);
		$data = '';
		foreach ($hr_profile_staff as $key => $attachment) {
			$href_url = site_url('modules/hr_profile/uploads/att_file/' . $attachment['rel_id'] . '/' . $attachment['file_name']) . '" download';
			if (!empty($attachment['external'])) {
				$href_url = $attachment['external_link'];
			}
			$data .= '<div class="display-block contract-attachment-wrapper">';
			$data .= '<div class="col-md-10">';
			$data .= '<div class="col-md-1 mr-5">';
			$data .= '<a name="preview-btn" onclick="preview_file_staff(this); return false;" rel_id = "' . $attachment['rel_id'] . '" id = "' . $attachment['id'] . '" href="Javascript:void(0);" class="mbot10 btn btn-success pull-left" data-toggle="tooltip" title data-original-title="' . _l("preview_file") . '">';
			$data .= '<i class="fa fa-eye"></i>';
			$data .= '</a>';
			$data .= '</div>';
			$data .= '<div class=col-md-9>';
			$data .= '<div class="pull-left"><i class="' . get_mime_class($attachment['filetype']) . '"></i></div>';
			$data .= '<a href="' . $href_url . '>' . $attachment['file_name'] . '</a>';
			$data .= '<p class="text-muted">' . $attachment["filetype"] . '</p>';
			$data .= '</div>';
			$data .= '</div>';
			$data .= '<div class="col-md-2 text-right">';
			if ($attachment['staffid'] == get_staff_user_id() || is_admin() || has_permission('hrm_hr_records', '', 'edit')) {
				$data .= '<a href="#" class="text-danger" onclick="delete_hr_att_file_attachment(this,' . $attachment['id'] . '); return false;"><i class="fa fa fa-times"></i></a>';
			}
			$data .= '</div>';
			$data .= '<div class="clearfix"></div><hr/>';
			$data .= '</div>';
		}

		echo json_encode([
			'message' => _l('hr_attach_file_successfully'),
			'data' => $data,
		]);
	}

	/**
	 * hr profile file
	 * @param  integer $id
	 * @param  string $rel_id
	 */
	public function hr_profile_file($id, $rel_id) {
		$data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
		$data['current_user_is_admin'] = is_admin();
		$data['file'] = $this->hr_profile_model->get_file($id, $rel_id);
		if (!$data['file']) {
			header('HTTP/1.0 404 Not Found');
			die;
		}
		$this->load->view('hr_profile/includes/_file', $data);
	}

	/**
	 * delete hr profile staff attachment
	 * @param  integer $attachment_id
	 * @return json
	 */
	public function delete_hr_profile_staff_attachment($attachment_id) {
		$file = $this->misc_model->get_file($attachment_id);
		if ($file->staffid == get_staff_user_id() || is_admin() || has_permission('hrm_hr_records', '', 'edit')) {
			$result = $this->hr_profile_model->delete_hr_profile_staff_attachment($attachment_id);

			if ($result) {
				$status = true;
				$message = _l('hr_deleted');
			} else {
				$message = _l('problem_deleting');
				$status = false;

			}
			echo json_encode([
				'success' => $status,
				'message' => $message,
			]);
		} else {
			access_denied('hr_profile');
		}
	}

/**
 * update staff permission
 */
	public function update_staff_permission() {
		$data = $this->input->post();
		if ($data['id'] != '') {
			if (!$data['id'] == get_staff_user_id() && !is_admin() && !hr_profile_permissions('hr_profile', '', 'edit')) {
				access_denied('hr_profile');
			}
			$response = $this->hr_profile_model->update_staff_permissions($data);
			if ($response == true) {
				set_alert('success', _l('updated_successfully', _l('staff_member')));
			} else {
				set_alert('danger', _l('updated_failed', _l('staff_member')));
			}
		}
		redirect(admin_url('hr_profile/member/' . $data['id'] . '/permission'));
	}
/**
 * update staff profile
 */
	public function update_staff_profile() {
		$data = $this->input->post();
		if ($data['id'] == '') {
			unset($data['id']);
			if (!has_permission('hrm_hr_records', '', 'create') && !has_permission('hrm_hr_records', '', 'edit') && !is_admin()) {
				access_denied('member');
			}
			$id = $this->hr_profile_model->add_staff($data);
			if ($id) {
				hr_profile_handle_staff_profile_image_upload($id);
				set_alert('success', _l('added_successfully', _l('staff_member')));
				redirect(admin_url('hr_profile/member/' . $id . '/profile'));
			}
		} else {
			if (!$data['id'] == get_staff_user_id() && !is_admin() && !hr_profile_permissions('hr_profile', '', 'edit')) {
				access_denied('hr_profile');
			}
			$response = $this->hr_profile_model->update_staff_profile($data);
			if ($response == true) {
				hr_profile_handle_staff_profile_image_upload($data['id']);
			}
			if (is_array($response)) {
				if (isset($response['cant_remove_main_admin'])) {
					set_alert('warning', _l('staff_cant_remove_main_admin'));
				} elseif (isset($response['cant_remove_yourself_from_admin'])) {
					set_alert('warning', _l('staff_cant_remove_yourself_from_admin'));
				}
			} elseif ($response == true) {
				set_alert('success', _l('updated_successfully', _l('staff_member')));
			}
			redirect(admin_url('hr_profile/member/' . $data['id'] . '/profile'));
		}
	}

	/**
	 * add update staff bonus discipline
	 */
	public function add_update_staff_bonus_discipline() {
		if ($this->input->post()) {
			$data = $this->input->post();
			$this->hr_profile_model->update_bonus_discipline($data['id_detail'], $data);
			$message = _l('hr_updated_successfully');
			set_alert('success', $message);
			redirect(admin_url('hr_profile/view_bonus_discipline/' . $data['id']));
		}
	}
	/**
	 * file view bonus discipline
	 * @param  integer $id
	 * @return view
	 */
	public function file_view_bonus_discipline($id) {
		$data['rel_id'] = $id;
		$data['file'] = $this->hr_profile_model->get_file_info($id, 'bonus_discipline');
		if (!$data['file']) {
			header('HTTP/1.0 404 Not Found');
			die;
		}
		$this->load->view('_file_bonus_discipline', $data);
	}

	/**
	 * workplace
	 * @param  string $id
	 * @return [type]
	 */
	public function workplace($id = '') {

		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {
				$id = $this->hr_profile_model->add_workplace($data);

				if ($id) {
					$message = _l('added_successfully', _l('workplace'));
					set_alert('success', $message);
				} else {
					$message = _l('added_failed', _l('workplace'));
					set_alert('warning', $message);
				}

				redirect(admin_url('hr_profile/setting?group=workplace'));
			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->hr_profile_model->update_workplace($data, $id);

				if ($success) {
					$message = _l('updated_successfully', _l('workplace'));
					set_alert('success', $message);

				} else {
					$message = _l('update_failed', _l('workplace'));
					set_alert('warning', $message);
				}

				redirect(admin_url('hr_profile/setting?group=workplace'));
			}

		}
	}

	/**
	 * delete workplace
	 * @param  [type] $id
	 * @return [type]
	 */
	public function delete_workplace($id) {
		if (!$id) {
			redirect(admin_url('hr_profile/setting?group=workplace'));
		}
		$response = $this->hr_profile_model->delete_workplace($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('hr_is_referenced', _l('workplace')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('workplace')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('workplace')));
		}
		redirect(admin_url('hr_profile/setting?group=workplace'));
	}

	public function hr_profile_permission_table() {
		if ($this->input->is_ajax_request()) {

			$select = [
				'staffid',
				'CONCAT(firstname," ",lastname) as full_name',
				'firstname', //for role name
				'email',
				'phonenumber',
			];
			$where = [];
			$where[] = 'AND ' . db_prefix() . 'staff.admin != 1';

			$arr_staff_id = hr_profile_get_staff_id_hr_permissions();

			if (count($arr_staff_id) > 0) {
				$where[] = 'AND ' . db_prefix() . 'staff.staffid IN (' . implode(', ', $arr_staff_id) . ')';
			} else {
				$where[] = 'AND ' . db_prefix() . 'staff.staffid IN ("")';
			}

			$aColumns = $select;
			$sIndexColumn = 'staffid';
			$sTable = db_prefix() . 'staff';
			$join = ['LEFT JOIN ' . db_prefix() . 'roles ON ' . db_prefix() . 'roles.roleid = ' . db_prefix() . 'staff.role'];

			$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'roles.name as role_name', db_prefix() . 'staff.role']);

			$output = $result['output'];
			$rResult = $result['rResult'];

			$not_hide = '';

			foreach ($rResult as $aRow) {
				$row = [];

				$row[] = '<a href="' . admin_url('staff/member/' . $aRow['staffid']) . '">' . $aRow['full_name'] . '</a>';

				$row[] = $aRow['role_name'];
				$row[] = $aRow['email'];
				$row[] = $aRow['phonenumber'];

				$options = '';

				if (has_permission('hrm_setting', '', 'edit')) {
					$options = icon_btn('#', 'edit', 'btn-default', [
						'title' => _l('hr_edit'),
						'onclick' => 'hr_profile_permissions_update(' . $aRow['staffid'] . ', ' . $aRow['role'] . ', ' . $not_hide . '); return false;',
					]);
				}

				if (has_permission('hrm_setting', '', 'delete')) {
					$options .= icon_btn('hr_profile/delete_hr_profile_permission/' . $aRow['staffid'], 'remove', 'btn-danger _delete', ['title' => _l('delete')]);
				}

				$row[] = $options;

				$output['aaData'][] = $row;
			}

			echo json_encode($output);
			die();
		}
	}

	/**
	 * permission modal
	 * @return [type]
	 */
	public function permission_modal() {
		if (!$this->input->is_ajax_request()) {
			show_404();
		}
		$this->load->model('staff_model');

		if ($this->input->post('slug') === 'update') {
			$staff_id = $this->input->post('staff_id');
			$role_id = $this->input->post('role_id');

			$data = ['funcData' => ['staff_id' => isset($staff_id) ? $staff_id : null]];

			if (isset($staff_id)) {
				$data['member'] = $this->staff_model->get($staff_id);
			}

			$data['roles_value'] = $this->roles_model->get();
			$data['staffs'] = hr_profile_get_staff_id_dont_permissions();
			$add_new = $this->input->post('add_new');

			if ($add_new == ' hide') {
				$data['add_new'] = ' hide';
				$data['display_staff'] = '';
			} else {
				$data['add_new'] = '';
				$data['display_staff'] = ' hide';
			}

			$this->load->view('includes/permissions', $data);
		}
	}

	/**
	 * hr profile update permissions
	 * @param  string $id
	 * @return [type]
	 */
	public function hr_profile_update_permissions($id = '') {
		if (!is_admin()) {
			access_denied('hr_profile');
		}
		$data = $this->input->post();

		if (!isset($id) || $id == '') {
			$id = $data['staff_id'];
		}

		if (isset($id) && $id != '') {

			$data = hooks()->apply_filters('before_update_staff_member', $data, $id);

			if (is_admin()) {
				if (isset($data['administrator'])) {
					$data['admin'] = 1;
					unset($data['administrator']);
				} else {
					if ($id != get_staff_user_id()) {
						if ($id == 1) {
							return [
								'cant_remove_main_admin' => true,
							];
						}
					} else {
						return [
							'cant_remove_yourself_from_admin' => true,
						];
					}
					$data['admin'] = 0;
				}
			}

			$this->db->where('staffid', $id);
			$this->db->update(db_prefix() . 'staff', [
				'role' => $data['role'],
			]);

			$response = $this->staff_model->update_permissions((isset($data['admin']) && $data['admin'] == 1 ? [] : $data['permissions']), $id);
		} else {
			$this->load->model('roles_model');

			$role_id = $data['role'];
			unset($data['role']);
			unset($data['staff_id']);

			$data['update_staff_permissions'] = true;

			$response = $this->roles_model->update($data, $role_id);
		}

		if (is_array($response)) {
			if (isset($response['cant_remove_main_admin'])) {
				set_alert('warning', _l('staff_cant_remove_main_admin'));
			} elseif (isset($response['cant_remove_yourself_from_admin'])) {
				set_alert('warning', _l('staff_cant_remove_yourself_from_admin'));
			}
		} elseif ($response == true) {
			set_alert('success', _l('updated_successfully', _l('staff_member')));
		}
		redirect(admin_url('hr_profile/setting?group=hr_profile_permissions'));

	}

	/**
	 * staff id changed
	 * @param  [type] $staff_id
	 * @return [type]
	 */
	public function staff_id_changed($staff_id) {
		$role_id = '';
		$status = 'false';
		$r_permission = [];

		$staff = $this->staff_model->get($staff_id);

		if ($staff) {
			if (count($staff->permissions) > 0) {
				foreach ($staff->permissions as $permission) {
					$r_permission[$permission['feature']][] = $permission['capability'];
				}
			}

			$role_id = $staff->role;
			$status = 'true';

		}

		if (count($r_permission) > 0) {
			$data = ['role_id' => $role_id, 'status' => $status, 'permission' => 'true', 'r_permission' => $r_permission];
		} else {
			$data = ['role_id' => $role_id, 'status' => $status, 'permission' => 'false', 'r_permission' => $r_permission];
		}

		echo json_encode($data);
		die;
	}

	/**
	 * delete hr profile permission
	 * @param  [type] $id
	 * @return [type]
	 */
	public function delete_hr_profile_permission($id) {
		if (!is_admin()) {
			access_denied('hr_profile');
		}

		$response = $this->hr_profile_model->delete_hr_profile_permission($id);

		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('hr_is_referenced', _l('department_lowercase')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('hr_department')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('department_lowercase')));
		}
		redirect(admin_url('hr_profile/setting?group=hr_profile_permissions'));

	}

	/**
	 * zen unit chart
	 * @param  [type] $department
	 * @return [type]
	 */
	public function zen_unit_chart($department) {
		$this->load->model('staff_model');
		$dpm = $this->departments_model->get($department);
		$dpm_data = $this->hr_profile_model->get_data_dpm_chart($department);
		$reality_now = $this->hr_profile_model->count_reality_now($department);

		$list_job = $this->hr_profile_model->list_job_department($department);

		$html = '<table class="table table-striped table-bordered text-nowrap dataTable no-footer dtr-inline collapsed"  ><tbody>';
		$html .= '<tr class="text-white">
						<th>' . _l('position') . '</th>
						<th>' . _l('hr_now') . '</th>
						<th>' . _l('hrplanning') . '</th>
					</tr>';

		$li_jobid = [];

		if (count($list_job) > 0) {
			foreach ($list_job as $lj) {
				if ($lj != '') {
					if (!in_array($lj, $li_jobid)) {
						$html .= '<tr class="text-white">
								<td class="text-left">' . job_name_by_id($lj) . '</td>
								<td>' . count_staff_job_unnit($department, $lj) . '</td>
								<td>' . count_staff_job_unnit($department, $lj) . '</td>
							</tr>';
					}
				}

			}
		}

		$html .= '</tbody></table>';

		echo json_encode([
			'dpm_name' => $dpm->name,
			'data' => $dpm_data,
			'reality_now' => $reality_now,
			'html' => $html,
		]);

	}

	/**
	 * get list job position training
	 * @param  [type] $id
	 * @return [type]
	 */
	public function get_list_job_position_training($id) {
		$list = $this->hr_profile_model->get_job_position_training_de($id);
		if (isset($list)) {
			$description = $list->description;
		} else {
			$description = '';

		}
		echo json_encode([
			'description' => $description,

		]);
	}

	/**
	 * delete job position training process
	 * @param  [type] $training_id
	 * @return [type]
	 */
	public function delete_job_position_training_process($training_id) {
		if (!has_permission('staffmanage_job_position', '', 'delete')) {
			access_denied('job_position');
		}

		if (!$training_id) {
			redirect(admin_url('hr_profile/training/?group=training_program'));
		}
		$success = $this->hr_profile_model->delete_job_position_training_process($training_id);
		if ($success) {
			set_alert('success', _l('hr_deleted'));
		} else {
			set_alert('warning', _l('problem_deleting'));
		}
		redirect(admin_url('hr_profile/training/?group=training_program'));
	}

	/**
	 * delete position training
	 * @param  [type] $id
	 * @return [type]
	 */
	public function delete_position_training($id) {
		if (!has_permission('staffmanage_job_position', '', 'delete')) {
			access_denied('job_position');
		}
		if (!$id) {
			redirect(admin_url('hr_profile/training'));
		}
		$success = $this->hr_profile_model->delete_position_training($id);
		if ($success) {
			set_alert('success', _l('hr_deleted'));
		} else {
			set_alert('warning', _l('problem_deleting'));
		}
		redirect(admin_url('hr_profile/training'));
	}

	/**
	 * table contract
	 * @return [type]
	 */
	public function table_contract() {
		$this->app->get_table_data(module_views_path('hr_profile', 'contracts/table_contract'));
	}

	/**
	 * contracts
	 * @param  string $id
	 * @return [type]
	 */
	public function contracts($id = '') {
		$this->load->model('staff_model');

		if (!has_permission('hrm_contract', '', 'view') && !has_permission('hrm_contract', '', 'view_own') && !is_admin()) {
			access_denied('staff_contract');
		}

		//filter from dasboard
		$data_get = $this->input->get();
		if (isset($data_get['to_expire'])) {
			$data['to_expire'] = true;
		}

		if (isset($data_get['overdue_contract'])) {
			$data['overdue_contract'] = true;
		}

		$data['hrmcontractid'] = $id;
		$data['positions'] = $this->hr_profile_model->get_job_position();
		$data['workplace'] = $this->hr_profile_model->get_workplace();
		$data['contract_type'] = $this->hr_profile_model->get_contracttype();
		$data['staff'] = $this->staff_model->get();
		$data['allowance_type'] = $this->hr_profile_model->get_allowance_type();
		$data['salary_form'] = $this->hr_profile_model->get_salary_form();
		$data['duration'] = $this->hr_profile_model->get_duration();
		$data['contract_attachment'] = $this->hr_profile_model->get_hrm_attachments_file($id, 'hr_contract');
		$data['dep_tree'] = json_encode($this->hr_profile_model->get_department_tree());

		$data['title'] = _l('hr_hr_contracts');
		$this->load->view('contracts/manage_contract', $data);
	}

	/**
	 * contract
	 * @param  string $id
	 * @return [type]
	 */
	public function contract($id = '') {
		if (!has_permission('hrm_contract', '', 'view') && !has_permission('hrm_contract', '', 'view_own') && !is_admin()) {
			access_denied('staff_contract');
		}

		if ($this->input->post()) {
			$data = $this->input->post();
			$count_file = 0;
			if ($id == '') {
				if (!has_permission('hrm_contract', '', 'create') && !is_admin()) {
					access_denied('staff_contract');
				}
				$id = $this->hr_profile_model->add_contract($data);

				//upload file
				if ($id) {
					$success = true;
					$_id = $id;
					$message = _l('added_successfully', _l('contract_attachment'));
					$uploadedFiles = hr_profile_handle_contract_attachments_array($id, 'file');

					if ($uploadedFiles && is_array($uploadedFiles)) {
						foreach ($uploadedFiles as $file) {

							$insert_file_id = $this->hr_profile_model->add_attachment_to_database($id, 'hr_contract', [$file]);
						}
					}
				}

				if ($id) {
					set_alert('success', _l('added_successfully', _l('contract')));
					redirect(admin_url('hr_profile/contracts/' . $id));
				}

			} else {
				if (!has_permission('hrm_contract', '', 'edit') && !is_admin()) {
					access_denied('staff_contract');
				}

				$response = $this->hr_profile_model->update_contract($data, $id);
				//upload file
				if ($id) {
					$success = true;
					$_id = $id;
					$message = _l('added_successfully', _l('contract_attachment'));
					$uploadedFiles = hr_profile_handle_contract_attachments_array($id, 'file');
					if ($uploadedFiles && is_array($uploadedFiles)) {
						$len = count($uploadedFiles);

						foreach ($uploadedFiles as $file) {
							$insert_file_id = $this->hr_profile_model->add_attachment_to_database($id, 'hr_contract', [$file]);
							if ($insert_file_id > 0) {
								$count_file++;
							}
						}
						if ($count_file == $len) {
							$response = true;
						}
					}
				}

				if (is_array($response)) {
					if (isset($response['cant_remove_main_admin'])) {
						set_alert('warning', _l('staff_cant_remove_main_admin'));
					} elseif (isset($response['cant_remove_yourself_from_admin'])) {
						set_alert('warning', _l('staff_cant_remove_yourself_from_admin'));
					}
				} elseif ($response == true) {
					set_alert('success', _l('updated_successfully', _l('contract')));
				}
				redirect(admin_url('hr_profile/contracts/' . $id));
			}
		}

		if ($id == '') {
			$title = _l('add_new', _l('contract'));
			$data['title'] = $title;
			$data['staff_contract_code'] = $this->hr_profile_model->create_code('staff_contract_code');
		} else {

			$contract = $this->hr_profile_model->get_contract($id);

			//load deparment by manager
			if (!is_admin() && !has_permission('hrm_contract', '', 'view')) {
				//View own
				if ($contract) {
					$staff_ids = $this->hr_profile_model->get_staff_by_manager();
					if (count($staff_ids) > 0) {
						if (!in_array($contract->staff, $staff_ids)) {
							access_denied('staff_contract');
						}
					} else {
						access_denied('staff_contract');
					}
				}

			}

			$contract_detail = $this->hr_profile_model->get_contract_detail($id);
			$data['contract_attachment'] = $this->hr_profile_model->get_hrm_attachments_file($id, 'hr_contract');
			if (!$contract) {
				blank_page('Contract Not Found', 'danger');
			}

			$data['contracts'] = $contract;
			if ($contract) {
				$data['staff_delegate_role'] = $this->hr_profile_model->get_staff_role($contract->staff_delegate);
			}

			$data['contract_details'] = json_encode($contract_detail);
			if ($contract) {
				$title = $this->hr_profile_model->get_contracttype_by_id($contract->name_contract);
				if (isset($title[0]['name_contracttype'])) {
					$data['title'] = $title[0]['name_contracttype'];
				}
			}

		}
        $this->load->model('currencies_model');
        $data['base_currency'] = $this->currencies_model->get_base_currency();

		$data['positions'] = $this->hr_profile_model->get_job_position();
		$data['workplace'] = $this->hr_profile_model->get_workplace();
		$data['contract_type'] = $this->hr_profile_model->get_contracttype();
		$data['staff'] = $this->hr_profile_model->get_staff_active();
		$data['allowance_type'] = $this->hr_profile_model->get_allowance_type();
		$data['salary_allowance_type'] = $this->hr_profile_model->get_salary_allowance_handsontable();
		$types = [];
		$types[] = [
			'id' => 'salary',
			'label' => _l('salary'),
		];
		$types[] = [
			'id' => 'allowance',
			'label' => _l('allowance'),
		];

		$data['types'] = $types;

		$this->load->view('hr_profile/contracts/contract', $data);
	}

	/**
	 * delete contract
	 * @param  [type] $id
	 * @return [type]
	 */
	public function delete_contract($id) {
		if (!has_permission('hrm_contract', '', 'delete') && !is_admin()) {
			access_denied('staff_contract');
		}

		if (!$id) {
			redirect(admin_url('hr_profile/contracts'));
		}

		$response = $this->hr_profile_model->delete_contract($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('hr_is_referenced', _l('contract')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('contract')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('contract')));
		}
		redirect(admin_url('hr_profile/contracts'));

	}

	/**
	 * contract code exists
	 * @return [type]
	 */
	public function contract_code_exists() {
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {
				// First we need to check if the email is the same
				$contractid = $this->input->post('contractid');

				if ($contractid != '') {

					$staff_contract = $this->hr_profile_model->get_contract($contractid);
					if ($staff_contract->contract_code == $this->input->post('contract_code')) {
						echo json_encode(true);
						die();
					}
				}
				$this->db->where('contract_code', $this->input->post('contract_code'));
				$total_rows = $this->db->count_all_results(db_prefix() . 'hr_staff_contract');
				if ($total_rows > 0) {
					echo json_encode(false);
				} else {
					echo json_encode(true);
				}
				die();
			}
		}
	}

	/**
	 * get hrm contract data ajax
	 * @param  [type] $id
	 * @return [type]
	 */
	public function get_hrm_contract_data_ajax($id) {
		$contract = $this->hr_profile_model->get_contract($id);
		$contract_detail = $this->hr_profile_model->get_contract_detail($id);
		if (!$contract) {
			blank_page('Contract Not Found', 'danger');
		}

		$data['contracts'] = $contract;
		if ($contract) {
			$data['staff_delegate_role'] = $this->hr_profile_model->get_staff_role($contract->staff_delegate);
			$title = $this->hr_profile_model->get_contracttype_by_id($contract->name_contract);
			if ($title) {
				$data['title'] = $title[0]['name_contracttype'];
			} else {
				$data['title'] = '';
			}

			//check update content from contract template (in case old data)
			if (strlen($contract->content) == 0) {

				$this->hr_profile_model->update_hr_staff_contract_content($id, $contract->staff);
			}

		}

		$data['contract_details'] = $contract_detail;
		$data['positions'] = $this->hr_profile_model->get_job_position();
		$data['workplace'] = $this->hr_profile_model->get_workplace();
		$data['contract_type'] = $this->hr_profile_model->get_contracttype();
		$data['staff'] = $this->staff_model->get();
		$data['allowance_type'] = $this->hr_profile_model->get_allowance_type();
		$data['salary_form'] = $this->hr_profile_model->get_salary_form();
		$data['contract_attachment'] = $this->hr_profile_model->get_hrm_attachments_file($id, 'hr_contract');
        $data['notes'] = $this->hr_profile_model->get_all_note($id);
        $data['comments'] = $this->hr_profile_model->get_all_comment($id);
        $data['attachments'] = $this->hr_profile_model->get_hrm_attachments_file($id, 'hr_contract');
        $data['contract_renewal_history'] = $this->hr_profile_model->get_all_renew($id);


        $data['contract_merge_fields'] = $this->app_merge_fields->get_flat('hr_contract', ['other'], '{email_signature}');

		$this->load->view('hr_profile/contracts/contract_preview_template', $data);
	}

	/**
	 * get staff role
	 * @return [type]
	 */
	public function get_staff_role() {
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {

				$id = $this->input->post('id');
				$name_object = $this->db->query('select r.name from ' . db_prefix() . 'staff as s join ' . db_prefix() . 'roles as r on s.role = r.roleid where s.staffid = ' . $id)->row();
			}
		}
		if ($name_object) {
			echo json_encode([
				'name' => $name_object->name,
			]);
		}

	}

	/**
	 * get contract type
	 * @param  string $id
	 * @return [type]
	 */
	public function get_contract_type($id = '') {
		$contract_type = $this->hr_profile_model->get_contracttype($id);

		echo json_encode([
			'contract_type' => $contract_type,
		]);
		die;

	}

	/**
	 * inventory setting
	 * @return [type]
	 */
	public function prefix_number() {
		$data = $this->input->post();

		if ($data) {

			$success = $this->hr_profile_model->update_prefix_number($data);

			if ($success == true) {

				$message = _l('hr_updated_successfully');
				set_alert('success', $message);
			}

			redirect(admin_url('hr_profile/setting?group=prefix_number'));

		}
	}

	/**
	 * get code
	 * @param  String $rel_type
	 * @return String
	 */
	public function get_code($rel_type) {
		//get data
		$code = $this->hr_profile_model->create_code($rel_type);

		echo json_encode([
			'code' => $code,
		]);
		die;

	}

	/**
	 * import job position
	 * @return [type]
	 */
	public function import_job_position() {
		$data['departments'] = $this->departments_model->get();
		$data['job_positions'] = $this->hr_profile_model->get_job_position();

		$data_staff = $this->hr_profile_model->get_staff(get_staff_user_id());

		/*get language active*/
		if ($data_staff) {
			if ($data_staff->default_language != '') {
				$data['active_language'] = $data_staff->default_language;

			} else {

				$data['active_language'] = get_option('active_language');
			}

		} else {
			$data['active_language'] = get_option('active_language');
		}

		$this->load->view('hr_profile/job_position_manage/position_manage/import_position', $data);
	}

	/**
	 * dependent person
	 * @param  string $id
	 * @return [type]
	 */
	public function dependent_person($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if ($this->input->post('id') == null) {
				$manage = $this->input->post('manage');
				unset($data['manage']);

				$idd = $this->hr_profile_model->add_dependent_person($data);
				if ($idd) {
					$success = true;
					$message = _l('added_successfully', _l('hr_dependent_persons'));
					set_alert('success', $message);
				} else {
					$message = _l('added_failed', _l('hr_dependent_persons'));
					set_alert('warning', $message);
				}

				if ($manage) {
					redirect(admin_url('hr_profile/dependent_persons'));
				} else {
					redirect(admin_url('hr_profile/member/' . get_staff_user_id() .'/dependent_person'));
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
				} else {
					$message = _l('updated_failed', _l('hr_dependent_persons'));
					set_alert('warning', $message);
				}

				if ($manage) {
					redirect(admin_url('hr_profile/dependent_persons'));
				} else {
					redirect(admin_url('hr_profile/member/' . get_staff_user_id() . '/dependent_person'));
				}
			}
		}
	}

	/**
	 * delete dependent person
	 * @param  [type] $id
	 * @return [type]
	 */
	public function delete_dependent_person($id) {
		if (!$id) {
			redirect(admin_url('hr_profile/member' . get_staff_user_id()));
		}
		$response = $this->hr_profile_model->delete_dependent_person($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('hr_is_referenced', _l('hr_dependent_persons')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('hr_dependent_persons')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('hr_dependent_persons')));
		}
		redirect(admin_url('hr_profile/member/' . get_staff_user_id() . '/dependent_person'));
	}

	/**
	 * approval dependents
	 * @return [type]
	 */
	public function dependent_persons() {

		if (!is_admin() && !has_permission('hrm_dependent_person', '', 'view') && !has_permission('hrm_dependent_person', '', 'view_own')) {
			access_denied('You_do_not_have_permission_to_approve');
		}

		$data['approval'] = $this->hr_profile_model->get_dependent_person();
		$data['staff'] = $this->staff_model->get();

		$this->load->view('hr_profile/dependent_person/manage_dependent_person', $data);
	}

	/**
	 * approval status
	 * @return [type]
	 */
	public function approval_status() {
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {
				$data = $this->input->post();

				$success = $this->hr_profile_model->update_approval_status($data);
				if ($success) {
					$message = _l('hr_updated_successfully');
					echo json_encode([
						'success' => true,
						'message' => $message,
					]);
				} else {
					$message = _l('hr_updated_failed');
					echo json_encode([
						'success' => false,
						'message' => $message,
					]);
				}
			}
		}
	}

	/**
	 * table dependent person
	 * @return [type]
	 */
	public function table_dependent_person() {
		$this->app->get_table_data(module_views_path('hr_profile', 'dependent_person/table_dependent_person'));
	}

	/**
	 * import xlsx dependent person
	 * @return [type]
	 */
	public function import_xlsx_dependent_person() {
		if (!is_admin() && !has_permission('hrm_dependent_person', '', 'create')) {
			access_denied('you_do_not_have_permission_create_dependent_person');
		}

		$data_staff = $this->hr_profile_model->get_staff(get_staff_user_id());

		/*get language active*/
		if ($data_staff) {
			if ($data_staff->default_language != '') {
				$data['active_language'] = $data_staff->default_language;

			} else {

				$data['active_language'] = get_option('active_language');
			}

		} else {
			$data['active_language'] = get_option('active_language');
		}

		$this->load->view('hr_profile/dependent_person/import_dependent_person', $data);
	}

	/**
	 * import file xlsx dependent person
	 * @return [type]
	 */
	public function import_file_xlsx_dependent_person() {
		if (!is_admin() && !has_permission('hrm_dependent_person', '', 'create')) {
			access_denied(_l('you_do_not_have_permission_create_dependent_person'));
		}

		$total_row_false = 0;
		$total_rows = 0;
		$dataerror = 0;
		$total_row_success = 0;
		if ($this->input->post()) {

			if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {

				$this->delete_error_file_day_before();

				// Get the temp file path
				$tmpFilePath = $_FILES['file_csv']['tmp_name'];
				// Make sure we have a filepath
				if (!empty($tmpFilePath) && $tmpFilePath != '') {
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
						$import_result = true;
						$rows = [];

						$objReader = new PHPExcel_Reader_Excel2007();
						$objReader->setReadDataOnly(true);
						$objPHPExcel = $objReader->load($newFilePath);
						$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
						$sheet = $objPHPExcel->getActiveSheet();

						$dataError = new PHPExcel();
						$dataError->setActiveSheetIndex(0);

						$dataError->getActiveSheet()->setTitle(_l('hr_error_data'));
						$dataError->getActiveSheet()->getColumnDimension('A')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('B')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('D')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('E')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('F')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('G')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('H')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('I')->setWidth(20);
						$dataError->getActiveSheet()->getColumnDimension('J')->setWidth(20);

						$dataError->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
						$dataError->getActiveSheet()->setCellValue('A1', _l('hr_hr_code'));
						$dataError->getActiveSheet()->setCellValue('B1', _l('hr_dependent_name'));
						$dataError->getActiveSheet()->setCellValue('C1', _l('relationship'));
						$dataError->getActiveSheet()->setCellValue('D1', _l('birth_date'));
						$dataError->getActiveSheet()->setCellValue('E1', _l('identification'));
						$dataError->getActiveSheet()->setCellValue('F1', _l('reason_'));
						$dataError->getActiveSheet()->setCellValue('G1', _l('hr_start_month'));
						$dataError->getActiveSheet()->setCellValue('H1', _l('hr_end_month'));
						$dataError->getActiveSheet()->setCellValue('I1', _l('status'));
						$dataError->getActiveSheet()->setCellValue('J1', _l('hr_error_data_description'));

						$styleArray = array(
							'font' => array(
								'bold' => true,
								'color' => array('rgb' => 'ff0000'),

							));

						//start write on line 2
						$numRow = 2;
						$total_rows = 0;
						$arr_insert = [];
						//get data for compare

						foreach ($rowIterator as $row) {
							$rowIndex = $row->getRowIndex();
							if ($rowIndex > 1) {
								$total_rows++;

								$rd = array();
								$flag = 0;
								$flag2 = 0;
								$flag_mail = 0;
								$string_error = '';

								$value_cell_hrcode = $sheet->getCell('A' . $rowIndex)->getValue();
								$value_cell_dependent_name = $sheet->getCell('B' . $rowIndex)->getValue();
								$value_cell_bir_of_day_dependent = $sheet->getCell('D' . $rowIndex)->getValue();
								$value_cell_dependent_identification = $sheet->getCell('E' . $rowIndex)->getValue();
								$value_cell_start_time = $sheet->getCell('G' . $rowIndex)->getValue();
								$value_cell_end_time = $sheet->getCell('H' . $rowIndex)->getValue();
								$value_cell_status = $sheet->getCell('I' . $rowIndex)->getValue();

								$pattern = '#^[a-z][a-z0-9\._]{2,31}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$#';
								$reg_day = '#^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$#';

								/*check null*/
								if (is_null($value_cell_hrcode) == true) {
									$string_error .= _l('hr_hr_code') . _l('not_yet_entered');
									$flag = 1;
								}

								if (is_null($value_cell_dependent_name) == true) {
									$string_error .= _l('hr_dependent_name') . _l('not_yet_entered');
									$flag = 1;
								}

								//check hr_code exist
								if (is_null($value_cell_hrcode) != true) {
									$this->db->where('staff_identifi', $value_cell_hrcode);
									$hrcode = $this->db->count_all_results('tblstaff');
									if ($hrcode == 0) {
										$string_error .= _l('hr_hr_code') . _l('does_not_exist');
										$flag2 = 1;
									}

								}

								//check bir of day dependent person input
								if (is_null($value_cell_bir_of_day_dependent) != true) {
									if (preg_match($reg_day, $value_cell_bir_of_day_dependent, $match) != 1) {
										$string_error .= _l('days_for_identity') . _l('_check_invalid');
										$flag = 1;
									}

								}

								//check start_time
								if (is_null($value_cell_start_time) != true) {
									if (preg_match($reg_day, $value_cell_start_time, $match) != 1) {
										$string_error .= _l('hr_start_month') . _l('_check_invalid');
										$flag = 1;
									}

								}

								//check end_time
								if (is_null($value_cell_end_time) != true) {
									if (preg_match($reg_day, $value_cell_end_time, $match) != 1) {
										$string_error .= _l('hr_end_month') . _l('_check_invalid');
										$flag = 1;
									}

								}

								if (($flag == 1) || ($flag2 == 1)) {
									$dataError->getActiveSheet()->setCellValue('A' . $numRow, $sheet->getCell('A' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('B' . $numRow, $sheet->getCell('B' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('C' . $numRow, $sheet->getCell('C' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('D' . $numRow, $sheet->getCell('D' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('E' . $numRow, $sheet->getCell('E' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('F' . $numRow, $sheet->getCell('F' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('G' . $numRow, $sheet->getCell('G' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('H' . $numRow, $sheet->getCell('H' . $rowIndex)->getValue());
									$dataError->getActiveSheet()->setCellValue('I' . $numRow, $sheet->getCell('I' . $rowIndex)->getValue());

									$dataError->getActiveSheet()->setCellValue('J' . $numRow, $string_error)->getStyle('J' . $numRow)->applyFromArray($styleArray);

									$numRow++;
									$total_row_false++;
								}

								if (($flag == 0) && ($flag2 == 0)) {

									if (is_numeric($value_cell_status) && ($value_cell_status == '2')) {
										/*reject*/
										$rd['status'] = 2;
									} else {
										/*approval*/
										$rd['status'] = 1;
									}

									/*staff id is HR_code, input is HR_CODE, insert => staffid*/
									$rd['staffid'] = $sheet->getCell('A' . $rowIndex)->getValue();
									$rd['dependent_name'] = $sheet->getCell('B' . $rowIndex)->getValue();
									$rd['relationship'] = $sheet->getCell('C' . $rowIndex)->getValue();
									$rd['dependent_bir'] = date('Y-m-d', strtotime(str_replace('/', '-', $sheet->getCell('D' . $rowIndex)->getValue())));
									$rd['dependent_iden'] = $sheet->getCell('E' . $rowIndex)->getValue() != null ? $sheet->getCell('E' . $rowIndex)->getValue() : '';
									$rd['reason'] = $sheet->getCell('F' . $rowIndex)->getValue();
									$rd['start_month'] = date('Y-m-d', strtotime(str_replace('/', '-', $sheet->getCell('G' . $rowIndex)->getValue())));
									$rd['end_month'] = date('Y-m-d', strtotime(str_replace('/', '-', $sheet->getCell('H' . $rowIndex)->getValue())));

									array_push($arr_insert, $rd);
								}

							}

						}
						$total_rows = $total_rows;
						$total_row_success = count($arr_insert);
						$dataerror = $dataError;
						$message = 'Not enought rows for importing';

						if ($total_row_false != 0) {

							$objWriter = new PHPExcel_Writer_Excel2007($dataError);
							$filename = 'Import_dependent_person_error_' . get_staff_user_id() . '_' . strtotime(date('Y-m-d H:i:s')) . '.xlsx';
							$objWriter->save(str_replace($filename, HR_PROFILE_ERROR . $filename, $filename));

						} else {
							$this->db->insert_batch(db_prefix() . 'hr_dependent_person', $arr_insert);
						}
						$import_result = true;
						@delete_dir($tmpDir);

					}
				} else {
					set_alert('warning', _l('import_upload_failed'));
				}
			}

		}
		echo json_encode([
			'message' => $message,
			'total_row_success' => $total_row_success,
			'total_row_false' => $total_row_false,
			'total_rows' => $total_rows,
			'site_url' => site_url(),
			'staff_id' => get_staff_user_id(),
		]);

	}

	/**
	 * admin delete dependent person
	 * @param  [type] $id
	 * @return [type]
	 */
	public function admin_delete_dependent_person($id) {
		if (!$id) {
			redirect(admin_url('hr_profile/member' . get_staff_user_id()));
		}
		$response = $this->hr_profile_model->delete_dependent_person($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('hr_is_referenced', _l('hr_dependent_persons')));
		} elseif ($response == true) {
			set_alert('success', _l('hr_deleted'));
		} else {
			set_alert('warning', _l('problem_deleting', _l('hr_dependent_persons')));
		}
		redirect(admin_url('hr_profile/dependent_persons'));
	}

	/**
	 * delete_error file day before
	 * @return [type]
	 */
	public function delete_error_file_day_before($before_day = '', $folder_name = '') {
		if ($before_day != '') {
			$day = $before_day;
		} else {
			$day = '7';
		}

		if ($folder_name != '') {
			$folder = $folder_name;
		} else {
			$folder = HR_PROFILE_ERROR;
		}

		//Delete old file before 7 day
		$date = date_create(date('Y-m-d H:i:s'));
		date_sub($date, date_interval_create_from_date_string($day . " days"));
		$before_7_day = strtotime(date_format($date, "Y-m-d H:i:s"));

		foreach (glob($folder . '*') as $file) {

			$file_arr = explode("/", $file);
			$filename = array_pop($file_arr);

			if (file_exists($file)) {
				//don't delete index.html file
				if ($filename != 'index.html') {
					$file_name_arr = explode("_", $filename);
					$date_create_file = array_pop($file_name_arr);
					$date_create_file = str_replace('.xlsx', '', $date_create_file);

					if ((float) $date_create_file <= (float) $before_7_day) {
						unlink($folder . $filename);
					}
				}
			}
		}
		return true;
	}

	/**
	 * dependent person modal
	 * @return [type]
	 */
	public function dependent_person_modal() {
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
	 * resignation procedures
	 * @return [type]
	 */
	public function resignation_procedures() {
		$this->app_scripts->add('circle-progress-js', 'assets/plugins/jquery-circle-progress/circle-progress.min.js');
		if (!has_permission('hrm_procedures_for_quitting_work', '', 'view') && !has_permission('hrm_procedures_for_quitting_work', '', 'view_own') && !is_admin()) {
			access_denied('hrm_procedures_for_quitting_work');
		}

		$data['staffs'] = $this->staff_model->get('', ['active' => 1]);
		$data['detail'] = $this->input->get('detail');
		$this->load->view('resignation_procedures/manage_resignation_procedures', $data);
	}

	/**
	 * add staff quitting work
	 */
	public function add_resignation_procedure() {
		if (!has_permission('hrm_procedures_for_quitting_work', '', 'edit') && !has_permission('hrm_procedures_for_quitting_work', '', 'add') && !is_admin()) {
			access_denied('hrm_procedures_for_quitting_work');
		}

		$data = $this->input->post();
		$response = $this->hr_profile_model->add_resignation_procedure($data);
		if ($response == true) {
			set_alert('success', _l('added_successfully', _l('staff_member')));
		} else if ($response == false) {
			set_alert('warning', _l('This_person_has_been_on_the_list_of_quit_work'));
		}
		redirect(admin_url('hr_profile/resignation_procedures'));
	}

	/**
	 * delete resignation procedure
	 * @param  [type] $id
	 * @return [type]
	 */
	public function delete_resignation_procedure($id) {

		if (!has_permission('hrm_procedures_for_quitting_work', '', 'edit') && !is_admin()) {
			access_denied('hrm_procedures_for_quitting_work');
		}

		$success = $this->hr_profile_model->delete_procedures_for_quitting_work($id);
		if ($success) {
			set_alert('success', _l('deleted', _l('hr_procedures_for_quitting_work')));
		}

		redirect(admin_url('hr_profile/resignation_procedures'));
	}

	/**
	 * table resignation procedures
	 * @return [type]
	 */
	public function table_resignation_procedures() {
		$this->app->get_table_data(module_views_path('hr_profile', 'resignation_procedures/table_resignation_procedures'));
	}

	/**
	 * get staff info of resignation procedures
	 * @param  [type] $staff_id
	 * @return [type]
	 */
	public function get_staff_info_of_resignation_procedures($staff_id) {
		$staff_email = '';
		$staff_department_name = '';
		$staff_job_position = '';
		$status = true;
		$message = '';

		//check resignation procedures exist
		$resignation_procedure = $this->hr_profile_model->get_resignation_procedure_by_staff($staff_id);

		if (!$resignation_procedure) {
			$staff = $this->staff_model->get($staff_id);
			if ($staff) {
				$staff_email = $staff->email;
				$staff_job_position = hr_profile_job_name_by_id($staff->job_position);
				$departments = $this->departments_model->get_staff_departments($staff_id);

				if (count($departments) > 0) {
					foreach ($departments as $value) {
						if (strlen($staff_department_name) > 0) {
							$staff_department_name .= ',' . $value['name'];
						} else {
							$staff_department_name .= $value['name'];
						}
					}
				}

			}
		} else {
			$status = false;
			$message = _l('hr_resignation_procedure_already_exists');
		}

		echo json_encode([
			'staff_email' => $staff_email,
			'staff_department_name' => $staff_department_name,
			'staff_job_position' => $staff_job_position,
			'status' => $status,
			'message' => $message,
		]);
		die;

	}

	/**
	 * delete procedures for quitting work
	 * @param  [type] $staffid
	 * @return [type]
	 */
	public function delete_procedures_for_quitting_work($staffid) {
		if (!has_permission('hrm_procedures_for_quitting_work', '', 'edit') && !is_admin()) {
			access_denied('hrm_procedures_for_quitting_work');
		}

		$success = $this->hr_profile_model->delete_procedures_for_quitting_work($staffid);
		if ($success) {
			set_alert('success', _l('deleted', _l('hr_procedures_for_quitting_work')));
		}

		redirect(admin_url('hr_profile/resignation_procedures'));
	}

	/**
	 * set data detail staff checklist quit work
	 * @param [type] $staffid
	 */
	public function set_data_detail_staff_checklist_quit_work($staffid) {
		if ($this->input->is_ajax_request()) {
			$results = $this->hr_profile_model->get_data_procedure_retire_of_staff($staffid);

			$html = '<input type="hidden" name="staffid" value="' . $staffid . '">';
			$rel_id = '';
			foreach ($results as $key => $value) {
				if ($value['people_handle_id'] == 0) {
					$value['people_handle_id'] = get_staff_user_id();
				}
				if ($rel_id != $value['rel_id']) {
					$rel_id = $value['rel_id'];
					$html .= '<br><h5 class="no-margin font-bold text-danger"><i class="fa fa-plus "></i>  ' . $value['rel_name'] . ' (' . get_staff_full_name($value['people_handle_id']) . ')<span ></span></h5><br>';

					$html .= ' <a href="#" class="list-group-item list-group-item-action">
					<div class="row">
					<div class="col-md-10 resignation-procedures-modal"><label for="' . $value['id'] . '">' . $value['option_name'] . ' </label></div>
					<div class="col-md-2 text-right">
					<div class="row">
					<div class="col-md-6 pt-1 pr-2">
					<div class="checkbox float-right">';
					if ($value['status'] == 1) {
						$html .= '<input type="checkbox" class="option_name" name="option_name[]" id="' . $value['id'] . '" data-id="' . $value['id'] . '" value="' . $value['id'] . '" checked disabled>
						<label></label>';
					} else {
						$html .= '<input type="checkbox" class="option_name" name="option_name[]" id="' . $value['id'] . '" data-id="' . $value['id'] . '" value="' . $value['id'] . '">
						<label></label>';
					}
					$html .= '</div>
					</div>
					</div>
					</div>
					</div>
					</a>';
				} else {
					$html .= ' <a href="#" class="list-group-item list-group-item-action" >
					<div class="row">
					<div class="col-md-10 resignation-procedures-modal"><label for="' . $value['id'] . '">' . $value['option_name'] . ' </label></div>
					<div class="col-md-2 text-right">
					<div class="row">
					<div class="col-md-6 pt-1 pr-2">
					<div class="checkbox float-right">';
					if ($value['status'] == 1) {
						$html .= '<input type="checkbox" class="option_name" name="option_name[]" id="' . $value['id'] . '" data-id="' . $value['id'] . '" value="' . $value['id'] . '" checked disabled>
						<label></label>';
					} else {
						$html .= '<input type="checkbox" class="option_name" name="option_name[]" id="' . $value['id'] . '" data-id="' . $value['id'] . '" value="' . $value['id'] . '">
						<label></label>';
					}
					$html .= '</div>
					</div>
					</div>
					</div>
					</div>

					</a>';
				}
			}
		}
		echo json_encode([
			'result' => $html,
			'staff_name' => get_staff_full_name($staffid),
		]);

	}

	/**
	 * update status quit work
	 * @param  [type] $staffid
	 * @return [type]
	 */
	public function update_status_quit_work() {
		$data = $this->input->post();
		$staffid = $data['staffid'];
		$id = $data['id'];
		$result = $this->hr_profile_model->update_status_quit_work($staffid, $id);

		if ($result == 0) {
			$message = _l('hr_updated_successfully');
		} else {
			$message = _l('hr_update_failed');
		}

		echo json_encode([
			'status' => $result,
			'message' => $message,
		]);

	}

	/**
	 * update status option name
	 * @return [type]
	 */
	public function update_status_option_name() {
		$data = $this->input->post();
		if ($data['finish'] == 0) {
			foreach ($data['option_name'] as $id_option) {
				$result = $this->hr_profile_model->update_status_procedure_retire_of_staff(['id' => $id_option]);
			}
		} else {
			$result = $this->hr_profile_model->update_status_procedure_retire_of_staff(['staffid' => $data['staffid']]);
		}

		if ($result) {
			set_alert('success', _l('hr_updated_successfully'));
		} else if ($response == false) {
			set_alert('warning', _l('hr_update_failed'));
		}
		redirect(admin_url('hr_profile/resignation_procedures'));
	}

	/**
	 * preview q a file
	 * @param  [type] $id
	 * @param  [type] $rel_id
	 * @return [type]
	 */
	public function preview_q_a_file($id, $rel_id) {
		$data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
		$data['current_user_is_admin'] = is_admin();
		$data['file'] = $this->hr_profile_model->get_file($id, $rel_id);
		if (!$data['file']) {
			header('HTTP/1.0 404 Not Found');
			die;
		}
		$this->load->view('hr_profile/knowledge_base_q_a/preview_q_a_file', $data);
	}

	/**
	 * delete hr profile q a attachment file
	 * @param  [type] $attachment_id
	 * @return [type]
	 */
	public function delete_hr_profile_q_a_attachment_file($attachment_id) {
		if (!has_permission('hr_manage_q_a', '', 'delete')) {
			access_denied('hr_manage_q_a');
		}

		$file = $this->misc_model->get_file($attachment_id);
		echo json_encode([
			'success' => $this->hr_profile_model->delete_hr_q_a_attachment_file($attachment_id),
		]);
	}

	/**
	 * get salary allowance value
	 * @param  [type] $rel_type
	 * @return [type]
	 */
	public function get_salary_allowance_value($rel_type) {

		if (preg_match('/^st_/', $rel_type)) {
			$rel_value = str_replace('st_', '', $rel_type);
			$salary_type = $this->hr_profile_model->get_salary_form($rel_value);

			$type = 'salary';
			if ($salary_type) {
				$value = $salary_type->salary_val;
			} else {
				$value = 0;
			}

		} elseif (preg_match('/^al_/', $rel_type)) {
			$rel_value = str_replace('al_', '', $rel_type);
			$allowance_type = $this->hr_profile_model->get_allowance_type($rel_value);

			$type = 'allowance';
			if ($allowance_type) {
				$value = $allowance_type->allowance_val;
			} else {
				$value = 0;
			}

		} else {

		}

		$effective_date = date('Y-m-d');

		echo json_encode([
			'type' => $type,
			'rel_value' => (float) $value,
			'effective_date' => $effective_date,
		]);
		die;
	}

	/**
	 * hrm file contract
	 * @param  [type] $id
	 * @param  [type] $rel_id
	 * @return [type]
	 */
	public function hrm_file_contract($id, $rel_id) {
		$data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
		$data['current_user_is_admin'] = is_admin();
		$data['file'] = $this->hr_profile_model->get_file($id, $rel_id);
		if (!$data['file']) {
			header('HTTP/1.0 404 Not Found');
			die;
		}
		$this->load->view('hr_profile/contracts/preview_contract_file', $data);
	}

	/**
	 * delete hrm contract attachment file
	 * @param  [type] $attachment_id
	 * @return [type]
	 */
	public function delete_hrm_contract_attachment_file($attachment_id) {
		if (!has_permission('hrm_contract', '', 'delete') && !is_admin()) {
			access_denied('hrm');
		}

		$file = $this->misc_model->get_file($attachment_id);
		echo json_encode([
			'success' => $this->hr_profile_model->delete_hr_contract_attachment_file($attachment_id),
		]);
	}

    public function delete_contract_attachment_file($attachment_id)
    {
        if (!has_permission('hrm_contract', '', 'delete') && !is_admin()) {
            access_denied('hrm');
        }

        echo json_encode([
            'success' => $this->hr_profile_model->delete_contract_attachment_file($attachment_id),
        ]);
    }

	/**
	 * member modal
	 * @return [type]
	 */
	public function member_modal() {
		if (!$this->input->is_ajax_request()) {
			show_404();
		}
		$this->load->model('staff_model');

		if ($this->input->post('slug') === 'create') {

			$this->load->view('hr_record/new_member', $data);

		} else if ($this->input->post('slug') === 'update') {
			$staff_id = $this->input->post('staff_id');
			$role_id = $this->input->post('role_id');

			$data = ['funcData' => ['staff_id' => isset($staff_id) ? $staff_id : null]];

			if (isset($staff_id)) {
				$data['member'] = $this->staff_model->get($staff_id);
			}

			$data['roles_value'] = $this->roles_model->get();
			$data['staffs'] = hr_profile_get_staff_id_dont_permissions();
			$add_new = $this->input->post('add_new');

			if ($add_new == ' hide') {
				$data['add_new'] = ' hide';
				$data['display_staff'] = '';
			} else {
				$data['add_new'] = '';
				$data['display_staff'] = ' hide';
			}
            $this->load->model('currencies_model');
            $this->load->model('Sub_department_model');

			$data['list_staff'] = $this->staff_model->get();
			$data['base_currency'] = $this->currencies_model->get_base_currency();
			$data['departments'] = $this->departments_model->get();
			$data['staff_departments'] = $this->departments_model->get_staff_departments($staff_id);
			$department_id = $data['staff_departments'][0]['departmentid'];
			$data['positions'] = $this->hr_profile_model->get_job_position();
			$data['workplace'] = $this->hr_profile_model->get_workplace();
			$data['staff_cover_image'] = $this->hr_profile_model->get_hr_profile_file($staff_id, 'staff_profile_images');
			$data['manage_staff'] = $this->input->post('manage_staff');
            $data['sub_departments'] = $this->Sub_department_model->get_sub_departments($department_id);
			$this->load->view('hr_record/update_member', $data);
		}
	}

	/**
	 * new member
	 * @return [type]
	 */
	public function new_member() {

		if (!has_permission('hrm_hr_records', '', 'create')) {
			access_denied('staff');
		}

		$data['hr_profile_member_add'] = true;
		$title = _l('add_new', _l('staff_member_lowercase'));

		$this->load->model('currencies_model');
		$data['positions'] = $this->hr_profile_model->get_job_position();
		$data['workplace'] = $this->hr_profile_model->get_workplace();
		$data['base_currency'] = $this->currencies_model->get_base_currency();

		$data['roles_value'] = $this->roles_model->get();
		$data['departments'] = $this->departments_model->get();
		$data['title'] = $title;
		$data['contract_type'] = $this->hr_profile_model->get_contracttype();
		$data['staff'] = $this->staff_model->get();
		$data['list_staff'] = $this->staff_model->get();
		$data['funcData'] = ['staff_id' => isset($staff_id) ? $staff_id : null];
		$data['staff_code'] = $this->hr_profile_model->create_code('staff_code');

		$this->load->view('hr_record/new_member', $data);
	}

	/**
	 * add edit member
	 * @param string $id
	 */
	public function add_edit_member($id = '') {
		if (!has_permission('hrm_hr_records', '', 'view') && !has_permission('hrm_hr_records', '', 'view_own') && get_staff_user_id() != $id) {
			access_denied('staff');
		}
		hooks()->do_action('staff_member_edit_view_profile', $id);

		$this->load->model('departments_model');
		if ($this->input->post()) {
			$data = $this->input->post();
			// Don't do XSS clean here.
			$data['email_signature'] = $this->input->post('email_signature', false);
			$data['email_signature'] = html_entity_decode($data['email_signature']);

			if ($data['email_signature'] == strip_tags($data['email_signature'])) {
				// not contains HTML, add break lines
				$data['email_signature'] = nl2br_save_html($data['email_signature']);
			}

			$data['password'] = $this->input->post('password', false);

			if ($id == '') {
				if (!has_permission('hrm_hr_records', '', 'create')) {
					access_denied('staff');
				}
				$id = $this->hr_profile_model->add_staff($data);

				if ($id) {
					hr_profile_handle_staff_profile_image_upload($id);
					set_alert('success', _l('added_successfully', _l('staff_member')));
					redirect(admin_url('hr_profile/member/' . $id));
				}
			} else {
				if (!has_permission('hrm_hr_records', '', 'edit') && get_staff_user_id() != $id) {
					access_denied('staff');
				}

				$manage_staff = false;
				if (isset($data['manage_staff'])) {
					$manage_staff = true;
					unset($data['manage_staff']);
				}
				hr_profile_handle_staff_profile_image_upload($id);
				$response = $this->hr_profile_model->update_staff($data, $id);
				if (is_array($response)) {
					if (isset($response['cant_remove_main_admin'])) {
						set_alert('warning', _l('staff_cant_remove_main_admin'));
					} elseif (isset($response['cant_remove_yourself_from_admin'])) {
						set_alert('warning', _l('staff_cant_remove_yourself_from_admin'));
					}
				} elseif ($response == true) {
					set_alert('success', _l('updated_successfully', _l('staff_member')));
				}

				if ($manage_staff) {
					redirect(admin_url('hr_profile/staff_infor'));
				} else {
					redirect(admin_url('hr_profile/member/' . $id));
				}
			}
		}

		$title = _l('add_new', _l('staff_member_lowercase'));
		$this->load->model('currencies_model');
		$data['positions'] = $this->hr_profile_model->get_job_position();
		$data['workplace'] = $this->hr_profile_model->get_workplace();
		$data['base_currency'] = $this->currencies_model->get_base_currency();

		$data['roles_value'] = $this->roles_model->get();
		$data['departments'] = $this->departments_model->get();
		$data['title'] = $title;
		$data['contract_type'] = $this->hr_profile_model->get_contracttype();
		$data['staff'] = $this->staff_model->get();
		$data['list_staff'] = $this->staff_model->get();
		$data['funcData'] = ['staff_id' => isset($staff_id) ? $staff_id : null];
		$data['staff_code'] = $this->hr_profile_model->create_code('staff_code');

		$this->load->view('hr_record/new_member', $data);
	}

	/**
	 * change staff status: Change status to staff active or inactive
	 * @param  [type] $id
	 * @param  [type] $status
	 * @return [type]
	 */
	public function change_staff_status($id, $status) {
		if (has_permission('hrm_hr_records', '', 'edit')) {
			if ($this->input->is_ajax_request()) {
				$this->staff_model->change_staff_status($id, $status);
			}
		}
	}

	/**
	 * hr code exists
	 * @return [type]
	 */
	public function hr_code_exists() {
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {
				// First we need to check if the email is the same
				$memberid = $this->input->post('memberid');
				if ($memberid != '') {
					$this->db->where('staffid', $memberid);
					$staff = $this->db->get('tblstaff')->row();
					if ($staff->staff_identifi == $this->input->post('staff_identifi')) {
						echo json_encode(true);
						die();
					}
				}

				$this->db->where('staff_identifi', $this->input->post('staff_identifi'));
				$total_rows = $this->db->count_all_results('tblstaff');
				if ($total_rows > 0) {
					echo json_encode(false);
				} else {
					echo json_encode(true);
				}
				die();
			}
		}
	}

	/**
	 * view contract modal
	 * @return [type]
	 */
	public function view_contract_modal() {
		if (!$this->input->is_ajax_request()) {
			show_404();
		}
		$this->load->model('staff_model');

		if ($this->input->post('slug') === 'view') {
			$contract_id = $this->input->post('contract_id');

			$data['contract'] = $this->hr_profile_model->get_contract($contract_id);
			$data['contract_details'] = $this->hr_profile_model->get_contract_detail($contract_id);

			$this->load->view('hr_record/contract_modal_view', $data);
		}
	}

	/**
	 * reports
	 * @return [type]
	 */
	public function reports() {
		if (!has_permission('hrm_report', '', 'view') && !is_admin()) {
			access_denied('reports');
		}

		$data['mysqlVersion'] = $this->db->query('SELECT VERSION() as version')->row();
		$data['sqlMode'] = $this->db->query('SELECT @@sql_mode as mode')->row();
		$data['position'] = $this->hr_profile_model->get_job_position();
		$data['staff'] = $this->staff_model->get();
		$data['department'] = $this->departments_model->get();
		$data['title'] = _l('hr_reports');

		$this->load->view('reports/manage_reports', $data);
	}

	/**
	 * report by leave statistics
	 * @return [type]
	 */
	public function report_by_leave_statistics() {
		echo json_encode($this->hr_profile_model->report_by_leave_statistics());
	}

	/**
	 * report by working hours
	 * @return [type]
	 */
	public function report_by_working_hours() {
		echo json_encode($this->hr_profile_model->report_by_working_hours());
	}

	/**
	 * report the employee quitting
	 * @return [type]
	 */
	public function report_the_employee_quitting() {
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {

				// $months_report = 'all_time';
				$months_report = $this->input->post('months_filter');
				$position_filter = $this->input->post('position_filter');
				$department_filter = $this->input->post('department_filter');
				$staff_filter = $this->input->post('staff_filter');

				if ($months_report == 'this_month') {
					$from_date = date('Y-m-01') . ' 00:00:00';
					$to_date = date('Y-m-t') . ' 23:59:59';
				}
				if ($months_report == '1') {
					$from_date = date('Y-m-01', strtotime('first day of last month')) . ' 00:00:00';
					$to_date = date('Y-m-t', strtotime('last day of last month')) . ' 23:59:59';
				}
				if ($months_report == 'this_year') {
					$from_date = date('Y-m-d', strtotime(date('Y-01-01'))) . ' 00:00:00';
					$to_date = date('Y-m-d', strtotime(date('Y-12-31'))) . ' 23:59:59';
				}
				if ($months_report == 'last_year') {
					$from_date = date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-01-01'))) . ' 00:00:00';
					$to_date = date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-12-31'))) . ' 23:59:59';
				}

				if ($months_report == '3') {
					$months_report--;
					$from_date = date('Y-m-01', strtotime("-$months_report MONTH")) . ' 00:00:00';
					$to_date = date('Y-m-t') . ' 23:59:59';
				}
				if ($months_report == '6') {
					$months_report--;
					$from_date = date('Y-m-01', strtotime("-$months_report MONTH")) . ' 00:00:00';
					$to_date = date('Y-m-t') . ' 23:59:59';

				}
				if ($months_report == '12') {
					$months_report--;
					$from_date = date('Y-m-01', strtotime("-$months_report MONTH")) . ' 00:00:00';
					$to_date = date('Y-m-t') . ' 23:59:59';

				}
				if ($months_report == 'custom') {
					$from_date = to_sql_date($this->input->post('report_from')) . ' 00:00:00';
					$to_date = to_sql_date($this->input->post('report_to')) . ' 23:59:59';
				}

				$select = [
					'staffid',
					'staff_identifi',
					'firstname',
					'job_position',
					'staffid',
					'staffid',
					'staffid',
				];
				$query = '';

				if (isset($from_date) && isset($to_date)) {
					$query = ' staffid in (SELECT staffid FROM ' . db_prefix() . 'hr_list_staff_quitting_work where dateoff >= \'' . $from_date . '\' and dateoff <= \'' . $to_date . '\' AND ' . db_prefix() . 'hr_list_staff_quitting_work.approval = "approved") and';
				} else {
					$query = ' staffid in (SELECT staffid FROM ' . db_prefix() . 'hr_list_staff_quitting_work where  ' . db_prefix() . 'hr_list_staff_quitting_work.approval = "approved") and';
				}

				if (isset($position_filter)) {
					$position_list = implode(',', $position_filter);
					$query .= ' job_position in (' . $position_list . ') and';
				}
				if (isset($staff_filter)) {
					$staffid_list = implode(',', $staff_filter);
					$query .= ' staffid in (' . $staffid_list . ') and';
				}
				if (isset($department_filter)) {
					$department_list = implode(',', $department_filter);
					$query .= ' staffid in (SELECT staffid FROM ' . db_prefix() . 'staff_departments where departmentid in (' . $department_list . ')) and';
				}

				$total_query = '';
				if (($query) && ($query != '')) {
					$total_query = rtrim($query, ' and');
					$total_query = ' where ' . $total_query;
				}

				$where = [$total_query];

				$aColumns = $select;
				$sIndexColumn = 'staffid';
				$sTable = db_prefix() . 'staff';
				$join = [];

				$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
					'staffid',
					'firstname',
					'lastname',
					'staff_identifi',
					'job_position',
					'datecreated',
					'appointment',
					'email',
				]);

				$output = $result['output'];
				$rResult = $result['rResult'];
				foreach ($rResult as $aRow) {
					$row = [];
					$row[] = $aRow['staffid'];
					$row[] = $aRow['staff_identifi'];
					$row[] = $aRow['firstname'] . ' ' . $aRow['lastname'];

					$position = $this->hr_profile_model->get_job_position($aRow['job_position']);
					$name_position = '';
					if (isset($position) && !is_array($position)) {
						$name_position = $position->position_name;
					}
					$row[] = $name_position;

					$department = $this->hr_profile_model->get_department_by_staffid($aRow['staffid']);
					$name_department = '';
					if (isset($department)) {
						$name_department = $department->name;
					}
					$row[] = $name_department;

					$row[] = date('d/m/Y', strtotime($aRow['datecreated']));
					$row[] = date('d/m/Y', strtotime($aRow['appointment']));

					$data_quiting = $this->hr_profile_model->get_list_quiting_work($aRow['staffid']);
					$date_off = '';
					if (isset($data_quiting)) {
						$date_off = date('d/m/Y', strtotime($data_quiting->dateoff));
					}
					$row[] = $date_off;

					$output['aaData'][] = $row;
				}

				echo json_encode($output);
				die();
			}
		}
	}

	/**
	 * list of employees with salary change
	 * @return [type]
	 */
	public function list_of_employees_with_salary_change() {
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {
				$months_report = $this->input->post('months_filter');
				$position_filter = $this->input->post('position_filter');
				$department_filter = $this->input->post('department_filter');
				$staff_filter = $this->input->post('staff_filter');

				$from_date = date('Y-m-d', strtotime('1997-01-01'));
				$to_date = date('Y-m-d', strtotime(date('Y-m-d')));

				if ($months_report == 'this_month') {

					$from_date = date('Y-m-01');
					$to_date = date('Y-m-t');
				}
				if ($months_report == '1') {
					$from_date = date('Y-m-01', strtotime('first day of last month'));
					$to_date = date('Y-m-t', strtotime('last day of last month'));
				}
				if ($months_report == 'this_year') {
					$from_date = date('Y-m-d', strtotime(date('Y-01-01')));
					$to_date = date('Y-m-d', strtotime(date('Y-12-31')));
				}
				if ($months_report == 'last_year') {
					$from_date = date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-01-01')));
					$to_date = date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-12-31')));
				}

				if ($months_report == '3') {
					$months_report--;
					$from_date = date('Y-m-01', strtotime("-$months_report MONTH"));
					$to_date = date('Y-m-t');

				}
				if ($months_report == '6') {
					$months_report--;
					$from_date = date('Y-m-01', strtotime("-$months_report MONTH"));
					$to_date = date('Y-m-t');

				}
				if ($months_report == '12') {
					$months_report--;
					$from_date = date('Y-m-01', strtotime("-$months_report MONTH"));
					$to_date = date('Y-m-t');

				}
				if ($months_report == 'custom') {
					$from_date = to_sql_date($this->input->post('report_from'));
					$to_date = to_sql_date($this->input->post('report_to'));
				}
				$select = [
					'staffid',
					'firstname',
					'staff_identifi',
					'staffid',
					'staffid',
					'staffid',
					'staffid',
					'staffid',
				];
				$query = '';
				if (isset($position_filter)) {
					$position_list = implode(',', $position_filter);
					$query .= ' job_position in (' . $position_list . ') and';
				}
				if (isset($staff_filter)) {
					$staffid_list = implode(',', $staff_filter);
					$query .= ' staffid in (' . $staffid_list . ') and';
				}
				if (isset($department_filter)) {
					$department_list = implode(',', $department_filter);
					$query .= ' staffid in (SELECT staffid FROM ' . db_prefix() . 'staff_departments where departmentid in (' . $department_list . ')) and';
				}

				$total_query = '';
				if (($query) && ($query != '')) {
					$total_query = rtrim($query, ' and');
					$total_query = ' where ' . $total_query;
				}
				$where = [$total_query];

				$aColumns = $select;
				$sIndexColumn = 'staffid';
				$sTable = db_prefix() . 'staff';
				$join = [];

				$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
					'staffid',
					'firstname',
					'lastname',
					'staff_identifi',
					'job_position',
					'email',
				]);

				$output = $result['output'];
				$rResult = $result['rResult'];
				foreach ($rResult as $aRow) {
					$row = [];
					$row[] = $aRow['staffid'];
					$row[] = $aRow['staff_identifi'];
					$row[] = $aRow['firstname'] . ' ' . $aRow['lastname'];
					$position = $this->hr_profile_model->get_job_position($aRow['job_position']);
					$name_position = '';
					if (isset($position) && !is_array($position)) {
						$name_position = $position->position_name;
					}
					$row[] = $name_position;

					$department = $this->hr_profile_model->get_department_by_staffid($aRow['staffid']);
					$name_department = '';
					if (isset($department)) {
						$name_department = $department->name;
					}
					$row[] = $name_department;

					$has_change = 0;
					$old_salary = 0;
					$new_salary = 0;
					$date_effect = '1970-01-01 00:00:00';
					$list_contract_staff = $this->hr_profile_model->get_list_contract_detail_staff($aRow['staffid']);

					if ($list_contract_staff) {
						$has_change = 1;
						$old_salary = $list_contract_staff['old_salary'];
						$new_salary = $list_contract_staff['new_salary'];
						$date_effect = $list_contract_staff['date_effect'];

					}

					$strtotime_from_date = strtotime($from_date);
					$strtotime_to_date = strtotime($to_date);
					$strtotime_date_effect = strtotime($date_effect);

					if (($strtotime_date_effect >= $strtotime_from_date) && ($strtotime_date_effect <= $strtotime_to_date)) {

						$row[] = _d($date_effect);
						$row[] = app_format_money($old_salary, $this->get_base_currency_name());
						$row[] = app_format_money($new_salary, $this->get_base_currency_name());
						if ($has_change == 1) {
							$output['aaData'][] = $row;
						}
					}

				}
				echo json_encode($output);
				die();
			}
		}
	}

	/**
	 * get get base currency name
	 * @return [type]
	 */
	public function get_base_currency_name() {
		$currency = '';

		$this->load->model('currencies_model');
		$base_currency = $this->currencies_model->get_base_currency();

		if ($base_currency) {
			$currency .= $base_currency->name;
		}
		return $currency;
	}

	/**
	 * get chart senior staff
	 * @return [type]
	 */
	public function get_chart_senior_staff($sort_from, $months_report = '', $report_from = '', $report_to = '') {
		if ($this->input->is_ajax_request()) {

			$months_report = $months_report;
			if ($months_report == '' || !isset($months_report)) {
				$staff_list = $this->staff_model->get();
			}
			if ($months_report == 'this_month') {

				$beginMonth = date('Y-m-01');
				$endMonth = date('Y-m-t');
				$staff_list = $this->hr_profile_model->get_staff_by_month($beginMonth, $endMonth);
			}
			if ($months_report == '1') {
				$beginMonth = date('Y-m-01', strtotime('first day of last month'));
				$endMonth = date('Y-m-t', strtotime('last day of last month'));
				$staff_list = $this->hr_profile_model->get_staff_by_month($beginMonth, $endMonth);
			}
			if ($months_report == 'this_year') {
				$from_year = date('Y-m-d', strtotime(date('Y-01-01')));
				$to_year = date('Y-m-d', strtotime(date('Y-12-31')));
				$staff_list = $this->hr_profile_model->get_staff_by_month($from_year, $to_year);
			}
			if ($months_report == 'last_year') {

				$from_year = date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-01-01')));
				$to_year = date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-12-31')));

				$staff_list = $this->hr_profile_model->get_staff_by_month($from_year, $to_year);

			}

			if ($months_report == '3') {
				$months_report = 3;
				$months_report--;
				$beginMonth = date('Y-m-01', strtotime("-$months_report MONTH"));
				$endMonth = date('Y-m-t');
				$staff_list = $this->hr_profile_model->get_staff_by_month($beginMonth, $endMonth);

			}
			if ($months_report == '6') {
				$months_report = 6;
				$months_report--;
				$beginMonth = date('Y-m-01', strtotime("-$months_report MONTH"));
				$endMonth = date('Y-m-t');
				$staff_list = $this->hr_profile_model->get_staff_by_month($beginMonth, $endMonth);
			}
			if ($months_report == '12') {
				$months_report = 12;
				$months_report--;
				$beginMonth = date('Y-m-01', strtotime("-$months_report MONTH"));
				$endMonth = date('Y-m-t');
				$staff_list = $this->hr_profile_model->get_staff_by_month($beginMonth, $endMonth);
			}
			if ($months_report == 'custom') {
				$from_date = to_sql_date($report_from);
				$to_date = to_sql_date($report_to);
				$staff_list = $this->hr_profile_model->get_staff_by_month($from_date, $to_date);

			}

			$list_count_month = array();
			$m1 = 0;
			$m3 = 0;
			$m6 = 0;
			$m9 = 0;
			$m12 = 0;
			$mp12 = 0;

			$p1 = 0;
			$p3 = 0;
			$p6 = 0;
			$p9 = 0;
			$p12 = 0;
			$pp12 = 0;
			$count_total_staff = count($staff_list);

			$current_date = new DateTime(date('Y-m-d'));

			foreach ($staff_list as $key => $value) {
				if ($value['datecreated'] != '') {

					$datecreated = new DateTime($value['datecreated']);

					$total_month = $datecreated->diff($current_date)->m + ($datecreated->diff($current_date)->y * 12) + $datecreated->diff($current_date)->d / 30;

					if ($total_month <= 1) {
						$m1 += 1;
					}
					if (($total_month > 1) && ($total_month <= 3)) {
						$m3 += 1;
					}
					if (($total_month > 3) && ($total_month <= 6)) {
						$m6 += 1;
					}
					if (($total_month > 6) && ($total_month <= 9)) {
						$m9 += 1;
					}
					if (($total_month > 9) && ($total_month <= 12)) {
						$m12 += 1;
					}
					if ($total_month > 12) {
						$mp12 += 1;
					}
				}
			}

			$list_chart = array($m1, $m3, $m6, $m9, $m12, $mp12);
			if ($count_total_staff > 0) {
				foreach ($list_chart as $key => $value) {
					if ($key == 0) {
						$p1 = round(($value * 100) / $count_total_staff, 2);
					}
					if ($key == 1) {
						$p3 = round(($value * 100) / $count_total_staff, 2);
					}
					if ($key == 2) {
						$p6 = round(($value * 100) / $count_total_staff, 2);
					}
					if ($key == 3) {
						$p9 = round(($value * 100) / $count_total_staff, 2);
					}
					if ($key == 4) {
						$p12 = round(($value * 100) / $count_total_staff, 2);
					}
					if ($key == 5) {
						$pp12 = round(($value * 100) / $count_total_staff, 2);
					}
				}
			}

			$list_ratio = array($p1, $p3, $p6, $p9, $p12, $pp12);

			echo json_encode([
				'data' => $list_chart,
				'data_ratio' => $list_ratio,
			]);
		}
	}

	/**
	 * HR is working
	 */
	public function HR_is_working() {
		if ($this->input->is_ajax_request()) {

			$months_report = $this->input->post('months_filter');

			$from_date = date('Y-m-d', strtotime('1997-01-01'));
			$to_date = date('Y-m-d', strtotime(date('Y-12-31')));

			if ($months_report == 'this_month') {

				$from_date = date('Y-m-01');
				$to_date = date('Y-m-t');
			}
			if ($months_report == '1') {
				$from_date = date('Y-m-01', strtotime('first day of last month'));
				$to_date = date('Y-m-t', strtotime('last day of last month'));

			}
			if ($months_report == 'this_year') {
				$from_date = date('Y-m-d', strtotime(date('Y-01-01')));
				$to_date = date('Y-m-d', strtotime(date('Y-12-31')));
			}
			if ($months_report == 'last_year') {
				$from_date = date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-01-01')));
				$to_date = date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-12-31')));
			}

			if ($months_report == '3') {
				$months_report--;
				$from_date = date('Y-m-01', strtotime("-$months_report MONTH"));
				$to_date = date('Y-m-t');

			}
			if ($months_report == '6') {
				$months_report--;
				$from_date = date('Y-m-01', strtotime("-$months_report MONTH"));
				$to_date = date('Y-m-t');

			}
			if ($months_report == '12') {
				$months_report--;
				$from_date = date('Y-m-01', strtotime("-$months_report MONTH"));
				$to_date = date('Y-m-t');

			}
			if ($months_report == 'custom') {
				$from_date = to_sql_date($this->input->post('report_from'));
				$to_date = to_sql_date($this->input->post('report_to'));
			}

			// change to report_by_staffs_month($from_date, $to_date));
			echo json_encode($this->hr_profile_model->report_by_staffs());

		}
	}

	/**
	 * qualification department
	 * @return [type]
	 */
	public function qualification_department() {
		if ($this->input->is_ajax_request()) {
			if ($this->input->post()) {
				$months_report = $this->input->post('months_filter');
				$department_filter = $this->input->post('department_filter');

				$from_date = date('Y-m-d', strtotime('1997-01-01'));
				$to_date = date('Y-m-d', strtotime(date('Y-12-31')));
				if ($months_report == 'this_month') {

					$from_date = date('Y-m-01');
					$to_date = date('Y-m-t');
				}
				if ($months_report == '1') {
					$from_date = date('Y-m-01', strtotime('first day of last month'));
					$to_date = date('Y-m-t', strtotime('last day of last month'));

				}
				if ($months_report == 'this_year') {
					$from_date = date('Y-m-d', strtotime(date('Y-01-01')));
					$to_date = date('Y-m-d', strtotime(date('Y-12-31')));
				}
				if ($months_report == 'last_year') {
					$from_date = date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-01-01')));
					$to_date = date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-12-31')));
				}

				if ($months_report == '3') {
					$months_report--;
					$from_date = date('Y-m-01', strtotime("-$months_report MONTH"));
					$to_date = date('Y-m-t');

				}
				if ($months_report == '6') {
					$months_report--;
					$from_date = date('Y-m-01', strtotime("-$months_report MONTH"));
					$to_date = date('Y-m-t');

				}
				if ($months_report == '12') {
					$months_report--;
					$from_date = date('Y-m-01', strtotime("-$months_report MONTH"));
					$to_date = date('Y-m-t');

				}
				if ($months_report == 'custom') {
					$from_date = to_sql_date($this->input->post('report_from'));
					$to_date = to_sql_date($this->input->post('report_to'));
				}

				$id_department = '';
				if (isset($department_filter)) {
					$id_department = implode(',', $department_filter);
				}
				$circle_mode = false;
				$list_diploma = array(
					"primary_level",
					"intermediate_level",
					"college_level",
					"masters",
					"doctor",
					"bachelor",
					"engineer",
					"university",
					"intermediate_vocational",
					"college_vocational",
					"in-service",
					"high_school",
					"intermediate_level_pro",
				);
				$list_result = array();
				$list_data_department = [];

				$departement_by_literacy = $this->hr_profile_model->count_staff_by_department_literacy();

				if ($id_department == '') {
					$list_department = $this->hr_profile_model->get_department_by_list_id();

					foreach ($list_diploma as $diploma) {
						$list_data_count = [];
						foreach ($list_department as $department) {

							$count = 0;
							if (isset($departement_by_literacy[$department['departmentid']][$diploma])) {
								$count = (int) $departement_by_literacy[$department['departmentid']][$diploma];
							}
							$list_data_count[] = $count;
						}
						array_push($list_result, array('stack' => _l($diploma), 'data' => $list_data_count));
					}
				} else {
					if (count($department_filter) == 1) {
//one department
						$circle_mode = true;
						$list_department = $this->hr_profile_model->get_department_by_list_id($id_department);
						$list_temp = [];
						$count_total = 0;
						foreach ($list_department as $department) {
							foreach ($list_diploma as $diploma) {
								$count = 0;
								if (isset($departement_by_literacy[$department['departmentid']][$diploma])) {
									$count = (int) $departement_by_literacy[$department['departmentid']][$diploma];
								}

								$count_total += $count;
								$list_temp[] = array('name' => _l($diploma), 'y' => $count);
							}
						}
						foreach ($list_temp as $key => $value) {
							if ($count_total <= 0) {
								$ca_percent = 0;
							} else {
								$ca_percent = ($value['y'] * 100) / $count_total;
							}
							array_push($list_result, array('name' => $value['name'], 'y' => $ca_percent));
						}
					} else {
// multiple deparment
						$list_department = $this->hr_profile_model->get_department_by_list_id($id_department);
						foreach ($list_diploma as $diploma) {
							$list_data_count = [];
							foreach ($list_department as $department) {
								$count = 0;
								if (isset($departement_by_literacy[$department['departmentid']][$diploma])) {
									$count = (int) $departement_by_literacy[$department['departmentid']][$diploma];
								}
								$list_data_count[] = $count;
							}
							array_push($list_result, array('stack' => _l($diploma), 'data' => $list_data_count));
						}

					}
				}
				if (isset($list_department)) {
					foreach ($list_department as $key => $value) {
						$list_data_department[] = $value['name'];
					}
				}
				echo json_encode([
					'department' => $list_data_department,
					'data_result' => $list_result,
					'circle_mode' => $circle_mode,
				]);
				die;
			}
		}
	}

	/**
	 * report by staffs
	 * @return [type]
	 */
	public function report_by_staffs() {
		echo json_encode($this->hr_profile_model->report_by_staffs());
	}

	/**
	 * import job position excel
	 * @return [type]
	 */
	public function import_job_position_excel() {
		if (!class_exists('XLSXReader_fin')) {
			require_once module_dir_path(HR_PROFILE_MODULE_NAME) . '/assets/plugins/XLSXReader/XLSXReader.php';
		}
		require_once module_dir_path(HR_PROFILE_MODULE_NAME) . '/assets/plugins/XLSXWriter/xlsxwriter.class.php';

		$filename = '';
		if ($this->input->post()) {
			if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {

				$this->delete_error_file_day_before();

				// Get the temp file path
				$tmpFilePath = $_FILES['file_csv']['tmp_name'];
				// Make sure we have a filepath
				if (!empty($tmpFilePath) && $tmpFilePath != '') {
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
							_l('hr_position_code') => 'string',
							_l('hr_position_name') => 'string',
							_l('hr_job_p_id') => 'string',
							_l('hr_job_descriptions') => 'string',
							_l('department_id') => 'string',
							_l('tags') => 'string',
							_l('error') => 'string',
						);
						$rowstyle[] = array('widths' => [10, 20, 30, 40]);

						$writer = new XLSXWriter();
						$writer->writeSheetHeader('Sheet1', $writer_header, $col_options = ['widths' => [40, 40, 40, 50, 40, 40, 50]]);

						//Reader file
						$xlsx = new XLSXReader_fin($newFilePath);
						$sheetNames = $xlsx->getSheetNames();
						$data = $xlsx->getSheetData($sheetNames[1]);

						$arr_header = [];

						$arr_header['position_code'] = 0;
						$arr_header['position_name'] = 1;
						$arr_header['job_p_id'] = 2;
						$arr_header['job_position_description'] = 3;
						$arr_header['department_id'] = 4;
						$arr_header['tags'] = 5;

						$total_rows = 0;
						$total_row_false = 0;

						for ($row = 1; $row < count($data); $row++) {

							$total_rows++;

							$rd = array();
							$flag = 0;
							$flag2 = 0;

							$string_error = '';
							$flag_position_group;
							$flag_department = null;

							$value_position_code = isset($data[$row][$arr_header['position_code']]) ? $data[$row][$arr_header['position_code']] : '';
							$value_position_name = isset($data[$row][$arr_header['position_name']]) ? $data[$row][$arr_header['position_name']] : '';
							$value_position_group = isset($data[$row][$arr_header['job_p_id']]) ? $data[$row][$arr_header['job_p_id']] : 0;
							$value_description = isset($data[$row][$arr_header['job_position_description']]) ? $data[$row][$arr_header['job_position_description']] : '';
							$value_department = isset($data[$row][$arr_header['department_id']]) ? $data[$row][$arr_header['department_id']] : '';
							$value_tags = isset($data[$row][$arr_header['tags']]) ? $data[$row][$arr_header['tags']] : '';

							if (is_null($value_position_name) == true || $value_position_name == '') {
								$string_error .= _l('hr_position_name') . _l('not_yet_entered');
								$flag = 1;
							}

							//check position group exist  (input: id or name)
							$flag_position_group = 0;
							if (is_null($value_position_group) != true && ($value_position_group != '0')) {
								/*case input id*/
								if (is_numeric($value_position_group)) {

									$this->db->where('job_id', $value_position_group);
									$position_group_id_value = $this->db->count_all_results(db_prefix() . 'hr_job_p');

									if ($position_group_id_value == 0) {
										$string_error .= _l('hr_job_p_id') . _l('does_not_exist');
										$flag2 = 1;
									} else {
										/*get id job_id*/
										$flag_position_group = $value_position_group;
									}

								} else {
									/*case input name*/
									$this->db->like(db_prefix() . 'hr_job_p.job_name', $value_position_group);

									$position_group_id_value = $this->db->get(db_prefix() . 'hr_job_p')->result_array();
									if (count($position_group_id_value) == 0) {
										$string_error .= _l('hr_job_p_id') . _l('does_not_exist');
										$flag2 = 1;
									} else {
										/*get job_id*/
										$flag_position_group = $position_group_id_value[0]['job_id'];
									}
								}

							}
							//check department
							if ($value_department != null && $value_department != '') {
								$department_result = $this->hr_profile_model->check_department_format($value_department);

								if ($department_result['status']) {
									$flag_department = $department_result['result'];
								} else {
									$string_error .= $department_result['result'] . _l('department_name') . _l('does_not_exist');
									$flag2 = 1;
								}

							}

							if (($flag == 1) || $flag2 == 1) {
								//write error file
								$writer->writeSheetRow('Sheet1', [
									$value_position_code,
									$value_position_name,
									$value_position_group,
									$value_description,
									$value_department,
									$value_tags,
									$string_error,
								]);
								$total_row_false++;
							}

							if ($flag == 0 && $flag2 == 0) {

								if ($value_position_code == '') {
									$rd['position_code'] = $this->hr_profile_model->create_code('position_code');
								} else {
									$rd['position_code'] = $value_position_code;
								}

								$rd['position_name'] = $value_position_name;
								$rd['job_p_id'] = $flag_position_group;
								$rd['job_position_description'] = $value_description;
								$rd['department_id'] = $flag_department;
								$rd['tags'] = $value_tags;

								$rows[] = $rd;
								$response = $this->hr_profile_model->add_job_position($rd);
							}

						}

						$total_rows = $total_rows;
						$total_row_success = isset($rows) ? count($rows) : 0;
						$dataerror = '';
						$message = 'Not enought rows for importing';

						if ($total_row_false != 0) {
							$filename = 'Import_job_position_error_' . get_staff_user_id() . '_' . strtotime(date('Y-m-d H:i:s')) . '.xlsx';
							$writer->writeToFile(str_replace($filename, HR_PROFILE_ERROR . $filename, $filename));
						}

					}
				}
			}
		}

		if (file_exists($newFilePath)) {
			@unlink($newFilePath);
		}

		echo json_encode([
			'message' => $message,
			'total_row_success' => $total_row_success,
			'total_row_false' => $total_row_false,
			'total_rows' => $total_rows,
			'site_url' => site_url(),
			'staff_id' => get_staff_user_id(),
			'filename' => HR_PROFILE_ERROR . $filename,
		]);
	}

	/**
	 * hrm delete bulk action
	 * @return [type]
	 */
	public function hrm_delete_bulk_action() {
		if (!is_staff_member()) {
			ajax_access_denied();
		}

		$total_deleted = 0;

		if ($this->input->post()) {

			$ids = $this->input->post('ids');
			$rel_type = $this->input->post('rel_type');

			/*check permission*/
			switch ($rel_type) {
			case 'hrm_contract':
				if (!has_permission('hrm_contract', '', 'delete') && !is_admin()) {
					access_denied('hr_hr_profile');
				}
				break;

			case 'hrm_staff':
				if (!has_permission('hrm_hr_records', '', 'delete') && !is_admin()) {
					access_denied('hr_hr_profile');
				}
				break;

			case 'hrm_training_library':
				if (!has_permission('staffmanage_training', '', 'delete') && !is_admin()) {
					access_denied('hr_hr_profile');
				}
				break;

			case 'hrm_job_position':
				if (!has_permission('staffmanage_job_position', '', 'delete') && !is_admin()) {
					access_denied('hr_hr_profile');
				}
				break;

			case 'hrm_kb-articles':
				if (!has_permission('hr_manage_q_a', '', 'delete') && !is_admin()) {
					access_denied('hr_hr_profile');
				}
				break;

			case 'hrm_reception_staff':
				if (!has_permission('hrm_reception_staff', '', 'delete') && !is_admin()) {
					access_denied('hr_hr_profile');
				}
				break;

			case 'hrm_resignation_procedures':
				if (!has_permission('hrm_procedures_for_quitting_work', '', 'delete') && !is_admin()) {
					access_denied('hr_hr_profile');
				}
				break;

			default:
				# code...
				break;
			}

			/*delete data*/
			$transfer_data_to = get_staff_user_id();
			if ($this->input->post('mass_delete')) {
				if (is_array($ids)) {
					foreach ($ids as $id) {

						switch ($rel_type) {
						case 'hrm_contract':
							if ($this->hr_profile_model->delete_contract($id)) {
								$total_deleted++;
								break;
							} else {
								break;
							}

						case 'hrm_staff':
							if ($this->hr_profile_model->delete_staff($id, $transfer_data_to)) {
								$total_deleted++;
								break;
							} else {
								break;
							}

						case 'hrm_training_library':
							if ($this->hr_profile_model->delete_position_training($id)) {
								$total_deleted++;
								break;
							} else {
								break;
							}

							break;

						case 'hrm_job_position':
							if ($this->hr_profile_model->delete_job_position($id)) {
								$total_deleted++;
								break;
							} else {
								break;
							}

							break;

						case 'hrm_kb-articles':
							$this->load->model('knowledge_base_q_a_model');

							if ($this->knowledge_base_q_a_model->delete_article($id)) {
								$total_deleted++;
								break;
							} else {
								break;
							}

							break;

						case 'hrm_reception_staff':

							$this->hr_profile_model->delete_manage_info_reception($id);
							$this->hr_profile_model->delete_setting_training($id);
							$this->hr_profile_model->delete_setting_asset_allocation($id);
							$success = $this->hr_profile_model->delete_reception($id);
							if ($success) {
								$total_deleted++;
							} else {
								break;
							}

							break;

						case 'hrm_resignation_procedures':
							$success = $this->hr_profile_model->delete_procedures_for_quitting_work($id);
							if ($success) {
								$total_deleted++;
							} else {
								break;
							}

							break;

						default:
							# code...
							break;
						}

					}
				}

				/*return result*/
				switch ($rel_type) {
				case 'hrm_contract':
					set_alert('success', _l('total_contract_deleted') . ": " . $total_deleted);
					break;

				case 'hrm_staff':
					set_alert('success', _l('total_staff_deleted') . ": " . $total_deleted);
					break;

				case 'hrm_training_library':
					set_alert('success', _l('total_training_libraries_deleted') . ": " . $total_deleted);
					break;

				case 'hrm_job_position':
					set_alert('success', _l('total_job_position_deleted') . ": " . $total_deleted);
					break;

				case 'hrm_kb-articles':
					set_alert('success', _l('total_kb_articles_deleted') . ": " . $total_deleted);
					break;

				case 'hrm_reception_staff':
					set_alert('success', _l('total_reception_staff_deleted') . ": " . $total_deleted);
					break;

				case 'hrm_resignation_procedures':
					set_alert('success', _l('total_layoff_checklist_deleted') . ": " . $total_deleted);
					break;

				default:
					# code...
					break;

				}

			}

		}

	}

	/**
	 * hrm delete bulk action v2
	 * @return [type]
	 * Delete data from ids array, don't use foreach
	 */
	public function hrm_delete_bulk_action_v2() {
		if (!is_staff_member()) {
			ajax_access_denied();
		}

		$total_deleted = 0;

		if ($this->input->post()) {

			$ids = $this->input->post('ids');
			$rel_type = $this->input->post('rel_type');

			/*check permission*/
			switch ($rel_type) {

			case 'hrm_training_program':
				if (!has_permission('staffmanage_training', '', 'delete') && !is_admin()) {
					access_denied('hr_hr_profile');
				}
				break;

			case 'hrm_job':
				if (!has_permission('staffmanage_job_position', '', 'delete') && !is_admin()) {
					access_denied('hr_hr_profile');
				}
				break;

			case 'hrm_dependent_person':
				if (!has_permission('hrm_dependent_person', '', 'delete') && !is_admin()) {
					access_denied('hr_hr_profile');
				}
				break;

			default:
				# code...
				break;
			}

			/*delete data*/
			$transfer_data_to = get_staff_user_id();
			if ($this->input->post('mass_delete')) {
				if (is_array($ids)) {

					switch ($rel_type) {

					case 'hrm_training_program':
						$sql_where = " training_process_id  IN ( '" . implode("', '", $ids) . "' ) ";
						$this->db->where($sql_where);
						$this->db->delete(db_prefix() . 'hr_jp_interview_training');
						$total_deleted = count($ids);
						break;

					case 'hrm_job':
						$sql_where = " job_id  IN ( '" . implode("', '", $ids) . "' ) ";
						$this->db->where($sql_where);
						$this->db->delete(db_prefix() . 'hr_job_p');
						$total_deleted = count($ids);
						break;

					case 'hrm_dependent_person':
						$sql_where = " id  IN ( '" . implode("', '", $ids) . "' ) ";
						$this->db->where($sql_where);
						$this->db->delete(db_prefix() . 'hr_dependent_person');
						$total_deleted = count($ids);
						break;

					default:
						# code...
						break;
					}

				}

				/*return result*/
				switch ($rel_type) {

				case 'hrm_training_program':
					set_alert('success', _l('total_training_program_deleted') . ": " . $total_deleted);
					break;

				case 'hrm_job':
					set_alert('success', _l('total_job_deleted') . ": " . $total_deleted);
					break;

				case 'hrm_dependent_person':
					set_alert('success', _l('total_dependent_person_deleted') . ": " . $total_deleted);
					break;

				default:
					# code...
					break;

				}

			}

		}

	}

	/**
	 * import dependent person excel
	 * @return [type]
	 */
	public function import_dependent_person_excel() {
		if (!class_exists('XLSXReader_fin')) {
			require_once module_dir_path(HR_PROFILE_MODULE_NAME) . '/assets/plugins/XLSXReader/XLSXReader.php';
		}
		require_once module_dir_path(HR_PROFILE_MODULE_NAME) . '/assets/plugins/XLSXWriter/xlsxwriter.class.php';

		$filename = '';
		if ($this->input->post()) {
			if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {

				$this->delete_error_file_day_before();

				// Get the temp file path
				$tmpFilePath = $_FILES['file_csv']['tmp_name'];
				// Make sure we have a filepath
				if (!empty($tmpFilePath) && $tmpFilePath != '') {
					$rows = [];
					$arr_insert = [];

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
							_l('hr_hr_code') => 'string',
							_l('hr_dependent_name') => 'string',
							_l('hr_hr_relationship') => 'string',
							_l('hr_dependent_bir') => 'string',
							_l('hr_dependent_iden') => 'string',
							_l('hr_reason_label') => 'string',
							_l('hr_start_month') => 'string',
							_l('hr_end_month') => 'string',
							_l('hr_status_label') => 'string',
							_l('error') => 'string',
						);
						$rowstyle[] = array('widths' => [10, 20, 30, 40]);

						$writer = new XLSXWriter();
						$writer->writeSheetHeader('Sheet1', $writer_header, $col_options = ['widths' => [40, 40, 40, 50, 40, 40, 40, 40, 50, 50]]);

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
						$total_row_false = 0;

						for ($row = 1; $row < count($data); $row++) {

							$total_rows++;

							$rd = array();
							$flag = 0;
							$flag2 = 0;

							$string_error = '';
							$flag_position_group;
							$flag_department = null;

							$value_staffid = isset($data[$row][$arr_header['staffid']]) ? $data[$row][$arr_header['staffid']] : '';
							$value_dependent_name = isset($data[$row][$arr_header['dependent_name']]) ? $data[$row][$arr_header['dependent_name']] : '';
							$value_relationship = isset($data[$row][$arr_header['relationship']]) ? $data[$row][$arr_header['relationship']] : '';
							$value_dependent_bir = isset($data[$row][$arr_header['dependent_bir']]) ? $data[$row][$arr_header['dependent_bir']] : '';
							$value_dependent_iden = isset($data[$row][$arr_header['dependent_iden']]) ? $data[$row][$arr_header['dependent_iden']] : '';
							$value_reason = isset($data[$row][$arr_header['reason']]) ? $data[$row][$arr_header['reason']] : '';
							$value_start_month = isset($data[$row][$arr_header['start_month']]) ? $data[$row][$arr_header['start_month']] : '';
							$value_end_month = isset($data[$row][$arr_header['end_month']]) ? $data[$row][$arr_header['end_month']] : '';
							$value_status = isset($data[$row][$arr_header['status']]) ? $data[$row][$arr_header['status']] : '';

							/*check null*/
							if (is_null($value_staffid) == true) {
								$string_error .= _l('hr_hr_code') . _l('not_yet_entered');
								$flag = 1;
							}

							$flag_staff_id = 0;
							//check hr_code exist
							if (is_null($value_staffid) != true) {
								$this->db->where('staff_identifi', $value_staffid);
								$hrcode = $this->db->get(db_prefix() . 'staff')->row();
								if ($hrcode) {
									$flag_staff_id = $hrcode->staffid;
								} else {
									$string_error .= _l('hr_hr_code') . _l('does_not_exist');
									$flag2 = 1;
								}

							}

							//check start_time
							if (is_null($value_dependent_bir) != true && $value_dependent_bir != '') {

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
							if (is_null($value_start_month) != true && $value_start_month != '') {

								if (is_null($value_start_month) != true) {

									if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", trim($value_start_month, " "))) {
										$test = true;

									} else {
										$flag2 = 1;
										$string_error .= _l('hr_start_month') . _l('invalid');
									}
								}
							}

							if (is_null($value_end_month) != true && $value_end_month != '') {

								if (is_null($value_end_month) != true) {

									if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", trim($value_end_month, " "))) {
										$test = true;

									} else {
										$flag2 = 1;
										$string_error .= _l('hr_end_month') . _l('invalid');
									}
								}
							}

							if (($flag == 1) || $flag2 == 1) {
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

							if ($flag == 0 && $flag2 == 0) {

								if (is_numeric($value_status) && ($value_status == '2')) {
									/*reject*/
									$rd['status'] = 2;
								} else {
									/*approval*/
									$rd['status'] = 1;
								}

								$rd['staffid'] = $flag_staff_id;
								$rd['dependent_name'] = $value_dependent_name;
								$rd['relationship'] = $value_relationship;
								$rd['dependent_bir'] = $value_dependent_bir;
								$rd['dependent_iden'] = $value_dependent_iden;
								$rd['reason'] = $value_reason;
								$rd['start_month'] = $value_start_month;
								$rd['end_month'] = $value_end_month;

								$rows[] = $rd;
								array_push($arr_insert, $rd);

							}

						}

						//insert batch
						if (count($arr_insert) > 0) {

							$this->db->insert_batch(db_prefix() . 'hr_dependent_person', $arr_insert);
						}

						$total_rows = $total_rows;
						$total_row_success = isset($rows) ? count($rows) : 0;
						$dataerror = '';
						$message = 'Not enought rows for importing';

						if ($total_row_false != 0) {
							$filename = 'Import_dependent_person_error_' . get_staff_user_id() . '_' . strtotime(date('Y-m-d H:i:s')) . '.xlsx';
							$writer->writeToFile(str_replace($filename, HR_PROFILE_ERROR . $filename, $filename));
						}

					}
				}
			}
		}

		if (file_exists($newFilePath)) {
			@unlink($newFilePath);
		}

		echo json_encode([
			'message' => $message,
			'total_row_success' => $total_row_success,
			'total_row_false' => $total_row_false,
			'total_rows' => $total_rows,
			'site_url' => site_url(),
			'staff_id' => get_staff_user_id(),
			'filename' => HR_PROFILE_ERROR . $filename,
		]);
	}

	/**
	 * reset data
	 * @return [type]
	 */
	public function reset_data() {

		if (!is_admin()) {
			access_denied('hr_profile');
		}
		//delete Onboarding process
		$this->db->truncate(db_prefix() . 'hr_rec_transfer_records');
		$this->db->truncate(db_prefix() . 'hr_group_checklist_allocation');
		$this->db->truncate(db_prefix() . 'hr_allocation_asset');
		$this->db->truncate(db_prefix() . 'hr_training_allocation');

		//delete Training
		$this->db->truncate(db_prefix() . 'hr_jp_interview_training');
		$this->db->truncate(db_prefix() . 'hr_position_training');
		$this->db->truncate(db_prefix() . 'hr_position_training_question_form');
		$this->db->truncate(db_prefix() . 'hr_p_t_form_question_box');
		$this->db->truncate(db_prefix() . 'hr_p_t_form_question_box_description');
		$this->db->truncate(db_prefix() . 'hr_p_t_form_results');
		$this->db->truncate(db_prefix() . 'hr_p_t_surveyresultsets');

		//delete contracs, file type "hr_contract"
		$this->db->truncate(db_prefix() . 'hr_staff_contract_detail');
		$this->db->truncate(db_prefix() . 'hr_staff_contract');

		//delete dependent persons
		$this->db->truncate(db_prefix() . 'hr_dependent_person');

		//delete Resignation procedures
		$this->db->truncate(db_prefix() . 'hr_list_staff_quitting_work');
		$this->db->truncate(db_prefix() . 'hr_procedure_retire_of_staff');

		//delete Q&A
		$this->db->truncate(db_prefix() . 'hr_knowledge_base');
		$this->db->truncate(db_prefix() . 'hr_knowledge_base_groups');
		$this->db->truncate(db_prefix() . 'hr_knowedge_base_article_feedback');
		$this->db->truncate(db_prefix() . 'hr_views_tracking');

		//delete sub folder contract
		foreach (glob(HR_PROFILE_CONTRACT_ATTACHMENTS_UPLOAD_FOLDER . '*') as $file) {
			$file_arr = explode("/", $file);
			$filename = array_pop($file_arr);

			if (is_dir($file)) {
				delete_dir(HR_PROFILE_CONTRACT_ATTACHMENTS_UPLOAD_FOLDER . $filename);
			}
		}

		//delete sub folder Q_A_ATTACHMENTS
		foreach (glob(HR_PROFILE_Q_A_ATTACHMENTS_UPLOAD_FOLDER . '*') as $file) {
			$file_arr = explode("/", $file);
			$filename = array_pop($file_arr);

			if (is_dir($file)) {
				delete_dir(HR_PROFILE_Q_A_ATTACHMENTS_UPLOAD_FOLDER . $filename);
			}
		}

		//delete file error response
		foreach (glob('modules/hr_profile/uploads/file_error_response/' . '*') as $file) {
			$file_arr = explode("/", $file);
			$filename = array_pop($file_arr);

			if (is_dir($file)) {
				delete_dir('modules/hr_profile/uploads/file_error_response/' . $filename);
			}
		}

		//delete file
		$this->db->where('rel_type', 'staff_contract');
		$this->db->or_where('rel_type', 'kb_article_files');
		$this->db->delete(db_prefix() . 'files');

		set_alert('success', _l('reset_data_successful'));
		redirect(admin_url('hr_profile/setting?group=reset_data'));

	}

	/**
	 * table training program
	 * @return [type]
	 */
	public function table_training_program() {
		$this->app->get_table_data(module_views_path('hr_profile', 'training/job_position_manage/training_programs_table'));
	}

	/**
	 * table training result
	 * @return [type]
	 */
	public function table_training_result() {
		$this->app->get_table_data(module_views_path('hr_profile', 'training/job_position_manage/training_result_table'));
	}

	/**
	 * training table
	 * @return [type]
	 */
	public function training_libraries_table() {
		$this->app->get_table_data(module_views_path('hr_profile', 'training/job_position_manage/training_table'));
	}

	/**
	 * type of training
	 * @param  string $id
	 * @return [type]
	 */
	public function type_of_training($id = '') {
		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			if (!$this->input->post('id')) {
				$id = $this->hr_profile_model->add_type_of_training($data);
                if ($id) {
                    $message = _l('added_successfully', _l('hr_type_of_training'));
                    set_alert('success', $message);
                }
				redirect(admin_url('hr_profile/setting?group=type_of_training'));
			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->hr_profile_model->update_type_of_training($data, $id);
				if ($success) {
					$message = _l('updated_successfully', _l('hr_type_of_training'));
					set_alert('success', $message);
				} else {
					$message = _l('hr_updated_failed', _l('hr_allowance_type'));
					set_alert('warning', $message);
				}
				redirect(admin_url('hr_profile/setting?group=type_of_training'));
			}
			die;
		}
	}

	/**
	 * delete type of training
	 * @param  [type] $id
	 * @return [type]
	 */
	public function delete_type_of_training($id) {
		if (!$id) {
			redirect(admin_url('hr_profile/setting?group=type_of_training'));
		}

		if (!has_permission('hrm_setting', '', 'delete') && !is_admin()) {
			access_denied('hr_profile');
		}

		$response = $this->hr_profile_model->delete_type_of_training($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('hr_is_referenced', _l('hr_type_of_training')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('hr_type_of_training')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('hr_type_of_training')));
		}
		redirect(admin_url('hr_profile/setting?group=type_of_training'));
	}

	/**
	 * get training program by type
	 * @return [type]
	 */
	public function get_training_program_by_type() {
		if ($this->input->is_ajax_request()) {
			$data = $this->input->post();
			if ($data['training_type'] == '') {
				$training_type = 0;
			} else {
				$training_type = $data['training_type'];
			}

			$training_program_option = '';
			$list_staff = $this->hr_profile_model->get_staff_info_id($data['staff_id']);
			if ($list_staff) {
				$training_program_option = $this->hr_profile_model->get_list_training_program($list_staff->job_position, $training_type);
			}

			echo json_encode([
				'training_program_html' => $training_program_option,
			]);
		}
	}

	/**
	 * view training program
	 * @param  string $id
	 * @return [type]
	 */
	public function view_training_program($id = '') {
		if (!has_permission('staffmanage_training', '', 'view') && !has_permission('staffmanage_training', '', 'view_own')) {
			access_denied('view_training_program');
		}

		//load deparment by manager
		if (!is_admin() && !has_permission('staffmanage_training', '', 'view')) {
			//View own
			$array_staff = $this->hr_profile_model->get_staff_by_manager();
		}

		$data['title'] = _l('view_training_program');
		$data['training_program'] = $this->hr_profile_model->get_job_position_training_de($id);

		if (!$data['training_program']) {
			blank_page('Training program Not Found', 'danger');
		}

		$data['training_results'] = $this->hr_profile_model->get_training_result_by_training_program($id);
		if (isset($array_staff)) {
			foreach ($data['training_results'] as $key => $value) {
				if (!in_array($value['staff_id'], $array_staff)) {
					unset($data['training_results'][$key]);
				}
			}
		}

		$this->load->view('hr_profile/training/view_training_program', $data);
	}

	/* Get role permission for specific role id */
	public function hr_role_changed($id) {
		echo json_encode($this->roles_model->get($id)->permissions);
	}

	/**
	 * create staff excel file
	 * @return [type]
	 */
	public function create_staff_sample_file() {
		$this->load->model('departments_model');

		$data = $this->input->post();

		if (!class_exists('XLSXReader_fin')) {
			require_once module_dir_path(HR_PROFILE_MODULE_NAME) . '/assets/plugins/XLSXReader/XLSXReader.php';
		}
		require_once module_dir_path(HR_PROFILE_MODULE_NAME) . '/assets/plugins/XLSXWriter/xlsxwriter.class.php';

		$this->delete_error_file_day_before('1', HR_PROFILE_CREATE_EMPLOYEES_SAMPLE);

		if (isset($data['sample_file'])) {

			$staffs = [];
		} else {

			//get list staff by id
			$this->db->where('staffid  IN (' . implode(",", $data['ids']) . ') ');
			$staffs = $this->db->get(db_prefix() . 'staff')->result_array();
		}

		$header_key = [
			'staffid',
			'staff_identifi', //*
			'firstname', //*
			'lastname', //*
			'sex',
			'birthday',
			'email', //*
			'phonenumber',
			'workplace',
			'status_work', //*
			'job_position', //*
			'team_manage',
			'role',
			'literacy',
			'hourly_rate',
			'department',
			'password',
			'home_town', //text
			'marital_status',
			'current_address',
            'birthplace',
			'religion',
			'identification',
			'days_for_identity',
			'place_of_issue',
			'resident',
			'account_number',
			'name_account',
			'issue_bank',
            'facebook',
			'linkedin',
			'twitter',
            'skype',
		];

		$header_label = [
			'id',
			'hr_staff_code', //*
			'hr_firstname', //*
			'hr_lastname', //*
			'hr_sex',
			'hr_hr_birthday',
			'Email', //*
			'staff_add_edit_phonenumber',
			'hr_hr_workplace',
			'hr_status_work', //*
			'hr_hr_job_position', //*
			'hr_team_manage',
			'staff_add_edit_role',
			'hr_hr_literacy',
			'staff_hourly_rate',
			'staff_add_edit_departments',
			'staff_add_edit_password',
			'hr_hr_home_town', //text
			'hr_hr_marital_status',
			'hr_current_address',
            'hr_hr_birthplace',
			'hr_hr_religion',
			'hr_citizen_identification',
			'hr_license_date',
			'hr_hr_place_of_issue',
			'hr_hr_resident',
			'hr_bank_account_number',
			'hr_bank_account_name',
			'hr_bank_name',
            'staff_add_edit_facebook',
			'staff_add_edit_linkedin',
			'staff_add_edit_twitter',
            'staff_add_edit_skype',
		];

		//Writer file
		//create header value
		$writer_header = [];
		$widths = [];

		$widths[] = 30;

		foreach ($header_label as $header_value) {
			$writer_header[_l($header_value)] = 'string';
			$widths[] = 30;
		}

		$writer = new XLSXWriter();

		//orange: do not update
		$col_style1 = [0, 1];
		$style1 = ['widths' => $widths, 'fill' => '#fc2d42', 'font-style' => 'bold', 'color' => '#0a0a0a', 'border' => 'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13];

		//red: required
		$col_style2 = [2, 3, 6, 9, 10];
		$style2 = ['widths' => $widths, 'fill' => '#ff9800', 'font-style' => 'bold', 'color' => '#0a0a0a', 'border' => 'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13];

		//otherwise blue: can be update

		$writer->writeSheetHeader_v2('Sheet1', $writer_header, $col_options = ['widths' => $widths, 'fill' => '#03a9f46b', 'font-style' => 'bold', 'color' => '#0a0a0a', 'border' => 'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13],
			$col_style1, $style1, $col_style2, $style2);

		$row_style1 = array('fill' => '#F8CBAD', 'height' => 25, 'border' => 'left,right,top,bottom', 'border-color' => '#FFFFFF', 'font-size' => 12, 'font' => 'Calibri', 'color' => '#000000');
		$row_style2 = array('fill' => '#FCE4D6', 'height' => 25, 'border' => 'left,right,top,bottom', 'border-color' => '#FFFFFF', 'font-size' => 12, 'font' => 'Calibri', 'color' => '#000000');

		//job position data
		$job_position_data = [];
		$job_positions = $this->hr_profile_model->get_job_position();

		foreach ($job_positions as $key => $job_position) {
			$job_position_data[$job_position['position_id']] = $job_position;
		}

		//direct manager
		$staff_data = [];
		$list_staffs = $this->hr_profile_model->get_staff();
		foreach ($list_staffs as $key => $list_staff) {
			$staff_data[$list_staff['staffid']] = $list_staff;
		}

		//get role data
		$role_data = [];
		$this->load->model('role/roles_model');
		$list_roles = $this->roles_model->get();

		foreach ($list_roles as $key => $list_role) {
			$role_data[$list_role['roleid']] = $list_role;
		}

		//get workplace data
		$workplace_data = [];
		$list_workplaces = $this->hr_profile_model->get_workplace();

		foreach ($list_workplaces as $key => $list_workplace) {
			$workplace_data[$list_workplace['id']] = $list_workplace;
		}

		//write the next row (row2)
		$writer->writeSheetRow('Sheet1', $header_key);

		foreach ($staffs as $staff_key => $staff_value) {

			$arr_department = $this->hr_profile_model->get_staff_departments($staff_value['staffid'], true);

			$list_department = '';
			if (count($arr_department) > 0) {

				foreach ($arr_department as $key => $department) {
					$department_value = $this->departments_model->get($department);

					if ($department_value) {
						if (strlen($list_department) != 0) {
							$list_department .= ';' . $department_value->name;
						} else {
							$list_department .= $department_value->name;
						}
					}
				}
			}

			$temp = [];

			foreach ($header_key as $_key) {
				if ($_key == 'password') {
					$temp[] = '';
				} elseif ($_key == 'department') {
					$temp[] = $list_department;

				} elseif ($_key == 'job_position') {
					$temp[] = isset($job_position_data[$staff_value['job_position']]) ? $job_position_data[$staff_value['job_position']]['position_code'] : '';

				} elseif ($_key == 'team_manage') {
					$temp[] = isset($staff_data[$staff_value['team_manage']]) ? $staff_data[$staff_value['team_manage']]['staff_identifi'] : '';

				} elseif ($_key == 'role') {
					$temp[] = isset($role_data[$staff_value['role']]) ? $role_data[$staff_value['role']]['name'] : '';

				} elseif ($_key == 'workplace') {
					$temp[] = isset($workplace_data[$staff_value['workplace']]) ? $workplace_data[$staff_value['workplace']]['name'] : '';

				} else {
					$temp[] = isset($staff_value[$_key]) ? $staff_value[$_key] : '';
				}
			}

			if (($staff_key % 2) == 0) {
				$writer->writeSheetRow('Sheet1', $temp, $row_style1);
			} else {
				$writer->writeSheetRow('Sheet1', $temp, $row_style2);
			}

		}

		$filename = 'employees_sample_file' . get_staff_user_id() . '_' . strtotime(date('Y-m-d H:i:s')) . '.xlsx';
		$writer->writeToFile(str_replace($filename, HR_PROFILE_CREATE_EMPLOYEES_SAMPLE . $filename, $filename));

		echo json_encode([
			'success' => true,
			'site_url' => site_url(),
			'staff_id' => get_staff_user_id(),
			'filename' => HR_PROFILE_CREATE_EMPLOYEES_SAMPLE . $filename,
		]);

	}

	//test view PDF file: TODO
	public function view_pdf() {
		$data = [];
		$this->load->view('hr_profile/contracts/view_contract_pdf', $data);
	}

	/**
	 * save contract data
	 * @return [type]
	 */
	public function save_hr_contract_data() {
		if (!has_permission('hrm_contract', '', 'edit')) {
			header('HTTP/1.0 400 Bad error');
			echo json_encode([
				'success' => false,
				'message' => _l('access_denied'),
			]);
			die;
		}

		$success = false;
		$message = '';

		$this->db->where('id_contract', $this->input->post('contract_id'));
		$this->db->update(db_prefix() . 'hr_staff_contract', [
			'content' => html_purify($this->input->post('content', false)),
		]);

		$success = $this->db->affected_rows() > 0;
		$message = _l('updated_successfully', _l('contract'));

		echo json_encode([
			'success' => $success,
			'message' => $message,
		]);
	}

	/**
	 * hr clear signature
	 * @param  [type] $id
	 * @return [type]
	 */
	public function hr_clear_signature($id) {
		if (has_permission('hrm_contract', '', 'delete')) {
			$this->hr_profile_model->contract_clear_signature($id);
		}

		redirect(admin_url('hr_profile/contracts#' . $id));
	}

	/**
	 * contract pdf
	 * @param  [type] $id
	 * @return [type]
	 */
	public function contract_pdf($id) {
		if (!has_permission('hrm_contract', '', 'view') && !has_permission('hrm_contract', '', 'view_own')) {
			access_denied('contracts');
		}

		if (!$id) {
			redirect(admin_url('hr_profile/hrm_contract'));
		}

		$contract = $this->hr_profile_model->hr_get_staff_contract_pdf_only_for_pdf($id);

		try {
			$pdf = hr_contract_pdf($contract);
		} catch (Exception $e) {
			echo $e->getMessage();
			die;
		}

		$type = 'D';
		if ($this->input->get('output_type')) {
			$type = $this->input->get('output_type');
		}

		if ($this->input->get('print')) {
			$type = 'I';
		}

		$pdf->Output(slug_it($contract->contract_code) . '.pdf', $type);
	}

	/**
	 * contract sign
	 * @param  [type] $id
	 * @return [type]
	 */
	public function contract_sign($id) {
		$contract = $this->hr_profile_model->hr_get_staff_contract_pdf($id);

		if (!$contract) {
			show_404();
		}

		if ($this->input->post()) {

			if ($this->input->post('sign_by') == 'company') {
				process_digital_signature_image($this->input->post('signature', false), HR_PROFILE_CONTRACT_SIGN . $id);
				$get_acceptance_info_array = get_acceptance_info_array();

				$this->db->where('id_contract', $id);
				$this->db->update(db_prefix() . 'hr_staff_contract', ['signature' => $get_acceptance_info_array['signature'], 'signer' => get_staff_user_id(), 'sign_day' => date('Y-m-d')]);
			} else {

				hr_process_digital_signature_image($this->input->post('signature', false), HR_PROFILE_CONTRACT_SIGN . $id);
				$get_acceptance_info_array = get_acceptance_info_array();

				$this->db->where('id_contract', $id);
				$this->db->update(db_prefix() . 'hr_staff_contract', ['staff_signature' => $get_acceptance_info_array['signature'], 'staff_sign_day' => date('Y-m-d')]);

			}

			// Notify contract creator that customer signed the contract
			// send_contract_signed_notification_to_staff($id);

			set_alert('success', _l('document_signed_successfully'));
			redirect($_SERVER['HTTP_REFERER']);

		}

		$data['title'] = $contract->contract_code;

		$data['contract'] = $contract;
		$data['bodyclass'] = 'contract contract-view';

		$data['identity_confirmation_enabled'] = true;
		$data['bodyclass'] .= ' identity-confirmation';

		$this->load->view('hr_profile/contracts/contracthtml', $data);
	}


	/**
	 * contract template
	 * @param  string $id
	 * @return [type]
	 */
	public function contract_template($id = '') {

		if ($this->input->post()) {
			$message = '';
			$data = $this->input->post();

			$data['content'] = $this->input->post('mce_0', false);

			if (isset($data['mce_0'])) {
				unset($data['mce_0']);
			}

			if ($id == '') {
				$id = $this->hr_profile_model->add_contract_template($data);

				if ($id) {
					$message = _l('added_successfully', _l('contract_template'));
					set_alert('success', $message);
				} else {
					$message = _l('added_failed', _l('contract_template'));
					set_alert('warning', $message);
				}

				redirect(admin_url('hr_profile/setting?group=contract_template'));
			} else {

				$success = $this->hr_profile_model->update_contract_template($data, $id);

				if ($success) {
					$message = _l('updated_successfully', _l('contract_template'));
					set_alert('success', $message);

				} else {
					$message = _l('update_failed', _l('contract_template'));
					set_alert('warning', $message);
				}

				redirect(admin_url('hr_profile/setting?group=contract_template'));
			}

		}
		$data = [];

		if ($id == '') {
			//add
			$title = _l('add_contract_template');
			$data['title'] = $title;

		} else {
			//update
			$title = _l('update_contract_template');
			$data['title'] = $title;
			$data['contract_template'] = $this->hr_profile_model->get_contract_template($id);
		}

		$data['job_positions'] = $this->hr_profile_model->get_job_position();
		$data['contract_merge_fields'] = $this->app_merge_fields->get_flat('hr_contract', ['other'], '{email_signature}');

		$this->load->view('hr_profile/includes/contract_template_detail', $data);

	}

	/**
	 * delete contract template
	 * @param  [type] $id
	 * @return [type]
	 */

    //salary
    public function salary($staff_id){

        $group = '';

        if(!$this->input->get('group')){
            $_GET['group'] = 'update_salary';
        }else{
            $group = $this->input->get('group');
        }
        if ($this->input->is_ajax_request()) {
            if($group == 'commissions'){
               $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_commissions_table'),['staff_id' => $staff_id]);

            }elseif($group == 'other_payments'){
               $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_other_payments_table'),['staff_id' => $staff_id]);

            }elseif($group == 'loan'){
                $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_loan_table'),['staff_id' => $staff_id]);

            }elseif($group == 'overtime'){
               $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_overtime_table'),['staff_id' => $staff_id]);

            }elseif($group == 'allowances'){
               $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_allowances_table'),['staff_id' => $staff_id]);

            }elseif($group == 'statutory_deductions'){
                  $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_statutory_deductions_table'),['staff_id' => $staff_id]);

            }
        }

        $staff = ['type' => '', 'amount' => 0];
        $this->load->model("hr_profile/Salary_model");
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
        $this->load->model("hr_profile/Salary_model");
        $success = $this->Salary_model->update($data, $staff_id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }
    // allowance

    public function json_allowance($id){
        $this->load->model("hr_profile/Allowances_model");
        $data = $this->Allowances_model->get($id);
        echo json_encode($data);
    }
    public function update_allowance(){
        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $id = $this->input->post('id');
        $this->load->model("hr_profile/Allowances_model");
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
        $this->load->model("hr_profile/Allowances_model");
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
        $this->load->model("hr_profile/Allowances_model");
        $response = $this->Allowances_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    /**
     * allowance view edit
     * @param  string $id
     * @return view
     */
    public function allowance_view_edit($id = '')
    {
        $this->load->model("hr_profile/Allowances_model");

        if (!has_permission('allowances', '', 'view')) {
            access_denied('allowances');
        }
        $data['allowances'] = $this->Allowances_model->get($id);

            $this->load->view('hr_profile/hr_record/view_edit_allowances', $data);



    }






// other_payment

    public function json_other_payment($id){
        $this->load->model("hr_profile/Other_payment_model");
        $data = $this->Other_payment_model->get($id);
        echo json_encode($data);
    }
    public function update_other_payment(){
        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $id = $this->input->post('id');
        $this->load->model("hr_profile/Other_payment_model");
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
        $this->load->model("hr_profile/Other_payment_model");
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
        $this->load->model("hr_profile/Other_payment_model");
        $response = $this->Other_payment_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function other_payment_view_edit($id = '')
    {
        $this->load->model("hr_profile/Other_payment_model");

        if (!has_permission('other_payments', '', 'view')) {
            access_denied('other_payments');
        }
        $data['other_payment'] = $this->Other_payment_model->get($id);

        $this->load->view('hr_profile/hr_record/view_edit_other_payments', $data);

    }
// loan

    public function json_loan($id){
        $this->load->model("hr_profile/Loan_model");
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
        $this->load->model("hr_profile/Loan_model");
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
        $this->load->model("hr_profile/Loan_model");
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
        $this->load->model("hr_profile/Loan_model");
        $response = $this->Loan_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * loan view edit
     * @param  string $id
     * @return view
     */
    public function loan_view_edit($id = '')
    {
        $this->load->model("hr_profile/Loan_model");

        if (!has_permission('loan', '', 'view')) {
            access_denied('loan');
        }
        $data['loan'] = $this->Loan_model->get($id);

        $this->load->view('hr_profile/hr_record/view_edit_loan', $data);

    }


// overtime

    public function json_overtime($id){
        $this->load->model("hr_profile/Overtime_model");
        $data = $this->Overtime_model->get($id);
        echo json_encode($data);
    }
    public function update_overtime(){
        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $id = $this->input->post('id');
        $this->load->model("hr_profile/Overtime_model");
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
        $this->load->model("hr_profile/Overtime_model");
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
        $this->load->model("hr_profile/Overtime_model");
        $response = $this->Overtime_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function overtime_view_edit($id = '')
    {
        $this->load->model("hr_profile/Overtime_model");

        if (!has_permission('overtime', '', 'view')) {
            access_denied('overtime');
        }
        $data['overtime'] = $this->Overtime_model->get($id);

        $this->load->view('hr_profile/hr_record/view_edit_overtime', $data);

    }
// commission

    public function json_commission($id){
        $this->load->model("hr_profile/Commissions_model");
        $data = $this->Commissions_model->get($id);
        echo json_encode($data);
    }
    public function update_commission(){
        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $id = $this->input->post('id');
        $this->load->model("hr_profile/Commissions_model");
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
        $this->load->model("hr_profile/Commissions_model");
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
        $this->load->model("hr_profile/Commissions_model");
        $response = $this->Commissions_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * commissions view edit
     * @param  string $id
     * @return view
     */
    public function commissions_view_edit($id = '')
    {
        $this->load->model("hr_profile/Commissions_model");

        if (!has_permission('commissions', '', 'view')) {
            access_denied('commissions');
        }
        $data['commissions'] = $this->Commissions_model->get($id);

        $this->load->view('hr_profile/hr_record/view_edit_commissions', $data);

    }




    // statutory_deduction

    public function json_statutory_deduction($id){
      $this->load->model("hr_profile/Statutory_deduction_model");
      $data = $this->Statutory_deduction_model->get($id);
      echo json_encode($data);
    }
    public function update_statutory_deduction(){
      if (!has_permission('hr', '', 'edit')) {
          access_denied('hr');
      }
      $data = $this->input->post();
      $id = $this->input->post('id');
      $this->load->model("hr_profile/Statutory_deduction_model");
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
      $this->load->model("hr_profile/Statutory_deduction_model");
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
      $this->load->model("hr_profile/Statutory_deduction_model");
      $response = $this->Statutory_deduction_model->delete($id);
      if ($response == true) {
          set_alert('success', _l('deleted_successfully'));
      } else {
          set_alert('warning', 'Problem deleting');
      }
      redirect($_SERVER['HTTP_REFERER']);
    }
    

    public function statutory_deduction_view_edit($id = '')
    {
        $this->load->model("hr_profile/Statutory_deduction_model");

        if (!has_permission('statutory_deduction', '', 'view')) {
            access_denied('statutory_deduction');
        }
        $data['statutory_deduction'] = $this->Statutory_deduction_model->get($id);

        $this->load->view('hr_profile/hr_record/view_edit_statutory_deductions', $data);

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




//document
    public function json_document($id){
        $this->load->model('Official_document_model');
        $data = $this->Document_model->get($id);
        echo json_encode($data);
    }
    public function update_document(){
        $data = $this->input->post();
        $id = $this->input->post('id');
        $this->load->model('Official_document_model');
        $success = $this->Document_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_document(){
        $data = $this->input->post();
        $this->load->model('Official_document_model');
        $success = $this->Document_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_document($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $this->load->model('Official_document_model');
        $response = $this->Document_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * document view edit
     * @param  string $id
     * @return view
     */
    public function document_view_edit($id = '', $parent_id = '')
    {
        $this->load->model("Official_document_model");

        if (!has_permission('qualification', '', 'view')) {
            access_denied('qualification');
        }

        $data['document'] = $this->Document_model->get($id);

        $this->load->view('hr_profile/hr_record/view_edit_document', $data);
    }


//emergency_contacts
    public function json_emergency_contact($id){
        $this->load->model("emergency_contact_model");
        $data = $this->emergency_contact_model->get($id);
        echo json_encode($data);
    }
    public function add_emergency_contact(){
       // if(!is_admin() ||!has_permission('hr', '', 'create')|| !has_permission('emergency_contacts','','create')){
         //   access_denied('hr');
     //   }
        $data = $this->input->post();
        $this->load->model("emergency_contact_model");
        $success = $this->emergency_contact_model->add_emergency_contacts($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_emergency_contacts($id)
    {
        if (!has_permission('hr', '', 'delete')) {
            access_denied('hr');
        }
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model("emergency_contact_model");
        $response = $this->emergency_contact_model->delete_emergency_contacts($id);
        if ($response) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function update_emergency_contacts(){
        $this->load->model("emergency_contact_model");

        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }

        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->emergency_contact_model->update_emergency_contacts($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }
    /**
     * emergency_contacts view edit
     * @param  string $id
     * @return view
     */
    public function emergency_contacts_view_edit($id = '', $parent_id = '')
    {
        $this->load->model("emergency_contact_model");

        if (!has_permission('emergency_contacts', '', 'view')) {
            access_denied('emergency_contacts');
        }
        if ($id == '') {
            $title = _l('add_new', _l('emergency_contacts'));
        } else {

            $data['emergency_contacts'] = $this->emergency_contact_model->get($id);

            $this->load->view('hr_profile/hr_record/view_edit_emergency_contacts', $data);

        }

    }


    //bank_account
    public function json_bank_account($id){
        $this->load->model("bank_account_model");
        $data = $this->bank_account_model->get($id);
        echo json_encode($data);
    }
    public function add_bank_account(){
        if (!has_permission('hr', '', 'create')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $this->load->model("bank_account_model");
        $success = $this->bank_account_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_bank_account($id)
    {
        if (!has_permission('hr', '', 'delete')) {
            access_denied('hr');
        }
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model("bank_account_model");
        $response = $this->bank_account_model->delete($id);
        if ($response) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function update_bank_account(){
        $this->load->model("bank_account_model");

        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }

        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->bank_account_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }
    //**************
    /**
     * bank_account view edit
     * @param  string $id
     * @return view
     */
    public function bank_account_view_edit($id = '', $parent_id = '')
    {
        $this->load->model("bank_account_model");

        if (!has_permission('bank_account', '', 'view')) {
            access_denied('bank_account');
        }
        if ($id == '') {
            $title = _l('add_new', _l('bank_account'));
        } else {

            $data['bank_account'] = $this->bank_account_model->get($id);

            $this->load->view('hr_profile/hr_record/view_edit_BankAccount', $data);

        }

    }







//work_experience
    public function json_work_experience($id){
        $this->load->model("Work_experience_model");
        $data = $this->Work_experience_model->get($id);
        echo json_encode($data);
    }
    public function add_work_experience(){
        if (!has_permission('hr', '', 'create')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $data['from_date'] = to_sql_date($data['from_date']);
        $data['to_date'] = to_sql_date($data['to_date']);
        $this->load->model("Work_experience_model");
        $success = $this->Work_experience_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_work_experience($id)
    {
        if (!has_permission('hr', '', 'delete')) {
            access_denied('hr');
        }
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model("Work_experience_model");
        $response = $this->Work_experience_model->delete($id);
        if ($response) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function update_work_experience(){
        $this->load->model("Work_experience_model");

        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }

        $data = $this->input->post();
        $data['from_date'] = to_sql_date($data['from_date']);
        $data['to_date'] = to_sql_date($data['to_date']);
        $id = $this->input->post('id');
        $success = $this->Work_experience_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * work_experience view edit
     * @param  string $id
     * @return view
     */
    public function work_experience_view_edit($id = '', $parent_id = '')
    {
        $this->load->model("Work_experience_model");

        if (!has_permission('work_experience', '', 'view')) {
            access_denied('work_experience');
        }

            $data['work_experience'] = $this->Work_experience_model->get($id);

            $this->load->view('hr_profile/hr_record/view_edit_work_experience', $data);
    }

//qualification
    public function json_qualification($id){
        $this->load->model('hr_profile/Qualification_model');
        $data = $this->Qualification_model->get($id);
        echo json_encode($data);
    }
    public function update_qualification(){
        if (!has_permission('hr', '', 'edit')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $data['from_date'] = to_sql_date($data['from_date']);
        $data['to_date'] = to_sql_date($data['to_date']);
        $id = $this->input->post('id');
        $this->load->model('hr_profile/Qualification_model');
        $success = $this->Qualification_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_qualification(){
        if (!has_permission('hr', '', 'create')) {
            access_denied('hr');
        }
        $data = $this->input->post();
        $data['from_date'] = to_sql_date($data['from_date']);
        $data['to_date'] = to_sql_date($data['to_date']);
        $this->load->model('hr_profile/Qualification_model');
        $success = $this->Qualification_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_qualification($id)
    {
        if (!has_permission('hr', '', 'delete')) {
            access_denied('hr');
        }
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model('hr_profile/Qualification_model');
        $response = $this->Qualification_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * qualification view edit
     * @param  string $id
     * @return view
     */
    public function qualifications_view_edit($id = '', $parent_id = '')
    {
        $this->load->model("hr_profile/Qualification_model");

        if (!has_permission('qualification', '', 'view')) {
            access_denied('qualification');
        }

        $data['qualification'] = $this->Qualification_model->get($id);

        $this->load->view('hr_profile/hr_record/view_edit_qualification', $data);
    }
//type

    public function add_type($type_name){

        $enArray=array();
        if (option_exists($type_name) != Null){
            $enArray = json_decode(get_option($type_name));
        }else{
            $enArray=array();
        }
        if ($this->input->get()){
            $nameEn['key'] = $this->input->get('nameEn');
            $nameEn['value'] = $this->input->get('nameEn');
        }

        array_push($enArray,$nameEn );
        if (option_exists($type_name) != Null){
            $en = update_option($type_name,json_encode($enArray));
        }else{
            $en = add_option($type_name,json_encode($enArray));
        }

        $success = $en ?true:false;
        if($success){
            set_alert('success', _l('added_successfully'));
        }
        redirect($_SERVER['HTTP_REFERER']);

    }

    public function delete_type($name, $type_name)
    {
        if (!has_permission('settings', '', 'delete')) {
            access_denied('settings');
        }

        $enArray = json_decode(get_option($type_name));

        $new_array = [];

        $name = urldecode($name);

        foreach($enArray as $obj){
            if($obj->key == $name)
                continue;
            $new_array[] = $obj;
        }

        $success = update_option($type_name,json_encode($new_array));

        if($success){
            set_alert('success', _l('deleted_successfully'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update_type($type_name)
    {
        if (!has_permission('settings', '', 'delete')) {
            access_denied('settings');
        }

        $old = $this->input->get('old');
        $new = $this->input->get('new');

        $enArray = json_decode(get_option($type_name));

        $new_array = [];

        $old = urldecode($old);

        foreach($enArray as $obj){
            if($obj->key == $old)
                continue;
            $new_array[] = $obj;
        }

        update_option($type_name,json_encode($new_array));

        $enArray = $new_array;
        if ($this->input->get()){
            $nameEn['key'] = $this->input->get('new');
            $nameEn['value'] = $this->input->get('new');
        }

        array_push($enArray,$nameEn );
        if (option_exists($type_name) != Null){
            $en = update_option($type_name,json_encode($enArray));
        }else{
            $en = add_option($type_name,json_encode($enArray));
        }

        $success = $en ?true:false;
        if($success){
            set_alert('success', _l('updated_successfully'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_leave_type(){
        $data = $this->input->get();
        $success = $this->Leave_type_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

//immigration

    public function json_immigration($id){
        $this->load->model("hr_profile/Immigration_model");
        $data = $this->Immigration_model->get($id);
        echo json_encode($data);
    }
    public function update_immigration(){
        if (!has_permission('hr_profile', '', 'edit')) {
            access_denied('hr_profile');
        }
        $data = $this->input->post();
        $data['issue_date'] = to_sql_date($data['issue_date']);
        $data['date_expiry'] = to_sql_date($data['date_expiry']);
        $data['eligible_review_date'] = to_sql_date($data['eligible_review_date']);
        $id = $this->input->post('id');
        $this->load->model("hr_profile/Immigration_model");
        $success = $this->Immigration_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_immigration(){
        if (!has_permission('hr_profile', '', 'create')) {
            access_denied('hr_profile');
        }
        $data = $this->input->post();
        $data['issue_date'] = to_sql_date($data['issue_date']);
        $data['date_expiry'] = to_sql_date($data['date_expiry']);
        $data['eligible_review_date'] = to_sql_date($data['eligible_review_date']);
        $this->load->model("hr_profile/Immigration_model");
        $success = $this->Immigration_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_immigration($id)
    {
        if (!has_permission('hr_profile', '', 'delete')) {
            access_denied('hr_profile');
        }
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->load->model("hr_profile/Immigration_model");
        $response = $this->Immigration_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * immigration view edit
     * @param  string $id
     * @return view
     */
    public function immigrations_view_edit($id = '')
    {
        $this->load->model("hr_profile/immigration_model");

        if (!has_permission('immigration', '', 'view')) {
            access_denied('immigration');
        }

        $data['Immigration'] = $this->immigration_model->get($id);

        $this->load->view('hr_profile/hr_record/view_edit_Immigration', $data);
    }

    /**
     * delete contract template
     * @param  [type] $id
     * @return [type]
     */
    public function delete_contract_template_($id) {
        if (!$id) {
            redirect(admin_url('hr_profile/setting?group=contract_template'));
        }
        $response = $this->hr_profile_model->delete_contract_template($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('hr_is_referenced', _l('contract_template')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('contract_template')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('contract_template')));
        }
        redirect(admin_url('hr_profile/setting?group=contract_template'));
    }
    //*********OLD HR**********
    public function table_insurance()
    {

        $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/table_insurance'));

    }


    public function insurances(){

        $this->load->model('departments_model');
        $this->load->model('staff_model');
        $this->load->model('hrm_model');
        $this->load->model('Insurance_book_num_model');
        $this->load->model('Insurance_type_model');

        $data['month'] = $this->hrm_model->get_month();

        $data['title'] = _l('insurrance');
        $data['dep_tree'] = json_encode($this->hrm_model->get_department_tree());

        $this->load->view('hr_profile/insurance/manage_insurance', $data);
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
                    redirect(admin_url('hr_profile/insurances'));
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
                redirect(admin_url('hr_profile/insurances'));
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
        $this->load->view('hr_profile/insurance/insurance', $data);
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
    /**
	 * cancel request
	 * @return 
	 */
	public function cancel_request(){
		$data = $this->input->post();
		$success = false; 
		$message = '';
    $this->load->model('hr_profile/timesheets_model');
		$success = $this->timesheets_model->cancel_request($data);
		if($success == true){
			$message = _l('cancel_successful');
		}
		else{
			$message = _l('cancel_failed');            
		}
		echo json_encode([
			'success' => $success,
			'message' => $message
		]);
		die();      
	}
/**
	 * delete timesheets attachment file
	 * @param  int $attachment_id
	 * @return
	 */
	public function delete_timesheets_attachment_file($attachment_id)
	{
    $this->load->model('hr_profile/timesheets_model');
		$file = $this->misc_model->get_file($attachment_id);
		echo json_encode([
			'success' => $this->timesheets_model->delete_timesheets_attachment_file($attachment_id),
		]);
	}   
	
// insurance_book_num

    public function add_insurance_book_num(){
        $data = $this->input->post();
        $success = $this->insurance_book_num_model->add($data);
        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update_insurance_book_num(){
        $data = $this->input->post();
        $id = $this->input->post('id');
        $success = $this->insurance_book_num_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_insurance_book_num($id){
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $response = $this->insurance_book_num_model->delete($id);

        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function insurance_book_num_json($id){
        $data = $this->insurance_book_num_model->get($id);
        echo json_encode($data);
    }
    //leave
    public function timesheets_delete_bulk_action()
    {
      if (!is_staff_member()) {
        ajax_access_denied();
      }
 
      $total_deleted = 0;
 
      if ($this->input->post()) {
 
        $ids                   = $this->input->post('ids');
        $rel_type                   = $this->input->post('rel_type');
 
        /*check permission*/
        switch ($rel_type) {
          case 'timesheets_requisition':
          if (!has_permission('timesheets_manage_requisition', '', 'delete') && !is_admin()) {
            access_denied('manage_requisition');
          }
          break;
          default:
           # code...
          break;
        }
 
        /*delete data*/
        if ($this->input->post('mass_delete')) {
          if (is_array($ids)) {
            foreach ($ids as $id) {
 
              switch ($rel_type) {
                case 'timesheets_requisition':
                  $this->load->model('hr_profile/timesheets_model');
                if ($this->timesheets_model->delete_requisition($id)) {
                  $total_deleted++;
                  break;
                }else{
                  break;
                }
                default:
                   # code...
                break;
              }
 
 
            }
          }
 
          /*return result*/
          switch ($rel_type) {
            case 'timesheets_requisition':
            set_alert('success', _l('total_requisition'). ": " .$total_deleted);
            break;
            default:
             # code...
            break;
          }
        }
      }
    }
 
    public function get_remain_day_of($id){
      $html = '';
      $this->load->model('hr_profile/timesheets_model');
      $day_off = $this->timesheets_model->get_day_off($id);
      $number_day_off = 0;
      $days_off = 0;
      if($day_off != null){
        $number_day_off = $day_off->remain;
        if($number_day_off < 0){
          $number_day_off = 0;
        }
        $days_off = $day_off->days_off;
        if($days_off > $day_off->total){
          $days_off = $day_off->total;
        }
      }
      $valid_cur_date = $this->timesheets_model->get_next_shift_date($id, date('Y-m-d'));
      $html .= '<label class="control-label">'._l('number_of_days_off').': '.$days_off.'</label><br>';
      $html .= '<label class="control-label'.($number_day_off == 0 ? ' text-danger' : '').'">'._l('number_of_leave_days_allowed').': '.$number_day_off.'</label>';
      $html .= '<input type="hidden" name="number_day_off" value="'.$number_day_off.'">';
      echo json_encode([
        'html' => $html,
        'valid_date' => _d($valid_cur_date)
      ]);
      die;
    }
  
    
	/**
	 * send mail
	 * @return json
	 */
	public function send_mail()
	{
		if ($this->input->is_ajax_request()) {
			$data = $this->input->post();
			if((isset($data)) && $data != ''){
        $this->load->model('hr_profile/timesheets_model');
				$this->timesheets_model->send_mail($data, $data['addedfrom']);
				$success = 'success';
				echo json_encode([
					'success' => $success,                
				]); 
			}
		}
	}
    public function calculate_number_days_off(){
      $data = $this->input->post();
      $this->load->model('hr_profile/timesheets_model');
      $start_time = $this->timesheets_model->format_date($data['start_time']);
      $end_time = $this->timesheets_model->format_date($data['end_time']);
      $list_af_date = [];
      if($start_time != '' && $end_time != ''){
        if($start_time && $end_time){
          if(strtotime($start_time) <= strtotime($end_time)){
            $list_date = $this->timesheets_model->get_list_date($start_time, $end_time);
            foreach ($list_date as $key => $next_start_date) {
              $data_work_time = $this->timesheets_model->get_hour_shift_staff($data['staffid'], $next_start_date);
              $data_day_off = $this->timesheets_model->get_day_off_staff_by_date($data['staffid'], $next_start_date);
              if($data_work_time > 0 && count($data_day_off) == 0){
                $list_af_date[] = $next_start_date;
              }            
            }
          }
        }
      }
      $count = count($list_af_date);
      echo json_encode($count);
    }
  
/**
	 * requisition detail
	 * @param  int $id 
	 * @return view
	 */
	public function requisition_detail($id){
		if (!(has_permission('leave_management', '', 'view_own') || has_permission('leave_management', '', 'view') || is_admin())) {          
			access_denied('approval_process');
		}
		$send_mail_approve = $this->session->userdata("send_mail_approve");
		$data['has_send_mail'] = 0;
		if((isset($send_mail_approve)) && $send_mail_approve != ''){
			$data['send_mail_approve'] = $send_mail_approve;
			$data['has_send_mail'] = 1;
			$this->session->unset_userdata("send_mail_approve");
		}
    $this->load->model('hr_profile/timesheets_model');
		$data['request_leave'] = $this->timesheets_model->get_request_leave($id);
		$status_leave = $this->timesheets_model->get_number_of_days_off($data['request_leave']->staff_id);
		$day_off = $this->timesheets_model->get_day_off($data['request_leave']->staff_id);
		$data['number_day_off'] = 0;
		if($day_off != null){
			$data['number_day_off'] = $day_off->remain;
		}

		$leave_isset = $this->db->query('select * from '.db_prefix().'timesheets_requisition_leave')->result_array();
		$data['id'] = $id;
		$data['leave_isset'] = $leave_isset;
		$rel_type = '';
		if($data['request_leave']->rel_type == '1'){
			$rel_type = 'Leave';
		}elseif($data['request_leave']->rel_type == '2'){
			$rel_type = 'late';
		}elseif($data['request_leave']->rel_type == '3'){
			$rel_type = 'Go_out';
		}elseif($data['request_leave']->rel_type == '4'){
			$rel_type = 'Go_on_bussiness';
		}elseif($data['request_leave']->rel_type == '5'){
			$rel_type = 'quit_job'; 
		}elseif($data['request_leave']->rel_type == '6'){
			$rel_type = 'early'; 
		}
		$this->load->model('staff_model');

		if($data['request_leave']->rel_type == '4'){
      $this->load->model('hr_profile/timesheets_model');
			$data['advance_payment'] = $this->timesheets_model->get_go_bussiness_advance_payment($id);
		}

		$id_file = $this->db->query('select id from '.db_prefix().'files where rel_id ='.$id)->row();
		$data['id_file'] = $id_file;
		$data['rel_type'] = $rel_type;
		$data['list_staff'] = $this->staff_model->get();
    $this->load->model('hr_profile/timesheets_model');
		$data['check_approve_status'] = $this->timesheets_model->check_approval_details($id,$rel_type);
		$data['list_approve_status'] = $this->timesheets_model->get_list_approval_details($id,$rel_type);


		$this->load->view('hr_profile/requisition_detail', $data);
	}
  	/**
	 * delete requisition
	 * @param  int $id
	 * @return redirect
	 */
	public function delete_requisition($id)
	{
    $this->load->model('hr_profile/timesheets_model');
		$response = $this->timesheets_model->delete_requisition($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('is_referenced', _l('lead_source_lowercase')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('lead_source')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('lead_source_lowercase')));
		}
		redirect(admin_url('hr_profile/requisition_manage'));
	}
public function add_requisition_ajax(){
	if($_FILES['file']['name'] != ''){
		$_FILES = $_FILES;
	}else{
		unset($_FILES);
	}
	if ($this->input->post()) {
		$data = $this->input->post();
		unset($data['number_day_off']);
		if($data['rel_type'] == 1){
// 			$data['start_time'] = $data['start_time_s'] . ' ' . $data['start_time_s_time'];
// 			$data['end_time'] = $data['end_time_s'] . ' ' . $data['end_time_s_time'];
      $this->load->model('hr_profile/timesheets_model');
		$data['end_time'] = $this->timesheets_model->format_date_time($data['end_time']);
		}
		else{
			// $data['start_time'] = $this->timesheets_model->format_date_time($data['start_time_s']);
			$data['start_time'] = $data['start_time_s'] . ' ' . $data['start_time_s_time'];
// 			$data['end_time'] = $data['end_time_s'] . ' ' . $data['end_time_s_time'];

  $data['end_time'] = $this->timesheets_model->format_date_time($data['end_time_s']);
		}

		unset($data['start_time_s']);
    unset($data['start_time_s_time']);
		unset($data['end_time_s']);
				unset($data['end_time_s_time']);

		if(!isset($data['staff_id'])){
			$data['staff_id'] = get_staff_user_id();
		}
		if(isset($data['according_to_the_plan'])){
			$data['according_to_the_plan'] = 0;
		}
		$result = $this->timesheets_model->add_requisition_ajax($data);
        //  echo json_encode(['status'=>$result]);
			$rel_type = '';
			if($data['rel_type'] == '1'){
				$rel_type = 'Leave';
			}elseif($data['rel_type'] == '2'){
				$rel_type = 'late';
			}elseif($data['rel_type'] == '3'){
				$rel_type = 'Go_out';
			}elseif($data['rel_type'] == '4'){
				$rel_type = 'Go_on_bussiness';
			}elseif($data['rel_type'] == '5'){
				$rel_type = 'quit_job'; 
			}elseif($data['rel_type'] == '6'){
				$rel_type = 'early'; 
			}
			$data_app['rel_id'] = $result;
			$data_app['rel_type'] = $rel_type;
			$data_app['addedfrom'] = $data['staff_id'];
			$check_proccess = $this->timesheets_model->get_approve_setting($rel_type, false, $data['staff_id']);
			$check = '';
			if($check_proccess){
				if($check_proccess->choose_when_approving == 0){
					$this->timesheets_model->send_request_approve($data_app, $data['staff_id']);
					$data_new = [];
					$data_new['send_mail_approve'] = $data;
					$this->session->set_userdata($data_new);
					$check = 'not_choose';
				}else{
					$check = 'choose';
				}
			}else{
				$check = 'no_proccess';
			}

			$followers_id = $data['followers_id'];
			$staffid = $data['staff_id'];
			$subject = $data['subject'];
			$link = 'hr_profile/requisition_detail/' . $result;



			if($followers_id != ''){
				if ($staffid != $followers_id) {
					$notification_data = [
						'description' => _l('you_are_added_to_follow_the_leave_application').'-'.$subject,
						'touserid'    => $followers_id,
						'link'        => $link,
					];

					$notification_data['additional_data'] = serialize([
						$subject,
					]);

					if (add_notification($notification_data)) {
						pusher_trigger_notification([$followers_id]);
					}

				}
			}
			redirect(admin_url('hr_profile/requisition_detail/'.$result.'?check='.$check));
		}else{
			redirect(admin_url('hr_profile/requisition_manage'));
		}        
	}

  /**
	 * table registration leave
	 * @return 
	 */


  /**
     * table type of leave
     * @return
     */
    public function table_type_of_leave()
    {
        $this->app->get_table_data(module_views_path('hr_profile', 'timekeeping/table_type_of_leave'));
    }

    public function type_of_leave(){
	    $data = $this->input->post();
      $this->load->model("hr_profile/Timesheets_model");
	    $success = $this->Timesheets_model->add_type_of_leave($data);
	    if($success){
            set_alert('success', _l('added_successfully'));
        }else{
            set_alert('warning', _l('fail'));
        }
        redirect(admin_url('hr_profile/requisition_manage?tab=type_of_leave'));
    }
  /**
     * table additional timesheets
     * @return
     */
    public function table_additional_timesheets()
    {
        $this->app->get_table_data(module_views_path('hr_profile', 'timekeeping/table_additional_timesheets'));
    }

/**
	 * requisition manage
	 * @return view
	 */
	public function requisition_manage(){
		if (!(has_permission('leave_management', '', 'view_own') || has_permission('leave_management', '', 'view') || is_admin())) {          
// 			access_denied('approval_process');
		}
		$send_mail_approve = $this->session->userdata("send_mail_approve");
		if((isset($send_mail_approve)) && $send_mail_approve != ''){
			$data['send_mail_approve'] = $send_mail_approve;
			$this->session->unset_userdata("send_mail_approve");
		}
     $this->load->model('hr_profile/timesheets_model');
		$status_leave = $this->timesheets_model->get_number_of_days_off();
		$day_off = $this->timesheets_model->get_day_off();
		$data['number_day_off'] = 0;
		$data['days_off'] = 0;
		if($day_off != null){
			$data['number_day_off'] = $day_off->remain;
			if($data['number_day_off'] < 0){
				$data['number_day_off'] = 0;
			}
			$data['days_off'] = $day_off->days_off;
			if($data['days_off'] > $day_off->total){
				$data['days_off'] = $day_off->total;
			}
		}
    $this->load->model('hr_profile/timesheets_model');
		$data['data_timekeeping_form'] = $this->timesheets_model->get_timesheets_option('timekeeping_form');
		$this->load->model('departments_model');
		$data['departments'] = $this->departments_model->get();
		$data['current_date'] = date('Y-m-d H:i:s');
    $this->load->model('hr_profile/Timesheets_model');
		$status_leave = $this->timesheets_model->get_option_val();
		$this->load->model('staff_model');
		$data['pro'] = $this->staff_model->get();
		$data['userid'] = get_staff_user_id();
		$data['tab'] = $this->input->get('tab');
		$data['title'] = _l('leave');
    $this->load->model('hr_profile/timesheets_model');
		$data['additional_timesheets_id'] = $this->input->get('additional_timesheets_id');
		$data['additional_timesheets'] = $this->timesheets_model->get_additional_timesheets();
		$this->load->view('hr_profile/timekeeping/manage_requisition_hrm', $data);
	}
    /**
     * delete additional timesheets
     * @param  int $id
     * @return redirect
     */
    public function delete_additional_timesheets($id)
    {
      $this->load->model('hr_profile/timesheets_model');
        $response = $this->timesheets_model->delete_additional_timesheets($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced'));
        } elseif ($response == true) {
            set_alert('success', _l('deleted'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect(admin_url('hr_profile/requisition_manage?tab=additional_timesheets'));
    }
    /**
     * delete type of leave
     * @param  int $id
     * @return redirect
     */
    public function delete_type_of_leave($id)
    {
      $this->load->model('hr_profile/timesheets_model');
        $response = $this->timesheets_model->delete_type_of_leave($id);
        if ($response == true) {
            set_alert('success', _l('deleted'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect(admin_url('hr_profile/requisition_manage?tab=type_of_leave'));
    }


  /**
	 * send additional timesheets
	 * @return redirect
	 */
	public function send_additional_timesheets(){
		$data = $this->input->post();
		$success = false;
		if(isset($data['additional_day'])){
      $this->load->model('hr_profile/timesheets_model');
			$check_latch_timesheet = $this->timesheets_model->check_latch_timesheet(date('m-Y',strtotime(to_sql_date($data['additional_day']))));
			if($check_latch_timesheet){
				set_alert('danger',_l('timekeeping_latched'));
				redirect(admin_url('hr_profile/member/'.get_staff_user_id().'?tab=timekeeping'));
			}
      $this->load->model('hr_profile/timesheets_model');
			$success = $this->timesheets_model->add_additional_timesheets($data);
		}
		if($success){
			set_alert('success', _l('added_successfully', _l('additional_timesheets')));
		}else{
			set_alert('warning', _l('fail'));
		}
		redirect(admin_url('hr_profile/requisition_manage?tab=additional_timesheets&additional_timesheets_id='.$success));
	}

  public function get_data_type_of_leave($id){
    $this->load->model('hr_profile/timesheets_model');
    $type_of_leave = $this->timesheets_model->get_type_of_leave($id);
    $staffid= $type_of_leave->staff_id_manage_depart;
    $staffid2=$type_of_leave->staff_id_manager_hr;
    $staffid3=$type_of_leave->staff_id_director_general;
    
    $manage= $this->timesheets_model->get_staff_by_id($staffid);
    $manager= $this->timesheets_model->get_staff_by_id($staffid2);
    $director= $this->timesheets_model->get_staff_by_id($staffid3);


    $html ='

<div class="modal-dialog" style="width: 55%">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">
<span>'. _l('type_of_leave') .'</span>
</h4>
</div>
<div class="modal-body">';

    $html .= '<div class="col-md-12">';
    if(!empty($type_of_leave)){
        $html .= '<table class="table border table-striped margin-top-0">
<tbody>
<tr class="project-overview">
<td class="bold">'. _l('name') .'</td>
<td>'. ($type_of_leave->name).'</td>
</tr>
<td class="bold">'. _l('code') .'</td>
<td>'. ($type_of_leave->code).'</td>
</tr>
<tr class="project-overview">
<td class="bold">'. _l('number_of_days') .'</td>
<td>'. $type_of_leave->number_of_days.'</td>
</tr>
<tr class="project-overview">
<td class="bold">'. _l('entitlement_in_months') .'</td>
<td>'. $type_of_leave->entitlement_in_months.'</td>
</tr>
';
        $is_deserving_salary = $type_of_leave->is_deserving_salary == 1 ? _l("yes") : _l("no");

        $html .= '  <tr class="project-overview">
<td class="bold" width="30%">'. _l('is_deserving_salary') .'</td>
<td>'.$is_deserving_salary.'</td>
</tr>
<tr class="project-overview">
<td class="bold" width="30%">'. _l('salary_type') .'</td>
<td>'._l($type_of_leave->salary_type).'</td>
</tr>';
        $salary_allocation = $type_of_leave->salary_allocation == true ? _l("yes") : _l("no");

        $html .= '  <tr class="project-overview">
<td class="bold" width="30%">'. _l('salary_allocation') .'</td>
<td>'.$salary_allocation.'</td>
</tr>';
        $allow_substitute_employee = $type_of_leave->allow_substitute_employee == 1 ? _l("yes") : _l("no");

        $html .= '  <tr class="project-overview">
<td class="bold" width="30%">'. _l('allow_substitute_employee') .'</td>
<td>'.$allow_substitute_employee.'</td>
</tr>
<td class="bold">'. _l('manage_depart') .'</td>
<td>'. ($manage->firstname).' '. ($manage->lastname).'</td>

</tr>
<td class="bold">'. _l('manager_hr') .'</td>
<td>'. ($manager->firstname).' '. ($manager->lastname).'</td>
</tr>
<td class="bold">'. _l('director_general') .'</td>
<td>'. ($director->firstname).' '. ($director->lastname).'</td>
</tr>
<td class="bold">'. _l('Is There an accumulative ?') .'</td>
<td>'. _l($type_of_leave->accumulative).'</td>
</tr>
</tbody>
</table>';
    }
    $html .='
<div class="modal-footer">';



    $html .= '</div></div>
</div>


<div class="clearfix"></div>
</div>
</div>';
    echo json_encode([
        'html' => $html,
    ]);
    die();
}

public function get_data_additional_timesheets($id){
  $this->load->model('hr_profile/timesheets_model');
	$check_approve_status = $this->timesheets_model->check_approval_details($id,'additional_timesheets');
	$list_approve_status = $this->timesheets_model->get_list_approval_details($id,'additional_timesheets');
	$additional_timesheets = $this->timesheets_model->get_additional_timesheets($id);

	$html ='
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">
	<span>'. _l('additional_timesheets') .'</span>
	</h4>
	</div>
	<div class="modal-body">';

	$html .= '<div class="col-md-12">';
	if($additional_timesheets){
		$status_class = 'info';
		$status_text = 'status_0';
		if($additional_timesheets->status == 1){
			$status_class = 'success';
			$status_text = 'status_1';
		}elseif ($additional_timesheets->status == 2) {
			$status_class = 'danger';
			$status_text = 'status_-1';
		}

		$creator = '';
		if(isset($additional_timesheets->creator)){
			$creator = '<a href="' . admin_url('staff/profile/' . $additional_timesheets->creator) . '">' . staff_profile_image($additional_timesheets->creator, [
				'staff-profile-image-small',
			]) . '</a> <a href="' . admin_url('staff/profile/' . $additional_timesheets->creator) . '">' . get_staff_full_name($additional_timesheets->creator) . '</a>';
		}
		$html .= '<table class="table border table-striped margin-top-0">
		<tbody>
		<tr class="project-overview">
		<td class="bold" width="30%">'. _l('creator') .'</td>
		<td><a href="' . admin_url('staff/profile/' . $additional_timesheets->creator) . '">' . staff_profile_image($additional_timesheets->creator, [
			'staff-profile-image-small',
			]) . '</a> <a href="' . admin_url('staff/profile/' . $additional_timesheets->creator) . '">' . get_staff_full_name($additional_timesheets->creator) . '</a>
		</td>
		</tr>
		<tr class="project-overview">
		<td class="bold" width="30%">'. _l('status') .'</td>
		<td><span class="label label-'. $status_class .' mr-1 mb-1 mt-1">'. _l($status_text) .'</span></td>
		</tr>
		<tr class="project-overview">
		<td class="bold">'. _l('additional_day') .'</td>
		<td>'. _d($additional_timesheets->additional_day).'</td>
		</tr>
		<tr class="project-overview">
		<td class="bold">'. _l('time_in') .'</td>
		<td>'. $additional_timesheets->time_in.'</td>
		</tr>
		<tr class="project-overview">
		<td class="bold">'. _l('time_out') .'</td>
		<td>'. $additional_timesheets->time_out.'</td>
		</tr>
		';

		$html .= '  <tr class="project-overview">
		<td class="bold" width="30%">'. _l('timekeeping_value') .'</td>
		<td>'.$additional_timesheets->timekeeping_value.'</td>
		</tr>
		<tr class="project-overview">
		<td class="bold" width="30%">'. _l('reason_') .'</td>
		<td>'.$additional_timesheets->reason.'</td>
		</tr>
		</tbody>
		</table>';
	}
	$html .='
	<p class="bold margin-top-15">'._l('approval_infor').'</p>
	<hr class="border-0-5" /><div>

	<div class="project-overview-right">';
	if(count($list_approve_status) > 0){

		$html .= '<div class="row">
		<div class="col-md-12 project-overview-expenses-finance">';

		$this->load->model('staff_model');
		$enter_charge_code = 0;
		foreach ($list_approve_status as $value) {
			$value['staffid'] = explode(', ',$value['staffid']);

			$html .= '<div class="col-md-6" class="font-15">
			<p class="text-uppercase text-muted no-mtop bold">';
			$staff_name = '';
			foreach ($value['staffid'] as $key => $val) {
				if($staff_name != '')
				{
					$staff_name .= ' or ';
				}
				$staff_name .= $this->staff_model->get($val)->firstname;
			}
			$html .=  $staff_name.'</p>';

			if($value['approve'] == 1){
				$html .= '<img src="'.site_url(TIMESHEETS_PATH.'approval/approved.png').'" class="wh-150-80">';
				$html .= '<br><br>  
				<p class="bold text-center text-success">'. _dt($value['date']).'</p> 
				';

			}elseif($value['approve'] == 2){
				$html .= '<img src="'.site_url(TIMESHEETS_PATH.'approval/rejected.png').'" class="wh-150-80">';
				$html .= '<br><br>  
				<p class="bold text-center text-danger">'. _dt($value['date']).'</p> 
				';
			}
			$html .= '</div>';
		}
		$html .= '</div></div>';
	}

	$html .=  '</div>
	<div class="clearfix"></div></br>
	<div class="modal-footer">';
  $this->load->model('hr_profile/timesheets_model');
	$check_proccess = $this->timesheets_model->get_approve_setting('additional_timesheets', false);
	$check = '';
	if($check_proccess){
		if($check_proccess->choose_when_approving == 0){
			$check = 'not_choose';
		}else{
			$check = 'choose';
		}
	}else{
		$check = 'no_proccess';
	}

	if($additional_timesheets->status == 0 && ($check_approve_status == false || $check_approve_status == 'reject')){
		if($check != 'choose'){
			$html .= '<a data-toggle="tooltip" data-loading-text="'._l('wait_text').'" class="btn btn-success lead-top-btn lead-view" data-placement="top" href="#" onclick="send_request_approve('.$additional_timesheets->id.','.$additional_timesheets->creator.'); return false;">'. _l('send_request_approve').'</a>';
		}

		if($check == 'choose'){
			$this->load->model('staff_model');
			$list_staff = $this->staff_model->get();
			$html .= '<div class="row"><div class="row"><div class="col-md-7"><select name="approver_c" class="selectpicker" data-live-search="true" id="approver_c" data-width="100%" data-none-selected-text="'. _l('please_choose_approver').'" required>';
			$current_user = get_staff_user_id();
			foreach($list_staff as $staff){
				if($staff['staffid'] != $current_user || is_admin()){
					$html .= '<option value="'.$staff['staffid'].'">'.$staff['staff_identifi'].' - '.$staff['firstname'].' '.$staff['lastname'].'</option>';
				}
			}
			$html .= '</select></div>';
			$html .= '<div class="col-md-5"><a href="#" class="btn btn-default pull-right mleft15" data-toggle="modal" data-target=".additional-timesheets-sidebar">'. _l('close') .'</a>';
			$html .= '<a href="#" onclick="choose_approver('.$additional_timesheets->id.','.$additional_timesheets->creator.');" class="btn btn-success lead-top-btn lead-view pull-right" data-loading-text="'._l('wait_text').'">'._l('choose').'</a></div></div></div>';

		}
	}
	if(isset($check_approve_status['staffid'])){
		if(in_array(get_staff_user_id(), $check_approve_status['staffid'])){
			$html .= '<div class="btn-group pull-left" >
			<a href="#" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'. _l('approve').'<span class="caret"></span></a>
			<ul class="dropdown-menu dropdown-menu-left wh-500-190">
			<li>
			<div class="col-md-12">
			'.render_textarea('reason', 'reason').'
			</div>
			</li>
			<li>
			<div class="row text-right col-md-12">
			<a href="#" data-loading-text="'._l('wait_text').'" onclick="approve_request('.$additional_timesheets->id.',\'additional_timesheets\'); return false;" class="btn btn-success margin-left-right-15">'. _l('approve').'</a>
			<a href="#" data-loading-text="'._l('wait_text').'" onclick="deny_request('. $additional_timesheets->id.',\'additional_timesheets\'); return false;" class="btn btn-warning">'._l('deny').'</a>
			</div>
			</li>
			</ul>
			</div>';
		}
	}
	if($check != 'choose'){
		$html .= '<a href="#" class="btn btn-default pull-right" data-toggle="modal" data-target=".additional-timesheets-sidebar">'. _l('close') .'</a>';
	}

	$html .= '</div></div>
	</div>


	<div class="clearfix"></div>
	</div>
	</div>';
	echo json_encode([
		'html' => $html,
	]);
	die();
}
/**
	 * approve request
	 * @return json
	 */
	public function approve_request(){
		$data = $this->input->post();
		$data['staff_approve'] = get_staff_user_id();
		$success = false; 
		$code = '';
		$status_string = 'status_'.$data['approve'];
		$message = '';
    $this->load->model('hr_profile/timesheets_model');
		$check_approve_status = $this->timesheets_model->check_approval_details($data['rel_id'], $data['rel_type']);
		if(isset($data['approve']) && in_array(get_staff_user_id(), $check_approve_status['staffid'])){
			$success = $this->timesheets_model->update_approval_details($check_approve_status['id'], $data);
			$message = _l('approved_successfully');
			if ($success) {
				if($data['approve'] == 1){
					$message = _l('approved_successfully');
					$data_log = [];
					$data_log['note'] = "approve_request";
					$check_approve_status = $this->timesheets_model->check_approval_details($data['rel_id'],$data['rel_type']);
					if ($check_approve_status === true){
						$this->timesheets_model->update_approve_request($data['rel_id'],$data['rel_type'], 1);
						if($data['rel_type'] == 'quit_job'){
							$this->load->model('staff_model');

							$this->db->where('id',$data['rel_id']);
							$requisition =  $this->db->get(db_prefix().'timesheets_requisition_leave')->row();
							if($requisition){
								$data_quitting_work=[];
								$staff = $this->staff_model->get($requisition->staff_id);
								if($staff){
									$department = $this->departments_model->get_staff_departments($requisition->staff_id);
									$role_name = $this->roles_model->get($requisition->staff_id);
									$data_quitting_work['staffs'] =  array('0' => $requisition->staff_id, );
									$data_quitting_work['email'] = $staff->email;
									$data_quitting_work['department'] = '';
									$data_quitting_work['role'] = '';
									if(count($department) > 0){
										$data_quitting_work['department'] = $department[0]['name'];
									}
									if($role_name){
										$data_quitting_work['role'] = $role_name->name;
									}      $this->load->model('hr_profile/timesheets_model');

									$this->timesheets_model->add_tbllist_staff_quitting_work($data_quitting_work);
								}
							}


						}

					}
				}else{
					$message = _l('rejected_successfully');   
          $this->load->model('hr_profile/timesheets_model');                 
					$this->timesheets_model->update_approve_request($data['rel_id'],$data['rel_type'], 2);
				}
			}
		}

		$data_new = [];
		$data_new['send_mail_approve'] = $data;
		$this->session->set_userdata($data_new);
		echo json_encode([
			'success' => $success,
			'message' => $message,
		]);
		die();      
	}
  /**
	 * get date leave 
	 * @return date
	 */
	public function get_date_leave(){
		$data = $this->input->post();
		$staffid = $data['staffid'];
		$number_of_days = $data['number_of_days'];
		$start_date = date('Y-m-d');    
    $this->load->model('hr_profile/timesheets_model');        
		if(!$this->timesheets_model->check_format_date_ymd($data['startdate'])){
			$start_date = to_sql_date($data['startdate']);
		}else{
			$start_date = $data['startdate'];            
		}
		$ceiling_number_of_days = ceil($number_of_days);

		$list_date = [];
		$i = 0; 
		while(count($list_date) != $ceiling_number_of_days) {

			$next_start_date = date('Y-m-d', strtotime($start_date .' +'.$i.' day'));
			$data_work_time = $this->timesheets_model->get_hour_shift_staff($staffid, $next_start_date);
			$data_day_off = $this->timesheets_model->get_day_off_staff_by_date($staffid, $next_start_date);
			if($data_work_time > 0 && count($data_day_off) == 0){
				$list_date[] = $next_start_date;
			}
			$i++;
			if($i > 100){
				break;
			}
		}
		$end_date = ($list_date[count($list_date) - 1]);
		echo json_encode([
			'end_date' => _d($end_date)
		]);
		die;    
	}
  /**
	 * send request approve
	 * @return json
	 */
	public function send_request_approve(){
		$data = $this->input->post();
		$message = 'Send request approval fail';
    $this->load->model('hr_profile/timesheets_model');
		$check = $this->timesheets_model->check_choose_when_approving($data['rel_type']);
		if($check == 0){
			$success = $this->timesheets_model->send_request_approve($data);
			if ($success === true) {                
				$message = _l('send_request_approval_success');
				$data_new = [];
				$data_new['send_mail_approve'] = $data;
				$this->session->set_userdata($data_new);
			}elseif($success === false){
				$message = _l('no_matching_process_found');
				$success = false;
				
			}else{
				$message = _l('could_not_find_approver_with', _l($success));
				$success = false;
			}
			echo json_encode([
				'type' => 'choose',
				'success' => $success,
				'message' => $message,
			]); 
			die;
		}else{
			$this->load->model('staff_model');
			$list_staff = $this->staff_model->get();

			$html = '<div class="col-md-12">';
			$html .= '<div class="col-md-9"><select name="approver_c" class="selectpicker" data-live-search="true" id="approver_c" data-width="100%" data-none-selected-text="'. _l('please_choose_approver').'" required> 
			<option value=""></option>'; 
			foreach($list_staff as $staff){ 
				$html .= '<option value="'.$staff['staffid'].'">'.$staff['firstname'].' '.$staff['lastname'].'</option>';                  
			}
			$html .= '</select></div>';
			if($data['rel_type'] == 'additional_timesheets'){
				$html .= '<div class="col-md-3"><a href="#" onclick="choose_approver('.$data['rel_id'].','.$data['addedfrom'].');" class="btn btn-success lead-top-btn lead-view" data-loading-text="'._l('wait_text').'">'._l('choose').'</a></div>';
			}else{
				$html .= '<div class="col-md-3"><a href="#" onclick="choose_approver();" class="btn btn-success lead-top-btn lead-view" data-loading-text="'._l('wait_text').'">'._l('choose').'</a></div>';
			}
			$html .= '</div>';

			echo json_encode([
				'type' => 'not_choose',
				'html' => $html,
				'message' => _l('please_choose_approver'),
			]);
		}
	}
/**
 * choose approver
 * @return json
 */
public function choose_approver(){
	$data = $this->input->post();
	$message = 'Send request approval fail';
  $this->load->model('hr_profile/timesheets_model');
	$success = $this->timesheets_model->choose_approver($data);
	if ($success === true) {                
		$message = 'Send request approval success';
		$data_new = [];
		$data_new['send_mail_approve'] = $data;
		$this->session->set_userdata($data_new);
	}elseif($success === false){
		$message = _l('no_matching_process_found');
		$success = false;

	}else{
		$message = _l('could_not_find_approver_with', _l($success));
		$success = false;
	}
	echo json_encode([
		'type' => 'choose',
		'success' => $success,
		'message' => $message,
	]); 
	die;

}


	 /**
	 * @return view
	 */
  public function timekeeping_data(){
    if (!(has_permission('attendance_management', '', 'view_own') || has_permission('attendance_management', '', 'view') || is_admin())) {          
      access_denied('timekeeping');
    }
    $this->load->model('hr_profile/timesheets_model');
    $this->load->model('staff_model');
    $data['title']                 = _l('timesheets');        
    $days_in_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
    $month      = date('m');
    $month_year = date('Y');

    $data['check_latch_timesheet'] = $this->timesheets_model->check_latch_timesheet(date('m-Y'));

    $data['departments'] = $this->departments_model->get();
    $data['staffs_li'] = $this->staff_model->get();
    $data['roles']         = $this->roles_model->get();
    $data['positions'] = $this->roles_model->get();

    $data['day_by_month_tk'] = [];
    $data['day_by_month_tk'][] = _l('staff_id');
    $data['day_by_month_tk'][] = _l('staff');

    $data['set_col_tk'] = [];
    $data['set_col_tk'][] = ['data' => _l('staff_id'), 'type' => 'text'];
    $data['set_col_tk'][] = ['data' => _l('staff'), 'type' => 'text','readOnly' => true,'width' => 200];

    for ($d = 1; $d <= $days_in_month; $d++) {
      $time = mktime(12, 0, 0, $month, $d, $month_year);
      if (date('m', $time) == $month) {
        array_push($data['day_by_month_tk'], date('D d', $time));
        array_push($data['set_col_tk'],[ 'data' => date('D d', $time), 'type' => 'text']);
      }
    }

    $data['day_by_month_tk'] = json_encode($data['day_by_month_tk']);
    $data_map = [];
    $data_timekeeping_form = get_timesheets_option('timekeeping_form');
    $data_timekeeping_manually_role = get_timesheets_option('timekeeping_manually_role');
    $data['data_timekeeping_form'] = $data_timekeeping_form;
    $data['staff_row_tk'] = [];
    $staffs = $this->timesheets_model->get_staff_timekeeping_applicable_object();
    $data['staffs_setting'] = $this->staff_model->get();
    $data['staffs'] = $staffs;


    if($data_timekeeping_form == 'timekeeping_task' && $data['check_latch_timesheet'] == false){
      foreach($staffs as $s){
        $ts_date = '';
        $ts_ts = '';
        $result_tb = [];
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-t');
        $staffsTasksWhere = [];
        if($from_date != '' && $to_date != ''){
          $staffsTasksWhere = 'IF(duedate IS NOT NULL,((startdate <= "'.$from_date.'" and duedate >= "'.$from_date.'") or (startdate <= "'.$to_date.'" and duedate >= "'.$to_date.'") or (startdate > "'.$to_date.'" and duedate < "'.$from_date.'")), IF(datefinished IS NOT NULL,IF(status = 5 ,((startdate <= "'.$from_date.'" and date_format(datefinished, "%Y-%m-%d") >= "'.$from_date.'") or (startdate <= "'.$to_date.'" and date_format(datefinished, "%Y-%m-%d") >= "'.$to_date.'") or (startdate > "'.$to_date.'" and date_format(datefinished, "%Y-%m-%d") < "'.$from_date.'")), (startdate <= "'.$from_date.'" or (startdate > "'.$from_date.'" and startdate <= "'.$to_date.'"))),(startdate <= "'.$from_date.'" or (startdate > "'.$from_date.'" and startdate <= "'.$to_date.'"))))';
        }
        $staff_task = $this->tasks_model->get_tasks_by_staff_id($s['staffid'], $staffsTasksWhere);   
        $list_in_out = [];
        foreach ($staff_task as $key_task => $task) {                    
          $list_taskstimers = $this->timesheets_model->get_taskstimers($task['id'], $s['staffid']);
          foreach ($list_taskstimers as $taskstimers) {
            $list_date = $this->timesheets_model->get_list_date(date('Y-m-d',$taskstimers['start_time']), date('Y-m-d',$taskstimers['end_time']));
            foreach ($list_date as $curent_date) {
              $start_work_time = "";
              $end_work_time = "";
              $data_shift_list = $this->timesheets_model->get_shift_work_staff_by_date($s['staffid'], $curent_date);

              foreach ($data_shift_list as $ss) {
                $data_shift_type = $this->timesheets_model->get_shift_type($ss); 
                if($start_work_time == "" || strtotime($start_work_time) > strtotime($curent_date.' '.$data_shift_type->time_start_work.':00')){
                  $start_work_time = $curent_date.' '.$data_shift_type->time_start_work.':00';
                }
                if($end_work_time == "" || strtotime($end_work_time) < strtotime($curent_date.' '.$data_shift_type->time_end_work.':00')){
                  $end_work_time = $curent_date.' '.$data_shift_type->time_end_work.':00';
                }
              } 


              if(strtotime($start_work_time) < strtotime($curent_date.' '.date('H:i:s',$taskstimers['start_time']))){
                $start_work_time = $curent_date.' '.date('H:i:s',$taskstimers['start_time']);
              }
              if(strtotime($end_work_time) > strtotime($curent_date.' '.date('H:i:s',$taskstimers['end_time'])) && strtotime(date('Y-m-d',$taskstimers['end_time'])) == strtotime($curent_date)){
                $end_work_time = $curent_date.' '.date('H:i:s',$taskstimers['end_time']);
              }
              if(strtotime($from_date) <= strtotime(date('Y-m-d',strtotime($start_work_time))) && strtotime($to_date) >= strtotime(date('Y-m-d',strtotime($start_work_time)))){
                if(isset($list_in_out[date('Y-m-d',strtotime($start_work_time))]['in'])){
                  if(strtotime($list_in_out[date('Y-m-d',strtotime($start_work_time))]['in']) > strtotime($start_work_time)){
                    $list_in_out[date('Y-m-d',strtotime($start_work_time))]['in'] = $start_work_time;
                  }
                }else{
                  $list_in_out[date('Y-m-d',strtotime($start_work_time))]['in'] = $start_work_time;    
                }



                if(isset($list_in_out[date('Y-m-d',strtotime($start_work_time))]['out'])){
                  if(strtotime($list_in_out[date('Y-m-d',strtotime($start_work_time))]['out']) < strtotime($start_work_time)){
                    $list_in_out[date('Y-m-d',strtotime($start_work_time))]['out'] = $start_work_time;
                  }
                }else{
                  $list_in_out[date('Y-m-d',strtotime($start_work_time))]['out'] = $start_work_time;
                }
              }

              if(strtotime($from_date) <= strtotime(date('Y-m-d',strtotime($end_work_time))) && strtotime($to_date) >= strtotime(date('Y-m-d',strtotime($end_work_time)))){
                if(isset($list_in_out[date('Y-m-d',strtotime($end_work_time))]['in'])){
                  if(strtotime($list_in_out[date('Y-m-d',strtotime($end_work_time))]['in']) >strtotime($end_work_time)){
                    $list_in_out[date('Y-m-d',strtotime($end_work_time))]['in'] = $end_work_time;
                  }
                }else{
                  $list_in_out[date('Y-m-d',strtotime($end_work_time))]['in'] = $end_work_time;
                }

                if(isset($list_in_out[date('Y-m-d',strtotime($end_work_time))]['out'])){
                  if(strtotime($list_in_out[date('Y-m-d',strtotime($end_work_time))]['out']) <strtotime($end_work_time)){
                    $list_in_out[date('Y-m-d',strtotime($end_work_time))]['out'] = $end_work_time;
                  }
                }else{
                  $list_in_out[date('Y-m-d',strtotime($end_work_time))]['out'] = $end_work_time;
                }
              }
            }

          }
        }
        foreach ($list_in_out as $date_ => $in_out) {                    
          $vl = $this->timesheets_model->get_data_insert_timesheets($s['staffid'], $in_out['in'], $in_out['out']);
          if(!isset($data_map[$s['staffid']][$date_]['ts'])){
            $data_map[$s['staffid']][$date_]['date'] = date('D d', strtotime($date_));
            $data_map[$s['staffid']][$date_]['ts'] = '';
          }
          if($vl['late'] > 0){
            $data_map[$s['staffid']][$date_]['ts'] .= 'L:'.$vl['late'].'; ';
          }
          if($vl['early'] > 0){
            $data_map[$s['staffid']][$date_]['ts'] .= 'E:'.$vl['early'].'; ';
          }
          if($vl['work'] > 0){
            $data_map[$s['staffid']][$date_]['ts'] .= 'W:'.$vl['work'].'; ';
          }
          $data_map[$s['staffid']][$date_]['ts'] = rtrim($data_map[$s['staffid']][$date_]['ts'], '; ');
        }

        if(isset($data_map[$s['staffid']])){
          foreach ($data_map[$s['staffid']] as $key => $value) {                        
            $ts_date = $data_map[$s['staffid']][$key]['date'];
            $ts_ts =  $data_map[$s['staffid']][$key]['ts'];
            $result_tb[] = [$ts_date => $ts_ts];
          }
        }

        $dt_ts = [];
        $dt_ts = [_l('staff_id') => $s['staffid'],_l('staff') => $s['firstname'].' '.$s['lastname']];
        $note = [];
        $list_dtts = [];
        foreach ($result_tb as $key => $rs) {
          foreach ($rs as $day => $val) {
            $list_dtts[$day] = $val;
          }
        }
        $list_date = $this->timesheets_model->get_list_date(date('Y-m-01'), date('Y-m-t'));
        foreach ($list_date as $key => $value) {
          $date_s = date('D d', strtotime($value));
          $max_hour = $this->timesheets_model->get_hour_shift_staff($s['staffid'],$value);
          $check_holiday = $this->timesheets_model->check_holiday($s['staffid'], $value);
          $result_lack = '';
          if($max_hour > 0){
            if(!$check_holiday){
              $ts_lack = '';
              if(isset($list_dtts[$date_s])){
                $ts_lack = $list_dtts[$date_s].'; ';
              }
              $total_lack = $ts_lack;
              if($total_lack){
                $total_lack = rtrim($total_lack, '; ');
              }
              $result_lack = $this->timesheets_model->merge_ts($total_lack, $max_hour);
            }
            else{
              if($check_holiday->off_type == 'holiday'){
                $result_lack = "HO";
              }
              if($check_holiday->off_type == 'event_break'){
                $result_lack = "EB";
              }
              if($check_holiday->off_type == 'unexpected_break'){
                $result_lack = "UB";
              }
            }
          }
          else{
            $result_lack = 'NS';
          }
          $dt_ts[$date_s] = $result_lack;

        }
        array_push($data['staff_row_tk'], $dt_ts);
      }                        
    }
    elseif($data_timekeeping_form == 'timekeeping_manually' && $data['check_latch_timesheet'] == false){

      $data_ts = $this->timesheets_model->get_timesheets_ts_by_month(date('m'), date('Y'));

      foreach($data_ts as $ts){
        $staff_info = array();
        $staff_info['date'] = date('D d', strtotime($ts['date_work']));  
        $ts_type = $this->timesheets_model->get_ts_by_date_and_staff($ts['date_work'],$ts['staff_id']);

        if(count($ts_type) <= 1){
          if($ts['value'] > 0){
            $staff_info['ts'] = $ts['type'].':'.$ts['value'];
          }else{
            $staff_info['ts'] = '';
          }
        }else{
          $str = '';
          foreach($ts_type as $tp){
            if($tp['value'] > 0){
              if($tp['type'] == 'HO' || $tp['type'] == 'M'){
                if($str == ''){
                  $str .= $tp['type'];
                }else{
                  $str .= "; ".$tp['type'];
                }
              }else{
                if($str == ''){
                  $str .= $tp['type'].':'.round($tp['value'], 2);
                }else{
                  $str .= "; ".$tp['type'].':'.round($tp['value'], 2);
                }
              }
            }                     
          }
          $staff_info['ts'] = $str;
        }         
        if(!isset($data_map[$ts['staff_id']])){
          $data_map[$ts['staff_id']] = array();
        }
        $data_map[$ts['staff_id']][$staff_info['date']] = $staff_info;
      }
      foreach($staffs as $s){
        $ts_date = '';
        $ts_ts = '';
        $result_tb = [];
        if(isset($data_map[$s['staffid']])){
          foreach ($data_map[$s['staffid']] as $key => $value) {
            $ts_date = $data_map[$s['staffid']][$key]['date'];
            $ts_ts =  $data_map[$s['staffid']][$key]['ts'];
            $result_tb[] = [$ts_date => $ts_ts];
          }
        }

        $dt_ts = [];
        $dt_ts = [_l('staff_id') => $s['staffid'],_l('staff') => $s['firstname'].' '.$s['lastname']];
        $note = [];
        $list_dtts = [];
        foreach ($result_tb as $key => $rs) {
          foreach ($rs as $day => $val) {
            $list_dtts[$day] = $val;
          }
        }
        $list_date = $this->timesheets_model->get_list_date(date('Y-m-01'), date('Y-m-t'));
        foreach ($list_date as $key => $value) {  
          $date_s = date('D d', strtotime($value));
          $max_hour = $this->timesheets_model->get_hour_shift_staff($s['staffid'],$value);
          $check_holiday = $this->timesheets_model->check_holiday($s['staffid'], $value);
          $result_lack = '';
          if($max_hour > 0){
            if(!$check_holiday){
              $ts_lack = '';
              if(isset($list_dtts[$date_s])){
                $ts_lack = $list_dtts[$date_s].'; ';
              }
              $total_lack = $ts_lack;
              if($total_lack){
                $total_lack = rtrim($total_lack, '; ');
              }
              $this->load->model('hr_profile/timesheets_model');
              $result_lack = $this->timesheets_model->merge_ts($total_lack, $max_hour);
            }
            else{
              if($check_holiday->off_type == 'holiday'){
                $result_lack = "HO";
              }
              if($check_holiday->off_type == 'event_break'){
                $result_lack = "EB";
              }
              if($check_holiday->off_type == 'unexpected_break'){
                $result_lack = "UB";
              }
            }
          }
          else{
            $result_lack = 'NS';
          }
          $dt_ts[$date_s] = $result_lack;
        }
        array_push($data['staff_row_tk'], $dt_ts);
      }
    }else{
      $this->load->model('hr_profile/timesheets_model');
      $data_ts = $this->timesheets_model->get_timesheets_ts_by_month(date('m'), date('Y'));
      foreach($data_ts as $ts){
        $staff_info = array();
        $staff_info['date'] = date('D d', strtotime($ts['date_work']));    
        $this->load->model('hr_profile/timesheets_model');-            
        $ts_type = $this->timesheets_model->get_ts_by_date_and_staff($ts['date_work'],$ts['staff_id']);
        if(count($ts_type) <= 1){
          if($ts['value'] > 0){
            $staff_info['ts'] = $ts['type'].':'.$ts['value'];
          }else{
            $staff_info['ts'] = '';
          }
        }else{
          $str = '';
          foreach($ts_type as $tp){
            if($tp['value'] > 0){
              if($tp['type'] == 'HO' || $tp['type'] == 'M'){
                if($str == ''){
                  $str .= $tp['type'];
                }else{
                  $str .= "; ".$tp['type'];
                }
              }else{
                if($str == ''){
                  $str .= $tp['type'].':'.round($tp['value'], 2);
                }else{
                  $str .= "; ".$tp['type'].':'.round($tp['value'], 2);
                }
              }
            }                     
          }
          $staff_info['ts'] = $str;
        }          

        if(!isset($data_map[$ts['staff_id']])){
          $data_map[$ts['staff_id']] = array();
        }
        $data_map[$ts['staff_id']][$staff_info['date']] = $staff_info;

      }

      foreach($staffs as $s){
        $ts_date = '';
        $ts_ts = '';
        $result_tb = [];
        if(isset($data_map[$s['staffid']])){
          foreach ($data_map[$s['staffid']] as $key => $value) {
            $ts_date = $data_map[$s['staffid']][$key]['date'];
            $ts_ts =  $data_map[$s['staffid']][$key]['ts'];
            $result_tb[] = [$ts_date => $ts_ts];
          }
        }

        $dt_ts = [];
        $dt_ts = [_l('staff_id') => $s['staffid'],_l('staff') => $s['firstname'].' '.$s['lastname']];
        $note = [];
        $list_dtts = [];
        foreach ($result_tb as $key => $rs) {
          foreach ($rs as $day => $val) {
            $list_dtts[$day] = $val;
          }
        }
        $list_date = $this->timesheets_model->get_list_date(date('Y-m-01'), date('Y-m-t'));
        foreach ($list_date as $key => $value) {  
          $date_s = date('D d', strtotime($value));
          $this->load->model('hr_profile/timesheets_model');
          $max_hour = $this->timesheets_model->get_hour_shift_staff($s['staffid'],$value);
          $check_holiday = $this->timesheets_model->check_holiday($s['staffid'], $value);
          $result_lack = '';
          if($max_hour > 0){
            if(!$check_holiday){
              $ts_lack = '';
              if(isset($list_dtts[$date_s])){
                $ts_lack = $list_dtts[$date_s].'; ';
              }
              $total_lack = $ts_lack;
              if($total_lack){
                $total_lack = rtrim($total_lack, '; ');
              }
              $result_lack = $this->timesheets_model->merge_ts($total_lack, $max_hour);
            }
            else{
              if($check_holiday->off_type == 'holiday'){
                $result_lack = "HO";
              }
              if($check_holiday->off_type == 'event_break'){
                $result_lack = "EB";
              }
              if($check_holiday->off_type == 'unexpected_break'){
                $result_lack = "UB";
              }
            }
          }
          else{
            $result_lack = 'NS';
          }
          $dt_ts[$date_s] = $result_lack;
        }
        array_push($data['staff_row_tk'], $dt_ts);
      }
    }
    $data_lack = [];
    $data['data_lack'] = $data_lack;
    $data['set_col_tk'] = json_encode($data['set_col_tk']);
    return $data;
  }
  public function advance_payment_update(){
		if($this->input->post()){
			$this->load->model('expenses_model');
			$data = $this->input->post();
			$id = $data['id'];
			unset($data['id']);
			$id_expense = '';
			if (!has_permission('expenses', '', 'create')) {
				set_alert('danger', _l('access_denied'));
				redirect(admin_url('hr_profile/requisition_detail/'.$id));
			}
			else{
				if($data['amount_received'] != '' && $data['received_date'] != ''){
					$data_payment['amount_received'] = $data['amount_received'];
					$data_payment['received_date'] = $data['received_date'];
					unset($data['amount_received']);
					unset($data['received_date']);
          $this->load->model('hr_profile/timesheets_model');
					$success = $this->timesheets_model->advance_payment_update($id, $data_payment);
					$id_expense = $this->expenses_model->add($data);
				}
			}
			if(is_numeric($id_expense)){
				set_alert('success',_l('added_successfully'));						
			}
			else{
				set_alert('danger',_l('added_fail'));										
			}
			echo json_encode([
				'url'       => admin_url('hr_profile/requisition_detail/' .$id),
				'expenseid' => $id_expense,
			]);
			die;
		}
	}
  public function add_expense_category()
	{
		if (!is_admin() && get_option('staff_members_create_inline_expense_categories') == '0') {
			access_denied('expenses');
		}
		if ($this->input->post()) {
			$this->load->model('expenses_model');
			$data = $this->input->post();
			$id = $data['leave_id'];
			unset($data['leave_id']);
			$id_category = $this->expenses_model->add_category($data);
			if ($id_category) {
				set_alert('success',_l('added_successfully'));
			}
			redirect(admin_url('hr_profile/requisition_detail/'.$id));
		}
	}
  	/**
	 * send notifi handover recipients
	 * @return
	 */
	public function send_notifi_handover_recipients()
	{
		if ($this->input->is_ajax_request()) {
			$data = $this->input->post();
			if((isset($data)) && $data != ''){
        $this->load->model('hr_profile/timesheets_model');
				$this->timesheets_model->send_notifi_handover_recipients($data);

				$success = 'success';
				echo json_encode([
					'success' => $success,                
				]); 
			}
		}
	}
  	/**
	 * send notification recipient
	 * @return [type] [description]
	 */
	public function send_notification_recipient()
	{
		if ($this->input->is_ajax_request()) {
			$data = $this->input->post();
			if((isset($data)) && $data != ''){
        $this->load->model('hr_profile/timesheets_model');
				$this->timesheets_model->send_notification_recipient($data);

				$success = 'success';
				echo json_encode([
					'success' => $success,                
				]); 
			}
		}
	}

  	/**
	 * file view requisition
	 * @param  int $id
	 * @param  int $rel_id
	 * @return 
	 */
	public function file_view_requisition($id, $rel_id)
	{
    $this->load->model('hr_profile/timesheets_model');
		$data['file'] = $this->timesheets_model->get_file_requisition($id, $rel_id);
		$data['rel_id'] = $rel_id;
		if (!$data['file']) {
			header('HTTP/1.0 404 Not Found');
			die;
		}
		$this->load->view('includes/_file', $data);
	}
	//1
// 	  public function add_requisition_ajax1()
//     {
//         //after submit form

//         if ($this->input->post()) {


//             $data = $this->input->post();



//             if (!isset($data['staff_id'])) {
//                 $data['staff_id'] = get_staff_user_id();
//             }
//             $result = $this->timesheets_model->add_requisition_ajax1($data);
//             redirect(admin_url('hr_profile/timekeeping'));
// //            echo '<pre>';print_r($data);exit();
//         }
//     }

      public function add_requisition_ajax1()
    {
        //after submit form
        if ($this->input->post()) {
            $data = $this->input->post();
            if (!isset($data['staff_id'])) {
                $data['staff_id'] = get_staff_user_id();

            }
            $result = $this->timesheets_model->add_requisition_ajax1($data);

            redirect(admin_url('hr_profile/core_hr/vacations'));
             
        }
    }
// number of days
public function number_of_days($rel_type, $staff_id, $type_of_leave)
    {
       
       
        $number_of_day_he_take_it_after_collecting = 0;
        $number_of_days_before=0;
        $number_of_days_after=0;
//echo $rel_type;echo $staffid;echo $type_of_leave ;exit();
        $data = [
            'days' => $this->timesheets_model->get_number_of_day($rel_type),
            'years' => $this->timesheets_model->get_deserving_year($rel_type),
            'deserving_before_days' => $this->timesheets_model->get_deserving_before_day($rel_type),
            'deserving_after_days' => $this->timesheets_model->get_deserving_after_days($rel_type),
            'number_of_day_he_take_it' => $this->timesheets_model->number_of_day_he_take_it($staff_id, $type_of_leave),
            'number_of_days_in_leave' => $this->timesheets_model->get_number_of_days_in_leave($type_of_leave),
            'years_status'=>$this->timesheets_model->get_status_of_years($type_of_leave,$staff_id),
            'contract_date'=>$this->timesheets_model->get_contract_date($staff_id),
        ];
        $contract_date = $this->timesheets_model->get_contract_date($staff_id);
    
            $data['time_now']=date('Y-m-d');
            // calculate the accumulative days
        $now = time(); // or your date as well
        $this_year = date('Y');
        $_contract_date = strtotime("$this_year-$contract_date");
        $date_diff = $now - $_contract_date;
        $number_of_days_between_start_year_and_now = round($date_diff / (60 * 60 * 24));
        $leave_days = $data['days']->number_of_days;
        $number_of_days_in_this_year = $this_year % 4 == 0 ? 366 : 365;
        $accumulative_vacation = $number_of_days_between_start_year_and_now * $leave_days / $number_of_days_in_this_year;
        $accumulative_vacation = round($accumulative_vacation, 1 );
        if(!($accumulative_vacation - 0.5 == round($accumulative_vacation, 0, PHP_ROUND_HALF_DOWN)))
            $accumulative_vacation = round($accumulative_vacation);

        $data['accumulative_day']=$accumulative_vacation;
        //end calculate

        // calculate accumulative days before years
        $leave_days = $data['deserving_before_days']->deserving_before_days;

        $number_of_days_in_this_year = $this_year % 4 == 0 ? 366 : 365;
        $accumulative_vacation_before_years = $number_of_days_between_start_year_and_now * $leave_days / $number_of_days_in_this_year;
        $accumulative_vacation_before_years = round($accumulative_vacation_before_years, 1 );
        if(!($accumulative_vacation_before_years - 0.5 == round($accumulative_vacation_before_years, 0, PHP_ROUND_HALF_DOWN)))
            $accumulative_vacation_before_years = round($accumulative_vacation_before_years);
        $data['accumulative_day_before_years']=$accumulative_vacation_before_years;
            //end calculate

        //calculate accumulative days after years
        $leave_days = $data['deserving_after_days']->deserving_after_days;
        $number_of_days_in_this_year = $this_year % 4 == 0 ? 366 : 365;
        $accumulative_vacation_after_years = $number_of_days_between_start_year_and_now * $leave_days / $number_of_days_in_this_year;
        $accumulative_vacation_after_years = round($accumulative_vacation_after_years, 1 );
        if(!($accumulative_vacation_after_years - 0.5 == round($accumulative_vacation_after_years, 0, PHP_ROUND_HALF_DOWN)))
            $accumulative_vacation_after_years = round($accumulative_vacation_after_years);
        $data['accumulative_day_after_years']=$accumulative_vacation_after_years;

        //end calculate
        $years = $data['years'];
        $number_of_day_he_take_it_before_collecting = $this->timesheets_model->number_of_day_he_take_it($staff_id, $type_of_leave);
        foreach ($number_of_day_he_take_it_before_collecting as $value) {


            $number_of_day_he_take_it_after_collecting = $value['number_of_leaving_day'] + $number_of_day_he_take_it_after_collecting;
        }


        $number_of_day_he_take_it_before = $this->timesheets_model->number_of_day_he_take_it_before($staff_id, $type_of_leave);
        foreach ($number_of_day_he_take_it_before as $value) {
            $number_of_days_before=$value['number_of_leaving_day']+$number_of_days_before;


        }
        $number_of_day_he_take_it_after = $this->timesheets_model->number_of_day_he_take_it_after($staff_id, $type_of_leave);
        foreach ($number_of_day_he_take_it_after as $value) {
            $number_of_days_after=$value['number_of_leaving_day']+$number_of_days_after;
        }
        
        $data['total_of_leaving_day'] = $number_of_day_he_take_it_after_collecting;
        $data['total_of_leaving_day_before'] =$number_of_days_before;
        $data['total_of_leaving_day_after']=$number_of_days_after;

        $data[""] = strtotime(date('Y-m-d', strtotime("-$years->deserving_in_years years", strtotime(date('Y-m-d')))));
        
        // $result = $this->number_of_days($rel_type, $staff_id, $type_of_leave);
      
        echo json_encode($data);

    }

//get type of leave
      public function get_type_of_leave($id)
    {



        $data = [];

        $data_created = $this->timesheets_model->get_staff_info1($id);
        $type_of_leave = $this->timesheets_model->get_type_of_leave_all();
        $check_is_once_leaves = $this->timesheets_model->check_is_once($id);
        $staff_gender_and_sex = $this->timesheets_model->get_another_info($id);


        if (sizeof($check_is_once_leaves) != 0) {
            foreach ($check_is_once_leaves as $check_is_once_leaves) {

                if (isset($check_is_once_leaves->repeat_leave) && $check_is_once_leaves->repeat_leave == 'once') {
                    foreach ($type_of_leave as $key => $value) {
                        if ($value['id'] == $check_is_once_leaves->id) {
                            unset($type_of_leave[$key]);
                        }
                    }
                }

            }
        }

        $gender = $staff_gender_and_sex->gender;
        if ($gender == 'Female') {
            $gender = 0;
        } else {
            $gender = 1;
        }
        $count = 0;

        $date_start = (is_object($data_created) ? $data_created->datestart : '');
        $contract_year_time = strtotime($date_start);
        $time_now = (date('Y-m-d'));
        $data[] = strtotime(is_object($data_created) ? $data_created->datestart : '');

        foreach ($type_of_leave as $key => $types) {
            if ($types['repeat_leave'] == 'year' && substr($time_now,0,4)!=substr($date_start,0,4)) {
                $check_if_years_and_take_all_day = $this->timesheets_model->check_if_years_and_take_all_day($types['id']);


                if ($check_if_years_and_take_all_day != null) {
                    foreach ($check_if_years_and_take_all_day as $check) {
                        $count += $check['number_of_leaving_day'];

                        if ($count == $check['number_of_days'] || $check['number_of_leaving_day'] == $check['number_of_days']) {
                            unset($type_of_leave[$key]);
                        }
                    }

                }
            }
        }


        foreach ($type_of_leave as $type) {


            $years = $type['deserving_in_years'];
            $number_of_day = $type['number_of_days'];
            $years_and_date_start = strtotime(date('Y-m-d', strtotime("+$years years", strtotime($date_start))));

            $months = $type['entitlement_in_months'];
            $is_date_allowed_for_leave = date('Y-m-d', strtotime("+$months months", strtotime($date_start)));
            $is_he_in_date_range = strtotime($is_date_allowed_for_leave);
            $is_he_in_year_range = $years_and_date_start - $contract_year_time;
            $now_time = strtotime($time_now);
            if ($type['male'] == 1 && $gender == 1 && $is_he_in_date_range <= $now_time) {

                $data[] = $type;
            } elseif ($type['female'] == 1 && $gender == 0 && $type['male'] == 0 && $is_he_in_date_range <= $now_time) {
                $data [] = $type;
            } else if ($type['female'] == 1 && $type['male'] == 1 && $is_he_in_date_range <= $now_time) {
                $data[] = $type;
            }
            if ($type['accumulative'] ==1 && $is_he_in_date_range <= $now_time){

            }

        }



        echo json_encode($data);


    }

      /**
     * manage timesheets
     */
 public function manage_timesheets()
{
    if ($this->input->post()) {
        $data = $this->input->post();
        if (isset($data)) {
            if ($data['latch'] == 1) {
                if (isset($data['month']) && $data['month'] != "") {
                    $data_month = explode("-", $data['month']);
                    if (strlen($data['month'][0]) == 4) {
                        $month_latch = $data_month[1] . '-' . $data_month[0];
                    } else {
                        $month_latch = $data_month[0] . '-' . $data_month[1];
                    }
                } else {
                    $month_latch = date("m-Y");
                }

                $day_month = [];
                $day_by_month_tk = [];
                $day_month_tk[] = 'staff_id';
                $day_month_tk[] = 'staff_name';

                $month = explode('-', $data['month'])[0];
                $month_year = explode('-', $data['month'])[1];

                for ($d = 1; $d <= 31; $d++) {
                    $time = mktime(12, 0, 0, $month, $d, $month_year);
                    if (date('m', $time) == $month) {
                        array_push($day_month, date('Y-m-d', $time));
                        array_push($day_month_tk, date('Y-m-d', $time));
                    }
                }

                $data['time_sheet'] = json_decode($data['time_sheet']);
                $ts_val = [];

                if (is_array($data['time_sheet'])) {
                    $ts_val = array_map(function ($value) use ($day_month_tk) {
                        if (is_array($value)) {
                            return array_combine($day_month_tk, $value);
                        } else {
                            // Handle the case where $value is not an array (e.g., log an error or skip)
                            // You can also return an empty array or another default value if needed.
                            return [];
                        }
                    }, $data['time_sheet']);
                } else {
                    // Handle the case where $data['time_sheet'] is not an array (e.g., log an error or skip)
                    // You can also set $ts_val to an empty array or another default value if needed.
                    $ts_val = [];
                }

                unset($data['time_sheet']);

                $add = $this->timesheets_model->add_update_timesheet($ts_val, true);

                $success = $this->timesheets_model->latch_timesheet($month_latch);

                if ($success) {
                    set_alert('success', _l('timekeeping_latch_successful'));
                } else {
                    set_alert('warning', _l('timekeeping_latch_false'));
                }

                redirect(admin_url('hr_profile/timekeeping?group=timesheets'));
            } elseif ($data['unlatch'] == 1) {
                if (isset($data['month']) && $data['month'] != "") {
                    $data['month'] = explode("-", $data['month']);
                    if (strlen($data['month'][0]) == 4) {
                        $month = $data['month'][1] . '-' . $data['month'][0];
                    } else {
                        $month = $data['month'][0] . '-' . $data['month'][1];
                    }
                } else {
                    $month = date("m-Y");
                }

                $success = $this->timesheets_model->unlatch_timesheet($month);

                if ($success) {
                    set_alert('success', _l('timekeeping_unlatch_successful'));
                } else {
                    set_alert('warning', _l('timekeeping_unlatch_false'));
                }

                redirect(admin_url('hr_profile/timekeeping?group=timesheets'));
            } else {
                $day_month = [];
                $day_month_tk = [];
                $day_month_tk[] = 'staff_id';
                $day_month_tk[] = 'staff_name';

                $month = explode('-', $data['month'])[0];
                $month_year = explode('-', $data['month'])[1];

                for ($d = 1; $d <= 31; $d++) {
                    $time = mktime(12, 0, 0, $month, $d, $month_year);
                    if (date('m', $time) == $month) {
                        array_push($day_month, date('Y-m-d', $time));
                        array_push($day_month_tk, date('Y-m-d', $time));
                    }
                }

                $data['time_sheet'] = json_decode($data['time_sheet']);
                $ts_val = [];

                if (is_array($data['time_sheet'])) {
                    $ts_val = array_map(function ($value) use ($day_month_tk) {
                        if (is_array($value)) {
                            return array_combine($day_month_tk, $value);
                        } else {
                            // Handle the case where $value is not an array (e.g., log an error or skip)
                            // You can also return an empty array or another default value if needed.
                            return [];
                        }
                    }, $data['time_sheet']);
                } else {
                    // Handle the case where $data['time_sheet'] is not an array (e.g., log an error or skip)
                    // You can also set $ts_val to an empty array or another default value if needed.
                    $ts_val = [];
                }

                unset($data['time_sheet']);

                $add = $this->timesheets_model->add_update_timesheet($ts_val, true);

                if ($add > 0) {
                    set_alert('success', _l('timekeeping') . ' ' . _l('successfully'));
                } else {
                    set_alert('warning', _l('alert_ts'));
                }

                redirect(admin_url('hr_profile/timekeeping?group=timesheets'));
            }
        }
    }
}


  /**
     * import timesheets
     * @return
     */
    public function import_timesheets()
    {
        if (!class_exists('XLSXReader_fin')) {
            require_once(module_dir_path(TIMESHEETS_MODULE_NAME) . '/assets/plugins/XLSXReader/XLSXReader.php');
        }
        require_once(module_dir_path(TIMESHEETS_MODULE_NAME) . '/assets/plugins/XLSXWriter/xlsxwriter.class.php');

        $total_row_false = 0;
        $total_rows = 0;
        $dataerror = 0;
        $total_row_success = 0;
        if (isset($_FILES['file_timesheets']['name']) && $_FILES['file_timesheets']['name'] != '') {
            // Get the temp file path
            $tmpFilePath = $_FILES['file_timesheets']['tmp_name'];
            // Make sure we have a filepath
            if (!empty($tmpFilePath) && $tmpFilePath != '') {
                $rows = [];
                // Setup our new file path
                $newFilePath = $tmpDir . $_FILES['file_timesheets']['name'];
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    $xlsx = new XLSXReader_fin($newFilePath);
                    $sheetNames = $xlsx->getSheetNames();
                    $data = $xlsx->getSheetData($sheetNames[1]);

                    for ($row = 1; $row < count($data); $row++) {
                        $flag = 0;
                        $rd = [];
                        $rd['staffid'] = isset($data[$row][0]) ? $data[$row][0] : '';
                        $rd['time_in'] = isset($data[$row][1]) ? $data[$row][1] : '';
                        $rd['time_out'] = isset($data[$row][2]) ? $data[$row][2] : '';
                        if ($rd['staffid'] == '' && $rd['time_in'] == '' && $rd['time_out'] == '') {
                            $flag = 1;
                        }
                        if ($flag == 0) {
                            $rows[] = $rd;
                        }
                    }
                    $this->timesheets_model->import_timesheets($rows);
                    set_alert('success', _l('import_timesheets'));
                }
            } else {
                set_alert('warning', _l('import_upload_failed'));
            }
        }
        redirect(admin_url('hr_profile/timekeeping'));
    }


    /**
     * reload timesheets byfilter
     * @return json
     */
    public function reload_timesheets_byfilter()
    {
        $data = $this->input->post();
        $date_ts = $this->timesheets_model->format_date($data['month'] . '-01');
        $date_ts_end = $this->timesheets_model->format_date($data['month'] . '-' . date('t'));
        $year = date('Y', strtotime($date_ts));
        $g_month = date('m', strtotime($date_ts));
        $month_filter = date('Y-m', strtotime($date_ts));


        $querystring = 'active=1';
        $department = $data['department'];
        $job_position = $data['job_position'];

        $data['month'] = date('m-Y', strtotime($date_ts));
        $data['check_latch_timesheet'] = $this->timesheets_model->check_latch_timesheet($data['month']);
        $staff = '';
        if (isset($data['staff'])) {
            $staff = $data['staff'];
        }
        $staff_querystring = '';
        $job_position_querystring = '';
        $department_querystring = '';
        $month_year_querystring = '';

        if ($department != '') {
            $arrdepartment = $this->staff_model->get('', 'staffid in (select ' . db_prefix() . 'staff_departments.staffid from ' . db_prefix() . 'staff_departments where departmentid = ' . $department . ')');
            $temp = '';
            foreach ($arrdepartment as $value) {
                $temp = $temp . $value['staffid'] . ',';
            }
            $temp = rtrim($temp, ",");
            $department_querystring = 'FIND_IN_SET(staffid, "' . $temp . '")';
        }
        if ($job_position != '') {
            $job_position_querystring = 'role = "' . $job_position . '"';
        }
        if ($staff != '') {
            $temp = '';
            $araylengh = count($staff);
            for ($i = 0; $i < $araylengh; $i++) {
                $temp = $temp . $staff[$i];
                if ($i != $araylengh - 1) {
                    $temp = $temp . ',';
                }
            }
            $staff_querystring = 'FIND_IN_SET(staffid, "' . $temp . '")';
        } else {
            $data_timekeeping_form = get_timesheets_option('timekeeping_form');

            $timekeeping_applicable_object = [];
            if ($data_timekeeping_form == 'timekeeping_task') {
                if (get_timesheets_option('timekeeping_task_role') != '') {
                    $timekeeping_applicable_object = get_timesheets_option('timekeeping_task_role');
                }
            } elseif ($data_timekeeping_form == 'timekeeping_manually') {
                if (get_timesheets_option('timekeeping_manually_role') != '') {
                    $timekeeping_applicable_object = get_timesheets_option('timekeeping_manually_role');
                }
            } elseif ($data_timekeeping_form == 'csv_clsx') {
                if (get_timesheets_option('csv_clsx_role') != '') {
                    $timekeeping_applicable_object = get_timesheets_option('csv_clsx_role');
                }
            }
            $staff_querystring != '';
            if ($data['job_position'] != '') {
                $staff_querystring .= 'role = ' . $data['job_position'];
            } else {
                if ($timekeeping_applicable_object) {
                    if ($timekeeping_applicable_object != '') {
                        $staff_querystring .= 'FIND_IN_SET(role, "' . $timekeeping_applicable_object . '")';
                    }
                }
            }

        }

        $arrQuery = array($staff_querystring, $department_querystring, $month_year_querystring, $job_position_querystring, $querystring);
        $newquerystring = '';
        foreach ($arrQuery as $string) {
            if ($string != '') {
                $newquerystring = $newquerystring . $string . ' AND ';
            }
        }

        $newquerystring = rtrim($newquerystring, "AND ");
        if ($newquerystring == '') {
            $newquerystring = [];
        }

        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $g_month, $year);
        if ($year != '') {
            $month_new = (string)$g_month;
            if (strlen($month_new) == 1) {
                $month_new = '0' . $month_new;
            }
            $g_month = $month_new;
        }

        $data['departments'] = $this->departments_model->get();
        $data['staffs_li'] = $this->staff_model->get();
        $data['roles'] = $this->roles_model->get();
        $data['job_position'] = $this->roles_model->get();
        $data['positions'] = $this->roles_model->get();

        $data['shifts'] = $this->timesheets_model->get_shifts();

        $data['day_by_month_tk'] = [];
        $data['day_by_month_tk'][] = _l('staff_id');
        $data['day_by_month_tk'][] = _l('staff');

        $data['set_col_tk'] = [];
        $data['set_col_tk'][] = ['data' => _l('staff_id'), 'type' => 'text'];
        $data['set_col_tk'][] = ['data' => _l('staff'), 'type' => 'text', 'readOnly' => true, 'width' => 200];

        for ($d = 1; $d <= $days_in_month; $d++) {
            $time = mktime(12, 0, 0, $g_month, $d, (int)$year);
            if (date('m', $time) == $g_month) {
                array_push($data['day_by_month_tk'], date('D d', $time));
                array_push($data['set_col_tk'], ['data' => date('D d', $time), 'type' => 'text']);
            }
        }

        $data['day_by_month_tk'] = $data['day_by_month_tk'];

        $data_map = [];
        $data_timekeeping_form = get_timesheets_option('timekeeping_form');
        $data['staff_row_tk'] = [];

        $staffs = $this->timesheets_model->getStaff('', $newquerystring);
        $data['staffs_setting'] = $this->staff_model->get();
        $data['staffs'] = $staffs;
        if ($data_timekeeping_form == 'timekeeping_task' && $data['check_latch_timesheet'] == false) {
            $result = $this->timesheets_model->get_attendance_task($staffs, $g_month, $year);
            $data['staff_row_tk'] = $result['staff_row_tk'];
        } else {
            if ($data['check_latch_timesheet'] == false) {
                $result = $this->timesheets_model->get_attendance_manual($staffs, $g_month, $year);
                $data['staff_row_tk'] = $result['staff_row_tk'];
            }
        }

        $data_lack = [];
        $data['data_lack'] = $data_lack;
        echo json_encode([
            'arr' => $data['staff_row_tk'],
            'set_col_tk' => $data['set_col_tk'],
            'day_by_month_tk' => $data['day_by_month_tk'],
            'check_latch_timesheet' => $data['check_latch_timesheet'],
            'month' => $data['month'],
            'data_lack' => $data['data_lack'],
        ]);
        die;
    }

  /**
     * show detail timesheets
     * @return json
     */
    public function show_detail_timesheets()
    {
        $data = $this->input->post();


        $d = substr($data['ColHeader'], 4, 2);
        $time = $data['month'] . '-' . $d;
        $d = _d($time);
        $st = $this->staff_model->get($data['staffid']);
        if (!isset($st->staffid)) {
            echo json_encode([
                'title' => '',
                'html' => '',
            ]);
            die();
        }
        $title = get_staff_full_name($st->staffid) . ' - ' . $d;

        $data['value'] = explode('; ', $data['value']);
        $html = '';

        foreach ($data['value'] as $key => $value) {
            $value = explode(':', $value);

            $html .= '<li class="list-group-item justify-content-between">
					' . $value[0] . '
					<span class="badgetext badge badge-primary badge-pill style_p">' . round($value[1], 2) . '</span>
					</li>';

            if (isset($value[1]) && $value[1] > 0 || $value[0] == 'M' || $value[0] == 'HO' || $value[0] == 'B') {
                switch ($value[0]) {
                    case 'AL':
                        $html .= '<li class="list-group-item justify-content-between">
					' . _l('p_timekeeping') . '
					<span class="badgetext badge badge-primary badge-pill style_p">' . round($value[1], 2) . '</span>
					</li>';
                        break;
                    case 'W':
                        $hours = round($value[1], 2);
                        $h = intval($hours);
                        $m = ($hours - $h) * 60;
                        $h_m = $h . ':' . ((strlen($m) == 1) ? $m . '0' : $m);
                        $html .= '<li class="list-group-item justify-content-between">
					' . _l('W_timekeeping') . '
					<span class="badgetext badge badge-primary badge-pill style_w" data-toggle="tooltip" data-placement="top" data-original-title="' . $hours . '">' . $h_m . '</span>
					</li>';
                        break;
                    case 'A':
                        $html .= '<li class="list-group-item justify-content-between">
					' . _l('A_timekeeping') . '
					<span class="badgetext badge badge-primary badge-pill style_a">' . round($value[1], 2) . '</span>
					</li>';
                        break;
                    case 'HO':
                        $html .= '<li class="list-group-item justify-content-between">
					' . _l('Le_timekeeping') . '
					</li>';
                        break;
                    case 'E':
                        $html .= '<li class="list-group-item justify-content-between">
					' . _l('E_timekeeping') . '
					<span class="badgetext badge badge-primary badge-pill style_e">' . round($value[1], 2) . '</span>
					</li>';
                        break;
                    case 'L':
                        $html .= '<li class="list-group-item justify-content-between">
					' . _l('L_timekeeping') . '
					<span class="badgetext badge badge-primary badge-pill style_l">' . round($value[1], 2) . '</span>
					</li>';
                        break;
                    case 'U':
                        $html .= '<li class="list-group-item justify-content-between">
					' . _l('U_timekeeping') . '
					<span class="badgetext badge badge-primary badge-pill style_u">' . round($value[1], 2) . '</span>
					</li>';
                        break;
                    case 'OM':
                        $html .= '<li class="list-group-item justify-content-between">
					' . _l('OM_timekeeping') . '
					<span class="badgetext badge badge-primary badge-pill style_om">' . round($value[1], 2) . '</span>
					</li>';
                        break;
                    case 'R':
                        $html .= '<li class="list-group-item justify-content-between">
					' . _l('R_timekeeping') . '
					<span class="badgetext badge badge-primary badge-pill style_u">' . round($value[1], 2) . '</span>
					</li>';
                        break;
                    case 'CO':
                        $html .= '<li class="list-group-item justify-content-between">
					' . _l('CO_timekeeping') . '
					<span class="badgetext badge badge-primary badge-pill style_u">' . round($value[1], 2) . '</span>
					</li>';
                        break;
                    case 'ME':
                        $html .= '<li class="list-group-item justify-content-between">
					' . _l('H_timekeeping') . '
					<span class="badgetext badge badge-primary badge-pill style_me">' . round($value[1], 2) . '</span>
					</li>';
                        break;
                    case 'OT':
                        $html .= '<li class="list-group-item justify-content-between">
					' . _l('OT_timekeeping') . '
					<span class="badgetext badge badge-primary badge-pill style_me">' . round($value[1], 2) . '</span>
					</li>';
                        break;
                    case 'PO':
                        $html .= '<li class="list-group-item justify-content-between">
					' . _l('PN_timekeeping') . '
					<span class="badgetext badge badge-primary badge-pill style_po">' . round($value[1], 2) . '</span>
					</li>';
                        break;

                }
            }

        }


        if (!($value[0] == 'HO' || $value[0] == 'EB' || $value[0] == 'UB')) {
            $ws_day = '';
            $color = '';
            $list_shift = $this->timesheets_model->get_shift_work_staff_by_date($data['staffid'], $time);
            foreach ($list_shift as $ss) {
                $data_shift_type = $this->timesheets_model->get_shift_type($ss);
                if ($data_shift_type) {
                    $ws_day .= '<li class="list-group-item justify-content-between">' . _l('work_times') . ': ' . $data_shift_type->time_start_work . ' - ' . $data_shift_type->time_end_work . '</li><li class="list-group-item justify-content-between">' . _l('lunch_break') . ': ' . $data_shift_type->start_lunch_break_time . ' - ' . $data_shift_type->end_lunch_break_time . '</li>';
                }
            }

            if ($ws_day != '') {
                $html .= $ws_day;
            }
            $access_history_string = '';
            $access_history = $this->timesheets_model->get_list_check_in_out($time, $data['staffid']);
            if ($access_history) {
                foreach ($access_history as $key => $value) {
                    if ($value['type_check'] == '1') {
                        $access_history_string .= '<li class="list-group-item"><i class="fa fa-sign-in text-success" aria-hidden="true"></i> ' . _dt($value['date']) . '</li>';
                    } else {
                        $access_history_string .= '<li class="list-group-item"><i class="fa fa-sign-out text-danger" aria-hidden="true"></i> ' . _dt($value['date']) . '</li>';
                    }
                }
            }
            if ($access_history_string != '') {
                $html .= '<li class="list-group-item justify-content-between"><ul class="list-group">
				<li class="list-group-item active">' . _l('access_history') . '</li>
				' . $access_history_string . '
				</ul></li>';
            }
        }
        echo json_encode([
            'title' => $title,
            'html' => $html,
        ]);
        die();
    }


/**
     * timekeeping
     * @return view
     */
    public function timekeeping()
    {


        if (!(has_permission('attendance_management', '', 'view_own') || has_permission('attendance_management', '', 'view') || is_admin())) {
            access_denied('timekeeping');
        }

        $this->load->model('staff_model');
        $data['title'] = _l('timesheets');
        $month = date('m');
        $month_year = date('Y');
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $month_year);

        $data['check_latch_timesheet'] = $this->timesheets_model->check_latch_timesheet(date('m-Y'));

        $data['departments'] = $this->departments_model->get();
        $data['roles'] = $this->roles_model->get();
        $data['day_by_month_tk'] = [];
        $data['day_by_month_tk'][] = _l('staff_id');
        $data['day_by_month_tk'][] = _l('staff');
        $data['set_col_tk'] = [];
        $data['set_col_tk'][] = ['data' => _l('staff_id'), 'type' => 'text'];
        $data['set_col_tk'][] = ['data' => _l('staff'), 'type' => 'text', 'readOnly' => true, 'width' => 200];

        for ($d = 1; $d <= $days_in_month; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $month_year);

            if (date('m', $time) == $month) {
                array_push($data['day_by_month_tk'], date('D d', $time));
                array_push($data['set_col_tk'], ['data' => date('D d', $time), 'type' => 'text']);
            }
        }
        $data['day_by_month_tk'] = json_encode($data['day_by_month_tk']);


        $data_map = [];
        $data_timekeeping_form = get_timesheets_option('timekeeping_form');//get timesheet setting(manual,task,..)
        $data_timekeeping_manually_role = get_timesheets_option('timekeeping_manually_role');
        $data['data_timekeeping_form'] = $data_timekeeping_form;

        $data['staff_row_tk'] = [];
        $staffs = $this->timesheets_model->get_staff_timekeeping_applicable_object();
        $data['staffs'] = $staffs;

        if ($data_timekeeping_form == 'timekeeping_task' && $data['check_latch_timesheet'] == false) {
            $result = $this->timesheets_model->get_attendance_task($staffs, $month, $month_year);
            $data['staff_row_tk'] = $result['staff_row_tk'];
        } else {
            if ($data['check_latch_timesheet'] == false) {
                $result = $this->timesheets_model->get_attendance_manual($staffs, $month, $month_year);
                $data['staff_row_tk'] = $result['staff_row_tk'];
            }
        }

        $data_lack = [];
        $data['data_lack'] = $data_lack;
        $data['set_col_tk'] = json_encode($data['set_col_tk']);


        $this->load->view('timekeeping/manage_timekeeping', $data);
    }

    public function timekeeping2()
    {


        if (!(has_permission('attendance_management', '', 'view_own') || has_permission('attendance_management', '', 'view') || is_admin())) {
            access_denied('timekeeping');
        }

        $this->load->model('staff_model');
        $data['title'] = _l('timesheets');
        $month = date('m');
        $month_year = date('Y');
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $month_year);

        $data['check_latch_timesheet'] = $this->timesheets_model->check_latch_timesheet(date('m-Y'));

        $data['departments'] = $this->departments_model->get();
        $data['roles'] = $this->roles_model->get();
        $data['day_by_month_tk'] = [];
        $data['day_by_month_tk'][] = _l('staff_id');
        $data['day_by_month_tk'][] = _l('staff');
        $data['set_col_tk'] = [];
        $data['set_col_tk'][] = ['data' => _l('staff_id'), 'type' => 'text'];
        $data['set_col_tk'][] = ['data' => _l('staff'), 'type' => 'text', 'readOnly' => true, 'width' => 200];

        for ($d = 1; $d <= $days_in_month; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $month_year);

            if (date('m', $time) == $month) {
                array_push($data['day_by_month_tk'], date('D d', $time));
                array_push($data['set_col_tk'], ['data' => date('D d', $time), 'type' => 'text']);
            }
        }
        $data['day_by_month_tk'] = json_encode($data['day_by_month_tk']);

        $data_map = [];
        $data_timekeeping_form = get_timesheets_option('timekeeping_form');//get timesheet setting(manual,task,..)
        $data_timekeeping_manually_role = get_timesheets_option('timekeeping_manually_role');
        $data['data_timekeeping_form'] = $data_timekeeping_form;

        $data['staff_row_tk'] = [];
        $staffs = $this->timesheets_model->get_staff_timekeeping_applicable_object();
        $data['staffs'] = $staffs;

        if ($data_timekeeping_form == 'timekeeping_task' && $data['check_latch_timesheet'] == false) {
            $result = $this->timesheets_model->get_attendance_task($staffs, $month, $month_year);
            $data['staff_row_tk'] = $result['staff_row_tk'];
        } else {
            if ($data['check_latch_timesheet'] == false) {

                $result = $this->timesheets_model->get_attendance_manual2($staffs, $month, $month_year);
                $data['staff_row_tk'] = $result['staff_row_tk'];
            }
        }


        $data_lack = [];
        $type_of_leave =  get_type_of_leave_all_name();
        $data['type_of_leave'] = $type_of_leave;
        $data['data_lack'] = $data_lack;
        $data['set_col_tk'] = json_encode($data['set_col_tk']);
       



        $this->load->view('timekeeping/manage_timekeeping2', $data);
    }

     


    // insurance_book_num

    public function add_insurance_type(){
        $this->load->model('Insurance_type_model');
        $data = $this->input->get();

        $success = $this->Insurance_type_model->add($data);

        if($success)
            set_alert('success', _l('added_successfully'));
        else
            set_alert('warning', 'Problem Creating');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update_insurance_type(){
        $this->load->model('Insurance_type_model');
        $data = $this->input->get();
        if(!isset($data['for_staff']))
            $data['for_staff'] = '';
        $id = $this->input->get('id');
        $success = $this->Insurance_type_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function delete_insurance_type($id) {
        $this->load->model('Insurance_type_model');

        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $response = $this->Insurance_type_model->delete($id);

        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('insurance_type')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('insurance_type')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('insurance_type')));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function insurance_type_json($id){
        $this->load->model('Insurance_type_model');
        $data = $this->Insurance_type_model->get($id);
        echo json_encode($data);
    }
    //***********************



    public function add_note()
    {
        $data = $this->input->post();
        $id = $this->hr_profile_model->add_note($data);
        if ($id) {
            $data = $this->hr_profile_model->get_note($id);
            echo json_encode($data);
        } else {
            echo false;
        }
    }

    public function delete_note($id)
    {
        $id = $this->hr_profile_model->delete_note($id);
        echo $id;
    }

    public function update_note($id)
    {
        $data = $this->input->post();
        $id = $this->hr_profile_model->update_note($id, $data);

        echo $id;
    }

    public function get_note($id)
    {
        $data = $this->hr_profile_model->get_note($id);
        echo json_encode($data);

    }

    public function add_comment()
    {
        $data = $this->input->post();
        $id = $this->hr_profile_model->add_comment($data);
        if ($id) {
            $data = $this->hr_profile_model->get_comment($id);
            echo json_encode($data);
        } else {
            echo false;
        }
    }

    public function delete_comment($id)
    {
        $id = $this->hr_profile_model->delete_comment($id);
        echo $id;
    }

    public function update_comment($id)
    {
        $data = $this->input->post();
        $id = $this->hr_profile_model->update_comment($id, $data);

        echo $id;
    }

    public function get_comment($id)
    {
        $data = $this->hr_profile_model->get_comment($id);
        echo json_encode($data);

    }

    public function add_contract_attachment($id)
    {
        $file_id = handle_hr_contract_attachment($id);
        if ($file_id) {
            $attachments = $this->hr_profile_model->get_hrm_attachments_file($id, 'hr_contract');
            $data = '<div class="row">';
            foreach ($attachments as $attachment) {
                $href_url = site_url('download/file/hr_contract/' . $attachment['attachment_key']);
                if (!empty($attachment['external'])) {
                    $href_url = $attachment['external_link'];
                }
                $data .= '<div class="display-block contract-attachment-wrapper">';
                $data .= '<div class="col-md-10">';
                $data .= '<div class="pull-left"><i class="' . get_mime_class($attachment['filetype']) . '"></i></div>';
                $data .= '<a href="' . $href_url . '"' . (!empty($attachment['external']) ? ' target="_blank"' : '') . '>' . $attachment['file_name'] . '</a>';
                $data .= '<p class="text-muted">' . $attachment["filetype"] . '</p>';
                $data .= '</div>';
                $data .= '<div class="col-md-2 text-right">';
                if ($attachment['staffid'] == get_staff_user_id() || is_admin()) {
                    $data .= '<a href="#" class="text-danger" onclick="delete_contract_attachment(this,' . $attachment['id'] . '); return false;"><i class="fa fa fa-times"></i></a>';
                }
                $data .= '</div>';
                $data .= '<div class="clearfix"></div><hr/>';
                $data .= '</div>';
            }
            $data .= '</div>';
            echo $data;
            die();
        }
        return false;
    }

    public function delete_renewal($renewal_id)
    {
        $success = $this->hr_profile_model->delete_renewal($renewal_id);
        if ($success) {
            echo true;
        } else {
            set_alert('warning', _l('contract_renewal_delete_fail'));
        }
    }

    public function modal_renew($id)
    {
        $contract = $this->hr_profile_model->get_contract($id);
        $data['contract'] = $contract;

        $this->load->view('contracts/renew_contract', $data);
    }

    public function add_renew()
    {
        $data = $this->input->post();
        $data['renewed_by'] = get_staff_user_id();
        $data['date_renewed'] = date('Y-m-d H:i:s');
        $data['new_start_date'] = to_sql_date($data['new_start_date']);
        $data['new_end_date'] = to_sql_date($data['new_end_date']);
        $id = $this->hr_profile_model->add_contract_renew($data);
        if ($id) {
            $contract_renewal_history = $this->hr_profile_model->get_all_renew($data["contract_id"]);
            $data = '';
            if (count($contract_renewal_history) == 0) {
                echo _l('no_contract_renewals_found');
            }
            foreach ($contract_renewal_history as $renewal) {
                $data .= "
                    <div class='display-block' id='renewl-{$renewal['id']}'>
                        <div class='media-body'>
                            <div class='display-block'>
                                <b>";
                $data .= _l('contract_renewed_by', get_staff_full_name($renewal['renewed_by']));
                $data .= " </b>";

                if ($renewal['renewed_by'] == get_staff_user_id() || is_admin()) {
                    $data .= "<button onclick='delete_renewal({$renewal['id']})'
                               class='pull-right text-danger'><i class='fa fa-remove'></i></button>
                            <br/>";
                }
                $data .= "
                    <small class='text-muted'>";
                $data .= _dt($renewal['date_renewed']);
                $data .= "</small>
                    <hr class='hr-10'/>
                    <span class='text-success bold' data-toggle='tooltip'
                          title='";
                $data .= _l('contract_renewal_old_start_date', _d($renewal['new_start_date']));
                $data .= "'>";
                $data .= _l('contract_renewal_new_start_date', _d($renewal['new_start_date']));
                $data .= "
                                      </span>
                    <br/>
                    <span class='text-success bold' data-toggle='tooltip'
                          title='";
                $data .= _l('contract_renewal_old_end_date', _d($renewal['new_end_date']));
                $data .= "'>";
                $data .= _l('contract_renewal_new_end_date', _d($renewal['new_end_date']));
                $data .= "
                                  </span>
                                <br/>
                                                </div>
                        </div>
                        <hr/>
                    </div>";
            }
            echo $data;
            die();
        } else {
            echo false;
        }
    }

    public function add_warnings_type()
    {
        $data = $this->input->post();
        $id = $this->hr_profile_model->add_warnings_type($data);
        if ($id) {
            set_alert('success', _l('added successfuly'));
            redirect(admin_url('hr_profile/setting?group=warnings'));
        }
        set_alert('warning', _l('thjhhfhgf'));
        redirect(admin_url('hr_profile/setting?group=warnings'));

    }
    public function delete_type_warnings($id)
    {
        $success = $this->hr_profile_model->delete_type_warnings($id);
        if ($success) {
            set_alert('success', _l('deleted successfuly'));
            redirect(admin_url('hr_profile/setting?group=warnings'));
        } else {
            set_alert('warning', _l('thjhhfhgf'));
            redirect(admin_url('hr_profile/setting?group=warnings'));
        }
    }
    public function update_type_warnings()
    {
        $data = $this->input->post();
        $data['name_warnings']=$data['new'];
        unset($data['new']);

        $success = $this->hr_profile_model->update_type_warnings($data['id'], $data);

        if ($success) {
            set_alert('success', _l('up successfuly'));
            redirect(admin_url('hr_profile/setting?group=warnings'));
        } else {
            set_alert('warning', _l('thjhhfhgf'));
            redirect(admin_url('hr_profile/setting?group=warnings'));
        }
    }





//end file
}
ob_end_flush();
?>
