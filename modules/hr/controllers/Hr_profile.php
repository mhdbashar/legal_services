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
}