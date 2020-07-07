<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Global_model extends App_Model{

    private $table_name = 'hr_extra_info';

    public function __construct(){
        parent::__construct();
        if(!substr( $this->table_name, 0, 3 ) === "tbl"){
            $this->table_name = 'tbl' . $this->table_name;
        }
    }

    public function get($staff_id=''){
        if(is_numeric($staff_id)){
            $this->db->where('staff_id' ,$staff_id);
            $staff = $this->db->get($this->table_name)->row();
            if ($staff) {
                $staff->leaves = $this->get_staffs_leaves($staff_id);
                return $staff;
            }
        }

        return false;
    }

    public function get_staffs(){
        $this->db->from(db_prefix().'staff');
        $this->db->join($this->table_name, $this->table_name.'.staff_id=' . db_prefix() . 'staff.staffid', 'inner');
        return $this->db->get()->result_array();
    }


    public function delete($id, $transfer_data_to)
    {
        if (!is_numeric($transfer_data_to)) {
            return false;
        }

        if ($id == $transfer_data_to) {
            return false;
        }

        hooks()->do_action('before_delete_staff_member', [
            'id'               => $id,
            'transfer_data_to' => $transfer_data_to,
        ]);

        $name           = get_staff_full_name($id);
        $transferred_to = get_staff_full_name($transfer_data_to);

        $this->db->where('addedfrom', $id);
        $this->db->update(db_prefix() . 'estimates', [
            'addedfrom' => $transfer_data_to,
        ]);

        $this->db->where('sale_agent', $id);
        $this->db->update(db_prefix() . 'estimates', [
            'sale_agent' => $transfer_data_to,
        ]);

        $this->db->where('addedfrom', $id);
        $this->db->update(db_prefix() . 'invoices', [
            'addedfrom' => $transfer_data_to,
        ]);

        $this->db->where('sale_agent', $id);
        $this->db->update(db_prefix() . 'invoices', [
            'sale_agent' => $transfer_data_to,
        ]);

        $this->db->where('addedfrom', $id);
        $this->db->update(db_prefix() . 'expenses', [
            'addedfrom' => $transfer_data_to,
        ]);

        $this->db->where('addedfrom', $id);
        $this->db->update(db_prefix() . 'notes', [
            'addedfrom' => $transfer_data_to,
        ]);

        $this->db->where('userid', $id);
        $this->db->update(db_prefix() . 'newsfeed_post_comments', [
            'userid' => $transfer_data_to,
        ]);

        $this->db->where('creator', $id);
        $this->db->update(db_prefix() . 'newsfeed_posts', [
            'creator' => $transfer_data_to,
        ]);

        $this->db->where('staff_id', $id);
        $this->db->update(db_prefix() . 'projectdiscussions', [
            'staff_id' => $transfer_data_to,
        ]);

        $this->db->where('addedfrom', $id);
        $this->db->update(db_prefix() . 'projects', [
            'addedfrom' => $transfer_data_to,
        ]);

        $this->db->where('addedfrom', $id);
        $this->db->update(db_prefix() . 'creditnotes', [
            'addedfrom' => $transfer_data_to,
        ]);

        $this->db->where('staff_id', $id);
        $this->db->update(db_prefix() . 'credits', [
            'staff_id' => $transfer_data_to,
        ]);

        $this->db->where('staffid', $id);
        $this->db->update(db_prefix() . 'project_files', [
            'staffid' => $transfer_data_to,
        ]);

        $this->db->where('staffid', $id);
        $this->db->update(db_prefix() . 'proposal_comments', [
            'staffid' => $transfer_data_to,
        ]);

        $this->db->where('addedfrom', $id);
        $this->db->update(db_prefix() . 'proposals', [
            'addedfrom' => $transfer_data_to,
        ]);

        $this->db->where('staffid', $id);
        $this->db->update(db_prefix() . 'task_comments', [
            'staffid' => $transfer_data_to,
        ]);

        $this->db->where('addedfrom', $id);
        $this->db->where('is_added_from_contact', 0);
        $this->db->update(db_prefix() . 'tasks', [
            'addedfrom' => $transfer_data_to,
        ]);

        $this->db->where('staffid', $id);
        $this->db->update(db_prefix() . 'files', [
            'staffid' => $transfer_data_to,
        ]);

        $this->db->where('renewed_by_staff_id', $id);
        $this->db->update(db_prefix() . 'contract_renewals', [
            'renewed_by_staff_id' => $transfer_data_to,
        ]);

        $this->db->where('addedfrom', $id);
        $this->db->update(db_prefix() . 'task_checklist_items', [
            'addedfrom' => $transfer_data_to,
        ]);

        $this->db->where('finished_from', $id);
        $this->db->update(db_prefix() . 'task_checklist_items', [
            'finished_from' => $transfer_data_to,
        ]);

        $this->db->where('admin', $id);
        $this->db->update(db_prefix() . 'ticket_replies', [
            'admin' => $transfer_data_to,
        ]);

        $this->db->where('admin', $id);
        $this->db->update(db_prefix() . 'tickets', [
            'admin' => $transfer_data_to,
        ]);

        $this->db->where('addedfrom', $id);
        $this->db->update(db_prefix() . 'leads', [
            'addedfrom' => $transfer_data_to,
        ]);

        $this->db->where('assigned', $id);
        $this->db->update(db_prefix() . 'leads', [
            'assigned' => $transfer_data_to,
        ]);

        $this->db->where('staff_id', $id);
        $this->db->update(db_prefix() . 'taskstimers', [
            'staff_id' => $transfer_data_to,
        ]);

        $this->db->where('addedfrom', $id);
        $this->db->update(db_prefix() . 'contracts', [
            'addedfrom' => $transfer_data_to,
        ]);

        $this->db->where('assigned_from', $id);
        $this->db->where('is_assigned_from_contact', 0);
        $this->db->update(db_prefix() . 'task_assigned', [
            'assigned_from' => $transfer_data_to,
        ]);

        $this->db->where('responsible', $id);
        $this->db->update(db_prefix() . 'leads_email_integration', [
            'responsible' => $transfer_data_to,
        ]);

        $this->db->where('responsible', $id);
        $this->db->update(db_prefix() . 'web_to_lead', [
            'responsible' => $transfer_data_to,
        ]);

        $this->db->where('created_from', $id);
        $this->db->update(db_prefix() . 'subscriptions', [
            'created_from' => $transfer_data_to,
        ]);

        $this->db->where('notify_type', 'specific_staff');
        $web_to_lead = $this->db->get(db_prefix() . 'web_to_lead')->result_array();

        foreach ($web_to_lead as $form) {
            if (!empty($form['notify_ids'])) {
                $staff = unserialize($form['notify_ids']);
                if (is_array($staff)) {
                    if (in_array($id, $staff)) {
                        if (($key = array_search($id, $staff)) !== false) {
                            unset($staff[$key]);
                            $staff = serialize(array_values($staff));
                            $this->db->where('id', $form['id']);
                            $this->db->update(db_prefix() . 'web_to_lead', [
                                'notify_ids' => $staff,
                            ]);
                        }
                    }
                }
            }
        }

        $this->db->where('id', 1);
        $leads_email_integration = $this->db->get(db_prefix() . 'leads_email_integration')->row();

        if ($leads_email_integration->notify_type == 'specific_staff') {
            if (!empty($leads_email_integration->notify_ids)) {
                $staff = unserialize($leads_email_integration->notify_ids);
                if (is_array($staff)) {
                    if (in_array($id, $staff)) {
                        if (($key = array_search($id, $staff)) !== false) {
                            unset($staff[$key]);
                            $staff = serialize(array_values($staff));
                            $this->db->where('id', 1);
                            $this->db->update(db_prefix() . 'leads_email_integration', [
                                'notify_ids' => $staff,
                            ]);
                        }
                    }
                }
            }
        }

        $this->db->where('assigned', $id);
        $this->db->update(db_prefix() . 'tickets', [
            'assigned' => 0,
        ]);

        $this->db->where('staff', 1);
        $this->db->where('userid', $id);
        $this->db->delete(db_prefix() . 'dismissed_announcements');

        $this->db->where('userid', $id);
        $this->db->delete(db_prefix() . 'newsfeed_comment_likes');

        $this->db->where('userid', $id);
        $this->db->delete(db_prefix() . 'newsfeed_post_likes');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'customer_admins');

        $this->db->where('fieldto', 'staff');
        $this->db->where('relid', $id);
        $this->db->delete(db_prefix() . 'customfieldsvalues');

        $this->db->where('userid', $id);
        $this->db->delete(db_prefix() . 'events');

        $this->db->where('touserid', $id);
        $this->db->delete(db_prefix() . 'notifications');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'user_meta');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'project_members');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'project_notes');

        $this->db->where('creator', $id);
        $this->db->or_where('staff', $id);
        $this->db->delete(db_prefix() . 'reminders');

        $this->db->where('staffid', $id);
        $this->db->delete(db_prefix() . 'staff_departments');

        $this->db->where('staffid', $id);
        $this->db->delete(db_prefix() . 'todos');

        $this->db->where('staff', 1);
        $this->db->where('user_id', $id);
        $this->db->delete(db_prefix() . 'user_auto_login');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'staff_permissions');

        $this->db->where('staffid', $id);
        $this->db->delete(db_prefix() . 'task_assigned');

        $this->db->where('staffid', $id);
        $this->db->delete(db_prefix() . 'task_followers');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'pinned_projects');
