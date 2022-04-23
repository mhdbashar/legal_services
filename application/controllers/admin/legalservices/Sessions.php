<?php
use app\services\tasks\TasksKanban;

defined('BASEPATH') or exit('No direct script access allowed');

class Sessions extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sessions_model');
        $this->load->model('projects_model');
        $this->load->model('legalservices/LegalServicesModel', 'legal');
        $this->load->model('legalservices/Cases_model', 'case');
    }

    /* Open also all taks if user access this /tasks url */
    public function index($id = '')
    {
        $this->list_tasks($id);
    }

    /* List all tasks */
    public function list_tasks($id = '')
    {
        close_setup_menu();
        // If passed from url
        $data['custom_view'] = $this->input->get('custom_view') ? $this->input->get('custom_view') : '';
        $data['taskid']      = $id;

        if ($this->input->get('kanban')) {
            $this->switch_kanban(0, true);
        }

        $data['switch_kanban'] = false;
        $data['bodyclass']     = 'tasks-page';

        if ($this->session->userdata('tasks_kanban_view') == 'true') {
            $data['switch_kanban'] = true;
            $data['bodyclass']     = 'tasks-page kan-ban-body';
        }

        $data['title'] = _l('sessions');
        $this->load->view('admin/sessions/manage', $data);
    }

    public function list_tasks_for_LegalServices($id = '')
    {
        close_setup_menu();
        // If passed from url
        $data['custom_view'] = $this->input->get('custom_view') ? $this->input->get('custom_view') : '';
        $data['taskid']      = $id;
        $data['rel_type']    = $this->input->get('rel_type');

        if ($this->input->get('kanban')) {
            $this->switch_kanban(0, true);
        }

        $data['switch_kanban'] = false;
        $data['bodyclass']     = 'tasks-page';

        if ($this->session->userdata('tasks_kanban_view') == 'true') {
            $data['switch_kanban'] = true;
            $data['bodyclass']     = 'tasks-page kan-ban-body';
        }

        $data['title'] = _l('sessions');
        $this->load->view('admin/sessions/manage', $data);
    }

    public function kanban_for_LegalServices($rel_type)
    {
        echo $this->load->view('admin/sessions/kan_ban', ['rel_type' => $rel_type], true);
    }

    public function table($session_status='')
    {
        if($session_status == ''):
            $this->app->get_table_data('sessions');
        else:
            $this->app->get_table_data($session_status, [
                'all_data' => true,
            ]);
        endif;
    }

    public function kanban()
    {
        echo $this->load->view('admin/sessions/kan_ban', [], true);
    }

    public function ajax_search_assign_task_to_timer()
    {
        if ($this->input->is_ajax_request()) {
            $q = $this->input->post('q');
            $q = trim($q);
            $this->db->select('name, id,' . sessions_rel_name_select_query() . ' as subtext');
            $this->db->from(db_prefix() . 'tasks');
            $this->db->where('' . db_prefix() . 'tasks.id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid = ' . get_staff_user_id() . ')');
            //   $this->db->where('id NOT IN (SELECT task_id FROM '.db_prefix().'taskstimers WHERE staff_id = ' . get_staff_user_id() . ' AND end_time IS NULL)');
            $this->db->where('status != ', 5);
            $this->db->where('billed', 0);
            $this->db->group_start();
            $this->db->like('name', $q);
            $this->db->or_like(sessions_rel_name_select_query(), $q);
            $this->db->group_end();
            echo json_encode($this->db->get()->result_array());
        }
    }

    public function tasks_kanban_load_more()
    {
        $status = $this->input->get('status');
        $page   = $this->input->get('page');

        $tasks = (new TasksKanban($status))
            ->search($this->input->get('search'))
            ->sortBy(
                $this->input->get('sort_by'),
                $this->input->get('sort')
            )
            ->forProject($ci->input->get('project_id') ?: null)
            ->page($page)->get();

        foreach ($tasks as $task) {
            $this->load->view('admin/sessions/_kan_ban_card', [
                'task'   => $task,
                'status' => $status,
            ]);
        }
    }

    public function update_order()
    {
        $this->sessions_model->update_order($this->input->post());
    }

    public function switch_kanban($set = 0, $manual = false)
    {
        if ($set == 1) {
            $set = 'false';
        } else {
            $set = 'true';
        }

        $this->session->set_userdata([
            'tasks_kanban_view' => $set,
        ]);
        if ($manual == false) {
            // clicked on VIEW KANBAN from projects area and will redirect again to the same view
            if (strpos($_SERVER['HTTP_REFERER'], 'project_id') !== false) {
                redirect(admin_url('legalservices/Sessions'));
            } else {
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    // Used in invoice add/edit
    public function get_billable_tasks_by_project($project_id)
    {
        if ($this->input->is_ajax_request() && (has_permission('invoices', '', 'edit') || has_permission('invoices', '', 'create'))) {
            $customer_id = get_client_id_by_project_id($project_id);
            echo json_encode($this->sessions_model->get_billable_tasks($customer_id, $project_id));
        }
    }

    // Used in invoice add/edit
    public function get_billable_tasks_by_customer_id($customer_id)
    {
        if ($this->input->is_ajax_request() && (has_permission('invoices', '', 'edit') || has_permission('invoices', '', 'create'))) {
            echo json_encode($this->sessions_model->get_billable_tasks($customer_id));
        }
    }

    public function update_task_description($id)
    {
        if (has_permission('sessions', '', 'edit')) {
            $this->db->where('id', $id);
            $this->db->update(db_prefix() . 'tasks', [
                'description' => html_purify($this->input->post('description', false)),
            ]);
        }
    }

    /*public function old_detailed_overview()
    {
        $overview = [];

        $has_permission_create = has_permission('sessions', '', 'create');
        $has_permission_view   = has_permission('sessions', '', 'view');

        if (!$has_permission_view) {
            $staff_id = get_staff_user_id();
        } elseif ($this->input->post('member')) {
            $staff_id = $this->input->post('member');
        } else {
            $staff_id = '';
        }

        $hijriStatus= get_option('isHijri');

        $month = ($this->input->post('month') ? $this->input->post('month') : date('m'));
        if ($this->input->post() && $this->input->post('month') == '') {
            $month = '';
        }

        $day = ($this->input->post('day') ? $this->input->post('day') : date('d'));
        if ($this->input->post() && $this->input->post('day') == '') {
            $day = '';
        }

        $status = $this->input->post('status');

        $fetch_month_from = 'startdate';

        $year       = ($this->input->post('year') ? $this->input->post('year') : date('Y'));


        if ($hijriStatus == 'on') {
            $start_year_ad = force_to_AD_date_for_filter($year . '-01-01');
            $end_year_ad = force_to_AD_date_for_filter($year . '-12-29');

            $end_day = 29;
            if($month != ''){
                switch ($month){
                    case 3:
                    case 1:
                    case 5:
                    case 7:
                    case 10:
                    case 12:
                        $end_day = 29;
                        break;
                    case 4:
                    case 2:
                    case 6:
                    case 8:
                    case 9:
                    case 11:
                        $end_day = 30;
                        break;
                }
                $start_month_ad = date('m', strtotime(force_to_AD_date_for_filter($year . '-' . $month . '-' . '01')));
                $end_month_ad = date('m', strtotime(force_to_AD_date_for_filter($year . '-' . $month . '-' . $end_day)));
                $start_month_ad = "$start_month_ad";
                $end_month_ad = "$end_month_ad";

                $start_month_ad_day = (int)date('d', strtotime(force_to_AD_date_for_filter($year . '-' . $month . '-' . '01')));
                $end_month_ad_day = (int)date('d', strtotime(force_to_AD_date_for_filter($year . '-' . $month . '-' . $end_day)));
                $start_month_ad_day = "$start_month_ad_day";
                $end_month_ad_day = "$end_month_ad_day";

            }
            if($day != ''){
                $ad_day = (int)date('d', strtotime(force_to_AD_date_for_filter(($year . '-' . $month . '-' . $day))));
                $ad_day = "$ad_day";
                // echo $ad_day; exit;
            }
        }

        $project_id = $this->input->get('project_id');
        $rel_type = $this->input->get('rel_type');
        if(isset($rel_type)){
            $data['ServID'] = $this->legal->get_service_id_by_slug($rel_type);
        }
        for ($m = 1; $m <= 12; $m++) {
            if ($month != '' && $month != $m) {
                continue;
            }

            // Task rel_name
            $sqlTasksSelect = '*,' . sessions_rel_name_select_query() . ' as rel_name';

            // Task logged time
            $selectLoggedTime = get_sql_calc_session_logged_time('tmp-task-id');
            // Replace tmp-task-id to be the same like tasks.id
            $selectLoggedTime = str_replace('tmp-task-id', db_prefix() . 'tasks.id', $selectLoggedTime);

            if (is_numeric($staff_id)) {
                $selectLoggedTime .= ' AND staff_id=' . $this->db->escape_str($staff_id);
                $sqlTasksSelect .= ',(' . $selectLoggedTime . ')';
            } else {
                $sqlTasksSelect .= ',(' . $selectLoggedTime . ')';
            }

            $sqlTasksSelect .= ' as total_logged_time';

            // Task checklist items
            $sqlTasksSelect .= ',' . get_sql_select_session_total_checklist_items();

            if (is_numeric($staff_id)) {
                $sqlTasksSelect .= ',(SELECT COUNT(id) FROM ' . db_prefix() . 'task_checklist_items WHERE taskid=' . db_prefix() . 'tasks.id AND finished=1 AND finished_from=' . $staff_id . ') as total_finished_checklist_items';
            } else {
                $sqlTasksSelect .= ',' . get_sql_select_session_total_finished_checklist_items();
            }

            // Task total comment and total files
            $selectTotalComments = ',(SELECT COUNT(id) FROM ' . db_prefix() . 'task_comments WHERE taskid=' . db_prefix() . 'tasks.id';
            $selectTotalFiles    = ',(SELECT COUNT(id) FROM ' . db_prefix() . 'files WHERE rel_id=' . db_prefix() . 'tasks.id AND rel_type="task"';

            if (is_numeric($staff_id)) {
                $sqlTasksSelect .= $selectTotalComments . ' AND staffid=' . $staff_id . ') as total_comments_staff';
                $sqlTasksSelect .= $selectTotalFiles . ' AND staffid=' . $staff_id . ') as total_files_staff';
            }

            $sqlTasksSelect .= $selectTotalComments . ') as total_comments';
            $sqlTasksSelect .= $selectTotalFiles . ') as total_files';

            // Task assignees
            $sqlTasksSelect .= ',' . get_sql_select_session_asignees_full_names() . ' as assignees' . ',' . get_sql_select_session_assignees_ids() . ' as assignees_ids';

            $this->db->select($sqlTasksSelect);

            if($day != ''){
                if($hijriStatus == 'on') {
                    $this->db->where('DAY(' . $fetch_month_from . ')', $ad_day);
                }else {
                    $this->db->where('DAY(' . $fetch_month_from . ')', $day);
                }
            }
            if($hijriStatus == 'on' && $month != ''){
                // $this->db->where('MONTH(' . $fetch_month_from . ') BETWEEN ' . $start_month_ad . ' and ' . $end_month_ad);
                // $this->db->where('DAY(' . $fetch_month_from . ') BETWEEN ' . $start_month_ad_day . ' and ' . $end_month_ad_day);

                $this->db->where([
                    'MONTH(' . $fetch_month_from . ')' . '>=' => $start_month_ad,
                    'MONTH(' . $fetch_month_from . ')' . '<=' => $end_month_ad,
                ])->group_start();
                $this->db->where([
                    'DAY(' . $fetch_month_from . ')' . '>=' => $start_month_ad_day,
                ]);
                $this->db->or_where('MONTH(' . $fetch_month_from . ') >', $start_month_ad)->group_end();
                $this->db->where([
                    'DAY(' . $fetch_month_from . ')' . '<=' => $end_month_ad > $start_month_ad ? $end_month_ad_day + $end_day: $end_month_ad_day,
                ]);
                //echo 'DAY(' . $fetch_month_from . ') BETWEEN ' . $start_month_ad_day . ' and ' . $end_month_ad_day;
            }else
            $this->db->where('MONTH(' . $fetch_month_from . ')', $m);

            if ($hijriStatus == 'on') {
                $this->db->where([
                    $fetch_month_from . '>' => $start_year_ad,
                    $fetch_month_from . '<' => $end_year_ad
                ]);
            }else {
                $this->db->where('YEAR(' . $fetch_month_from . ')', $year);
            }

            if($rel_type && $rel_type != ''){
                $this->db->where('rel_id', $project_id);
                $this->db->where('rel_type', $rel_type);
            }else{
                if ($project_id && $project_id != '') {
                    $this->db->where('rel_id', $project_id);
                    $this->db->where('rel_type', 'project');
                }
            }


            if (!$has_permission_view) {
                $sqlWhereStaff = '(id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid=' . $staff_id . ')';

                // User dont have permission for view but have for create
                // Only show tasks createad by this user.
                if ($has_permission_create) {
                    $sqlWhereStaff .= ' OR addedfrom=' . get_staff_user_id();
                }

                $sqlWhereStaff .= ')';
                $this->db->where($sqlWhereStaff);
            } elseif ($has_permission_view) {
                if (is_numeric($staff_id)) {
                    $this->db->where('(id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid=' . $staff_id . '))');
                }
            }

            if ($status) {
                //$this->db->where('status', $status);
                if($status === 'previous'):
                    $this->db->where('DATE_FORMAT(now(),"%Y-%m-%d") > STR_TO_DATE('.db_prefix() .'tasks.startdate, "%Y-%m-%d")');
                else:
                    $this->db->where('DATE_FORMAT(now(),"%Y-%m-%d") <= STR_TO_DATE('.db_prefix() .'tasks.startdate, "%Y-%m-%d")');
                endif;
            }

            $this->db->where('is_session', 1);
            $this->db->join(db_prefix() . 'my_session_info', db_prefix() . 'my_session_info.task_id='.db_prefix() . 'tasks.id', 'left');
            $this->db->order_by($fetch_month_from, 'ASC');
            array_push($overview, $m);

            $overview[$m] = $this->db->get(db_prefix() . 'tasks')->result_array();

        }
        unset($overview[0]);

        $overview = [
            'staff_id' => $staff_id,
            'detailed' => $overview,
        ];
        $data['members']  = $this->staff_model->get();
        $data['overview'] = $overview['detailed'];
        $data['years']    = $this->sessions_model->get_distinct_tasks_years(($this->input->post('month_from') ? $this->input->post('month_from') : 'startdate'));
        $data['staff_id'] = $overview['staff_id'];
        $data['title']    = _l('session_detailed_overview');
        $this->load->view('admin/sessions/detailed_overview', $data);
    }*/

    public function detailed_overview()
    {
        $overview = [];

        $has_permission_create = has_permission('sessions', '', 'create');
        $has_permission_view   = has_permission('sessions', '', 'view');

        if (!$has_permission_view) {
            $staff_id = get_staff_user_id();
        } elseif ($this->input->post('member')) {
            $staff_id = $this->input->post('member');
        } else {
            $staff_id = '';
        }

        $month = ($this->input->post('month') ? $this->input->post('month') : date('m'));
        if ($this->input->post() && $this->input->post('month') == '') {
            $month = '';
        }

        $status = $this->input->post('status');

        $fetch_month_from = 'startdate';

        $year       = ($this->input->post('year') ? $this->input->post('year') : date('Y'));
        $project_id = $this->input->get('project_id');
        $rel_type = $this->input->get('rel_type');
        if(isset($rel_type)){
            $data['ServID'] = $this->legal->get_service_id_by_slug($rel_type);
        }
        for ($m = 1; $m <= 12; $m++) {
            if ($month != '' && $month != $m) {
                continue;
            }

            // Task rel_name
            $sqlTasksSelect = '*,' . sessions_rel_name_select_query() . ' as rel_name';

            // Task logged time
            $selectLoggedTime = get_sql_calc_session_logged_time('tmp-task-id');
            // Replace tmp-task-id to be the same like tasks.id
            $selectLoggedTime = str_replace('tmp-task-id', db_prefix() . 'tasks.id', $selectLoggedTime);

            if (is_numeric($staff_id)) {
                $selectLoggedTime .= ' AND staff_id=' . $this->db->escape_str($staff_id);
                $sqlTasksSelect .= ',(' . $selectLoggedTime . ')';
            } else {
                $sqlTasksSelect .= ',(' . $selectLoggedTime . ')';
            }

            $sqlTasksSelect .= ' as total_logged_time';

            // Task checklist items
            $sqlTasksSelect .= ',' . get_sql_select_session_total_checklist_items();

            if (is_numeric($staff_id)) {
                $sqlTasksSelect .= ',(SELECT COUNT(id) FROM ' . db_prefix() . 'task_checklist_items WHERE taskid=' . db_prefix() . 'tasks.id AND finished=1 AND finished_from=' . $staff_id . ') as total_finished_checklist_items';
            } else {
                $sqlTasksSelect .= ',' . get_sql_select_session_total_finished_checklist_items();
            }

            // Task total comment and total files
            $selectTotalComments = ',(SELECT COUNT(id) FROM ' . db_prefix() . 'task_comments WHERE taskid=' . db_prefix() . 'tasks.id';
            $selectTotalFiles    = ',(SELECT COUNT(id) FROM ' . db_prefix() . 'files WHERE rel_id=' . db_prefix() . 'tasks.id AND rel_type="task"';

            if (is_numeric($staff_id)) {
                $sqlTasksSelect .= $selectTotalComments . ' AND staffid=' . $staff_id . ') as total_comments_staff';
                $sqlTasksSelect .= $selectTotalFiles . ' AND staffid=' . $staff_id . ') as total_files_staff';
            }

            $sqlTasksSelect .= $selectTotalComments . ') as total_comments';
            $sqlTasksSelect .= $selectTotalFiles . ') as total_files';

            // Task assignees
            $sqlTasksSelect .= ',' . get_sql_select_session_asignees_full_names() . ' as assignees' . ',' . get_sql_select_session_assignees_ids() . ' as assignees_ids';

            $this->db->select($sqlTasksSelect);

            $this->db->where('MONTH(' . $fetch_month_from . ')', $m);
            $this->db->where('YEAR(' . $fetch_month_from . ')', $year);

            if($rel_type && $rel_type != ''){
                $this->db->where('rel_id', $project_id);
                $this->db->where('rel_type', $rel_type);
            }else{
                if ($project_id && $project_id != '') {
                    $this->db->where('rel_id', $project_id);
                    $this->db->where('rel_type', 'project');
                }
            }


            if (!$has_permission_view) {
                $sqlWhereStaff = '(id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid=' . $staff_id . ')';

                // User dont have permission for view but have for create
                // Only show tasks createad by this user.
                if ($has_permission_create) {
                    $sqlWhereStaff .= ' OR addedfrom=' . get_staff_user_id();
                }

                $sqlWhereStaff .= ')';
                $this->db->where($sqlWhereStaff);
            } elseif ($has_permission_view) {
                if (is_numeric($staff_id)) {
                    $this->db->where('(id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid=' . $staff_id . '))');
                }
            }

            if ($status) {
                //$this->db->where('status', $status);
                if($status === 'previous'):
                    $this->db->where('DATE_FORMAT(now(),"%Y-%m-%d") > STR_TO_DATE('.db_prefix() .'tasks.startdate, "%Y-%m-%d")');
                else:
                    $this->db->where('DATE_FORMAT(now(),"%Y-%m-%d") <= STR_TO_DATE('.db_prefix() .'tasks.startdate, "%Y-%m-%d")');
                endif;
            }

            $this->db->where('is_session', 1);
            $this->db->where('deleted', 0);
            $this->db->join(db_prefix() . 'my_session_info', db_prefix() . 'my_session_info.task_id='.db_prefix() . 'tasks.id', 'left');
            $this->db->order_by($fetch_month_from, 'ASC');
            array_push($overview, $m);
            $overview[$m] = $this->db->get(db_prefix() . 'tasks')->result_array();
        }

        unset($overview[0]);

        $overview = [
            'staff_id' => $staff_id,
            'detailed' => $overview,
        ];

        $data['members']  = $this->staff_model->get();
        $data['overview'] = $overview['detailed'];
        $data['years']    = $this->sessions_model->get_distinct_tasks_years(($this->input->post('month_from') ? $this->input->post('month_from') : 'startdate'));
        $data['staff_id'] = $overview['staff_id'];
        $data['title']    = _l('session_detailed_overview');
        $this->load->view('admin/sessions/detailed_overview', $data);
    }

    public function init_relation_tasks($rel_id, $rel_type)
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('sessions_relations', [
                'rel_id'   => $rel_id,
                'rel_type' => $rel_type,
            ]);
        }
    }

    public function init_previous_sessions_log($rel_id, $rel_type)
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('previous_sessions_log', [
                'rel_id'   => $rel_id,
                'rel_type' => $rel_type,
                'all_data' => false,
            ]);
        }
    }

    public function init_waiting_sessions_log($rel_id, $rel_type)
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('waiting_sessions_log', [
                'rel_id'   => $rel_id,
                'rel_type' => $rel_type,
                'all_data' => false,
            ]);
        }
    }

    /* Add new task or update existing */
    public function task($id = '')
    {
        if (!has_permission('sessions', '', 'edit') && !has_permission('sessions', '', 'create')) {
            ajax_access_denied();
        }

        $data = [];
        // FOr new task add directly from the projects milestones
        if ($this->input->get('milestone_id')) {
            $this->db->where('id', $this->input->get('milestone_id'));
            $milestone = $this->db->get(db_prefix() . 'milestones')->row();

            if ($milestone) {
                $data['_milestone_selected_data'] = [
                    'id'       => $milestone->id,
                    'due_date' => _d($milestone->due_date),
                ];
            }
        }
        if ($this->input->get('start_date')) {
            $data['start_date'] = $this->input->get('start_date');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            $data['description'] = html_purify($this->input->post('description', false));

            if ($id == '') {
                if (!has_permission('sessions', '', 'create')) {
                    header('HTTP/1.0 400 Bad error');
                    echo json_encode([
                        'success' => false,
                        'message' => _l('access_denied'),
                    ]);
                    die;
                }
                $id      = $this->sessions_model->add($data);


                $_id     = false;
                $success = false;
                $message = '';
                if ($id) {
                    $success       = true;
                    $_id           = $id;
                    $message       = _l('added_successfully', _l('session'));
                    $uploadedFiles = handle_task_attachments_array($id);
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'task', [$file]);
                        }
                    }
                }

                echo json_encode([
                    'success' => $success,
                    'id'      => $_id,
                    'message' => $message,
                ]);
            } else {
                if (!has_permission('sessions', '', 'edit')) {
                    header('HTTP/1.0 400 Bad error');
                    echo json_encode([
                        'success' => false,
                        'message' => _l('access_denied'),
                    ]);
                    die;
                }
                $success = $this->sessions_model->update($data, $id);
                $message = '';
                if ($success) {
                    $message = _l('updated_successfully', _l('session'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                    'id'      => $id,
                ]);


            }

            die;
        }

        $data['milestones']         = [];
        $data['checklistTemplates'] = $this->sessions_model->get_checklist_templates();
        if ($id == '') {
            $title = _l('add_new', _l('session_lowercase'));
        } else {
            $data['task'] = $this->sessions_model->get_with_session_info($id);
            if ($data['task']->rel_type == 'project') {
                $data['milestones'] = $this->projects_model->get_milestones($data['task']->rel_id);
            }
            $title = _l('edit', _l('session_lowercase')) . ' ' . $data['task']->name;
        }

        $data['project_end_date_attrs'] = [];
        if ($this->input->get('rel_type') == 'project' && $this->input->get('rel_id') || ($id !== '' && $data['task']->rel_type == 'project')) {
            $project = $this->projects_model->get($id === '' ? $this->input->get('rel_id') : $data['task']->rel_id);

            if ($project->deadline) {
                $data['project_end_date_attrs'] = [
                    'data-date-end-date' => $project->deadline,
                ];
            }
        }
        $data['members'] = $this->staff_model->get();
        $data['id']      = $id;
        $data['title']   = $title;
        //Remove service option from rel_type dropdown if not link with session
        $data['legal_services'] = $this->legal->get_all_services();
        foreach ($data['legal_services'] as $service => $object):
            if($object->id != 1):
                $count = check_service_if_link_with_seesion($object->id);
                if($count == 0):
                    unset($data['legal_services'][$service]);
                endif;
            endif;
        endforeach;
        $data['judges']         = $this->sessions_model->get_judges();
        $data['courts']         = $this->sessions_model->get_court();
        $this->load->view('admin/sessions/task', $data);
    }

    public function services_sessions($id = '')
    {
        if (!has_permission('sessions', '', 'edit') && !has_permission('sessions', '', 'create')) {
            ajax_access_denied();
        }

        $data = [];
        // FOr new task add directly from the projects milestones
        if ($this->input->get('milestone_id')) {
            $this->db->where('id', $this->input->get('milestone_id'));
            $milestone = $this->db->get(db_prefix() . 'milestones')->row();
            if ($milestone) {
                $data['_milestone_selected_data'] = [
                    'id'       => $milestone->id,
                    'due_date' => _d($milestone->due_date),
                ];
            }
        }
        if ($this->input->get('start_date')) {
            $data['start_date'] = $this->input->get('start_date');
        }
        if ($this->input->post()) {
            $data                = $this->input->post();
            if (strpos($data['rel_type'], 'session') !== false) {
                $data['rel_type'] = substr($data['rel_type'],8);

            }
            $data['description'] = $this->input->post('description', false);
            if ($id == '') {
                if (!has_permission('sessions', '', 'create')) {
                    header('HTTP/1.0 400 Bad error');
                    echo json_encode([
                        'success' => false,
                        'message' => _l('access_denied'),
                    ]);
                    die;
                }

                $id      = $this->sessions_model->add($data);
                $task = $this->sessions_model->get($id);



                $_id     = false;
                $success = false;
                $message = '';
                if ($id) {
                    $success       = true;
                    $_id           = $id;
                    $message       = _l('added_successfully', _l('session'));
                    $uploadedFiles = handle_task_attachments_array($id);
                    if ($uploadedFiles && is_array($uploadedFiles)) {
                        foreach ($uploadedFiles as $file) {
                            $this->misc_model->add_attachment_to_database($id, 'task', [$file]);
                        }
                    }

                }
                if(sizeof($task->assignees)==1 && $task->current_user_is_assigned==1){
                    $userName = $GLOBALS['current_user']->firstname .' ' .$GLOBALS['current_user']->lastname;
                    if($this->app_modules->is_active('telegram_chat')) {
                        //Telegram Chat
                        $str = '&#9878  تم اضافة جلسة من قبل ' .$userName. "\n"."اسم المكلف بالجلسة :"."\n";
                        foreach ($task->assignees as $assignee) {
                            $str .= $assignee['full_name'] . "\n";
                        }

                        $this->load->helper('telegram_helper');
                        $link1 = APP_BASE_URL . 'admin/legalservices/sessions/index/' . $task->id;
                        $link = "<a href= '$link1' >click here</a>";
                        $str1 = $str ."الموضوع: ".$task->name."\n"."تاريخ الجلسة: ".$task->startdate."\n"."وقت الجلسة:".$task->time. " \n رابط الجلسة: " . $link . "\nDone!";
                        send_message_telegram(urlencode($str1));
                        //Telegram Chat
                    }
                }
                echo json_encode([
                    'success' => $success,
                    'id'      => $_id,
                    'message' => $message,
                ]);

            } else {
                if (!has_permission('sessions', '', 'edit')) {
                    header('HTTP/1.0 400 Bad error');
                    echo json_encode([
                        'success' => false,
                        'message' => _l('access_denied'),
                    ]);
                    die;
                }
                $data['is_session'] = 1;
                $success = $this->sessions_model->update($data, $id);
                $message = '';
                if ($success) {
                    $message = _l('updated_successfully', _l('session'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                    'id'      => $id,
                ]);




                die;



            }






            die;
        }

        $data['milestones']         = [];
        $data['checklistTemplates'] = $this->sessions_model->get_checklist_templates();
        if ($id == '') {
            $title = _l('add_new_session');
        } else {
            $data['task'] = $this->sessions_model->get_with_session_info($id);
            if ($data['task']->rel_type == 'project') {
                $data['milestones'] = $this->projects_model->get_milestones($data['task']->rel_id);
            }
            $title = _l('edit', _l('session_lowercase')) . ' ' . $data['task']->name;
        }
        $data['project_end_date_attrs'] = [];
        if ($this->input->get('rel_type') == 'project' && $this->input->get('rel_id')) {
            $project = $this->projects_model->get($this->input->get('rel_id'));
            if ($project->deadline) {
                $data['project_end_date_attrs'] = [
                    'data-date-end-date' => $project->deadline,
                ];
            }
        }
        $data['id']             = $id;
        $data['legal_services'] = $this->legal->get_all_services();
        $data['judges']         = $this->sessions_model->get_judges();
        $data['courts']         = $this->sessions_model->get_court();
        $data['title']          = $title;
        $this->load->view('admin/legalservices/services_sessions/modal_session', $data);
    }

    public function copy()
    {
        if (has_permission('sessions', '', 'create')) {
            $new_task_id = $this->sessions_model->copy($this->input->post());
            $response    = [
                'new_task_id' => '',
                'alert_type'  => 'warning',
                'message'     => _l('failed_to_copy_task'),
                'success'     => false,
            ];
            if ($new_task_id) {
                $response['message']     = _l('task_copied_successfully');
                $response['new_task_id'] = $new_task_id;
                $response['success']     = true;
                $response['alert_type']  = 'success';
            }
            echo json_encode($response);
        }
    }

    public function copy_session()
    {
        if (has_permission('sessions', '', 'create')) {
            $data = $this->input->post();
            $data['is_session'] = 1;
            $new_task_id = $this->sessions_model->copy($data);
            $response    = [
                'new_task_id' => '',
                'alert_type'  => 'warning',
                'message'     => _l('failed_to_copy_task'),
                'success'     => false,
            ];
            if ($new_task_id) {
                $response['message']     = _l('task_copied_successfully');
                $response['new_task_id'] = $new_task_id;
                $response['success']     = true;
                $response['alert_type']  = 'success';
            }
            echo json_encode($response);
        }
    }

    public function get_billable_task_data($task_id)
    {
        $task              = $this->sessions_model->get_billable_task_data($task_id);
        $task->description = seconds_to_time_format($task->total_seconds) . ' ' . _l('hours');
        echo json_encode($task);
    }

    /**
     * Task ajax request modal
     * @param  mixed $taskid
     * @return mixed
     */
    public function get_task_data($taskid, $return = false)
    {
        $tasks_where = [];

        if (!has_permission('sessions', '', 'view')) {
            $tasks_where = get_sessions_where_string(false);
        }

        $task = $this->sessions_model->get($taskid, $tasks_where);


        if (!$task) {
            header('HTTP/1.0 404 Not Found');
            echo 'Session not found';
            die();
        }



        $data['checklistTemplates'] = $this->sessions_model->get_checklist_templates();
        $data['task']               = $task;
        $data['id']                 = $task->id;
        $data['staff']              = $this->staff_model->get('', ['active' => 1]);
        $data['reminders']          = $this->sessions_model->get_reminders($taskid);

        $data['task_staff_members'] = $this->tasks_model->get_staff_members_that_can_access_task($taskid);
        // For backward compatibilities
        $data['staff_reminders'] = $data['task_staff_members'];

        $data['hide_completed_items'] = get_staff_meta(get_staff_user_id(), 'task-hide-completed-items-' . $taskid);

        $data['project_deadline'] = null;
        if ($task->rel_type == 'project') {
            $data['project_deadline'] = get_project_deadline($task->rel_id);
        }

        if ($return == false) {
            $this->load->view('admin/sessions/view_task_template', $data);
        } else {
            return $this->load->view('admin/sessions/view_task_template', $data, true);
        }
    }

    public function get_task_data_with_session($taskid, $return = false)
    {
        $tasks_where = [];

        if (!has_permission('sessions', '', 'view')) {
            $tasks_where = get_sessions_where_string(false);
        }

        $task = $this->sessions_model->get_with_session_info($taskid, $tasks_where);

        if (!$task) {
            header('HTTP/1.0 404 Not Found');
            echo 'Session not found';
            die();
        }

        $data['checklistTemplates'] = $this->sessions_model->get_checklist_templates();
        $data['task']               = $task;
        $data['id']                 = $task->id;
        $data['staff']              = $this->staff_model->get('', ['active' => 1]);
        $data['reminders']          = $this->sessions_model->get_reminders($taskid);

        $data['staff_reminders'] = $this->sessions_model->get_staff_members_that_can_access_task($taskid);

        $data['project_deadline'] = null;
        if ($task->rel_type == 'project') {
            $data['project_deadline'] = get_project_deadline($task->rel_id);
        }

        if ($return == false) {
            $this->load->view('admin/legalservices/services_sessions/view_session_template', $data);
        } else {
            return $this->load->view('admin/legalservices/services_sessions/view_session_template', $data, true);
        }
    }

    public function add_reminder($task_id)
    {
        $message    = '';
        $alert_type = 'warning';
        if ($this->input->post()) {

            $success = $this->misc_model->add_reminder($this->input->post(), $task_id);
            if ($success) {
                $alert_type = 'success';
                $message    = _l('reminder_added_successfully');
            }

        }
        echo json_encode([
            'taskHtml'   => $this->get_task_data($task_id, true),
            'alert_type' => $alert_type,
            'message'    => $message,
        ]);
    }

    public function add_reminder_session($task_id)
    {
        $message    = '';
        $alert_type = 'warning';
        $data = $this->input->post();
        $data1=$data;
        $staff= get_staff_full_name($data['staff']);
        if ($data) {
            //Merge date with time
            if(isset($data['time'])){
                $data['date'] = $data['date'] . ' ' . $data['time'] . ':00';
            }

            $success = $this->misc_model->add_reminder($data, $task_id);
            if ($success) {
                $alert_type = 'success';
                $message    = _l('reminder_added_successfully');
            }

        }
        echo json_encode([
            'taskHtml'   => $this->get_task_data_with_session($task_id, true),
            'alert_type' => $alert_type,
            'message'    => $message,
        ]);
    }

    public function edit_reminder($id)
    {
        $reminder = $this->misc_model->get_reminders($id);
        if ($reminder && ($reminder->creator == get_staff_user_id() || is_admin()) && $reminder->isnotified == 0) {
            $success = $this->misc_model->edit_reminder($this->input->post(), $id);
            echo json_encode([
                    'taskHtml'   => $this->get_task_data($reminder->rel_id, true),
                    'alert_type' => 'success',
                    'message'    => ($success ? _l('updated_successfully', _l('reminder')) : ''),
                ]);
        }
    }

    public function edit_reminder_session($id)
    {
        $reminder = $this->misc_model->get_reminders($id);
        if ($reminder && ($reminder->creator == get_staff_user_id() || is_admin()) && $reminder->isnotified == 0) {
            $success = $this->misc_model->edit_reminder($this->input->post(), $id);
            echo json_encode([
                'taskHtml'   => $this->get_task_data_with_session($reminder->rel_id, true),
                'alert_type' => 'success',
                'message'    => ($success ? _l('updated_successfully', _l('reminder')) : ''),
            ]);
        }
    }

    public function delete_reminder($rel_id, $id)
    {
        $success    = $this->misc_model->delete_reminder($id);
        $alert_type = 'warning';
        $message    = _l('reminder_failed_to_delete');
        if ($success) {
            $alert_type = 'success';
            $message    = _l('reminder_deleted');
        }
        echo json_encode([
            'taskHtml'   => $this->get_task_data($rel_id, true),
            'alert_type' => $alert_type,
            'message'    => $message,
        ]);
    }

    public function delete_reminder_session($rel_id, $id)
    {
        $success    = $this->misc_model->delete_reminder($id);
        $alert_type = 'warning';
        $message    = _l('reminder_failed_to_delete');
        if ($success) {
            $alert_type = 'success';
            $message    = _l('reminder_deleted');
        }
        echo json_encode([
            'taskHtml'   => $this->get_task_data_with_session($rel_id, true),
            'alert_type' => $alert_type,
            'message'    => $message,
        ]);
    }

    public function get_staff_started_timers($return = false)
    {
        $data['startedTimers'] = $this->misc_model->get_staff_started_timers();
        $_data['html']         = $this->load->view('admin/sessions/started_timers', $data, true);
        $_data['total_timers'] = count($data['startedTimers']);

        $timers = json_encode($_data);
        if ($return) {
            return $timers;
        }

        echo $timers;
    }

    public function save_checklist_item_template()
    {
        if (has_permission('checklist_templates', '', 'create')) {
            $id = $this->sessions_model->add_checklist_template($this->input->post('description'));
            echo json_encode(['id' => $id]);
        }
    }

    public function remove_checklist_item_template($id)
    {
        if (has_permission('checklist_templates', '', 'delete')) {
            $success = $this->sessions_model->remove_checklist_item_template($id);
            echo json_encode(['success' => $success]);
        }
    }

    public function init_checklist_items()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                $post_data                       = $this->input->post();
                $data['task_id']                 = $post_data['taskid'];
                $data['checklists']              = $this->tasks_model->get_checklist_items($post_data['taskid']);
                $data['task_staff_members']      = $this->tasks_model->get_staff_members_that_can_access_task($data['task_id']);
                $data['current_user_is_creator'] = $this->tasks_model->is_task_creator(get_staff_user_id(), $data['task_id']);
                $data['hide_completed_items']    = get_staff_meta(get_staff_user_id(), 'task-hide-completed-items-' . $data['task_id']);

                $this->load->view('admin/sessions/checklist_items_template', $data);
            }
        }
    }

    public function task_tracking_stats($task_id)
    {
        $data['stats'] = json_encode($this->sessions_model->task_tracking_stats($task_id));
        $this->load->view('admin/sessions/tracking_stats', $data);
    }

    public function checkbox_action($listid, $value)
    {
        $this->db->where('id', $listid);
        $this->db->update(db_prefix() . 'task_checklist_items', [
            'finished' => $value,
        ]);

        if ($this->db->affected_rows() > 0) {
            if ($value == 1) {
                $this->db->where('id', $listid);
                $this->db->update(db_prefix() . 'task_checklist_items', [
                    'finished_from' => get_staff_user_id(),
                ]);
                hooks()->do_action('task_checklist_item_finished', $listid);
            }
        }
    }

    public function add_checklist_item()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                echo json_encode([
                    'success' => $this->sessions_model->add_checklist_item($this->input->post()),
                ]);
            }
        }
    }

    public function update_checklist_order()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                $this->sessions_model->update_checklist_order($this->input->post());
            }
        }
    }

    public function delete_checklist_item($id)
    {
        $list = $this->sessions_model->get_checklist_item($id);
        if (has_permission('sessions', '', 'delete') || $list->addedfrom == get_staff_user_id()) {
            if ($this->input->is_ajax_request()) {
                echo json_encode([
                    'success' => $this->sessions_model->delete_checklist_item($id),
                ]);
            }
        }
    }

    public function update_checklist_item()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post()) {
                $desc = $this->input->post('description');
                $desc = trim($desc);
                $this->sessions_model->update_checklist_item($this->input->post('listid'), $desc);
                echo json_encode(['can_be_template' => (total_rows(db_prefix() . 'sessions_checklist_templates', ['description' => $desc]) == 0)]);
            }
        }
    }

    public function make_public($task_id)
    {
        if (!has_permission('sessions', '', 'edit')) {
            json_encode([
                'success' => false,
            ]);
            die;
        }
        echo json_encode([
            'success'  => $this->sessions_model->make_public($task_id),
            'taskHtml' => $this->get_task_data($task_id, true),
        ]);
    }

    public function make_session_public($task_id)
    {
        if (!has_permission('sessions', '', 'edit')) {
            json_encode([
                'success' => false,
            ]);
            die;
        }
        echo json_encode([
            'success'  => $this->sessions_model->make_public($task_id),
            'taskHtml' => $this->get_task_data_with_session($task_id, true),
        ]);
    }


    public function add_external_attachment()
    {
        if ($this->input->post()) {
            $this->sessions_model->add_attachment_to_database(
                $this->input->post('task_id'),
                $this->input->post('files'),
                $this->input->post('external')
            );
        }
    }

    /* Add new task comment / ajax */
    public function add_task_comment()
    {
        $data            = $this->input->post();
        $data['content'] = html_purify($this->input->post('content', false));
        if ($this->input->post('no_editor')) {
            $data['content'] = nl2br($this->input->post('content'));
        }
        $comment_id = false;
        if ($data['content'] != ''
            || (isset($_FILES['file']['name']) && is_array($_FILES['file']['name']) && count($_FILES['file']['name']) > 0)) {
            $comment_id = $this->sessions_model->add_task_comment($data);
            if ($comment_id) {
                $commentAttachments = handle_task_attachments_array($data['taskid'], 'file');
                if ($commentAttachments && is_array($commentAttachments)) {
                    foreach ($commentAttachments as $file) {
                        $file['task_comment_id'] = $comment_id;
                        $this->misc_model->add_attachment_to_database($data['taskid'], 'task', [$file]);
                    }

                    if (count($commentAttachments) > 0) {
                        $this->db->query('UPDATE ' . db_prefix() . "task_comments SET content = CONCAT(content, '[task_attachment]')
                            WHERE id = " . $this->db->escape_str($comment_id));
                    }
                }
            }
        }
        echo json_encode([
            'success'  => $comment_id ? true : false,
            'taskHtml' => $this->get_task_data($data['taskid'], true),
        ]);
    }

    public function add_session_comment()
    {
        $data            = $this->input->post();
        $data['content'] = $this->input->post('content', false);
        if ($this->input->post('no_editor')) {
            $data['content'] = nl2br($this->input->post('content'));
        }
        $comment_id = false;
        if ($data['content'] != ''
            || (isset($_FILES['file']['name']) && is_array($_FILES['file']['name']) && count($_FILES['file']['name']) > 0)) {
            $comment_id = $this->sessions_model->add_task_comment($data);
            if ($comment_id) {
                $commentAttachments = handle_task_attachments_array($data['taskid'], 'file');
                if ($commentAttachments && is_array($commentAttachments)) {
                    foreach ($commentAttachments as $file) {
                        $file['task_comment_id'] = $comment_id;
                        $this->misc_model->add_attachment_to_database($data['taskid'], 'task', [$file]);
                    }

                    if (count($commentAttachments) > 0) {
                        $this->db->query('UPDATE ' . db_prefix() . "task_comments SET content = CONCAT(content, '[task_attachment]')
                            WHERE id = " . $comment_id);
                    }
                }
            }
        }
        echo json_encode([
            'success'  => $comment_id ? true : false,
            'taskHtml' => $this->get_task_data_with_session($data['taskid'], true),
        ]);
    }

    public function download_files($task_id, $comment_id = null)
    {
        $taskWhere = 'external IS NULL';

        if ($comment_id) {
            $taskWhere .= ' AND task_comment_id=' . $this->db->escape_str($comment_id);
        }

        if (!has_permission('sessions', '', 'view')) {
            $taskWhere .= ' AND ' . get_sessions_where_string(false);
        }

        $files = $this->sessions_model->get_task_attachments($task_id, $taskWhere);

        if (count($files) == 0) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $path = get_upload_path_by_type('task') . $task_id;

        $this->load->library('zip');

        foreach ($files as $file) {
            $this->zip->read_file($path . '/' . $file['file_name']);
        }

        $this->zip->download('files.zip');
        $this->zip->clear_data();
    }

    /* Add new task follower / ajax */
    public function add_task_followers()
    {
        $task = $this->sessions_model->get($this->input->post('taskid'));

        if (staff_can('edit', 'sessions') ||
            ($task->current_user_is_creator && staff_can('create', 'sessions'))) {
            echo json_encode([
                'success'  => $this->sessions_model->add_task_followers($this->input->post()),
                'taskHtml' => $this->get_task_data($this->input->post('taskid'), true),
            ]);
        }
    }

    public function add_session_followers()
    {
        if (has_permission('sessions', '', 'edit') || has_permission('sessions', '', 'create')) {
            echo json_encode([
                'success'  => $this->sessions_model->add_task_followers($this->input->post()),
                'taskHtml' => $this->get_task_data_with_session($this->input->post('taskid'), true),
            ]);
        }
    }

    /* Add task assignees / ajax */
    public function add_task_assignees()
    {
        $task = $this->sessions_model->get($this->input->post('taskid'));

        $userName = $GLOBALS['current_user']->firstname .' ' .$GLOBALS['current_user']->lastname;

        if (staff_can('edit', 'sessions') ||
            ($task->current_user_is_creator && staff_can('create', 'sessions'))) {
            echo json_encode([
                'success'  => $this->sessions_model->add_task_assignees($this->input->post()),
                'taskHtml' => $this->get_task_data($this->input->post('taskid'), true),
            ]);
            $task = $this->sessions_model->get($this->input->post('taskid'));
            if($this->app_modules->is_active('telegram_chat')) {
                //Telegram Chat
                $str = '&#9878  تم اضافة جلسة من قبل ' .$userName. "\n"."اسم المكلف بالجلسة :"."\n";
                foreach ($task->assignees as $assignee) {
                    $str .= $assignee['full_name'] . "\n";
                }

                $this->load->helper('telegram_helper');
                $link1 = APP_BASE_URL . 'admin/legalservices/sessions/index/' . $task->id;
                $link = "<a href= '$link1' >click here</a>";
                $str1 = $str ."الموضوع: ".$task->name."\n"."تاريخ الجلسة: ".$task->startdate."\n"."وقت الجلسة:".$task->time. " \n رابط الجلسة: " . $link . "\nDone!";
                send_message_telegram(urlencode($str1));
                //Telegram Chat
            }


        }
    }

    public function edit_comment()
    {
        if ($this->input->post()) {
            $data            = $this->input->post();
            $data['content'] = html_purify($this->input->post('content', false));
            if ($this->input->post('no_editor')) {
                $data['content'] = nl2br(clear_textarea_breaks($this->input->post('content')));
            }
            $success = $this->sessions_model->edit_comment($data);
            $message = '';
            if ($success) {
                $message = _l('task_comment_updated');
            }
            echo json_encode([
                'success'  => $success,
                'message'  => $message,
                'taskHtml' => $this->get_task_data($data['task_id'], true),
            ]);
        }
    }

    public function edit_session_comment()
    {
        if ($this->input->post()) {
            $data            = $this->input->post();
            $data['content'] = $this->input->post('content', false);
            if ($this->input->post('no_editor')) {
                $data['content'] = nl2br(clear_textarea_breaks($this->input->post('content')));
            }
            $success = $this->sessions_model->edit_comment($data);
            $message = '';
            if ($success) {
                $message = _l('task_comment_updated');
            }
            echo json_encode([
                'success'  => $success,
                'message'  => $message,
                'taskHtml' => $this->get_task_data_with_session($data['task_id'], true),
            ]);
        }
    }

    /* Remove task comment / ajax */
    public function remove_comment($id)
    {
        echo json_encode([
            'success' => $this->sessions_model->remove_comment($id),
        ]);
    }

    /* Remove assignee / ajax */
    public function remove_assignee($id, $taskid)
    {
        $task = $this->sessions_model->get($taskid);

        if (staff_can('edit', 'sessions') ||
            ($task->current_user_is_creator && staff_can('create', 'sessions'))) {
            $success = $this->sessions_model->remove_assignee($id, $taskid);
            $message = '';
            if ($success) {
                $message = _l('project_activity_session_assignee_removed');
            }
            echo json_encode([
                'success'  => $success,
                'message'  => $message,
                'taskHtml' => $this->get_task_data($taskid, true),
            ]);
        }
    }

    public function remove_assignee_session($id, $taskid)
    {
        if (has_permission('sessions', '', 'edit') && has_permission('sessions', '', 'create')) {
            $success = $this->sessions_model->remove_assignee($id, $taskid);
            $message = '';
            if ($success) {
                $message = _l('session_assignee_removed');
            }
            echo json_encode([
                'success'  => $success,
                'message'  => $message,
                'taskHtml' => $this->get_task_data_with_session($taskid, true),
            ]);
        }
    }

    /* Remove task follower / ajax */
    public function remove_follower($id, $taskid)
    {
        $task = $this->sessions_model->get($taskid);

        if (staff_can('edit', 'sessions') ||
            ($task->current_user_is_creator && staff_can('create', 'sessions'))) {
            $success = $this->sessions_model->remove_follower($id, $taskid);
            $message = '';
            if ($success) {
                $message = _l('session_follower_removed');
            }
            echo json_encode([
                'success'  => $success,
                'message'  => $message,
                'taskHtml' => $this->get_task_data($taskid, true),
            ]);
        }
    }

    public function remove_follower_session($id, $taskid)
    {
        if (has_permission('sessions', '', 'edit') && has_permission('sessions', '', 'create')) {
            $success = $this->sessions_model->remove_follower($id, $taskid);
            $message = '';
            if ($success) {
                $message = _l('session_follower_removed');
            }
            echo json_encode([
                'success'  => $success,
                'message'  => $message,
                'taskHtml' => $this->get_task_data_with_session($taskid, true),
            ]);
        }
    }

    /* Unmark task as complete / ajax*/
    public function unmark_complete($id)
    {
        if ($this->sessions_model->is_task_assignee(get_staff_user_id(), $id)
            || $this->sessions_model->is_task_creator(get_staff_user_id(), $id)
            || has_permission('sessions', '', 'edit')) {
            $success = $this->sessions_model->unmark_complete($id);

            // Don't do this query if the action is not performed via task single
            $taskHtml = $this->input->get('single_task') === 'true' ? $this->get_task_data($id, true) : '';

            $message = '';
            if ($success) {
                $message = _l('session_unmarked_as_complete');
            }
            echo json_encode([
                'success'  => $success,
                'message'  => $message,
                'taskHtml' => $taskHtml,
            ]);
        } else {
            echo json_encode([
                'success'  => false,
                'message'  => '',
                'taskHtml' => '',
            ]);
        }
    }

    public function unmark_session_complete($id)
    {
        if ($this->sessions_model->is_task_assignee(get_staff_user_id(), $id)
            || $this->sessions_model->is_task_creator(get_staff_user_id(), $id)
            || has_permission('sessions', '', 'edit')) {
            $success = $this->sessions_model->unmark_complete($id);

            // Don't do this query if the action is not performed via task single
            $taskHtml = $this->input->get('single_task') === 'true' ? $this->get_task_data_with_session($id, true) : '';

            $message = '';
            if ($success) {
                $message = _l('session_unmarked_as_complete');
            }
            echo json_encode([
                'success'  => $success,
                'message'  => $message,
                'taskHtml' => $taskHtml,
            ]);
        } else {
            echo json_encode([
                'success'  => false,
                'message'  => '',
                'taskHtml' => '',
            ]);
        }
    }

    public function mark_as($status, $id)
    {
        if ($this->sessions_model->is_task_assignee(get_staff_user_id(), $id)
            || $this->sessions_model->is_task_creator(get_staff_user_id(), $id)
            || has_permission('sessions', '', 'edit')) {
            $success = $this->sessions_model->mark_as($status, $id);

            // Don't do this query if the action is not performed via task single
            $taskHtml = $this->input->get('single_task') === 'true' ? $this->get_task_data($id, true) : '';

            $message = '';

            if ($success) {
                $message = _l('session_marked_as_success', format_session_status($status, true, true));
            }

            echo json_encode([
                'success'  => $success,
                'message'  => $message,
                'taskHtml' => $taskHtml,
            ]);
        } else {
            echo json_encode([
                'success'  => false,
                'message'  => '',
                'taskHtml' => '',
            ]);
        }
    }

    public function mark_as_session($status, $id)
    {
        if ($this->sessions_model->is_task_assignee(get_staff_user_id(), $id)
            || $this->sessions_model->is_task_creator(get_staff_user_id(), $id)
            || has_permission('sessions', '', 'edit')) {
            $success = $this->sessions_model->mark_as($status, $id);

            // Don't do this query if the action is not performed via task single
            $taskHtml = $this->input->get('single_task') === 'true' ? $this->get_task_data_with_session($id, true) : '';

            $message = '';

            if ($success) {
                $message = _l('session_marked_as_success', format_session_status($status, true, true));
            }

            echo json_encode([
                'success'  => $success,
                'message'  => $message,
                'taskHtml' => $taskHtml,
            ]);
        } else {
            echo json_encode([
                'success'  => false,
                'message'  => '',
                'taskHtml' => '',
            ]);
        }
    }

    public function change_priority($priority_id, $id)
    {
        if (has_permission('sessions', '', 'edit')) {
            $this->db->where('id', $id);
            $this->db->update(db_prefix() . 'tasks', ['priority' => $priority_id]);

            $success = $this->db->affected_rows() > 0 ? true : false;

            // Don't do this query if the action is not performed via task single
            $taskHtml = $this->input->get('single_task') === 'true' ? $this->get_task_data($id, true) : '';
            echo json_encode([
                'success'  => $success,
                'taskHtml' => $taskHtml,
            ]);
        } else {
            echo json_encode([
                'success'  => false,
                'taskHtml' => $taskHtml,
            ]);
        }
    }

    public function change_session_priority($priority_id, $id)
    {
        if (has_permission('sessions', '', 'edit')) {
            $this->db->where('id', $id);
            $this->db->update(db_prefix() . 'tasks', ['priority' => $priority_id]);

            $success = $this->db->affected_rows() > 0 ? true : false;

            // Don't do this query if the action is not performed via task single
            $taskHtml = $this->input->get('single_task') === 'true' ? $this->get_task_data_with_session($id, true) : '';
            echo json_encode([
                'success'  => $success,
                'taskHtml' => $taskHtml,
            ]);
        } else {
            echo json_encode([
                'success'  => false,
                'taskHtml' => $taskHtml,
            ]);
        }
    }

    public function change_milestone($milestone_id, $id)
    {
        if (has_permission('sessions', '', 'edit')) {
            $this->db->where('id', $id);
            $this->db->update(db_prefix() . 'tasks', ['milestone' => $milestone_id]);

            $success = $this->db->affected_rows() > 0 ? true : false;
            // Don't do this query if the action is not performed via task single
            $taskHtml = $this->input->get('single_task') === 'true' ? $this->get_task_data($id, true) : '';
            echo json_encode([
                'success'  => $success,
                'taskHtml' => $taskHtml,
            ]);
        } else {
            echo json_encode([
                'success'  => false,
                'taskHtml' => $taskHtml,
            ]);
        }
    }

    public function task_single_inline_update($task_id)
    {
        if (has_permission('sessions', '', 'edit')) {
            $post_data = $this->input->post();
            foreach ($post_data as $key => $val) {
                $this->db->where('id', $task_id);
                $this->db->update(db_prefix() . 'tasks', [$key => to_sql_date($val)]);
            }
        }
    }

    /* Delete task from database */
    public function delete_task($id)
    {
        if (!has_permission('sessions', '', 'delete')) {
            access_denied('sessions');
        }
        $success = $this->sessions_model->delete_task($id);
        $message = _l('problem_deleting', _l('session_lowercase'));
        if ($success) {
            $message = _l('deleted', _l('session'));
            set_alert('success', $message);
        } else {
            set_alert('warning', $message);
        }

        if (strpos($_SERVER['HTTP_REFERER'], 'tasks/index') !== false || strpos($_SERVER['HTTP_REFERER'], 'tasks/view') !== false) {
            redirect(admin_url('tasks'));
        } elseif (preg_match("/projects\/view\/[1-9]+/", $_SERVER['HTTP_REFERER'])) {
            $project_url = explode('?', $_SERVER['HTTP_REFERER']);
            redirect($project_url[0] . '?group=project_tasks');
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * Remove task attachment
     * @since  Version 1.0.1
     * @param  mixed $id attachment it
     * @return json
     */
    public function remove_task_attachment($id)
    {
        if ($this->input->is_ajax_request()) {
            echo json_encode($this->sessions_model->remove_task_attachment($id));
        }
    }

    /**
     * Upload task attachment
     * @since  Version 1.0.1
     */
    public function upload_file()
    {
        if ($this->input->post()) {
            $taskid  = $this->input->post('taskid');
            $files   = handle_task_attachments_array($taskid, 'file');
            $success = false;

            if ($files) {
                $i   = 0;
                $len = count($files);
                foreach ($files as $file) {
                    $success = $this->sessions_model->add_attachment_to_database($taskid, [$file], false, ($i == $len - 1 ? true : false));
                    $i++;
                }
            }

            echo json_encode([
                'success'  => $success,
                'taskHtml' => $this->get_task_data($taskid, true),
            ]);
        }
    }

    public function upload_file_session()
    {
        if ($this->input->post()) {
            $taskid  = $this->input->post('taskid');
            $files   = handle_task_attachments_array($taskid, 'file');
            $success = false;

            if ($files) {
                $i   = 0;
                $len = count($files);
                foreach ($files as $file) {
                    $success = $this->sessions_model->add_attachment_to_database($taskid, [$file], false, ($i == $len - 1 ? true : false));
                    $i++;
                }
            }

            echo json_encode([
                'success'  => $success,
                'taskHtml' => $this->get_task_data_with_session($taskid, true),
            ]);
        }
    }

    public function timer_tracking()
    {
        $task_id   = $this->input->post('task_id');
        $adminStop = $this->input->get('admin_stop') && is_admin() ? true : false;

        if ($adminStop) {
            $this->session->set_flashdata('task_single_timesheets_open', true);
        }

        echo json_encode([
            'success' => $this->sessions_model->timer_tracking(
                $task_id,
                $this->input->post('timer_id'),
                nl2br($this->input->post('note')),
                $adminStop
            ),
            'taskHtml' => $this->input->get('single_task') === 'true' ? $this->get_task_data($task_id, true) : '',
            'timers'   => $this->get_staff_started_timers(true),
        ]);
    }

    public function timer_tracking_session()
    {
        $task_id   = $this->input->post('task_id');
        $adminStop = $this->input->get('admin_stop') && is_admin() ? true : false;

        if ($adminStop) {
            $this->session->set_flashdata('task_single_timesheets_open', true);
        }

        echo json_encode([
            'success' => $this->sessions_model->timer_tracking(
                $task_id,
                $this->input->post('timer_id'),
                nl2br($this->input->post('note')),
                $adminStop
            ),
            'taskHtml' => $this->input->get('single_task') === 'true' ? $this->get_task_data_with_session($task_id, true) : '',
            'timers'   => $this->get_staff_started_timers(true),
        ]);
    }

    public function delete_user_unfinished_timesheet($id)
    {
        $this->db->where('id', $id);
        $timesheet = $this->db->get(db_prefix() . 'taskstimers')->row();
        if ($timesheet && $timesheet->end_time == null && $timesheet->staff_id == get_staff_user_id()) {
            $this->db->where('id', $id);
            $this->db->delete(db_prefix() . 'taskstimers');
        }
        echo json_encode(['timers' => $this->get_staff_started_timers(true)]);
    }

    public function delete_timesheet($id)
    {
        if (staff_can('delete_timesheet', 'sessions') || staff_can('delete_own_timesheet', 'sessions') && total_rows(db_prefix() . 'taskstimers', ['staff_id' => get_staff_user_id(), 'id' => $id]) > 0) {
            $alert_type = 'warning';
            $success    = $this->sessions_model->delete_timesheet($id);
            if ($success) {
                $this->session->set_flashdata('task_single_timesheets_open', true);
                $message = _l('deleted', _l('project_timesheet'));
                set_alert('success', $message);
            }
            if (!$this->input->is_ajax_request()) {
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function update_timesheet()
    {
        if ($this->input->is_ajax_request()) {
            if (staff_can('edit_timesheet', 'tasks') || (staff_can('edit_own_timesheet', 'tasks') && total_rows(db_prefix() . 'taskstimers', ['staff_id' => get_staff_user_id(), 'id' => $this->input->post('timer_id')]) > 0)) {
                $success = $this->tasks_model->timesheet($this->input->post());
                if ($success === true) {
                    $this->session->set_flashdata('task_single_timesheets_open', true);
                    $message = _l('updated_successfully', _l('project_timesheet'));
                } else {
                    $message = _l('failed_to_update_timesheet');
                }

                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                ]);
                die;
            }

            echo json_encode([
                'success' => false,
                'message' => _l('access_denied'),
            ]);
            die;
        }
    }

    public function log_time()
    {
        $data = $this->input->post();
        //Merge date with time
        if(isset($data['ts_start_time'])){
            $data['start_time'] = $data['start_time'].' '.$data['ts_start_time'];
            unset($data['ts_start_time']);
        }
        if(isset($data['ts_end_time'])){
            $data['end_time'] = $data['end_time'].' '.$data['ts_end_time'];
            unset($data['ts_end_time']);
        }
        $success = $this->sessions_model->timesheet($data);
        if ($success === true) {
            $this->session->set_flashdata('task_single_timesheets_open', true);
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

    public function update_tags()
    {
        if (has_permission('sessions', '', 'create') || has_permission('sessions', '', 'edit')) {
            handle_tags_save($this->input->post('tags'), $this->input->post('task_id'), 'task');
        }
    }

    public function bulk_action()
    {
        hooks()->do_action('before_do_bulk_action_for_tasks');
        $total_deleted = 0;
        if ($this->input->post()) {
            $status    = $this->input->post('status');
            $ids       = $this->input->post('ids');
            $tags      = $this->input->post('tags');
            $assignees = $this->input->post('assignees');
            $milestone = $this->input->post('milestone');
            $priority  = $this->input->post('priority');
            $billable  = $this->input->post('billable');
            $is_admin  = is_admin();
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    if ($this->input->post('mass_delete')) {
                        if (has_permission('sessions', '', 'delete')) {
                            if ($this->sessions_model->delete_task($id)) {
                                $total_deleted++;
                            }
                        }
                    } else {
                        if ($status) {
                            if ($this->sessions_model->is_task_creator(get_staff_user_id(), $id)
                                || $is_admin
                                || $this->sessions_model->is_task_assignee(get_staff_user_id(), $id)) {
                                $this->sessions_model->mark_as($status, $id);
                            }
                        }
                        if ($priority || $milestone || ($billable === 'billable' || $billable === 'not_billable')) {
                            $update = [];
                            if ($priority) {
                                $update['priority'] = $priority;
                            }
                            if ($milestone) {
                                $update['milestone'] = $milestone;
                            }
                            if ($billable) {
                                $update['billable'] = $billable === 'billable' ? 1 : 0;
                            }
                            $this->db->where('id', $id);
                            $this->db->update(db_prefix() . 'tasks', $update);
                        }
                        if ($tags) {
                            handle_tags_save($tags, $id, 'task');
                        }
                        if ($assignees) {
                            $notifiedUsers = [];
                            foreach ($assignees as $user_id) {
                                if (!$this->sessions_model->is_task_assignee($user_id, $id)) {
                                    $this->db->select('rel_type,rel_id');
                                    $this->db->where('id', $id);
                                    $task = $this->db->get(db_prefix() . 'tasks')->row();
                                    if ($task->rel_type == 'project') {
                                        // User is we are trying to assign the task is not project member
                                        if (total_rows(db_prefix() . 'project_members', ['project_id' => $task->rel_id, 'staff_id' => $user_id]) == 0) {
                                            $this->db->insert(db_prefix() . 'project_members', ['project_id' => $task->rel_id, 'staff_id' => $user_id]);
                                        }
                                    }
                                    $this->db->insert(db_prefix() . 'task_assigned', [
                                        'staffid'       => $user_id,
                                        'taskid'        => $id,
                                        'assigned_from' => get_staff_user_id(),
                                        ]);
                                    if ($user_id != get_staff_user_id()) {
                                        $notification_data = [
                                        'description' => 'not_session_assigned_to_you',
                                        'touserid'    => $user_id,
                                        'link'        => '#sessionid=' . $id,
                                        ];

                                        $notification_data['additional_data'] = serialize([
                                            get_session_subject_by_id($id),
                                        ]);
                                        if (add_notification($notification_data)) {
                                            array_push($notifiedUsers, $user_id);
                                        }
                                    }
                                }
                            }
                            pusher_trigger_notification($notifiedUsers);
                        }
                    }
                }
            }
            if ($this->input->post('mass_delete')) {
                set_alert('success', _l('total_tasks_deleted', $total_deleted));
            }
        }
    }

    //New functions added for sessions
    public function edit_customer_report($id)
    {
        if(!$id){
            set_alert('danger', _l('WrongEntry'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        if ($this->input->post()) {
            $data = $this->input->post();
            echo $this->sessions_model->update_customer_report($id, $data);
        }
    }

    public function update_session_court_decision($id)
    {
        if (has_permission('sessions', '', 'edit')) {
            $this->db->where('task_id', $id);
            $this->db->update(db_prefix() . 'my_session_info', [
                'court_decision' => $this->input->post('court_decision', false),
            ]);
        }
    }

    public function update_session_information($id)
    {
        if (has_permission('sessions', '', 'edit')) {
            $this->db->where('task_id', $id);
            $this->db->update(db_prefix() . 'my_session_info', [
                'session_information' => $this->input->post('session_information', false),
            ]);
        }
    }

    public function send_report_to_customer($task_id)
    {
        echo $this->sessions_model->update_send_to_customer($task_id);
    }

    public function print_report($task_id)
    {
        $response = array();
        $response = $this->sessions_model->get_session_data($task_id);
        $client_id = get_client_id_by_case_id($response->tbl1);
        $opponent_id = get_opponent_id_by_case_id($response->tbl1);
        $client_name = get_company_name($client_id);
        $opponent_name = get_company_name($opponent_id);
        $response->tbl2 = $client_name;
        $response->tbl3 = $opponent_name;
        echo json_encode($response);
    }

    public function checklist_items_description($task_id)
    {
        $response = $this->sessions_model->get_checklist_items_description($task_id);
        echo json_encode($response);
    }

    public function save_checklist_assigned_staff()
    {
        if ($this->input->post() && $this->input->is_ajax_request()) {
            $payload = $this->input->post();
            $item    = $this->sessions_model->get_checklist_item($payload['checklistId']);
            if ($item->addedfrom == get_staff_user_id()
                || is_admin() ||
                $this->tasks_model->is_task_creator(get_staff_user_id(), $payload['taskId'])) {
                $this->tasks_model->update_checklist_assigned_staff($payload);
                die;
            }

            ajax_access_denied();
        }
    }
}
