<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Case_movement_model extends App_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('LegalServices/LegalServicesModel', 'legal');
    }

    public function get($id = '', $where = [])
    {
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where('case_movement.case_id', $id);
            $this->db->select('case_movement.*,countries.short_name_ar as country_name, cat.name as cat, subcat.name as subcat,my_courts.court_name,my_judicialdept.Jud_number,my_customer_representative.representative as Representative,my_casestatus.name as StatusCase');
            $this->db->join(db_prefix() . 'countries', db_prefix() . 'countries.country_id=' . db_prefix() . 'case_movement.country', 'left');
            $this->db->join(db_prefix() . 'my_categories as cat',  'cat.id=' . db_prefix() . 'case_movement.cat_id' , 'left');
            $this->db->join(db_prefix() . 'my_categories as subcat',  'subcat.id=' . db_prefix() . 'case_movement.subcat_id' , 'left');
            $this->db->join(db_prefix() . 'my_courts',  'my_courts.c_id=' . db_prefix() . 'case_movement.court_id' , 'left');
            $this->db->join(db_prefix() . 'my_judicialdept',  'my_judicialdept.j_id=' . db_prefix() . 'case_movement.jud_num' , 'left');
            $this->db->join(db_prefix() . 'my_customer_representative',  'my_customer_representative.id=' . db_prefix() . 'case_movement.representative' , 'left');
            $this->db->join(db_prefix() . 'my_casestatus', db_prefix() . 'my_casestatus.id=' . db_prefix() . 'case_movement.case_status' , 'left');
            return $this->db->get(db_prefix() . 'case_movement')->result_array();
        }

        $this->db->select('*,' . get_sql_select_client_company());
        $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid=' . db_prefix() . 'case_movement.clientid');
        $this->db->order_by('case_movement.id', 'desc');
        return $this->db->get(db_prefix() . 'case_movement')->result_array();
    }

    public function add($ServID,$id, $data)
    {
        $slug = $this->legal->get_service_by_id($ServID)->row()->slug;

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

        $data['case_id'] = $id;

        $data = hooks()->apply_filters('before_add_project', $data);

        $tags = '';
        if (isset($data['tags'])) {
            $tags = $data['tags'];
            unset($data['tags']);
        }

        $this->db->insert(db_prefix() . 'case_movement', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            handle_tags_save($tags, $insert_id, $slug);

            if (isset($custom_fields)) {
                handle_custom_fields_post($insert_id, $custom_fields);
            }

            if (isset($project_members)) {
                $_pm['project_members'] = $project_members;
                $this->case->add_edit_members($_pm, $insert_id);
            }

            if (isset($judges)) {
                $cases_judges['judges'] = $judges;
                $this->case->add_edit_judges($cases_judges, $insert_id);
            }

            $this->case->log_activity($insert_id, 'project_activity_created');

            if ($send_created_email == true) {
                $this->case->send_project_customer_email($insert_id, 'project_created_to_customer');
            }

            if ($send_project_marked_as_finished_email_to_contacts == true) {
                $this->case->send_project_customer_email($insert_id, 'project_marked_as_finished_to_customer');
            }

            hooks()->do_action('after_add_project', $insert_id);

            log_activity ('New Cases Movement [id: ' . $insert_id . ']');

            return $insert_id;
        }

        return false;
    }

    public function update($ServID,$id,$data)
    {
        $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
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

        $original_project = $this->case->get($id);

        if (isset($data['notify_project_members_status_change'])) {
            $notify_project_members_status_change = true;
            unset($data['notify_project_members_status_change']);
        }
        $affectedRows = 0;

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
        if ($this->case->add_edit_members($_pm, $id)) {
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
        if ($this->case->add_edit_judges($cases_judges, $id)) {
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
            $this->case->cancel_recurring_tasks($id, $slug);
        }

        $data = hooks()->apply_filters('before_update_project', $data, $id);

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'my_cases', $data);

        if ($this->db->affected_rows() > 0) {
            if (isset($mark_all_tasks_as_completed)) {
                $this->case->_mark_all_project_tasks_as_completed($id, $slug);
            }
            $affectedRows++;
        }

        if ($send_created_email == true) {
            if ($this->case->send_project_customer_email($id, 'project_created_to_customer')) {
                $affectedRows++;
            }
        }

        if ($send_project_marked_as_finished_email_to_contacts == true) {
            if ($this->case->send_project_customer_email($id, 'project_marked_as_finished_to_customer')) {
                $affectedRows++;
            }
        }
        if ($affectedRows > 0) {
            $this->case->log_activity($id, 'project_activity_updated');
            log_activity('Case Updated [CaseID: ' . $id . ']');

            if ($original_project->status != $data['status']) {
                hooks()->do_action('project_status_changed', [
                    'status'     => $data['status'],
                    'project_id' => $id,
                ]);
                // Give space this log to be on top
                sleep(1);
                if ($data['status'] == 4) {
                    $this->log_activity($id, 'project_marked_as_finished');
                    $this->db->where('id', $id);
                    $this->db->update(db_prefix() . 'my_cases', ['date_finished' => date('Y-m-d H:i:s')]);
                } else {
                    $this->case->log_activity($id, 'project_status_updated', '<b><lang>project_status_' . $data['status'] . '</lang></b>');
                }

                if (isset($notify_project_members_status_change)) {
                    $this->case->_notify_project_members_status_change($id, $original_project->status, $data['status']);
                }
            }
            hooks()->do_action('after_update_project', $id);

            return true;
        }

        return false;

    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'case_movement');
        if ($this->db->affected_rows() > 0) {
            log_activity('Case Movement Deleted [CaseID: ' . $id . ']');
            return true;
        }
        return false;
    }

}