<?php

class Core_hr extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Awards_model');
        $this->load->model('Staff_model');
        $this->load->library('hrmapp');
        $this->load->model('Terminations_model');
        $this->load->model('Designation_model');
        $this->load->model('Resignations_model');
        $this->load->model('Complaint_model');
        $this->load->model('Travel_model');
        $this->load->model('Promotion_model');
        $this->load->model('Transfers_model');
        $this->load->model('Warnings_model');







        // $this->load->model('No_branch_model');

        if (!has_permission('hr', '', 'view_own') && !has_permission('hr', '', 'view'))
            access_denied();

//        $total_complete_staffs = $this->db->count_all_results(db_prefix() . 'hr_extra_info');
//        $total_staffs = $this->db->count_all_results(db_prefix() . 'staff');
//        if($total_complete_staffs != $total_staffs) {
//            set_alert('warning', _l('you_have_to_complete_staff_informations'));
//            redirect(admin_url('hr/general/staff'));
//        }
	}
    // awards

    public function awards(){
        if($this->input->is_ajax_request()){
            $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_awards_table'));

        }
//            if($this->app_modules->is_active('branches')) {
//            $ci = &get_instance();
//            $ci->load->model('branches/Branches_model');
//            $data['branches'] = $ci->Branches_model->getBranches();
//        }

        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('awards');
        $this->load->view('core_hr/awards/manage', $data);
    }


    public function json_document($id){
//        $branch_id = '';
//        if($this->Branches_model->get('awards', $id))
//            $branch_id = $this->Branches_model->get_branch('awards', $id);
        $data = $this->Awards_model->get($id);
        // $data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_document(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();
        $id = $this->input->post('id');
        $success = $this->Awards_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

            // $this->Branches_model->update_branch('awards', $id, $branch_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_document(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();

        $success = $this->Awards_model->add($data);
        if($success){
            $this->db->where('staffid', $data['staff_id']);
            $staff = $this->db->get(db_prefix() . 'staff')->row();
            $this->db->where('id', $success);
            $award = $this->db->get('hr_awards')->row();
            $template = mail_template('award_staff_to_staff', 'hr', $award, $staff);
            $template->send();
            $description = _l('new_award');
            $staff_id = $staff->staffid;
            $notified = add_notification([
                'description'     => $description,
                'touserid'        => $staff_id,
                'link'            => ('hr/core_hr/awards'),
            ]);
            if ($notified) {
                pusher_trigger_notification([$staff_id]);
            }
            set_alert('success', _l('added_successfully'));
        }
        else
            set_alert('warning', 'Problem Creating');


//        if(is_numeric($branch_id)){
//            $branch_data = [
//                'branch_id' => $branch_id,
//                'rel_type' => 'awards',
//                'rel_id' => $success
//            ];
//            $this->Branches_model->set_branch($branch_data);
//        }
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
        $response = $this->Awards_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // complaint

    public function complaints(){
        if($this->input->is_ajax_request()){
            $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_complaints_table'));

        }
//            if($this->app_modules->is_active('branches')) {
//            $ci = &get_instance();
//            $ci->load->model('branches/Branches_model');
//            $data['branches'] = $ci->Branches_model->getBranches();
//        }

        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('complaints');
        $this->load->view('core_hr/complaints/manage', $data);
    }

    public function complaint_json($id){
//        $branch_id = '';
//        if($this->Branches_model->get('complaints', $id))
//            $branch_id = $this->Branches_model->get_branch('complaints', $id);
        $data = $this->Complaint_model->get($id);
        //$data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_complaint(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();
        $id = $this->input->post('id');
        $success = $this->Complaint_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

            // $this->Branches_model->update_branch('complaints', $id, $branch_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_complaint(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();

        $success = $this->Complaint_model->add($data);
        if($success){
            $this->db->where('id', $success);
            $complaint = $this->db->get('hr_complaints')->row();

            $this->db->where('admin', 1);
            $assignees = $this->staff_model->get();

            foreach ($assignees as $member) {
                $template = mail_template('complaint_staff_to_staff', 'hr', $complaint, array_to_object($member));
                $template->send();
                $description = _l('new_complaint');
                $staff_id = $member['staffid'];
                $notified = add_notification([
                    'description'     => $description,
                    'touserid'        => $staff_id,
                    'link'            => ('hr/core_hr/complaints'),
                ]);
                if ($notified) {
                    pusher_trigger_notification([$staff_id]);
                }
            }
            set_alert('success', _l('added_successfully'));
        }
        else
            set_alert('warning', 'Problem Creating');
//
//
//        if(is_numeric($branch_id)){
//            $branch_data = [
//                'branch_id' => $branch_id,
//                'rel_type' => 'complaints',
//                'rel_id' => $success
//            ];
//            $this->Branches_model->set_branch($branch_data);
//        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_complaint($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Complaint_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // travels

    public function travels(){
        if($this->input->is_ajax_request()){
            $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_travel_table'));

        }
//            if($this->app_modules->is_active('branches')) {
//            $ci = &get_instance();
//            $ci->load->model('branches/Branches_model');
//            $data['branches'] = $ci->Branches_model->getBranches();
//        }

        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('travels');
        $this->load->view('core_hr/travels/manage', $data);
    }

    public function json_travel($id){
//        $branch_id = '';
//        if($this->Branches_model->get('travels', $id))
//            $branch_id = $this->Branches_model->get_branch('travels', $id);
        $data = $this->Travel_model->get($id);
//        $data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_travel(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();
        $id = $this->input->post('id');
        $success = $this->Travel_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

            // $this->Branches_model->update_branch('travels', $id, $branch_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_travel(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();

        $success = $this->Travel_model->add($data);
        if($success){
            $this->db->where('staffid', $data['staff_id']);
            $staff = $this->db->get(db_prefix() . 'staff')->row();
            $this->db->where('id', $success);
            $travel = $this->db->get('hr_travels')->row();
            $template = mail_template('travel_staff_to_staff', 'hr', $travel, $staff);
            $template->send();
            $description = _l('new_travel');
            $staff_id = $staff->staffid;
            $notified = add_notification([
                'description'     => $description,
                'touserid'        => $staff_id,
                'link'            => ('hr/core_hr/travels'),
            ]);
            if ($notified) {
                pusher_trigger_notification([$staff_id]);
            }
            set_alert('success', _l('added_successfully'));
        }
        else
            set_alert('warning', 'Problem Creating');
//
//
//        if(is_numeric($branch_id)){
//            $branch_data = [
//                'branch_id' => $branch_id,
//                'rel_type' => 'travels',
//                'rel_id' => $success
//            ];
//            $this->Branches_model->set_branch($branch_data);
//        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_travel($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Travel_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // promotion

    public function promotions(){
        $this->load->model('Departments_model');
        $data['departments'] = $this->Departments_model->get();
        $data['designations'] = $this->Designation_model->get();
        if($this->input->is_ajax_request()){
            $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_promotions_table'));

        }
//            if($this->app_modules->is_active('branches')) {
//            $ci = &get_instance();
//            $ci->load->model('branches/Branches_model');
//            $data['branches'] = $ci->Branches_model->getBranches();
//        }

   //     $data['staffes'] = $this->Extra_info_model->get_staffs();
        $data['title'] = _l('promotions');
        $this->load->view('core_hr/promotions/manage', $data);
    }

    public function promotion_json($id){
        //$branch_id = '';
        //if($this->Branches_model->get('promotions', $id))
            // $branch_id = $this->Branches_model->get_branch('promotions', $id);
        $data = $this->Promotion_model->get($id);
        // $data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_promotion(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();
        $id = $this->input->post('id');
        $success = $this->Promotion_model->update($data, $id);
        if($success){
            $staff = $data['staff_id'];
            $designation = $data['designation'];
            $this->Designation_model->to_designation($staff, $designation);
            set_alert('success', _l('updated_successfully'));
        }
        else
            set_alert('warning', 'Problem Updating');

        // $this->Branches_model->update_branch('promotions', $id, $branch_id);


        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_promotion(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();

        $success = $this->Promotion_model->add($data);
        if($success){

            $this->db->where('staffid', $data['staff_id']);
            $staff = $this->db->get(db_prefix() . 'staff')->row();
            $this->db->where('id', $success);
            $promotion = $this->db->get('hr_promotions')->row();
            $template = mail_template('promotion_staff_to_staff', 'hr', $promotion, $staff);
            $template->send();
            $description = _l('new_promotion');
            $staff_id = $staff->staffid;
            $notified = add_notification([
                'description'     => $description,
                'touserid'        => $staff_id,
                'link'            => ('hr/core_hr/promotions'),
            ]);
            if ($notified) {
                pusher_trigger_notification([$staff_id]);
            }

            $designation = $data['designation'];
            $staff = $data['staff_id'];
            $this->Designation_model->to_designation($staff, $designation);

            set_alert('success', _l('added_successfully'));
        }
        else
            set_alert('warning', 'Problem Creating');

//
//        if(is_numeric($branch_id)){
//            $branch_data = [
//                'branch_id' => $branch_id,
//                'rel_type' => 'promotions',
//                'rel_id' => $success
//            ];
//            $this->Branches_model->set_branch($branch_data);
//        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_promotion($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Promotion_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // resignation

    public function resignations(){
        if($this->input->is_ajax_request()){
            $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_resignations_table'));

        }
//            if($this->app_modules->is_active('branches')) {
//            $ci = &get_instance();
//            $ci->load->model('branches/Branches_model');
//            $data['branches'] = $ci->Branches_model->getBranches();
//        }

        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('resignations');
        $this->load->view('core_hr/resignations/manage', $data);
    }

    public function json_resignation($id){
//        $branch_id = '';
//        if($this->Branches_model->get('resignations', $id))
//            $branch_id = $this->Branches_model->get_branch('resignations', $id);
        $data = $this->Resignations_model->get($id);
//        $data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_resignation(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();
        $id = $this->input->post('id');
        $success = $this->Resignations_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

//            $this->Branches_model->update_branch('complaints', $id, $branch_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_resignation(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();

        $success = $this->Resignations_model->add($data);
        if($success){
            $this->db->where('staffid', $data['staff_id']);
            $staff = $this->db->get(db_prefix() . 'staff')->row();
            $this->db->where('id', $success);
            $resignation = $this->db->get('hr_resignations')->row();
            $template = mail_template('resignation_staff_to_staff', 'hr', $resignation, $staff);
            $template->send();
            $description = _l('new_resignation');
            $staff_id = $staff->staffid;
            $notified = add_notification([
                'description'     => $description,
                'touserid'        => $staff_id,
                'link'            => ('hr/core_hr/resignations'),
            ]);
            if ($notified) {
                pusher_trigger_notification([$staff_id]);
            }
            set_alert('success', _l('added_successfully'));
        }
        else
            set_alert('warning', 'Problem Creating');


//        if(is_numeric($branch_id)){
//            $branch_data = [
//                'branch_id' => $branch_id,
//                'rel_type' => 'resignations',
//                'rel_id' => $success
//            ];
//            $this->Branches_model->set_branch($branch_data);
//        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_resignation($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Resignations_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // transfers

    public function transfers(){
        $this->load->model('Departments_model');
        $this->load->model('Sub_department_model');

        if($this->input->is_ajax_request()){
            $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_transfers_table'));

        }
//            if($this->app_modules->is_active('branches')) {
//            $ci = &get_instance();
//            $ci->load->model('branches/Branches_model');
//            $data['branches'] = $ci->Branches_model->getBranches();
//        }

        $data['departments'] = $this->Departments_model->get();
        $data['sub_departments'] = $this->Sub_department_model->get();
        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('transfers');
        $this->load->view('core_hr/transfers/manage', $data);
    }


    public function json_transfer($id){
//        $branch_id = '';
//        if($this->Branches_model->get('transfers', $id))
//            $branch_id = $this->Branches_model->get_branch('transfers', $id);
        $data = $this->Transfers_model->get($id);
//        $data->branch_id = $branch_id;
        $data->has_extra_info = $this->Extra_info_model->has_extra_info($data->staff_id);
        echo json_encode($data);
    }

    public function in_hr_system($staff_id){
        echo json_encode(['success'=>true,'data'=>$this->Extra_info_model->has_extra_info($staff_id)]);
        die();
    }
    public function update_transfer(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();
        $id = $this->input->post('id');
        $success = $this->Transfers_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

        $sub_department = $data['to_sub_department'];
        $department = $data['to_department'];
        var_dump($sub_department);
        $staff = $data['staff_id'];

        if($data['status'] == 'Accepted'){

            $this->Transfers_model->in_department($staff, $department);

            $this->Transfers_model->to_sub_department($staff, $sub_department);
        }
            // $this->Branches_model->update_branch('transfers', $id, $branch_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_transfer(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();

        $success = $this->Transfers_model->add($data);
        if($success){
            $this->db->where('staffid', $data['staff_id']);
            $staff = $this->db->get(db_prefix() . 'staff')->row();
            $this->db->where('id', $success);
            $transfer = $this->db->get('hr_transfers')->row();
            $template = mail_template('transfer_staff_to_staff', 'hr', $transfer, $staff);
            $template->send();
            $description = _l('new_transfer');
            $staff_id = $staff->staffid;
            $notified = add_notification([
                'description'     => $description,
                'touserid'        => $staff_id,
                'link'            => ('hr/core_hr/transfer'),
            ]);
            if ($notified) {
                pusher_trigger_notification([$staff_id]);
            }
            set_alert('success', _l('added_successfully'));
        }
        else
            set_alert('warning', 'Problem Creating');
//        if(is_numeric($branch_id)){
//            $branch_data = [
//                'branch_id' => $branch_id,
//                'rel_type' => 'transfers',
//                'rel_id' => $success
//            ];
//            $this->Branches_model->set_branch($branch_data);
//        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_transfer($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Transfers_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // warnings

    public function warnings(){
        if($this->input->is_ajax_request()){
            $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_warnings_table'));

        }
//            if($this->app_modules->is_active('branches')) {
//            $ci = &get_instance();
//            $ci->load->model('branches/Branches_model');
//            $data['branches'] = $ci->Branches_model->getBranches();
//        }

        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('warnings');
        $this->load->view('core_hr/warnings/manage', $data);
    }


    public function json_warning($id){
//        $branch_id = '';
//        if($this->Branches_model->get('warnings', $id))
//            $branch_id = $this->Branches_model->get_branch('warnings', $id);
        $data = $this->Warnings_model->get($id);
//        $data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_warning(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();
        $id = $this->input->post('id');
        $success = $this->Warnings_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

//        if(is_numeric($branch_id)){
//            $this->Branches_model->update_branch('warnings', $id, $branch_id);
//        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_warning(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();

        $success = $this->Warnings_model->add($data);
        if($success){
            $this->db->where('id', $success);
            $warning = $this->db->get('hr_warnings')->row();

            $this->db->where('admin', 1);
            $assignees = $this->staff_model->get();

            foreach ($assignees as $member) {
                $template = mail_template('warning_staff_to_staff', 'hr', $warning, array_to_object($member));
                $template->send();
                    $description = _l('new_warning');
                    $staff_id = $member['staffid'];
                    $notified = add_notification([
                        'description'     => $description,
                        'touserid'        => $staff_id,
                        'link'            => ('hr/core_hr/warnings'),
                    ]);
                    if ($notified) {
                        pusher_trigger_notification([$staff_id]);
                    }
            }
            set_alert('success', _l('added_successfully'));
        }
        else
            set_alert('warning', 'Problem Creating');

//
//        if(is_numeric($branch_id)){
//            $branch_data = [
//                'branch_id' => $branch_id,
//                'rel_type' => 'warnings',
//                'rel_id' => $success
//            ];
//            $this->Branches_model->set_branch($branch_data);
//        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_warning($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Warnings_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    // terminations

    public function terminations(){
        if($this->input->is_ajax_request()){
            $this->app->get_table_data(module_views_path('hr_profile', 'admin/tables/my_terminations_table'));

        }
//            if($this->app_modules->is_active('branches')) {
//            $ci = &get_instance();
//            $ci->load->model('branches/Branches_model');
//            $data['branches'] = $ci->Branches_model->getBranches();
//        }

        $data['staffes'] = $this->Staff_model->get();
        $data['title'] = _l('terminations');
        $this->load->view('core_hr/terminations/manage', $data);
    }


    public function json_termination($id){
//        $branch_id = '';
//        if($this->Branches_model->get('terminations', $id))
//            $branch_id = $this->Branches_model->get_branch('terminations', $id);
        $data = $this->Terminations_model->get($id);
//        $data->branch_id = $branch_id;
        echo json_encode($data);
    }
    public function update_termination(){
        $data = $this->input->post();
//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();
        $id = $this->input->post('id');
        $success = $this->Terminations_model->update($data, $id);
        if($success)
            set_alert('success', _l('updated_successfully'));
        else
            set_alert('warning', 'Problem Updating');

//        if(is_numeric($branch_id)){
//            $this->Branches_model->update_branch('terminations', $id, $branch_id);
//        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_termination(){
        $data = $this->input->post();
        $this->db->where('staffid', $data['staff_id']);
        $staff = $this->db->get(db_prefix() . 'staff')->row();

//        if($this->app_modules->is_active('branches')){
//            $branch_id = $this->input->post()['branch_id'];
//
//            unset($data['branch_id']);
//        }
//        else
//            $branch_id = $this->No_branch_model->get_general_branch();

        $success = $this->Terminations_model->add($data);
        if($success){
            $this->db->where('id', $success);
            $termination = $this->db->get('hr_terminations')->row();
            $template = mail_template('termination_staff_to_staff', 'hr', $termination, $staff);
            $template->send();
            $description = _l('new_termination');
            $staff_id = $staff->staffid;
            $notified = add_notification([
                'description'     => $description,
                'touserid'        => $staff_id,
                'link'            => ('hr/core_hr/terminations'),
            ]);
            if ($notified) {
                pusher_trigger_notification([$staff_id]);
            }
            set_alert('success', _l('added_successfully'));
        }
        else
            set_alert('warning', 'Problem Creating');


//        if(is_numeric($branch_id)){
//            $branch_data = [
//                'branch_id' => $branch_id,
//                'rel_type' => 'terminations',
//                'rel_id' => $success
//            ];
//            $this->Branches_model->set_branch($branch_data);
//        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_termination($id)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        if (!is_admin()) {
            access_denied();
        }
        $response = $this->Terminations_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', 'Problem deleting');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
}