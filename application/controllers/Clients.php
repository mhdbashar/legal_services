<?php

defined('BASEPATH') or exit('No direct script access allowed');

use app\services\ValidatesContact;

class Clients extends ClientsController
{
    /**
     * @since  2.3.3
     */
    use ValidatesContact;

    private $project_settings = [
            'available_features',
            'view_tasks',
            'create_tasks',
            'edit_tasks',
            'comment_on_tasks',
            'view_task_comments',
            'view_task_attachments',
            'view_task_checklist_items',
            'upload_on_tasks',
            'view_task_total_logged_time',
            'view_finance_overview',
            'upload_files',
            'open_discussions',
            'view_milestones',
            'view_gantt',
            'view_timesheets',
            'view_activity_log',
            'view_team_members',
            'hide_tasks_on_main_tasks_table',
    ];

    public function __construct()
    {
        parent::__construct();

        $this->load->model('legalservices/Cases_model', 'case');
        $this->load->model('legalservices/Other_services_model', 'other');
        $this->load->model('legalservices/LegalServicesModel', 'legal');
        $this->load->model('procurations_model', 'procurations');
        $this->load->model('legalservices/Imported_services_model', 'imported');
        hooks()->do_action('after_clients_area_init', $this);
    }

    private function set_upload_options($id)
    {
        //upload an image options'

        $accept = "jpg|png|pdf|doc|zip|rar|image|jpeg|png|pdf|msword|docs";
        $config = array();
        $config['upload_path'] = FCPATH . 'uploads/imported_services/'.$id;
        $config['allowed_types'] = $accept;
        $config['max_size']      = '0';
        $config['overwrite']     = FALSE;
        $config['remove_spaces'] = FALSE;

        return $config;
    }

    public function remove_file($project_id, $id)
    {
        $this->imported->remove_file($project_id, $id);
        redirect(site_url('clients/imported_service/'.$project_id. '?group=project_files'));
    }

    public function imported_edit($id) {
        if($this->input->post()){
            $data = $this->input->post();
            if($this->imported->update($id, $data))
                redirect(site_url('clients/imported_service/'.$id));
        }
        $data['imported'] = $this->imported->get($id);
        $data['title']  = _l('projects');
        $this->data($data);
        $this->view('imported_edit');
        $this->layout();
    }

    public function imported_add() {

        if($this->input->post()){
            $data = $this->input->post();
            $success = $this->imported->add(get_client_user_id(), $data);

            $available_features = $this->db->get("tbloservice_settings")->row_array()['value'];

            $this->db->insert(db_prefix() . 'iservice_settings', [
                'oservice_id' => $success,
                'name' => 'available_features',
                'value' => $available_features,
            ]);
            $original_settings = $this->project_settings;

            foreach ($original_settings as $setting) {
                if ($setting != 'available_features'){
                    $value_setting = 0;
                    $this->db->insert(db_prefix() . 'iservice_settings', [
                        'oservice_id' => $success,
                        'name' => $setting,
                        'value' => $value_setting,
                    ]);
                }
            }

            if($success){
                if(!file_exists('uploads/imported_services/'.$success)){
                    mkdir(FCPATH.'uploads/imported_services/'.$success, 0755);
                }
                $countfiles = count($_FILES['attachments']['name']);
                $files = $_FILES;

                for($i=0;$i<$countfiles;$i++){

                    $_FILES = $files;

                    if(!empty($_FILES['attachments']['name'][$i])){
                        // Define new $_FILES array - $_FILES['file']
                        $_FILES['attachments'.$i]['name'] = $files['attachments']['name'][$i];
                        $_FILES['attachments'.$i]['type'] = $files['attachments']['type'][$i];
                        $_FILES['attachments'.$i]['tmp_name'] = $files['attachments']['tmp_name'][$i];
                        $_FILES['attachments'.$i]['error'] = $files['attachments']['error'][$i];
                        $_FILES['attachments'.$i]['size'] = $files['attachments']['size'][$i];


                        // Set preference
                        $accept = "jpg|png|pdf|doc|zip|rar|image|jpeg|png|pdf|msword|docs";
                        $config['upload_path'] = FCPATH . 'uploads/imported_services/'.$success;
                        $config['allowed_types'] = $accept;
                        $config['max_size'] = '5000'; // max_size in kb
                        $config['remove_spaces'] = FALSE;
                        $config['file_name'] = $_FILES['attachments']['name'][$i];

                        //Load upload library
                        $this->load->library('upload',$config);

                        // File upload
                        $this->upload->initialize($this->set_upload_options($success));
                        if($this->upload->do_upload('attachments'.$i)){
                            $data = array('upload_data' => $this->upload->data());
                            // Get data about the file
                            $uploadData = $this->upload->data();
                            $filename = $uploadData['file_name'];

                            $file_data = [
                                'file_name' => $config['file_name'],
                                'subject' => $config['file_name'],
                                'description' => '',
                                'filetype' => $uploadData['file_type'],
                                'dateadded' => date('Y-m-d H:i:s'),
                                'last_activity' => '',
                                'iservice_id' => $success,
                                'visible_to_customer' => 0,   //$value['visible_to_customer'],
                                'staffid' => 0,    //$value['staffid'],
                                'contact_id' => 0,   //$value['contact_id'],
                                'external' => '',
                                'external_link' => '',
                            ];


                            $this->db->insert('tbliservice_files', $file_data);

                            // Initialize array
                            $data['filenames'][] = $filename;
                        }else {
                            $error = array('error' => $this->upload->display_errors());
                        }
                    }

                }
                // alert('success', _l('added_successfully'));
                redirect(site_url('clients/imported_service/'.$success));
            }else{
                // alert('warning', _l('problem'));
                redirect(site_url('clients/clients/imported/'));
            }
        }
        $data['title']  = _l('projects');
        $this->data($data);
        $this->view('imported_add');
        $this->layout();
    }

    public function imported($status = '')
    {
        if (!has_contact_permission('projects')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }
        $data['project_statuses'] = $this->other->get_project_statuses();
        $where = 'clientid=' . get_client_user_id();

        if (is_numeric($status)) {
            $where .= ' AND status=' . $status;
        } else {
            $listStatusesIds = [];
            $where .= ' AND status IN (';
            foreach ($data['project_statuses'] as $projectStatus) {
                if (isset($projectStatus['filter_default']) && $projectStatus['filter_default'] == true) {
                    $listStatusesIds[] = $projectStatus['id'];
                    $where .= $projectStatus['id'] . ',';
                }
            }
            $where = rtrim($where, ',');
            $where .= ')';
        }

        $data['list_statuses'] = is_numeric($status) ? [$status] : $listStatusesIds;
        $slug = 'imported_services';
        $data['projects'] = $this->other->get_imported('', ['clientid' => get_client_user_id()]);
        $data['ServID'] = 0;
        $data['slug'] = $slug;
        $data['title']  = _l('clients_my_legal');
        $this->data($data);
        $this->view('imported_services');
        $this->layout();
    }

