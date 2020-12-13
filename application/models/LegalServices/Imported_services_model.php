<?php

class Imported_services_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'my_imported_services', $data);
        if ($this->db->affected_rows() > 0) {
            $this->log_activity($id, 'imported updated');
            return true;
        }
        return false;
    }

    public function get_imported_project_settings($project_id)
    {
        $this->db->where('oservice_id', $project_id);
        return $this->db->get(db_prefix() . 'iservice_settings')->result_array();
    }

    public function get_project_members($id)
    {
        $this->db->select('email,staffid');
        $this->db->where('admin', 1);
        return $this->db->get(db_prefix() . 'staff')->result_array();
    }

    public function get_file($id, $project_id = false)
    {
        if (is_client_logged_in()) {
            $this->db->where('visible_to_customer', 1);
        }
        $this->db->where('id', $id);
        $file = $this->db->get(db_prefix() . 'iservice_files')->row();

        if ($file && $project_id) {
            if ($file->iservice_id != $project_id) {
                return false;
            }
        }

        return $file;
    }

    public function new_project_file_notification($file_id, $project_id)
    {
        $file = $this->get_file($file_id);

        $additional_data = $file->file_name;
        $this->log_activity($project_id, 'IService_activity_uploaded_file', $additional_data, $file->visible_to_customer);

        $members = $this->get_project_members($project_id);
        $notification_data = [
            'description' => 'not_project_file_uploaded',
            'link' => 'SImported/view/' . $project_id . '?group=project_files&file_id=' . $file_id,
        ];

        if (is_client_logged_in()) {
            $notification_data['fromclientid'] = get_contact_user_id();
        } else {
            $notification_data['fromuserid'] = get_staff_user_id();
        }

        $notifiedUsers = [];
        foreach ($members as $member) {
            if ($member['staffid'] == get_staff_user_id() && !is_client_logged_in()) {
                continue;
            }
            $notification_data['touserid'] = $member['staffid'];
            if (add_notification($notification_data)) {
                array_push($notifiedUsers, $member['staffid']);
            }
        }
        pusher_trigger_notification($notifiedUsers);

        // $this->send_project_email_template(
        //     1,
        //     $project_id,
        //     'project_file_to_staff',
        //     'project_file_to_customer',
        //     $file->visible_to_customer,
        //     [
        //         'staff' => ['discussion_id' => $file_id, 'discussion_type' => 'file', 'ServID' => 1],
        //         'customers' => ['customer_template' => true, 'discussion_id' => $file_id, 'discussion_type' => 'file', 'ServID' => 1],
        //     ]
        // );
    }

    public function remove_file($id, $logActivity = true)
    {
        hooks()->do_action('before_remove_project_file', $id);

        $this->db->where('id', $id);
        $file = $this->db->get(db_prefix() . 'iservice_files')->row();
        if ($file) {
            if (empty($file->external)) {
                $path     = get_upload_path_by_type('iservice') . $file->iservice_id . '/';
                $fullPath = $path . $file->file_name;
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                    $fname     = pathinfo($fullPath, PATHINFO_FILENAME);
                    $fext      = pathinfo($fullPath, PATHINFO_EXTENSION);
                    $thumbPath = $path . $fname . '_thumb.' . $fext;

                    if (file_exists($thumbPath)) {
                        unlink($thumbPath);
                    }
                }
            }

            $this->db->where('id', $id);
            $this->db->delete(db_prefix() . 'iservice_files');
            if ($logActivity) {
                $this->log_activity($file->iservice_id, 'IService_activity_project_file_removed', $file->file_name, $file->visible_to_customer);
            }

            // Delete discussion comments
            //$this->_delete_discussion_comments($id, 'file');

            if (is_dir(get_upload_path_by_type('iservice') . $file->project_id)) {
                // Check if no attachments left, so we can delete the folder also
                $other_attachments = list_files(get_upload_path_by_type('iservice') . $file->project_id);
                if (count($other_attachments) == 0) {
                    delete_dir(get_upload_path_by_type('iservice') . $file->project_id);
                }
            }

            return true;
        }

        return false;
    }

    public function get($id = '', $where = [])
    {
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where(array('my_imported_services.id' => $id, 'my_imported_services.deleted' => 0));
            $this->db->select('my_imported_services.*,countries.short_name_ar as country_name, cat.name as cat, subcat.name as subcat');
            $this->db->join(db_prefix() . 'countries', db_prefix() . 'countries.country_id=' . db_prefix() . 'my_imported_services.country', 'left');
            $this->db->join(db_prefix() . 'my_categories as cat',  'cat.id=' . db_prefix() . 'my_imported_services.cat_id', 'left');
            $this->db->join(db_prefix() . 'my_categories as subcat',  'subcat.id=' . db_prefix() . 'my_imported_services.subcat_id', 'left');
            $project = $this->db->get(db_prefix() . 'my_imported_services')->row();
            if ($project) {
                $project->shared_vault_entries = $this->clients_model->get_vault_entries($project->clientid, ['share_in_projects' => 1]);
                $settings = $this->get_imported_project_settings($id);

                // SYNC NEW TABS
                $tabs = get_iservice_tabs_admin();
                $tabs_flatten = [];
                $settings_available_features = [];

                $available_features_index = false;
                foreach ($settings as $key => $setting) {
                    if ($setting['name'] == 'available_features') {
                        $available_features_index = $key;
                        $available_features = unserialize($setting['value']);
                        if (is_array($available_features)) {
                            foreach ($available_features as $name => $avf) {
                                $settings_available_features[] = $name;
                            }
                        }
                    }
                }
                foreach ($tabs as $tab) {
                    if (isset($tab['collapse'])) {
                        foreach ($tab['children'] as $d) {
                            $tabs_flatten[] = $d['slug'];
                        }
                    } else {
                        $tabs_flatten[] = $tab['slug'];
                    }
                }
                if (count($settings_available_features) != $tabs_flatten) {
                    foreach ($tabs_flatten as $tab) {
                        if (!in_array($tab, $settings_available_features)) {
                            if ($available_features_index) {
                                $current_available_features_settings = $settings[$available_features_index];
                                $tmp = unserialize($current_available_features_settings['value']);
                                $tmp[$tab] = 1;
                                $this->db->where('id', $current_available_features_settings['id']);
                                $this->db->update(db_prefix() . 'oservice_settings', ['value' => serialize($tmp)]);
                            }
                        }
                    }
                }

                $project->settings = new StdClass();

                foreach ($settings as $setting) {
                    $project->settings->{$setting['name']} = $setting['value'];
                }

                $project->client_data = new StdClass();
                $project->client_data = $this->clients_model->get($project->clientid);

                $project = hooks()->apply_filters('project_get', $project);
                $GLOBALS['project'] = $project;
                return $project;
            }

            return null;
        }
        $this->db->where(array('my_imported_services.deleted' => 0));
        $this->db->select('*,' . get_sql_select_client_company());
        $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid=' . db_prefix() . 'my_imported_services.clientid');
        $this->db->order_by('my_imported_services.id', 'desc');
        return $this->db->get(db_prefix() . 'my_imported_services')->result_array();
    }

    public function add($client_id, $data){
        $slug = 'imported';
        $ServiceName = 'imported_services';
        $new_data = [
            'clientid' => $client_id,
            'name' => $data['name'],
            'cat_id' => 0,
            'subcat_id' => 0,
            'service_session_link' => 1,
            'billing_type' => 0,
            'status' => 1,
            'project_rate_per_hour' => 0,
            'description' => $data['description']
        ];
        $this->db->insert(db_prefix() . 'my_imported_services', $new_data);
        $id = $this->db->insert_id();
        if($id)
            return $id;
        return false;
    }
    public function copy($ServID,$project_id, $data)
    {
        $slug      = $this->legal->get_service_by_id($ServID)->row()->slug;
        $ServiceName = $this->legal->get_service_by_id($ServID)->row()->name;
        $project   = $this->get($project_id);
        $settings  = $this->get_imported_project_settings($project_id);
        $_new_data = [];
        if($ServID == 1) {
            $fields    = $this->db->list_fields(db_prefix() . 'my_cases');
            foreach ($fields as $field) {
                if (isset($project->$field)) {
                    $_new_data[$field] = $project->$field;
                }
            }

            unset($_new_data['id']);
            $_new_data['clientid'] = $data['clientid_copy_project'];
            unset($_new_data['clientid_copy_project']);
            $_new_data['country'] = 0;

            $this->db->where('is_default', 1);
            $case_status = $this->db->get('tblmy_casestatus')->row();
            $_new_data['case_status'] = $case_status->id;

            $this->db->where('is_default', 1);
            $court = $this->db->get('tblmy_courts')->row();
            $_new_data['court_id'] = $court->c_id;

            $this->db->where('c_id', $court->c_id);
            $jud = $this->db->get('tblmy_judicialdept')->row();
            $_new_data['jud_num'] = $jud->j_id;

            $this->db->where('is_default', 1);
            $representative = $this->db->get('tblmy_customer_representative')->row();
            $_new_data['representative'] = $representative->id;

            $_new_data['case_result'] = "متداولة";
            $_new_data['file_number_case'] = 0;
            $_new_data['file_number_court'] = 0;



            $_new_data['start_date'] = to_sql_date($data['start_date']);

            if ($_new_data['start_date'] > date('Y-m-d')) {
                $_new_data['status'] = 1;
            } else {
                $_new_data['status'] = 2;
            }
            if ($data['deadline']) {
                $_new_data['deadline'] = to_sql_date($data['deadline']);
            } else {
                $_new_data['deadline'] = null;
            }

            $_new_data['project_created'] = date('Y-m-d H:i:s');
            $_new_data['addedfrom']       = get_staff_user_id();

            $_new_data['date_finished'] = null;

            $this->db->insert(db_prefix() . 'my_cases', $_new_data);
            $id = $this->db->insert_id();
            if ($id) {
                $files = $this->other->get_imported_files($project_id);
                if(!file_exists('uploads/cases/'.$id)){
                        mkdir(FCPATH.'uploads/cases/'.$id, 0755);
                }
                foreach ($files as $key => $value) {
                    $file_url = base_url().'uploads/imported_services/'.$project_id.'/'.$value['file_name'];
                    $file_content = curl_get_contents(str_replace(' ', '%20', $file_url));
                    $myFile = fopen(FCPATH.'uploads/cases/'.$id.'/'.$value['file_name'], 'w', true);

                    file_put_contents(FCPATH.'uploads/cases/'.$id.'/'.$value['file_name'], $file_content);
                    $file_data = [
                        'file_name' => $value['file_name'],
                        'subject' => $value['subject'],
                        'description' => isset($value['description']) ? $value['description'] : '',
                        'filetype' => $value['filetype'],
                        'dateadded' => $value['dateadded'],
                        'last_activity' => isset($value['last_activity']) ? $value['last_activity'] : '',
                        'project_id' => $id,
                        'visible_to_customer' => 0,   //$value['visible_to_customer'],
                        'staffid' => get_staff_user_id(),    //$value['staffid'],
                        'contact_id' => 0,   //$value['contact_id'],
                        'external' => isset($value['external']) ? $value['external'] : '',
                        'external_link' => isset($value['external_link']) ? $value['external_link'] : '',
                        'file_name' => isset($value['file_name']) ? $value['file_name'] : '',
                    ];
                    $this->db->insert('tblcase_files', $file_data);

                }
                $tags = get_tags_in($project_id, $slug);
                handle_tags_save($tags, $id, $slug);

                foreach ($settings as $setting) {
                    $this->db->insert(db_prefix() . 'case_settings', [
                        'case_id'    => $id,
                        'name'       => $setting['name'],
                        'value'      => $setting['value'],
                    ]);
                }
                $added_tasks = [];
                

                $this->log_activity($id, 'LService_activity_created');
                log_activity('Case Copied [ID: ' . $project_id . ', NewID: ' . $id . ']');

                return $id;
            }
        }else {
            $fields    = $this->db->list_fields(db_prefix() . 'my_other_services');
            foreach ($fields as $field) {
                if (isset($project->$field)) {
                    $_new_data[$field] = $project->$field;
                }
            }


            unset($_new_data['id']);
            $_new_data['clientid'] = $data['clientid_copy_project'];
            unset($_new_data['clientid_copy_project']);
            $_new_data['country'] = 0;
            $_new_data['service_id'] = $ServID;
            $_new_data['code'] = $slug;
            // $_new_data['jud_num'] = 1;
            // $_new_data['court_id'] = 1;
            // $_new_data['representative'] = 1;
            // $_new_data['case_result'] = "متداولة";
            // $_new_data['file_number_case'] = 0;
            // $_new_data['file_number_court'] = 0;


            $_new_data['start_date'] = to_sql_date($data['start_date']);

            if ($_new_data['start_date'] > date('Y-m-d')) {
                $_new_data['status'] = 1;
            } else {
                $_new_data['status'] = 2;
            }
            if ($data['deadline']) {
                $_new_data['deadline'] = to_sql_date($data['deadline']);
            } else {
                $_new_data['deadline'] = null;
            }

            $_new_data['project_created'] = date('Y-m-d H:i:s');
            $_new_data['addedfrom']       = get_staff_user_id();

            $_new_data['date_finished'] = null;


            $this->db->insert(db_prefix() . 'my_other_services', $_new_data);
            $id = $this->db->insert_id();

            if ($id) {
                $files = $this->other->get_imported_files($project_id);
                if(!file_exists('uploads/oservices/'.$id)){
                        mkdir(FCPATH.'uploads/oservices/'.$id, 0755);
                }
                foreach ($files as $key => $value) {
                    $file_url = base_url().'uploads/imported_services/'.$project_id.'/'.$value['file_name'];
                    $file_content = curl_get_contents(str_replace(' ', '%20', $file_url));
                    $myFile = fopen(FCPATH.'uploads/oservices/'.$id.'/'.$value['file_name'], 'w', true);

                    file_put_contents(FCPATH.'uploads/oservices/'.$id.'/'.$value['file_name'], $file_content);
                    $file_data = [
                        'file_name' => $value['file_name'],
                        'subject' => $value['subject'],
                        'description' => isset($value['description']) ? $value['description'] : '',
                        'filetype' => $value['filetype'],
                        'dateadded' => $value['dateadded'],
                        'last_activity' => isset($value['last_activity']) ? $value['last_activity'] : '',
                        'oservice_id' => $id,
                        'visible_to_customer' => 0,   //$value['visible_to_customer'],
                        'staffid' => get_staff_user_id(),    //$value['staffid'],
                        'contact_id' => 0,   //$value['contact_id'],
                        'external' => isset($value['external']) ? $value['external'] : '',
                        'external_link' => isset($value['external_link']) ? $value['external_link'] : '',
                        'file_name' => isset($value['file_name']) ? $value['file_name'] : '',
                    ];
                    $this->db->insert('tbloservice_files', $file_data);

                }
                $tags = get_tags_in($project_id, $slug);
                handle_tags_save($tags, $id, $slug);

                foreach ($settings as $setting) {
                    $this->db->insert(db_prefix() . 'oservice_settings', [
                        'oservice_id'    => $id,
                        'name'       => $setting['name'],
                        'value'      => $setting['value'],
                    ]);
                }
                $added_tasks = [];
                

                $this->log_activity($id, 'LService_activity_created');
                log_activity($ServiceName.' Copied [ID: ' . $project_id . ', NewID: ' . $id . ']');

                return $id;
            }
        }

        return false;
    }

    public function get_project_statuses()
    {
        $statuses = hooks()->apply_filters('before_get_project_statuses', [
            [
                'id' => 1,
                'color' => '#989898',
                'name' => _l('project_status_3'),
                'order' => 1,
                'filter_default' => true,
            ],
            [
                'id' => 2,
                'color' => '#03a9f4',
                'name' => _l('approved'),
                'order' => 2,
                'filter_default' => true,
            ],
            [
                'id' => 3,
                'color' => '#ff6f00',
                'name' => _l('rejected'),
                'order' => 3,
                'filter_default' => true,
            ],
        ]);

        usort($statuses, function ($a, $b) {
            return $a['order'] - $b['order'];
        });

        return $statuses;
    }
    public function log_activity($project_id, $description_key, $additional_data = '', $visible_to_customer = 1)
    {
        if (!DEFINED('CRON')) {
            if (is_client_logged_in()) {
                $data['contact_id'] = get_contact_user_id();
                $data['staff_id']   = 0;
                $data['fullname']   = get_contact_full_name(get_contact_user_id());
            } elseif (is_staff_logged_in()) {
                $data['contact_id'] = 0;
                $data['staff_id']   = get_staff_user_id();
                $data['fullname']   = get_staff_full_name(get_staff_user_id());
            }
        } else {
            $data['contact_id'] = 0;
            $data['staff_id']   = 0;
            $data['fullname']   = '[CRON]';
        }
        $data['description_key']     = $description_key;
        $data['additional_data']     = $additional_data;
        $data['visible_to_customer'] = $visible_to_customer;
        $data['project_id']          = $project_id;
        $data['dateadded']           = date('Y-m-d H:i:s');

        $data = hooks()->apply_filters('before_log_project_activity', $data);

        $this->db->insert(db_prefix() . 'case_activity', $data);
    }
}