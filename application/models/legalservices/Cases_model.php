<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cases_model extends App_Model
{
    private $project_settings;

    public function __construct()
    {
        parent::__construct();

       $project_settings = [
            'available_features',
            'view_procurations',
            'view_finance_overview',
            'upload_files',
            'open_discussions',
            'view_milestones',
            'view_gantt',
            'view_timesheets',
            'view_activity_log',
            'view_team_members',
            'hide_tasks_on_main_tasks_table',
            'view_tasks',
            'create_tasks',
            'edit_tasks',
            'comment_on_tasks',
            'view_task_comments',
            'view_task_attachments',
            'view_task_checklist_items',
            'upload_on_tasks',
            'view_task_total_logged_time',
            'view_session_logs',
            'create_sessions',
            'edit_sessions',
            'comment_on_sessions',
            'view_session_comments',
            'view_session_attachments',
            'view_session_checklist_items',
            'upload_on_sessions',
            'view_session_total_logged_time',
        ];

        $this->project_settings = hooks()->apply_filters('project_settings', $project_settings);
        $this->load->model('legalservices/LegalServicesModel', 'legal');
        $this->load->model('legalservices/Case_movement_model', 'movement');
        $this->load->model('legalservices/Legal_procedures_model' , 'procedures');
    }

    public function get($id = '', $where = [])
    {
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where(array('my_cases.id' => $id, 'my_cases.deleted' => 0));
            $this->db->select('my_cases.*,countries.short_name_ar as country_name, cat.name as cat, subcat.name as subcat,my_courts.court_name,my_judicialdept.Jud_number,my_customer_representative.representative as Representative,my_casestatus.name as StatusCase');
            //$this->db->select('*');
            $this->db->join(db_prefix() . 'countries', db_prefix() . 'countries.country_id=' . db_prefix() . 'my_cases.country', 'left');
            $this->db->join(db_prefix() . 'my_categories as cat',  'cat.id=' . db_prefix() . 'my_cases.cat_id', 'left');
            $this->db->join(db_prefix() . 'my_categories as subcat',  'subcat.id=' . db_prefix() . 'my_cases.subcat_id', 'left');
            $this->db->join(db_prefix() . 'my_courts',  'my_courts.c_id=' . db_prefix() . 'my_cases.court_id', 'left');
            $this->db->join(db_prefix() . 'my_judicialdept',  'my_judicialdept.j_id=' . db_prefix() . 'my_cases.jud_num', 'left');
            $this->db->join(db_prefix() . 'my_customer_representative',  'my_customer_representative.id=' . db_prefix() . 'my_cases.representative', 'left');
            $this->db->join(db_prefix() . 'my_casestatus', db_prefix() . 'my_casestatus.id=' . db_prefix() . 'my_cases.case_status', 'left');
            $project = $this->db->get(db_prefix() . 'my_cases')->row();
            if ($project) {
                $project->shared_vault_entries = $this->clients_model->get_vault_entries($project->clientid, ['share_in_projects' => 1]);
                $settings                      = $this->get_case_settings($id);
                // SYNC NEW TABS
                $tabs = get_case_tabs_admin();
                $tabs_flatten = [];
                $settings_available_features = [];

                $available_features_index = false;
                foreach ($settings as $key => $setting) {
                    if ($setting['name'] == 'available_features') {
                        $available_features_index = $key;
                        @$available_features = @unserialize($setting['value']);
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
                                $tmp = @unserialize($current_available_features_settings['value']);
                                $tmp[$tab] = 1;
                                $this->db->where('id', $current_available_features_settings['id']);
                                $this->db->update(db_prefix() . 'case_settings', ['value' => serialize($tmp)]);
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

                $project->opponent_data = new StdClass();
                $project->opponent_data = $this->clients_model->get($project->opponent_id);

                $project = hooks()->apply_filters('case_get', $project);
                $GLOBALS['case'] = $project;

                return $project;
            }

            return null;
        }
        $this->db->where('my_cases.deleted', 0);
        $this->db->select('*,' . get_sql_select_client_company());
        $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid=' . db_prefix() . 'my_cases.clientid');
        $this->db->order_by('my_cases.id', 'desc');
        return $this->db->get(db_prefix() . 'my_cases')->result_array();
    }

    public function GetTopNumbering()
    {
        $this->db->select('numbering');
        $this->db->from('my_cases');
        $this->db->order_by("id desc");
        return $this->db->get()->row();
    }

    public function GetClientsCases($id)
    {
        $this->db->select('clients.company');
        $this->db->from('clients');
        $this->db->join('my_cases', 'clients.userid = my_cases.clientid' ,'right');
        $this->db->where('my_cases.id', $id);
        return $this->db->get()->row();
    }

    public function GetMembersCases($id)
    {
        $this->db->select('staff.staffid, staff.firstname, staff.lastname, staff.profile_image');
        $this->db->from('my_members_cases');
        $this->db->join('my_cases', 'my_cases.id = my_members_cases.project_id');
        $this->db->join('staff', 'staff.staffid = my_members_cases.staff_id');
        $this->db->where('my_cases.id', $id);
        return $this->db->get()->result();
    }

    public function GetJudgesCases($id)
    {
        $this->db->select('my_judges.name');
        $this->db->from('my_cases_judges');
        $this->db->join('my_judges', 'my_judges.id = my_cases_judges.judge_id');
        $this->db->where('my_cases_judges.case_id', $id);
        return $this->db->get()->result();
    }

    public function add($ServID,$data)
    {
        $slug = $this->legal->get_service_by_id($ServID)->row()->slug;

        if (isset($data['court_id']) && $data['court_id'] == '') {
            $data['court_id'] = get_default_value_id_by_table_name('my_courts', 'c_id');
        }

        if (isset($data['jud_num']) && $data['jud_num'] == '') {
            $data['jud_num'] = get_default_value_id_by_table_name('my_judicialdept', 'j_id');
        }

        if (isset($data['representative']) && $data['representative'] == '') {
            $data['representative'] = get_default_value_id_by_table_name('my_customer_representative', 'id');
        }

        if (isset($data['case_status']) && $data['case_status'] == '') {
            $data['case_status'] = get_default_value_id_by_table_name('my_casestatus', 'id');
        }

        if (isset($data['notify_project_members_status_change'])) {
            unset($data['notify_project_members_status_change']);
        }

        $send_created_email = false;
        if (isset($data['send_created_email'])) {
            unset($data['send_created_email']);
            $send_created_email = true;
        }

        $send_project_marked_as_finished_email_to_contacts = false;
        if (isset($data['project_marked_as_finished_email_to_contacts'])) {
            unset($data['project_marked_as_finished_email_to_contacts']);
            $send_project_marked_as_finished_email_to_contacts = true;
        }

        if (isset($data['settings'])) {
            $case_settings = $data['settings'];
            unset($data['settings']);
        }
        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            unset($data['custom_fields']);
        }
        if (isset($data['progress_from_tasks'])) {
            $data['progress_from_tasks'] = 1;
        } else {
            $data['progress_from_tasks'] = 0;
        }

        if (isset($data['contact_notification'])) {
            if ($data['contact_notification'] == 2) {
                $data['notify_contacts'] = serialize($data['notify_contacts']);
            } else {
                $data['notify_contacts'] = serialize([]);
            }
        }

        $data['project_cost']    = !empty($data['project_cost']) ? $data['project_cost'] : null;
        $data['estimated_hours'] = !empty($data['estimated_hours']) ? $data['estimated_hours'] : null;

        $data['start_date'] = to_sql_date($data['start_date']);

        if (!empty($data['deadline'])) {
            $data['deadline'] = to_sql_date($data['deadline']);
        } else {
            unset($data['deadline']);
        }

        $data['project_created'] = date('Y-m-d');
        if (isset($data['project_members'])) {
            $project_members = $data['project_members'];
            unset($data['project_members']);
        }

        //judges
        if (isset($data['judges'])) {
            $judges = $data['judges'];
            unset($data['judges']);
        }

        if ($data['billing_type'] == 1) {
            $data['project_rate_per_hour'] = 0;
        } elseif ($data['billing_type'] == 2) {
            $data['project_cost'] = 0;
        } else {
            $data['project_rate_per_hour'] = 0;
            $data['project_cost']          = 0;
        }

        $data['addedfrom'] = get_staff_user_id();

        $items_to_convert = false;
        if (isset($data['items'])) {
            $items_to_convert = $data['items'];
            $estimate_id = $data['estimate_id'];
            $items_assignees = $data['items_assignee'];
            unset($data['items'], $data['estimate_id'], $data['items_assignee']);
        }


        $court_id          = $data['court_id'];

        $data = hooks()->apply_filters('before_add_project', $data);

        $tags = '';
        if (isset($data['tags'])) {
            $tags = $data['tags'];
            unset($data['tags']);
        }

        $this->db->insert(db_prefix() . 'my_cases', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {

            //Make tags from name and description
            $name_array        = convert_to_tags($data['name']);
            $description_array = convert_to_tags($data['description']);
            $services_tags     = array_merge($name_array, $description_array);
            save_edit_services_tags($services_tags, $insert_id, $slug);

            //Add Case Movement
            $movement_data = $data;
            unset($movement_data['contact_notification']);
            $this->movement->add($ServID, $insert_id, $movement_data);

            handle_tags_save($tags, $insert_id, $slug);

            if (isset($custom_fields)) {
                handle_custom_fields_post($insert_id, $custom_fields);
            }

            if (isset($project_members)) {
                $_pm['project_members'] = $project_members;
                $this->add_edit_members($_pm, $ServID, $insert_id);
                $this->movement->add_edit_members_movement($_pm, $insert_id);
            }

            if (isset($judges)) {
                $cases_judges['judges'] = $judges;
                $this->add_edit_judges($cases_judges, $insert_id);
                $this->movement->add_edit_judges_movement($cases_judges, $insert_id);
            }

            $original_settings = $this->get_settings();
            if (isset($case_settings)) {
                $_settings = [];
                $_values   = [];
                foreach ($case_settings as $name => $val) {
                    array_push($_settings, $name);
                    $_values[$name] = $val;
                }
                foreach ($original_settings as $setting) {
                    if ($setting != 'available_features') {
                        if (in_array($setting, $_settings)) {
                            $value_setting = 1;
                        } else {
                            $value_setting = 0;
                        }
                    } else {
                        $tabs         = get_case_tabs_admin();
                        $tab_settings = [];
                        foreach ($_values[$setting] as $tab) {
                            $tab_settings[$tab] = 1;
                        }
                        foreach ($tabs as $tab) {
                            if (!isset($tab['collapse'])) {
                                if (!in_array($tab['slug'], $_values[$setting])) {
                                    $tab_settings[$tab['slug']] = 0;
                                }
                            } else {
                                foreach ($tab['children'] as $tab_dropdown) {
                                    if (!in_array($tab_dropdown['slug'], $_values[$setting])) {
                                        $tab_settings[$tab_dropdown['slug']] = 0;
                                    }
                                }
                            }
                        }
                        $value_setting = serialize($tab_settings);
                    }
                    $this->db->insert(db_prefix() . 'case_settings', [
                        'case_id'    => $insert_id,
                        'name'       => $setting,
                        'value'      => $value_setting,
                    ]);
                }
            } else {
                foreach ($original_settings as $setting) {
                    $value_setting = 0;
                    $this->db->insert(db_prefix() . 'case_settings', [
                        'case_id'    => $insert_id,
                        'name'       => $setting,
                        'value'      => $value_setting,
                    ]);
                }
            }

            if ($items_to_convert && is_numeric($estimate_id)) {
                $this->convert_estimate_items_to_tasks($insert_id, $items_to_convert, $items_assignees, $data, $case_settings);

                $this->db->where('id', $estimate_id);
                //$this->db->set('project_id', $insert_id);
                $this->db->set('rel_sid', $insert_id);
                $this->db->set('rel_stype', $slug);
                $this->db->update(db_prefix() . 'estimates');
            }

            $this->log_activity($insert_id, 'LService_activity_created');

            if ($send_created_email == true) {
                $this->send_project_customer_email($insert_id, 'project_created_to_customer', $ServID);//Done Send
            }

            if ($send_project_marked_as_finished_email_to_contacts == true) {
                $this->send_project_customer_email($insert_id, 'project_marked_as_finished_to_customer', $ServID);//Done Send
            }

            hooks()->do_action('after_add_project', $insert_id);

            log_activity ('New Case Added [CaseID: ' . $insert_id . ']');

            return $insert_id;
        }

        return false;
    }

    public function update($ServID,$id,$data)
    {
        $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
        if (isset($data['court_id']) && $data['court_id'] == '') {
            $data['court_id'] = get_default_value_id_by_table_name('my_courts', 'c_id');
        }

        if (isset($data['jud_num']) && $data['jud_num'] == '') {
            $data['jud_num'] = get_default_value_id_by_table_name('my_judicialdept', 'j_id');
        }

        if (!isset($data['childsubcat_id'])) $data['childsubcat_id'] = '0';
        if (!isset($data['subcat_id'])) $data['subcat_id'] = '0';

        if (isset($data['representative']) && $data['representative'] == '') {
            $data['representative'] = get_default_value_id_by_table_name('my_customer_representative', 'id');
        }

        if (isset($data['case_status']) && $data['case_status'] == '') {
            $data['case_status'] = get_default_value_id_by_table_name('my_casestatus', 'id');
        }
        //Make tags from name and description
        $name_array        = convert_to_tags($data['name']);
        $description_array = convert_to_tags($data['description']);
        $services_tags     = array_merge($name_array, $description_array);
        save_edit_services_tags($services_tags, $id, $slug);

        $this->db->select('status');
        $this->db->where('id', $id);
        $old_status = $this->db->get(db_prefix() . 'my_cases')->row()->status;

        $send_created_email = false;
        if (isset($data['send_created_email'])) {
            unset($data['send_created_email']);
            $send_created_email = true;
        }

        $send_project_marked_as_finished_email_to_contacts = false;
        if (isset($data['project_marked_as_finished_email_to_contacts'])) {
            unset($data['project_marked_as_finished_email_to_contacts']);
            $send_project_marked_as_finished_email_to_contacts = true;
        }

        $original_project = $this->get($id);

        if (isset($data['notify_project_members_status_change'])) {
            $notify_project_members_status_change = true;
            unset($data['notify_project_members_status_change']);
        }
        $affectedRows = 0;


        if (!isset($data['settings'])) {
            $this->db->where('case_id', $id);
            $this->db->update(db_prefix() . 'case_settings', [
                'value' => 0,
            ]);
            if ($this->db->affected_rows() > 0) {
                $affectedRows++;
            }
        } else {
            $_settings = [];
            $_values   = [];

            foreach ($data['settings'] as $name => $val) {
                array_push($_settings, $name);
                $_values[$name] = $val;
            }

            unset($data['settings']);
            $original_settings = $this->get_case_settings($id);

            foreach ($original_settings as $setting) {

                if ($setting['name'] != 'available_features') {
                    if (in_array($setting['name'], $_settings)) {
                        $value_setting = 1;
                    } else {
                        $value_setting = 0;
                    }
                } else {
                    $tabs         = get_case_tabs_admin();
                    $tab_settings = [];
                    foreach ($_values[$setting['name']] as $tab) {
                        $tab_settings[$tab] = 1;
                    }
                    foreach ($tabs as $tab) {
                        if (!isset($tab['collapse'])) {
                            if (!in_array($tab['slug'], $_values[$setting['name']])) {
                                $tab_settings[$tab['slug']] = 0;
                            }
                        } else {
                            foreach ($tab['children'] as $tab_dropdown) {
                                if (!in_array($tab_dropdown['slug'], $_values[$setting['name']])) {
                                    $tab_settings[$tab_dropdown['slug']] = 0;
                                }
                            }
                        }
                    }
                    $value_setting = serialize($tab_settings);
                }

                $this->db->where('case_id', $id);
                $this->db->where('name', $setting['name']);
                $this->db->update(db_prefix() . 'case_settings', [
                    'value' => $value_setting,
                ]);

                if ($this->db->affected_rows() > 0) {
                    $affectedRows++;
                }
            }
        }

        $data['project_cost']    = !empty($data['project_cost']) ? $data['project_cost'] : null;
        $data['estimated_hours'] = !empty($data['estimated_hours']) ? $data['estimated_hours'] : null;


        if ($old_status == 4 && $data['status'] != 4) {
            $data['date_finished'] = null;
        } elseif (isset($data['date_finished'])) {
            $data['date_finished'] = to_sql_date($data['date_finished'], true);
        }

        if (isset($data['progress_from_tasks'])) {
            $data['progress_from_tasks'] = 1;
        } else {
            $data['progress_from_tasks'] = 0;
        }

        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            if (handle_custom_fields_post($id, $custom_fields)) {
                $affectedRows++;
            }
            unset($data['custom_fields']);
        }

        if (!empty($data['deadline'])) {
            $data['deadline'] = to_sql_date($data['deadline']);
        } else {
            $data['deadline'] = null;
        }

        $data['start_date'] = to_sql_date($data['start_date']);
        if ($data['billing_type'] == 1) {
            $data['project_rate_per_hour'] = 0;
        } elseif ($data['billing_type'] == 2) {
            $data['project_cost'] = 0;
        } else {
            $data['project_rate_per_hour'] = 0;
            $data['project_cost']          = 0;
        }
        if (isset($data['project_members'])) {
            $project_members = $data['project_members'];
            unset($data['project_members']);
        }
        $_pm = [];
        if (isset($project_members)) {
            $_pm['project_members'] = $project_members;
        }
        if ($this->add_edit_members($_pm,$ServID, $id)) {
            $affectedRows++;
        }
        //judges
        if (isset($data['judges'])) {
            $judges = $data['judges'];
            unset($data['judges']);
        }
        $cases_judges = [];
        if (isset($judges)) {
            $cases_judges['judges'] = $judges;
        }
        if ($this->add_edit_judges($cases_judges, $id)) {
            $affectedRows++;
        }
        if (isset($data['mark_all_tasks_as_completed'])) {
            $mark_all_tasks_as_completed = true;
            unset($data['mark_all_tasks_as_completed']);
        }

        if (isset($data['tags'])) {
            if (handle_tags_save($data['tags'], $id, $slug)) {
                $affectedRows++;
            }
            unset($data['tags']);
        }

        if (isset($data['cancel_recurring_tasks'])) {
            unset($data['cancel_recurring_tasks']);
            $this->cancel_recurring_tasks($id, $slug);
        }

        if (isset($data['contact_notification'])) {
            if ($data['contact_notification'] == 2) {
                $data['notify_contacts'] = serialize($data['notify_contacts']);
            } else {
                $data['notify_contacts'] = serialize([]);
            }
        }

        $data = hooks()->apply_filters('before_update_project', $data, $id);

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'my_cases', $data);

        if ($this->db->affected_rows() > 0) {
            if (isset($mark_all_tasks_as_completed)) {
                $this->_mark_all_project_tasks_as_completed($id, $slug);
            }
            $affectedRows++;
        }

        if ($send_created_email == true) {
            if ($this->send_project_customer_email($id, 'project_created_to_customer', $ServID)) {//Done Send
                $affectedRows++;
            }
        }

        if ($send_project_marked_as_finished_email_to_contacts == true) {
            if ($this->send_project_customer_email($id, 'project_marked_as_finished_to_customer', $ServID)) {//Done Send
                $affectedRows++;
            }
        }
        if ($affectedRows > 0) {
            $this->log_activity($id, 'LService_activity_updated');
            log_activity('Case Updated [CaseID: ' . $id . ']');

            if ($original_project->status != $data['status']) {
                hooks()->do_action('project_status_changed', [
                    'status'     => $data['status'],
                    'project_id' => $id,
                ]);
                // Give space this log to be on top
                sleep(1);
                if ($data['status'] == 4) {
                    $this->log_activity($id, 'LService_marked_as_finished');
                    $this->db->where('id', $id);
                    $this->db->update(db_prefix() . 'my_cases', ['date_finished' => date('Y-m-d H:i:s')]);
                } else {
                    $this->log_activity($id, 'LService_status_updated', '<b><lang>project_status_' . $data['status'] . '</lang></b>');
                }

                if (isset($notify_project_members_status_change)) {
                    $this->_notify_project_members_status_change($ServID, $id, $original_project->status, $data['status']);
                }
            }
            hooks()->do_action('after_update_project', $id);

            return true;
        }

        return false;

    }

    public function delete($ServID,$id)
    {
        $slug = $this->legal->get_service_by_id($ServID)->row()->slug;

        $this->db->where(array('id' => $id, 'deleted' => 1));
        $this->db->delete(db_prefix() . 'my_cases');

        if ($this->db->affected_rows() > 0) {

            $this->db->where([db_prefix() . 'my_link_services.service_id' => $ServID, 'rel_id' => $id]);
            $this->db->delete(db_prefix() . 'my_link_services');

            $this->db->where([db_prefix() . 'my_link_services.to_service_id' => $ServID, 'to_rel_id' => $id]);
            $this->db->delete(db_prefix() . 'my_link_services');

            $this->db->where('project_id', $id);
            $this->db->delete(db_prefix() . 'my_members_cases');

            $this->db->where('case_id', $id);
            $this->db->delete(db_prefix() . 'case_movement');

            $this->db->where('case_mov_id', $id);
            $this->db->delete(db_prefix() . 'my_cases_movement_judges');

            $this->db->where('case_mov_id', $id);
            $this->db->delete(db_prefix() . 'my_members_movement_cases');

            $this->db->where('case_id', $id);
            $this->db->delete(db_prefix() . 'my_cases_judges');

            $this->db->where('project_id', $id);
            $this->db->delete(db_prefix() . 'case_notes');

            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', $slug);
            $this->db->delete(db_prefix() . 'written_reports');

            $this->db->where('rel_sid', $id);
            $this->db->where('rel_stype', $slug);
            $this->db->delete(db_prefix() . 'milestones');

            $this->db->where('rel_sid', $id);
            $this->db->where('rel_stype', $slug);
            $this->db->delete(db_prefix() . 'contracts');

            // Delete the custom field values
            $this->db->where('relid', $id);
            $this->db->where('fieldto', $slug);
            $this->db->delete('customfieldsvalues');

            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', $slug);
            $this->db->delete(db_prefix() . 'taggables');

            $this->db->where('project_id', $id);
            $discussions = $this->db->get(db_prefix() . 'casediscussions')->result_array();
            foreach ($discussions as $discussion) {
                $discussion_comments = $this->get_discussion_comments($discussion['id'], 'regular');
                foreach ($discussion_comments as $comment) {
                    $this->delete_discussion_comment_attachment($comment['file_name'], $discussion['id']);
                }
                $this->db->where('discussion_id', $discussion['id']);
                $this->db->delete(db_prefix() . 'casediscussioncomments');
            }
            $this->db->where('project_id', $id);
            $this->db->delete(db_prefix() . 'casediscussions');

            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', $slug);
            $phases = $this->db->get(db_prefix() . 'my_phase_data')->result_array();
            foreach ($phases as $phase) {
                // Delete the phases customfieldsvalues
                $this->db->where('relid', $phase['id']);
                $this->db->where('fieldto', 'legal_phase_'.$phase['id'].'_'.$phase['rel_type']);
                $this->db->delete('customfieldsvalues');
            }
            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', $slug);
            $this->db->delete(db_prefix() . 'my_phase_data');

            $files = $this->get_files($id);
            foreach ($files as $file) {
                $this->remove_file($file['id']);
            }

            $tasks = $this->get_tasks($id);
            foreach ($tasks as $task) {
                $this->tasks_model->delete_task($task['id'], false);
            }
            $this->db->where(array('rel_id' => $id, 'rel_type' => $slug, 'deleted' => 1));
            $this->db->delete(db_prefix() . 'tasks');

            $this->db->where('case_id', $id);
            $this->db->delete(db_prefix() . 'case_settings');

            $this->db->where('project_id', $id);
            $this->db->delete(db_prefix() . 'case_activity');

            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug, 'deleted' => 1));
            $this->db->delete(db_prefix() . 'expenses');
