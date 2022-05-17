<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_520 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        // Version 290
        add_option('automatically_stop_task_timer_after_hours', 0);
        add_option('automatically_assign_ticket_to_first_staff_responding', 0);

        if (!$this->db->field_exists('hide_from_customer', db_prefix() . 'milestones')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'milestones` ADD `hide_from_customer` INT DEFAULT 0');
        }

        if (!$this->db->field_exists('cc', db_prefix() . 'tickets')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'tickets` ADD `cc` VARCHAR(191) NULL AFTER `assigned`;');
        }

        if (!$this->db->field_exists('submit_btn_bg_color', db_prefix() . 'web_to_lead')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'web_to_lead` ADD `submit_btn_bg_color` VARCHAR(10) DEFAULT "#84c529" AFTER `submit_btn_name`;');
        }

        if (!$this->db->field_exists('submit_btn_text_color', db_prefix() . 'web_to_lead')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'web_to_lead` ADD `submit_btn_text_color` VARCHAR(10) DEFAULT "#ffffff" AFTER `submit_btn_name`;');
        }

        if (!$this->db->field_exists('submit_btn_bg_color', db_prefix() . 'estimate_request_forms')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'estimate_request_forms` ADD `submit_btn_bg_color` VARCHAR(10) DEFAULT "#84c529" AFTER `submit_btn_name`;');
        }

        if (!$this->db->field_exists('submit_btn_text_color', db_prefix() . 'estimate_request_forms')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'estimate_request_forms` ADD `submit_btn_text_color` VARCHAR(10) DEFAULT "#ffffff" AFTER `submit_btn_name`;');
        }

        // Version 291
        if (!$this->db->field_exists('original_file_name', db_prefix() . 'project_files')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'project_files` ADD `original_file_name` MEDIUMTEXT DEFAULT NULL AFTER `file_name`');
        }
        if (!$this->db->field_exists('original_file_name', db_prefix() . 'case_files')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'case_files` ADD `original_file_name` MEDIUMTEXT DEFAULT NULL AFTER `file_name`');
        }
        if (!$this->db->field_exists('original_file_name', db_prefix() . 'iservice_files')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'iservice_files` ADD `original_file_name` MEDIUMTEXT DEFAULT NULL AFTER `file_name`');
        }
        if (!$this->db->field_exists('original_file_name', db_prefix() . 'oservice_files')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'oservice_files` ADD `original_file_name` MEDIUMTEXT DEFAULT NULL AFTER `file_name`');
        }

        if (!$this->db->field_exists('submit_redirect_url', db_prefix() . 'web_to_lead')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'web_to_lead` ADD `submit_redirect_url` MEDIUMTEXT DEFAULT NULL AFTER `success_submit_msg`');
        }

        if (!$this->db->field_exists('submit_action', db_prefix() . 'web_to_lead')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'web_to_lead` ADD `submit_action` INT(2) DEFAULT 0 AFTER `success_submit_msg`');
        }

        if (!$this->db->field_exists('submit_redirect_url', db_prefix() . 'estimate_request_forms')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'estimate_request_forms` ADD `submit_redirect_url` MEDIUMTEXT DEFAULT NULL AFTER `success_submit_msg`');
        }

        if (!$this->db->field_exists('submit_action', db_prefix() . 'estimate_request_forms')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'estimate_request_forms` ADD `submit_action` INT(2) DEFAULT 0 AFTER `success_submit_msg`');
        }

        $this->db->where('original_file_name IS NULL');
        $this->db->set('original_file_name', 'file_name', false);
        $this->db->update('project_files');


        // Version 292
        if (!$this->db->field_exists('lead_name_prefix', db_prefix() . 'web_to_lead')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'web_to_lead` ADD `lead_name_prefix` VARCHAR(255) AFTER `submit_action`');
        }

        if (!$this->db->field_exists('start_date', db_prefix() . 'milestones')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'milestones` ADD `start_date` DATE AFTER `description_visible_to_customer`');

            $this->db->set('start_date', 'datecreated', false);
            $this->db->update(db_prefix() . 'milestones');
        }

        if (!$this->db->field_exists('staff_id_replying', db_prefix() . 'tickets')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'tickets` ADD `staff_id_replying` INT NULL AFTER `assigned`');
        }

        if ($this->db->field_exists('message', db_prefix() . 'emailtemplates')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'emailtemplates` CHANGE `message` `message` MEDIUMTEXT NOT NULL');
        }

        if (!$this->db->field_exists('merged_ticket_id', db_prefix() . 'tickets')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'tickets` ADD `merged_ticket_id` INT Default null AFTER `contactid`');
        }

        $this->db->query('ALTER TABLE `' . db_prefix() . 'estimates` CHANGE `pipeline_order` `pipeline_order` INT NULL DEFAULT \'1\';');
        $this->db->query('ALTER TABLE `' . db_prefix() . 'proposals` CHANGE `pipeline_order` `pipeline_order` INT NULL DEFAULT \'1\';');
        $this->db->query('ALTER TABLE `' . db_prefix() . 'tasks` CHANGE `kanban_order` `kanban_order` INT NULL DEFAULT \'1\';');

        add_option('reminder_for_completed_but_not_billed_tasks', '0');
        add_option('staff_notify_completed_but_not_billed_tasks');
        add_option('reminder_for_completed_but_not_billed_tasks_days');
        add_option('tasks_reminder_notification_last_notified_day');

        create_email_template(
            'Action required: Completed tasks are not billed',
            'Hello {staff_firstname}<br><br>The following tasks are marked as complete but not yet billed:<br><br>{unbilled_tasks_list}<br><br>Kind Regards,<br><br>{email_signature}',
            'notifications',
            'Non-billed tasks reminder (sent to selected staff members)',
            'non-billed-tasks-reminder',
            1
        );

        create_email_template(
            'We have received your payments',
            'Hello {contact_firstname} {contact_lastname}<br><br>Thank you for the payments. Please find the payments details below:<br><br>{batch_payments_list}<br><br>We are looking forward working with you.<br><br>Kind Regards,<br><br>{email_signature}',
            'invoice',
            'Invoices Payments Recorded in Batch (Sent to Customer)',
            'invoices-batch-payments',
            1
        );
    }
}
