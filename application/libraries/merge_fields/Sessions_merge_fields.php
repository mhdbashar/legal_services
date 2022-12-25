<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sessions_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
//            [
//                'name'      => _l('staff_contact_who_take_action_on_session'),
//                'key'       => '{session_user_take_action}',
//                'available' => [
//                    'sessions',
//                ],
//            ],
            [
                'name'      => _l('session_link'),
                'key'       => '{session_link}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => _l('comment_link'),
                'key'       => '{comment_link}',
                'available' => [
                ],
                'templates' => [
                    'session-commented',
                    'session-commented-to-contacts',
                ],
            ],
            [
                'name'      => _l('session_name'),
                'key'       => '{session_name}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => _l('session_description'),
                'key'       => '{session_description}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => _l('session_status'),
                'key'       => '{session_status}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => _l('session_comment'),
                'key'       => '{session_comment}',
                'available' => [

                ],
                'templates' => [
                    'session-commented',
                    'session-commented-to-contacts',
                ],
            ],
//            [
//                'name'      => _l('session_priority'),
//                'key'       => '{session_priority}',
//                'available' => [
//                    'sessions',
//                ],
//            ],
            [
                'name'      => _l('session_start_date'),
                'key'       => '{session_startdate}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => _l('session_due_date'),
                'key'       => '{session_time}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => _l('related_to'),
                'key'       => '{session_related}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => _l('next_session_date'),
                'key'       => '{next_session_date}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => _l('next_session_time'),
                'key'       => '{next_session_time}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => _l('session_type'),
                'key'       => '{session_type}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => _l('session_information'),
                'key'       => '{session_information}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => _l('court_decision'),
                'key'       => '{court_decision}',
                'available' => [
                    'sessions',
                ],
            ],
        ];
    }

    /**
     * Merge fields for tasks
     * @param  mixed  $task_id         task id
     * @param  boolean $client_template is client template or staff template
     * @return array
     */
    public function format($task_id, $client_template = false)
    {
        $fields = [];

        $this->ci->db->where('id', $task_id);
        $task = $this->ci->db->get(db_prefix().'tasks')->row();
        $this->ci->db->where('task_id', $task_id);
        $session_info = $this->ci->db->get(db_prefix() .'my_session_info')->row();

        if(isset($task->rel_type) && $task->rel_type != null) {
            $service_id = $this->ci->legal->get_service_id_by_slug($task->rel_type);
        }
        if (!$task || !$session_info) {
            return $fields;
        }

        // Client templateonly passed when sending to tasks related to project and sending email template to contacts
        // Passed from tasks_model  _send_task_responsible_users_notification function
        if ($client_template == false) {
            if(isset($service_id)) {
                if ($service_id == 1) {
                    $fields['{session_link}'] = admin_url('Case/view/' . $service_id . '/' . $task->rel_id . '?group=CaseSession&sessionid=' . $task_id);
                }elseif ($service_id == 22){
                    $fields['{session_link}'] = admin_url('Disputes_cases/view/' . $service_id . '/' . $task->rel_id . '?group=CaseSession&sessionid=' . $task_id);
                } else {
                    $fields['{session_link}'] = admin_url('SOther/view/' . $service_id . '/' . $task->rel_id . '?group=OserviceSession&sessionid=' . $task_id);
                }
            }
        } else {
            $fields['{session_link}'] = site_url('clients/project/' . $task->rel_id . '?group=project_tasks&taskid=' . $task_id);
        }

//        if (is_client_logged_in()) {
//            $fields['{session_user_take_action}'] = get_contact_full_name(get_contact_user_id());
//        } else {
//            $fields['{session_user_take_action}'] = get_staff_full_name(get_staff_user_id());
//        }

        $fields['{session_comment}'] = '';
        $fields['{session_related}'] = '';
        $fields['{service_name}'] = '';

        if ($task->rel_type == 'project') {
            $this->ci->db->select('name, clientid');
            $this->ci->db->from(db_prefix().'projects');
            $this->ci->db->where('id', $task->rel_id);
            $project = $this->ci->db->get()->row();
            if ($project) {
                $fields['{service_name}'] = $project->name;
            }
        }

        if (!empty($task->rel_id)) {
            $rel_data                 = get_relation_data($task->rel_type, $task->rel_id);
            $rel_values               = get_relation_values($rel_data, $task->rel_type);
            $fields['{session_related}'] = $rel_values['name'];
        }

        $fields['{session_name}']        = $task->name;
        $fields['{session_description}'] = $task->description;

        $languageChanged = false;

        // The tasks status may not be translated if the client language is not loaded
        if (!is_client_logged_in()
            && $task->rel_type == 'project'
            && $project
            && isset($GLOBALS['SENDING_EMAIL_TEMPLATE_CLASS'])
            && !$GLOBALS['SENDING_EMAIL_TEMPLATE_CLASS']->get_staff_id() // email to client
        ) {
            load_client_language($project->clientid);
            $languageChanged = true;
        } else {
            if (isset($GLOBALS['SENDING_EMAIL_TEMPLATE_CLASS'])) {
                $sending_to_staff_id = $GLOBALS['SENDING_EMAIL_TEMPLATE_CLASS']->get_staff_id();
                if ($sending_to_staff_id) {
                    load_admin_language($sending_to_staff_id);
                    $languageChanged = true;
                }
            }
        }

        $fields['{session_status}']   = format_session_status($task->status, false, true);
//        $fields['{session_priority}'] = session_priority($task->priority);

        $custom_fields = get_custom_fields('sessions');
        foreach ($custom_fields as $field) {
            $fields['{' . $field['slug'] . '}'] = get_custom_field_value($task_id, $field['id'], 'tasks');
        }

        if (!is_client_logged_in() && $languageChanged) {
            load_admin_language();
        } elseif (is_client_logged_in() && $languageChanged) {
            load_client_language();
        }
        $CI = &get_instance();
        $CI->load->library('app_modules');
        $task->duedate = $CI->app_modules->is_active('hijri') ? _d($task->duedate) . '  &  ' . to_hijri_date(_d($task->duedate)) : _d($task->duedate);
        $session_info->next_session_date = $CI->app_modules->is_active('hijri') ? _d($session_info->next_session_date) . '  &  ' . to_hijri_date(_d($session_info->next_session_date)) : _d($session_info->next_session_date);
        $task->startdate = $CI->app_modules->is_active('hijri') ? _d($task->startdate) . '  &  ' . to_hijri_date(_d($task->startdate)) : _d($task->startdate);

        $time_format = get_option('time_format');
        $session_info->time = $time_format === '24' ? date('h:i', strtotime($session_info->time)) : date('h:i a', strtotime($session_info->time));
        $session_info->next_session_time = $time_format === '24' ? date('h:i', strtotime($session_info->next_session_time)) : date('h:i a', strtotime($session_info->next_session_time));

        $fields['{session_startdate}'] = $task->startdate;
        $fields['{session_time}']   = $session_info->time;
        $fields['{comment_link}']   = '';

        $fields['{next_session_date}'] = $session_info->next_session_date;
        $fields['{next_session_time}']   = $session_info->next_session_time;
        $fields['{session_type}']   = $session_info->session_type;
        $fields['{session_information}']   = $session_info->session_information;
        $fields['{court_decision}']   = $session_info->court_decision;

        $this->ci->db->where('taskid', $task_id);
        $this->ci->db->limit(1);
        $this->ci->db->order_by('dateadded', 'desc');
        $comment = $this->ci->db->get(db_prefix().'task_comments')->row();

        if ($comment) {
            $fields['{session_comment}'] = $comment->content;
            $fields['{comment_link}'] = $fields['{session_link}'] . '#comment_' . $comment->id;
        }

        return hooks()->apply_filters('sessions_merge_fields', $fields, [
            'id'              => $task_id,
            'task'            => $task,
            'client_template' => $client_template,
        ]);
    }
}
