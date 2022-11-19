<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Staff_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
        [
                    'name'      => _l('staff_fullname'),
                    'key'       => '{staff_fullname}',
                    'available' => [
                        'staff',
                        'gdpr',
                    ],
                    'templates' => [
                        'task-status-change-to-staff',
                        'task-commented',
                        'task-deadline-notification',
                        'task-added-attachment',
                        'task-added-as-follower',
                        'task-assigned',
                        'new-project-discussion-created-to-staff',
                        'new-project-file-uploaded-to-staff',
                        'new-project-discussion-comment-to-staff',
                        'staff-added-as-project-member',
                        'contract-expiration-to-staff',
                        'contract-signed-to-staff',
                        'contract-comment-to-admin',
                        'regular-duration-deadline-notification',
                    ],
                ],
            [
                'name'      => _l('firstname'),
                'key'       => '{staff_firstname}',
                'available' => [
                    'staff',
                    'gdpr',
                ],
                'templates' => [
                    'task-status-change-to-staff',
                    'task-commented',
                    'task-deadline-notification',
                    'task-added-attachment',
                    'task-added-as-follower',
                    'task-assigned',
                    'new-project-discussion-created-to-staff',
                    'new-project-file-uploaded-to-staff',
                    'new-project-discussion-comment-to-staff',
                    'staff-added-as-project-member',
                    'contract-expiration-to-staff',
                    'contract-signed-to-staff',
                    'contract-comment-to-admin',
                    'regular-duration-deadline-notification',
                ],
            ],
            [
                'name'      => _l('staff_add_edit_second_name'),
                'key'       => '{staff_second_name}',
                'available' => [
                    'staff',
                    'gdpr',
                ],
                'templates' => [
                    'task-status-change-to-staff',
                    'task-commented',
                    'task-deadline-notification',
                    'task-added-attachment',
                    'task-added-as-follower',
                    'task-assigned',
                    'new-project-discussion-created-to-staff',
                    'new-project-file-uploaded-to-staff',
                    'new-project-discussion-comment-to-staff',
                    'staff-added-as-project-member',
                    'contract-expiration-to-staff',
                    'contract-signed-to-staff',
                    'contract-comment-to-admin',
                    'regular-duration-deadline-notification',
                ],
            ],
            [
                'name'      => _l('staff_add_edit_third_name'),
                'key'       => '{staff_third_name}',
                'available' => [
                    'staff',
                    'gdpr',
                ],
                'templates' => [
                    'task-status-change-to-staff',
                    'task-commented',
                    'task-deadline-notification',
                    'task-added-attachment',
                    'task-added-as-follower',
                    'task-assigned',
                    'new-project-discussion-created-to-staff',
                    'new-project-file-uploaded-to-staff',
                    'new-project-discussion-comment-to-staff',
                    'staff-added-as-project-member',
                    'contract-expiration-to-staff',
                    'contract-signed-to-staff',
                    'contract-comment-to-admin',
                    'regular-duration-deadline-notification',
                ],
            ],
            [
                'name'      => _l('lastname'),
                'key'       => '{staff_lastname}',
                'available' => [
                    'staff',
                    'gdpr',
                ],
                'templates' => [
                    'task-status-change-to-staff',
                    'task-commented',
                    'task-deadline-notification',
                    'task-added-attachment',
                    'task-added-as-follower',
                    'task-assigned',
                    'new-project-discussion-created-to-staff',
                    'new-project-file-uploaded-to-staff',
                    'new-project-discussion-comment-to-staff',
                    'staff-added-as-project-member',
                    'contract-expiration-to-staff',
                    'contract-signed-to-staff',
                    'contract-comment-to-admin',
                    'regular-duration-deadline-notification',
                ],
            ],
                [
                    'name'      => _l('staff_email'),
                    'key'       => '{staff_email}',
                    'available' => [
                        'staff',
                    ],
                    'templates' => [
                        'new-project-discussion-created-to-staff',
                        'new-project-file-uploaded-to-staff',
                        'new-project-discussion-comment-to-staff',
                        'staff-added-as-project-member',
                        'regular-duration-deadline-notification',
                    ],
                ],
                [
                    'name'      => _l('staff_datecreated'),
                    'key'       => '{staff_datecreated}',
                    'available' => [
                        'staff',
                    ],
                ],
                [
                    'name'      => _l('reset_password_url'),
                    'key'       => '{reset_password_url}',
                    'available' => [
                    ],
                    'templates' => [
                        'staff-forgot-password',
                        'regular-duration-deadline-notification',
                    ],
                ],
                [
                    'name'      => _l('staff_reminder_description'),
                    'key'       => '{staff_reminder_description}',
                    'available' => [

                    ],
                    'templates' => [
                        'reminder-email-staff',
                        'regular-duration-deadline-notification',
                    ],
                ],
                [
                    'name'      => _l('staff_reminder_date'),
                    'key'       => '{staff_reminder_date}',
                    'available' => [

                    ],
                    'templates' => [
                        'reminder-email-staff',
                        'regular-duration-deadline-notification',
                    ],
                ],
                [
                    'name'      => _l('staff_reminder_relation_name'),
                    'key'       => '{staff_reminder_relation_name}',
                    'available' => [

                    ],
                    'templates' => [
                        'reminder-email-staff',
                        'regular-duration-deadline-notification',
                    ],
                ],
                [
                    'name'      => _l('staff_reminder_relation_link'),
                    'key'       => '{staff_reminder_relation_link}',
                    'available' => [

                    ],
                    'templates' => [
                        'reminder-email-staff',
                        'regular-duration-deadline-notification',
                    ],
                ],
                [
                    'name'      => _l('two_factor_auth_code'),
                    'key'       => '{two_factor_auth_code}',
                    'available' => [
                    ],
                    'templates' => [
                        'two-factor-authentication',
                        'regular-duration-deadline-notification',
                    ],
                ],
                [
                    'name'      => _l('password'),
                    'key'       => '{password}',
                    'available' => [
                    ],
                    'templates' => [
                        'new-staff-created',
                        'regular-duration-deadline-notification',
                    ],
                ],
            ];
    }

    /**
    * Merge field for staff members
    * @param  mixed $staff_id staff id
    * @param  string $password password is used only when sending welcome email, 1 time
    * @return array
    */
    public function format($staff_id, $password = '')
    {
        $fields = [];

        $this->ci->db->where('staffid', $staff_id);
        $staff = $this->ci->db->get(db_prefix().'staff')->row();

        $fields['{password}']          = '';
        $fields['{staff_fullname}']   = '';
        $fields['{staff_firstname}']   = '';
        $fields['{staff_second_name}']   = '';
        $fields['{staff_third_name}']   = '';
        $fields['{staff_lastname}']   = '';
        // $fields['{staff_lastname}']    = '';
        $fields['{staff_email}']       = '';
        $fields['{staff_datecreated}'] = '';

        if (!$staff) {
            return $fields;
        }

        if ($password != '') {
            $fields['{password}'] = htmlentities($password);
        }

        if ($staff->two_factor_auth_code) {
            $fields['{two_factor_auth_code}'] = $staff->two_factor_auth_code;
        }

        $fields['{staff_fullname}']   = $staff->firstname . ' ' . $staff->second_name . ' ' . $staff->third_name . ' ' . $staff->lastname;
        $fields['{staff_firstname}']   = $staff->firstname;
        $fields['{staff_second_name}']   = $staff->second_name;
        $fields['{staff_third_name}']   = $staff->third_name;
        $fields['{staff_lastname}']   = $staff->lastname;
        // $fields['{staff_lastname}']    = $staff->lastname;
        $fields['{staff_email}']       = $staff->email;
        $fields['{staff_datecreated}'] = $staff->datecreated;


        $custom_fields = get_custom_fields('staff');
        foreach ($custom_fields as $field) {
            $fields['{' . $field['slug'] . '}'] = get_custom_field_value($staff_id, $field['id'], 'staff');
        }

        return hooks()->apply_filters('staff_merge_fields', $fields, [
        'id'    => $staff_id,
        'staff' => $staff,
     ]);
    }

    /**
     * Merge fields for staff reminders
     * @param  object $reminder reminder from database
     * @return array
     */
    public function reminder($reminder)
    {
        $reminder = (object) $reminder;

        $rel_data   = get_relation_data($reminder->rel_type, $reminder->rel_id);
        $rel_values = get_relation_values($rel_data, $reminder->rel_type);

        $fields['{staff_reminder_description}']   = $reminder->description;
        $fields['{staff_reminder_date}']          = _dt($reminder->date);
        $fields['{staff_reminder_relation_name}'] = $rel_values['name'];
        $fields['{staff_reminder_relation_link}'] = $rel_values['link'];

        return hooks()->apply_filters('staff_reminder_merge_fields', $fields, [
            'reminder' => $reminder,
        ]);
    }

    public function password($data, $type)
    {
        $fields['{reset_password_url}'] = '';
        $fields['{set_password_url}']   = '';

        if ($type == 'forgot') {
            $fields['{reset_password_url}'] = admin_url('authentication/reset_password/1/' . $data['userid'] . '/' . $data['new_pass_key']);
        }

        return $fields;
    }
}