    public function imported_service($id)
    {
        if (!has_contact_permission('projects')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        $project = $this->other->get_imported($id, [
            'clientid' => get_client_user_id(),
        ]);

        if (!$project) {
            show_404();
        }

        $data['project']                               = $project;
        $data['project']->settings->available_features = '';

        $data['title'] = $data['project']->name;
        $slug = 'imported_services';
        if ($this->input->post('action')) {
            $action = $this->input->post('action');

            switch ($action) {
                case 'new_task':
                case 'edit_task':

                    $data    = $this->input->post();
                    $task_id = false;
                    if (isset($data['task_id'])) {
                        $task_id = $data['task_id'];
                        unset($data['task_id']);
                    }

                    $data['rel_type']    = 'project';
                    $data['rel_id']      = $project->id;
                    $data['description'] = nl2br($data['description']);

                    $assignees = isset($data['assignees']) ? $data['assignees'] : [];
                    if (isset($data['assignees'])) {
                        unset($data['assignees']);
                    }
                    unset($data['action']);

                    if (!$task_id) {
                        $task_id = $this->tasks_model->add($data, true);
                        if ($task_id) {
                            foreach ($assignees as $assignee) {
                                $this->tasks_model->add_task_assignees(['taskid' => $task_id, 'assignee' => $assignee], false, true);
                            }
                            $uploadedFiles = handle_task_attachments_array($task_id);
                            if ($uploadedFiles && is_array($uploadedFiles)) {
                                foreach ($uploadedFiles as $file) {
                                    $file['contact_id'] = get_contact_user_id();
                                    $this->misc_model->add_attachment_to_database($task_id, 'task', [$file]);
                                }
                            }
                            set_alert('success', _l('added_successfully', _l('task')));
                            redirect(site_url('clients/project/' . $project->id . '?group=project_tasks&taskid=' . $task_id));
                        }
                    } else {
                        if ($project->settings->edit_tasks == 1
                            && total_rows(db_prefix() . 'tasks', ['is_added_from_contact' => 1, 'addedfrom' => get_contact_user_id()]) > 0) {
                            $affectedRows = 0;
                            $updated      = $this->tasks_model->update($data, $task_id, true);
                            if ($updated) {
                                $affectedRows++;
                            }

                            $currentAssignees    = $this->tasks_model->get_task_assignees($task_id);
                            $currentAssigneesIds = [];
                            foreach ($currentAssignees as $assigned) {
                                array_push($currentAssigneesIds, $assigned['assigneeid']);
                            }

                            $totalAssignees = count($assignees);

                            /**
                             * In case when contact created the task and then was able to view team members
                             * Now in this case he still can view team members and can edit them
                             */
                            if ($totalAssignees == 0 && $project->settings->view_team_members == 1) {
                                $this->db->where('taskid', $task_id);
                                $this->db->delete(db_prefix() . 'task_assigned');
                            } elseif ($totalAssignees > 0 && $project->settings->view_team_members == 1) {
                                foreach ($currentAssignees as $assigned) {
                                    if (!in_array($assigned['assigneeid'], $assignees)) {
                                        if ($this->tasks_model->remove_assignee($assigned['id'], $task_id)) {
                                            $affectedRows++;
                                        }
                                    }
                                }
                                foreach ($assignees as $assignee) {
                                    if (!$this->tasks_model->is_task_assignee($assignee, $task_id)) {
                                        if ($this->tasks_model->add_task_assignees(['taskid' => $task_id, 'assignee' => $assignee], false, true)) {
                                            $affectedRows++;
                                        }
                                    }
                                }
                            }
                            if ($affectedRows > 0) {
                                set_alert('success', _l('updated_successfully', _l('task')));
                            }
                            redirect(site_url('clients/project/' . $project->id . '?group=project_tasks&taskid=' . $task_id));
                        }
                    }

                    redirect(site_url('clients/project/' . $project->id . '?group=project_tasks'));

                    break;
                case 'discussion_comments':
                    echo json_encode($this->projects_model->get_discussion_comments($this->input->post('discussion_id'), $this->input->post('discussion_type')));
                    die;
                case 'new_discussion_comment':
                    echo json_encode($this->projects_model->add_discussion_comment($this->input->post(), $this->input->post('discussion_id'), $this->input->post('discussion_type')));
                    die;

                    break;
                case 'update_discussion_comment':
                    echo json_encode($this->projects_model->update_discussion_comment($this->input->post(), $this->input->post('discussion_id')));
                    die;

                    break;
                case 'delete_discussion_comment':
                    echo json_encode($this->projects_model->delete_discussion_comment($this->input->post('id')));
                    die;

                    break;
                case 'new_discussion':
                    $discussion_data = $this->input->post();
                    unset($discussion_data['action']);
                    $success = $this->projects_model->add_discussion($discussion_data);
                    if ($success) {
                        set_alert('success', _l('added_successfully', _l('project_discussion')));
                    }
                    redirect(site_url('clients/project/' . $id . '?group=project_discussions'));

                    break;
                case 'upload_file':
                    handle_iservice_file_uploads($id);
                    die;

                    break;
                case 'project_file_dropbox': // deprecated
                case 'project_external_file':
                    $data                        = [];
                    $data['project_id']          = $id;
                    $data['files']               = $this->input->post('files');
                    $data['external']            = $this->input->post('external');
                    $data['visible_to_customer'] = 1;
                    $data['contact_id']          = get_contact_user_id();
                    $this->projects_model->add_external_file($data);
                    die;

                    break;
                case 'get_file':
                    $file_data['discussion_user_profile_image_url'] = contact_profile_image_url(get_contact_user_id());
                    $file_data['current_user_is_admin']             = false;
                    $file_data['file']                              = $this->other->get_imported_file($this->input->post('id'), $this->input->post('project_id'));

                    if (!$file_data['file']) {
                        header('HTTP/1.0 404 Not Found');
                        die;
                    }
                    echo get_template_part('imported_services/file', $file_data, true);
                    die;

                    break;
                case 'update_file_data':
                    $file_data = $this->input->post();
                    unset($file_data['action']);
                    $this->projects_model->update_file_data($file_data);

                    break;
                case 'upload_task_file':
                    $taskid = $this->input->post('task_id');
                    $files  = handle_task_attachments_array($taskid, 'file');
                    if ($files) {
                        $i   = 0;
                        $len = count($files);
                        foreach ($files as $file) {
                            $file['contact_id'] = get_contact_user_id();
                            $file['staffid']    = 0;
                            $this->tasks_model->add_attachment_to_database($taskid, [$file], false, ($i == $len - 1 ? true : false));
                            $i++;
                        }
                    }
                    die;

                    break;
                case 'add_task_external_file':
                    $taskid                = $this->input->post('task_id');
                    $file                  = $this->input->post('files');
                    $file[0]['contact_id'] = get_contact_user_id();
                    $file[0]['staffid']    = 0;
                    $this->tasks_model->add_attachment_to_database($this->input->post('task_id'), $file, $this->input->post('external'));
                    die;

                    break;
                case 'new_task_comment':
                    $comment_data            = $this->input->post();
                    $comment_data['content'] = nl2br($comment_data['content']);
                    $comment_id              = $this->tasks_model->add_task_comment($comment_data);
                    $url                     = site_url('clients/project/' . $id . '?group=project_tasks&taskid=' . $comment_data['taskid']);

                    if ($comment_id) {
                        set_alert('success', _l('task_comment_added'));
                        $url .= '#comment_' . $comment_id;
                    }

                    redirect($url);

                    break;
                default:
                    redirect(site_url('clients/project/' . $id));

                    break;
            }
        }
        if (!$this->input->get('group')) {
            $group = 'project_overview';
        } else {
            $group = $this->input->get('group');
        }
        $data['project_status'] = get_project_status_by_id($data['project']->status);
        if ($group != 'edit_task') {
            if ($group == 'project_overview') {
                $percent = $this->other->calc_imported_progress($slug, $id);
                @$data['percent'] = $percent / 100;
                $this->load->helper('date');
                $data['project_total_days']        = round((human_to_unix($data['project']->deadline . ' 00:00') - human_to_unix($data['project']->start_date . ' 00:00')) / 3600 / 24);
                $data['project_days_left']         = $data['project_total_days'];
                $data['project_time_left_percent'] = 100;
                if ($data['project']->deadline) {
                    if (human_to_unix($data['project']->start_date . ' 00:00') < time() && human_to_unix($data['project']->deadline . ' 00:00') > time()) {
                        $data['project_days_left'] = round((human_to_unix($data['project']->deadline . ' 00:00') - time()) / 3600 / 24);

                        $data['project_time_left_percent'] = $data['project_days_left'] / $data['project_total_days'] * 100;
                        $data['project_time_left_percent'] = round($data['project_time_left_percent'], 2);
                    }
                    if (human_to_unix($data['project']->deadline . ' 00:00') < time()) {
                        $data['project_days_left']         = 0;
                        $data['project_time_left_percent'] = 0;
                    }
                }
                $total_tasks = total_rows(db_prefix() . 'tasks', [
                    'rel_id'            => $id,
                    'rel_type'          => 'project',
                    'visible_to_client' => 1,
                ]);
                $total_tasks = hooks()->apply_filters('client_project_total_tasks', $total_tasks, $id);

                $data['tasks_not_completed'] = total_rows(db_prefix() . 'tasks', [
                    'status !='         => 5,
                    'rel_id'            => $id,
                    'rel_type'          => 'project',
                    'visible_to_client' => 1,
                ]);

                $data['tasks_not_completed'] = hooks()->apply_filters('client_project_tasks_not_completed', $data['tasks_not_completed'], $id);

                $data['tasks_completed'] = total_rows(db_prefix() . 'tasks', [
                    'status'            => 5,
                    'rel_id'            => $id,
                    'rel_type'          => 'project',
                    'visible_to_client' => 1,
                ]);
                $data['tasks_completed'] = hooks()->apply_filters('client_project_tasks_completed', $data['tasks_completed'], $id);

                $data['total_tasks']                  = $total_tasks;
                $data['tasks_not_completed_progress'] = ($total_tasks > 0 ? number_format(($data['tasks_completed'] * 100) / $total_tasks, 2) : 0);
                $data['tasks_not_completed_progress'] = round($data['tasks_not_completed_progress'], 2);
            } elseif ($group == 'new_task') {
                if ($project->settings->create_tasks == 0) {
                    redirect(site_url('clients/project/' . $project->id));
                }
                $data['milestones'] = $this->projects_model->get_milestones($id);
            } elseif ($group == 'project_gantt') {
                $data['gantt_data'] = $this->projects_model->get_gantt_data($id);
            } elseif ($group == 'project_discussions') {
                if ($this->input->get('discussion_id')) {
                    $data['discussion_user_profile_image_url'] = contact_profile_image_url(get_contact_user_id());
                    $data['discussion']                        = $this->projects_model->get_discussion($this->input->get('discussion_id'), $id);
                    $data['current_user_is_admin']             = false;
                }
                $data['discussions'] = $this->projects_model->get_discussions($id);
            } elseif ($group == 'project_files') {
                $data['files'] = $this->other->get_imported_files($id);
            } elseif ($group == 'project_tasks') {
                $data['tasks_statuses'] = $this->tasks_model->get_statuses();
                $data['project_tasks']  = $this->projects_model->get_tasks($id);
            } elseif ($group == 'project_activity') {
                $data['activity'] = $this->projects_model->get_activity($id);
            } elseif ($group == 'project_milestones') {
                $data['milestones'] = $this->projects_model->get_milestones($id);
            } elseif ($group == 'project_invoices') {
                $data['invoices'] = [];
                if (has_contact_permission('invoices')) {
                    $whereInvoices = [
                        'clientid'   => get_client_user_id(),
                        'rel_sid' => $id,
                        'rel_stype' => 'imported'
                    ];
                    if (get_option('exclude_invoice_from_client_area_with_draft_status') == 1) {
                        $whereInvoices['status !='] = 6;
                    }
                    $data['invoices'] = $this->invoices_model->get('', $whereInvoices);
                }
            } elseif ($group == 'project_tickets') {
                $data['tickets'] = [];
                if (has_contact_permission('support')) {
                    $where_tickets = [
                        db_prefix() . 'tickets.userid' => get_client_user_id(),
                        'project_id'                   => $id,
                    ];

                    if (!!can_logged_in_contact_view_all_tickets()) {
                        $where_tickets[db_prefix() . 'tickets.contactid'] = get_contact_user_id();
                    }

                    $data['tickets']                 = $this->tickets_model->get('', $where_tickets);
                    $data['show_submitter_on_table'] = show_ticket_submitter_on_clients_area_table();
                }
            } elseif ($group == 'project_estimates') {
                $data['estimates'] = [];
                if (has_contact_permission('estimates')) {
                    $data['estimates'] = $this->estimates_model->get('', [
                        'clientid'   => get_client_user_id(),
                        'project_id' => $id,
                    ]);
                }
            } elseif ($group == 'project_timesheets') {
                $data['timesheets'] = $this->projects_model->get_timesheets($id);
            }

            if ($this->input->get('taskid')) {
                $data['view_task'] = $this->tasks_model->get($this->input->get('taskid'), [
                    'rel_id'   => $project->id,
                    'rel_type' => 'project',
                ]);

                $data['title'] = $data['view_task']->name;
            }
        } elseif ($group == 'edit_task') {
            $data['milestones'] = $this->projects_model->get_milestones($id);
            $data['task']       = $this->tasks_model->get($this->input->get('taskid'), [
                'rel_id'                => $project->id,
                'rel_type'              => 'project',
                'addedfrom'             => get_contact_user_id(),
                'is_added_from_contact' => 1,
            ]);
        }

        $data['group']    = $group;
        $data['currency'] = $this->projects_model->get_currency($id);
        $data['members']  = $this->projects_model->get_project_members($id);
        $data['ServID'] = 0;
        $data['slug'] = 'imported_services';

        $this->data($data);
        $this->view('imported_service');
        $this->layout();
    }

    public function index()
    {
        $data['is_home'] = true;
        $this->load->model('reports_model');
        $data['payments_years'] = $this->reports_model->get_distinct_customer_invoices_years();

        $data['project_statuses'] = $this->projects_model->get_project_statuses();
        $data['title']            = get_company_name(get_client_user_id());
        $data['legal_services']   = $this->legal->get_all_services();
        $this->data($data);
        $this->view('home');
        $this->layout();
    }

    public function announcements()
    {
        $data['title']         = _l('announcements');
        $data['announcements'] = $this->announcements_model->get();
        $this->data($data);
        $this->view('announcements');
        $this->layout();
    }

    public function announcement($id)
    {
        $data['announcement'] = $this->announcements_model->get($id);
        $data['title']        = $data['announcement']->name;
        $this->data($data);
        $this->view('announcement');
        $this->layout();
    }

    public function calendar()
    {
        $data['title'] = _l('calendar');
        $this->view('calendar');
        $this->data($data);
        $this->layout();
    }

    public function get_calendar_data()
    {
        $this->load->model('utilities_model');
        $data = $this->utilities_model->get_calendar_data(
            date('Y-m-d', strtotime($this->input->get('start'))),
            date('Y-m-d', strtotime($this->input->get('end'))),
            get_user_id_by_contact_id(get_contact_user_id()),
            get_contact_user_id()
        );

        echo json_encode($data);
    }

    public function projects($status = '')
    {
        if (!has_contact_permission('projects')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }
        $data['project_statuses'] = $this->projects_model->get_project_statuses();

        $where = 'clientid=' . get_client_user_id();

        if (is_numeric($status)) {
            $where .= ' AND status=' . $this->db->escape_str($status);
        } else {
            $listStatusesIds = [];
            $where .= ' AND status IN (';
            foreach ($data['project_statuses'] as $projectStatus) {
                if (isset($projectStatus['filter_default']) && $projectStatus['filter_default'] == true) {
                    $listStatusesIds[] = $projectStatus['id'];
                    $where .= $this->db->escape_str($projectStatus['id']) . ',';
                }
            }
            $where = rtrim($where, ',');
            $where .= ')';
        }

        $data['list_statuses'] = is_numeric($status) ? [$status] : $listStatusesIds;
        $data['projects']      = $this->projects_model->get('', $where);
        $data['title']         = _l('clients_my_projects');
        $this->data($data);
        $this->view('projects');
        $this->layout();
    }

    public function legals($ServID, $status = '')
    {
        if (!has_contact_permission('projects')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }
        if($ServID == 1) {
            $data['project_statuses'] = $this->case->get_project_statuses();
        }else{
            $data['project_statuses'] = $this->other->get_project_statuses();
        }
        $where = 'clientid=' . get_client_user_id();

        if (is_numeric($status)) {
            $where .= ' AND status=' . $status;
        } else {
            $listStatusesIds = [];
            $where .= ' AND status IN (';
            foreach ($data['project_statuses'] as $projectStatus) {
                if (isset($projectStatus['filter_default']) && $projectStatus['filter_default'] == true) {
                    $listStatusesIds[] = $projectStatus['id'];
                    $where .= $projectStatus['id'] . ',';
                }
            }
            $where = rtrim($where, ',');
            $where .= ')';
        }

        $data['list_statuses'] = is_numeric($status) ? [$status] : $listStatusesIds;
        if($ServID == 1){
            $data['slug']     = $this->legal->get_service_by_id($ServID)->row()->slug;
            $data['projects'] = $this->case->get('', $where);
        }else{
            $data['slug']     = $this->legal->get_service_by_id($ServID)->row()->slug;
            $data['projects'] = $this->other->get($ServID, '', $where);
        }
        $data['ServID'] = $ServID;
        $data['title']  = _l('clients_my_legal');
        $this->data($data);
        $this->view('legals');
        $this->layout();
    }
    
    public function project($id)
    {
        if (!has_contact_permission('projects')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        $project = $this->projects_model->get($id, [
            'clientid' => get_client_user_id(),
        ]);

        if (!$project) {
            show_404();
        }

        $data['project']                               = $project;
        $data['project']->settings->available_features = unserialize($data['project']->settings->available_features);

        $data['title'] = $data['project']->name;
        if ($this->input->post('action')) {
            $action = $this->input->post('action');

            switch ($action) {
                  case 'new_task':
                  case 'edit_task':

                    $data    = $this->input->post();
                    $task_id = false;
                    if (isset($data['task_id'])) {
                        $task_id = $data['task_id'];
                        unset($data['task_id']);
                    }

                    $data['rel_type']    = 'project';
                    $data['rel_id']      = $project->id;
                    $data['description'] = nl2br($data['description']);

                    $assignees = isset($data['assignees']) ? $data['assignees'] : [];
                    if (isset($data['assignees'])) {
                        unset($data['assignees']);
                    }
                    unset($data['action']);

                    if (!$task_id) {
                        $task_id = $this->tasks_model->add($data, true);
                        if ($task_id) {
                            foreach ($assignees as $assignee) {
                                $this->tasks_model->add_task_assignees(['taskid' => $task_id, 'assignee' => $assignee], false, true);
                            }
                            $uploadedFiles = handle_task_attachments_array($task_id);
                            if ($uploadedFiles && is_array($uploadedFiles)) {
                                foreach ($uploadedFiles as $file) {
                                    $file['contact_id'] = get_contact_user_id();
                                    $this->misc_model->add_attachment_to_database($task_id, 'task', [$file]);
                                }
                            }
                            set_alert('success', _l('added_successfully', _l('task')));
                            redirect(site_url('clients/project/' . $project->id . '?group=project_tasks&taskid=' . $task_id));
                        }
                    } else {
                        if ($project->settings->edit_tasks == 1
                        && total_rows(db_prefix() . 'tasks', ['is_session' => 0, 'is_added_from_contact' => 1, 'addedfrom' => get_contact_user_id(), 'billed' => 0]) > 0) {
                            $affectedRows = 0;
                            $updated      = $this->tasks_model->update($data, $task_id, true);
                            if ($updated) {
                                $affectedRows++;
                            }

                            $currentAssignees    = $this->tasks_model->get_task_assignees($task_id);
                            $currentAssigneesIds = [];
                            foreach ($currentAssignees as $assigned) {
                                array_push($currentAssigneesIds, $assigned['assigneeid']);
                            }

                            $totalAssignees = count($assignees);

                            /**
                             * In case when contact created the task and then was able to view team members
                             * Now in this case he still can view team members and can edit them
                             */
                            if ($totalAssignees == 0 && $project->settings->view_team_members == 1) {
                                $this->db->where('taskid', $task_id);
                                $this->db->delete(db_prefix() . 'task_assigned');
                            } elseif ($totalAssignees > 0 && $project->settings->view_team_members == 1) {
                                foreach ($currentAssignees as $assigned) {
                                    if (!in_array($assigned['assigneeid'], $assignees)) {
                                        if ($this->tasks_model->remove_assignee($assigned['id'], $task_id)) {
                                            $affectedRows++;
                                        }
                                    }
                                }
                                foreach ($assignees as $assignee) {
                                    if (!$this->tasks_model->is_task_assignee($assignee, $task_id)) {
                                        if ($this->tasks_model->add_task_assignees(['taskid' => $task_id, 'assignee' => $assignee], false, true)) {
                                            $affectedRows++;
                                        }
                                    }
                                }
                            }
                            if ($affectedRows > 0) {
                                set_alert('success', _l('updated_successfully', _l('task')));
                            }
                            redirect(site_url('clients/project/' . $project->id . '?group=project_tasks&taskid=' . $task_id));
                        }
                    }

                    redirect(site_url('clients/project/' . $project->id . '?group=project_tasks'));

                    break;
                case 'discussion_comments':
                    echo json_encode($this->projects_model->get_discussion_comments($this->input->post('discussion_id'), $this->input->post('discussion_type')));
                    die;
                case 'new_discussion_comment':
                    echo json_encode($this->projects_model->add_discussion_comment($this->input->post(), $this->input->post('discussion_id'), $this->input->post('discussion_type')));
                    die;

                    break;
                case 'update_discussion_comment':
                    echo json_encode($this->projects_model->update_discussion_comment($this->input->post(), $this->input->post('discussion_id')));
                    die;

                    break;
                case 'delete_discussion_comment':
                    echo json_encode($this->projects_model->delete_discussion_comment($this->input->post('id')));
                    die;

                    break;
                case 'new_discussion':
                    $discussion_data = $this->input->post();
                    unset($discussion_data['action']);
                    $success = $this->projects_model->add_discussion($discussion_data);
                    if ($success) {
                        set_alert('success', _l('added_successfully', _l('project_discussion')));
                    }
                    redirect(site_url('clients/project/' . $id . '?group=project_discussions'));

                    break;
                case 'upload_file':
                    handle_project_file_uploads($id);
                    die;

                    break;
                case 'project_file_dropbox': // deprecated
                case 'project_external_file':
                        $data                        = [];
                        $data['project_id']          = $id;
                        $data['files']               = $this->input->post('files');
                        $data['external']            = $this->input->post('external');
                        $data['visible_to_customer'] = 1;
                        $data['contact_id']          = get_contact_user_id();
                        $this->projects_model->add_external_file($data);
                die;

                break;
                case 'get_file':
                    $file_data['discussion_user_profile_image_url'] = contact_profile_image_url(get_contact_user_id());
                    $file_data['current_user_is_admin']             = false;
                    $file_data['file']                              = $this->projects_model->get_file($this->input->post('id'), $this->input->post('project_id'));

                    if (!$file_data['file']) {
                        header('HTTP/1.0 404 Not Found');
                        die;
                    }
                    echo get_template_part('projects/file', $file_data, true);
                    die;

                    break;
                case 'update_file_data':
                    $file_data = $this->input->post();
                    unset($file_data['action']);
                    $this->projects_model->update_file_data($file_data);

                    break;
                case 'upload_task_file':
                    $taskid = $this->input->post('task_id');
                    $files  = handle_task_attachments_array($taskid, 'file');
                    if ($files) {
                        $i   = 0;
                        $len = count($files);
                        foreach ($files as $file) {
                            $file['contact_id'] = get_contact_user_id();
                            $file['staffid']    = 0;
                            $this->tasks_model->add_attachment_to_database($taskid, [$file], false, ($i == $len - 1 ? true : false));
                            $i++;
                        }
                    }
                    die;

                    break;
                case 'add_task_external_file':
                    $taskid                = $this->input->post('task_id');
                    $file                  = $this->input->post('files');
                    $file[0]['contact_id'] = get_contact_user_id();
                    $file[0]['staffid']    = 0;
                    $this->tasks_model->add_attachment_to_database($this->input->post('task_id'), $file, $this->input->post('external'));
                    die;

                    break;
                case 'new_task_comment':
                    $comment_data            = $this->input->post();
                    $comment_data['content'] = nl2br($comment_data['content']);
                    $comment_id              = $this->tasks_model->add_task_comment($comment_data);
                    $url                     = site_url('clients/project/' . $id . '?group=project_tasks&taskid=' . $comment_data['taskid']);

                    if ($comment_id) {
                        set_alert('success', _l('task_comment_added'));
                        $url .= '#comment_' . $comment_id;
                    }

                    redirect($url);

                    break;
                default:
                    redirect(site_url('clients/project/' . $id));

                    break;
            }
        }
        if (!$this->input->get('group')) {
            $group = 'project_overview';
        } else {
            $group = $this->input->get('group');
        }
        $data['project_status'] = get_project_status_by_id($data['project']->status);
        if ($group != 'edit_task') {
            if ($group == 'project_overview') {
                $percent          = $this->projects_model->calc_progress($id);
                @$data['percent'] = $percent / 100;
                $this->load->helper('date');
                $data['project_total_days']        = round((human_to_unix($data['project']->deadline . ' 00:00') - human_to_unix($data['project']->start_date . ' 00:00')) / 3600 / 24);
                $data['project_days_left']         = $data['project_total_days'];
                $data['project_time_left_percent'] = 100;
                if ($data['project']->deadline) {
                    if (human_to_unix($data['project']->start_date . ' 00:00') < time() && human_to_unix($data['project']->deadline . ' 00:00') > time()) {
                        $data['project_days_left'] = round((human_to_unix($data['project']->deadline . ' 00:00') - time()) / 3600 / 24);

                        $data['project_time_left_percent'] = $data['project_days_left'] / $data['project_total_days'] * 100;
                        $data['project_time_left_percent'] = round($data['project_time_left_percent'], 2);
                    }
                    if (human_to_unix($data['project']->deadline . ' 00:00') < time()) {
                        $data['project_days_left']         = 0;
                        $data['project_time_left_percent'] = 0;
                    }
                }
                $total_tasks = total_rows(db_prefix() . 'tasks', [
                    'is_session'        => 0,
                    'rel_id'            => $id,
                    'rel_type'          => 'project',
                    'visible_to_client' => 1,
                ]);
                $total_tasks = hooks()->apply_filters('client_project_total_tasks', $total_tasks, $id);

                $data['tasks_not_completed'] = total_rows(db_prefix() . 'tasks', [
                'is_session'        => 0,
                'status !='         => 5,
                'rel_id'            => $id,
                'rel_type'          => 'project',
                'visible_to_client' => 1,
            ]);

                $data['tasks_not_completed'] = hooks()->apply_filters('client_project_tasks_not_completed', $data['tasks_not_completed'], $id);

                $data['tasks_completed'] = total_rows(db_prefix() . 'tasks', [
                'is_session'        => 0,
                'status'            => 5,
                'rel_id'            => $id,
                'rel_type'          => 'project',
                'visible_to_client' => 1,
            ]);
                $data['tasks_completed'] = hooks()->apply_filters('client_project_tasks_completed', $data['tasks_completed'], $id);

                $data['total_tasks']                  = $total_tasks;
                $data['tasks_not_completed_progress'] = ($total_tasks > 0 ? number_format(($data['tasks_completed'] * 100) / $total_tasks, 2) : 0);
                $data['tasks_not_completed_progress'] = round($data['tasks_not_completed_progress'], 2);
            } elseif ($group == 'new_task') {
                if ($project->settings->create_tasks == 0) {
                    redirect(site_url('clients/project/' . $project->id));
                }
                $data['milestones'] = $this->projects_model->get_milestones($id);
            } elseif ($group == 'project_gantt') {
                $data['gantt_data'] = $this->projects_model->get_gantt_data($id);
            } elseif ($group == 'project_discussions') {
                if ($this->input->get('discussion_id')) {
                    $data['discussion_user_profile_image_url'] = contact_profile_image_url(get_contact_user_id());
                    $data['discussion']                        = $this->projects_model->get_discussion($this->input->get('discussion_id'), $id);
                    $data['current_user_is_admin']             = false;
                }
                $data['discussions'] = $this->projects_model->get_discussions($id);
            } elseif ($group == 'project_files') {
                $data['files'] = $this->projects_model->get_files($id);
            } elseif ($group == 'project_tasks') {
                $data['tasks_statuses'] = $this->tasks_model->get_statuses();
                $data['project_tasks']  = $this->projects_model->get_tasks($id);
            } elseif ($group == 'project_contracts') {
                $data['contracts'] = [];
                if (has_contact_permission('contracts')) {
                    $data['contracts'] = $this->contracts_model->get('', [
                            'client'     => get_client_user_id(),
                            'project_id' => $id,
                        ]);
                }
            } elseif ($group == 'project_activity') {
                $data['activity'] = $this->projects_model->get_activity($id);
            } elseif ($group == 'project_milestones') {
                $data['milestones'] = $this->projects_model->get_milestones($id);
            } elseif ($group == 'project_invoices') {
                $data['invoices'] = [];
                if (has_contact_permission('invoices')) {
                    $whereInvoices = [
                            'clientid'   => get_client_user_id(),
                            'project_id' => $id,
                        ];
                    if (get_option('exclude_invoice_from_client_area_with_draft_status') == 1) {
                        $whereInvoices['status !='] = 6;
                    }
                    $data['invoices'] = $this->invoices_model->get('', $whereInvoices);
                }
            } elseif ($group == 'project_tickets') {
                $data['tickets'] = [];
                if (has_contact_permission('support')) {
                    $where_tickets = [
                        db_prefix() . 'tickets.userid' => get_client_user_id(),
                        'project_id'                   => $id,
                    ];

                    if (!!can_logged_in_contact_view_all_tickets()) {
                        $where_tickets[db_prefix() . 'tickets.contactid'] = get_contact_user_id();
                    }

                    $data['tickets']                 = $this->tickets_model->get('', $where_tickets);
                    $data['show_submitter_on_table'] = show_ticket_submitter_on_clients_area_table();
                }
            } elseif ($group == 'project_estimates') {
                $data['estimates'] = [];
                if (has_contact_permission('estimates')) {
                    $data['estimates'] = $this->estimates_model->get('', [
                            'clientid'   => get_client_user_id(),
                            'project_id' => $id,
                        ]);
                }
            } elseif ($group == 'project_timesheets') {
                $data['timesheets'] = $this->projects_model->get_timesheets($id);
            }

            if ($this->input->get('taskid')) {
                $data['view_task'] = $this->tasks_model->get($this->input->get('taskid'), [
                    'rel_id'   => $project->id,
                    'rel_type' => 'project',
                ]);

                $data['title'] = $data['view_task']->name;
            }
        } elseif ($group == 'edit_task') {
            $data['milestones'] = $this->projects_model->get_milestones($id);
            $data['task']       = $this->tasks_model->get($this->input->get('taskid'), [
                    'rel_id'                => $project->id,
                    'rel_type'              => 'project',
                    'addedfrom'             => get_contact_user_id(),
                    'is_added_from_contact' => 1,
                ]);
        }

        $data['group']    = $group;
        $data['currency'] = $this->projects_model->get_currency($id);
        $data['members']  = $this->projects_model->get_project_members($id);

        $this->data($data);
        $this->view('project');
        $this->layout();
    }

    public function legal_services($id, $ServID)
    {

        if (!has_contact_permission('projects')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        $slug = $this->legal->get_service_by_id($ServID)->row()->slug;

        if ($ServID == 1) {
            $project = $this->case->get($id, [
                'clientid' => get_client_user_id(),
            ]);
        } else {
            $project = $this->other->get($ServID, $id, [
                'clientid' => get_client_user_id(),
            ]);
        }

        if (!$project) {
            show_404();
        }

        $data['project']                               = $project;
        $data['project']->settings->available_features = unserialize($data['project']->settings->available_features);

        $data['title'] = $data['project']->name;
        if ($this->input->post('action')) {
            $action = $this->input->post('action');
            switch ($action) {
                case 'new_session':
                case 'edit_session':
                    $data    = $this->input->post();
                    $session_id = false;
                    if (isset($data['session_id'])) {
                        $session_id = $data['session_id'];
                        unset($data['session_id']);
                    }

                    $data['duedate']        = null;
                    $data['rel_type']       = $slug;
                    $data['rel_id']         = $project->id;
                    $data['description']    = nl2br($data['description']);
                    // $data['courts']         = $this->sessions_model->get_court();
                    

                    $assignees = isset($data['assignees']) ? $data['assignees'] : [];
                    if (isset($data['assignees'])) {
                        unset($data['assignees']);
                    }

                    unset($data['action']);
                    
                    if (!$session_id) {
                        $this->load->model('sessions_model');
                        $session_id = $this->sessions_model->add($data, true);
                        
                        if ($session_id) {
                            foreach ($assignees as $assignee) {
                                // $this->sessions_model->remove_assignee(, $session_id);
                                $this->sessions_model->add_task_assignees(['taskid' => $session_id, 'assignee' => $assignee]);
                            }

                            $uploadedFiles = handle_task_attachments_array($session_id);
                            if ($uploadedFiles && is_array($uploadedFiles)) {
                                foreach ($uploadedFiles as $file) {
                                    $file['contact_id'] = get_contact_user_id();
                                    $this->misc_model->add_attachment_to_database($session_id, 'task', [$file]);
                                }
                            }

                            set_alert('success', _l('added_successfully', _l('session')));
                            redirect(site_url('clients/legal_services/' . $project->id . '/' . $ServID. '?group=CaseSession&session_id='. $session_id));

                        }
                    } else {
                        if ($project->settings->edit_sessions == 1
                            && total_rows(db_prefix() . 'tasks', ['is_session' => 1, 'is_added_from_contact' => 1, 'addedfrom' => get_contact_user_id()]) > 0) {
                            $affectedRows = 0;
                            $updated      = $this->sessions_model->update($data, $session_id, true);
                            if ($updated) {
                                $affectedRows++;
                            }

                            $currentAssignees    = $this->sessions_model->get_task_assignees($session_id);
                            $currentAssigneesIds = [];
                            foreach ($currentAssignees as $assigned) {
                                array_push($currentAssigneesIds, $assigned['assigneeid']);
                            }

                            $totalAssignees = count($assignees);

                            /**
                             * In case when contact created the task and then was able to view team members
                             * Now in this case he still can view team members and can edit them
                             */
                            if ($totalAssignees == 0 && $project->settings->view_team_members == 1) {
                                $this->db->where('taskid', $session_id);
                                $this->db->delete(db_prefix() . 'task_assigned');
                            } elseif ($totalAssignees > 0 && $project->settings->view_team_members == 1) {
                                foreach ($currentAssignees as $assigned) {
                                    if (!in_array($assigned['assigneeid'], $assignees)) {
                                        if ($this->sessions_model->remove_assignee($assigned['id'], $session_id)) {
                                            $affectedRows++;
                                        }
                                    }
                                }
                                foreach ($assignees as $assignee) {
                                    if (!$this->sessions_model->is_task_assignee($assignee, $session_id)) {
                                        if ($this->sessions_model->add_task_assignees(['taskid' => $session_id, 'assignee' => $assignee], false, true)) {
                                            $affectedRows++;
                                        }
                                    }
                                }
                            }
                            if ($affectedRows > 0) {
                                set_alert('success', _l('updated_successfully', _l('session')));
                            }
                            redirect(site_url('clients/legal_services/' . $project->id . '/' . $ServID. '?group=CaseSession'));
                        }
                    }

                    redirect(site_url('clients/legal_services/' . $project->id . '/' . $ServID. '?group=CaseSession'));
                    break;
                case 'new_task':
                case 'edit_task':
                    $data    = $this->input->post();
                    $task_id = false;
                    if (isset($data['task_id'])) {
                        $task_id = $data['task_id'];
                        unset($data['task_id']);
                    }

                    $data['rel_type']    = $slug;
                    $data['rel_id']      = $project->id;
                    $data['description'] = nl2br($data['description']);

                    $assignees = isset($data['assignees']) ? $data['assignees'] : [];
                    if (isset($data['assignees'])) {
                        unset($data['assignees']);
                    }
                    unset($data['action']);

                    if (!$task_id) {
                        $task_id = $this->tasks_model->add($data, true);
                        if ($task_id) {
                            foreach ($assignees as $assignee) {
                                $this->tasks_model->add_task_assignees(['taskid' => $task_id, 'assignee' => $assignee], false, true);
                            }
                            $uploadedFiles = handle_task_attachments_array($task_id);
                            if ($uploadedFiles && is_array($uploadedFiles)) {
                                foreach ($uploadedFiles as $file) {
                                    $file['contact_id'] = get_contact_user_id();
                                    $this->misc_model->add_attachment_to_database($task_id, 'task', [$file]);
                                }
                            }
                            set_alert('success', _l('added_successfully', _l('task')));
                            redirect(site_url('clients/legal_services/' . $project->id . '/' . $ServID . '?group=project_tasks&taskid=' . $task_id));
                        }
                    } else {
                        if (
                            $project->settings->edit_tasks == 1
                            && total_rows(db_prefix() . 'tasks', ['is_session' => 0, 'is_added_from_contact' => 1, 'addedfrom' => get_contact_user_id()]) > 0
                        ) {
                            $affectedRows = 0;
                            $updated      = $this->tasks_model->update($data, $task_id, true);
                            if ($updated) {
                                $affectedRows++;
                            }

                            $currentAssignees    = $this->tasks_model->get_task_assignees($task_id);
                            $currentAssigneesIds = [];
                            foreach ($currentAssignees as $assigned) {
                                array_push($currentAssigneesIds, $assigned['assigneeid']);
                            }

                            $totalAssignees = count($assignees);

                            /**
                             * In case when contact created the task and then was able to view team members
                             * Now in this case he still can view team members and can edit them
                             */
                            if ($totalAssignees == 0 && $project->settings->view_team_members == 1) {
                                $this->db->where('taskid', $task_id);
                                $this->db->delete(db_prefix() . 'task_assigned');
                            } elseif ($totalAssignees > 0 && $project->settings->view_team_members == 1) {
                                foreach ($currentAssignees as $assigned) {
                                    if (!in_array($assigned['assigneeid'], $assignees)) {
                                        if ($this->tasks_model->remove_assignee($assigned['id'], $task_id)) {
                                            $affectedRows++;
                                        }
                                    }
                                }
                                foreach ($assignees as $assignee) {
                                    if (!$this->tasks_model->is_task_assignee($assignee, $task_id)) {
                                        if ($this->tasks_model->add_task_assignees(['taskid' => $task_id, 'assignee' => $assignee], false, true)) {
                                            $affectedRows++;
                                        }
                                    }
                                }
                            }
                            if ($affectedRows > 0) {
                                set_alert('success', _l('updated_successfully', _l('task')));
                            }
                            redirect(site_url('clients/legal_services/' . $project->id . '?group=project_tasks&taskid=' . $task_id));
                        }
                    }

                    redirect(site_url('clients/legal_services/' . $project->id . '?group=project_tasks'));

                    break;
                case 'discussion_comments':
                
                    if ($ServID == 1) {
                        echo json_encode($this->case->get_discussion_comments($this->input->post('discussion_id'), $this->input->post('discussion_type')));
                    } else {
                        echo json_encode($this->other->get_discussion_comments($this->input->post('discussion_id'), $this->input->post('discussion_type')));
                    }
                    die;
                case 'new_discussion_comment':
                    if ($ServID == 1) {
                        echo json_encode($this->case->add_discussion_comment($ServID, $this->input->post(), $this->input->post('discussion_id'), $this->input->post('discussion_type')));
                    } else {
                        echo json_encode($this->other->add_discussion_comment($ServID, $this->input->post(), $this->input->post('discussion_id'), $this->input->post('discussion_type')));
                    }
                    die;

                    break;
                case 'update_discussion_comment':
                    if ($ServID == 1) {
                        echo json_encode($this->case->update_discussion_comment($this->input->post(), $this->input->post('discussion_id')));
                    } else {
                        echo json_encode($this->other->update_discussion_comment($this->input->post(), $this->input->post('discussion_id')));
                    }
                    die;

                    break;
                case 'delete_discussion_comment':
                    if ($ServID == 1) {
                        echo json_encode($this->case->delete_discussion_comment($this->input->post('id')));
                    } else {
                        echo json_encode($this->other->delete_discussion_comment($this->input->post('id')));
                    }
                    die;

                    break;
                case 'new_discussion':
                    $discussion_data = $this->input->post();
                    unset($discussion_data['action']);
                    if ($ServID == 1) {
                        $success = $this->case->add_discussion($discussion_data, $ServID);
                    } else {
                        $success = $this->other->add_discussion($discussion_data, $ServID);
                    }
                    if ($success) {
                        set_alert('success', _l('added_successfully', _l('project_discussion')));
                    }
                    redirect(site_url('clients/legal_services/' . $id . '/' . $ServID . '?group=project_discussions'));

                    break;
                case 'upload_file':
                    if ($ServID == 1) {
                        handle_case_file_uploads($ServID, $id);
                    } else {
                        handle_oservice_file_uploads($ServID, $id);
                    }
                    die;

                    break;
                case 'project_file_dropbox': // deprecated
                case 'project_external_file':
                    $data                        = [];
                    $data['project_id']          = $id;
                    $data['files']               = $this->input->post('files');
                    $data['external']            = $this->input->post('external');
                    $data['visible_to_customer'] = 1;
                    $data['contact_id']          = get_contact_user_id();
                    if ($ServID == 1) {
                        $this->case->add_external_file($data);
                    } else {
                        $this->other->add_external_file($data);
                    }
                    die;

                    break;
                case 'get_file':
                    $file_data['discussion_user_profile_image_url'] = contact_profile_image_url(get_contact_user_id());
                    $file_data['current_user_is_admin']             = false;
                    if ($ServID == 1) {
                        $file_data['file']                          = $this->case->get_file($this->input->post('id'), $this->input->post('project_id'));
                    } else {
                        $file_data['file']                          = $this->other->get_file($this->input->post('id'), $this->input->post('project_id'));
                    }
                    $file_data['ServID'] = $ServID;

                    if (!$file_data['file']) {
                        header('HTTP/1.0 404 Not Found');
                        die;
                    }
                    $file_data['ServID'] = $ServID;
                    echo get_template_part('legal_services/file', $file_data, true);
                    die;

                    break;
                case 'update_file_data':
                    $file_data = $this->input->post();
                    unset($file_data['action']);
                    if ($ServID == 1) {
                        $this->case->update_file_data($file_data);
                    } else {
                        $this->other->update_file_data($file_data);
                    }

                    break;
                case 'upload_task_file':
                    $taskid = $this->input->post('task_id');
                    $files  = handle_task_attachments_array($taskid, 'file');
                    if ($files) {
                        $i   = 0;
                        $len = count($files);
                        foreach ($files as $file) {
                            $file['contact_id'] = get_contact_user_id();
                            $file['staffid']    = 0;
                            $this->tasks_model->add_attachment_to_database($taskid, [$file], false, ($i == $len - 1 ? true : false));
                            $i++;
                        }
                    }
                    die;

                    break;
                case 'add_task_external_file':
                    $taskid                = $this->input->post('task_id');
                    $file                  = $this->input->post('files');
                    $file[0]['contact_id'] = get_contact_user_id();
                    $file[0]['staffid']    = 0;
                    $this->tasks_model->add_attachment_to_database($this->input->post('task_id'), $file, $this->input->post('external'));
                    die;

                    break;
                case 'new_task_comment':
                    $comment_data            = $this->input->post();
                    $comment_data['content'] = nl2br($comment_data['content']);
                    $comment_id              = $this->tasks_model->add_task_comment($comment_data);
                    $url                     = site_url('clients/legal_services/' . $id . '/' . $ServID . '?group=project_tasks&taskid=' . $comment_data['taskid']);

                    if ($comment_id) {
                        set_alert('success', _l('task_comment_added'));
                        $url .= '#comment_' . $comment_id;
                    }

                    redirect($url);

                    break;
                case 'new_session_comment':
                    $comment_data            = $this->input->post();
                    $comment_data['content'] = nl2br($comment_data['content']);
                    $comment_id              = $this->sessions_model->add_task_comment($comment_data);
                    $url                     = site_url('clients/legal_services/' . $id .'/'. $ServID . '?group=CaseSession&session_id=' . $comment_data['taskid']);

                    if ($comment_id) {
                        set_alert('success', _l('task_comment_added'));
                        $url .= '#comment_' . $comment_id;
                    }

                    redirect($url);

                    break;
                default:
                    redirect(site_url('clients/legal_services/' . $id));

                    break;
            }
        }
        if (!$this->input->get('group')) {
            $group = 'project_overview';
        } else {
            $group = $this->input->get('group');
        }
        if ($ServID == 1) {
            $data['project_status'] = get_case_status_by_id($data['project']->status);
        } else {
            $data['project_status'] = get_oservice_status_by_id($data['project']->status);
        }
        if ($group != 'edit_task' && $group != 'edit_session') {
            if ($group == 'project_overview') {
                if ($ServID == 1) {
                    $percent = $this->case->calc_progress($id, $slug);
                } else {
                    $percent = $this->other->calc_progress($slug, $id);
                }
                @$data['percent'] = $percent / 100;
                $this->load->helper('date');
                $data['project_total_days']        = round((human_to_unix($data['project']->deadline . ' 00:00') - human_to_unix($data['project']->start_date . ' 00:00')) / 3600 / 24);
                $data['project_days_left']         = $data['project_total_days'];
                $data['project_time_left_percent'] = 100;
                if ($data['project']->deadline) {
                    if (human_to_unix($data['project']->start_date . ' 00:00') < time() && human_to_unix($data['project']->deadline . ' 00:00') > time()) {
                        $data['project_days_left'] = round((human_to_unix($data['project']->deadline . ' 00:00') - time()) / 3600 / 24);

                        $data['project_time_left_percent'] = $data['project_days_left'] / $data['project_total_days'] * 100;
                        $data['project_time_left_percent'] = round($data['project_time_left_percent'], 2);
                    }
                    if (human_to_unix($data['project']->deadline . ' 00:00') < time()) {
                        $data['project_days_left']         = 0;
                        $data['project_time_left_percent'] = 0;
                    }
                }
                $total_tasks = total_rows(db_prefix() . 'tasks', [
                    'is_session'        => 0,
                    'rel_id'            => $id,
                    'rel_type'          => $slug,
                    'visible_to_client' => 1,
                ]);
                $total_tasks = hooks()->apply_filters('client_project_total_tasks', $total_tasks, $id);

                $data['tasks_not_completed'] = total_rows(db_prefix() . 'tasks', [
                    'is_session'        => 0,
                    'status !='         => 5,
                    'rel_id'            => $id,
                    'rel_type'          => $slug,
                    'visible_to_client' => 1,
                ]);

                $data['tasks_not_completed'] = hooks()->apply_filters('client_project_tasks_not_completed', $data['tasks_not_completed'], $id);

                $data['tasks_completed'] = total_rows(db_prefix() . 'tasks', [
                    'is_session'        => 0,
                    'status'            => 5,
                    'rel_id'            => $id,
                    'rel_type'          => $slug,
                    'visible_to_client' => 1,
                ]);
                $data['tasks_completed'] = hooks()->apply_filters('client_project_tasks_completed', $data['tasks_completed'], $id);

                $data['total_tasks']                  = $total_tasks;
                $data['tasks_not_completed_progress'] = ($total_tasks > 0 ? number_format(($data['tasks_completed'] * 100) / $total_tasks, 2) : 0);
                $data['tasks_not_completed_progress'] = round($data['tasks_not_completed_progress'], 2);
            } elseif ($group == 'new_task') {
                if ($project->settings->create_tasks == 0) {
                    redirect(site_url('clients/legal_services/' . $project->id . '/' . $ServID));
                }
                if ($ServID == 1) {
                    $data['milestones'] = $this->case->get_milestones($slug, $id);
                } else {
                    $data['milestones'] = $this->other->get_milestones($slug, $id);
                }
            
            } elseif ($group == 'new_session') {
                if ($project->settings->create_sessions == 0) {
                    redirect(site_url('clients/legal_services/' . $project->id. '/' .$ServID));
                }
                if($ServID == 1){
                    $data['default_courts'] = get_default_value_id_by_table_name('my_courts', 'c_id');
                    $data['courts']         = $this->sessions_model->get_court();
                    $data['milestones'] = $this->case->get_milestones($slug, $id);
                    $data['judges']      = $this->sessions_model->get_judges();
                }else{
                    $data['milestones'] = $this->other->get_milestones($slug, $id);
                }
            } elseif ($group == 'project_gantt') {
                if ($ServID == 1) {
                    $data['gantt_data'] = $this->case->get_gantt_data($slug, $id);
                } else {
                    $data['gantt_data'] = $this->other->get_gantt_data($slug, $id);
                }
            } elseif ($group == 'CaseSession') {
                if ($ServID == 1) {
                    $data['service_id']  = $ServID;
                    $data['rel_id']      = $id;
                    $data['project_tasks']  = $this->case->get_CaseSession($id);
                    // $data['num_session'] = $this->sessions_model->count_sessions($ServID, $id);
                    $data['judges']      = $this->sessions_model->get_judges();
                    $data['courts']      = $this->sessions_model->get_court();
                } else {
                    $data['gantt_data'] = $this->other->get_gantt_data($slug, $id);
                }
            } elseif ($group == 'project_discussions') {
                if ($this->input->get('discussion_id')) {
                    $data['discussion_user_profile_image_url'] = contact_profile_image_url(get_contact_user_id());
                    if ($ServID == 1) {
                        $data['discussion'] = $this->case->get_discussion($this->input->get('discussion_id'), $id);
                    } else {
                        $data['discussion'] = $this->other->get_discussion($this->input->get('discussion_id'), $id);
                    }
                    $data['current_user_is_admin']             = false;
                }
                if ($ServID == 1) {
                    $data['discussions'] = $this->case->get_discussions($id);
                } else {
                    $data['discussions'] = $this->other->get_discussions($id);
                }
            } elseif ($group == 'project_files') {
                if ($ServID == 1) {
                    $data['files'] = $this->case->get_files($id);
                } else {
                    $data['files'] = $this->other->get_files($id);
                }
            } elseif ($group == 'project_tasks') {
                $data['tasks_statuses'] = $this->tasks_model->get_statuses();
                if ($ServID == 1) {
                    $data['project_tasks']  = $this->case->get_tasks($id);
                } else {
                    $data['project_tasks']  = $this->other->get_tasks($ServID, $id);
                }
            } elseif ($group == 'project_contracts') {
                $data['contracts'] = [];
                if (has_contact_permission('contracts')) {
                    $data['contracts'] = $this->contracts_model->get('', [
                        'client'  => get_client_user_id(),
                        'rel_sid' => $id,
                        'rel_stype' => $slug,
                    ]);
                }
            } elseif ($group == 'project_activity') {
                if ($ServID == 1) {
                    $data['activity'] = $this->case->get_activity($id);
                } else {
                    $data['activity'] = $this->other->get_activity($id);
                }
            } elseif ($group == 'project_milestones') {
                if ($ServID == 1) {
                    $data['milestones'] = $this->case->get_milestones($slug, $id);
                } else {
                    $data['milestones'] = $this->other->get_milestones($slug, $id);
                }
            } elseif ($group == 'project_invoices') {
                $data['invoices'] = [];
                if (has_contact_permission('invoices')) {
                    $whereInvoices = [
                        'clientid'   => get_client_user_id(),
                        'rel_sid' => $id,
                        'rel_stype' => $slug
                    ];
                    if (get_option('exclude_invoice_from_client_area_with_draft_status') == 1) {
                        $whereInvoices['status !='] = 6;
                    }
                    $data['invoices'] = $this->invoices_model->get('', $whereInvoices);
                }
            } elseif ($group == 'project_tickets') {
                $data['tickets'] = [];
                if (has_contact_permission('support')) {
                    $where_tickets = [
                        db_prefix() . 'tickets.userid' => get_client_user_id(),
                        'project_id'                   => 0,
                        'rel_stype'                    => $slug,
                        'rel_sid'                    => get_case()->id
                    ];

                    if (!!can_logged_in_contact_view_all_tickets()) {
                        $where_tickets[db_prefix() . 'tickets.contactid'] = get_contact_user_id();
                    }

                    $data['tickets']                 = $this->tickets_model->get('', $where_tickets);
                    $data['show_submitter_on_table'] = show_ticket_submitter_on_clients_area_table();
                }
            } elseif ($group == 'project_estimates') {
                $data['estimates'] = [];
                if (has_contact_permission('estimates')) {
                    $data['estimates'] = $this->estimates_model->get('', [
                        'clientid'   => get_client_user_id(),
                        'project_id' => 0,
                        'rel_sid' => $id,
                        'rel_stype' => $slug
                    ]);
                }
            } elseif ($group == 'project_timesheets') {
                if ($ServID == 1) {
                    $data['timesheets'] = $this->case->get_timesheets($id);
                } else {
                    $data['timesheets'] = $this->other->get_timesheets($ServID, $id);
                }
            } elseif ($group == 'procuration') {
                $data['procuration'] = $this->procurations->get_procurations(get_client_user_id());
            }

            if ($this->input->get('taskid')) {
                $data['view_task'] = $this->tasks_model->get($this->input->get('taskid'), [
                    'rel_id'   => $project->id,
                    'rel_type' => $slug,
                ]);

                $data['title'] = $data['view_task']->name;
            }
            if ($this->input->get('session_id')) {
                $data['view_task']              = $this->tasks_model->get($this->input->get('session_id'), [
                    'rel_id'   => $project->id,
                    'rel_type' => $slug,
                ], 1);
                $data['staff']                  = $this->staff_model->get('', ['active' => 1]);
                $data['session_data']           = $this->sessions_model->get_session_data($this->input->get('session_id'));
                $data['court_decision']         = $data['session_data']->tbl8;
                $data['session_information']    = $data['session_data']->tbl7;
                $data['title']                  = $data['view_task']->name;
                
            }
        } elseif ($group == 'edit_task') {
            if ($ServID == 1) {
                $data['milestones'] = $this->case->get_milestones($slug, $id);
            } else {
                $data['milestones'] = $this->other->get_milestones($slug, $id);
            }
            $data['task']       = $this->tasks_model->get($this->input->get('taskid'), [
                'rel_id'                => $project->id,
                'rel_type'              => $slug,
                'addedfrom'             => get_contact_user_id(),
                'is_added_from_contact' => 1,
            ]);
        } elseif($group == 'edit_session') {
            if ($project->settings->edit_sessions == 0) {
                redirect(site_url('clients/legal_services/' . $project->id. '/' .$ServID));
            }
            if($ServID == 1){
                $data['courts']         = $this->sessions_model->get_court();
                $data['default_courts'] = get_default_value_id_by_table_name('my_courts', 'c_id');
                $data['milestones'] = $this->case->get_milestones($slug, $id);
                $data['judges']      = $this->sessions_model->get_judges();
            }else{
                $data['milestones'] = $this->other->get_milestones($slug, $id);
            }
            
            $data['courts']         = $this->sessions_model->get_court();
            $data['session']       = $this->sessions_model->get($this->input->get('session_id'), [
                'rel_id'                => $project->id,
                'rel_type'              => $slug,
                'addedfrom'             => get_contact_user_id(),
                'is_added_from_contact' => 1,
            ], 1);
        }

        $data['group']    = $group;

        if ($ServID == 1) {
            $data['currency'] = $this->case->get_currency($id);
            $data['members']  = $this->case->get_project_members($id);
        } else {
            $data['currency'] = $this->other->get_currency($id);
            $data['members']  = $this->other->get_project_members($id);
        }

        $data['ServID'] = $ServID;

        $this->data($data);
        $this->view('legal_services');
        $this->layout();
    }

    public function GetJudicialByCourtID($id)
    {
        $arr = $this->court->get_judicial_of_courts($id)->result();
        $response = '<div class="form-group">
        <label class="control-label">'._l('NumJudicialDept'). '</label>
        <select class="form-control custom_select_arrow" aria-invalid="false" id="dept" name="dept" placeholder="dropdown_non_selected_tex">';
        foreach($arr as $item){
            $response.= '<option value="'.$item->j_id.'">'.$item->Jud_number . '</option>';
        }
        $response .= '</select></div>';
        echo ($response);
    }

    public function download_all_project_files($id)
    {
        if (!has_contact_permission('projects')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        $files = $this->projects_model->get_files($id);

        if (count($files) == 0) {
            set_alert('warning', _l('no_files_found'));
            redirect(site_url('clients/project/' . $id . '?group=project_files'));
        }

        $path = get_upload_path_by_type('project') . $id;
        $this->load->library('zip');

        foreach ($files as $file) {
            $this->zip->read_file($path . '/' . $file['file_name']);
        }

        $this->zip->download(slug_it(get_project_name_by_id($id)) . '-files.zip');
        $this->zip->clear_data();
    }

     public function download_all_session_files($id, $comment_id = null)
    {
        $taskWhere = 'external IS NULL';

        if ($comment_id) {
            $taskWhere .= ' AND task_comment_id=' . $this->db->escape_str($comment_id);
        }

        if (!has_permission('sessions', '', 'view')) {
            $taskWhere .= ' AND ' . get_sessions_where_string(false);
        }

        $files = $this->sessions_model->get_task_attachments($id, $taskWhere);

        if (count($files) == 0) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $path = get_upload_path_by_type('task') . $id;

        $this->load->library('zip');

        foreach ($files as $file) {
            $this->zip->read_file($path . '/' . $file['file_name']);
        }

        $this->zip->download('files.zip');
        $this->zip->clear_data();
    }

    public function download_all_case_files($id)
    {
        if (!has_contact_permission('projects')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        $files = $this->case->get_files($id);

        if (count($files) == 0) {
            set_alert('warning', _l('no_files_found'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        $path = get_upload_path_by_type('case') . $id;
        $this->load->library('zip');

        foreach ($files as $file) {
            $this->zip->read_file($path . '/' . $file['file_name']);
        }

        $this->zip->download(slug_it(get_case_name_by_id($id)) . '-files.zip');
        $this->zip->clear_data();
    }

    public function download_all_oservice_files($id)
    {
        if (!has_contact_permission('projects')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        $files = $this->other->get_files($id);

        if (count($files) == 0) {
            set_alert('warning', _l('no_files_found'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        $path = get_upload_path_by_type('oservice') . $id;
        $this->load->library('zip');

        foreach ($files as $file) {
            $this->zip->read_file($path . '/' . $file['file_name']);
        }

        $this->zip->download(slug_it(get_oservice_name_by_id($id)) . '-files.zip');
        $this->zip->clear_data();
    }

    public function files()
    {
        $files_where = 'visible_to_customer = 1 AND id IN (SELECT file_id FROM ' . db_prefix() . 'shared_customer_files WHERE contact_id =' . get_contact_user_id() . ')';

        $files_where = hooks()->apply_filters('customers_area_files_where', $files_where);

        $files = $this->clients_model->get_customer_files(get_client_user_id(), $files_where);

        $data['files'] = $files;
        $data['title'] = _l('customer_attachments');
        $this->data($data);
        $this->view('files');
        $this->layout();
    }

    public function upload_files()
    {
        $success = false;
        if ($this->input->post('external')) {
            $file                        = $this->input->post('files');
            $file[0]['staffid']          = 0;
            $file[0]['contact_id']       = get_contact_user_id();
            $file['visible_to_customer'] = 1;
            $success                     = $this->misc_model->add_attachment_to_database(
                get_client_user_id(),
                'customer',
                $file,
                $this->input->post('external')
            );
        } else {
            $success = handle_client_attachments_upload(get_client_user_id(), true);
        }

        if ($success) {
            $this->clients_model->send_notification_customer_profile_file_uploaded_to_responsible_staff(
                get_contact_user_id(),
                get_client_user_id()
            );
        }
    }

     public function delete_file($id, $type = '', $ServID = '')
    {
        if (get_option('allow_contact_to_delete_files') == 1) {
            if ($type == 'general') {
                $file = $this->misc_model->get_file($id);
                if ($file->contact_id == get_contact_user_id()) {
                    $this->clients_model->delete_attachment($id);
                    set_alert('success', _l('deleted', _l('file')));
                }
                redirect(site_url('clients/files'));
            } elseif ($type == 'project') {
                $this->load->model('projects_model');
                $file = $this->projects_model->get_file($id);
                if ($file->contact_id == get_contact_user_id()) {
                    $this->projects_model->remove_file($id);
                    set_alert('success', _l('deleted', _l('file')));
                }
                redirect(site_url('clients/project/' . $file->project_id . '?group=project_files'));
            } elseif ($type == 'task' || $type == 'session') {
                $file = $this->misc_model->get_file($id);
                if ($file->contact_id == get_contact_user_id()) {
                    $this->tasks_model->remove_task_attachment($id);
                    set_alert('success', _l('deleted', _l('file')));
                }

                if ($type == 'task')
                {
                    redirect(site_url('clients/legal_services/' . $this->input->get('project_id') . '/'. $ServID . '?group=project_tasks&taskid=' . $file->rel_id));
                } else 
                {
                    redirect(site_url('clients/legal_services/' . $this->input->get('project_id') . '/'. $ServID .'?group=CaseSession&session_id=' . $file->rel_id));
                }
            } elseif ($type == 'legal_services') {
                if ($ServID == 1) {
                    $this->load->model('legalservices/Cases_model', 'case');
                    $file = $this->case->get_file($id);
                    if ($file->contact_id == get_contact_user_id()) {
                        $this->case->remove_file($id);
                        set_alert('success', _l('deleted', _l('file')));
                    }
                } else {
                    $this->load->model('legalservices/Other_services_model', 'other');
                    $file = $this->other->get_file($id);
                    if ($file->contact_id == get_contact_user_id()) {
                        $this->other->remove_file($id);
                        set_alert('success', _l('deleted', _l('file')));
                    }
                }
                redirect(site_url('clients/legal_services/' . $file->project_id . '/' . $ServID . '?group=project_files'));
            }
        }
        redirect(site_url());
    }

    public function remove_task_comment($id)
    {
        echo json_encode([
            'success' => $this->tasks_model->remove_comment($id),
        ]);
    }

    public function edit_comment()
    {
        if ($this->input->post()) {
            $data            = $this->input->post();
            $data['content'] = nl2br($data['content']);
            $success         = $this->tasks_model->edit_comment($data);
            if ($success) {
                set_alert('success', _l('task_comment_updated'));
            }
            echo json_encode([
                'success' => $success,
            ]);
        }
    }

    public function tickets($status = '')
    {
        if (!has_contact_permission('support')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        $where = db_prefix() . 'tickets.userid=' . get_client_user_id();
        if (!can_logged_in_contact_view_all_tickets()) {
            $where .= ' AND ' . db_prefix() . 'tickets.contactid=' . get_contact_user_id();
        }

        $data['show_submitter_on_table'] = show_ticket_submitter_on_clients_area_table();

        $defaultStatuses = hooks()->apply_filters('customers_area_list_default_ticket_statuses', [1, 2, 3, 4]);
        // By default only open tickets
        if (!is_numeric($status)) {
            $where .= ' AND status IN (' . implode(', ', $defaultStatuses) . ')';
        } else {
            $where .= ' AND status=' . $this->db->escape_str($status);
        }

        $data['list_statuses'] = is_numeric($status) ? [$status] : $defaultStatuses;
        $data['bodyclass']     = 'tickets';
        $data['tickets']       = $this->tickets_model->get('', $where);
        $data['title']         = _l('clients_tickets_heading');
        $this->data($data);
        $this->view('tickets');
        $this->layout();
    }

    public function change_ticket_status()
    {
        if (has_contact_permission('support')) {
            $post_data = $this->input->post();
            if (can_change_ticket_status_in_clients_area($post_data['status_id'])) {
                $response = $this->tickets_model->change_ticket_status($post_data['ticket_id'], $post_data['status_id']);
                set_alert($response['alert'], $response['message']);
            }
        }
    }

    public function proposals()
    {
        if (!has_contact_permission('proposals')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        $where = 'rel_id =' . get_client_user_id() . ' AND rel_type ="customer"';

        if (get_option('exclude_proposal_from_client_area_with_draft_status') == 1) {
            $where .= ' AND status != 6';
        }

        $client = $this->clients_model->get(get_client_user_id());

        if (!is_null($client->leadid)) {
            $where .= ' OR rel_type="lead" AND rel_id=' . $client->leadid;
        }

        $data['proposals'] = $this->proposals_model->get('', $where);
        $data['title']     = _l('proposals');
        $this->data($data);
        $this->view('proposals');
        $this->layout();
    }

    public function open_ticket()
    {
        if (!has_contact_permission('support')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }
        if ($this->input->post()) {
            $this->form_validation->set_rules('subject', _l('customer_ticket_subject'), 'required');
            $this->form_validation->set_rules('department', _l('clients_ticket_open_departments'), 'required');
            $this->form_validation->set_rules('priority', _l('priority'), 'required');
            $custom_fields = get_custom_fields('tickets', [
                'show_on_client_portal' => 1,
                'required'              => 1,
            ]);
            foreach ($custom_fields as $field) {
                $field_name = 'custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']';
                if ($field['type'] == 'checkbox' || $field['type'] == 'multiselect') {
                    $field_name .= '[]';
                }
                $this->form_validation->set_rules($field_name, $field['name'], 'required');
            }
            if ($this->form_validation->run() !== false) {
                $data = $this->input->post();
                $tkt_data = [
                    'subject'    => $data['subject'],
                    'department' => $data['department'],
                    'priority'   => $data['priority'],
                    'service'    => isset($data['service']) && is_numeric($data['service'])
                        ? $data['service']
                        : null,
                    'project_id' => isset($data['project_id']) && is_numeric($data['project_id'])
                        ? $data['project_id']
                        : 0,
                    'custom_fields' => isset($data['custom_fields']) && is_array($data['custom_fields'])
                        ? $data['custom_fields']
                        : [],
                    'message'   => $data['message'],
                    'contactid' => get_contact_user_id(),
                    'userid'    => get_client_user_id(),
                ];
                if (isset($data['ServID']) && $data['ServID'] != '') {
                    $slug = $this->legal->get_service_by_id($data['ServID'])->row()->slug;
                    $tkt_data['rel_sid'] = $data['rel_sid'];
                    $tkt_data['rel_stype'] = $slug;
                    $tkt_data['project_id'] = 0;
                    unset($data['ServID']);
                }
                $id = $this->tickets_model->add($tkt_data);
                if ($id) {
                    set_alert('success', _l('new_ticket_added_successfully', $id));
                    redirect(site_url('clients/ticket/' . $id));
                }
            }
        }
        $data             = [];
        if ($this->input->get('ServID') && $this->input->get('ServID') != '') {
            if ($this->input->get('ServID') == 1){
                $data['projects'] = $this->case->get_projects_for_ticket(get_client_user_id());
            }else{
                $data['projects'] = $this->other->get_projects_for_ticket($this->input->get('ServID'),get_client_user_id());
            }
        }else{
            $array1 = $this->projects_model->get_projects_for_ticket(get_client_user_id());
            $array2 = $this->case->get_projects_for_ticket(get_client_user_id());
            $array3 = $this->other->get_all_other_services(['clientid' => get_client_user_id()]);
            $data['projects'] = array_merge($array1, $array2, $array3);
        }
        $data['title']    = _l('new_ticket');
        $this->data($data);

        $this->view('open_ticket');
        $this->layout();
    }

    public function ticket($id)
    {
        if (!has_contact_permission('support')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        if (!$id) {
            redirect(site_url());
        }

        $data['ticket'] = $this->tickets_model->get_ticket_by_id($id, get_client_user_id());
        if (!$data['ticket'] || $data['ticket']->userid != get_client_user_id()) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('message', _l('ticket_reply'), 'required');

            if ($this->form_validation->run() !== false) {
                $data = $this->input->post();

                $replyid = $this->tickets_model->add_reply([
                    'message'   => $data['message'],
                    'contactid' => get_contact_user_id(),
                    'userid'    => get_client_user_id(),
                ], $id);
                if ($replyid) {
                    set_alert('success', _l('replied_to_ticket_successfully', $id));
                }
                redirect(site_url('clients/ticket/' . $id));
            }
        }

        $data['ticket_replies'] = $this->tickets_model->get_ticket_replies($id);
        $data['title']          = $data['ticket']->subject;
        $this->data($data);
        $this->view('single_ticket');
        $this->layout();
    }

    public function contracts()
    {
        if (!has_contact_permission('contracts')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }
        $data['contracts'] = $this->contracts_model->get('', [
            'client'                => get_client_user_id(),
            'not_visible_to_client' => 0,
            'trash'                 => 0,
        ]);

        $data['contracts_by_type_chart'] = json_encode($this->contracts_model->get_contracts_types_chart_data());
        $data['title']                   = _l('clients_contracts');
        $this->data($data);
        $this->view('contracts');
        $this->layout();
    }

    public function invoices($status = false)
    {
        if (!has_contact_permission('invoices')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        $where = [
            'clientid' => get_client_user_id(),
        ];

        if (is_numeric($status)) {
            $where['status'] = $status;
        }

        if (isset($where['status'])) {
            if ($where['status'] == Invoices_model::STATUS_DRAFT
                && get_option('exclude_invoice_from_client_area_with_draft_status') == 1) {
                unset($where['status']);
                $where['status !='] = Invoices_model::STATUS_DRAFT;
            }
        } else {
            if (get_option('exclude_invoice_from_client_area_with_draft_status') == 1) {
                $where['status !='] = Invoices_model::STATUS_DRAFT;
            }
        }

        $data['invoices'] = $this->invoices_model->get('', $where);
        $data['title']    = _l('clients_my_invoices');
        $this->data($data);
        $this->view('invoices');
        $this->layout();
    }

    public function statement()
    {
        if (!has_contact_permission('invoices')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        $data = [];
        // Default to this month
        $from = _d(date('Y-m-01'));
        $to   = _d(date('Y-m-t'));

        if ($this->input->get('from') && $this->input->get('to')) {
            $from = $this->input->get('from');
            $to   = $this->input->get('to');
        }

        $data['statement'] = $this->clients_model->get_statement(get_client_user_id(), to_sql_date($from), to_sql_date($to));

        $data['from'] = $from;
        $data['to']   = $to;

        $data['period_today'] = json_encode(
                     [
                     _d(date('Y-m-d')),
                     _d(date('Y-m-d')),
                     ]
        );
        $data['period_this_week'] = json_encode(
                     [
                     _d(date('Y-m-d', strtotime('monday this week'))),
                     _d(date('Y-m-d', strtotime('sunday this week'))),
                     ]
        );
        $data['period_this_month'] = json_encode(
                     [
                     _d(date('Y-m-01')),
                     _d(date('Y-m-t')),
                     ]
        );

        $data['period_last_month'] = json_encode(
                     [
                     _d(date('Y-m-01', strtotime('-1 MONTH'))),
                     _d(date('Y-m-t', strtotime('-1 MONTH'))),
                     ]
        );

        $data['period_this_year'] = json_encode(
                     [
                     _d(date('Y-m-d', strtotime(date('Y-01-01')))),
                     _d(date('Y-m-d', strtotime(date('Y-12-31')))),
                     ]
        );
        $data['period_last_year'] = json_encode(
                     [
                     _d(date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-01-01')))),
                     _d(date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-12-31')))),
                     ]
        );

        $data['period_selected'] = json_encode([$from, $to]);

        $data['custom_period'] = ($this->input->get('custom_period') ? true : false);

        $data['title'] = _l('customer_statement');
        $this->data($data);
        $this->view('statement');
        $this->layout();
    }

    public function statement_pdf()
    {
        if (!has_contact_permission('invoices')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        $from = $this->input->get('from');
        $to   = $this->input->get('to');

        $data['statement'] = $this->clients_model->get_statement(
            get_client_user_id(),
            to_sql_date($from),
            to_sql_date($to)
        );

        try {
            $pdf = statement_pdf($data['statement']);
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }

        $type = 'D';
        if ($this->input->get('print')) {
            $type = 'I';
        }

        $pdf_name = slug_it(_l('customer_statement') . '_' . get_option('companyname'));
        $pdf->Output($pdf_name . '.pdf', $type);
    }

    public function estimates($status = '')
    {
        if (!has_contact_permission('estimates')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }
        $where = [
            'clientid' => get_client_user_id(),
        ];
        if (is_numeric($status)) {
            $where['status'] = $status;
        }
        if (isset($where['status'])) {
            if ($where['status'] == 1 && get_option('exclude_estimate_from_client_area_with_draft_status') == 1) {
                unset($where['status']);
                $where['status !='] = 1;
            }
        } else {
            if (get_option('exclude_estimate_from_client_area_with_draft_status') == 1) {
                $where['status !='] = 1;
            }
        }
        $data['estimates'] = $this->estimates_model->get('', $where);
        $data['title']     = _l('clients_my_estimates');
        $this->data($data);
        $this->view('estimates');
        $this->layout();
    }

    public function company()
    {
        if ($this->input->post() && is_primary_contact()) {
            if (get_option('company_is_required') == 1) {
                $this->form_validation->set_rules('company', _l('clients_company'), 'required');
            }

            if (active_clients_theme() == 'babil') {
                // Fix for custom fields checkboxes validation
                $this->form_validation->set_rules('company_form', '', 'required');
            }

            $custom_fields = get_custom_fields('customers', [
                'show_on_client_portal'  => 1,
                'required'               => 1,
                'disalow_client_to_edit' => 0,
            ]);

            foreach ($custom_fields as $field) {
                $field_name = 'custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']';
                if ($field['type'] == 'checkbox' || $field['type'] == 'multiselect') {
                    $field_name .= '[]';
                }
                $this->form_validation->set_rules($field_name, $field['name'], 'required');
            }

            if ($this->form_validation->run() !== false) {
                $data['company'] = $this->input->post('company');

                if (!is_null($this->input->post('vat'))) {
                    $data['vat'] = $this->input->post('vat');
                }

                if (!is_null($this->input->post('default_language'))) {
                    $data['default_language'] = $this->input->post('default_language');
                }

                if (!is_null($this->input->post('custom_fields'))) {
                    $data['custom_fields'] = $this->input->post('custom_fields');
                }

                $data['phonenumber'] = $this->input->post('phonenumber');
                $data['website']     = $this->input->post('website');
                $data['country']     = $this->input->post('country');
                $data['city']        = $this->input->post('city');
                $data['address']     = $this->input->post('address');
                $data['zip']         = $this->input->post('zip');
                $data['state']       = $this->input->post('state');

                if (get_option('allow_primary_contact_to_view_edit_billing_and_shipping') == 1
                    && is_primary_contact()) {

                    // Dynamically get the billing and shipping values from $_POST
                    for ($i = 0; $i < 2; $i++) {
                        $prefix = ($i == 0 ? 'billing_' : 'shipping_');
                        foreach (['street', 'city', 'state', 'zip', 'country'] as $field) {
                            $data[$prefix . $field] = $this->input->post($prefix . $field);
                        }
                    }
                }

                $success = $this->clients_model->update_company_details($data, get_client_user_id());
                if ($success == true) {
                    set_alert('success', _l('clients_profile_updated'));
                }

                redirect(site_url('clients/company'));
            }
        }
        $data['title'] = _l('client_company_info');
        $this->data($data);
        $this->view('company_profile');
        $this->layout();
    }

    public function profile()
    {
        if ($this->input->post('profile')) {
            $this->form_validation->set_rules('firstname', _l('client_firstname'), 'required');
            //$this->form_validation->set_rules('lastname', _l('client_lastname'), 'required');

            $this->form_validation->set_message('contact_email_profile_unique', _l('form_validation_is_unique'));
            $this->form_validation->set_rules('email', _l('clients_email'), 'required|valid_email|callback_contact_email_profile_unique');

            $custom_fields = get_custom_fields('contacts', [
                'show_on_client_portal'  => 1,
                'required'               => 1,
                'disalow_client_to_edit' => 0,
            ]);
            foreach ($custom_fields as $field) {
                $field_name = 'custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']';
                if ($field['type'] == 'checkbox' || $field['type'] == 'multiselect') {
                    $field_name .= '[]';
                }
                $this->form_validation->set_rules($field_name, $field['name'], 'required');
            }
            if ($this->form_validation->run() !== false) {
                handle_contact_profile_image_upload();

                $data = $this->input->post();

                $contact = $this->clients_model->get_contact(get_contact_user_id());

                if (has_contact_permission('invoices')) {
                    $data['invoice_emails']     = isset($data['invoice_emails']) ? 1 : 0;
                    $data['credit_note_emails'] = isset($data['credit_note_emails']) ? 1 : 0;
                } else {
                    $data['invoice_emails']     = $contact->invoice_emails;
                    $data['credit_note_emails'] = $contact->credit_note_emails;
                }

                if (has_contact_permission('estimates')) {
                    $data['estimate_emails'] = isset($data['estimate_emails']) ? 1 : 0;
                } else {
                    $data['estimate_emails'] = $contact->estimate_emails;
                }

                if (has_contact_permission('support')) {
                    $data['ticket_emails'] = isset($data['ticket_emails']) ? 1 : 0;
                } else {
                    $data['ticket_emails'] = $contact->ticket_emails;
                }

                if (has_contact_permission('contracts')) {
                    $data['contract_emails'] = isset($data['contract_emails']) ? 1 : 0;
                } else {
                    $data['contract_emails'] = $contact->contract_emails;
                }

                if (has_contact_permission('projects')) {
                    $data['project_emails'] = isset($data['project_emails']) ? 1 : 0;
                    $data['task_emails']    = isset($data['task_emails']) ? 1 : 0;
                } else {
                    $data['project_emails'] = $contact->project_emails;
                    $data['task_emails']    = $contact->task_emails;
                }

                $success = $this->clients_model->update_contact([
                    'firstname'          => $this->input->post('firstname'),
                    //'lastname'           => $this->input->post('lastname'),
                    'title'              => $this->input->post('title'),
                    'email'              => $this->input->post('email'),
                    'phonenumber'        => $this->input->post('phonenumber'),
                    'direction'          => $this->input->post('direction'),
                    'invoice_emails'     => $data['invoice_emails'],
                    'credit_note_emails' => $data['credit_note_emails'],
                    'estimate_emails'    => $data['estimate_emails'],
                    'ticket_emails'      => $data['ticket_emails'],
                    'contract_emails'    => $data['contract_emails'],
                    'project_emails'     => $data['project_emails'],
                    'task_emails'        => $data['task_emails'],
                    'custom_fields'      => isset($data['custom_fields']) && is_array($data['custom_fields']) ? $data['custom_fields'] : [],
                ], get_contact_user_id(), true);

                if ($success == true) {
                    set_alert('success', _l('clients_profile_updated'));
                }

                redirect(site_url('clients/profile'));
            }
        } elseif ($this->input->post('change_password')) {
            $this->form_validation->set_rules('oldpassword', _l('clients_edit_profile_old_password'), 'required');
            $this->form_validation->set_rules('newpassword', _l('clients_edit_profile_new_password'), 'required');
            $this->form_validation->set_rules('newpasswordr', _l('clients_edit_profile_new_password_repeat'), 'required|matches[newpassword]');
            if ($this->form_validation->run() !== false) {
                $success = $this->clients_model->change_contact_password(
                    get_contact_user_id(),
                    $this->input->post('oldpassword', false),
                    $this->input->post('newpasswordr', false)
                );

                if (is_array($success) && isset($success['old_password_not_match'])) {
                    set_alert('danger', _l('client_old_password_incorrect'));
                } elseif ($success == true) {
                    set_alert('success', _l('client_password_changed'));
                }

                redirect(site_url('clients/profile'));
            }
        }
        $data['title'] = _l('clients_profile_heading');
        $this->data($data);
        $this->view('profile');
        $this->layout();
    }

    public function remove_profile_image()
    {
        $id = get_contact_user_id();

        hooks()->do_action('before_remove_contact_profile_image', $id);

        if (file_exists(get_upload_path_by_type('contact_profile_images') . $id)) {
            delete_dir(get_upload_path_by_type('contact_profile_images') . $id);
        }

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'contacts', [
            'profile_image' => null,
        ]);

        if ($this->db->affected_rows() > 0) {
            redirect(site_url('clients/profile'));
        }
    }

    public function dismiss_announcement($id)
    {
        $this->misc_model->dismiss_announcement($id, false);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update_credit_card()
    {
        if (!can_logged_in_contact_update_credit_card()) {
            redirect(site_url());
        }

        $this->load->library('stripe_subscriptions');
        $this->load->library('stripe_core');
        $this->load->model('subscriptions_model');

        $sessionData = [
              'payment_method_types' => ['card'],
              'mode'                 => 'setup',
              'setup_intent_data'    => [
                'metadata' => [
                  'customer_id' => $this->clients_model->get(get_client_user_id())->stripe_id,
                ],
              ],
              'success_url' => site_url('clients/success_update_card?session_id={CHECKOUT_SESSION_ID}'),
              'cancel_url'  => $cancelUrl = site_url('clients/credit_card'),
            ];

        $contact = $this->clients_model->get_contact(get_contact_user_id());

        if ($contact->email) {
            $sessionData['customer_email'] = $contact->email;
        }

        try {
            $session = $this->stripe_core->create_session($sessionData);
            redirect_to_stripe_checkout($session->id);
        } catch (Exception $e) {
            set_alert('warning', $e->getMessage());
            redirect($cancelUrl);
        }
    }

    public function success_update_card()
    {
        if (!can_logged_in_contact_update_credit_card()) {
            redirect(site_url());
        }

        $this->load->library('stripe_core');

        try {
            $session = $this->stripe_core->retrieve_session([
                'id'     => $this->input->get('session_id'),
                'expand' => ['setup_intent.payment_method'],
            ]);

            $session->setup_intent->payment_method->attach(['customer' => $session->setup_intent->metadata->customer_id]);

            $this->stripe_core->update_customer($session->setup_intent->metadata->customer_id, [
                'invoice_settings' => [
                    'default_payment_method' => $session->setup_intent->payment_method->id,
                  ],
              ]);

            set_alert('success', _l('updated_successfully', _l('credit_card')));
        } catch (Exception $e) {
            set_alert('warning', $e->getMessage());
        }

        redirect(site_url('clients/credit_card'));
    }

    public function credit_card()
    {
        if (!can_logged_in_contact_update_credit_card()) {
            redirect(site_url());
        }

        $this->load->library('stripe_core');
        $client = $this->clients_model->get(get_client_user_id());

        $data['stripe_customer'] = $this->stripe_core->get_customer($client->stripe_id);
        $data['payment_method']  = null;

        if (!empty($data['stripe_customer']->invoice_settings->default_payment_method)) {
            $data['payment_method'] = $this->stripe_core->retrieve_payment_method($data['stripe_customer']->invoice_settings->default_payment_method);
        }

        $data['bodyclass'] = 'customer-credit-card';
        $data['title']     = _l('credit_card');

        $this->data($data);
        $this->view('credit_card');
        $this->layout();
    }

    public function delete_credit_card()
    {
        if (customer_can_delete_credit_card()) {
            $client = $this->clients_model->get(get_client_user_id());

            $this->load->library('stripe_core');

            $stripeCustomer = $this->stripe_core->get_customer($client->stripe_id);

            try {
                $payment_method = $this->stripe_core->retrieve_payment_method($stripeCustomer->invoice_settings->default_payment_method);
                $payment_method->detach();

                set_alert('success', _l('credit_card_successfully_deleted'));
            } catch (Exception $e) {
                set_alert('warning', $e->getMessage());
            }
        }

        redirect(site_url('clients/credit_card'));
    }

    public function subscriptions()
    {
        if (!can_logged_in_contact_view_subscriptions()) {
            redirect(site_url());
        }

        $this->load->model('subscriptions_model');
        $data['subscriptions'] = $this->subscriptions_model->get(['clientid' => get_client_user_id()]);

        $data['show_projects'] = total_rows(db_prefix() . 'subscriptions', 'project_id != 0 AND clientid=' . get_client_user_id()) > 0 && has_contact_permission('projects');

        $data['title']     = _l('subscriptions');
        $data['bodyclass'] = 'subscriptions';
        $this->data($data);
        $this->view('subscriptions');
        $this->layout();
    }

    public function cancel_subscription($id)
    {
        if (!is_primary_contact(get_contact_user_id())
            || get_option('show_subscriptions_in_customers_area') != '1') {
            redirect(site_url());
        }

        $this->load->model('subscriptions_model');
        $this->load->library('stripe_subscriptions');
        $subscription = $this->subscriptions_model->get_by_id($id, ['clientid' => get_client_user_id()]);

        if (!$subscription) {
            show_404();
        }

        try {
            $type    = $this->input->get('type');
            $ends_at = time();
            if ($type == 'immediately') {
                $this->stripe_subscriptions->cancel($subscription->stripe_subscription_id);
            } elseif ($type == 'at_period_end') {
                $ends_at = $this->stripe_subscriptions->cancel_at_end_of_billing_period($subscription->stripe_subscription_id);
            } else {
                throw new Exception('Invalid Cancelation Type', 1);
            }

            $update = ['ends_at' => $ends_at];
            if ($type == 'immediately') {
                $update['status'] = 'canceled';
            }
            $this->subscriptions_model->update($id, $update);

            set_alert('success', _l('subscription_canceled'));
        } catch (Exception $e) {
            set_alert('danger', $e->getMessage());
        }

        redirect(site_url('clients/subscriptions'));
    }

    public function resume_subscription($id)
    {
        if (!is_primary_contact(get_contact_user_id())
            || get_option('show_subscriptions_in_customers_area') != '1') {
            redirect(site_url());
        }

        $this->load->model('subscriptions_model');
        $this->load->library('stripe_subscriptions');
        $subscription = $this->subscriptions_model->get_by_id($id, ['clientid' => get_client_user_id()]);

        if (!$subscription) {
            show_404();
        }

        try {
            $this->stripe_subscriptions->resume($subscription->stripe_subscription_id, $subscription->stripe_plan_id);
            $this->subscriptions_model->update($id, ['ends_at' => null]);
            set_alert('success', _l('subscription_resumed'));
        } catch (Exception $e) {
            set_alert('danger', $e->getMessage());
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function gdpr()
    {
        $this->load->model('gdpr_model');

        if (is_gdpr()
            && $this->input->post('removal_request')
            && get_option('gdpr_contact_enable_right_to_be_forgotten') == '1') {
            $success = $this->gdpr_model->add_removal_request([
                'description'  => nl2br($this->input->post('removal_description')),
                'request_from' => get_contact_full_name(get_contact_user_id()),
                'contact_id'   => get_contact_user_id(),
                'clientid'     => get_client_user_id(),
            ]);
            if ($success) {
                send_gdpr_email_template('gdpr_removal_request_by_customer', get_contact_user_id());
                set_alert('success', _l('data_removal_request_sent'));
            }
            redirect(site_url('clients/gdpr'));
        }

        $data['title'] = _l('gdpr');
        $this->data($data);
        $this->view('gdpr');
        $this->layout();
    }

    public function change_language($lang = '')
    {
        if (is_language_disabled()) {
            redirect(site_url());
        }

        set_contact_language($lang);

        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect(site_url());
        }
    }

    public function export()
    {
        if (is_gdpr()
            && get_option('gdpr_data_portability_contacts') == '0'
            || !is_gdpr()) {
            show_error('This page is currently disabled, check back later.');
        }

        $this->load->library('gdpr/gdpr_contact');
        $this->gdpr_contact->export(get_contact_user_id());
    }

    /**
     * Client home chart
     * @return mixed
     */
    public function client_home_chart()
    {
        $statuses = [
                1,
                2,
                4,
                3,
            ];
        $months          = [];
        $months_original = [];
        for ($m = 1; $m <= 12; $m++) {
            array_push($months, _l(date('F', mktime(0, 0, 0, $m, 1))));
            array_push($months_original, date('F', mktime(0, 0, 0, $m, 1)));
        }
        $chart = [
                'labels'   => $months,
                'datasets' => [],
            ];
        foreach ($statuses as $status) {
            $this->db->select('total as amount, date');
            $this->db->from(db_prefix() . 'invoices');
            $this->db->where('clientid', get_client_user_id());
            $this->db->where('status', $status);
            $by_currency = $this->input->post('report_currency');
            if ($by_currency) {
                $this->db->where('currency', $by_currency);
            }
            if ($this->input->post('year')) {
                $this->db->where('YEAR(' . db_prefix() . 'invoices.date)', $this->input->post('year'));
            }
            $payments      = $this->db->get()->result_array();
            $data          = [];
            $data['temp']  = $months_original;
            $data['total'] = [];
            $i             = 0;
            foreach ($months_original as $month) {
                $data['temp'][$i] = [];
                foreach ($payments as $payment) {
                    $_month = date('F', strtotime($payment['date']));
                    if ($_month == $month) {
                        $data['temp'][$i][] = $payment['amount'];
                    }
                }
                $data['total'][] = array_sum($data['temp'][$i]);
                $i++;
            }

            if ($status == 1) {
                $borderColor = '#fc142b';
            } elseif ($status == 2) {
                $borderColor = '#84c529';
            } elseif ($status == 4 || $status == 3) {
                $borderColor = '#ff6f00';
            }

            $backgroundColor = 'rgba(' . implode(',', hex2rgb($borderColor)) . ',0.3)';

            array_push($chart['datasets'], [
                    'label'           => format_invoice_status($status, '', false, true),
                    'backgroundColor' => $backgroundColor,
                    'borderColor'     => $borderColor,
                    'borderWidth'     => 1,
                    'tension'         => false,
                    'data'            => $data['total'],
                ]);
        }
        echo json_encode($chart);
    }

    public function contact_email_profile_unique($email)
    {
        return total_rows(db_prefix() . 'contacts', 'id !=' . get_contact_user_id() . ' AND email="' . get_instance()->db->escape_str($email) . '"') > 0 ? false : true;
    }

    public function procuration_pdf($id)
    {
        if (!$id) {
            redirect(site_url());
        }

        $procuration = $this->procurations->get($id);
        //$procuration        = hooks()->apply_filters('before_admin_view_procuration_pdf', $procuration);

        try {
            $pdf = procuration_pdf($procuration);
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

        $pdf_name = $procuration->name;
        $pdf->Output(mb_strtoupper(slug_it($pdf_name)) . '.pdf', $type);
    }
}
