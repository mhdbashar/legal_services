<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sessions_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => 'Staff/Contact who take action on session',
                'key'       => '{session_user_take_action}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => 'Session Link',
                'key'       => '{session_link}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => 'Comment Link',
                'key'       => '{comment_link}',
                'available' => [
                ],
                'templates' => [
                    'session-commented',
                    'session-commented-to-contacts',
                ],
            ],
            [
                'name'      => 'Session Name',
                'key'       => '{session_name}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => 'Session Description',
                'key'       => '{session_description}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => 'Session Status',
                'key'       => '{session_status}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => 'Session Comment',
                'key'       => '{session_comment}',
                'available' => [

                ],
                'templates' => [
                    'session-commented',
                    'session-commented-to-contacts',
                ],
            ],
            [
                'name'      => 'Session Priority',
                'key'       => '{session_priority}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => 'Session Start Date',
                'key'       => '{session_startdate}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => 'Session Due Date',
                'key'       => '{session_duedate}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => 'Related to',
                'key'       => '{session_related}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => 'Next Session Date',
                'key'       => '{next_session_date}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => 'Next Session Time',
                'key'       => '{next_session_time}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => 'Session Type',
                'key'       => '{session_type}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => 'Session Information',
                'key'       => '{session_information}',
                'available' => [
                    'sessions',
                ],
            ],
            [
                'name'      => 'Court Decision',
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

        $service_id = $this->ci->legal->get_service_id_by_slug($task->rel_type);

        if (!$task) {
            return $fields;
        }

        // Client templateonly passed when sending to tasks related to project and sending email template to contacts
        // Passed from tasks_model  _send_task_responsible_users_notification function
        if ($client_template == false) {
            if($service_id == 1) {
                $fields['{session_link}'] = admin_url('Case/view/' . $service_id. '/' .$task->rel_id .'?group=CaseSession&sessionid=' . $task_id);
            }else{
                $fields['{session_link}'] = admin_url('SOther/view/' . $service_id. '/' .$task->rel_id .'?group=OserviceSession&sessionid=' . $task_id);
            }
        } else {
            $fields['{session_link}'] = site_url('clients/project/' . $task->rel_id . '?group=project_tasks&taskid=' . $task_id);
        }

        if (is_client_logged_in()) {
            $fields['{session_user_take_action}'] = get_contact_full_name(get_contact_user_id());
        } else {
            $fields['{session_user_take_action}'] = get_staff_full_name(get_staff_user_id());
        }

        $fields['{session_comment}'] = '';
        $fields['{session_related}'] = '';
        $fields['{project_name}'] = '';

        if ($task->rel_type == 'project') {
            $this->ci->db->select('name, clientid');
            $this->ci->db->from(db_prefix().'projects');
            $this->ci->db->where('id', $task->rel_id);
            $project = $this->ci->db->get()->row();
            if ($project) {
                $fields['{project_name}'] = $project->name;
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

        $fields['{session_status}']   = format_task_status($task->status, false, true);
        $fields['{session_priority}'] = task_priority($task->priority);

        $custom_fields = get_custom_fields('tasks');
        foreach ($custom_fields as $field) {
            $fields['{' . $field['slug'] . '}'] = get_custom_field_value($task_id, $field['id'], 'tasks');
        }

        if (!is_client_logged_in() && $languageChanged) {
            load_admin_language();
        } elseif (is_client_logged_in() && $languageChanged) {
            load_client_language();
        }

        $fields['{session_startdate}'] = _d($task->startdate);
        $fields['{session_duedate}']   = _d($task->duedate);
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
