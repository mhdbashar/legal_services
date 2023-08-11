<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Disputes_cases extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('legalservices/LegalServicesModel', 'legal');
        $this->load->model('legalservices/disputes_cases/Disputes_cases_model', 'Dcase');
        $this->load->model('Customer_representative_model', 'representative');
        $this->load->model('currencies_model');
        $this->load->model('legalservices/disputes_cases/Disputes_case_movement_model', 'Dmovement');
        $this->load->model('Branches_model');
        $this->load->model('tasks_model');
        $this->load->model('legalservices/Phase_model', 'phase');
        $this->load->model('legalservices/irac_model', 'irac');
        $this->load->model('legalservices/Legal_procedures_model', 'procedures');
        $this->load->model('Written_reports_model', 'reports');
        $this->load->helper('date');
    }

    public function add($ServID)
    {
        if (!staff_can('edit', 'projects') && !staff_can('create', 'projects')) {
            access_denied('Projects');
        }
        $ExistServ = $this->legal->CheckExistService($ServID);
        if ($ExistServ == 0 || !$ServID) {
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("Service/$ServID"));
        }

        if ($this->input->post()) {
            $data['description'] = $this->input->post('description', false);
            $data = $this->input->post();
            $id = $this->Dcase->add($ServID, $data);
            if ($id) {
                set_alert('success', _l('added_successfully'));
                redirect(admin_url("Disputes_cases/view/$ServID/$id"));
            }
        }

        $data['service'] = $this->legal->get_service_by_id($ServID)->row();
        $data['Numbering'] = $this->Dcase->GetTopNumbering();

        $data['auto_select_billing_type'] = $this->Dcase->get_most_used_billing_type();
        if ($this->input->get('via_estimate_id')) {
            $this->load->model('estimates_model');
            $data['estimate'] = $this->estimates_model->get($this->input->get('via_estimate_id'));
        }

        $data['last_case_settings'] = $this->Dcase->get_last_case_settings();
        if (count($data['last_case_settings'])) {
            $key = array_search('available_features', array_column($data['last_case_settings'], 'name'));
            $data['last_case_settings'][$key]['value'] = @unserialize($data['last_case_settings'][$key]['value']);
        }
        $data['settings'] = $this->Dcase->get_settings();
        if ($this->input->get('customer_id')) {
            $data['customer_id'] = $this->input->get('customer_id');
        }
        $data['statuses'] = $this->Dcase->get_project_statuses();
        $data['staff'] = $this->staff_model->get('', ['active' => 1]);
        $data['ServID'] = $ServID;
        $data['title'] = _l('permission_create') . ' ' . _l('LegalService');
        $data['case_statuses'] = $this->Dcase->get_all_statuses();
        $this->load->view('admin/legalservices/disputes_cases/AddCase', $data);
    }

    public function edit($ServID = '22', $id)
    {
        if (!staff_can('edit', 'projects') && !staff_can('create', 'projects')) {
            access_denied('Projects');
        }
        if (!$id) {
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("Service/$ServID"));
        }
        if ($this->input->post()) {
            $data = $this->input->post();
            $data['description'] = html_purify($this->input->post('description', false));
            $success = $this->Dcase->update($ServID, $id, $data);
            if ($success) {
                set_alert('success', _l('updated_successfully'));
                redirect(admin_url("Disputes_cases/view/$ServID/$id"));
            } else {
                set_alert('warning', _l('problem_updating'));
                redirect(admin_url("Service/$ServID"));
            }
        }
        $data['case_members'] = $this->Dcase->get_project_members($id);
        $data['case_judges'] = $this->Dcase->get_case_judges($id);
        $data['case_opponents'] = $this->Dcase->get_case_opponents($id);
        $data['service'] = $this->legal->get_service_by_id($ServID)->row();
        $data['case'] = $this->Dcase->get($id);
        $data['case']->settings->available_features = unserialize($data['case']->settings->available_features);
        $data['auto_select_billing_type'] = $this->Dcase->get_most_used_billing_type();
        if ($this->input->get('via_estimate_id')) {
            $this->load->model('estimates_model');
            $data['estimate'] = $this->estimates_model->get($this->input->get('via_estimate_id'));
        }
        $data['last_case_settings'] = $this->Dcase->get_last_case_settings();
        if (count($data['last_case_settings'])) {
            $key = array_search('available_features', array_column($data['last_case_settings'], 'name'));
            $data['last_case_settings'][$key]['value'] = @unserialize($data['last_case_settings'][$key]['value']);
        }
        $data['settings'] = $this->Dcase->get_settings();
        if ($this->input->get('customer_id')) {
            $data['customer_id'] = $this->input->get('customer_id');
        }
        $data['statuses'] = $this->Dcase->get_project_statuses();
        $data['staff'] = $this->staff_model->get('', ['active' => 1]);
        $data['ServID'] = $ServID;
        $data['title'] = _l('edit') . ' ' . _l('LegalService');

        $this->load->view('admin/legalservices/disputes_cases/EditCase', $data);
    }

    public function delete($ServID, $id)
    {
        if (staff_can('delete', 'projects')) {
            if (!$id) {
                set_alert('danger', _l('WrongEntry'));
                redirect(admin_url("legalservices/legal_services/legal_recycle_bin/$ServID"));
            }
            $response = $this->Dcase->delete($ServID, $id);
            if ($response == true) {
                set_alert('success', _l('deleted_successfully'));
            } else {
                set_alert('warning', _l('problem_deleting'));
            }
            redirect(admin_url("legalservices/legal_services/legal_recycle_bin/$ServID"));
        }
    }

    public function move_to_recycle_bin($ServID, $id)
    {
        if (!has_permission('legal_recycle_bin', '', 'delete')) {
            access_denied('legal_recycle_bin');
        }
        if (!$id) {
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("Service/$ServID"));
        }
        $response = $this->Dcase->move_to_recycle_bin($ServID, $id);
        if ($response == true) {
            set_alert('success', _l('deleted_successfully'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect(admin_url("Service/$ServID"));
    }

//    public function table($clientid = '', $slug='')
//    {
//        if($slug != ''):
//            $service = $this->db->get_where('my_basic_services', array('slug' => $slug))->row();
//            $model = $this->Dcase;
//            $this->app->get_table_data('disputes_cases', [
//                'clientid' => $clientid,
//                'service' => $service,
//                'model' => $model,
//                'ServID' => $service->id
//            ]);
//        else:
//            $this->app->get_table_data('disputes_cases', [
//                'clientid' => $clientid,
//            ]);
//        endif;
//
//    }
    public function table($clientid = '')
    {
        if (!has_permission('invoices', '', 'view')
            && !has_permission('invoices', '', 'view_own')
            && get_option('allow_staff_view_invoices_assigned') == '0') {
            ajax_access_denied();
        }

        $this->load->model('payment_modes_model');
        $data['payment_modes'] = $this->payment_modes_model->get('', [], true);

        $this->disputes_get_table_data(($this->input->get('recurring') ? 'recurring_invoices' : 'invoices'), [
            'clientid' => $clientid,
            'data' => $data,
        ]);
    }

    public function procurations($case_id)
    {
        $this->app->get_table_data('my_procurations', [
            'disputes_case_id' => $case_id,
            'request' => 'case'
        ]);
    }

    public function staff_cases()
    {
        $this->app->get_table_data('staff_disputes_cases');
    }

    public function expenses($id, $slug = '')
    {
        $this->load->model('expenses_model');
        $this->load->model('payment_modes_model');
        $data['payment_modes'] = $this->payment_modes_model->get('', [], true);
        $this->app->get_table_data('case_expenses', [
            'project_id' => $id,
            'slug' => $slug,
            'data' => $data,
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
            $data['project_id'] = 0;
            $id = $this->expenses_model->add_for_case($data);
            if ($id) {
                set_alert('success', _l('added_successfully', _l('expense')));
                echo json_encode([
                    'url' => admin_url('Disputes_cases/view/' . $ServID . '/' . $this->input->post('project_id') . '/?group=project_expenses'),
                    'expenseid' => $id,
                ]);
                die;
            }
            echo json_encode([
                'url' => admin_url('Disputes_cases/view/' . $ServID . '/' . $this->input->post('project_id') . '/?group=project_expenses'),
            ]);
            die;
        }
    }

    public function gantt()
    {
        $data['title'] = _l('project_gant');
        $selected_statuses = [];
        $selectedMember = null;
        $data['statuses'] = $this->Dcase->get_project_statuses();
        $appliedStatuses = $this->input->get('status');
        $appliedMember = $this->input->get('member');
        $allStatusesIds = [];
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

        if (staff_can('view', 'projects')) {
            $selectedMember = $appliedMember;
            $data['selectedMember'] = $selectedMember;
            $data['project_members'] = $this->Dcase->get_distinct_projects_members();
        }

        $data['gantt_data'] = $this->Dcase->get_all_projects_gantt_data([
            'status' => $selected_statuses,
            'member' => $selectedMember,
        ]);

        $this->load->view('admin/legalservices/disputes_cases/gantt', $data);
    }

    public function view($ServID = '22', $id)
    {
        if (staff_can('view', 'projects') || $this->Dcase->is_member($id)) {
            $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
            $data['slug'] = $slug;
            close_setup_menu();
            $project = $this->Dcase->get($id);
            if (!$project) {
                blank_page(_l('LService_not_found'));
            }

            @$project->settings->available_features = @unserialize($project->settings->available_features);
            $data['statuses'] = $this->Dcase->get_project_statuses();

            $group = !$this->input->get('group') ? 'project_overview' : $this->input->get('group');

            // Unable to load the requested file: admin/projects/project_tasks#.php - FIX
            if (strpos($group, '#') !== false) {
                $group = str_replace('#', '', $group);
            }

            $data['tabs'] = get_disputes_case_tabs_admin();
            $data['tab'] = $this->app_tabs->filter_tab($data['tabs'], $group);

            if (!$data['tab']) {
                show_404();
            }

            $this->load->model('payment_modes_model');
            $data['payment_modes'] = $this->payment_modes_model->get('', [], true);

            $data['project'] = $project;
            $data['currency'] = $this->Dcase->get_currency($id);

            $linked_services = $this->Dcase->get_linked_services($ServID, $id);
            $father_linked_services = [];
            $child_linked_services = [];
            foreach ($linked_services as $linked_service) {
                if ($linked_service->l_service_id == $ServID && $linked_service->rel_id == $id) {
                    $child_linked_services[] = $linked_service;
                } elseif ($linked_service->to_service_id == $ServID && $linked_service->to_rel_id == $id) {
                    $father_linked_services = $linked_service;
                }
            }

            $data['linked_services'] = $linked_services;
            $data['father_linked_services'] = $father_linked_services;
            $data['child_linked_services'] = $child_linked_services;

            $data['project_total_logged_time'] = $this->Dcase->total_logged_time($slug, $id);

            $data['staff'] = $this->staff_model->get('', ['active' => 1]);
            $percent = $this->Dcase->calc_progress($id, $slug);
            $data['bodyclass'] = '';
            //$this->app_scripts->add('cases-js', 'assets/js/cases.js');
            $this->app_scripts->add(
                'disputes_case-js',
                base_url($this->app_scripts->core_file('assets/js', 'disputes_cases.js')) . '?v=' . $this->app_scripts->core_version(),
                'admin',
                ['app-js', 'jquery-comments-js', 'frappe-gantt-js', 'circle-progress-js']
            );
            $this->app_scripts->add('legal_proc', 'assets/js/legal_proc.js');
            if ($group == 'project_overview') {
                $data['members'] = $this->Dcase->get_project_members($id);
                foreach ($data['members'] as $key => $member) {
                    $data['members'][$key]['total_logged_time'] = 0;
                    $member_timesheets = $this->tasks_model->get_unique_member_logged_task_ids($member['staff_id'], ' AND task_id IN (SELECT id FROM ' . db_prefix() . 'tasks WHERE rel_type="' . $slug . '" AND rel_id="' . $this->db->escape_str($id) . '")');

                    foreach ($member_timesheets as $member_task) {
                        $data['members'][$key]['total_logged_time'] += $this->tasks_model->calc_task_total_time($member_task->task_id, ' AND staff_id=' . $member['staff_id']);
                    }
                }

                $data['project_total_days'] = round((human_to_unix($data['project']->deadline . ' 00:00') - human_to_unix($data['project']->start_date . ' 00:00')) / 3600 / 24);
                $data['project_days_left'] = $data['project_total_days'];
                $data['project_time_left_percent'] = 100;
                if ($data['project']->deadline) {
                    if (human_to_unix($data['project']->start_date . ' 00:00') < time() && human_to_unix($data['project']->deadline . ' 00:00') > time()) {
                        $data['project_days_left'] = round((human_to_unix($data['project']->deadline . ' 00:00') - time()) / 3600 / 24);
                        $data['project_time_left_percent'] = $data['project_days_left'] / $data['project_total_days'] * 100;
                        $data['project_time_left_percent'] = round($data['project_time_left_percent'], 2);
                    }
                    if (human_to_unix($data['project']->deadline . ' 00:00') < time()) {
                        $data['project_days_left'] = 0;
                        $data['project_time_left_percent'] = 0;
                    }
                }

                $__total_where_tasks = 'rel_type = "' . $slug . '" AND rel_id=' . $this->db->escape_str($id);
                if (!staff_can('view', 'tasks')) {
                    $__total_where_tasks .= ' AND ' . db_prefix() . 'tasks.id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid = ' . get_staff_user_id() . ')';

                    if (get_option('show_all_tasks_for_project_member') == 1) {
                        $__total_where_tasks .= ' AND (rel_type="' . $slug . '" AND rel_id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . get_staff_user_id() . '))';
                    }
                }

                $__total_where_tasks = hooks()->apply_filters('admin_total_project_tasks_where', $__total_where_tasks, $id);

                $where = ($__total_where_tasks == '' ? '' : $__total_where_tasks . ' AND ') . 'status != ' . Tasks_model::STATUS_COMPLETE;

                $data['tasks_not_completed'] = total_rows(db_prefix() . 'tasks', $where);
                $total_tasks = total_rows(db_prefix() . 'tasks', $__total_where_tasks);
                $data['total_tasks'] = $total_tasks;

                $where = ($__total_where_tasks == '' ? '' : $__total_where_tasks . ' AND ') . 'status = ' . Tasks_model::STATUS_COMPLETE . ' AND rel_type="' . $slug . '" AND rel_id="' . $this->db->escape_str($id) . '"';

                $data['tasks_completed'] = total_rows(db_prefix() . 'tasks', $where);

                $data['tasks_not_completed_progress'] = ($total_tasks > 0 ? number_format(($data['tasks_completed'] * 100) / $total_tasks, 2) : 0);
                $data['tasks_not_completed_progress'] = round($data['tasks_not_completed_progress'], 2);

                @$percent_circle = $percent / 100;
                $data['percent_circle'] = $percent_circle;


                $data['project_overview_chart'] = $this->Dcase->get_project_overview_weekly_chart_data($slug, $id, ($this->input->get('overview_chart') ? $this->input->get('overview_chart') : 'this_week'));
            } elseif ($group == 'project_invoices') {
                $this->load->model('invoices_model');
                $data['invoiceid'] = '';
                $data['status'] = '';
                $data['custom_view'] = '';

                $data['invoices_years'] = $this->invoices_model->get_invoices_years();
                $data['invoices_sale_agents'] = $this->invoices_model->get_sale_agents();
                $data['invoices_statuses'] = $this->invoices_model->get_statuses();
            } elseif ($group == 'disputes_invoices') {
                //$data['tab']['view'] = 'disputes/disputes_invoices';
                $this->load->model('legalservices/disputes_cases/disputes_invoices_model', 'invoices');

                $data['invoiceid'] = '';
                $data['status'] = '';
                $data['custom_view'] = '';

                $data['invoices_years'] = $this->invoices->get_invoices_years();
                $data['invoices_sale_agents'] = $this->invoices->get_sale_agents();
                $data['invoices_statuses'] = $this->invoices->get_statuses();

            } elseif ($group == 'project_gantt') {
                $gantt_type = (!$this->input->get('gantt_type') ? 'milestones' : $this->input->get('gantt_type'));
                $taskStatus = (!$this->input->get('gantt_task_status') ? null : $this->input->get('gantt_task_status'));
                $data['gantt_data'] = $this->Dcase->get_gantt_data($slug, $id, $gantt_type, $taskStatus);
            } elseif ($group == 'project_milestones') {
                $data['bodyclass'] .= 'disputes-case-milestones ';
                $data['milestones_exclude_completed_tasks'] = $this->input->get('exclude_completed') && $this->input->get('exclude_completed') == 'yes' || !$this->input->get('exclude_completed');
                $data['total_milestones'] = total_rows(db_prefix() . 'milestones', ['rel_sid' => $id, 'rel_stype' => $slug]);
                $data['milestones_found'] = $data['total_milestones'] > 0 || (!$data['total_milestones'] && total_rows(db_prefix() . 'tasks', ['rel_id' => $id, 'rel_type' => $slug, 'milestone' => 0, 'is_session' => 0]) > 0);
            } elseif ($group == 'project_files') {
                $data['files'] = $this->Dcase->get_files($id);
            } elseif ($group == 'project_expenses') {
                $this->load->model('taxes_model');
                $this->load->model('expenses_model');
                $data['taxes'] = $this->taxes_model->get();
                $data['expense_categories'] = $this->expenses_model->get_category();
                $data['currencies'] = $this->currencies_model->get();
            } elseif ($group == 'project_activity') {
                $data['activity'] = $this->Dcase->get_activity($id);
            } elseif ($group == 'project_notes') {
                $data['staff_notes'] = $this->Dcase->get_staff_notes($id);
            } elseif ($group == 'project_contracts') {
                $this->load->model('contracts_model');
                $data['contract_types'] = $this->contracts_model->get_contract_types();
                $data['years'] = $this->contracts_model->get_contracts_years();
            } elseif ($group == 'project_estimates') {
                $this->load->model('estimates_model');
                $data['estimates_years'] = $this->estimates_model->get_estimates_years();
                $data['estimates_sale_agents'] = $this->estimates_model->get_sale_agents();
                $data['estimate_statuses'] = $this->estimates_model->get_statuses();
                $data['estimateid'] = '';
                $data['switch_pipeline'] = '';
            } elseif ($group == 'project_tickets') {
                $data['chosen_ticket_status'] = '';
                $this->load->model('tickets_model');
                $data['ticket_assignees'] = $this->tickets_model->get_tickets_assignes_disctinct();

                $this->load->model('departments_model');
                $data['staff_deparments_ids'] = $this->departments_model->get_staff_departments(get_staff_user_id(), true);
                $data['default_tickets_list_statuses'] = hooks()->apply_filters('default_tickets_list_statuses', [1, 2, 4]);
            } elseif ($group == 'project_timesheets') {
                // Tasks are used in the timesheet dropdown
                // Completed tasks are excluded from this list because you can't add timesheet on completed task.
                $data['tasks'] = $this->Dcase->get_tasks($id, 'status != ' . Tasks_model::STATUS_COMPLETE . ' AND billed=0');
                $data['timesheets_staff_ids'] = $this->Dcase->get_distinct_tasks_timesheets_staff($id, $slug);
            } elseif ($group == 'CaseMovement') {
                $data['members'] = $this->Dcase->get_project_members($id);
                $data['movements'] = $this->Dmovement->get($id);
            } elseif ($group == 'CaseSession') {
                $data['service_id'] = $ServID;
                $data['rel_id'] = $id;
                // $data['num_session'] = $this->sessions_model->count_sessions($ServID, $id);
                $data['judges'] = $this->sessions_model->get_judges();
                $data['courts'] = $this->sessions_model->get_court();
            } elseif ($group == 'Phase') {
                $data['phases'] = $this->phase->get_all(['service_id' => $ServID]);
            } elseif ($group == 'IRAC') {
                $data['IRAC'] = $this->irac->get('', ['rel_id' => $id, 'rel_type' => $slug]);
            } elseif ($group == 'Procedures') {
                $data['category'] = $this->procedures->get('', ['type_id' => 2, 'parent_id' => 0]);
                $data['procedure_lists'] = $this->procedures->get_lists_procedure('', ['rel_id' => $id, 'rel_type' => $slug]);
            } elseif ($group == 'help_library') {
                $tags_array = get_service_tags($id, $slug);
                $tags = array();
                foreach ($tags_array as $tag) {
                    $tags[] = $tag['tag'];
                }
                $tags = implode(',', $tags);
                $response = get_books_by_api($tags);
                if (isset($response['error'])):
                    $data['books'] = array();
                else:
                    $data['books'] = json_decode($response);
                endif;
            } elseif ($group == 'written_reports') {
                $data['reports'] = $this->reports->get('', ['rel_id' => $id, 'rel_type' => $slug]);
            }

            // Discussions
            if ($this->input->get('discussion_id')) {
                $data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
                $data['discussion'] = $this->Dcase->get_discussion($this->input->get('discussion_id'), $id);
                $data['current_user_is_admin'] = is_admin();
            }

            $data['percent'] = $percent;

            $this->app_scripts->add('circle-progress-js', 'assets/plugins/jquery-circle-progress/circle-progress.min.js');

            $other_projects = [];
            $other_projects_where = 'id != ' . $id;

            $statuses = $this->Dcase->get_project_statuses();

            $other_projects_where .= ' AND (';
            foreach ($statuses as $status) {
                if (isset($status['filter_default']) && $status['filter_default']) {
                    $other_projects_where .= 'status = ' . $status['id'] . ' OR ';
                }
            }

            $other_projects_where = rtrim($other_projects_where, ' OR ');

            $other_projects_where .= ')';

            if (!staff_can('view', 'projects')) {
                $other_projects_where .= ' AND ' . db_prefix() . 'projects.id IN (SELECT project_id FROM ' . db_prefix() . 'my_disputes_cases_members WHERE staff_id=' . get_staff_user_id() . ')';
            }

            $data['other_projects'] = $this->Dcase->get($other_projects_where);
            $data['judges_case'] = $this->Dcase->GetJudgesCases($id);
            $data['title'] = $data['project']->name;
            $data['bodyclass'] .= 'project invoices-total-manual estimates-total-manual';
            $data['project_status'] = get_disputes_case_status_by_id($project->status);
            $data['service'] = $this->legal->get_service_by_id($ServID)->row();
            $data['case_model'] = $this->Dcase;
            $data['ServID'] = $ServID;
            $data['id'] = $id;
            $this->load->view('admin/legalservices/disputes_cases/view', $data);
        } else {
            access_denied('Case View');
        }
    }

    public function mark_as($slug)
    {
        $ServID = $this->legal->get_service_id_by_slug($slug);
        $success = false;
        $message = '';
        if ($this->input->is_ajax_request()) {
            if (staff_can('create', 'projects') || staff_can('edit', 'projects')) {
                $status = get_case_status_by_id($this->input->post('status_id'));

                $message = _l('project_marked_as_failed', $status['name']);
                $success = $this->Dcase->mark_as($ServID, $this->input->post(), $slug);

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
        $data['current_user_is_admin'] = is_admin();

        $data['file'] = $this->Dcase->get_file($id, $project_id);
        if (!$data['file']) {
            header('HTTP/1.0 404 Not Found');
            die;
        }
        $this->load->view('admin/legalservices/disputes_cases/_file', $data);
    }

    public function update_file_data()
    {
        if ($this->input->post()) {
            $this->Dcase->update_file_data($this->input->post());
        }
    }

    public function add_external_file()
    {
        if ($this->input->post()) {
            $data = [];
            $data['project_id'] = $this->input->post('project_id');
            $data['files'] = $this->input->post('files');
            $data['external'] = $this->input->post('external');
            $data['visible_to_customer'] = ($this->input->post('visible_to_customer') == 'true' ? 1 : 0);
            $data['staffid'] = get_staff_user_id();
            $this->Dcase->add_external_file($data);
        }
    }

    public function download_all_files($ServID = '', $id)
    {
        if ($this->Dcase->is_member($id) || staff_can('view', 'projects')) {
            $files = $this->Dcase->get_files($id);
            if (count($files) == 0) {
                set_alert('warning', _l('no_files_found'));
                redirect(admin_url('Disputes_cases/view/' . $ServID . '/' . $id . '?group=project_files'));
            }
            $path = get_upload_path_by_type_disputes_case('disputes_case') . $id;
            $this->load->library('zip');
            foreach ($files as $file) {
                $this->zip->read_file($path . '/' . $file['file_name']);
            }
            $this->zip->download(slug_it(get_disputes_case_name_by_id($id)) . '-files.zip');
            $this->zip->clear_data();
        }
    }

    public function export_project_data($ServID, $id)
    {
        if (staff_can('create', 'projects')) {
            app_pdf('case-data', LIBSPATH . 'pdf/Disputes_case_data_pdf', $ServID, $id);
        }
    }

    public function update_task_milestone()
    {
        if ($this->input->post()) {
            $this->Dcase->update_task_milestone($this->input->post());
        }
    }

    public function update_milestones_order()
    {
        if ($post_data = $this->input->post()) {
            $this->Dcase->update_milestones_order($post_data);
        }
    }

    public function pin_action($project_id)
    {
        $this->Dcase->pin_action($project_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_edit_members($ServID = '', $project_id)
    {
        if (staff_can('edit', 'projects')) {
            $this->Dcase->add_edit_members($this->input->post(), $ServID, $project_id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function discussions($project_id, $slug)
    {
        $ServID = $this->legal->get_service_id_by_slug($slug);
        if ($this->Dcase->is_member($project_id) || has_permission('projects', '', 'view')) {
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('disputes_case_discussions', [
                    'project_id' => $project_id,
                    'ServID' => $ServID
                ]);
            }
        }
    }

    public function discussion($ServID = '22', $id = '')
    {
        if ($this->input->post()) {
            $message = '';
            $success = false;
            if (!$this->input->post('id')) {
                $id = $this->Dcase->add_discussion($this->input->post(), $ServID);
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
                $id = $data['id'];
                unset($data['id']);
                $success = $this->Dcase->edit_discussion($data, $id);
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
        echo json_encode($this->Dcase->get_discussion_comments($id, $type));
    }

    public function add_discussion_comment($ServID = '', $discussion_id, $type)
    {
        echo json_encode($this->Dcase->add_discussion_comment($ServID, $this->input->post(null, false), $discussion_id, $type));
    }

    public function update_discussion_comment()
    {
        echo json_encode($this->Dcase->update_discussion_comment($this->input->post(null, false)));
    }

    public function delete_discussion_comment($id)
    {
        echo json_encode($this->Dcase->delete_discussion_comment($id));
    }

    public function delete_discussion($id)
    {
        $success = false;
        if (staff_can('delete', 'projects')) {
            $success = $this->Dcase->delete_discussion($id);
        }
        $alert_type = 'warning';
        $message = _l('project_discussion_failed_to_delete');
        if ($success) {
            $alert_type = 'success';
            $message = _l('project_discussion_deleted');
        }
        echo json_encode([
            'alert_type' => $alert_type,
            'message' => $message,
        ]);
    }

    public function change_milestone_color()
    {
        if ($this->input->post()) {
            $this->Dcase->update_milestone_color($this->input->post());
        }
    }

    public function upload_file($ServID = '', $project_id)
    {
        handle_disputes_case_file_uploads($ServID, $project_id);
    }

    public function change_file_visibility($id, $visible)
    {
        if ($this->input->is_ajax_request()) {
            $this->Dcase->change_file_visibility($id, $visible);
        }
    }

    public function change_activity_visibility($id, $visible)
    {
        if (staff_can('create', 'projects')) {
            if ($this->input->is_ajax_request()) {
                $this->Dcase->change_activity_visibility($id, $visible);
            }
        }
    }

    public function remove_file($ServID = '22', $project_id, $id)
    {
        $this->Dcase->remove_file($id);
        redirect(admin_url('Disputes_cases/view/' . $ServID . '/' . $project_id . '?group=project_files'));
    }

    public function milestones_kanban($slug = '')
    {
        $data['milestones_exclude_completed_tasks'] = $this->input->get('exclude_completed_tasks') && $this->input->get('exclude_completed_tasks') == 'yes';

        $data['project_id'] = $this->input->get('project_id');
        $data['milestones'] = [];

        $data['milestones'][] = [
            'name' => _l('milestones_uncategorized'),
            'id' => 0,
            'total_logged_time' => $this->Dcase->calc_milestone_logged_time($data['project_id'], 0),
            'color' => null,
        ];

        $_milestones = $this->Dcase->get_milestones($slug, $data['project_id']);

        foreach ($_milestones as $m) {
            $data['milestones'][] = $m;
        }

        echo $this->load->view('admin/legalservices/disputes_cases/milestones_kan_ban', $data, true);
    }

    public function milestones_kanban_load_more()
    {
        $milestones_exclude_completed_tasks = $this->input->get('exclude_completed_tasks') && $this->input->get('exclude_completed_tasks') == 'yes';

        $status = $this->input->get('status');
        $page = $this->input->get('page');
        $project_id = $this->input->get('project_id');
        $where = [];
        if ($milestones_exclude_completed_tasks) {
            $where['status !='] = Tasks_model::STATUS_COMPLETE;
        }
        $tasks = $this->Dcase->do_milestones_kanban_query($status, $project_id, $page, $where);
        foreach ($tasks as $task) {
            $this->load->view('admin/legalservices/disputes_cases/_milestone_kanban_card', ['task' => $task, 'milestone' => $status]);
        }
    }

    public function milestones($project_id, $ServID, $slug)
    {
        if ($this->Dcase->is_member($project_id) || staff_can('view', 'projects')) {
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('milestones_disputes_case', [
                    'project_id' => $project_id,
                    'ServID' => '22',
                    'slug' => $slug
                ]);
            }
        }
    }

    public function milestone($ServID = '22', $id = '')
    {
        if ($this->input->post()) {
            $message = '';
            $success = false;
            if (!$this->input->post('id')) {
                if (!staff_can('create_milestones', 'projects')) {
                    access_denied();
                }
                $id = $this->Dcase->add_milestone($ServID, $this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('project_milestone')));
                }
            } else {
                if (!staff_can('edit_milestones', 'projects')) {
                    access_denied();
                }
                $data = $this->input->post();
                $id = $data['id'];
                unset($data['id']);
                $success = $this->Dcase->update_milestone($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('project_milestone')));
                }
            }
        }

        redirect(admin_url('Disputes_cases/view/' . $ServID . '/' . $this->input->post('rel_sid') . '?group=project_milestones'));
    }

    public function delete_milestone($ServID = '', $project_id, $id)
    {
        if (staff_can('delete_milestones', 'projects')) {
            if ($this->Dcase->delete_milestone($id)) {
                set_alert('deleted', 'project_milestone');
            }
        }
        redirect(admin_url('Disputes_cases/view/' . $ServID . '/' . $project_id . '?group=project_milestones'));
    }

    public function bulk_action_files()
    {
        hooks()->do_action('before_do_bulk_action_for_project_files');
        $total_deleted = 0;
        $hasPermissionDelete = staff_can('delete', 'projects');
        // bulk action for projects currently only have delete button
        if ($this->input->post()) {
            $fVisibility = $this->input->post('visible_to_customer') == 'true' ? 1 : 0;
            $ids = $this->input->post('ids');
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    if ($hasPermissionDelete && $this->input->post('mass_delete') && $this->Dcase->remove_file($id)) {
                        $total_deleted++;
                    } else {
                        $this->Dcase->change_file_visibility($id, $fVisibility);
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
        if ($this->Dcase->is_member($project_id) || staff_can('view', 'projects')) {
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
        $assignees = $this->tasks_model->get_task_assignees($task_id);
        $data = '';
        $has_permission_edit = staff_can('edit', 'projects');
        $has_permission_create = staff_can('edit', 'projects');
        // The second condition if staff member edit their own timesheet
        if ($staff_id == 'undefined' || $staff_id != 'undefined' && (!$has_permission_edit || !$has_permission_create)) {
            $staff_id = get_staff_user_id();
            $current_user = true;
        }
        foreach ($assignees as $staff) {
            $selected = '';
            // maybe is admin and not project member
            if ($staff['assigneeid'] == $staff_id && $this->Dcase->is_member($project_id, $staff_id)) {
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

    public function remove_team_member($ServID, $project_id, $staff_id)
    {
        if (staff_can('edit', 'projects')) {
            if ($this->Dcase->remove_team_member($ServID, $project_id, $staff_id)) {
                set_alert('success', _l('project_member_removed'));
            }
        }
        redirect(admin_url('Disputes_cases/view/' . $ServID . '/' . $project_id));
    }

    public function save_note($ServID = '', $project_id)
    {
        if ($this->input->post()) {
            $success = $this->Dcase->save_note($this->input->post(null, false), $project_id);
            if ($success) {
                set_alert('success', _l('updated_successfully', _l('project_note')));
            }
            redirect(admin_url('Disputes_cases/view/' . $ServID . '/' . $project_id . '?group=project_notes'));
        }
    }

    public function copy($ServID, $project_id)
    {
        if (staff_can('create', 'projects')) {
            $id = $this->Dcase->copy($ServID, $project_id, $this->input->post());
            if ($id) {
                set_alert('success', _l('project_copied_successfully'));
                redirect(admin_url('Disputes_cases/view/' . $ServID . '/' . $id));
            } else {
                set_alert('danger', _l('failed_to_copy_project'));
                redirect(admin_url('Disputes_cases/view/' . $ServID . '/' . $project_id));
            }
        }
    }

    public function link($ServID, $project_id)
    {
        if (has_permission('projects', '', 'create')) {
            $ServID2 = $this->input->post('service_id');
            $id = $this->Dcase->link($ServID, $project_id, $this->input->post(), $ServID2);
            if ($id) {
                set_alert('success', _l('project_linked_successfully'));
                if ($ServID2 == 1)
                    redirect(admin_url('Case/edit/1/' . $id));
                elseif ($ServID2 == 22)
                    redirect(admin_url('Disputes_cases/view/22/' . $id));
                else
                    redirect(admin_url('SOther/view/' . $ServID2 . '/' . $id));
            } else {
                set_alert('danger', _l('failed_to_link_project'));
                redirect(admin_url('Disputes_cases/view/' . $ServID . '/' . $project_id));
            }
        }
    }

    public function mass_stop_timers($project_id, $billable = 'false')
    {
        if (staff_can('create', 'invoices')) {
            $where = [
                'billed' => 0,
                'startdate <=' => date('Y-m-d'),
            ];
            if ($billable == 'true') {
                $where['billable'] = true;
            }
            $tasks = $this->Dcase->get_tasks($project_id, $where);
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
            $type = 'success';
            if ($total_timers_stopped == 0) {
                $type = 'warning';
            }
            echo json_encode([
                'type' => $type,
                'message' => $message,
            ]);
        }
    }

    public function get_invoice_project_info($ServID, $project_id)
    {
        if (staff_can('create', 'invoices')) {
            $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
            $data['billable_tasks'] = $this->Dcase->get_tasks($project_id, [
                'billable' => 1,
                'billed' => 0,
                'startdate <=' => date('Y-m-d'),
            ]);
            $data['not_billable_tasks'] = $this->Dcase->get_tasks($project_id, [
                'billable' => 1,
                'billed' => 0,
                'startdate >' => date('Y-m-d'),
            ]);

            $data['project_id'] = $project_id;
            $data['ServID'] = $ServID;
            $data['billing_type'] = get_disputes_case_billing_type($project_id);

            $this->load->model('expenses_model');
            $this->db->where('invoiceid IS NULL');
            $data['expenses'] = $this->expenses_model->get('', [
                'rel_sid' => $project_id,
                'rel_stype' => $slug,
                'billable' => 1,
            ]);

            $this->load->view('admin/legalservices/disputes_cases/project_invoice_settings', $data);
        }
    }

    public function get_pre_invoice_project_info($ServID = 22, $project_id)
    {
        if (staff_can('create', 'invoices')) {
            $data['billable_tasks'] = $this->Dcase->get_tasks($project_id, [
                'billable' => 1,
                'billed' => 0,
                'startdate <=' => date('Y-m-d'),
            ]);

            $data['not_billable_tasks'] = $this->Dcase->get_tasks($project_id, [
                'billable' => 1,
                'billed' => 0,
                'startdate >' => date('Y-m-d'),
            ]);

            $data['project_id'] = $project_id;
            $data['billing_type'] = get_disputes_case_billing_type($project_id);

            $this->load->model('expenses_model');
            $this->db->where('invoiceid IS NULL');
            $data['expenses'] = $this->expenses_model->get('', [
                'project_id' => $project_id,
                'billable' => 1,
            ]);
            $this->load->view('admin/legalservices/disputes_cases/project_pre_invoice_settings', $data);
        }
    }

    public function get_invoice_data()
    {
        if (staff_can('create', 'invoices')) {
            $type = $this->input->post('type');
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
            $data['taxes'] = $this->taxes_model->get();
            $data['currencies'] = $this->currencies_model->get();
            $data['base_currency'] = $this->currencies_model->get_base_currency();
            $this->load->model('invoice_items_model');

            $data['ajaxItems'] = false;
            if (total_rows(db_prefix() . 'items') <= ajax_on_total_items()) {
                $data['items'] = $this->invoice_items_model->get_grouped();
            } else {
                $data['items'] = [];
                $data['ajaxItems'] = true;
            }

            $data['items_groups'] = $this->invoice_items_model->get_groups();
            $data['staff'] = $this->staff_model->get('', ['active' => 1]);
            $project = $this->Dcase->get($project_id);
            $data['project'] = $project;
            $items = [];

            $project = $this->Dcase->get($project_id);
            $item['id'] = 0;

            $default_tax = @unserialize(get_option('default_tax'));
            $item['taxname'] = $default_tax;

            $tasks = $this->input->post('tasks');
            if ($tasks) {
                $item['long_description'] = '';
                $item['qty'] = 0;
                $item['task_id'] = [];
                if ($type == 'single_line') {
                    $item['description'] = $project->name;
                    foreach ($tasks as $task_id) {
                        $task = $this->tasks_model->get($task_id);
                        $sec = $this->tasks_model->calc_task_total_time($task_id);
                        $item['long_description'] .= $task->name . ' - ' . seconds_to_time_format(task_timer_round($sec)) . ' ' . _l('hours') . "\r\n";
                        $item['task_id'][] = $task_id;
                        if ($project->billing_type == 2) {
                            if ($sec < 60) {
                                $sec = 0;
                            }
                            $item['qty'] += sec2qty(task_timer_round($sec));
                        } else {
                            if ($sec < 60) {
                                $sec = 0;
                            }
                            $item['qty'] += sec2qty(task_timer_round($sec));
                            $item['rate'] += $task->hourly_rate;
                        }
                    }
                    if ($project->billing_type == 1) {
                        $item['qty'] = 1;
                        $item['rate'] = $project->project_cost;
                    } elseif ($project->billing_type == 2) {
                        $item['rate'] = $project->project_rate_per_hour;
                    }
                    $item['unit'] = '';
                    $items[] = $item;
                } elseif ($type == 'task_per_item') {
                    foreach ($tasks as $task_id) {
                        $task = $this->tasks_model->get($task_id);
                        $sec = $this->tasks_model->calc_task_total_time($task_id);
                        $item['description'] = $project->name . ' - ' . $task->name;
                        $item['qty'] = floatVal(sec2qty(task_timer_round($sec)));
                        $item['long_description'] = seconds_to_time_format(task_timer_round($sec)) . ' ' . _l('hours');
                        if ($project->billing_type == 2) {
                            $item['rate'] = $project->project_rate_per_hour;
                        } elseif ($project->billing_type == 3) {
                            $item['rate'] = $task->hourly_rate;
                        }
                        $item['task_id'] = $task_id;
                        $item['unit'] = '';
                        $items[] = $item;
                    }
                } elseif ($type == 'timesheets_individualy') {
                    $timesheets = $this->Dcase->get_timesheets($project_id, $tasks);
                    $added_task_ids = [];
                    foreach ($timesheets as $timesheet) {
                        if ($timesheet['task_data']->billed == 0 && $timesheet['task_data']->billable == 1) {
                            $item['description'] = $project->name . ' - ' . $timesheet['task_data']->name;
                            if (!in_array($timesheet['task_id'], $added_task_ids)) {
                                $item['task_id'] = $timesheet['task_id'];
                            }

                            array_push($added_task_ids, $timesheet['task_id']);

                            $item['qty'] = floatVal(sec2qty(task_timer_round($timesheet['total_spent'])));
                            $item['long_description'] = _l('project_invoice_timesheet_start_time', _dt($timesheet['start_time'], true)) . "\r\n" . _l('project_invoice_timesheet_end_time', _dt($timesheet['end_time'], true)) . "\r\n" . _l('project_invoice_timesheet_total_logged_time', seconds_to_time_format(task_timer_round($timesheet['total_spent']))) . ' ' . _l('hours');

                            if ($this->input->post('timesheets_include_notes') && $timesheet['note']) {
                                $item['long_description'] .= "\r\n\r\n" . _l('note') . ': ' . $timesheet['note'];
                            }

                            if ($project->billing_type == 2) {
                                $item['rate'] = $project->project_rate_per_hour;
                            } elseif ($project->billing_type == 3) {
                                $item['rate'] = $timesheet['task_data']->hourly_rate;
                            }
                            $item['unit'] = '';
                            $items[] = $item;
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
                $expenses = $this->input->post('expenses');
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
                    $item = [];
                    $item['id'] = 0;
                    $expense = $this->expenses_model->get($expense_id);
                    $item['expense_id'] = $expense->expenseid;
                    $item['description'] = _l('item_as_expense') . ' ' . $expense->name;
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
                    $item['rate'] = $expense->amount;
                    $item['order'] = 1;
                    $item['unit'] = '';
                    $items[] = $item;
                }
            }
            if($project->project_cost > 0){
                $item = [];
                $item['id'] = 0;
                $item['expense_id'] = 1;
                $item['description'] = _l('disputes_case_invoice_description_item');
                $item['long_description'] = _l('disputes_case_invoice_long_description_item');
                $item['qty'] = 1;
                $item['taxname'] = [];
                $item['rate'] = $project->project_cost;
                $item['order'] = 1;
                $item['unit'] = '';
                $items[] = $item;
            }
            $data['customer_id'] = $project->clientid;
            $data['invoice_from_project'] = true;
            $data['add_items'] = $items;
            $data['ServID'] = 22;
            $this->load->view('admin/legalservices/disputes_cases/invoice_project', $data);
        }
    }

    public function get_invoice_data_ajax($id)
    {
        if (!has_permission('invoices', '', 'view')
            && !has_permission('invoices', '', 'view_own')
            && get_option('allow_staff_view_invoices_assigned') == '0') {
            echo _l('access_denied');
            die;
        }

        if (!$id) {
            die(_l('invoice_not_found'));
        }
        $this->load->model('invoices_model');

        $invoice = $this->invoices_model->get($id);

        if (!$invoice || !disputes_user_can_view_invoice($id)) {
            echo _l('invoice_not_found');
            die;
        }

        $invoice->date = _d($invoice->date);
        $invoice->duedate = _d($invoice->duedate);

        $template_name = 'invoice_send_to_customer';

        if ($invoice->sent == 1) {
            $template_name = 'invoice_send_to_customer_already_sent';
        }

        $data = prepare_mail_preview_data($template_name, $invoice->clientid);

        // Check for recorded payments
        $this->load->model('payments_model');
        $data['invoices_to_merge'] = $this->invoices_model->check_for_merge_invoice($invoice->clientid, $id);
        $data['members'] = $this->staff_model->get('', ['active' => 1]);
        $data['payments'] = $this->payments_model->get_invoice_payments($id);
        $data['activity'] = $this->invoices_model->get_invoice_activity($id);
        $data['totalNotes'] = total_rows(db_prefix() . 'notes', ['rel_id' => $id, 'rel_type' => 'invoice']);
        $data['invoice_recurring_invoices'] = $this->invoices_model->get_invoice_recurring_invoices($id);

        $data['applied_credits'] = $this->credit_notes_model->get_applied_invoice_credits($id);
        // This data is used only when credit can be applied to invoice
        if (credits_can_be_applied_to_invoice($invoice->status)) {
            $data['credits_available'] = $this->credit_notes_model->total_remaining_credits_by_customer($invoice->clientid);

            if ($data['credits_available'] > 0) {
                $data['open_credits'] = $this->credit_notes_model->get_open_credits($invoice->clientid);
            }

            $customer_currency = $this->clients_model->get_customer_default_currency($invoice->clientid);
            $this->load->model('currencies_model');

            if ($customer_currency != 0) {
                $data['customer_currency'] = $this->currencies_model->get($customer_currency);
            } else {
                $data['customer_currency'] = $this->currencies_model->get_base_currency();
            }
        }

        $data['invoice'] = $invoice;

        $data['record_payment'] = false;

        if ($this->session->has_userdata('record_payment')) {
            $data['record_payment'] = true;
            $this->session->unset_userdata('record_payment');
        }

        $this->load->view('admin/invoices/invoice_preview_template', $data);
    }

    public function get_invoice_project_data()
    {
        if (staff_can('create', 'invoices')) {
            $type = $this->input->post('type');
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
            $data['taxes'] = $this->taxes_model->get();
            $data['currencies'] = $this->currencies_model->get();
            $data['base_currency'] = $this->currencies_model->get_base_currency();
            $this->load->model('invoice_items_model');


            $current_next_invoice_number = get_option('next_disputes_invoice_number');
            if (!$current_next_invoice_number) {
                add_option('next_disputes_invoice_number', '1');
            }

            $data['ajaxItems'] = false;
            if (total_rows(db_prefix() . 'items') <= ajax_on_total_items()) {
                $data['items'] = $this->invoice_items_model->get_grouped();
            } else {
                $data['items'] = [];
                $data['ajaxItems'] = true;
            }

            $data['items_groups'] = $this->invoice_items_model->get_groups();
            $data['staff'] = $this->staff_model->get('', ['active' => 1]);
            $project = $this->Dcase->get($project_id);
            $data['project'] = $project;
            $items = [];

            // Extract meta values of this project

            $data['currency'] = $this->Dcase->get_currency($project_id);
//            $meta = $this->Disputes_model->get_project_meta($project_id);
//            $data['meta'] = array();
//            foreach ($meta as $array) {
//                $data['meta'][$array['meta_key']] = $array['meta_value'];
//            }
            $item['id'] = 0;
            $default_tax = unserialize(get_option('default_tax'));
            $item['taxname'] = $default_tax;

            $tasks = $this->input->post('tasks');
            if ($tasks) {
                $item['long_description'] = '';
                $item['qty'] = 0;
                $item['task_id'] = [];
                if ($type == 'single_line') {
                    $item['description'] = $project->name;
                    foreach ($tasks as $task_id) {
                        $task = $this->tasks_model->get($task_id);
                        $sec = $this->tasks_model->calc_task_total_time($task_id);
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
                        $item['qty'] = 1;
                        //$item['rate'] = $project->project_cost;
                    } elseif ($project->billing_type == 2) {
                        //$item['rate'] = $project->project_rate_per_hour;
                    }
                    $item['rate'] = 0;
                    $item['unit'] = '';
                    $items[] = $item;
                }/* elseif ($type == 'task_per_item') {
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
                    $timesheets     = $this->projects_model->get_timesheets($project_id, $tasks);
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
                }*/
            }
            if ($project->billing_type != 1) {
                //$data['hours_quantity'] = true;
            }

            if ($this->input->post('expenses')) {
                if (isset($data['hours_quantity'])) {
                    unset($data['hours_quantity']);
                }
                if (count($tasks) > 0) {
                    $data['qty_hrs_quantity'] = true;
                }
                $expenses = $this->input->post('expenses');
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
                    $item = [];
                    $item['id'] = 0;
                    $expense = $this->expenses_model->get($expense_id);
                    $item['expense_id'] = $expense->expenseid;
                    $item['description'] = _l('item_as_expense') . ' ' . $expense->name;
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
                    $item['rate'] = $expense->amount;
                    $item['order'] = 1;
                    $item['unit'] = '';
                    $items[] = $item;
                }
            }
            $data['customer_id'] = $project->clientid;
            //noor edite
//            $opponents = explode(',', isset($data['meta']['opponent_id'])?$data['meta']['opponent_id']:'');
            $opponents = get_disputes_cases_opponents_by_case_id($project->id);
            $data['opponents'] = [];
            foreach ($opponents as $opponent) {
                if ($opponent->opponent_id > 0) $data['opponents'][] = $this->clients_model->get($opponent->opponent_id);
            }

            $data['invoice_from_project'] = true;
            $data['add_items'] = $items;
            $this->load->view('admin/legalservices/disputes_cases/invoices/invoice_project', $data);
        }
    }

    public function invoice($project_id)
    {
        if (staff_can('create', 'invoices')) {
            $slug = $this->legal->get_service_by_id(22)->row()->slug;
            $this->load->model('invoices_model');
            $data = $this->input->post();
            $data['rel_stype'] = $slug;
            $data['rel_sid'] = $project_id;
            $data['project_id'] = null;
            $invoice_id = $this->invoices_model->add($data);
            if ($invoice_id) {
                $this->db->where('id', $project_id);
                $this->db->update(db_prefix() . 'my_disputes_cases', ['is_invoiced' => '1']);
                $this->Dcase->log_activity($project_id, 'LService_activity_invoiced_project', format_invoice_number($invoice_id));
                set_alert('success', _l('project_invoiced_successfully'));
            }
            redirect(admin_url('Disputes_cases/view/22/' . $project_id . '?group=project_invoices'));
        }
    }


    public function view_project_as_client($id, $clientid, $ServID = '')
    {
        if (is_admin()) {
            login_as_client($clientid);
            redirect(site_url('clients/legal_services/' . $id . '/' . $ServID));
        }
    }

    function add_task_to_select_timesheet()
    {
        $data = $this->input->post();
        echo $this->tasks_model->new_task_to_select_timesheet($data);
    }

    public function get_case_by_clientid()
    {
        $clientid = $this->input->post('clientid') ? $this->input->post('clientid') : '';
        if ($clientid != '') {
            $response = $this->Dcase->get('', ['clientid' => $clientid]);
            echo json_encode($response);
        }
    }

    public function get_staff_names_for_mentions($projectId)
    {
        if ($this->input->is_ajax_request()) {
            $projectId = $this->db->escape_str($projectId);

            $members = $this->Dcase->get_project_members($projectId);
            $members = array_map(function ($member) {
                $staff = $this->staff_model->get($member['staff_id']);

                $_member['id'] = $member['staff_id'];
                $_member['name'] = $staff->firstname . ' ' . $staff->lastname;
                return $_member;
            }, $members);

            echo json_encode($members);
        }
    }

    //ivoices
    public function validate_invoice_number()
    {
        $isedit = $this->input->post('isedit');
        $number = $this->input->post('number');
        $date = $this->input->post('date');
        $original_number = $this->input->post('original_number');
        $number = trim($number);
        $number = ltrim($number, '0');
        if ($isedit == 'true') {
            if ($number == $original_number) {
                echo json_encode(true);
                die;
            }
        }
        if (total_rows(db_prefix() . 'my_disputes_cases_invoices', [
                'YEAR(date)' => date('Y', strtotime(to_sql_date($date))),
                'number' => $number,
            ]) > 0) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    //case_statuses
    public function add_case_statuses_from_modal()
    {
        $data = $this->input->post();
        echo $this->Dcase->add_new_case_status($data);
    }

    public function index_case_statuses()
    {
        $data['statuses'] = $this->Dcase->get_all_statuses();
        $data['title'] = _l('disputes_cases_statuses');
        $this->load->view('admin/legalservices/disputes_cases/projects_statuses', $data);
    }

    public function view_case_statuses($id = '')
    {
        if ($this->input->post()) {

            if (!$id) {

                $data = $this->input->post();
                $added = $this->Dcase->add_new_case_status($data);
                if ($added) {
                    set_alert('success', _l('added_successfully'), _l('disputes_cases'));
                    redirect(admin_url('legalservices/disputes_cases/index_case_statuses'));
                }

            } else {

                $data = $this->input->post();
                $success = $this->Dcase->update_case_status($id, $data);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('disputes_cases')));
                    redirect(admin_url('legalservices/disputes_cases/index_case_statuses'));
                } else {
                    set_alert('warning', _l('problem_updating', _l('disputes_cases')));
                }

            }
        }
        $data['status'] = $this->Dcase->get_status_by_id($id);
        $data['title'] = _l('disputes_cases_status');
        $this->load->view('admin/legalservices/disputes_cases/manage_statuses', $data);
    }

    public function delete_case_statuses($id)
    {
        if (!$id) {
            redirect(admin_url('legalservices/disputes_cases/index_case_statuses'));
        }
        $response = $this->Dcase->delete_case_status($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('disputes_cases')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('disputes_cases')));
        }
        redirect(admin_url('legalservices/disputes_cases/index_case_statuses'));
    }

}
