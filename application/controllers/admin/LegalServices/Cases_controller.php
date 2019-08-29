<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cases_controller extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/LegalServicesModel', 'legal');
        $this->load->model('LegalServices/Cases_model', 'case');
        $this->load->model('Customer_representative_model', 'representative');
        $this->load->model('currencies_model');
        $this->load->model('LegalServices/Case_movement_model', 'movement');
        $this->load->model('LegalServices/Case_session_model', 'case_session');
        $this->load->helper('date');
    }

    public function add($ServID)
    {
        if (!has_permission('projects', '', 'edit') && !has_permission('projects', '', 'create')) {
            access_denied('Projects');
        }
        $ExistServ = $this->legal->CheckExistService($ServID);
        if($ExistServ == 0 || !$ServID){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("Service/$ServID"));
        }
        if ($this->input->post()) {
            $data['description'] = $this->input->post('description', false);
            $data = $this->input->post();
            $added = $this->case->add($ServID,$data);
            if ($added) {
                set_alert('success', _l('added_successfully'));
                redirect(admin_url("Service/$ServID"));
            }
        }
        $data['service'] = $this->legal->get_service_by_id($ServID)->row();
        $data['Numbering'] = $this->case->GetTopNumbering();
        $data['auto_select_billing_type'] = $this->case->get_most_used_billing_type();
        $data['last_case_settings'] = $this->case->get_last_case_settings();
        if (count($data['last_case_settings'])) {
            $key                                       = array_search('available_features', array_column($data['last_case_settings'], 'name'));
            $data['last_case_settings'][$key]['value'] = @unserialize($data['last_case_settings'][$key]['value']);
        }
        $data['settings'] = $this->case->get_settings();
        if ($this->input->get('customer_id')) {
            $data['customer_id'] = $this->input->get('customer_id');
        }
        $data['statuses'] = $this->case->get_project_statuses();
        $data['staff']    = $this->staff_model->get('', ['active' => 1]);
        $data['ServID']   = $ServID;
        $data['title']    = _l('permission_create').' '._l('LegalService');
        $this->load->view('admin/LegalServices/cases/AddCase',$data);
    }

    public function edit($ServID,$id)
    {
        if (!has_permission('projects', '', 'edit') && !has_permission('projects', '', 'create')) {
            access_denied('Projects');
        }
        if(!$id){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("Service/$ServID"));
        }
        if ($this->input->post()) {
            $data = $this->input->post();
            $data['description'] = $this->input->post('description', false);
            //echo "<pre>";print_r($data['judges']);exit;
            $success = $this->case->update($ServID,$id,$data);
            if ($success) {
                set_alert('success', _l('updated_successfully'));
                redirect(admin_url("Service/$ServID"));
            }else {
                set_alert('warning', _l('problem_updating'));
                redirect(admin_url("Service/$ServID"));
            }
        }
        $data['case_members'] = $this->case->get_project_members($id);
        $data['case_judges'] = $this->case->get_case_judges($id);
        $data['service'] = $this->legal->get_service_by_id($ServID)->row();
        $data['case'] = $this->case->get($id);
        $data['case']->settings->available_features = unserialize($data['case']->settings->available_features);
        $data['last_case_settings'] = $this->case->get_last_case_settings();
        if (count($data['last_case_settings'])) {
            $key                                          = array_search('available_features', array_column($data['last_case_settings'], 'name'));
            $data['last_case_settings'][$key]['value'] = @unserialize($data['last_case_settings'][$key]['value']);
        }
        $data['settings'] = $this->case->get_settings();
        if ($this->input->get('customer_id')) {
            $data['customer_id'] = $this->input->get('customer_id');
        }
        $data['statuses'] = $this->case->get_project_statuses();
        $data['staff']    = $this->staff_model->get('', ['active' => 1]);
        $data['ServID']   = $ServID;
        $data['title']    = _l('edit').' '._l('LegalService');
        $this->load->view('admin/LegalServices/cases/EditCase',$data);
    }

    public function delete($ServID,$id)
    {
        if(!$id){
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("Service/$ServID"));
        }
        $response = $this->case->delete($ServID,$id);
        if ($response == true) {
            set_alert('success', _l('deleted'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect(admin_url("Service/$ServID"));
    }

    public function table($clientid = '')
    {
        $this->app->get_table_data('cases', [
            'clientid' => $clientid,
        ]);
    }

    public function staff_projects()
    {
        $this->app->get_table_data('staff_projects');
    }

    public function expenses($id, $slug = '')
    {
        $this->load->model('expenses_model');
        $this->app->get_table_data('case_expenses', [
            'project_id' => $id,
            'slug' => $slug
        ]);
    }

    public function add_expense($ServID = '', $case_id = '')
    {
        if ($this->input->post()) {
            $this->load->model('expenses_model');
            $data = array();
            $data = $this->input->post();
            $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
            $data['rel_stype'] = $slug;
            $data['rel_sid'] = $case_id;
            $id = $this->expenses_model->add_for_case($data);
            if ($id) {
                set_alert('success', _l('added_successfully', _l('expense')));
                echo json_encode([
                    'url'       => admin_url('Case/view/' .$ServID. '/' . $this->input->post('project_id') . '/?group=project_expenses'),
                    'expenseid' => $id,
                ]);
                die;
            }
            echo json_encode([
                'url' => admin_url('Case/view/' .$ServID. '/' . $this->input->post('project_id') . '/?group=project_expenses'),
            ]);
            die;
        }
    }

    public function gantt()
    {
        $data['title']     = _l('project_gant');
        $selected_statuses = [];
        $selectedMember    = null;
        $data['statuses']  = $this->case->get_project_statuses();
        $appliedStatuses   = $this->input->get('status');
        $appliedMember     = $this->input->get('member');
        $allStatusesIds    = [];
        foreach ($data['statuses'] as $status) {
            if (!isset($status['filter_default'])
                || (isset($status['filter_default']) && $status['filter_default'])
                && !$appliedStatuses) {
                $selected_statuses[] = $status['id'];
            } elseif ($appliedStatuses) {
                if (in_array($status['id'], $appliedStatuses)) {
                    $selected_statuses[] = $status['id'];
                }
            } else {
                // All statuses
                $allStatusesIds[] = $status['id'];
            }
        }

        if (count($selected_statuses) == 0) {
            $selected_statuses = $allStatusesIds;
        }

        $data['selected_statuses'] = $selected_statuses;

        if (has_permission('projects', '', 'view')) {
            $selectedMember          = $appliedMember;
            $data['selectedMember']  = $selectedMember;
            $data['project_members'] = $this->case->get_distinct_projects_members();
        }

        $data['gantt_data'] = $this->case->get_all_projects_gantt_data([
            'status' => $selected_statuses,
            'member' => $selectedMember,
        ]);

        $this->load->view('admin/LegalServices/cases/gantt', $data);
    }

    public function view($ServID,$id)
    {
        if (has_permission('projects', '', 'view') || $this->case->is_member($id)) {
            $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
            close_setup_menu();
            $project = $this->case->get($id);

            if (!$project) {
                blank_page(_l('project_not_found'));
            }

            @$project->settings->available_features = @unserialize($project->settings->available_features);
            $data['statuses'] = $this->case->get_project_statuses();

            $group = !$this->input->get('group') ? 'project_overview' : $this->input->get('group');

            // Unable to load the requested file: admin/projects/project_tasks#.php - FIX
            if (strpos($group, '#') !== false) {
                $group = str_replace('#', '', $group);
            }

            $data['tabs'] = get_case_tabs_admin();
            $data['tab']  = $this->app_tabs->filter_tab($data['tabs'], $group);

            if (!$data['tab']) {
                show_404();
            }

            $this->load->model('payment_modes_model');
            $data['payment_modes'] = $this->payment_modes_model->get('', [], true);

            $data['project']  = $project;
            $data['currency'] = $this->case->get_currency($id);

            $data['project_total_logged_time'] = $this->case->total_logged_time($slug, $id);

            $data['staff']     = $this->staff_model->get('', ['active' => 1]);
            $percent           = $this->case->calc_progress($id, $slug);
            $data['bodyclass'] = '';

            $this->app_scripts->add(
                'projects-js',
                base_url($this->app_scripts->core_file('assets/js', 'projects.js')) . '?v=' . $this->app_scripts->core_version(),
                'admin',
                ['app-js', 'jquery-comments-js', 'jquery-gantt-js', 'circle-progress-js']
            );

            if ($group == 'project_overview') {
                $data['members'] = $this->case->get_project_members($id);
                foreach ($data['members'] as $key => $member) {
                    $data['members'][$key]['total_logged_time'] = 0;
                    $member_timesheets = $this->tasks_model->get_unique_member_logged_task_ids($member['staff_id'], ' AND task_id IN (SELECT id FROM ' . db_prefix() . 'tasks WHERE rel_type="'.$slug.'" AND rel_id="' . $id . '")');

                    foreach ($member_timesheets as $member_task) {
                        $data['members'][$key]['total_logged_time'] += $this->tasks_model->calc_task_total_time($member_task->task_id, ' AND staff_id=' . $member['staff_id']);
                    }
                }

                $data['project_total_days']        = round((human_to_unix($data['project']->deadline . ' 00:00') - human_to_unix($data['project']->start_date . ' 00:00')) / 3600 / 24);
                $data['project_days_left']         = $data['project_total_days'];
                $data['project_time_left_percent'] = 100;
                if ($data['project']->deadline) {
                    if (human_to_unix($data['project']->start_date . ' 00:00') < time() && human_to_unix($data['project']->deadline . ' 00:00') > time()) {
                        $data['project_days_left']         = round((human_to_unix($data['project']->deadline . ' 00:00') - time()) / 3600 / 24);
                        $data['project_time_left_percent'] = $data['project_days_left'] / $data['project_total_days'] * 100;
                        $data['project_time_left_percent'] = round($data['project_time_left_percent'], 2);
                    }
                    if (human_to_unix($data['project']->deadline . ' 00:00') < time()) {
                        $data['project_days_left']         = 0;
                        $data['project_time_left_percent'] = 0;
                    }
                }

                $__total_where_tasks = 'rel_type = "'.$slug.'" AND rel_id=' . $id;
                if (!has_permission('tasks', '', 'view')) {
                    $__total_where_tasks .= ' AND ' . db_prefix() . 'tasks.id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid = ' . get_staff_user_id() . ')';

                    if (get_option('show_all_tasks_for_project_member') == 1) {
                        $__total_where_tasks .= ' AND (rel_type="'.$slug.'" AND rel_id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . get_staff_user_id() . '))';
                    }
                }

                $__total_where_tasks = hooks()->apply_filters('admin_total_project_tasks_where', $__total_where_tasks, $id);

                $where = ($__total_where_tasks == '' ? '' : $__total_where_tasks . ' AND ') . 'status != ' . Tasks_model::STATUS_COMPLETE;

                $data['tasks_not_completed'] = total_rows(db_prefix() . 'tasks', $where);
                $total_tasks                 = total_rows(db_prefix() . 'tasks', $__total_where_tasks);
                $data['total_tasks']         = $total_tasks;

                $where = ($__total_where_tasks == '' ? '' : $__total_where_tasks . ' AND ') . 'status = ' . Tasks_model::STATUS_COMPLETE . ' AND rel_type="'.$slug.'" AND rel_id="' . $id . '"';

                $data['tasks_completed'] = total_rows(db_prefix() . 'tasks', $where);

                $data['tasks_not_completed_progress'] = ($total_tasks > 0 ? number_format(($data['tasks_completed'] * 100) / $total_tasks, 2) : 0);
                $data['tasks_not_completed_progress'] = round($data['tasks_not_completed_progress'], 2);

                @$percent_circle        = $percent / 100;
                $data['percent_circle'] = $percent_circle;


                $data['project_overview_chart'] = $this->case->get_project_overview_weekly_chart_data($slug,$id, ($this->input->get('overview_chart') ? $this->input->get('overview_chart'):'this_week'));
            } elseif ($group == 'project_invoices') {
                $this->load->model('invoices_model');

                $data['invoiceid']   = '';
                $data['status']      = '';
                $data['custom_view'] = '';

                $data['invoices_years']       = $this->invoices_model->get_invoices_years();
                $data['invoices_sale_agents'] = $this->invoices_model->get_sale_agents();
                $data['invoices_statuses']    = $this->invoices_model->get_statuses();
            } elseif ($group == 'project_gantt') {
                $gantt_type         = (!$this->input->get('gantt_type') ? 'milestones' : $this->input->get('gantt_type'));
                $taskStatus         = (!$this->input->get('gantt_task_status') ? null : $this->input->get('gantt_task_status'));
                $data['gantt_data'] = $this->case->get_gantt_data($slug, $id, $gantt_type, $taskStatus);
            } elseif ($group == 'project_milestones') {
                $data['bodyclass'] .= 'case-milestones ';
                $data['milestones_exclude_completed_tasks'] = $this->input->get('exclude_completed') && $this->input->get('exclude_completed') == 'yes' || !$this->input->get('exclude_completed');

                $data['total_milestones'] = total_rows(db_prefix() . 'milestones', ['rel_sid' => $id, 'rel_stype' => $slug]);
                $data['milestones_found'] = $data['total_milestones'] > 0 || (!$data['total_milestones'] && total_rows(db_prefix() . 'tasks', ['rel_id' => $id, 'rel_type' => $slug, 'milestone' => 0]) > 0);
            } elseif ($group == 'project_files') {
                $data['files'] = $this->case->get_files($id);
            } elseif ($group == 'project_expenses') {
                $this->load->model('taxes_model');
                $this->load->model('expenses_model');
                $data['taxes']              = $this->taxes_model->get();
                $data['expense_categories'] = $this->expenses_model->get_category();
                $data['currencies']         = $this->currencies_model->get();
            } elseif ($group == 'project_activity') {
                $data['activity'] = $this->case->get_activity($id);
            } elseif ($group == 'project_notes') {
                $data['staff_notes'] = $this->case->get_staff_notes($id);
            } elseif ($group == 'project_estimates') {
                $this->load->model('estimates_model');
                $data['estimates_years']       = $this->estimates_model->get_estimates_years();
                $data['estimates_sale_agents'] = $this->estimates_model->get_sale_agents();
                $data['estimate_statuses']     = $this->estimates_model->get_statuses();
                $data['estimateid']            = '';
                $data['switch_pipeline']       = '';
            } elseif ($group == 'project_tickets') {
                $data['chosen_ticket_status'] = '';
                $this->load->model('tickets_model');
                $data['ticket_assignees'] = $this->tickets_model->get_tickets_assignes_disctinct();

                $this->load->model('departments_model');
                $data['staff_deparments_ids']          = $this->departments_model->get_staff_departments(get_staff_user_id(), true);
                $data['default_tickets_list_statuses'] = hooks()->apply_filters('default_tickets_list_statuses', [1, 2, 4]);
            } elseif ($group == 'project_timesheets') {
                // Tasks are used in the timesheet dropdown
                // Completed tasks are excluded from this list because you can't add timesheet on completed task.
                $data['tasks']                = $this->case->get_tasks($id, 'status != ' . Tasks_model::STATUS_COMPLETE . ' AND billed=0');
                $data['timesheets_staff_ids'] = $this->case->get_distinct_tasks_timesheets_staff($id, $slug);
            } elseif ($group == 'CaseMovement'){
                $data['members']         = $this->case->get_project_members($id);
                $data['movements']       = $this->movement->get($id);
            } elseif ($group == 'CaseSession'){
                $data['service_id']  = $ServID;
                $data['rel_id']      = $id;
                $data['num_session'] = $this->case_session->count_sessions($ServID, $id);
                $data['judges']      = $this->case_session->get_judges();
                $data['courts']      = $this->case_session->get_court();
            }

            // Discussions
            if ($this->input->get('discussion_id')) {
                $data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
                $data['discussion']                        = $this->case->get_discussion($this->input->get('discussion_id'), $id);
                $data['current_user_is_admin']             = is_admin();
            }

            $data['percent'] = $percent;

            $this->app_scripts->add('circle-progress-js', 'assets/plugins/jquery-circle-progress/circle-progress.min.js');
            $this->app_scripts->add('cases-js', 'assets/js/cases.js');
            // $this->app_scripts->add('cases-main-js', 'assets/js/cases_main.js');
            $other_projects       = [];
            $other_projects_where = 'id != ' . $id;

            $statuses = $this->case->get_project_statuses();

            $other_projects_where .= ' AND (';
            foreach ($statuses as $status) {
                if (isset($status['filter_default']) && $status['filter_default']) {
                    $other_projects_where .= 'status = ' . $status['id'] . ' OR ';
                }
            }

            $other_projects_where = rtrim($other_projects_where, ' OR ');

            $other_projects_where .= ')';

            if (!has_permission('projects', '', 'view')) {
                $other_projects_where .= ' AND ' . db_prefix() . 'projects.id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . get_staff_user_id() . ')';
            }

            $data['other_projects'] = $this->case->get($other_projects_where);
            $data['judges_case']    = $this->case->GetJudgesCases($id);
            $data['title']          = $data['project']->name;
            $data['bodyclass']     .= 'project invoices-total-manual estimates-total-manual';
            $data['project_status'] = get_case_status_by_id($project->status);
            $data['service']        = $this->legal->get_service_by_id($ServID)->row();
            $data['case_model']     = $this->case;
            $data['ServID']         = $ServID;
            $this->load->view('admin/LegalServices/cases/view', $data);
        } else {
            access_denied('Project View');
        }
    }

    public function mark_as($slug)
    {
        $ServID = $this->legal->get_service_id_by_slug($slug);
        $success = false;
        $message = '';
        if ($this->input->is_ajax_request()) {
            if (has_permission('projects', '', 'create') || has_permission('projects', '', 'edit')) {
                $status = get_case_status_by_id($this->input->post('status_id'));

                $message = _l('project_marked_as_failed', $status['name']);
                $success = $this->case->mark_as($ServID, $this->input->post(), $slug);

                if ($success) {
                    $message = _l('project_marked_as_success', $status['name']);
                }
            }
        }
        echo json_encode([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function file($id, $project_id)
    {
        $data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
        $data['current_user_is_admin']             = is_admin();

        $data['file'] = $this->case->get_file($id, $project_id);
        if (!$data['file']) {
            header('HTTP/1.0 404 Not Found');
            die;
        }
        $this->load->view('admin/LegalServices/cases/_file', $data);
    }

    public function update_file_data()
    {
        if ($this->input->post()) {
            $this->case->update_file_data($this->input->post());
        }
    }

    public function add_external_file()
    {
        if ($this->input->post()) {
            $data                        = [];
            $data['project_id']          = $this->input->post('project_id');
            $data['files']               = $this->input->post('files');
            $data['external']            = $this->input->post('external');
            $data['visible_to_customer'] = ($this->input->post('visible_to_customer') == 'true' ? 1 : 0);
            $data['staffid']             = get_staff_user_id();
            $this->case->add_external_file($data);
        }
    }

    public function download_all_files($ServID = '', $id)
    {
        if ($this->case->is_member($id) || has_permission('projects', '', 'view')) {
            $files = $this->case->get_files($id);
            if (count($files) == 0) {
                set_alert('warning', _l('no_files_found'));
                redirect(admin_url('Case/view/'.$ServID.'/'. $id . '?group=project_files'));
            }
            $path = get_upload_path_by_type_case('case') . $id;
            $this->load->library('zip');
            foreach ($files as $file) {
                $this->zip->read_file($path . '/' . $file['file_name']);
            }
            $this->zip->download(slug_it(get_case_name_by_id($id)) . '-files.zip');
            $this->zip->clear_data();
        }
    }

    public function export_project_data($ServID, $id)
    {
        if (has_permission('projects', '', 'create')) {
            app_pdf('case-data', LIBSPATH . 'pdf/Case_data_pdf',$ServID, $id);
        }
    }

    public function update_task_milestone()
    {
        if ($this->input->post()) {
            $this->case->update_task_milestone($this->input->post());
        }
    }

    public function update_milestones_order()
    {
        if ($post_data = $this->input->post()) {
            $this->case->update_milestones_order($post_data);
        }
    }

    public function pin_action($project_id)
    {
        $this->case->pin_action($project_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_edit_members($project_id)
    {
        if (has_permission('projects', '', 'edit') || has_permission('projects', '', 'create')) {
            $this->case->add_edit_members($this->input->post(), $project_id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function discussions($project_id, $slug)
    {
        $ServID = $this->legal->get_service_id_by_slug($slug);
        if ($this->case->is_member($project_id) || has_permission('projects', '', 'view')) {
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('case_discussions', [
                    'project_id' => $project_id,
                    'ServID' => $ServID
                ]);
            }
        }
    }

    public function discussion($ServID = '', $id = '')
    {
        if ($this->input->post()) {
            $message = '';
            $success = false;
            if (!$this->input->post('id')) {
                $id = $this->case->add_discussion($this->input->post(), $ServID);
                if ($id) {
                    $success = true;
                    $message = _l('added_successfully', _l('project_discussion'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                ]);
            } else {
                $data = $this->input->post();
                $id   = $data['id'];
                unset($data['id']);
                $success = $this->case->edit_discussion($data, $id);
                if ($success) {
                    $message = _l('updated_successfully', _l('project_discussion'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
            die;
        }
    }

    public function get_discussion_comments($id, $type)
    {
        echo json_encode($this->case->get_discussion_comments($id, $type));
    }

    public function add_discussion_comment($ServID = '',$discussion_id, $type)
    {
        echo json_encode($this->case->add_discussion_comment($ServID, $this->input->post(), $discussion_id, $type));
    }

    public function update_discussion_comment()
    {
        echo json_encode($this->case->update_discussion_comment($this->input->post()));
    }

    public function delete_discussion_comment($id)
    {
        echo json_encode($this->case->delete_discussion_comment($id));
    }

    public function delete_discussion($id)
    {
        $success = false;
        if (has_permission('projects', '', 'delete')) {
            $success = $this->case->delete_discussion($id);
        }
        $alert_type = 'warning';
        $message    = _l('project_discussion_failed_to_delete');
        if ($success) {
            $alert_type = 'success';
            $message    = _l('project_discussion_deleted');
        }
        echo json_encode([
            'alert_type' => $alert_type,
            'message'    => $message,
        ]);
    }

    public function change_milestone_color()
    {
        if ($this->input->post()) {
            $this->case->update_milestone_color($this->input->post());
        }
    }

    public function upload_file($ServID = '',$project_id)
    {
        handle_case_file_uploads($ServID, $project_id);
    }

    public function change_file_visibility($id, $visible)
    {
        if ($this->input->is_ajax_request()) {
            $this->case->change_file_visibility($id, $visible);
        }
    }

    public function change_activity_visibility($id, $visible)
    {
        if (has_permission('projects', '', 'create')) {
            if ($this->input->is_ajax_request()) {
                $this->case->change_activity_visibility($id, $visible);
            }
        }
    }

    public function remove_file($ServID = '', $project_id, $id)
    {
        $this->case->remove_file($id);
        redirect(admin_url('Case/view/' .$ServID .'/'. $project_id . '?group=project_files'));
    }

    public function milestones_kanban($slug = '')
    {
        $data['milestones_exclude_completed_tasks'] = $this->input->get('exclude_completed_tasks') && $this->input->get('exclude_completed_tasks') == 'yes';

        $data['project_id'] = $this->input->get('project_id');
        $data['milestones'] = [];

        $data['milestones'][] = [
            'name'              => _l('milestones_uncategorized'),
            'id'                => 0,
            'total_logged_time' => $this->case->calc_milestone_logged_time($data['project_id'], 0),
            'color'             => null,
        ];

        $_milestones = $this->case->get_milestones($slug, $data['project_id']);

        foreach ($_milestones as $m) {
            $data['milestones'][] = $m;
        }

        echo $this->load->view('admin/LegalServices/cases/milestones_kan_ban', $data, true);
    }

    public function milestones_kanban_load_more()
    {
        $milestones_exclude_completed_tasks = $this->input->get('exclude_completed_tasks') && $this->input->get('exclude_completed_tasks') == 'yes';

        $status     = $this->input->get('status');
        $page       = $this->input->get('page');
        $project_id = $this->input->get('project_id');
        $where      = [];
        if ($milestones_exclude_completed_tasks) {
            $where['status !='] = Tasks_model::STATUS_COMPLETE;
        }
        $tasks = $this->case->do_milestones_kanban_query($status, $project_id, $page, $where);
        foreach ($tasks as $task) {
            $this->load->view('admin/LegalServices/cases/_milestone_kanban_card', ['task' => $task, 'milestone' => $status]);
        }
    }

    public function milestones($project_id, $ServID, $slug)
    {

        if ($this->case->is_member($project_id) || has_permission('projects', '', 'view')) {
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('milestones_case', [
                    'project_id' => $project_id,
                    'ServID' => $ServID,
                    'slug' => $slug
                ]);
            }
        }
    }

    public function milestone($ServID = '', $id = '')
    {
        if ($this->input->post()) {
            $message = '';
            $success = false;
            if (!$this->input->post('id')) {
                $id = $this->case->add_milestone($ServID, $this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('project_milestone')));
                }
            } else {
                $data = $this->input->post();
                $id   = $data['id'];
                unset($data['id']);
                $success = $this->case->update_milestone($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('project_milestone')));
                }
            }
        }

        redirect(admin_url('Case/view/'.$ServID. '/' . $this->input->post('rel_sid') . '?group=project_milestones'));
    }

    public function delete_milestone($ServID='',$project_id, $id)
    {
        if (has_permission('projects', '', 'delete')) {
            if ($this->case->delete_milestone($id)) {
                set_alert('deleted', 'project_milestone');
            }
        }
        redirect(admin_url('Case/view/' .$ServID.'/'. $project_id . '?group=project_milestones'));
    }

    public function bulk_action_files()
    {
        hooks()->do_action('before_do_bulk_action_for_project_files');
        $total_deleted       = 0;
        $hasPermissionDelete = has_permission('projects', '', 'delete');
        // bulk action for projects currently only have delete button
        if ($this->input->post()) {
            $fVisibility = $this->input->post('visible_to_customer') == 'true' ? 1 : 0;
            $ids         = $this->input->post('ids');
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    if ($hasPermissionDelete && $this->input->post('mass_delete') && $this->case->remove_file($id)) {
                        $total_deleted++;
                    } else {
                        $this->case->change_file_visibility($id, $fVisibility);
                    }
                }
            }
        }
        if ($this->input->post('mass_delete')) {
            set_alert('success', _l('total_files_deleted', $total_deleted));
        }
    }

    public function timesheets($project_id, $slug)
    {
        if ($this->case->is_member($project_id) || has_permission('projects', '', 'view')) {
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('timesheets_case', [
                    'project_id' => $project_id,
                    'slug' => $slug
                ]);
            }
        }
    }

    public function timesheet()
    {
        if ($this->input->post()) {
            $message = '';
            $success = false;
            $success = $this->tasks_model->timesheet($this->input->post());
            if ($success === true) {
                $message = _l('added_successfully', _l('project_timesheet'));
            } elseif (is_array($success) && isset($success['end_time_smaller'])) {
                $message = _l('failed_to_add_project_timesheet_end_time_smaller');
            } else {
                $message = _l('project_timesheet_not_updated');
            }
            echo json_encode([
                'success' => $success,
                'message' => $message,
            ]);
            die;
        }
    }

    public function timesheet_task_assignees($task_id, $project_id, $staff_id = 'undefined')
    {
        $assignees             = $this->tasks_model->get_task_assignees($task_id);
        $data                  = '';
        $has_permission_edit   = has_permission('projects', '', 'edit');
        $has_permission_create = has_permission('projects', '', 'edit');
        // The second condition if staff member edit their own timesheet
        if ($staff_id == 'undefined' || $staff_id != 'undefined' && (!$has_permission_edit || !$has_permission_create)) {
            $staff_id     = get_staff_user_id();
            $current_user = true;
        }
        foreach ($assignees as $staff) {
            $selected = '';
            // maybe is admin and not project member
            if ($staff['assigneeid'] == $staff_id && $this->case->is_member($project_id, $staff_id)) {
                $selected = ' selected';
            }
            if ((!$has_permission_edit || !$has_permission_create) && isset($current_user)) {
                if ($staff['assigneeid'] != $staff_id) {
                    continue;
                }
            }
            $data .= '<option value="' . $staff['assigneeid'] . '"' . $selected . '>' . get_staff_full_name($staff['assigneeid']) . '</option>';
        }
        echo $data;
    }

    public function remove_team_member($ServID,$project_id, $staff_id)
    {
        if (has_permission('projects', '', 'edit') || has_permission('projects', '', 'create')) {
            if ($this->case->remove_team_member($ServID,$project_id, $staff_id)) {
                set_alert('success', _l('project_member_removed'));
            }
        }
        redirect(admin_url('Case/view/' . $ServID.'/'.$project_id));
    }

    public function save_note($ServID = '', $project_id)
    {
        if ($this->input->post()) {
            $success = $this->case->save_note($this->input->post(null, false), $project_id);
            if ($success) {
                set_alert('success', _l('updated_successfully', _l('project_note')));
            }
            redirect(admin_url('Case/view/' .$ServID.'/'. $project_id . '?group=project_notes'));
        }
    }

    public function copy($ServID,$project_id)
    {
        if (has_permission('projects', '', 'create')) {
            $id = $this->case->copy($ServID,$project_id, $this->input->post());
            if ($id) {
                set_alert('success', _l('project_copied_successfully'));
                redirect(admin_url('Case/view/' .$ServID.'/'. $id));
            } else {
                set_alert('danger', _l('failed_to_copy_project'));
                redirect(admin_url('Case/view/' .$ServID.'/'. $project_id));
            }
        }
    }

    public function mass_stop_timers($project_id, $billable = 'false')
    {
        if (has_permission('invoices', '', 'create')) {
            $where = [
                'billed'       => 0,
                'startdate <=' => date('Y-m-d'),
            ];
            if ($billable == 'true') {
                $where['billable'] = true;
            }
            $tasks                = $this->case->get_tasks($project_id, $where);
            $total_timers_stopped = 0;
            foreach ($tasks as $task) {
                $this->db->where('task_id', $task['id']);
                $this->db->where('end_time IS NULL');
                $this->db->update(db_prefix() . 'taskstimers', [
                    'end_time' => time(),
                ]);
                $total_timers_stopped += $this->db->affected_rows();
            }
            $message = _l('project_tasks_total_timers_stopped', $total_timers_stopped);
            $type    = 'success';
            if ($total_timers_stopped == 0) {
                $type = 'warning';
            }
            echo json_encode([
                'type'    => $type,
                'message' => $message,
            ]);
        }
    }

    public function get_pre_invoice_project_info($ServID, $project_id)
    {
        if (has_permission('invoices', '', 'create')) {
            $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
            $data['billable_tasks'] = $this->case->get_tasks($ServID,$project_id, [
                'billable'     => 1,
                'billed'       => 0,
                'startdate <=' => date('Y-m-d'),
            ]);

            $data['not_billable_tasks'] = $this->case->get_tasks($project_id, [
                'billable'    => 1,
                'billed'      => 0,
                'startdate >' => date('Y-m-d'),
            ]);

            $data['project_id']   = $project_id;
            $data['ServID']       = $ServID;
            $data['billing_type'] = get_case_billing_type($project_id);

            $this->load->model('expenses_model');
            $this->db->where('invoiceid IS NULL');
            $data['expenses'] = $this->expenses_model->get('', [
                'rel_sid'    => $project_id,
                'rel_stype'  => $slug,
                'billable'  => 1,
            ]);

            $this->load->view('admin/LegalServices/cases/project_pre_invoice_settings', $data);
        }
    }

    public function get_invoice_project_data($ServID)
    {
        if (has_permission('invoices', '', 'create')) {
            $type       = $this->input->post('type');
            $project_id = $this->input->post('project_id');
            // Check for all cases
            if ($type == '') {
                $type == 'single_line';
            }
            $this->load->model('payment_modes_model');
            $data['payment_modes'] = $this->payment_modes_model->get('', [
                'expenses_only !=' => 1,
            ]);
            $this->load->model('taxes_model');
            $data['taxes']         = $this->taxes_model->get();
            $data['currencies']    = $this->currencies_model->get();
            $data['base_currency'] = $this->currencies_model->get_base_currency();
            $this->load->model('invoice_items_model');

            $data['ajaxItems'] = false;
            if (total_rows(db_prefix() . 'items') <= ajax_on_total_items()) {
                $data['items'] = $this->invoice_items_model->get_grouped();
            } else {
                $data['items']     = [];
                $data['ajaxItems'] = true;
            }

            $data['items_groups'] = $this->invoice_items_model->get_groups();
            $data['staff']        = $this->staff_model->get('', ['active' => 1]);
            $project              = $this->case->get($project_id);
            $data['project']      = $project;
            $items                = [];

            $project    = $this->case->get($project_id);
            $item['id'] = 0;

            $default_tax     = @unserialize(get_option('default_tax'));
            $item['taxname'] = $default_tax;

            $tasks = $this->input->post('tasks');
            if ($tasks) {
                $item['long_description'] = '';
                $item['qty']              = 0;
                $item['task_id']          = [];
                if ($type == 'single_line') {
                    $item['description'] = $project->name;
                    foreach ($tasks as $task_id) {
                        $task = $this->tasks_model->get($task_id);
                        $sec  = $this->tasks_model->calc_task_total_time($task_id);
                        $item['long_description'] .= $task->name . ' - ' . seconds_to_time_format($sec) . ' ' . _l('hours') . "\r\n";
                        $item['task_id'][] = $task_id;
                        if ($project->billing_type == 2) {
                            if ($sec < 60) {
                                $sec = 0;
                            }
                            $item['qty'] += sec2qty($sec);
                        }
                    }
                    if ($project->billing_type == 1) {
                        $item['qty']  = 1;
                        $item['rate'] = $project->project_cost;
                    } elseif ($project->billing_type == 2) {
                        $item['rate'] = $project->project_rate_per_hour;
                    }
                    $item['unit'] = '';
                    $items[]      = $item;
                } elseif ($type == 'task_per_item') {
                    foreach ($tasks as $task_id) {
                        $task                     = $this->tasks_model->get($task_id);
                        $sec                      = $this->tasks_model->calc_task_total_time($task_id);
                        $item['description']      = $project->name . ' - ' . $task->name;
                        $item['qty']              = floatVal(sec2qty($sec));
                        $item['long_description'] = seconds_to_time_format($sec) . ' ' . _l('hours');
                        if ($project->billing_type == 2) {
                            $item['rate'] = $project->project_rate_per_hour;
                        } elseif ($project->billing_type == 3) {
                            $item['rate'] = $task->hourly_rate;
                        }
                        $item['task_id'] = $task_id;
                        $item['unit']    = '';
                        $items[]         = $item;
                    }
                } elseif ($type == 'timesheets_individualy') {
                    $timesheets     = $this->case->get_timesheets($project_id, $tasks);
                    $added_task_ids = [];
                    foreach ($timesheets as $timesheet) {
                        if ($timesheet['task_data']->billed == 0 && $timesheet['task_data']->billable == 1) {
                            $item['description'] = $project->name . ' - ' . $timesheet['task_data']->name;
                            if (!in_array($timesheet['task_id'], $added_task_ids)) {
                                $item['task_id'] = $timesheet['task_id'];
                            }

                            array_push($added_task_ids, $timesheet['task_id']);

                            $item['qty']              = floatVal(sec2qty($timesheet['total_spent']));
                            $item['long_description'] = _l('project_invoice_timesheet_start_time', _dt($timesheet['start_time'], true)) . "\r\n" . _l('project_invoice_timesheet_end_time', _dt($timesheet['end_time'], true)) . "\r\n" . _l('project_invoice_timesheet_total_logged_time', seconds_to_time_format($timesheet['total_spent'])) . ' ' . _l('hours');

                            if ($this->input->post('timesheets_include_notes') && $timesheet['note']) {
                                $item['long_description'] .= "\r\n\r\n" . _l('note') . ': ' . $timesheet['note'];
                            }

                            if ($project->billing_type == 2) {
                                $item['rate'] = $project->project_rate_per_hour;
                            } elseif ($project->billing_type == 3) {
                                $item['rate'] = $timesheet['task_data']->hourly_rate;
                            }
                            $item['unit'] = '';
                            $items[]      = $item;
                        }
                    }
                }
            }
            if ($project->billing_type != 1) {
                $data['hours_quantity'] = true;
            }
            if ($this->input->post('expenses')) {
                if (isset($data['hours_quantity'])) {
                    unset($data['hours_quantity']);
                }
                if (count($tasks) > 0) {
                    $data['qty_hrs_quantity'] = true;
                }
                $expenses       = $this->input->post('expenses');
                $addExpenseNote = $this->input->post('expenses_add_note');
                $addExpenseName = $this->input->post('expenses_add_name');

                if (!$addExpenseNote) {
                    $addExpenseNote = [];
                }

                if (!$addExpenseName) {
                    $addExpenseName = [];
                }

                $this->load->model('expenses_model');
                foreach ($expenses as $expense_id) {
                    // reset item array
                    $item                     = [];
                    $item['id']               = 0;
                    $expense                  = $this->expenses_model->get($expense_id);
                    $item['expense_id']       = $expense->expenseid;
                    $item['description']      = _l('item_as_expense') . ' ' . $expense->name;
                    $item['long_description'] = $expense->description;

                    if (in_array($expense_id, $addExpenseNote) && !empty($expense->note)) {
                        $item['long_description'] .= PHP_EOL . $expense->note;
                    }

                    if (in_array($expense_id, $addExpenseName) && !empty($expense->expense_name)) {
                        $item['long_description'] .= PHP_EOL . $expense->expense_name;
                    }

                    $item['qty'] = 1;

                    $item['taxname'] = [];
                    if ($expense->tax != 0) {
                        array_push($item['taxname'], $expense->tax_name . '|' . $expense->taxrate);
                    }
                    if ($expense->tax2 != 0) {
                        array_push($item['taxname'], $expense->tax_name2 . '|' . $expense->taxrate2);
                    }
                    $item['rate']  = $expense->amount;
                    $item['order'] = 1;
                    $item['unit']  = '';
                    $items[]       = $item;
                }
            }
            $data['customer_id']          = $project->clientid;
            $data['invoice_from_project'] = true;
            $data['add_items']            = $items;
            $data['ServID']               = $ServID;
            $this->load->view('admin/LegalServices/cases/invoice_project', $data);
        }
    }

    public function get_rel_project_data($id, $task_id = '')
    {
        if ($this->input->is_ajax_request()) {
            $selected_milestone = '';
            if ($task_id != '' && $task_id != 'undefined') {
                $task               = $this->tasks_model->get($task_id);
                $selected_milestone = $task->milestone;
            }

            $allow_to_view_tasks = 0;
            $this->db->where('case_id', $id);
            $this->db->where('name', 'view_tasks');
            $project_settings = $this->db->get(db_prefix() . 'case_settings')->row();
            if ($project_settings) {
                $allow_to_view_tasks = $project_settings->value;
            }

            $deadline = get_case_deadline($id);

            echo json_encode([
                'deadline'            => $deadline,
                'deadline_formatted'  => $deadline ? _d($deadline) : null,
                'allow_to_view_tasks' => $allow_to_view_tasks,
                'billing_type'        => get_case_billing_type($id),
                'milestones'          => render_select('milestone', $this->case->get_milestones($id), [
                    'id',
                    'name',
                ], 'task_milestone', $selected_milestone),
            ]);
        }
    }

    public function invoice_project($ServID, $project_id)
    {
        if (has_permission('invoices', '', 'create')) {
            $this->load->model('invoices_model');
            $data               = $this->input->post();
            $data['project_id'] = $project_id;
            $invoice_id         = $this->invoices_model->add($data);
            if ($invoice_id) {
                $this->case->log_activity($project_id, 'project_activity_invoiced_project', format_invoice_number($invoice_id));
                set_alert('success', _l('project_invoiced_successfully'));
            }
            redirect(admin_url('Case/view/' .$ServID.'/'. $project_id . '?group=project_invoices'));
        }
    }

    public function view_project_as_client($id, $clientid)
    {
        if (is_admin()) {
            login_as_client($clientid);
            redirect(site_url('clients/project/' . $id));
        }
    }

}
