<?php

class Imported_services_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_imported_project_settings($project_id)
    {
        $this->db->where('oservice_id', $project_id);
        return $this->db->get(db_prefix() . 'iservice_settings')->result_array();
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
            $_new_data['case_status'] = 1;
            $_new_data['jud_num'] = 1;
            $_new_data['court_id'] = 1;
            $_new_data['representative'] = 1;
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
                        mkdir(FCPATH.'uploads/cases/'.$id, 0777);
                }
                foreach ($files as $key => $value) {
                    $file_url = base_url().'uploads/imported_services/'.$project_id.'/'.$value['file_name'];
                    $file_content = file_get_contents($file_url);
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
                if(!file_exists('uploads/cases/'.$id)){
                        mkdir(FCPATH.'uploads/cases/'.$id, 0777);
                }
                foreach ($files as $key => $value) {
                    $file_url = base_url().'uploads/imported_services/'.$project_id.'/'.$value['file_name'];
                    $file_content = file_get_contents($file_url);
                    $myFile = fopen(FCPATH.'uploads/cases/'.$id.'/'.$value['file_name'], 'w', true);

                    file_put_contents(FCPATH.'uploads/cases/'.$id.'/'.$value['file_name'], $file_content);
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