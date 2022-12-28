<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_522 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {
        //add filds to tblmy_session_info
        if (!$this->db->field_exists('cat_id', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `cat_id` int(11) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('subcat_id', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `subcat_id` int(11) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('childsubcat_id', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `childsubcat_id` int(11) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('file_number_court', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `file_number_court` bigint(20) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('session_link', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `session_link` varchar(255) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('is_send_opponent', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `is_send_opponent` int(11) NOT NULL DEFAULT 0');
        }

        if(!get_option('sessions_reminder_notification_before')) {
            add_option('sessions_reminder_notification_before', 1);
        }
        $emailtemplate = $this->db->get_where('tblemailtemplates', array('slug' => 'send_report_session_to_staff','type'=>'sessions','language'=>'arabic'))->num_rows();
        if($emailtemplate == 0) {
            $data = [
                'type'=>'sessions', 'slug'=>'send_report_session_to_staff', 'language'=>'arabic', 'name'=>'مراجعة تقرير الجلسة (مرسل إلى فريق العمل)', 'subject'=>'تم إنشاء تقرير لجلسة', 'message'=>'', 'fromname'=>'', 'fromemail'=>'{companyname}', 'plaintext'=>'0', 'active'=>'1', 'order'=>'0',
            ];
            $this->db->insert(db_prefix() . 'sessions_checklist_templates',$data);
            //
            $this->db->where('type','sessions');
            $this->db->where('slug','next_session_action');
            $this->db->where('language','arabic');
            $values = [
                'name'=>'تذكير بإجراءات الجلسة القادمة (مرسل جهات اتصال العملاء)',
                'subject'=>'تذكير بإجراءات الجلسة القادمة',
                'message'=>'عملينا الكريم : {contact_firstname}{contact_lastname}

السلام عليكم ورحمة الله وبركاته,,, وأسعد الله أوقاتكم بكل خير

فيما يلي نفيدكم بموعد الجلسة المقبلة الخاصة بكم والطلبات والإجراءات الخاصة بها.

عنوان الجلسة :{session_name}
تاريخ الجلسة القادمة : {next_session_date}
وقت الجلسة القادمة : {next_session_time}
قرار المحكمة : {court_decision}
'
            ];
            $this->db->update(db_prefix() . 'emailtemplates',$values);
            //
            $this->db->where('type','sessions');
            $this->db->where('slug','send_report_session');
            $this->db->where('language','arabic');
            $values2 = [
                'name'=>'تقرير الجلسة (مرسل جهات اتصال العملاء)',
                'subject'=>'تقرير الجلسة',
                'message'=>'عملينا الكريم : {contact_firstname}{contact_lastname}

السلام عليكم ورحمة الله وبركاته,,, وأسعد الله أوقاتكم بكل خير


فيما يلي تقرير الجلسة الخاصة بكم :

عنوان الجلسة :{session_name}
تاريخ الجلسة : {session_startdate}
وقت الجلسة : {session_time}
وصف الجلسة : {session_description}
وقائع الجلسة : {session_description}
قرار المحكمة : {court_decision}


في حال وجود أي جلسة قادمة مرتبطة بالجلسة الحالية سيصلكم بريد إلكتروني بهذه الجلسة متضمناً أي طلبات أو إجراءات خاصة بالجلسة المقبلة.


وتقبلوا خالص التقدير


مع تحيات فريق عمل {companyname}'
            ];
            $this->db->update(db_prefix() . 'emailtemplates',$values2);
        }
    }
}