//
//            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug, 'deleted' => 1));
//            $this->db->delete(db_prefix() . 'invoices');

            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug, 'deleted' => 1));
            $this->db->delete(db_prefix() . 'creditnotes');

            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug, 'deleted' => 1));
            $this->db->delete(db_prefix() . 'estimates');

            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug, 'deleted' => 1));
            $this->db->delete(db_prefix() . 'tickets');

            $this->db->where('project_id', $id);
            $this->db->delete(db_prefix() . 'pinned_cases');

            $this->db->where(array('rel_id' => $id, 'rel_type' => $slug));
            $this->db->delete(db_prefix() . 'irac_method');

            $this->db->where(array('rel_id' => $id, 'rel_type' => $slug));
            $lists = $this->db->get(db_prefix() .'legal_procedures_lists')->result_array();
            foreach ($lists as $list):
                $this->procedures->delete_list($list['id']);
            endforeach;

            //Delete services tags
            $this->db->where(array('rel_id' => $id, 'rel_type' => $slug));
            $tags = $this->db->get(db_prefix().'my_services_tags')->result_array();
            foreach ($tags as $tag) {
                $this->db->where('id', $tag['id']);
                $this->db->delete(db_prefix() . 'my_services_tags');
            }

            log_activity('Case Deleted [CaseID: ' . $id . ']');
            return true;
        }
        return false;
    }

    public function move_to_recycle_bin($ServID,$id)
    {
        $slug = $this->legal->get_service_by_id($ServID)->row()->slug;

        $this->db->set('deleted', 1);
        $this->db->where(array('id' => $id, 'deleted' => 0));
        $this->db->update(db_prefix() . 'my_cases');

        if ($this->db->affected_rows() > 0) {

            $this->db->where(array('id' => $id, 'service_id' => $ServID));
            $this->db->update(db_prefix() . 'my_imported_services', [
                'deleted' => 1,
                'imported' => 0
            ]);

            $this->db->where(array('rel_id' => $id, 'rel_type' => $slug));
            $this->db->update(db_prefix() . 'tasks', [
                'deleted' => 1,
            ]);

            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug));
            $this->db->update(db_prefix() . 'expenses', [
                'deleted' => 1,
            ]);