// hr
        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_allowances');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_appraisal');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_attendance');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_attendances');

        $this->db->where('staff_id', $id);
        $awards = $this->db->get(db_prefix() . 'hr_awards')->result_array();
        $this->load->model('hr/Awards_model', 'Awards_model');
        foreach($awards as $award){
            $this->Awards_model->delete($award['id']);
        }

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_bank_account');

        $this->db->where('staff_id', $id);
        $commissions = $this->db->get(db_prefix() . 'hr_commissions')->result_array();
        $this->load->model('hr/Commissions_model', 'Commissions_model');
        foreach($commissions as $commission){
            $this->Commissions_model->delete($commission['id']);
        }

        $this->db->where('complaint_from', $id);
        $complaints = $this->db->get(db_prefix() . 'hr_complaints')->result_array();
        $this->load->model('hr/Complaint_model', 'Complaint_model');
        foreach($complaints as $complaint){
            $this->Complaint_model->delete($complaint['id']);
        }

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_documents');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_emergency_contact');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_extra_info');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_immigration');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_leaves');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_loan');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_other_payments');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_overtime');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_overtime_request');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_payments');

        $this->db->where('staff_id', $id);
        $promotions = $this->db->get(db_prefix() . 'hr_promotions')->result_array();
        $this->load->model('hr/Promotion_model', 'Promotion_model');
        foreach($promotions as $promotion){
            $this->Promotion_model->delete($promotion['id']);
        }

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_qualification');

        $this->db->where('staff_id', $id);
        $resignations = $this->db->get(db_prefix() . 'hr_resignations')->result_array();
        $this->load->model('hr/Resignations_model', 'Resignations_model');
        foreach($resignations as $resignation){
            $this->Resignations_model->delete($resignation['id']);
        }

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_salary');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_social_networking');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_staffs_leaves');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_staff_leaves');

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_statutory_deductions');

        $this->db->where('staff_id', $id);
        $terminations = $this->db->get(db_prefix() . 'hr_terminations')->result_array();
        $this->load->model('hr/Terminations_model', 'Terminations_model');
        foreach($terminations as $termination){
            $this->Terminations_model->delete($termination['id']);
        }

        $this->db->where('staff_id', $id);
        $transfers = $this->db->get(db_prefix() . 'hr_transfers')->result_array();
        $this->load->model('hr/Transfers_model', 'Transfers_model');
        foreach($transfers as $transfer){
            $this->Transfers_model->delete($transfer['id']);
        }

        $this->db->where('staff_id', $id);
        $travels = $this->db->get(db_prefix() . 'hr_travels')->result_array();
        $this->load->model('hr/Travel_model', 'Travel_model');
        foreach($travels as $travel){
            $this->Travel_model->delete($travel['id']);
        }

        $this->db->where('warning_by', $id);
        $warnings = $this->db->get(db_prefix() . 'hr_warnings')->result_array();
        $this->load->model('hr/Warnings_model', 'Warnings_model');
        foreach($warnings as $warning){
            $this->Warnings_model->delete($warning['id']);
        }

        $this->db->where('staff_id', $id);
        $this->db->delete(db_prefix() . 'hr_work_experience');

        if($this->app_modules->is_active('branches')){
            $this->db->where(['rel_id' => $id, 'rel_type' => 'staff']);
            $this->db->delete('tblbranches_services');
        }


// hr
        $this->db->where('staffid', $id);
        $this->db->delete(db_prefix() . 'staff');
        log_activity('Staff Member Deleted [Name: ' . $name . ', Data Transferred To: ' . $transferred_to . ']');

        hooks()->do_action('staff_member_deleted', [
            'id'               => $id,
            'transfer_data_to' => $transfer_data_to,
        ]);

        return true;
    }
}