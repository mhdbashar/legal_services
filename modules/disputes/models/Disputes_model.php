<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Disputes_model extends App_Model
{
    private $project_settings;


    /*private $shipping_fields = [
        'shipping_street',
        'shipping_city',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
    ];*/

    public function __construct()
    {
        parent::__construct();
    }


    public function add($data)
    {
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
            $project_settings = $data['settings'];
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
        if ($data['billing_type'] == 1) {
            $data['project_rate_per_hour'] = 0;
        } elseif ($data['billing_type'] == 11) {
            $data['project_cost'] = 0;
        }/* else {
            $data['project_rate_per_hour'] = 0;
            $data['project_cost']          = 0;
        }*/

        $data['addedfrom'] = get_staff_user_id();

        $data = hooks()->apply_filters('before_add_project', $data);

        $tags = '';
        if (isset($data['tags'])) {
            $tags = $data['tags'];
            unset($data['tags']);
        }
        $this->load->model('Projects_model');

        $this->db->insert(db_prefix() . 'projects', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            handle_tags_save($tags, $insert_id, 'project');

            if (isset($custom_fields)) {
                handle_custom_fields_post($insert_id, $custom_fields);
            }

            if (isset($project_members)) {
                $_pm['project_members'] = $project_members;
                $this->Projects_model->add_edit_members($_pm, $insert_id);
            }

            $original_settings = $this->Projects_model->get_settings();
            if (isset($project_settings)) {
                $_settings = [];
                $_values   = [];
                foreach ($project_settings as $name => $val) {
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
                        $tabs         = get_project_tabs_admin();
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
                    $this->db->insert(db_prefix() . 'project_settings', [
                        'project_id' => $insert_id,
                        'name'       => $setting,
                        'value'      => $value_setting,
                    ]);
                }
            } else {
                foreach ($original_settings as $setting) {
                    $value_setting = 0;
                    $this->db->insert(db_prefix() . 'project_settings', [
                        'project_id' => $insert_id,
                        'name'       => $setting,
                        'value'      => $value_setting,
                    ]);
                }
            }

            $this->Projects_model->log_activity($insert_id, 'project_activity_created');

            if ($send_created_email == true) {
                $this->Projects_model->send_project_customer_email($insert_id, 'project_created_to_customer');
            }

            if ($send_project_marked_as_finished_email_to_contacts == true) {
                $this->Projects_model->send_project_customer_email($insert_id, 'project_marked_as_finished_to_customer');
            }

            hooks()->do_action('after_add_project', $insert_id);

            log_activity('New Project Created [ID: ' . $insert_id . ']');

            return $insert_id;
        }

        return false;
    }



    public function update($data, $id)
    {
        $this->db->select('status');
        $this->db->where('id', $id);
        $old_status = $this->db->get(db_prefix() . 'projects')->row()->status;

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

        $this->load->model('Projects_model');
        $original_project = $this->Projects_model->get($id);

        if (isset($data['notify_project_members_status_change'])) {
            $notify_project_members_status_change = true;
            unset($data['notify_project_members_status_change']);
        }
        $affectedRows = 0;
        if (!isset($data['settings'])) {
            $this->db->where('project_id', $id);
            $this->db->update(db_prefix() . 'project_settings', [
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
            $original_settings = $this->Projects_model->get_project_settings($id);

            foreach ($original_settings as $setting) {
                if ($setting['name'] != 'available_features') {
                    if (in_array($setting['name'], $_settings)) {
                        $value_setting = 1;
                    } else {
                        $value_setting = 0;
                    }
                } else {
                    $tabs         = get_project_tabs_admin();
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

                $this->db->where('project_id', $id);
                $this->db->where('name', $setting['name']);
                $this->db->update(db_prefix() . 'project_settings', [
                    'value' => $value_setting,
                ]);

                if ($this->db->affected_rows() > 0) {
                    $affectedRows++;
                }
            }
        }

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
        } elseif ($data['billing_type'] == 11) {
            $data['project_cost'] = 0;
        }/* else {
            $data['project_rate_per_hour'] = 0;
            $data['project_cost']          = 0;
        }*/
        if (isset($data['project_members'])) {
            $project_members = $data['project_members'];
            unset($data['project_members']);
        }
        $_pm = [];
        if (isset($project_members)) {
            $_pm['project_members'] = $project_members;
        }
        if ($this->Projects_model->add_edit_members($_pm, $id)) {
            $affectedRows++;
        }
        if (isset($data['mark_all_tasks_as_completed'])) {
            $mark_all_tasks_as_completed = true;
            unset($data['mark_all_tasks_as_completed']);
        }

        if (isset($data['tags'])) {
            if (handle_tags_save($data['tags'], $id, 'project')) {
                $affectedRows++;
            }
            unset($data['tags']);
        }

        if (isset($data['cancel_recurring_tasks'])) {
            unset($data['cancel_recurring_tasks']);
            $this->Projects_model->cancel_recurring_tasks($id);
        }

        $data = hooks()->apply_filters('before_update_project', $data, $id);

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'projects', $data);

        if ($this->db->affected_rows() > 0) {
            if (isset($mark_all_tasks_as_completed)) {
                $this->Projects_model->_mark_all_project_tasks_as_completed($id);
            }
            $affectedRows++;
        }

        if ($send_created_email == true) {
            if ($this->Projects_model->send_project_customer_email($id, 'project_created_to_customer')) {
                $affectedRows++;
            }
        }

        if ($send_project_marked_as_finished_email_to_contacts == true) {
            if ($this->Projects_model->send_project_customer_email($id, 'project_marked_as_finished_to_customer')) {
                $affectedRows++;
            }
        }
        if ($affectedRows > 0) {
            $this->Projects_model->log_activity($id, 'project_activity_updated');
            log_activity('Project Updated [ID: ' . $id . ']');

            if ($original_project->status != $data['status']) {
                hooks()->do_action('project_status_changed', [
                    'status'     => $data['status'],
                    'project_id' => $id,
                ]);
                // Give space this log to be on top
                sleep(1);
                if ($data['status'] == 4) {
                    $this->Projects_model->log_activity($id, 'project_marked_as_finished');
                    $this->db->where('id', $id);
                    $this->db->update(db_prefix() . 'projects', ['date_finished' => date('Y-m-d H:i:s')]);
                } else {
                    $this->Projects_model->log_activity($id, 'project_status_updated', '<b><lang>project_status_' . $data['status'] . '</lang></b>');
                }

                if (isset($notify_project_members_status_change)) {
                    $this->Projects_model->_notify_project_members_status_change($id, $original_project->status, $data['status']);
                }
            }
            hooks()->do_action('after_update_project', $id);

            return true;
        }

        return false;
    }

    public function get_project_meta($project_id)
    {
        return $this->db->query('SELECT * FROM `' . db_prefix() . 'my_projects_meta` WHERE project_id='.$project_id)->result_array();
    }

    public function add_update_meta($project_id,$meta)
    {
        
        foreach ($meta as $key => $value) {
            
            $query = $this->db->query('SELECT * FROM `' . db_prefix() . 'my_projects_meta` WHERE `project_id`='.$project_id.' AND `meta_key`="'.$key.'" ');
            if($query->num_rows()>0){
                $this->db->query('UPDATE `' . db_prefix() . 'my_projects_meta` SET `meta_value`="'.$value.'" WHERE `project_id`='.$project_id.' AND `meta_key`="'.$key.'" ');
            }else{
                $this->db->query('INSERT INTO `' . db_prefix() . 'my_projects_meta` (`project_id`,`meta_key`,`meta_value`) VALUES ('.$project_id.', "'.$key.'", "'.$value.'") ');
            }
        }
        
    }


}
