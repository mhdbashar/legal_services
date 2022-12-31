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

        if (!$this->db->field_exists('staff', db_prefix() . 'contracts')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'contracts` ADD `staff` int(11) NOT NULL');
        }

        if(!get_option('sessions_reminder_notification_before')) {
            add_option('sessions_reminder_notification_before', 1);
        }
        $emailtemplate = $this->db->get_where('tblemailtemplates', array('slug' => 'send_report_session_to_staff','type'=>'sessions','language'=>'arabic'))->num_rows();
        if($emailtemplate == 0) {
            $data = [
                'type'=>'sessions', 'slug'=>'send_report_session_to_staff', 'language'=>'arabic', 'name'=>'مراجعة تقرير الجلسة (مرسل إلى فريق العمل)', 'subject'=>'تم إنشاء تقرير لجلسة', 'message'=>'', 'fromname'=>'', 'fromemail'=>'{companyname}', 'plaintext'=>'0', 'active'=>'1', 'order'=>'0',
            ];
            $this->db->insert(db_prefix() . 'emailtemplates',$data);
            //
            $this->db->where('type','sessions');
            $this->db->where('slug','next_session_action');
            $this->db->where('language','arabic');
            $values = [
                'name'=>'تذكير بإجراءات الجلسة القادمة (مرسل جهات اتصال العملاء)',
                'subject'=>'تذكير بإجراءات الجلسة القادمة',
                'message'=>'عملينا الكريم : {contact_firstname}{contact_lastname}<br />السلام عليكم ورحمة الله وبركاته,,, وأسعد الله أوقاتكم بكل خير<br />فيما يلي نفيدكم بموعد الجلسة المقبلة الخاصة بكم والطلبات والإجراءات الخاصة بها. <br />عنوان الجلسة :{session_name}<br />تاريخ الجلسة القادمة : {next_session_date}<br />وقت الجلسة القادمة : {next_session_time}<br />قرار المحكمة : {court_decision}<br /><span>الطلبات والإجراءات : {checklist_items}</span>'
            ];
            $this->db->update(db_prefix() . 'emailtemplates',$values);
            //
            $this->db->where('type','sessions');
            $this->db->where('slug','send_report_session');
            $this->db->where('language','arabic');
            $values2 = [
                'name'=>'تقرير الجلسة (مرسل جهات اتصال العملاء)',
                'subject'=>'تقرير الجلسة',
                'message'=>'عملينا الكريم : {contact_firstname}{contact_lastname}عملينا الكريم : {contact_firstname}{contact_lastname}<br />السلام عليكم ورحمة الله وبركاته,,, وأسعد الله أوقاتكم بكل خير<br />فيما يلي تقرير الجلسة الخاصة بكم :<br /><br />
<table style="height: 100px; width: 100%; border-style: none; margin-left: auto; margin-right: auto;" border="1">
<tbody>
<tr style="height: 16px;">
<td style="width: 50%; height: 16px;">عنوان الجلسة :</td>
<td style="width: 25%; height: 16px;">{session_name}</td>
</tr>
<tr style="height: 17px;">
<td style="width: 50%; height: 17px;">تاريخ الجلسة :</td>
<td style="width: 25%; height: 17px;">{session_startdate}</td>
</tr>
<tr style="height: 17px;">
<td style="width: 50%; height: 17px;">وقت الجلسة :</td>
<td style="width: 25%; height: 17px;">{session_time}</td>
</tr>
<tr style="height: 17px;">
<td style="width: 50%; height: 17px;">وصف الجلسة :</td>
<td style="width: 25%; height: 17px;">{session_description}</td>
</tr>
<tr style="height: 16px;">
<td style="width: 50%; height: 16px;">وقائع الجلسة :</td>
<td style="width: 25%; height: 16px;">{session_description}</td>
</tr>
<tr style="height: 17px;">
<td style="width: 50%; height: 17px;">قرار المحكمة :</td>
<td style="width: 25%; height: 17px;">{court_decision}</td>
</tr>
<tr>
<td style="width: 50%;"><span>الطلبات والإجراءات : </span></td>
<td style="width: 25%;"><span>{checklist_items}</span></td>
</tr>
</tbody>
</table>
<br /><br /><br /><br />في حال وجود أي جلسة قادمة مرتبطة بالجلسة الحالية سيصلكم بريد إلكتروني بهذه الجلسة متضمناً أي طلبات أو إجراءات خاصة بالجلسة المقبلة.<br /><br />وتقبلوا خالص التقدير مع تحيات فريق عمل {companyname}'
            ];
            $this->db->update(db_prefix() . 'emailtemplates',$values2);
        }
    }
}