//            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug));
//            $this->db->update(db_prefix() . 'invoices', [
//                'deleted' => 1,
//            ]);

            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug));
            $this->db->update(db_prefix() . 'creditnotes', [
                'deleted' => 1,
            ]);

            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug));
            $this->db->update(db_prefix() . 'estimates', [
                'deleted' => 1,
            ]);

            $this->db->where(array('rel_sid' => $id, 'rel_stype' => $slug));
            $this->db->update(db_prefix() . 'tickets', [
                'deleted' => 1,
            ]);

            log_activity('Case Moved To Recycle Bin [CaseID: ' . $id . ']');
            return true;
        }
        return false;
    }

    public function add_edit_oservices_members($data, $ServID, $id)
    {

        $affectedRows = 0;
        if (isset($data['project_members'])) {
            $project_members = $data['project_members'];
        }

        $new_project_members_to_receive_email = [];
        $this->db->select('name,clientid');
        $this->db->where('id', $id);
        $project = $this->db->get(db_prefix() . 'my_other_services')->row();
        $project_name = $project->name;
        $client_id = $project->clientid;

        $project_members_in = $this->get_oservices_project_members($id);
        if (sizeof($project_members_in) > 0) {
            foreach ($project_members_in as $project_member) {
                if (isset($project_members)) {
                    if (!in_array($project_member['staff_id'], $project_members)) {
                        $this->db->where('oservice_id', $id);
                        $this->db->where('staff_id', $project_member['staff_id']);
                        $this->db->delete(db_prefix() . 'my_members_services');
                        if ($this->db->affected_rows() > 0) {
                            $this->db->where('staff_id', $project_member['staff_id']);
                            $this->db->where('oservice_id', $id);
                            $this->db->delete(db_prefix() . 'pinned_oservices');

                            $this->log_activity($id, 'project_activity_removed_team_member', get_staff_full_name($project_member['staff_id']));
                            $affectedRows++;
                        }
                    }
                } else {
                    $this->db->where('oservice_id', $id);
                    $this->db->delete(db_prefix() . 'my_members_services');
                    if ($this->db->affected_rows() > 0) {
                        $affectedRows++;
                    }
                }
            }
            if (isset($project_members)) {
                $notifiedUsers = [];
                foreach ($project_members as $staff_id) {
                    $this->db->where('oservice_id', $id);
                    $this->db->where('staff_id', $staff_id);
                    $_exists = $this->db->get(db_prefix() . 'my_members_services')->row();
                    if (!$_exists) {
                        if (empty($staff_id)) {
                            continue;
                        }
                        $this->db->insert(db_prefix() . 'my_members_services', [
                            'oservice_id' => $id,
                            'staff_id' => $staff_id,
                        ]);
                        if ($this->db->affected_rows() > 0) {
                            if ($staff_id != get_staff_user_id()) {
                                $notified = add_notification([
                                    'fromuserid' => get_staff_user_id(),
                                    'description' => 'not_staff_added_as_project_member',
                                    'link' => 'SOther/view/' .$ServID.'/' . $id,
                                    'touserid' => $staff_id,
                                    'additional_data' => serialize([
                                        $project_name,
                                    ]),
                                ]);
                                array_push($new_project_members_to_receive_email, $staff_id);
                                if ($notified) {
                                    array_push($notifiedUsers, $staff_id);
                                }
                            }


                            $this->log_activity($id, 'project_activity_added_team_member', get_staff_full_name($staff_id));
                            $affectedRows++;
                        }
                    }
                }
                pusher_trigger_notification($notifiedUsers);
            }
        } else {
            if (isset($project_members)) {
                $notifiedUsers = [];
                foreach ($project_members as $staff_id) {
                    if (empty($staff_id)) {
                        continue;
                    }
                    $this->db->insert(db_prefix() . 'my_members_services', [
                        'oservice_id' => $id,
                        'staff_id' => $staff_id,
                    ]);
                    if ($this->db->affected_rows() > 0) {
                        if ($staff_id != get_staff_user_id()) {
                            $notified = add_notification([
                                'fromuserid' => get_staff_user_id(),
                                'description' => 'not_staff_added_as_project_member',
                                'link' => 'SOther/view/' .$ServID.'/'. $id,
                                'touserid' => $staff_id,
                                'additional_data' => serialize([
                                    $project_name,
                                ]),
                            ]);
                            array_push($new_project_members_to_receive_email, $staff_id);
                            if ($notifiedUsers) {
                                array_push($notifiedUsers, $staff_id);
                            }
                        }
                        $this->log_activity($id, 'project_activity_added_team_member', get_staff_full_name($staff_id));
                        $affectedRows++;
                    }
                }
                pusher_trigger_notification($notifiedUsers);
            }
        }
        if (count($new_project_members_to_receive_email) > 0) {
            $all_members = $this->get_oservices_project_members($id);
            foreach ($all_members as $data) {
                if (in_array($data['staff_id'], $new_project_members_to_receive_email)) {
                    //  error 1
                    //send_mail_template('project_staff_added_as_member', $data, $id, $client_id, $ServID);
                }
            }
        }
        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }


    public function get_oservices_project_members($id)
    {
        $this->db->select('email,oservice_id,staff_id');
        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid=' . db_prefix() . 'my_members_services.staff_id');
        $this->db->where('oservice_id', $id);
        return $this->db->get(db_prefix() . 'my_members_services')->result_array();
    }

    public function get_disputes_cases_members($id)
    {
        $this->db->select('email,project_id,staff_id');
        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid=' . db_prefix() . 'my_disputes_cases_members.staff_id');
        $this->db->where('project_id', $id);
        return $this->db->get(db_prefix() . 'my_disputes_cases_members')->result_array();
    }

    public function add_edit_members($data, $ServID, $id)
    {
        $affectedRows = 0;
        if (isset($data['project_members'])) {
            $project_members = $data['project_members'];
        }
        $new_project_members_to_receive_email = [];
        $this->db->select('name,clientid');
        $this->db->where('id', $id);
        $project      = $this->db->get(db_prefix() . 'my_cases')->row();
        $project_name = $project->name;
        $client_id    = $project->clientid;
        $project_members_in = $this->get_project_members($id);
        if (sizeof($project_members_in) > 0) {
            foreach ($project_members_in as $project_member) {
                if (isset($project_members)) {
                    if (!in_array($project_member['staff_id'], $project_members)) {
                        $this->db->where('project_id', $id);
                        $this->db->where('staff_id', $project_member['staff_id']);
                        $this->db->delete(db_prefix() . 'my_members_cases');
                        if ($this->db->affected_rows() > 0) {
                            $this->db->where('staff_id', $project_member['staff_id']);
                            $this->db->where('project_id', $id);
                            $this->db->delete(db_prefix() . 'pinned_cases');

                            $this->log_activity($id, 'project_activity_removed_team_member', get_staff_full_name($project_member['staff_id']));
                            $affectedRows++;
                        }
                    }
                } else {
                    $this->db->where('project_id', $id);
                    $this->db->delete(db_prefix() . 'my_members_cases');
                    if ($this->db->affected_rows() > 0) {
                        $affectedRows++;
                    }
                }
            }
            if (isset($project_members)) {
                $notifiedUsers = [];
                foreach ($project_members as $staff_id) {
                    $this->db->where('project_id', $id);
                    $this->db->where('staff_id', $staff_id);
                    $_exists = $this->db->get(db_prefix() . 'my_members_cases')->row();
                    if (!$_exists) {
                        if (empty($staff_id)) {
                            continue;
                        }
                        $this->db->insert(db_prefix() . 'my_members_cases', [
                            'project_id' => $id,
                            'staff_id'   => $staff_id,
                        ]);
                        if ($this->db->affected_rows() > 0) {
                            if ($staff_id != get_staff_user_id()) {
                                $notified = add_notification([
                                    'fromuserid'      => get_staff_user_id(),
                                    'description'     => 'not_staff_added_as_project_member',
                                    'link'            => 'Case/view/' .$ServID.'/' .$id,
                                    'touserid'        => $staff_id,
                                    'additional_data' => serialize([
                                        $project_name,
                                    ]),
                                ]);
                                array_push($new_project_members_to_receive_email, $staff_id);
                                if ($notified) {
                                    array_push($notifiedUsers, $staff_id);
                                }
                            }


                            $this->log_activity($id, 'project_activity_added_team_member', get_staff_full_name($staff_id));
                            $affectedRows++;
                        }
                    }
                }
                pusher_trigger_notification($notifiedUsers);
            }
        } else {
            if (isset($project_members)) {
                $notifiedUsers = [];
                foreach ($project_members as $staff_id) {
                    if (empty($staff_id)) {
                        continue;
                    }
                    $this->db->insert(db_prefix() . 'my_members_cases', [
                        'project_id' => $id,
                        'staff_id'   => $staff_id,
                    ]);
                    if ($this->db->affected_rows() > 0) {
                        if ($staff_id != get_staff_user_id()) {
                            $notified = add_notification([
                                'fromuserid'      => get_staff_user_id(),
                                'description'     => 'not_staff_added_as_project_member',
                                'link'            => 'Case/view/' .$ServID.'/' .$id,
                                'touserid'        => $staff_id,
                                'additional_data' => serialize([
                                    $project_name,
                                ]),
                            ]);
                            array_push($new_project_members_to_receive_email, $staff_id);
                            if ($notifiedUsers) {
                                array_push($notifiedUsers, $staff_id);
                            }
                        }
                        $this->log_activity($id, 'project_activity_added_team_member', get_staff_full_name($staff_id));
                        $affectedRows++;
                    }
                }
                pusher_trigger_notification($notifiedUsers);
            }
        }

        if (count($new_project_members_to_receive_email) > 0) {
            $all_members = $this->get_project_members($id);
            foreach ($all_members as $data) {
                if (in_array($data['staff_id'], $new_project_members_to_receive_email)) {
                    send_mail_template('project_staff_added_as_member', $data, $id, $client_id, $ServID);
                }
            }
        }
        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }

    public function add_disputes_cases_members($data, $ServID, $id)
    {
        $affectedRows = 0;
        if (isset($data['project_members'])) {
            $project_members = $data['project_members'];
        }
        $new_project_members_to_receive_email = [];
        $this->db->select('name,clientid');
        $this->db->where('id', $id);
        $project      = $this->db->get(db_prefix() . 'my_disputes_cases')->row();
        $project_name = $project->name;
        $client_id    = $project->clientid;
        if (isset($project_members)) {
            $notifiedUsers = [];
            foreach ($project_members as $staff_id) {
                if (empty($staff_id)) {
                    continue;
                }
                $this->db->insert(db_prefix() . 'my_disputes_cases_members', [
                    'project_id' => $id,
                    'staff_id'   => $staff_id,
                ]);
                if ($this->db->affected_rows() > 0) {
                    if ($staff_id != get_staff_user_id()) {
                        $notified = add_notification([
                            'fromuserid'      => get_staff_user_id(),
                            'description'     => 'not_staff_added_as_project_member',
                            'link'            => 'Disputes_cases/view/' .$ServID.'/' .$id,
                            'touserid'        => $staff_id,
                            'additional_data' => serialize([
                                $project_name,
                            ]),
                        ]);
                        array_push($new_project_members_to_receive_email, $staff_id);
                        if ($notifiedUsers) {
                            array_push($notifiedUsers, $staff_id);
                        }
                    }
                    $this->log_activity($id, 'project_activity_added_team_member', get_staff_full_name($staff_id));
                    $affectedRows++;
                }
            }
            pusher_trigger_notification($notifiedUsers);
        }

        if (count($new_project_members_to_receive_email) > 0) {
            $all_members = $this->get_disputes_cases_members($id);
            foreach ($all_members as $data) {
                if (in_array($data['staff_id'], $new_project_members_to_receive_email)) {
                    send_mail_template('project_staff_added_as_member', $data, $id, $client_id, $ServID);
                }
            }
        }
        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }


    public function add_edit_judges($data, $id)
    {
        $affectedRows = 0;
        if (isset($data['judges'])) {
            $cases_judges = $data['judges'];
        }
        $cases_judges_in = $this->get_case_judges($id);

        if (sizeof($cases_judges_in) > 0) {
            foreach ($cases_judges_in as $case_judge) {
                if (isset($cases_judges)) {
                    if (!in_array($case_judge['judge_id'], $cases_judges)) {
                        $this->db->where('case_id', $id);
                        $this->db->where('judge_id', $case_judge['judge_id']);
                        $this->db->delete(db_prefix() . 'my_cases_judges');
                        if ($this->db->affected_rows() > 0) {
                            $affectedRows++;
                        }
                    }
                } else {
                    $this->db->where('case_id', $id);
                    $this->db->delete(db_prefix() . 'my_cases_judges');
                    if ($this->db->affected_rows() > 0) {
                        $affectedRows++;
                    }
                }
            }
            if (isset($cases_judges)) {
                foreach ($cases_judges as $judge_id) {
                    $this->db->where('case_id', $id);
                    $this->db->where('judge_id', $judge_id);
                    $_exists = $this->db->get(db_prefix() . 'my_cases_judges')->row();
                    if (!$_exists) {
                        if (empty($judge_id)) {
                            continue;
                        }
                        $this->db->insert(db_prefix() . 'my_cases_judges', [
                            'case_id'   => $id,
                            'judge_id'  => $judge_id,
                        ]);
                        if ($this->db->affected_rows() > 0) {
                            $affectedRows++;
                        }
                    }
                }
            }
        } else {
            if (isset($cases_judges)) {
                foreach ($cases_judges as $judge_id) {
                    if (empty($judge_id)) {
                        continue;
                    }
                    $this->db->insert(db_prefix() . 'my_cases_judges', [
                        'case_id'  => $id,
                        'judge_id' => $judge_id,
                    ]);
                    if ($this->db->affected_rows() > 0) {
                        $affectedRows++;
                    }
                }
            }
        }
        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }

    public function get_project_members($id)
    {
        $this->db->select('email,project_id,staff_id');
        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid=' . db_prefix() . 'my_members_cases.staff_id');
        $this->db->where('project_id', $id);
        return $this->db->get(db_prefix() . 'my_members_cases')->result_array();
    }

    public function get_project_members_name($id)
    {

        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid=' . db_prefix() . 'my_members_cases.staff_id');
        $this->db->where('project_id', $id);
        return $this->db->get(db_prefix() . 'my_members_cases')->result_array();
    }
    public function get_case_judges($id)
    {
        $this->db->select('my_cases_judges.*,my_judges.*');
        $this->db->join(db_prefix() . 'my_judges', db_prefix() . 'my_judges.id=' . db_prefix() . 'my_cases_judges.judge_id');
        $this->db->where('my_cases_judges.case_id', $id);
        return $this->db->get(db_prefix() . 'my_cases_judges')->result_array();
    }

    public function get_project_statuses()
    {
        $statuses = hooks()->apply_filters('before_get_project_statuses', [
            [
                'id'             => 1,
                'color'          => '#989898',
                'name'           => _l('project_status_1'),
                'order'          => 1,
                'filter_default' => true,
            ],
            [
                'id'             => 2,
                'color'          => '#03a9f4',
                'name'           => _l('project_status_2'),
                'order'          => 2,
                'filter_default' => true,
            ],
            [
                'id'             => 3,
                'color'          => '#ff6f00',
                'name'           => _l('project_status_3'),
                'order'          => 3,
                'filter_default' => true,
            ],
            [
                'id'             => 4,
                'color'          => '#84c529',
                'name'           => _l('project_status_4'),
                'order'          => 100,
                'filter_default' => false,
            ],
            [
                'id'             => 5,
                'color'          => '#989898',
                'name'           => _l('project_status_5'),
                'order'          => 4,
                'filter_default' => false,
            ],
        ]);

        usort($statuses, function ($a, $b) {
            return $a['order'] - $b['order'];
        });

        return $statuses;
    }

    public function get_distinct_tasks_timesheets_staff($project_id, $slug)
    {
        return $this->db->query('SELECT DISTINCT staff_id FROM ' . db_prefix() . 'taskstimers LEFT JOIN ' . db_prefix() . 'tasks ON ' . db_prefix() . 'tasks.id = ' . db_prefix() . 'taskstimers.task_id WHERE rel_type="'.$slug.'" AND rel_id=' . $project_id)->result_array();
    }

    public function get_distinct_projects_members()
    {
        return $this->db->query('SELECT staff_id, firstname, lastname FROM ' . db_prefix() . 'my_members_cases JOIN ' . db_prefix() . 'staff ON ' . db_prefix() . 'staff.staffid=' . db_prefix() . 'my_members_cases.staff_id GROUP by staff_id order by firstname ASC')->result_array();
    }

    public function get_most_used_billing_type()
    {
        return $this->db->query('SELECT billing_type, COUNT(*) AS total_usage
                FROM ' . db_prefix() . 'my_cases
                GROUP BY billing_type
                ORDER BY total_usage DESC
                LIMIT 1')->row();
    }

    public function timers_started_for_project($slug = '', $project_id, $where = [], $task_timers_where = [])
    {
        $this->db->where($where);
        $this->db->where('end_time IS NULL');
        $this->db->where(db_prefix() . 'tasks.rel_id', $project_id);
        $this->db->where(db_prefix() . 'tasks.rel_type', $slug);
        $this->db->join(db_prefix() . 'tasks', db_prefix() . 'tasks.id=' . db_prefix() . 'taskstimers.task_id');
        $total = $this->db->count_all_results(db_prefix() . 'taskstimers');

        return $total > 0 ? true : false;
    }

    public function pin_action($id)
    {
        if (total_rows(db_prefix() . 'pinned_cases', [
                'staff_id' => get_staff_user_id(),
                'project_id' => $id,
            ]) == 0) {
            $this->db->insert(db_prefix() . 'pinned_cases', [
                'staff_id'   => get_staff_user_id(),
                'project_id' => $id,
            ]);

            return true;
        }
        $this->db->where('project_id', $id);
        $this->db->where('staff_id', get_staff_user_id());
        $this->db->delete(db_prefix() . 'pinned_cases');

        return true;
    }

    public function get_currency($id)
    {
        $this->load->model('currencies_model');
        $customer_currency = $this->clients_model->get_customer_default_currency(get_client_id_by_case_id($id));
        if ($customer_currency != 0) {
            $currency = $this->currencies_model->get($customer_currency);
        } else {
            $currency = $this->currencies_model->get_base_currency();
        }

        return $currency;
    }

    public function calc_progress($id, $slug)
    {
        $this->db->select('progress_from_tasks,progress,status');
        $this->db->where('id', $id);
        $project = $this->db->get(db_prefix() . 'my_cases')->row();

        if ($project->status == 4) {
            return 100;
        }

        if ($project->progress_from_tasks == 1) {
            return $this->calc_progress_by_tasks($id, $slug);
        }

        return $project->progress;
    }

    public function calc_progress_by_tasks($id, $slug)
    {
        $total_project_tasks = total_rows(db_prefix() . 'tasks', [
            'rel_type' => $slug,
            'rel_id'   => $id,
        ]);
        $total_finished_tasks = total_rows(db_prefix() . 'tasks', [
            'rel_type' => $slug,
            'rel_id'   => $id,
            'status'   => 5,
        ]);
        $percent = 0;
        if ($total_finished_tasks >= floatval($total_project_tasks)) {
            $percent = 100;
        } else {
            if ($total_project_tasks !== 0) {
                $percent = number_format(($total_finished_tasks * 100) / $total_project_tasks, 2);
            }
        }

        return $percent;
    }

    public function get_last_case_settings()
    {
        $this->db->select('id');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $last_project = $this->db->get(db_prefix() . 'my_cases')->row();
        if ($last_project) {
            return $this->get_case_settings($last_project->id);
        }

        return [];
    }

    public function get_settings()
    {
        return $this->project_settings;
    }

    public function calculate_total_by_project_hourly_rate($seconds, $hourly_rate)
    {
        $hours       = seconds_to_time_format($seconds);
        $decimal     = sec2qty($seconds);
        $total_money = 0;
        $total_money += ($decimal * $hourly_rate);

        return [
            'hours'       => $hours,
            'total_money' => $total_money,
        ];
    }

    public function calculate_total_by_task_hourly_rate($tasks)
    {
        $total_money    = 0;
        $_total_seconds = 0;

        foreach ($tasks as $task) {
            $seconds = $task['total_logged_time'];
            $_total_seconds += $seconds;
            $total_money += sec2qty($seconds) * $task['hourly_rate'];
        }

        return [
            'total_money'   => $total_money,
            'total_seconds' => $_total_seconds,
        ];
    }

   public function get_CaseSession($id, $where = [], $apply_restrictions = false, $count = false, $ServID = 1)
    {
        $slug = $this->legal->get_service_by_id($ServID)->row()->slug;

        $CI = &get_instance();
        $CI->load->library('app_modules');
        $time_format = get_option('time_format');
        if ($time_format === '24') {
            $format = '"%H:%i"';
        } else {
            $format = '"%h:%i %p"';
        }

        $select = implode(', ', prefixed_table_fields_array(db_prefix() . 'tasks')) . ',' . db_prefix() . 'tasks.id as id,
        '.db_prefix() . 'tasks.name as task_name,'
        .db_prefix() . 'my_judges.name as judge,
        court_name,
        session_link,
        customer_report,
        send_to_customer,
        startdate,
        TIME_FORMAT(time,'. $format .') as time
        ';

        $this->db->select($select);

        $this->db->where(array(
            db_prefix() .'tasks.rel_id'             => $id,
            db_prefix() .'tasks.rel_type'           => $slug,
            db_prefix() .'tasks.is_session'         => 1,
//            db_prefix() .'tasks.visible_to_client'         => 1
     ));
        $this->db->where($where);

        $this->db->join(db_prefix() . 'my_session_info', db_prefix() . 'my_session_info.task_id = ' . db_prefix() . 'tasks.id', 'inner');
        $this->db->join(db_prefix() . 'my_courts', db_prefix() . 'my_courts.c_id = ' . db_prefix() . 'my_session_info.court_id', 'left');
        $this->db->join(db_prefix() . 'my_judges', db_prefix() . 'my_judges.id = ' . db_prefix() . 'my_session_info.judge_id', 'left');

        if ($count == false) {
            $tasks = $this->db->get(db_prefix() . 'tasks')->result_array();
        } else {
            $tasks = $this->db->count_all_results(db_prefix() . 'tasks');
        }


        for($i=0; $i < count($tasks); $i++) {
            $tasks[$i]['assignees']     = $this->tasks_model->get_task_assignees($tasks[$i]['id']);
            $tasks[$i]['assignees_ids'] = [];

            foreach ($tasks[$i]['assignees'] as $follower) {
                array_push($tasks[$i]['assignees_ids'], $follower['assigneeid']);
            }

            // if (is_client_logged_in()) {
                
            //     if (total_rows(db_prefix() . 'task_assigned', [
            //         'staffid' => get_staff_user_id(),
            //         'taskid' => $id,
            //     ]) == 0) {
            //         $tasks[$i]['current_user_is_assigned']  = false;
            //     } else {
            //         $tasks[$i]['current_user_is_assigned']  = true;
            //     }
            // }
        }
        
        return $tasks;
    }

    public function cancel_recurring_tasks($id, $slug)
    {
        $this->db->where('rel_type', $slug);
        $this->db->where('rel_id', $id);
        $this->db->where('recurring', 1);
        $this->db->where('(cycles != total_cycles OR cycles=0)');

        $this->db->update(db_prefix() . 'tasks', [
            'recurring_type'      => null,
            'repeat_every'        => 0,
            'cycles'              => 0,
            'recurring'           => 0,
            'custom_recurring'    => 0,
            'last_recurring_date' => null,
        ]);
    }

    public function get_tasks($id, $where = [], $apply_restrictions = false, $count = false, $ServID = 1, $callback = null)
    {
        $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
        $has_permission                    = has_permission('tasks', '', 'view');
        $show_all_tasks_for_project_member = get_option('show_all_tasks_for_project_member');


        $select = implode(', ', prefixed_table_fields_array(db_prefix() . 'tasks')) . ',' . db_prefix() . 'milestones.name as milestone_name,
        (SELECT SUM(CASE
            WHEN end_time is NULL THEN ' . time() . '-start_time
            ELSE end_time-start_time
            END) FROM ' . db_prefix() . 'taskstimers WHERE task_id=' . db_prefix() . 'tasks.id) as total_logged_time,
           ' . get_sql_select_task_assignees_ids() . ' as assignees_ids
        ';

        if (!is_client_logged_in() && is_staff_logged_in()) {
            $select .= ',(SELECT staffid FROM ' . db_prefix() . 'task_assigned WHERE taskid=' . db_prefix() . 'tasks.id AND staffid=' . get_staff_user_id() . ') as current_user_is_assigned';
        }
        if (is_client_logged_in()) {
            $this->db->where('visible_to_client', 1);
        }
        $this->db->select($select);

        $this->db->join(db_prefix() . 'milestones', db_prefix() . 'milestones.id = ' . db_prefix() . 'tasks.milestone', 'left');
        $this->db->where(db_prefix() .'tasks.rel_id', $id);
        $this->db->where(db_prefix() .'tasks.rel_type', $slug);
        if ($apply_restrictions == true) {
            if (!is_client_logged_in() && !$has_permission && $show_all_tasks_for_project_member == 0) {
                $this->db->where('(
                    ' . db_prefix() . 'tasks.id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid=' . get_staff_user_id() . ')
                    OR ' . db_prefix() . 'tasks.id IN(SELECT taskid FROM ' . db_prefix() . 'task_followers WHERE staffid=' . get_staff_user_id() . ')
                    OR is_public = 1
                    OR (addedfrom =' . get_staff_user_id() . ' AND is_added_from_contact = 0)
                    )');
            }
        }

        $this->db->where($where);

        // Milestones kanban order
        // Request is admin/projects/milestones_kanban
        if ($this->uri->segment(3) == 'milestones_kanban' | $this->uri->segment(3) == 'milestones_kanban_load_more') {
            $this->db->order_by('milestone_order', 'asc');
        } else {
            $orderByString = hooks()->apply_filters('project_tasks_array_default_order', 'FIELD(status, 5), duedate IS NULL ASC, duedate');
            $this->db->order_by($orderByString, '', false);
        }

        if ($callback) {
            $callback();
        }

        if ($count == false) {
            $tasks = $this->db->get(db_prefix() . 'tasks')->result_array();
        } else {
            $tasks = $this->db->count_all_results(db_prefix() . 'tasks');
        }

        return $tasks;
    }

    
    public function do_milestones_kanban_query($milestone_id, $project_id, $page = 1, $where = [], $count = false)
    {
        $where['milestone'] = $milestone_id;
        $limit              = get_option('tasks_kanban_limit');
        $tasks              = $this->get_tasks($project_id, $where, true, $count,$ServID = 1, function () use ($count, $page, $limit) {
            if ($count == false) {
                if ($page > 1) {
                    $position = (($page - 1) * $limit);
                    $this->db->limit($limit, $position);
                } else {
                    $this->db->limit($limit);
                }
            }
        });

        return $tasks;
    }

    public function get_files($project_id)
    {
        if (is_client_logged_in()) {
            $this->db->where('visible_to_customer', 1);
        }
        $this->db->where('project_id', $project_id);
        return $this->db->get(db_prefix() . 'case_files')->result_array();
    }

    public function get_file($id, $project_id = false)
    {
        if (is_client_logged_in()) {
            $this->db->where('visible_to_customer', 1);
        }
        $this->db->where('id', $id);
        $file = $this->db->get(db_prefix() . 'case_files')->row();

        if ($file && $project_id) {
            if ($file->project_id != $project_id) {
                return false;
            }
        }

        return $file;
    }

    public function update_file_data($data)
    {
        $this->db->where('id', $data['id']);
        unset($data['id']);
        $this->db->update(db_prefix() . 'case_files', $data);
    }

    public function change_file_visibility($id, $visible)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'case_files', [
            'visible_to_customer' => $visible,
        ]);
    }

    public function change_activity_visibility($id, $visible)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'case_activity', [
            'visible_to_customer' => $visible,
        ]);
    }

    public function remove_file($id, $logActivity = true)
    {
        hooks()->do_action('before_remove_project_file', $id);

        $this->db->where('id', $id);
        $file = $this->db->get(db_prefix() . 'case_files')->row();
        if ($file) {
            if (empty($file->external)) {
                $path     = get_upload_path_by_type_case('case') . $file->project_id . '/';
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
            $this->db->delete(db_prefix() . 'case_files');
            if ($logActivity) {
                $this->log_activity($file->project_id, 'project_activity_project_file_removed', $file->file_name, $file->visible_to_customer);
            }

            // Delete discussion comments
            $this->_delete_discussion_comments($id, 'file');

            if (is_dir(get_upload_path_by_type_case('case') . $file->project_id)) {
                // Check if no attachments left, so we can delete the folder also
                $other_attachments = list_files(get_upload_path_by_type_case('case') . $file->project_id);
                if (count($other_attachments) == 0) {
                    delete_dir(get_upload_path_by_type_case('case') . $file->project_id);
                }
            }

            return true;
        }

        return false;
    }

    public function get_project_overview_weekly_chart_data($slug = '', $id, $type = 'this_week')
    {
        $billing_type = get_case_billing_type($id);
        $chart        = [];

        $has_permission_create = has_permission('projects', '', 'create');
        // If don't have permission for projects create show only bileld time
        if (!$has_permission_create) {
            $timesheets_type = 'total_logged_time_only';
        } else {
            if ($billing_type == 2 || $billing_type == 3) {
                $timesheets_type = 'billable_unbilled';
            } else {
                $timesheets_type = 'total_logged_time_only';
            }
        }

        $chart['data']             = [];
        $chart['data']['labels']   = [];
        $chart['data']['datasets'] = [];

        $chart['data']['datasets'][] = [
            'label'           => ($timesheets_type == 'billable_unbilled' ? str_replace(':', '', _l('project_overview_billable_hours')) : str_replace(':', '', _l('project_overview_logged_hours'))),
            'data'            => [],
            'backgroundColor' => [],
            'borderColor'     => [],
            'borderWidth'     => 1,
        ];

        if ($timesheets_type == 'billable_unbilled') {
            $chart['data']['datasets'][] = [
                'label'           => str_replace(':', '', _l('project_overview_unbilled_hours')),
                'data'            => [],
                'backgroundColor' => [],
                'borderColor'     => [],
                'borderWidth'     => 1,
            ];
        }

        $temp_weekdays_data = [];
        $weeks              = [];
        $where_time         = '';

        if ($type == 'this_month') {
            $beginThisMonth = date('Y-m-01');
            $endThisMonth   = date('Y-m-t 23:59:59');

            $weeks_split_start = date('Y-m-d', strtotime($beginThisMonth));
            $weeks_split_end   = date('Y-m-d', strtotime($endThisMonth));

            $where_time = 'start_time BETWEEN ' . strtotime($beginThisMonth) . ' AND ' . strtotime($endThisMonth);
        } elseif ($type == 'last_month') {
            $beginLastMonth = date('Y-m-01', strtotime('-1 MONTH'));
            $endLastMonth   = date('Y-m-t 23:59:59', strtotime('-1 MONTH'));

            $weeks_split_start = date('Y-m-d', strtotime($beginLastMonth));
            $weeks_split_end   = date('Y-m-d', strtotime($endLastMonth));

            $where_time = 'start_time BETWEEN ' . strtotime($beginLastMonth) . ' AND ' . strtotime($endLastMonth);
        } elseif ($type == 'last_week') {
            $beginLastWeek = date('Y-m-d', strtotime('monday last week'));
            $endLastWeek   = date('Y-m-d 23:59:59', strtotime('sunday last week'));
            $where_time    = 'start_time BETWEEN ' . strtotime($beginLastWeek) . ' AND ' . strtotime($endLastWeek);
        } else {
            $beginThisWeek = date('Y-m-d', strtotime('monday this week'));
            $endThisWeek   = date('Y-m-d 23:59:59', strtotime('sunday this week'));
            $where_time    = 'start_time BETWEEN ' . strtotime($beginThisWeek) . ' AND ' . strtotime($endThisWeek);
        }

        if ($type == 'this_week' || $type == 'last_week') {
            foreach (get_weekdays() as $day) {
                array_push($chart['data']['labels'], $day);
            }
            $weekDay = date('w', strtotime(date('Y-m-d H:i:s')));
            $i       = 0;
            foreach (get_weekdays_original() as $day) {
                if ($weekDay != '0') {
                    $chart['data']['labels'][$i] = date('d', strtotime($day . ' ' . str_replace('_', ' ', $type))) . ' - ' . $chart['data']['labels'][$i];
                } else {
                    if ($type == 'this_week') {
                        $strtotime = 'last ' . $day;
                        if ($day == 'Sunday') {
                            $strtotime = 'sunday this week';
                        }
                        $chart['data']['labels'][$i] = date('d', strtotime($strtotime)) . ' - ' . $chart['data']['labels'][$i];
                    } else {
                        $strtotime                   = $day . ' last week';
                        $chart['data']['labels'][$i] = date('d', strtotime($strtotime)) . ' - ' . $chart['data']['labels'][$i];
                    }
                }
                $i++;
            }
        } elseif ($type == 'this_month' || $type == 'last_month') {
            $weeks_split_start = new DateTime($weeks_split_start);
            $weeks_split_end   = new DateTime($weeks_split_end);
            $weeks             = get_weekdays_between_dates($weeks_split_start, $weeks_split_end);
            $total_weeks       = count($weeks);
            for ($i = 1; $i <= $total_weeks; $i++) {
                array_push($chart['data']['labels'], split_weeks_chart_label($weeks, $i));
            }
        }

        $loop_break = ($timesheets_type == 'billable_unbilled') ? 2 : 1;

        for ($i = 0; $i < $loop_break; $i++) {
            $temp_weekdays_data = [];
            // Store the weeks in new variable for each loop to prevent duplicating
            $tmp_weeks = $weeks;


            $color = '3, 169, 244';

            $where = 'task_id IN (SELECT id FROM ' . db_prefix() . 'tasks WHERE rel_type = "'.$slug.'" AND rel_id = "' . $id . '"';

            if ($timesheets_type != 'total_logged_time_only') {
                $where .= ' AND billable=1';
                if ($i == 1) {
                    $color = '252, 45, 66';
                    $where .= ' AND billed = 0';
                }
            }

            $where .= ')';
            $this->db->where($where_time);
            $this->db->where($where);
            if (!$has_permission_create) {
                $this->db->where('staff_id', get_staff_user_id());
            }
            $timesheets = $this->db->get(db_prefix() . 'taskstimers')->result_array();

            foreach ($timesheets as $t) {
                $total_logged_time = 0;
                if ($t['end_time'] == null) {
                    $total_logged_time = time() - $t['start_time'];
                } else {
                    $total_logged_time = $t['end_time'] - $t['start_time'];
                }

                if ($type == 'this_week' || $type == 'last_week') {
                    $weekday = date('N', $t['start_time']);
                    if (!isset($temp_weekdays_data[$weekday])) {
                        $temp_weekdays_data[$weekday] = 0;
                    }
                    $temp_weekdays_data[$weekday] += $total_logged_time;
                } else {
                    // months - this and last
                    $w = 1;
                    foreach ($tmp_weeks as $week) {
                        $start_time_date = strftime('%Y-%m-%d', $t['start_time']);
                        if (!isset($tmp_weeks[$w]['total'])) {
                            $tmp_weeks[$w]['total'] = 0;
                        }
                        if (in_array($start_time_date, $week)) {
                            $tmp_weeks[$w]['total'] += $total_logged_time;
                        }
                        $w++;
                    }
                }
            }

            if ($type == 'this_week' || $type == 'last_week') {
                ksort($temp_weekdays_data);
                for ($w = 1; $w <= 7; $w++) {
                    $total_logged_time = 0;
                    if (isset($temp_weekdays_data[$w])) {
                        $total_logged_time = $temp_weekdays_data[$w];
                    }
                    array_push($chart['data']['datasets'][$i]['data'], sec2qty($total_logged_time));
                    array_push($chart['data']['datasets'][$i]['backgroundColor'], 'rgba(' . $color . ',0.8)');
                    array_push($chart['data']['datasets'][$i]['borderColor'], 'rgba(' . $color . ',1)');
                }
            } else {
                // loop over $tmp_weeks because the unbilled is shown twice because we auto increment twice
                // months - this and last
                foreach ($tmp_weeks as $week) {
                    $total = 0;
                    if (isset($week['total'])) {
                        $total = $week['total'];
                    }
                    $total_logged_time = $total;
                    array_push($chart['data']['datasets'][$i]['data'], sec2qty($total_logged_time));
                    array_push($chart['data']['datasets'][$i]['backgroundColor'], 'rgba(' . $color . ',0.8)');
                    array_push($chart['data']['datasets'][$i]['borderColor'], 'rgba(' . $color . ',1)');
                }
            }
        }

        return $chart;
    }

    public function get_gantt_data($slug, $project_id, $type = 'milestones', $taskStatus = null)
    {
        $project_data = $this->get($project_id);
        $type_data = [];
        if ($type == 'milestones') {
            $type_data[] = [
                'name'   => _l('milestones_uncategorized'),
                'dep_id' => 'milestone_0',
                'id'     => 0,
            ];
            $_milestones = $this->get_milestones($slug, $project_id);
            foreach ($_milestones as $m) {
                $m['dep_id']       = 'milestone_' . $m['id'];
                $m['milestone_id'] = $m['id'];
                $type_data[]       = $m;
            }
        } elseif ($type == 'members') {
            $type_data[] = [
                'name'     => _l('task_list_not_assigned'),
                'dep_id'   => 'member_0' ,
                'staff_id' => 0,
            ];
            $_members = $this->get_project_members($project_id);
            foreach ($_members as $m) {
                $m['dep_id'] = 'member_' . $m['staff_id'];
                $m['name']   = get_staff_full_name($m['staff_id']);
                $type_data[] = $m;
            }
        } else {
            if (!$taskStatus) {
                $statuses = $this->tasks_model->get_statuses();
                foreach ($statuses as $status) {
                    $status['dep_id'] = 'status_' . $status['id'];
                    $status['name']   = format_task_status($status['id'], false, true);
                    $type_data[]      = $status;
                }
            } else {
                $status['id']     = $taskStatus;
                $status['dep_id'] = 'status_' . $taskStatus;
                $status['name']   = format_task_status($taskStatus, false, true);
                $type_data[]      = $status;
            }
        }

        $gantt_data     = [];
        $has_permission = has_permission('tasks', '', 'view');
        foreach ($type_data as $data) {
            if ($type == 'milestones') {
                $tasks = $this->get_tasks($project_id, 'milestone=' . $data['id'] . ($taskStatus ? ' AND ' . db_prefix() . 'tasks.status=' . $taskStatus : ''), true);
                if (isset($data['due_date'])) {
                    $data['end'] = $data['due_date'];
                }
                unset($data['description']);
            } elseif ($type == 'members') {
                if ($data['staff_id'] != 0) {
                    $tasks = $this->get_tasks($project_id, db_prefix() . 'tasks.id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid=' . $data['staff_id'] . ')' . ($taskStatus ? ' AND ' . db_prefix() . 'tasks.status=' . $taskStatus : ''), true);
                } else {
                    $tasks = $this->get_tasks($project_id, db_prefix() . 'tasks.id NOT IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned)' . ($taskStatus ? ' AND ' . db_prefix() . 'tasks.status=' . $taskStatus : ''), true);
                }
            } else {
                $tasks = $this->get_tasks($project_id, [
                    'status' => $data['id'],
                ], true);

                $name = format_task_status($data, false, true);
            }

            if (count($tasks) > 0) {
                $data['id']           = $data['dep_id'];
                $data['start']        = $project_data->start_date;
                $data['end']          = (isset($data['end'])) ? $data['end'] : $project_data->deadline;
                $data['custom_class'] = 'noDrag';
                unset($data['dep_id']);

                $gantt_data[] = $data;

                foreach ($tasks as $task) {
                    $gantt_data[] = get_task_array_gantt_data($task, $data['id']);

                }
            }
        }

        return $gantt_data;
    }

    public function get_all_projects_gantt_data($filters = [])
    {
        $statuses   = $this->get_project_statuses();
        $gantt_data = [];

        $statusesIds = [];
        foreach ($statuses as $status) {
            if (!in_array($status['id'], $filters['status'])) {
                continue;
            }

            if (!has_permission('projects', '', 'view')) {
                $this->db->where(db_prefix() . 'my_cases.id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . get_staff_user_id() . ')');
            }

            if ($filters['member']) {
                $this->db->where(db_prefix() . 'my_cases.id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . $filters['member'] . ')');
            }

            $this->db->where('status', $status['id']);
            $this->db->order_by('deadline IS NULL ASC, deadline', '', false);
            $projects = $this->db->get(db_prefix() . 'my_cases')->result_array();
            foreach ($projects as $project) {
                $tasks = $this->get_tasks($project['id'], [], true);

                $data               = [];
                $data['id']         = 'proj_' . $project['id'];
                $data['project_id'] = $project['id'];
                $data['name']       = $project['name'];
                $data['progress']   = 0;
                $data['start']      = strftime('%Y-%m-%d', strtotime($project['start_date']));

                if (!empty($project['deadline'])) {
                    $data['end'] = strftime('%Y-%m-%d', strtotime($project['deadline']));
                }

                $data['custom_class'] = 'noDrag';
                $gantt_data[]         = $data;


                if (count($tasks) > 0) {
                    foreach ($tasks as $task) {
                        $task_data                 = get_task_array_gantt_data($task, null, isset($data['end']) ? $data['end'] : null);
                        $task_data['progress']     = 0;
                        $task_data['dependencies'] = $data['id'];
                        $gantt_data[]              = $task_data;
                    }
                }
            }
        }

        return $gantt_data;
    }

    public function calc_milestone_logged_time($project_id, $id)
    {
        $total = [];
        $tasks = $this->get_tasks($project_id, [
            'milestone' => $id,
        ]);

        foreach ($tasks as $task) {
            $total[] = $task['total_logged_time'];
        }

        return array_sum($total);
    }

    public function total_logged_time($slug, $id)
    {
        $q = $this->db->query('
            SELECT SUM(CASE
                WHEN end_time is NULL THEN ' . time() . '-start_time
                ELSE end_time-start_time
                END) as total_logged_time
            FROM ' . db_prefix() . 'taskstimers
            WHERE task_id IN (SELECT id FROM ' . db_prefix() . 'tasks WHERE rel_type="'.$slug.'" AND rel_id=' . $id . ')')
            ->row();

        return $q->total_logged_time;
    }

    public function get_milestones($slug,$project_id)
    {
        $this->db->select('*, (SELECT COUNT(id) FROM '.db_prefix().'tasks WHERE '.db_prefix().'tasks.rel_type="'.$slug.'" AND '.db_prefix().'tasks.rel_id='.$project_id.' and milestone='.db_prefix().'milestones.id) as total_tasks, (SELECT COUNT(id) FROM '.db_prefix().'tasks WHERE '.db_prefix().'tasks.rel_type="'.$slug.'" AND '.db_prefix().'tasks.rel_id='.$project_id.' and milestone='.db_prefix().'milestones.id AND status=5) as total_finished_tasks');
        $this->db->where(array(db_prefix() . 'milestones.rel_sid' => $project_id, db_prefix() . 'milestones.rel_stype' => $slug));
        $this->db->order_by('milestone_order', 'ASC');
        $milestones = $this->db->get(db_prefix() . 'milestones')->result_array();
        $i          = 0;
        foreach ($milestones as $milestone) {
            $milestones[$i]['total_logged_time'] = $this->calc_milestone_logged_time($project_id, $milestone['id']);
            $i++;
        }


        return $milestones;
    }

    public function add_milestone($ServID, $data)
    {
        $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
        $data['rel_stype']    = $slug;
        $data['due_date']    = to_sql_date($data['due_date']);
        $data['datecreated'] = date('Y-m-d');
        $data['description'] = nl2br($data['description']);
        if (isset($data['description_visible_to_customer'])) {
            $data['description_visible_to_customer'] = 1;
        } else {
            $data['description_visible_to_customer'] = 0;
        }
        $this->db->insert(db_prefix() . 'milestones', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $this->db->where('id', $insert_id);
            $milestone = $this->db->get(db_prefix() . 'milestones')->row();
            $project   = $this->get($milestone->rel_sid);
            if ($project->settings->view_milestones == 1) {
                $show_to_customer = 1;
            } else {
                $show_to_customer = 0;
            }
            $this->log_activity($milestone->project_id, 'project_activity_created_milestone', $milestone->name, $show_to_customer);
            log_activity('Case Milestone Created [ID:' . $insert_id . ']');

            return $insert_id;
        }

        return false;
    }

    public function update_milestone($data, $id)
    {
        $this->db->where('id', $id);
        $milestone           = $this->db->get(db_prefix() . 'milestones')->row();
        $data['due_date']    = to_sql_date($data['due_date']);
        $data['description'] = nl2br($data['description']);

        if (isset($data['description_visible_to_customer'])) {
            $data['description_visible_to_customer'] = 1;
        } else {
            $data['description_visible_to_customer'] = 0;
        }

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'milestones', $data);
        if ($this->db->affected_rows() > 0) {
            $project = $this->get($milestone->project_id);
            if ($project->settings->view_milestones == 1) {
                $show_to_customer = 1;
            } else {
                $show_to_customer = 0;
            }
            $this->log_activity($milestone->project_id, 'project_activity_updated_milestone', $milestone->name, $show_to_customer);
            log_activity('Case Milestone Updated [ID:' . $id . ']');

            return true;
        }

        return false;
    }

    public function update_task_milestone($data)
    {
        $this->db->where('id', $data['task_id']);
        $this->db->update(db_prefix() . 'tasks', [
            'milestone' => $data['milestone_id'],
        ]);

        foreach ($data['order'] as $order) {
            $this->db->where('id', $order[0]);
            $this->db->update(db_prefix() . 'tasks', [
                'milestone_order' => $order[1],
            ]);
        }
    }

    public function update_milestones_order($data)
    {
        foreach ($data['order'] as $status) {
            $this->db->where('id', $status[0]);
            $this->db->update(db_prefix() . 'milestones', [
                'milestone_order' => $status[1],
            ]);
        }
    }

    public function update_milestone_color($data)
    {
        $this->db->where('id', $data['milestone_id']);
        $this->db->update(db_prefix() . 'milestones', [
            'color' => $data['color'],
        ]);
    }

    public function delete_milestone($id)
    {
        $this->db->where('id', $id);
        $milestone = $this->db->get(db_prefix() . 'milestones')->row();
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'milestones');
        if ($this->db->affected_rows() > 0) {
            $project = $this->get($milestone->project_id);
            if ($project->settings->view_milestones == 1) {
                $show_to_customer = 1;
            } else {
                $show_to_customer = 0;
            }
            $this->log_activity($milestone->project_id, 'project_activity_deleted_milestone', $milestone->name, $show_to_customer);
            $this->db->where('milestone', $id);
            $this->db->update(db_prefix() . 'tasks', [
                'milestone' => 0,
            ]);
            log_activity('Case Milestone Deleted [' . $id . ']');

            return true;
        }

        return false;
    }

    /**
     * Simplified function to send non complicated email templates for project contacts
     * @param  mixed $id project id
     * @return boolean
     */
    public function send_project_customer_email($id, $template, $ServID = '')
    {
        $this->db->select('clientid,contact_notification,notify_contacts');
        $this->db->where('id', $id);
        $project = $this->db->get(db_prefix() . 'my_cases')->row();

        $sent     = false;

        if ($project->contact_notification == 1) {
            $contacts = $this->clients_model->get_contacts($project->clientid, ['active' => 1, 'project_emails' => 1]);
        } elseif ($project->contact_notification == 2) {
            $contacts = [];
            $contactIds = unserialize($project->notify_contacts);
            if(count($contactIds) > 0){
                $this->db->where_in('id', $contactIds);
                $this->db->where('active', 1);
                $contacts = $this->db->get(db_prefix() . 'contacts')->result_array();
            }
        } else {
            $contacts = [];
        }

        foreach ($contacts as $contact) {
            if (send_mail_template($template, $id, $project->clientid, $contact, $ServID)) {
                $sent = true;
            }
        }

        return $sent;
    }

    public function mark_as($ServID, $data, $slug)
    {
        $this->db->select('status');
        $this->db->where('id', $data['project_id']);
        $old_status = $this->db->get(db_prefix() . 'my_cases')->row()->status;

        $this->db->where('id', $data['project_id']);
        $this->db->update(db_prefix() . 'my_cases', [
            'status' => $data['status_id'],
        ]);
        if ($this->db->affected_rows() > 0) {
            hooks()->do_action('project_status_changed', [
                'status'     => $data['status_id'],
                'project_id' => $data['project_id'],
            ]);


            if ($data['status_id'] == 4) {
                $this->log_activity($data['project_id'], 'project_marked_as_finished');
                $this->db->where('id', $data['project_id']);
                $this->db->update(db_prefix() . 'my_cases', ['date_finished' => date('Y-m-d H:i:s')]);
            } else {
                $this->log_activity($data['project_id'], 'project_status_updated', '<b><lang>project_status_' . $data['status_id'] . '</lang></b>');
                if ($old_status == 4) {
                    $this->db->update(db_prefix() . 'my_cases', ['date_finished' => null]);
                }
            }

            if ($data['notify_project_members_status_change'] == 1) {
                $this->_notify_project_members_status_change($ServID, $data['project_id'], $old_status, $data['status_id']);
            }

            if ($data['mark_all_tasks_as_completed'] == 1) {
                $this->_mark_all_project_tasks_as_completed($data['project_id'], $slug);
            }

            if (isset($data['cancel_recurring_tasks']) && $data['cancel_recurring_tasks'] == 'true') {
                $this->cancel_recurring_tasks($data['project_id'], $slug);
            }

            if (isset($data['send_project_marked_as_finished_email_to_contacts'])
                && $data['send_project_marked_as_finished_email_to_contacts'] == 1) {
                $this->send_project_customer_email($data['project_id'], 'project_marked_as_finished_to_customer', $ServID); //Done Send
            }

            return true;
        }


        return false;
    }

    private function _notify_project_members_status_change($ServID , $id, $old_status, $new_status)
    {
        $members       = $this->get_project_members($id);
        $notifiedUsers = [];
        foreach ($members as $member) {
            if ($member['staff_id'] != get_staff_user_id()) {
                $notified = add_notification([
                    'fromuserid'      => get_staff_user_id(),
                    'description'     => 'not_project_status_updated',
                    'link'            => 'Case/view/'.$ServID.'/' . $id,
                    'touserid'        => $member['staff_id'],
                    'additional_data' => serialize([
                        '<lang>project_status_' . $old_status . '</lang>',
                        '<lang>project_status_' . $new_status . '</lang>',
                    ]),
                ]);
                if ($notified) {
                    array_push($notifiedUsers, $member['staff_id']);
                }
            }
        }
        pusher_trigger_notification($notifiedUsers);
    }

    private function _mark_all_project_tasks_as_completed($id, $slug)
    {
        $this->db->where('rel_type', $slug);
        $this->db->where('rel_id', $id);
        $this->db->update(db_prefix() . 'tasks', [
            'status'       => 5,
            'datefinished' => date('Y-m-d H:i:s'),
        ]);
        $tasks = $this->get_tasks($id);
        foreach ($tasks as $task) {
            $this->db->where('task_id', $task['id']);
            $this->db->where('end_time IS NULL');
            $this->db->update(db_prefix() . 'taskstimers', [
                'end_time' => time(),
            ]);
        }
        $this->log_activity($id, 'project_activity_marked_all_tasks_as_complete');
    }

    public function is_member($project_id, $staff_id = '')
    {
        if (!is_numeric($staff_id)) {
            $staff_id = get_staff_user_id();
        }
        $member = total_rows(db_prefix() . 'my_members_cases', [
            'staff_id'   => $staff_id,
            'project_id' => $project_id,
        ]);
        if ($member > 0) {
            return true;
        }

        return false;
    }

    public function get_projects_for_ticket($client_id)
    {
        return $this->get('', [
            'clientid' => $client_id,
        ]);
    }

    public function get_case_settings($project_id)
    {
        $this->db->where('case_id', $project_id);

        return $this->db->get(db_prefix() . 'case_settings')->result_array();
    }

    public function remove_team_member($ServID = '', $project_id, $staff_id)
    {
        $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
        $this->db->where('project_id', $project_id);
        $this->db->where('staff_id', $staff_id);
        $this->db->delete(db_prefix() . 'my_members_cases');
        if ($this->db->affected_rows() > 0) {

            // Remove member from tasks where is assigned
            $this->db->where('staffid', $staff_id);
            $this->db->where('taskid IN (SELECT id FROM ' . db_prefix() . 'tasks WHERE rel_type="'.$slug.'" AND rel_id="' . $project_id . '")');
            $this->db->delete(db_prefix() . 'task_assigned');

            $this->log_activity($project_id, 'project_activity_removed_team_member', get_staff_full_name($staff_id));

            return true;
        }

        return false;
    }

    public function get_timesheets($project_id, $tasks_ids = [])
    {
        if (count($tasks_ids) == 0) {
            $tasks     = $this->get_tasks($project_id);
            $tasks_ids = [];
            foreach ($tasks as $task) {
                array_push($tasks_ids, $task['id']);
            }
        }
        if (count($tasks_ids) > 0) {
            $this->db->where('task_id IN(' . implode(', ', $tasks_ids) . ')');
            $timesheets = $this->db->get(db_prefix() . 'taskstimers')->result_array();
            $i          = 0;
            foreach ($timesheets as $t) {
                $task                         = $this->tasks_model->get($t['task_id']);
                $timesheets[$i]['task_data']  = $task;
                $timesheets[$i]['staff_name'] = get_staff_full_name($t['staff_id']);
                if (!is_null($t['end_time'])) {
                    $timesheets[$i]['total_spent'] = $t['end_time'] - $t['start_time'];
                } else {
                    $timesheets[$i]['total_spent'] = time() - $t['start_time'];
                }
                $i++;
            }

            return $timesheets;
        }

        return [];
    }

    public function get_discussion($id, $project_id = '')
    {
        if ($project_id != '') {
            $this->db->where('project_id', $project_id);
        }
        $this->db->where('id', $id);
        if (is_client_logged_in()) {
            $this->db->where('show_to_customer', 1);
            $this->db->where('project_id IN (SELECT id FROM ' . db_prefix() . 'my_cases WHERE clientid=' . get_client_user_id() . ')');
        }
        $discussion = $this->db->get(db_prefix() . 'casediscussions')->row();
        if ($discussion) {
            return $discussion;
        }

        return false;
    }

    public function get_discussion_comment($id)
    {
        $this->db->where('id', $id);
        $comment = $this->db->get(db_prefix() . 'casediscussioncomments')->row();
        if ($comment->contact_id != 0) {
            if (is_client_logged_in()) {
                if ($comment->contact_id == get_contact_user_id()) {
                    $comment->created_by_current_user = true;
                } else {
                    $comment->created_by_current_user = false;
                }
            } else {
                $comment->created_by_current_user = false;
            }
            $comment->profile_picture_url = contact_profile_image_url($comment->contact_id);
        } else {
            if (is_client_logged_in()) {
                $comment->created_by_current_user = false;
            } else {
                if (is_staff_logged_in()) {
                    if ($comment->staff_id == get_staff_user_id()) {
                        $comment->created_by_current_user = true;
                    } else {
                        $comment->created_by_current_user = false;
                    }
                } else {
                    $comment->created_by_current_user = false;
                }
            }
            if (is_admin($comment->staff_id)) {
                $comment->created_by_admin = true;
            } else {
                $comment->created_by_admin = false;
            }
            $comment->profile_picture_url = staff_profile_image_url($comment->staff_id);
        }
        $comment->created = (strtotime($comment->created) * 1000);
        if (!empty($comment->modified)) {
            $comment->modified = (strtotime($comment->modified) * 1000);
        }
        if (!is_null($comment->file_name)) {
            $comment->file_url = site_url('uploads/discussions/cases/' . $comment->discussion_id . '/' . $comment->file_name);
        }

        return $comment;
    }

    public function get_discussion_comments($id, $type)
    {
        $this->db->where('discussion_id', $id);
        $this->db->where('discussion_type', $type);
        $comments             = $this->db->get(db_prefix() . 'casediscussioncomments')->result_array();
        $i                    = 0;
        $allCommentsIDS       = [];
        $allCommentsParentIDS = [];
        foreach ($comments as $comment) {
            $allCommentsIDS[] = $comment['id'];
            if (!empty($comment['parent'])) {
                $allCommentsParentIDS[] = $comment['parent'];
            }

            if ($comment['contact_id'] != 0) {
                if (is_client_logged_in()) {
                    if ($comment['contact_id'] == get_contact_user_id()) {
                        $comments[$i]['created_by_current_user'] = true;
                    } else {
                        $comments[$i]['created_by_current_user'] = false;
                    }
                } else {
                    $comments[$i]['created_by_current_user'] = false;
                }
                $comments[$i]['profile_picture_url'] = contact_profile_image_url($comment['contact_id']);
            } else {
                if (is_client_logged_in()) {
                    $comments[$i]['created_by_current_user'] = false;
                } else {
                    if (is_staff_logged_in()) {
                        if ($comment['staff_id'] == get_staff_user_id()) {
                            $comments[$i]['created_by_current_user'] = true;
                        } else {
                            $comments[$i]['created_by_current_user'] = false;
                        }
                    } else {
                        $comments[$i]['created_by_current_user'] = false;
                    }
                }
                if (is_admin($comment['staff_id'])) {
                    $comments[$i]['created_by_admin'] = true;
                } else {
                    $comments[$i]['created_by_admin'] = false;
                }
                $comments[$i]['profile_picture_url'] = staff_profile_image_url($comment['staff_id']);
            }
            if (!is_null($comment['file_name'])) {
                $comments[$i]['file_url'] = site_url('uploads/discussions/cases/' . $id . '/' . $comment['file_name']);
            }
            $comments[$i]['created'] = (strtotime($comment['created']) * 1000);
            if (!empty($comment['modified'])) {
                $comments[$i]['modified'] = (strtotime($comment['modified']) * 1000);
            }
            $i++;
        }

        // Ticket #5471
        foreach ($allCommentsParentIDS as $parent_id) {
            if (!in_array($parent_id, $allCommentsIDS)) {
                foreach ($comments as $key => $comment) {
                    if ($comment['parent'] == $parent_id) {
                        $comments[$key]['parent'] = null;
                    }
                }
            }
        }
        return $comments;
    }

    public function get_discussions($project_id)
    {
        $this->db->where('project_id', $project_id);
        if (is_client_logged_in()) {
            $this->db->where('show_to_customer', 1);
        }
        $discussions = $this->db->get(db_prefix() . 'casediscussions')->result_array();
        $i           = 0;
        foreach ($discussions as $discussion) {
            $discussions[$i]['total_comments'] = total_rows(db_prefix() . 'casediscussioncomments', [
                'discussion_id'   => $discussion['id'],
                'discussion_type' => 'regular',
            ]);
            $i++;
        }

        return $discussions;
    }

    public function add_discussion_comment($ServID = '', $data, $discussion_id, $type)
    {
        $discussion               = $this->get_discussion($discussion_id);
        $_data['discussion_id']   = $discussion_id;
        $_data['discussion_type'] = $type;
        if (isset($data['content'])) {
            $_data['content'] = $data['content'];
        }
        if (isset($data['parent']) && $data['parent'] != null) {
            $_data['parent'] = $data['parent'];
        }
        if (is_client_logged_in()) {
            $_data['contact_id'] = get_contact_user_id();
            $_data['fullname']   = get_contact_full_name($_data['contact_id']);
            $_data['staff_id']   = 0;
        } else {
            $_data['contact_id'] = 0;
            $_data['staff_id']   = get_staff_user_id();
            $_data['fullname']   = get_staff_full_name($_data['staff_id']);
        }
        $_data            = handle_case_discussion_comment_attachments($discussion_id, $data, $_data);
        $_data['created'] = date('Y-m-d H:i:s');
        $_data = hooks()->apply_filters('before_add_project_discussion_comment', $_data, $discussion_id);
        $this->db->insert(db_prefix() . 'casediscussioncomments', $_data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            if ($type == 'regular') {
                $discussion = $this->get_discussion($discussion_id);
                $not_link   = 'Case/view/' .$ServID.'/'. $discussion->project_id . '?group=project_discussions&discussion_id=' . $discussion_id;
            } else {
                $discussion                   = $this->get_file($discussion_id);
                $not_link                     = 'Case/view/' .$ServID.'/'. $discussion->project_id . '?group=project_files&file_id=' . $discussion_id;
                $discussion->show_to_customer = $discussion->visible_to_customer;
            }

            $emailTemplateData = [
                'staff' => [
                    'discussion_id'         => $discussion_id,
                    'discussion_comment_id' => $insert_id,
                    'discussion_type'       => $type,
                    'ServID'                => $ServID,
                ],
                'customers' => [
                    'customer_template'     => true,
                    'discussion_id'         => $discussion_id,
                    'discussion_comment_id' => $insert_id,
                    'discussion_type'       => $type,
                    'ServID'                => $ServID,
                ],
            ];

            if (isset($_data['file_name'])) {
                $emailTemplateData['attachments'] = [
                    [
                        'attachment' => CASE_DISCUSSION_ATTACHMENT_FOLDER . $discussion_id . '/' . $_data['file_name'],
                        'filename'   => $_data['file_name'],
                        'type'       => $_data['file_mime_type'],
                        'read'       => true,
                    ],
                ];
            }

            $notification_data = [
                'description' => 'not_commented_on_project_discussion',
                'link'        => $not_link,
            ];

            if (is_client_logged_in()) {
                $notification_data['fromclientid'] = get_contact_user_id();
            } else {
                $notification_data['fromuserid'] = get_staff_user_id();
            }

            $notifiedUsers = [];

            $regex = "/data\-mention\-id\=\"(\d+)\"/";
            if (isset($data['content']) && preg_match_all($regex, $data['content'], $mentionedStaff, PREG_PATTERN_ORDER)) {
                $members = array_unique($mentionedStaff[1], SORT_NUMERIC);
                $this->send_project_email_mentioned_users($discussion->project_id, 'project_new_discussion_comment_to_staff', $members, $emailTemplateData);

                foreach ($members as $memberId) {
                    if ($memberId == get_staff_user_id() && !is_client_logged_in()) {
                        continue;
                    }

                    $notification_data['touserid'] = $memberId;
                    if (add_notification($notification_data)) {
                        array_push($notifiedUsers, $memberId);
                    }
                }
                
            } else {
                $this->send_project_email_template($discussion->project_id, 'project_new_discussion_comment_to_staff', 'project_new_discussion_comment_to_customer', $discussion->show_to_customer, $emailTemplateData);

                $members = $this->get_project_members($discussion->project_id);
                foreach ($members as $member) {
                    if ($member['staff_id'] == get_staff_user_id() && !is_client_logged_in()) {
                        continue;
                    }
                    $notification_data['touserid'] = $member['staff_id'];
                    if (add_notification($notification_data)) {
                        array_push($notifiedUsers, $member['staff_id']);
                    }
                }
            }

            $this->log_activity($discussion->project_id, 'project_activity_commented_on_discussion', $discussion->subject, $discussion->show_to_customer);
            
            pusher_trigger_notification($notifiedUsers);

            $this->_update_discussion_last_activity($discussion_id, $type);

            hooks()->do_action('after_add_discussion_comment', $insert_id);

            return $this->get_discussion_comment($insert_id);
        }

        return false;
    }

    public function update_discussion_comment($data)
    {
        $comment = $this->get_discussion_comment($data['id']);
        $this->db->where('id', $data['id']);
        $this->db->update(db_prefix() . 'casediscussioncomments', [
            'modified' => date('Y-m-d H:i:s'),
            'content'  => $data['content'],
        ]);
        if ($this->db->affected_rows() > 0) {
            $this->_update_discussion_last_activity($comment->discussion_id, $comment->discussion_type);
        }

        return $this->get_discussion_comment($data['id']);
    }

    public function delete_discussion_comment($id, $logActivity = true)
    {
        $comment = $this->get_discussion_comment($id);
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'casediscussioncomments');
        if ($this->db->affected_rows() > 0) {
            $this->delete_discussion_comment_attachment($comment->file_name, $comment->discussion_id);
            if ($logActivity) {
                $additional_data = '';
                if ($comment->discussion_type == 'regular') {
                    $discussion = $this->get_discussion($comment->discussion_id);
                    $not        = 'project_activity_deleted_discussion_comment';
                    $additional_data .= $discussion->subject . '<br />' . $comment->content;
                } else {
                    $discussion = $this->get_file($comment->discussion_id);
                    $not        = 'project_activity_deleted_file_discussion_comment';
                    $additional_data .= $discussion->subject . '<br />' . $comment->content;
                }

                if (!is_null($comment->file_name)) {
                    $additional_data .= $comment->file_name;
                }

                $this->log_activity($discussion->project_id, $not, $additional_data);
            }
        }

        $this->db->where('parent', $id);
        $this->db->update(db_prefix() . 'casediscussioncomments', [
            'parent' => null,
        ]);

        if ($this->db->affected_rows() > 0 && $logActivity) {
            $this->_update_discussion_last_activity($comment->discussion_id, $comment->discussion_type);
        }

        return true;
    }

    public function delete_discussion_comment_attachment($file_name, $discussion_id)
    {
        $path = CASE_DISCUSSION_ATTACHMENT_FOLDER . $discussion_id;
        if (!is_null($file_name)) {
            if (file_exists($path . '/' . $file_name)) {
                unlink($path . '/' . $file_name);
            }
        }
        if (is_dir($path)) {
            // Check if no attachments left, so we can delete the folder also
            $other_attachments = list_files($path);
            if (count($other_attachments) == 0) {
                delete_dir($path);
            }
        }
    }

    public function add_discussion($data, $ServID)
    {
        if (is_client_logged_in()) {
            $data['contact_id']       = get_contact_user_id();
            $data['staff_id']         = 0;
            $data['show_to_customer'] = 1;
        } else {
            $data['staff_id']   = get_staff_user_id();
            $data['contact_id'] = 0;
            if (isset($data['show_to_customer'])) {
                $data['show_to_customer'] = 1;
            } else {
                $data['show_to_customer'] = 0;
            }
        }
        $data['datecreated'] = date('Y-m-d H:i:s');
        $data['description'] = nl2br($data['description']);
        $this->db->insert(db_prefix() . 'casediscussions', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $members           = $this->get_project_members($data['project_id']);
            $notification_data = [
                'description' => 'not_created_new_project_discussion',
                'link'        => 'Case/view/'. $ServID.'/'. $data['project_id'] . '?group=project_discussions&discussion_id=' . $insert_id,
            ];

            if (is_client_logged_in()) {
                $notification_data['fromclientid'] = get_contact_user_id();
            } else {
                $notification_data['fromuserid'] = get_staff_user_id();
            }

            $notifiedUsers = [];
            foreach ($members as $member) {
                if ($member['staff_id'] == get_staff_user_id() && !is_client_logged_in()) {
                    continue;
                }
                $notification_data['touserid'] = $member['staff_id'];
                if (add_notification($notification_data)) {
                    array_push($notifiedUsers, $member['staff_id']);
                }
            }
            pusher_trigger_notification($notifiedUsers);
            $this->send_project_email_template($data['project_id'], 'project_discussion_created_to_staff', 'project_discussion_created_to_customer', $data['show_to_customer'], [
                'staff' => [
                    'discussion_id'   => $insert_id,
                    'discussion_type' => 'regular',
                    'ServID'          => $ServID,
                ],
                'customers' => [
                    'customer_template' => true,
                    'discussion_id'     => $insert_id,
                    'discussion_type'   => 'regular',
                    'ServID'            => $ServID,
                ],
            ]);
            $this->log_activity($data['project_id'], 'project_activity_created_discussion', $data['subject'], $data['show_to_customer']);

            return $insert_id;
        }

        return false;
    }

    public function edit_discussion($data, $id)
    {
        $this->db->where('id', $id);
        if (isset($data['show_to_customer'])) {
            $data['show_to_customer'] = 1;
        } else {
            $data['show_to_customer'] = 0;
        }
        $data['description'] = nl2br($data['description']);
        $this->db->update(db_prefix() . 'casediscussions', $data);
        if ($this->db->affected_rows() > 0) {
            $this->log_activity($data['project_id'], 'project_activity_updated_discussion', $data['subject'], $data['show_to_customer']);

            return true;
        }

        return false;
    }

    public function delete_discussion($id, $logActivity = true)
    {
        $discussion = $this->get_discussion($id);
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'casediscussions');
        if ($this->db->affected_rows() > 0) {
            if ($logActivity) {
                $this->log_activity($discussion->project_id, 'project_activity_deleted_discussion', $discussion->subject, $discussion->show_to_customer);
            }
            $this->_delete_discussion_comments($id, 'regular');

            return true;
        }

        return false;
    }

    public function copy($ServID,$project_id, $data)
    {
        $slug      = $this->legal->get_service_by_id($ServID)->row()->slug;
        $project   = $this->get($project_id);
        $settings  = $this->get_case_settings($project_id);
        $_new_data = [];
        $fields    = $this->db->list_fields(db_prefix() . 'my_cases');
        foreach ($fields as $field) {
            if (isset($project->$field)) {
                $_new_data[$field] = $project->$field;
            }
        }

        unset($_new_data['id']);
        $_new_data['clientid'] = $data['clientid_copy_project'];
        unset($_new_data['clientid_copy_project']);

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

        if ($project->contact_notification == 2) {
            $contacts = $this->clients_model->get_contacts($_new_data['clientid'], ['active' => 1, 'project_emails' => 1]);
            $_new_data['notify_contacts'] = serialize(array_column($contacts, 'id'));
        }

        $this->db->insert(db_prefix() . 'my_cases', $_new_data);
        $id = $this->db->insert_id();
        if ($id) {
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
            $tasks       = $this->get_tasks($project_id);
            if (isset($data['tasks'])) {
                foreach ($tasks as $task) {
                    if (isset($data['task_include_followers'])) {
                        $copy_task_data['copy_task_followers'] = 'true';
                    }
                    if (isset($data['task_include_assignees'])) {
                        $copy_task_data['copy_task_assignees'] = 'true';
                    }
                    if (isset($data['tasks_include_checklist_items'])) {
                        $copy_task_data['copy_task_checklist_items'] = 'true';
                    }
                    $copy_task_data['copy_from'] = $task['id'];
                     // For new task start date, we will find the difference in days between
                    // the old project start and and the old task start date and then
                    // based on the new project start date, we will add e.q. 15 days to be
                    // new task start date to the task
                    // e.q. old project start date 2020-04-01, old task start date 2020-04-15 and due date 2020-04-30
                    // copy project and set start date 2020-06-01
                    // new task start date will be 2020-06-15 and below due date 2020-06-30
                    $dStart    = new DateTime($project->start_date);
                    $dEnd      = new DateTime($task['startdate']);
                    $dDiff     = $dStart->diff($dEnd);
                    $startDate = new DateTime($_new_data['start_date']);
                    $startDate->modify('+' . $dDiff->days . ' DAY');
                    $newTaskStartDate = $startDate->format('Y-m-d');

                    $merge = [
                        'rel_id'              => $id,
                        'rel_type'            => $slug,
                        'last_recurring_date' => null,
                        'startdate'           => $newTaskStartDate,
                        'status'              => $data['copy_project_task_status'],
                    ];

                    // Calculate the diff in days between the task start and due date
                    // then add these days to the new task start date to be used as this task due date
                    if ($task['duedate']) {
                        $dStart  = new DateTime($task['startdate']);
                        $dEnd    = new DateTime($task['duedate']);
                        $dDiff   = $dStart->diff($dEnd);
                        $dueDate = new DateTime($newTaskStartDate);
                        $dueDate->modify('+' . $dDiff->days . ' DAY');
                        $merge['duedate'] = $dueDate->format('Y-m-d');
                    }

                    $task_id = $this->tasks_model->copy($copy_task_data, $merge);

                    if ($task_id) {
                        array_push($added_tasks, $task_id);
                    }
                }
            }
            if (isset($data['milestones'])) {
                $milestones        = $this->get_milestones($slug, $project_id);
                $_added_milestones = [];
                foreach ($milestones as $milestone) {
                    $oldProjectStartDate = new DateTime($project->start_date);
                    $dDuedate            = new DateTime($milestone['due_date']);
                    $dDiff               = $oldProjectStartDate->diff($dDuedate);

                    $newProjectStartDate = new DateTime($_new_data['start_date']);
                    $newProjectStartDate->modify('+' . $dDiff->days . ' DAY');
                    $newMilestoneDueDate = $newProjectStartDate->format('Y-m-d');

                    $this->db->insert(db_prefix() . 'milestones', [
                        'name'                            => $milestone['name'],
                        'project_id'                      => $id,
                        'milestone_order'                 => $milestone['milestone_order'],
                        'description_visible_to_customer' => $milestone['description_visible_to_customer'],
                        'description'                     => $milestone['description'],
                        'due_date'                        => $newMilestoneDueDate,
                        'datecreated'                     => date('Y-m-d'),
                        'color'                           => $milestone['color'],
                    ]);

                    $milestone_id = $this->db->insert_id();
                    if ($milestone_id) {
                        $_added_milestone_data         = [];
                        $_added_milestone_data['id']   = $milestone_id;
                        $_added_milestone_data['name'] = $milestone['name'];
                        $_added_milestones[]           = $_added_milestone_data;
                    }
                }
                if (isset($data['tasks'])) {
                    if (count($added_tasks) > 0) {
                        // Original project tasks
                        foreach ($tasks as $task) {
                            if ($task['milestone'] != 0) {
                                $this->db->where('id', $task['milestone']);
                                $milestone = $this->db->get(db_prefix() . 'milestones')->row();
                                if ($milestone) {
                                    $name = $milestone->name;
                                    foreach ($_added_milestones as $added_milestone) {
                                        if ($name == $added_milestone['name']) {
                                            $this->db->where('id IN (' . implode(', ', $added_tasks) . ')');
                                            $this->db->where('milestone', $task['milestone']);
                                            $this->db->update(db_prefix() . 'tasks', [
                                                'milestone' => $added_milestone['id'],
                                            ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                // milestones not set
                if (count($added_tasks)) {
                    foreach ($added_tasks as $task) {
                        $this->db->where('id', $task['id']);
                        $this->db->update(db_prefix() . 'tasks', [
                            'milestone' => 0,
                        ]);
                    }
                }
            }
            if (isset($data['members'])) {
                $members  = $this->get_project_members($project_id);
                $_members = [];
                foreach ($members as $member) {
                    array_push($_members, $member['staff_id']);
                }
                $this->add_edit_members([
                    'project_members' => $_members,
                ],$ServID, $id);
            }

            $custom_fields = get_custom_fields($slug);
            foreach ($custom_fields as $field) {
                $value = get_custom_field_value($project_id, $field['id'], $slug, false);
                if ($value != '') {
                    $this->db->insert(db_prefix() . 'customfieldsvalues', [
                        'relid'   => $id,
                        'fieldid' => $field['id'],
                        'fieldto' => $slug,
                        'value'   => $value,
                    ]);
                }
            }

            $this->log_activity($id, 'LService_activity_created');
            log_activity('Case Copied [ID: ' . $project_id . ', NewID: ' . $id . ']');

            return $id;
        }

        return false;
    }

    public function get_linked_services($ServID, $id)
    {
        $father_linked_services = [];
        $this->db->select('*');
        $this->db->select(db_prefix() . 'my_link_services.service_id as l_service_id');
        $this->db->where([db_prefix() . 'my_link_services.service_id' => $ServID, 'rel_id' => $id]);
        $this->db->join(db_prefix() . 'my_other_services', db_prefix() . 'my_other_services.id=' . db_prefix() . 'my_link_services.to_rel_id' .' AND '.db_prefix() . 'my_other_services.service_id='.db_prefix() . 'my_link_services.to_service_id AND '.db_prefix() . 'my_other_services.deleted = 0', 'left');
        $father_linked_services = $this->db->get(db_prefix() . 'my_link_services')->result();

        $this->db->select('*');
        $this->db->select(db_prefix() . 'my_link_services.service_id as l_service_id');
        $this->db->where([db_prefix() . 'my_link_services.service_id' => $ServID, 'rel_id' => $id]);
        $this->db->join(db_prefix() . 'my_cases', db_prefix() . 'my_cases.id=' . db_prefix() . 'my_link_services.to_rel_id AND '.db_prefix() . 'my_cases.deleted = 0 AND '.db_prefix() . 'my_link_services.to_service_id = 1', 'inner');
        $cases = $this->db->get(db_prefix() . 'my_link_services')->result();
         foreach ($cases as $key => $case) {
             $cases[$key]->l_service_id = "1";
         }

        // $father_linked_services = [
        //         ...$father_linked_services,
        //         ...$cases
        // ];
        $father_linked_services = array_merge($father_linked_services, $cases);

        $this->db->select('*');
        $this->db->select(db_prefix() . 'my_link_services.service_id as l_service_id');
        $this->db->where([db_prefix() . 'my_link_services.service_id' => $ServID, 'rel_id' => $id]);
        $this->db->join(db_prefix() . 'my_disputes_cases', db_prefix() . 'my_disputes_cases.id=' . db_prefix() . 'my_link_services.to_rel_id AND '.db_prefix() . 'my_disputes_cases.deleted = 0 AND '.db_prefix() . 'my_link_services.to_service_id = 22', 'inner');
        $disputes_cases = $this->db->get(db_prefix() . 'my_link_services')->result();
        foreach ($disputes_cases as $key => $case) {
            $disputes_cases[$key]->l_service_id = "1";
        }

        // $father_linked_services = [
        //         ...$father_linked_services,
        //         ...$cases
        // ];
        $father_linked_services = array_merge($father_linked_services, $disputes_cases);

        $this->db->select('*');
        $this->db->select(db_prefix() . 'my_link_services.service_id as l_service_id');
        $this->db->where([db_prefix() . 'my_link_services.to_service_id' => $ServID, 'to_rel_id' => $id]);
        $this->db->join(db_prefix() . 'my_other_services', db_prefix() . 'my_other_services.id=' . db_prefix() . 'my_link_services.to_rel_id' .' AND '.db_prefix() . 'my_other_services.service_id='.db_prefix() . 'my_link_services.to_service_id AND '.db_prefix() . 'my_other_services.deleted = 0', 'left');
        $child_linked_services = $this->db->get(db_prefix() . 'my_link_services')->result();

        $this->db->select('*');
        $this->db->select(db_prefix() . 'my_link_services.service_id as l_service_id');
        $this->db->where([db_prefix() . 'my_link_services.to_service_id' => $ServID, 'to_rel_id' => $id]);
        $this->db->join(db_prefix() . 'my_cases', db_prefix() . 'my_cases.id=' . db_prefix() . 'my_link_services.to_rel_id' .' AND '.db_prefix() . 'my_link_services.to_service_id=1 AND '.db_prefix() . 'my_cases.deleted = 0', 'inner');
        // $child_linked_services = [
        //     ...$child_linked_services,
        //     ...$this->db->get(db_prefix() . 'my_link_services')->result()
        // ];
        $child_linked_services = array_merge($child_linked_services, $this->db->get(db_prefix() . 'my_link_services')->result());
        // return $linked_services = [
        //         ...$father_linked_services,
        //         ...$child_linked_services
        // ];

        $this->db->select('*');
        $this->db->select(db_prefix() . 'my_link_services.service_id as l_service_id');
        $this->db->where([db_prefix() . 'my_link_services.to_service_id' => $ServID, 'to_rel_id' => $id]);
        $this->db->join(db_prefix() . 'my_disputes_cases', db_prefix() . 'my_disputes_cases.id=' . db_prefix() . 'my_link_services.to_rel_id' .' AND '.db_prefix() . 'my_link_services.to_service_id=22 AND '.db_prefix() . 'my_disputes_cases.deleted = 0', 'inner');
        $child_linked_services = array_merge($child_linked_services, $this->db->get(db_prefix() . 'my_link_services')->result());

        return $linked_services = array_merge($father_linked_services, $child_linked_services);
    }

    public function link($ServID,$project_id, $data, $ServID2)
    {
        $slug      = $this->legal->get_service_by_id($ServID)->row()->slug;
        $slug2      = $this->legal->get_service_by_id($ServID2)->row()->slug;
        $mark_as_data = [
            'status_id' => 4,
            'project_id' => $project_id,
            'send_project_marked_as_finished_email_to_contacts' => 0,
            'mark_all_tasks_as_completed' => 1,
            'cancel_recurring_tasks' => false,
            'notify_project_members_status_change' => 0
        ];

            if (has_permission('projects', '', 'create') || has_permission('projects', '', 'edit')) {
                $status = get_case_status_by_id($mark_as_data['status_id']);

                $message = _l('project_marked_as_failed', $status['name']);
                $success = $this->mark_as($ServID, $mark_as_data, $slug);

                if ($success) {
                    $message = _l('project_marked_as_success', $status['name']);
                }
            }

        $project   = $this->get($project_id);
        $settings  = $this->get_case_settings($project_id);
        $_new_data = [];
        $fields    = $this->db->list_fields(db_prefix() . 'my_cases');
        foreach ($fields as $field) {
            if (isset($project->$field)) {
                $_new_data[$field] = $project->$field;
            }
        }

        if($ServID2 == 1) {
            $service_table = db_prefix() . 'my_cases';
            $settings_table = db_prefix() . 'case_settings';
            $setting_id = 'case_id';
            $upload_folder = 'cases';
            $files_table = db_prefix() . 'case_files';
            $files_id = 'project_id';
        } elseif ($ServID2 == 22){
            $service_table = db_prefix() . 'my_disputes_cases';
            $settings_table = db_prefix() . 'my_disputes_case_settings';
            $setting_id = 'case_id';
            $upload_folder = 'disputes_cases';
            $files_table = db_prefix() . 'my_disputes_case_files';
            $files_id = 'project_id';
            $opponents = $_new_data['opponent_id'];
            unset($_new_data['opponent_id']);
            unset($_new_data['case_status']);
            unset($_new_data['billing_type']);
            unset($_new_data['duration_id']);
            unset($_new_data['regular_duration_begin_date']);
            unset($_new_data['deadline_notified']);
            unset($_new_data['regular_header']);

        }else {
            $service_table = db_prefix() . 'my_other_services';
            $settings_table = db_prefix() . 'oservice_settings';
            $setting_id = 'oservice_id';
            $_new_data['service_id'] = $ServID2;
            $upload_folder = 'oservices';
            $files_table = db_prefix() . 'oservice_files';
            $files_id = 'oservice_id';
            unset($_new_data['opponent_id']);
            unset($_new_data['representative']);
            unset($_new_data['court_id']);
            unset($_new_data['childsubcat_id']);//////
            unset($_new_data['jud_num']);
            unset($_new_data['case_status']);
            unset($_new_data['case_result']);
            unset($_new_data['file_number_case']);
            unset($_new_data['file_number_court']);
            unset($_new_data['previous_case_id']);
            unset($_new_data['duration_id']);
            unset($_new_data['regular_duration_begin_date']);
            unset($_new_data['deadline_notified']);
            unset($_new_data['regular_header']);
        }

        unset($_new_data['id']);
        $_new_data['clientid'] = $data['clientid_copy_project'];
        unset($_new_data['clientid_copy_project']);

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

        $this->db->insert($service_table, $_new_data);
        $id = $this->db->insert_id();
        if ($id) {
            if(isset($data['files'])){
                $files = $this->get_files($project_id);
                if(!file_exists('uploads/'.$upload_folder)){
                    mkdir(FCPATH.'uploads/'.$upload_folder, 0755);
                }
                if(!file_exists('uploads/'.$upload_folder.'/'.$id)){
                        mkdir(FCPATH.'uploads/'.$upload_folder.'/'.$id, 0755);
                }
                foreach ($files as $key => $value) {
                    $file_url = base_url().'uploads/cases/'.$project_id.'/'.$value['file_name'];
                    $file_content = file_get_contents(str_replace(' ', '%20', $file_url));
                    $myFile = fopen(FCPATH.'uploads/'.$upload_folder.'/'.$id.'/'.$value['file_name'], 'w', true);

                    file_put_contents(FCPATH.'uploads/'.$upload_folder.'/'.$id.'/'.$value['file_name'], $file_content);
                    $file_data = [
                        'file_name' => $value['file_name'],
                        'subject' => $value['subject'],
                        'description' => isset($value['description']) ? $value['description'] : '',
                        'filetype' => $value['filetype'],
                        'dateadded' => $value['dateadded'],
                        'last_activity' => isset($value['last_activity']) ? $value['last_activity'] : '',
                        $files_id => $id,
                        'visible_to_customer' => 0,   //$value['visible_to_customer'],
                        'last_activity' => null,
                        'staffid' => get_staff_user_id(),    //$value['staffid'],
                        'contact_id' => 0,   //$value['contact_id'],
                        'external' => isset($value['external']) ? $value['external'] : '',
                        'external_link' => isset($value['external_link']) ? $value['external_link'] : '',
                        'file_name' => isset($value['file_name']) ? $value['file_name'] : '',
                    ];
                    $this->db->insert($files_table, $file_data);

                }
            }   
            $tags = get_tags_in($project_id, $slug);
            handle_tags_save($tags, $id, $slug);

            foreach ($settings as $setting) {
                $this->db->insert($settings_table, [
                    $setting_id => $id,
                    'name' => $setting['name'],
                    'value' => $setting['value'],
                ]);
            }
            $added_tasks = [];
                $tasks       = $this->get_tasks($project_id);
            if (isset($data['tasks'])) {
                foreach ($tasks as $task) {
                    if (isset($data['task_include_followers'])) {
                        $copy_task_data['copy_task_followers'] = 'true';
                    }
                    if (isset($data['task_include_assignees'])) {
                        $copy_task_data['copy_task_assignees'] = 'true';
                    }
                    if (isset($data['tasks_include_checklist_items'])) {
                        $copy_task_data['copy_task_checklist_items'] = 'true';
                    }
                    $copy_task_data['copy_from'] = $task['id'];
                     // For new task start date, we will find the difference in days between
                    // the old project start and and the old task start date and then
                    // based on the new project start date, we will add e.q. 15 days to be
                    // new task start date to the task
                    // e.q. old project start date 2020-04-01, old task start date 2020-04-15 and due date 2020-04-30
                    // copy project and set start date 2020-06-01
                    // new task start date will be 2020-06-15 and below due date 2020-06-30
                    $dStart    = new DateTime($project->start_date);
                    $dEnd      = new DateTime($task['startdate']);
                    $dDiff     = $dStart->diff($dEnd);
                    $startDate = new DateTime($_new_data['start_date']);
                    $startDate->modify('+' . $dDiff->days . ' DAY');
                    $newTaskStartDate = $startDate->format('Y-m-d');

                    $merge = [
                        'rel_id'              => $id,
                        'rel_type'            => $slug2,
                        'last_recurring_date' => null,
                        'startdate'           => $newTaskStartDate,
                        'status'              => $data['copy_project_task_status'],
                    ];

                    // Calculate the diff in days between the task start and due date
                    // then add these days to the new task start date to be used as this task due date
                    if ($task['duedate']) {
                        $dStart  = new DateTime($task['startdate']);
                        $dEnd    = new DateTime($task['duedate']);
                        $dDiff   = $dStart->diff($dEnd);
                        $dueDate = new DateTime($newTaskStartDate);
                        $dueDate->modify('+' . $dDiff->days . ' DAY');
                        $merge['duedate'] = $dueDate->format('Y-m-d');
                    }

                    $task_id = $this->tasks_model->copy($copy_task_data, $merge);

                    if ($task_id) {
                        array_push($added_tasks, $task_id);
                    }
                }
            }
            if (isset($data['milestones'])) {
                $milestones        = $this->get_milestones($slug, $project_id);
                $_added_milestones = [];
                foreach ($milestones as $milestone) {
                    $dCreated = new DateTime($milestone['datecreated']);
                    $dDuedate = new DateTime($milestone['due_date']);
                    $dDiff    = $dCreated->diff($dDuedate);
                    $due_date = date('Y-m-d', strtotime(date('Y-m-d', strtotime('+' . $dDiff->days . 'DAY'))));

                    $milestone_data = $milestone_data = $ServID2 != 1 ? [
                        'name' => $milestone['name'],
                        'rel_sid' => $id,
                        'rel_stype' => $slug,
                        'milestone_order' => $milestone['milestone_order'],
                        'description_visible_to_customer' => $milestone['description_visible_to_customer'],
                        'description' => $milestone['description'],
                        'due_date' => $due_date,
                        'datecreated' => date('Y-m-d'),
                        'color' => $milestone['color'],
                    ] : [
                        'name'                            => $milestone['name'],
                        'project_id'                      => $id,
                        'milestone_order'                 => $milestone['milestone_order'],
                        'description_visible_to_customer' => $milestone['description_visible_to_customer'],
                        'description'                     => $milestone['description'],
                        'due_date'                        => $due_date,
                        'datecreated'                     => date('Y-m-d'),
                        'color'                           => $milestone['color'],
                    ];

                    $this->db->insert(db_prefix() . 'milestones', $milestone_data);

                    $milestone_id = $this->db->insert_id();
                    if ($milestone_id) {
                        $_added_milestone_data         = [];
                        $_added_milestone_data['id']   = $milestone_id;
                        $_added_milestone_data['name'] = $milestone['name'];
                        $_added_milestones[]           = $_added_milestone_data;
                    }
                }
                if (isset($data['tasks'])) {
                    if (count($added_tasks) > 0) {
                        // Original project tasks
                        foreach ($tasks as $task) {
                            if ($task['milestone'] != 0) {
                                $this->db->where('id', $task['milestone']);
                                $milestone = $this->db->get(db_prefix() . 'milestones')->row();
                                if ($milestone) {
                                    $name = $milestone->name;
                                    foreach ($_added_milestones as $added_milestone) {
                                        if ($name == $added_milestone['name']) {
                                            $this->db->where('id IN (' . implode(', ', $added_tasks) . ')');
                                            $this->db->where('milestone', $task['milestone']);
                                            $this->db->update(db_prefix() . 'tasks', [
                                                'milestone' => $added_milestone['id'],
                                            ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                // milestones not set
                if (count($added_tasks)) {
                    foreach ($added_tasks as $task) {
                        $this->db->where('id', $task['id']);
                        $this->db->update(db_prefix() . 'tasks', [
                            'milestone' => 0,
                        ]);
                    }
                }
            }
            if (isset($data['members'])) {
                $members  = $this->get_project_members($project_id);
                $_members = [];
                foreach ($members as $member) {
                    array_push($_members, $member['staff_id']);
                }
                if($ServID2 == 1){
                    $this->add_edit_members([
                    'project_members' => $_members,
                    ], $ServID,$id);
                }elseif($ServID2 == 22){
                    $this->add_disputes_cases_members([
                        'project_members' => $_members,
                    ],$ServID, $id);

                }else{
                    $this->add_edit_oservices_members([
                    'project_members' => $_members,
                    ],$ServID, $id);
                }
                
            }

            $custom_fields = get_custom_fields($slug);
            foreach ($custom_fields as $field) {
                $value = get_custom_field_value($project_id, $field['id'], $slug, false);
                if ($value != '') {
                    $this->db->insert(db_prefix() . 'customfieldsvalues', [
                        'relid'   => $id,
                        'fieldid' => $field['id'],
                        'fieldto' => $slug,
                        'value'   => $value,
                    ]);
                }
            }

            if ($ServID2 == 22){
                if(isset($opponents)){
                    $this->db->insert(db_prefix() . 'my_disputes_cases_opponents', [
                        'case_id'  => $id,
                        'opponent_id' => $opponents,
                    ]);
                }
                $cases_judges = $this->get_case_judges($project_id);
                if (isset($cases_judges)) {
                    foreach ($cases_judges as $case_judge) {
                        $this->db->insert(db_prefix() . 'my_disputes_cases_judges', [
                            'case_id'  => $id,
                            'judge_id' => $case_judge['judge_id'],
                        ]);
                    }
                }
            }

            $this->db->insert(db_prefix() . 'my_link_services', [
                'rel_id' => $project_id,
                'service_id' => $ServID,
                'to_rel_id' => $id,
                'to_service_id' => $ServID2
            ]);

            $this->log_activity($id, 'LService_activity_created');
            log_activity('Case Copied [ID: ' . $project_id . ', NewID: ' . $id . ']');

            return $id;
        }

        return false;
    }

    public function get_staff_notes($project_id)
    {
        $this->db->where('project_id', $project_id);
        $this->db->where('staff_id', get_staff_user_id());
        $notes = $this->db->get(db_prefix() . 'case_notes')->row();
        if ($notes) {
            return $notes->content;
        }

        return '';
    }

    public function save_note($data, $project_id)
    {
        // Check if the note exists for this project;
        $this->db->where('project_id', $project_id);
        $this->db->where('staff_id', get_staff_user_id());
        $notes = $this->db->get(db_prefix() . 'case_notes')->row();
        if ($notes) {
            $this->db->where('id', $notes->id);
            $this->db->update(db_prefix() . 'case_notes', [
                'content' => $data['content'],
            ]);
            if ($this->db->affected_rows() > 0) {
                return true;
            }

            return false;
        }
        $this->db->insert(db_prefix() . 'case_notes', [
            'staff_id'   => get_staff_user_id(),
            'content'    => $data['content'],
            'project_id' => $project_id,
        ]);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            return true;
        }

        return false;


        return false;
    }

    public function get_activity($id = '', $limit = '', $only_project_members_activity = false)
    {
        if (!is_client_logged_in()) {
            $has_permission = has_permission('projects', '', 'view');
            if (!$has_permission) {
                $this->db->where('project_id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . get_staff_user_id() . ')');
            }
        }
        if (is_client_logged_in()) {
            $this->db->where('visible_to_customer', 1);
        }
        if (is_numeric($id)) {
            $this->db->where('project_id', $id);
        }
        if (is_numeric($limit)) {
            $this->db->limit($limit);
        }
        $this->db->order_by('dateadded', 'desc');
        $activities = $this->db->get(db_prefix() . 'case_activity')->result_array();
        $i          = 0;
        foreach ($activities as $activity) {
            $seconds          = get_string_between($activity['additional_data'], '<seconds>', '</seconds>');
            $other_lang_keys  = get_string_between($activity['additional_data'], '<lang>', '</lang>');
            $_additional_data = $activity['additional_data'];
            if ($seconds != '') {
                $_additional_data = str_replace('<seconds>' . $seconds . '</seconds>', seconds_to_time_format($seconds), $_additional_data);
            }
            if ($other_lang_keys != '') {
                $_additional_data = str_replace('<lang>' . $other_lang_keys . '</lang>', _l($other_lang_keys), $_additional_data);
            }
            if (strpos($_additional_data, 'project_status_') !== false) {
                $_additional_data = get_case_status_by_id(strafter($_additional_data, 'project_status_'));

                if (isset($_additional_data['name'])) {
                    $_additional_data = $_additional_data['name'];
                }
            }
            $activities[$i]['description']     = _l($activities[$i]['description_key']);
            $activities[$i]['additional_data'] = $_additional_data;
            $activities[$i]['project_name']    = get_case_name_by_id($activity['project_id']);
            unset($activities[$i]['description_key']);
            $i++;
        }

        return $activities;
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

    public function new_project_file_notification($ServID = '1', $file_id, $project_id)
    {
        $file = $this->get_file($file_id);

        $additional_data = $file->file_name;
        $this->log_activity($project_id, 'LService_activity_uploaded_file', $additional_data, $file->visible_to_customer);

        $members           = $this->get_project_members($project_id);
        $notification_data = [
            'description' => 'not_project_file_uploaded',
            'link'        => 'Case/view/' .$ServID. '/' . $project_id . '?group=project_files&file_id=' . $file_id,
        ];

        if (is_client_logged_in()) {
            $notification_data['fromclientid'] = get_contact_user_id();
        } else {
            $notification_data['fromuserid'] = get_staff_user_id();
        }

        $notifiedUsers = [];
        foreach ($members as $member) {
            if ($member['staff_id'] == get_staff_user_id() && !is_client_logged_in()) {
                continue;
            }
            $notification_data['touserid'] = $member['staff_id'];
            if (add_notification($notification_data)) {
                array_push($notifiedUsers, $member['staff_id']);
            }
        }
        pusher_trigger_notification($notifiedUsers);

        $this->send_project_email_template(
            $project_id,
            'project_file_to_staff',
            'project_file_to_customer',
            $file->visible_to_customer,
            [
                'staff'     => ['discussion_id' => $file_id, 'discussion_type' => 'file', 'ServID' => $ServID],
                'customers' => ['customer_template' => true, 'discussion_id' => $file_id, 'discussion_type' => 'file', 'ServID' => $ServID],
            ]
        );
    }

    public function add_external_file($data)
    {
        $insert['dateadded']           = date('Y-m-d H:i:s');
        $insert['project_id']          = $data['project_id'];
        $insert['external']            = $data['external'];
        $insert['visible_to_customer'] = $data['visible_to_customer'];
        $insert['file_name']           = $data['files'][0]['name'];
        $insert['subject']             = $data['files'][0]['name'];
        $insert['external_link']       = $data['files'][0]['link'];

        $path_parts         = pathinfo($data['files'][0]['name']);
        $insert['filetype'] = get_mime_by_extension('.' . $path_parts['extension']);

        if (isset($data['files'][0]['thumbnailLink'])) {
            $insert['thumbnail_link'] = $data['files'][0]['thumbnailLink'];
        }

        if (isset($data['staffid'])) {
            $insert['staffid'] = $data['staffid'];
        } elseif (isset($data['contact_id'])) {
            $insert['contact_id'] = $data['contact_id'];
        }

        $this->db->insert(db_prefix() . 'case_files', $insert);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $this->new_project_file_notification(1,$insert_id, $data['project_id']);

            return $insert_id;
        }

        return false;
    }

    public function send_project_email_template($project_id, $staff_template, $customer_template, $action_visible_to_customer, $additional_data = [])
    {
        if (count($additional_data) == 0) {
            $additional_data['customers'] = [];
            $additional_data['staff']     = [];
        } elseif (count($additional_data) == 1) {
            if (!isset($additional_data['staff'])) {
                $additional_data['staff'] = [];
            } else {
                $additional_data['customers'] = [];
            }
        }

        $project = $this->get($project_id);
        $members = $this->get_project_members($project_id);

        foreach ($members as $member) {
            if (is_staff_logged_in() && $member['staff_id'] == get_staff_user_id()) {
                continue;
            }
            $mailTemplate = mail_template($staff_template, $project, $member, $additional_data['staff']);
            if (isset($additional_data['attachments'])) {
                foreach ($additional_data['attachments'] as $attachment) {
                    $mailTemplate->add_attachment($attachment);
                }
            }
            $mailTemplate->send();
        }
        if ($action_visible_to_customer == 1) {
            if ($project->contact_notification == 1) {
                $contacts = $this->clients_model->get_contacts($project->clientid, ['active' => 1, 'project_emails' => 1]);
            } elseif ($project->contact_notification == 2) {
                $contacts = [];
                $contactIds = unserialize($project->notify_contacts);
                if(count($contactIds) > 0){
                    $this->db->where_in('id', $contactIds);
                    $this->db->where('active', 1);
                    $contacts = $this->db->get(db_prefix() . 'contacts')->result_array();
                }
            } else {
                $contacts = [];
            }

            foreach ($contacts as $contact) {
                if (is_client_logged_in() && $contact['id'] == get_contact_user_id()) {
                    continue;
                }
                $mailTemplate = mail_template($customer_template, $project, $contact, $additional_data['customers']);
                if (isset($additional_data['attachments'])) {
                    foreach ($additional_data['attachments'] as $attachment) {
                        $mailTemplate->add_attachment($attachment);
                    }
                }
                $mailTemplate->send();
            }
        }
    }

    private function _get_project_billing_data($id)
    {
        $this->db->select('billing_type,project_rate_per_hour');
        $this->db->where('id', $id);

        return $this->db->get(db_prefix() . 'my_cases')->row();
    }

    public function total_logged_time_by_billing_type($slug = '', $id, $conditions = [])
    {
        $project_data = $this->_get_project_billing_data($id);
        $data         = [];
        if ($project_data->billing_type == 2) {
            $seconds             = $this->total_logged_time($slug, $id);
            $data                = $this->calculate_total_by_project_hourly_rate($seconds, $project_data->project_rate_per_hour);
            $data['logged_time'] = $data['hours'];
        } elseif ($project_data->billing_type == 3) {
            $data = $this->_get_data_total_logged_time($slug, $id);
        }

        return $data;
    }

    public function data_billable_time($slug, $id)
    {
        return $this->_get_data_total_logged_time($slug, $id, [
            'billable' => 1,
        ]);
    }

    public function data_billed_time($slug, $id)
    {
        return $this->_get_data_total_logged_time($slug, $id, [
            'billable' => 1,
            'billed'   => 1,
        ]);
    }

    public function data_unbilled_time($slug, $id)
    {
        return $this->_get_data_total_logged_time($slug, $id, [
            'billable' => 1,
            'billed'   => 0,
        ]);
    }

    private function _delete_discussion_comments($id, $type)
    {
        $this->db->where('discussion_id', $id);
        $this->db->where('discussion_type', $type);
        $comments = $this->db->get(db_prefix() . 'casediscussioncomments')->result_array();
        foreach ($comments as $comment) {
            $this->delete_discussion_comment_attachment($comment['file_name'], $id);
        }
        $this->db->where('discussion_id', $id);
        $this->db->where('discussion_type', $type);
        $this->db->delete(db_prefix() . 'casediscussioncomments');
    }

    private function _get_data_total_logged_time($slug = '', $id, $conditions = [])
    {
        $project_data = $this->_get_project_billing_data($id);
        $tasks        = $this->get_tasks($id, $conditions);

        if ($project_data->billing_type == 3) {
            $data                = $this->calculate_total_by_task_hourly_rate($tasks);
            $data['logged_time'] = seconds_to_time_format($data['total_seconds']);
        } elseif ($project_data->billing_type == 2) {
            $seconds = 0;
            foreach ($tasks as $task) {
                $seconds += $task['total_logged_time'];
            }
            $data                = $this->calculate_total_by_project_hourly_rate($seconds, $project_data->project_rate_per_hour);
            $data['logged_time'] = $data['hours'];
        }

        return $data;
    }

    private function _update_discussion_last_activity($id, $type)
    {
        if ($type == 'file') {
            $table = db_prefix() . 'case_files';
        } elseif ($type == 'regular') {
            $table = db_prefix() . 'casediscussions';
        }
        $this->db->where('id', $id);
        $this->db->update($table, [
            'last_activity' => date('Y-m-d H:i:s'),
        ]);
    }

    public function send_project_email_mentioned_users($project_id, $staff_template, $staff, $additional_data = [])
    {
        $this->load->model('staff_model');

        $project = $this->get($project_id);

        foreach ($staff as $staffId) {
            if (is_staff_logged_in() && $staffId == get_staff_user_id()) {
                continue;
            }
            $member = (array) $this->staff_model->get($staffId);
            $member['staff_id'] = $member['staffid'];

            $mailTemplate = mail_template($staff_template, $project, $member, $additional_data['staff']);
            if (isset($additional_data['attachments'])) {
                foreach ($additional_data['attachments'] as $attachment) {
                    $mailTemplate->add_attachment($attachment);
                }
            }
            $mailTemplate->send();
        }
    }

    public function convert_estimate_items_to_tasks($project_id, $items, $assignees, $project_data, $project_settings)
    {
        $this->load->model('tasks_model');
        foreach ($items as $index => $itemId) {

            $this->db->where('id', $itemId);
            $_item = $this->db->get(db_prefix() . 'itemable')->row();

            $data = [
                'billable' => 'on',
                'name' => $_item->description,
                'description' => $_item->long_description,
                'startdate' => $project_data['start_date'],
                'duedate' => '',
                'rel_type' => 'project',
                'rel_id' => $project_id,
                'hourly_rate' => $project_data['billing_type'] == 3 ? $_item->rate : 0,
                'priority' => get_option('default_task_priority'),
                'withDefaultAssignee' => false,
            ];

            if (isset($project_settings->view_tasks)) {
                $data['visible_to_client'] = 'on';
            }

            $task_id = $this->tasks_model->add($data);

            if ($task_id) {
                $staff_id = $assignees[$index];

                $this->tasks_model->add_task_assignees([
                    'taskid' => $task_id,
                    'assignee' => intval($staff_id),
                ]);

                if (!$this->is_member($project_id, $staff_id)) {
                    $this->db->insert(db_prefix() . 'project_members', [
                        'project_id' => $project_id,
                        'staff_id'   => $staff_id,
                    ]);
                }
            }
        }
    }
    
}