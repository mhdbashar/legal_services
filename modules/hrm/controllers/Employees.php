<?php

defined('BASEPATH') or exit('No direct script access allowed');
set_time_limit(0);

class Employees extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->load->model('employee');
        $ci = &get_instance();
        $ci->load->library(['hr_tabs']);
        //$ci->load->library(['hr_tabs']);
        $this->load->model('hr');
        $this->load->model('Details_model');
        $this->load->model('Workday');
    }

    /* List all Employees */

    public function index() {

        if ($this->input->is_ajax_request()) {
            $this->hrmapp->get_table_data('employees');
        }
        $data['staff_members'] = $this->staff_model->get('', ['active' => 1]);
        $data['title'] = _l('staff_members');
        
        $this->load->view('hrm/manage', $data);
    }

    /* Add new hr employee or edit existing */

    public function member($id = '') {
        if (!has_permission('hr', '', 'view')) {
            access_denied('hr');
        }
        
        if($this->input->get('group') == 'salary'){
            
            if ($this->input->is_ajax_request()) {
                $this->hrmapp->get_table_data('my_payment_table', ['staff_id' => $id]);
            }
        }

        if($this->input->get('group') == 'activities'){
            
            $staff = $this->Details_model->get_staff_name($id);
            $staffname = $staff['firstname'] . ' ' . $staff['lastname'];
            if ($this->input->is_ajax_request()) {
                $this->hrmapp->get_table_data('my_activity_table', ['staffname' => $staffname]);
            }
        }

        if($this->input->get('group') == 'bank'){
            
            if ($this->input->is_ajax_request()) {
                $this->hrmapp->get_table_data('my_bank_table', ['staff_id' => $id]);
            }
        }

        if($this->input->get('group') == 'leave'){
            
            if($this->input->is_ajax_request()){
                $this->hrmapp->get_table_data('my_vac_table', ['staff_id' => $id]);
            }
        }
        

        

        hooks()->do_action('staff_member_edit_view_profile', $id);

        $this->load->model('departments_model');
        if ($this->input->post()) {
            $data = $this->input->post();
            // Don't do XSS clean here.
            $data['email_signature'] = $this->input->post('email_signature', false);
            $data['email_signature'] = html_entity_decode($data['email_signature']);

            $data['password'] = $this->input->post('password', false);

            if ($id == '') {
                if (!has_permission('staff', '', 'create')) {
                    access_denied('staff');
                }
                $id = $this->employee->add($data);
                if ($id) {
                    handle_staff_profile_image_upload($id);
                    set_alert('success', _l('added_successfully', _l('staff_member')));
                    redirect(admin_url('staff/member/' . $id));
                }
            } else {
                if (!has_permission('staff', '', 'edit')) {
                    access_denied('staff');
                }
                handle_staff_profile_image_upload($id);
                $response = $this->employee->update($data, $id);
                if (is_array($response)) {
                    if (isset($response['cant_remove_main_admin'])) {
                        set_alert('warning', _l('staff_cant_remove_main_admin'));
                    } elseif (isset($response['cant_remove_yourself_from_admin'])) {
                        set_alert('warning', _l('staff_cant_remove_yourself_from_admin'));
                    }
                } elseif ($response == true) {
                    set_alert('success', _l('updated_successfully', _l('staff_member')));
                }
                redirect(admin_url('staff/member/' . $id));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('staff_member_lowercase'));
        } else {
            $member = $this->employee->get($id);
            if (!$member) {
                blank_page('Staff Member Not Found', 'danger');
            }
            $data['member'] = $member;
            $title = $member->firstname . ' ' . $member->lastname;
            $data['staff_departments'] = $this->departments_model->get_staff_departments($member->staffid);

            $ts_filter_data = [];
            if ($this->input->get('filter')) {
                if ($this->input->get('range') != 'period') {
                    $ts_filter_data[$this->input->get('range')] = true;
                } else {
                    $ts_filter_data['period-from'] = $this->input->get('period-from');
                    $ts_filter_data['period-to'] = $this->input->get('period-to');
                }
            } else {
                $ts_filter_data['this_month'] = true;
            }

            $data['logged_time'] = $this->employee->get_logged_time_data($id, $ts_filter_data);
            $data['timesheets'] = $data['logged_time']['timesheets'];
        }
        $this->load->model('currencies_model');
        $data['base_currency'] = $this->currencies_model->get_base_currency();
        $data['roles'] = $this->roles_model->get();
        $data['user_notes'] = $this->misc_model->get_notes($id, 'staff');
        $data['departments'] = $this->departments_model->get();
        $data['title'] = $title;


        $tab = $this->input->get('group');
        $data['tab']['slug'] = $tab;
        $data['tab']['view'] = 'hrm/details/' . $tab;
        $data['tab']['info'] = $this->hr_tabs->filter_tab($this->hr_tabs->get_employeedetails_tabs(), $tab);

        if (!$data['tab']) {
            show_404();
        }

        $data['tabs'] = $this->hr_tabs->get_employeedetails_tabs();
        $data['leave_stats'] = json_encode($this->employee->leave_stats());
        $data['id'] = $id;

        $this->load->view('hrm/member', $data);
    }

    public function form_basic($employee_id) {
        if (!has_permission('hr', '', 'view')) {
            /* if (!is_customer_admin($customer_id)) {
              echo _l('access_denied');
              die;
              } */
        }
        $data['employee_id'] = $employee_id;
        $data['title'] = 'Edit Basic information';
        $data['member'] = $this->employee->get($employee_id);

        if ($this->input->post()) {
            $data = $this->input->post();

            if (!has_permission('hr', '', 'edit')) {
                /*
                  if (!is_customer_admin($customer_id)) {
                  header('HTTP/1.0 400 Bad error');
                  echo json_encode([
                  'success' => false,
                  'message' => _l('access_denied'),
                  ]);
                  die;
                  }
                 * *
                 */
            }
            $success = $this->employee->update_employee_basic($data, $employee_id);
            $message = '';
            $updated = false;
            if ($success == true) {
                $updated = true;
                $message = _l('updated_successfully', _l('basic'));
            }


            echo json_encode([
                'success' => $success,
                'message' => $message,
            ]);
            die;
        }

        $this->load->view('admin/modals/basic', $data);
    }
    
    public function banks($employee_id)
    {
        $this->hrmApp->get_table_data('employee_bank', [
            'staff_id' => $employee_id,
        ]);

    }

    

}
