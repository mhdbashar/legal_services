<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Disputes_case_movement_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('legalservices/LegalServicesModel', 'legal');
    }

    public function get($id = '', $where = [])
    {
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where('my_disputes_case_movement.case_id', $id);
            $this->db->select('my_disputes_case_movement.*,countries.short_name_ar as country_name, cat.name as cat, subcat.name as subcat,my_courts.court_name,my_judicialdept.Jud_number,my_customer_representative.representative as Representative,my_disputes_cases_statuses.status_name as StatusCase');
            $this->db->join(db_prefix() . 'countries', db_prefix() . 'countries.country_id=' . db_prefix() . 'my_disputes_case_movement.country', 'left');
            $this->db->join(db_prefix() . 'my_categories as cat',  'cat.id=' . db_prefix() . 'my_disputes_case_movement.cat_id' , 'left');
            $this->db->join(db_prefix() . 'my_categories as subcat',  'subcat.id=' . db_prefix() . 'my_disputes_case_movement.subcat_id' , 'left');
            $this->db->join(db_prefix() . 'my_courts',  'my_courts.c_id=' . db_prefix() . 'my_disputes_case_movement.court_id' , 'left');
            $this->db->join(db_prefix() . 'my_judicialdept',  'my_judicialdept.j_id=' . db_prefix() . 'my_disputes_case_movement.jud_num' , 'left');
            $this->db->join(db_prefix() . 'my_customer_representative',  'my_customer_representative.id=' . db_prefix() . 'my_disputes_case_movement.representative' , 'left');
            $this->db->join(db_prefix() . 'my_disputes_cases_statuses', db_prefix() . 'my_disputes_cases_statuses.id=' . db_prefix() . 'my_disputes_case_movement.case_status' , 'left');
            return $this->db->get(db_prefix() . 'my_disputes_case_movement')->result_array();
        }

        $this->db->select('*,' . get_sql_select_client_company());
        $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid=' . db_prefix() . 'my_disputes_case_movement.clientid');
        $this->db->order_by('my_disputes_case_movement.id', 'desc');
        return $this->db->get(db_prefix() . 'my_disputes_case_movement')->result_array();
    }

    public function get_row($id = '', $where = [])
    {
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where('my_disputes_case_movement.case_id', $id);
            $this->db->select('my_disputes_case_movement.*,countries.short_name_ar as country_name, cat.name as cat, subcat.name as subcat,my_courts.court_name,my_judicialdept.Jud_number,my_customer_representative.representative as Representative,my_disputes_cases_statuses.status_name as StatusCase');
            $this->db->join(db_prefix() . 'countries', db_prefix() . 'countries.country_id=' . db_prefix() . 'my_disputes_case_movement.country', 'left');
            $this->db->join(db_prefix() . 'my_categories as cat',  'cat.id=' . db_prefix() . 'my_disputes_case_movement.cat_id' , 'left');
            $this->db->join(db_prefix() . 'my_categories as subcat',  'subcat.id=' . db_prefix() . 'my_disputes_case_movement.subcat_id' , 'left');
            $this->db->join(db_prefix() . 'my_courts',  'my_courts.c_id=' . db_prefix() . 'my_disputes_case_movement.court_id');
            $this->db->join(db_prefix() . 'my_judicialdept',  'my_judicialdept.j_id=' . db_prefix() . 'my_disputes_case_movement.jud_num');
            $this->db->join(db_prefix() . 'my_customer_representative',  'my_customer_representative.id=' . db_prefix() . 'my_disputes_case_movement.representative');
            $this->db->join(db_prefix() . 'my_disputes_cases_statuses', db_prefix() . 'my_disputes_cases_statuses.id=' . db_prefix() . 'my_disputes_case_movement.case_status');
            return $this->db->get(db_prefix() . 'my_disputes_case_movement')->row();
        }
    }

    public function add($ServID,$id, $data)
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
            $data['case_status'] = get_default_value_id_by_table_name('my_disputes_cases_statuses', 'id');
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

        if (isset($data['opponent_id'])) {
            $opponents = $data['opponent_id'];
            unset($data['opponent_id']);
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
        $this->db->insert(db_prefix() . 'my_disputes_case_movement', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            handle_tags_save($tags, $insert_id, $slug);

            if (isset($custom_fields)) {
                handle_custom_fields_post($insert_id, $custom_fields);
            }

            if (isset($project_members)) {
                $_pm['project_members'] = $project_members;
                $this->add_edit_members_movement($_pm, $insert_id);
            }

            if (isset($judges)) {
                $cases_judges['judges'] = $judges;
                $this->add_edit_judges_movement($cases_judges, $insert_id);
            }
            if (isset($opponents)) {
                $cases_opponentss['opponents'] = $opponents;
                $this->add_edit_opponents_movement($cases_opponentss, $insert_id);
            }

            $this->Dcase->log_activity($insert_id, 'CaseMov_activity_created');

            if ($send_created_email == true) {
                $this->Dcase->send_project_customer_email($insert_id, 'project_created_to_customer');
            }

            if ($send_project_marked_as_finished_email_to_contacts == true) {
                $this->Dcase->send_project_customer_email($insert_id, 'project_marked_as_finished_to_customer');
            }

            hooks()->do_action('after_add_project', $insert_id);

            log_activity ('New Case Movement [id: ' . $insert_id . ']');

            return $insert_id;
        }

        return false;
    }

    public function update($ServID,$id,$data)
    {
        $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
        $this->db->select('status');
        $this->db->where('id', $id);
        $old_status = $this->db->get(db_prefix() . 'my_disputes_cases')->row()->status;

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

        $original_project = $this->Dcase->get($id);

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
        if ($this->Dcase->add_edit_members($_pm,$ServID, $id)) {
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
        if ($this->Dcase->add_edit_judges($cases_judges, $id)) {
            $affectedRows++;
        }

        if (isset($data['opponent_id'])) {
            $opponents = $data['opponent_id'];
            unset($data['opponent_id']);
        }
        $cases_opponents = [];
        if (isset($opponents)) {
            $cases_opponents['opponents'] = $opponents;
        }
        if ($this->Dcase->add_edit_opponents($cases_opponents, $id)) {
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
            $this->Dcase->cancel_recurring_tasks($id, $slug);
        }

        $data = hooks()->apply_filters('before_update_project', $data, $id);

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'my_disputes_cases', $data);

        if ($this->db->affected_rows() > 0) {
            if (isset($mark_all_tasks_as_completed)) {
                $this->Dcase->_mark_all_project_tasks_as_completed($id, $slug);
            }
            $affectedRows++;
        }
        if ($send_created_email == true) {
            if ($this->Dcase->send_project_customer_email($id, 'project_created_to_customer')) {
                $affectedRows++;
            }
        }

        if ($send_project_marked_as_finished_email_to_contacts == true) {
            if ($this->Dcase->send_project_customer_email($id, 'project_marked_as_finished_to_customer')) {
                $affectedRows++;
            }
        }
        if ($affectedRows > 0) {
            $this->Dcase->log_activity($id, 'LService_activity_updated');
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
                    $this->db->update(db_prefix() . 'my_disputes_cases', ['date_finished' => date('Y-m-d H:i:s')]);
                } else {
                    $this->Dcase->log_activity($id, 'LService_status_updated', '<b><lang>project_status_' . $data['status'] . '</lang></b>');
                }

                if (isset($notify_project_members_status_change)) {
                    $this->Dcase->_notify_project_members_status_change($ServID, $id, $original_project->status, $data['status']);
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
        $this->db->delete(db_prefix() . 'my_disputes_case_movement');
        if ($this->db->affected_rows() > 0) {
            log_activity('Case Movement Deleted [CaseID: ' . $id . ']');
            return true;
        }
        return false;
    }

    public function add_edit_judges_movement($data, $id)
    {
        $affectedRows = 0;
        if (isset($data['judges'])) {
            $cases_judges = $data['judges'];
        }
        $cases_judges_in = $this->get_case_mov_judges($id);

        if (sizeof($cases_judges_in) > 0) {
            foreach ($cases_judges_in as $case_judge) {
                if (isset($cases_judges)) {
                    if (!in_array($case_judge['judge_id'], $cases_judges)) {
                        $this->db->where('case_mov_id', $id);
                        $this->db->where('judge_id', $case_judge['judge_id']);
                        $this->db->delete(db_prefix() . 'my_disputes_cases_movement_judges');
                        if ($this->db->affected_rows() > 0) {
                            $affectedRows++;
                        }
                    }
                } else {
                    $this->db->where('case_mov_id', $id);
                    $this->db->delete(db_prefix() . 'my_disputes_cases_movement_judges');
                    if ($this->db->affected_rows() > 0) {
                        $affectedRows++;
                    }
                }
            }
            if (isset($cases_judges)) {
                foreach ($cases_judges as $judge_id) {
                    $this->db->where('case_mov_id', $id);
                    $this->db->where('judge_id', $judge_id);
                    $_exists = $this->db->get(db_prefix() . 'my_disputes_cases_movement_judges')->row();
                    if (!$_exists) {
                        if (empty($judge_id)) {
                            continue;
                        }
                        $this->db->insert(db_prefix() . 'my_disputes_cases_movement_judges', [
                            'case_mov_id'   => $id,
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
                    $this->db->insert(db_prefix() . 'my_disputes_cases_movement_judges', [
                        'case_mov_id'  => $id,
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

    public function add_edit_opponents_movement($data, $id)
    {
        $affectedRows = 0;
        if (isset($data['opponents'])) {
            $cases_opponents = $data['opponents'];
        }
        $cases_opponents_in = $this->get_case_mov_opponents($id);

        if (sizeof($cases_opponents_in) > 0) {
            foreach ($cases_opponents_in as $case_opponent) {
                if (isset($cases_opponents)) {
                    if (!in_array($case_opponent['opponent_id'], $cases_opponents)) {
                        $this->db->where('case_mov_id', $id);
                        $this->db->where('opponent_id', $case_opponent['opponent_id']);
                        $this->db->delete(db_prefix() . 'my_disputes_cases_movement_opponents');
                        if ($this->db->affected_rows() > 0) {
                            $affectedRows++;
                        }
                    }
                } else {
                    $this->db->where('case_mov_id', $id);
                    $this->db->delete(db_prefix() . 'my_disputes_cases_movement_opponents');
                    if ($this->db->affected_rows() > 0) {
                        $affectedRows++;
                    }
                }
            }
            if (isset($cases_opponents)) {
                foreach ($cases_opponents as $opponent_id) {
                    $this->db->where('case_mov_id', $id);
                    $this->db->where('opponent_id', $opponent_id);
                    $_exists = $this->db->get(db_prefix() . 'my_disputes_cases_movement_opponents')->row();
                    if (!$_exists) {
                        if (empty($judge_id)) {
                            continue;
                        }
                        $this->db->insert(db_prefix() . 'my_disputes_cases_movement_opponents', [
                            'case_mov_id'   => $id,
                            'opponent_id'  => $opponent_id,
                        ]);
                        if ($this->db->affected_rows() > 0) {
                            $affectedRows++;
                        }
                    }
                }
            }
        } else {
            if (isset($cases_opponents)) {
                foreach ($cases_opponents as $opponent_id) {
                    if (empty($opponent_id)) {
                        continue;
                    }
                    $this->db->insert(db_prefix() . 'my_disputes_cases_movement_opponents', [
                        'case_mov_id'  => $id,
                        'opponent_id' => $opponent_id,
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

    public function add_edit_members_movement($data, $id)
    {
        $affectedRows = 0;
        if (isset($data['project_members'])) {
            $cases_members = $data['project_members'];
        }
        $cases_members_in = $this->get_case_mov_members($id);

        if (sizeof($cases_members_in) > 0) {
            foreach ($cases_members_in as $case_member) {
                if (isset($cases_members)) {
                    if (!in_array($case_member['staff_id'], $cases_members)) {
                        $this->db->where('case_mov_id', $id);
                        $this->db->where('staff_id', $case_member['staff_id']);
                        $this->db->delete(db_prefix() . 'my_members_disputes_movement_cases');
                        if ($this->db->affected_rows() > 0) {
                            $affectedRows++;
                        }
                    }
                } else {
                    $this->db->where('case_mov_id', $id);
                    $this->db->delete(db_prefix() . 'my_members_disputes_movement_cases');
                    if ($this->db->affected_rows() > 0) {
                        $affectedRows++;
                    }
                }
            }
            if (isset($cases_members)) {
                foreach ($cases_members as $staff_id) {
                    $this->db->where('case_mov_id', $id);
                    $this->db->where('staff_id', $staff_id);
                    $_exists = $this->db->get(db_prefix() . 'my_members_disputes_movement_cases')->row();
                    if (!$_exists) {
                        if (empty($staff_id)) {
                            continue;
                        }
                        $this->db->insert(db_prefix() . 'my_members_disputes_movement_cases', [
                            'case_mov_id'   => $id,
                            'staff_id'  => $staff_id,
                        ]);
                        if ($this->db->affected_rows() > 0) {
                            $affectedRows++;
                        }
                    }
                }
            }
        } else {
            if (isset($cases_members)) {
                foreach ($cases_members as $staff_id) {
                    if (empty($staff_id)) {
                        continue;
                    }
                    $this->db->insert(db_prefix() . 'my_members_disputes_movement_cases', [
                        'case_mov_id'  => $id,
                        'staff_id' => $staff_id,
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

    public function get_case_mov_judges($id)
    {
        $this->db->select('my_disputes_cases_movement_judges.*,my_judges.*');
        $this->db->join(db_prefix() . 'my_judges', db_prefix() . 'my_judges.id=' . db_prefix() . 'my_disputes_cases_movement_judges.judge_id');
        $this->db->where('my_disputes_cases_movement_judges.case_mov_id', $id);
        return $this->db->get(db_prefix() . 'my_disputes_cases_movement_judges')->result_array();
    }
    public function get_case_mov_opponents($id)
    {
        $this->db->select('my_disputes_cases_movement_opponents.*,clients.*');
        $this->db->join(db_prefix() . 'clients', db_prefix() . 'clients.userid=' . db_prefix() . 'my_disputes_cases_movement_opponents.opponent_id');
        $this->db->where('my_disputes_cases_movement_opponents.case_mov_id', $id);
        return $this->db->get(db_prefix() . 'my_disputes_cases_movement_opponents')->result_array();
    }

    public function GetJudgesCasesMovement($id)
    {
        $this->db->select('my_judges.name');
        $this->db->from('my_disputes_cases_movement_judges');
        $this->db->join('my_judges', 'my_judges.id = my_disputes_cases_movement_judges.judge_id');
        $this->db->where('my_disputes_cases_movement_judges.case_mov_id', $id);
        return $this->db->get()->result_array();
    }

    public function get_case_mov_members($id)
    {
        $this->db->select('my_members_disputes_movement_cases.*,staff.*');
        $this->db->join(db_prefix() . 'staff', db_prefix() . 'staff.staffid=' . db_prefix() . 'my_members_disputes_movement_cases.staff_id');
        $this->db->where('my_members_disputes_movement_cases.case_mov_id', $id);
        return $this->db->get(db_prefix() . 'my_members_disputes_movement_cases')->result_array();
    }

    public function GetMembersCasesMovement($id)
    {
        $this->db->select('CONCAT(firstname, " ", lastname) as full_name, my_members_disputes_movement_cases.staff_id');
        $this->db->from('my_members_disputes_movement_cases');
        $this->db->join('staff', 'staff.staffid = my_members_disputes_movement_cases.staff_id');
        $this->db->where('my_members_disputes_movement_cases.case_mov_id', $id);
        return $this->db->get()->result_array();
    }

}