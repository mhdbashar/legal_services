<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Projects_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
                [
                    'name'      => _l('project_name'),
                    'key'       => '{project_name}',
                    'available' => [
                        'project',
                    ],
                ],
                [
                    'name'      => _l('project_description'),
                    'key'       => '{project_description}',
                    'available' => [
                        'project',
                    ],
                ],
                [
                    'name'      => _l('project_start_date'),
                    'key'       => '{project_start_date}',
                    'available' => [
                        'project',
                    ],
                ],
                [
                    'name'      => _l('project_deadline'),
                    'key'       => '{project_deadline}',
                    'available' => [
                        'project',
                    ],
                ],
                [
                    'name'      => _l('project_link'),
                    'key'       => '{project_link}',
                    'available' => [
                        'project',
                    ],
                ],
                    [
                    'name'      => _l('file_creator'),
                    'key'       => '{file_creator}',
                    'available' => [
                    ],
                    'templates' => [
                        'new-project-file-uploaded-to-customer',
                        'new-project-file-uploaded-to-staff',
                    ],
                ],
                [
                    'name'      => _l('comment_creator'),
                    'key'       => '{comment_creator}',
                    'available' => [
                    ],
                    'templates' => [
                        'new-project-discussion-comment-to-customer',
                        'new-project-discussion-comment-to-staff',
                    ],
                ],
                [
                    'name'      => _l('discussion_link'),
                    'key'       => '{discussion_link}',
                    'available' => [
                    ],
                    'templates' => [
                        'new-project-discussion-created-to-staff',
                        'new-project-discussion-created-to-customer',
                        'new-project-discussion-comment-to-customer',
                        'new-project-discussion-comment-to-staff',
                        'new-project-file-uploaded-to-staff',
                        'new-project-file-uploaded-to-customer',
                    ],
                ],
                [
                    'name'      => _l('discussion_subject'),
                    'key'       => '{discussion_subject}',
                    'available' => [
                    ],
                     'templates' => [
                        'new-project-discussion-created-to-staff',
                        'new-project-discussion-created-to-customer',
                        'new-project-discussion-comment-to-customer',
                        'new-project-discussion-comment-to-staff',
                        'new-project-file-uploaded-to-staff',
                        'new-project-file-uploaded-to-customer',
                    ],
                ],
                [
                    'name'      => _l('discussion_description'),
                    'key'       => '{discussion_description}',
                    'available' => [
                    ],
                     'templates' => [
                        'new-project-discussion-created-to-staff',
                        'new-project-discussion-created-to-customer',
                        'new-project-discussion-comment-to-customer',
                        'new-project-discussion-comment-to-staff',
                    ],
                ],
                [
                    'name'      => _l('discussion_creator'),
                    'key'       => '{discussion_creator}',
                    'available' => [
                    ],
                    'templates' => [
                        'new-project-discussion-created-to-staff',
                        'new-project-discussion-created-to-customer',
                        'new-project-discussion-comment-to-customer',
                        'new-project-discussion-comment-to-staff',
                    ],
                ],
                [
                    'name'      => _l('discussion_comment'),
                    'key'       => '{discussion_comment}',
                    'available' => [
                    ],
                    'templates' => [
                        'new-project-discussion-comment-to-customer',
                        'new-project-discussion-comment-to-staff',
                    ],
                ],
            ];
    }

    /**
     * Project merge fields
     * @param  mixed $project_id      project id
     * @param  array  $additional_data option to pass additional data for the templates eq is staff template or customer template
     * This field is also used for the project discussion files and regular discussions
     * @return array
     */
    public function format($project_id, $additional_data = [])
    {

        $serv_table  = 'projects';
        $dis_table   = 'projectdiscussions';
        $files_table = 'project_files';
        $comm_table  = 'projectdiscussioncomments';
        $custom_fields_var = 'projects';
        if (isset($additional_data['ServID']) && $additional_data['ServID'] != '') {
            $this->ci->load->model('legalservices/LegalServicesModel', 'legal');
            if($additional_data['ServID'] == 1){
                $serv_table  = 'my_cases';
                $dis_table   = 'casediscussions';
                $files_table = 'case_files';
                $comm_table  = 'casediscussioncomments';
                $custom_fields_var = $this->ci->legal->get_service_by_id($additional_data['ServID'])->row()->slug;
            }else{
                $serv_table  = 'my_other_services';
                $dis_table   = 'oservicediscussions';
                $files_table = 'oservice_files';
                $comm_table  = 'oservicediscussioncomments';
                $custom_fields_var = $this->ci->legal->get_service_by_id($additional_data['ServID'])->row()->slug;
            }
        }
        $fields = [];

        $fields['{project_name}']           = '';
        $fields['{project_deadline}']       = '';
        $fields['{project_start_date}']     = '';
        $fields['{project_description}']    = '';
        $fields['{project_link}']           = '';
        $fields['{discussion_link}']        = '';
        $fields['{discussion_creator}']     = '';
        $fields['{comment_creator}']        = '';
        $fields['{file_creator}']           = '';
        $fields['{discussion_subject}']     = '';
        $fields['{discussion_description}'] = '';
        $fields['{discussion_comment}']     = '';


        $this->ci->db->where('id', $project_id);
        $project = $this->ci->db->get(db_prefix().$serv_table)->row();
        $fields['{project_name}']        = $project->name;
        $fields['{project_deadline}']    = _d($project->deadline);
        $fields['{project_start_date}']  = _d($project->start_date);
        $fields['{project_description}'] = $project->description;

        $custom_fields = get_custom_fields($custom_fields_var);
        foreach ($custom_fields as $field) {
            $fields['{' . $field['slug'] . '}'] = get_custom_field_value($project_id, $field['id'], $custom_fields_var);
        }

        if (is_client_logged_in()) {
            $cf = get_contact_full_name(get_contact_user_id());
        } else {
            $cf = get_staff_full_name(get_staff_user_id());
        }

        $fields['{file_creator}']       = $cf;
        $fields['{discussion_creator}'] = $cf;
        $fields['{comment_creator}']    = $cf;

        if (isset($additional_data['discussion_id'])) {
            $this->ci->db->where('id', $additional_data['discussion_id']);

            if (isset($additional_data['discussion_type']) && $additional_data['discussion_type'] == 'regular') {
                $table = db_prefix().$dis_table;
            } else {
                // is file
                $table = db_prefix().$files_table;
            }

            $discussion = $this->ci->db->get($table)->row();


            $fields['{discussion_subject}']     = $discussion->subject;
            $fields['{discussion_description}'] = $discussion->description;

            if (isset($additional_data['discussion_comment_id'])) {
                $this->ci->db->where('id', $additional_data['discussion_comment_id']);
                $discussion_comment             = $this->ci->db->get(db_prefix().$comm_table)->row();
                $fields['{discussion_comment}'] = $discussion_comment->content;
            }
        }
        if (isset($additional_data['customer_template'])) {

            $fields['{project_link}'] = site_url('clients/project/' . $project_id);

            if (isset($additional_data['discussion_id']) && isset($additional_data['discussion_type']) && $additional_data['discussion_type'] == 'regular') {
                $fields['{discussion_link}'] = site_url('clients/project/' . $project_id . '?group=project_discussions&discussion_id=' . $additional_data['discussion_id']);
            } elseif (isset($additional_data['discussion_id']) && isset($additional_data['discussion_type']) && $additional_data['discussion_type'] == 'file') {
                // is file
                $fields['{discussion_link}'] = site_url('clients/project/' . $project_id . '?group=project_files&file_id=' . $additional_data['discussion_id']);
            }

            if (isset($additional_data['ServID']) && $additional_data['ServID'] != '') {
                if ($additional_data['ServID'] == 1) {
                    $fields['{project_link}'] = site_url('clients/legal_services/' . $project_id. '/'. $additional_data['ServID']);

                    if (isset($additional_data['discussion_id']) && isset($additional_data['discussion_type']) && $additional_data['discussion_type'] == 'regular') {
                        $fields['{discussion_link}'] = site_url('clients/legal_services/' . $project_id . '/'. $additional_data['ServID'] . '?group=project_discussions&discussion_id=' . $additional_data['discussion_id']);
                    } elseif (isset($additional_data['discussion_id']) && isset($additional_data['discussion_type']) && $additional_data['discussion_type'] == 'file') {
                        // is file
                        $fields['{discussion_link}'] = site_url('clients/legal_services/' . $project_id  . '/'. $additional_data['ServID'] . '?group=project_files&file_id=' . $additional_data['discussion_id']);
                    }
                }else{
                    $fields['{project_link}'] = site_url('clients/legal_services/' . $project_id. '/'. $additional_data['ServID']);

                    if (isset($additional_data['discussion_id']) && isset($additional_data['discussion_type']) && $additional_data['discussion_type'] == 'regular') {
                        $fields['{discussion_link}'] = site_url('clients/legal_services/' . $project_id . '/'. $additional_data['ServID'] . '?group=project_discussions&discussion_id=' . $additional_data['discussion_id']);
                    } elseif (isset($additional_data['discussion_id']) && isset($additional_data['discussion_type']) && $additional_data['discussion_type'] == 'file') {
                        // is file
                        $fields['{discussion_link}'] = site_url('clients/legal_services/' . $project_id . '/'. $additional_data['ServID'] . '?group=project_files&file_id=' . $additional_data['discussion_id']);
                    }
                }
            }

        } else {
            $fields['{project_link}'] = admin_url('projects/view/' . $project_id);
            if (isset($additional_data['discussion_type']) && $additional_data['discussion_type'] == 'regular' && isset($additional_data['discussion_id'])) {
                $fields['{discussion_link}'] = admin_url('projects/view/' . $project_id . '?group=project_discussions&discussion_id=' . $additional_data['discussion_id']);
            } else {
                if (isset($additional_data['discussion_id'])) {
                    // is file
                    $fields['{discussion_link}'] = admin_url('projects/view/' . $project_id . '?group=project_files&file_id=' . $additional_data['discussion_id']);
                }
            }

            if (isset($additional_data['ServID']) && $additional_data['ServID'] != '') {
                if($additional_data['ServID'] == 1){
                    $fields['{project_link}'] = admin_url('Case/view/' .$additional_data['ServID'].'/'. $project_id);
                    if (isset($additional_data['discussion_type']) && $additional_data['discussion_type'] == 'regular' && isset($additional_data['discussion_id'])) {
                        $fields['{discussion_link}'] = admin_url('Case/view/' .$additional_data['ServID'].'/'. $project_id . '?group=project_discussions&discussion_id=' . $additional_data['discussion_id']);
                    } else {
                        if (isset($additional_data['discussion_id'])) {
                            // is file
                            $fields['{discussion_link}'] = admin_url('Case/view/' .$additional_data['ServID'].'/'. $project_id . '?group=project_files&file_id=' . $additional_data['discussion_id']);
                        }
                    }
                }else{
                    $fields['{project_link}'] = admin_url('SOther/view/' .$additional_data['ServID'].'/'. $project_id);
                    if (isset($additional_data['discussion_type']) && $additional_data['discussion_type'] == 'regular' && isset($additional_data['discussion_id'])) {
                        $fields['{discussion_link}'] = admin_url('SOther/view/' .$additional_data['ServID'].'/'. $project_id . '?group=project_discussions&discussion_id=' . $additional_data['discussion_id']);
                    } else {
                        if (isset($additional_data['discussion_id'])) {
                            // is file
                            $fields['{discussion_link}'] = admin_url('SOther/view/' .$additional_data['ServID'].'/'. $project_id . '?group=project_files&file_id=' . $additional_data['discussion_id']);
                        }
                    }
                }
            }

        }

        $custom_fields = get_custom_fields($custom_fields_var);
        foreach ($custom_fields as $field) {
            $fields['{' . $field['slug'] . '}'] = get_custom_field_value($project_id, $field['id'], $custom_fields_var);
        }

        return hooks()->apply_filters('project_merge_fields', $fields, [
        'id'              => $project_id,
        'project'         => $project,
        'additional_data' => $additional_data,
     ]);
    }
}
