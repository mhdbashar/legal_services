<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_532 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {
        add_option('automatically_send_case_not_checked', '3');
        add_option('daily_agenda_last_check', date('Y-m-d'));

        $emailtemplate = $this->db->get_where('tblemailtemplates', array('slug' => 'send_lawyer_daily_agenda_to_staff', 'type' => 'lawyer_daily_agenda', 'language' => 'arabic'))->num_rows();
        if ($emailtemplate == 0) {
            $data = [
                'type' => 'lawyer_daily_agenda',
                'slug' => 'send_lawyer_daily_agenda_to_staff',
                'language' => 'arabic',
                'name' => 'اجندة المحامي',
                'subject' => 'تم إنشاء تقرير لجلسة',
                'message' => '
<table border="1" style="width: 100%;">
<tbody>
<tr>
<td style="width: 33.3333%;"><strong>عنوان الجلسة</strong></td>
<td style="width: 33.3333%;"><strong>اسم الجلسة</strong></td>
<td style="width: 33.3333%;"> <strong> رابط الجلسة</strong></td>
</tr>
<tr>
<td style="width: 33.3333%;" >{session_info}</td>
</tr>
</tbody>
</table>



',
                'fromname' => '{companyname}',
                'fromemail' => '',
                'plaintext' => '0',
                'active' => '1',
                'order' => '0',
            ];
            $this->db->insert(db_prefix() . 'emailtemplates', $data);
            //
        }
        $this->db->where('type', 'lawyer_daily_agenda');
        $this->db->where('slug', 'send_lawyer_daily_agenda_to_staff');
        $this->db->where('language', 'arabic');
        $values = [
            'name' => 'أجندة المحامي  ',
            'subject' => 'جدول الأعمال اليومي',
            'message' => '
               <div style="padding: 20px; text-align: right; background-color: #f6f6f6;">
<div style="text-align: right;"><strong><span style="color: #49c4f5;">صباح الخير</span> <span style="color: #2e4d69;">{staff_fullname}&nbsp;</span> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<br /><br /></strong></div>
<div style="text-align: right;"><strong><span style="color: #49c4f5;">هذا جدول أعمالك اليوم :</span><br /><br /></strong> <strong><span style="color: #49c4f5;">عندك اليوم</span><br /><br /></strong></div>
<div style="text-align: right;"><strong><span style="color: #49c4f5;">جلسات اليوم</span><br /><br /></strong></div>
<div style="text-align: right;">
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;"><strong>وقت الجلسة</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong>رابط الجلسة</strong></td>
</tr>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{session_time}</span></div>
</div>
</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{session_url}</span></div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;"><b><br /><br /><span style="color: #376894;">مهام اليوم</span><br /><br /></b></div>
<div style="text-align: right;"><strong><strong><br /></strong></strong>
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr style="height: 19px;">
<td style="width: 25%; height: 17px; border-style: none;"><strong>عنوان المهام المستحقة اليوم</strong></td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><strong>تاريخ المهمة التي استحقاقها اليوم</strong></div>
</div>
</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><strong>رابط المهمة</strong></div>
</div>
</td>
</tr>
<tr style="height: 16px;">
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{task_duedate_today_name}</span></div>
</div>
</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{task_duedate_today_date_added}</span></div>
</div>
</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div>
<div>
<div><span>{task_link_today}</span></div>
</div>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;"><strong><strong><br /><br /><span style="color: #376894;">المهمات الغير مكتملة والتي انتهى تاريخ استحقاقها</span><br /><br /><br /><br /></strong></strong>
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;"><strong>عنوان المهمة</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong>تاريخ المهمة</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong>رابط المهمة</strong></td>
</tr>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{task_duedate_today_name_duedate_ended}</span></div>
</div>
</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{task_duedate_today_date_added_duedate_ended}</span></div>
</div>
</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{task_link_duedate_ended}</span></div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;">
<div><strong><br /><br /><span style="color: #376894;">مواعيد اليوم</span><br /><br /><br /></strong></div>
</div>
<div style="text-align: right;">
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><strong>ساعة بدء الموعد </strong></div>
</div>
</td>
<td style="width: 25%; height: 17px; border-style: none;"><strong>تاريخ الموعد</strong></td>
<td style="width: 25%; border-style: none;"><strong>رابط الموعد </strong></td>
</tr>
<tr>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{appointment_start_hour}</span></div>
</div>
</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{appointment_date}</span></div>
</div>
</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{appoint_url}</span></div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;">
<div><strong><br /><br /><span style="color: #376894;">طلبات اعادة الاتصال لليوم</span><br /><br /><br /></strong></div>
</div>
<div style="text-align: right;">
<table border="1" style="height: 33px; width: 100%; background-color: #ffffff; border-color: #dee0e0; border-style: solid;">
<tbody>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;"><strong>التاريخ</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong>رقم هاتف</strong></td>
</tr>
<tr style="height: 16px;">
<td style="width: 33.3333%; height: 16px; border-style: none;">
<div>
<div><span>{appointlycallback_date}</span></div>
</div>
</td>
<td style="width: 25%; height: 16px; border-style: none;">
<div>
<div><span>{appointlycallback_phone_number}</span></div>
</div>
</td>
</tr>
</tbody>
</table>
<strong><br /><br /><span style="color: #376894;">العناصر التي يجب القيام بها لليوم</span><br /><br /></strong></div>
<div style="text-align: right;"><strong><strong><br /></strong></strong>
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr>
<td style="width: 25%; height: 17px; border-style: none;"><strong> تاريخ اضافة العنصر </strong></td>
<td style="width: 33.3333%; border-style: none;"><b>شرح العنصر</b></td>
</tr>
<tr>
<td style="width: 25%; height: 17px; border-style: none;">{todo_date_added}</td>
<td style="width: 33.3333%; border-style: none;">{todo_description}</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;"><strong> <br /><br /><span style="color: #376894;">قضايا مفتوحة تحتاج الى متابعة منك</span><br /><br /></strong></div>
<div style="text-align: right;"><strong><strong><br /></strong></strong>
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr>
<td style="width: 25%; height: 17px; border-style: none;"><b>حالة القضية</b></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> عنوان القضية</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> رابط القضية </strong></td>
</tr>
<tr>
<td style="width: 25%; height: 17px; border-style: none;">{case_status_open}</td>
<td style="width: 25%; height: 17px; border-style: none;">{case_name_open}</td>
<td style="width: 25%; height: 17px; border-style: none;">{case_url_open}</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;"><strong><strong>&nbsp;<br /><br /></strong></strong></div>
<div style="text-align: right;"><strong><span style="color: #376894;"> قضايا التنفيذ والتحصيل</span><br /><br /></strong></div>
<div style="text-align: right;"><strong><strong><br /></strong></strong>
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;"><b>حالة قضية التنفيذ والتحصيل</b></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> عنوان قضية التنفيذ والتحصيل</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> رابط القضية </strong></td>
</tr>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;">{case_disputes_status_open}</td>
<td style="width: 25%; height: 17px; border-style: none;">{case_disputes_name_open}</td>
<td style="width: 25%; height: 17px; border-style: none;">{case_disputes_url_open}</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;"><b><br /><br /><span style="color: #376894;">الخدمات القانونية</span><br /><br /></b></div>
<div style="text-align: right;"><strong><strong><br /></strong></strong>
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;"><strong> تاريخ الاضافة</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> موضوع الخدمة</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> رابط الخدمة</strong></td>
</tr>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;">{other_services_status_open}</td>
<td style="width: 25%; height: 17px; border-style: none;">{other_services_name_open}</td>
<td style="width: 25%; height: 17px; border-style: none;">{other_services_link_open}</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;"><strong><strong>&nbsp;<br /><br /></strong></strong></div>
<div style="text-align: right;"><strong><span style="color: #376894;"> التذاكر التي لم يتم الرد عليها</span><br /><br /></strong></div>
<div style="text-align: right;"><strong><strong><br /></strong></strong>
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;"><strong> تاريخ الاضافة</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> موضوع التذكرة </strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> رابط التذكرة </strong></td>
</tr>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;">{tick_start_date}</td>
<td style="width: 25%; height: 17px; border-style: none;">{tick_subject}</td>
<td style="width: 25%; height: 17px; border-style: none;">{ticket_url}</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;"><strong> <br /><br /><span style="color: #376894;">التعليقات التي وصلت لك على المهمات</span><br /><br /></strong></div>
<div style="text-align: right;"><strong><strong><br /></strong></strong>
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr>
<td style="width: 25%; height: 17px; border-style: none;"><strong> تاريخ اضافة التعليق </strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> نص التعليق</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong>رابط التعليق</strong></td>
</tr>
<tr>
<td style="width: 25%; height: 17px; border-style: none;">{task_comment_dateadded}</td>
<td style="width: 25%; height: 17px; border-style: none;">{task_comment_content}</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{task_comment_link}</span></div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;"><strong> <br /><span style="color: #376894;">التعليقات التي وصلت لك على القضايا</span><br /><br /></strong></div>
<div style="text-align: right;"><strong><strong><br /></strong></strong>
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr style="height: 27px;">
<td style="width: 25%; height: 17px; border-style: none;"><strong> تاريخ الاضافة التعليق على القضية</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> محتوى التعليق</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong>رابط التعليق</strong></td>
</tr>
<tr style="width: 25%; height: 17px; border-style: none;">
<td style="width: 25%; height: 17px; border-style: none;">{case_comment_created}</td>
<td style="width: 25%; height: 17px; border-style: none;">{case_comment_content}</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{discussion_link_cases}</span></div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;"><strong> <br /><br /><span style="color: #376894;">التعليقات التي وصلت لك على ملفات القضايا</span><br /><br /></strong></div>
<div style="text-align: right;"><strong><strong><br /></strong></strong>
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;"><strong> تاريخ الاضافة </strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> نص التعليق</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong>رابط التعليق</strong></td>
</tr>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;">{case_comment_created_file}</td>
<td style="width: 25%; height: 17px; border-style: none;">{case_comment_content_file}</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{discussion_link_cases_file}</span></div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;"><strong> <br /><br /><span style="color: #376894;">التعليقات التي وصلت لك على قضايا التنفيذ والتحصيل</span><br /><br /><br /></strong></div>
<div style="text-align: right;"><strong><strong><br /></strong></strong>
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr style="width: 25%; height: 17px; border-style: none;">
<td style="width: 25%; height: 17px; border-style: none;"><strong> تاريخ الاضافة </strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> نص التعليق</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong>رابط التعليق</strong></td>
</tr>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;">{case_disputes_comment_created}</td>
<td style="width: 25%; height: 17px; border-style: none;">{case_disputes_comment_content}</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{discussion_link_cases_disputes}</span></div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;"><strong> <br /><br /><span style="color: #376894;">التعليقات التي وصلت لك على ملفات قضايا التنفيذ والتحصيل</span><br /><br /></strong></div>
<div style="text-align: right;"><strong><strong><br /></strong></strong>
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr>
<td style="width: 25%; height: 17px; border-style: none;"><strong> تاريخ التعليق </strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong>نص التعليق</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong>رابط التعليق</strong></td>
</tr>
<tr>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{case_disputes_comment_created_file}</span></div>
</div>
</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{case_disputes_comment_content_file}</span></div>
</div>
</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div>
<div>
<div><span>{discussion_link_cases_disputes_file}</span></div>
</div>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;"><strong><br /><br /><span style="color: #376894;">التعليقات التي وصلت لك على الخدمات القانونية</span><br /><br /><br /></strong></div>
<div style="text-align: right;">
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;"><strong>تاريخ اضافة التعليق&nbsp;</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong>نص التعليق</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong>رابط التعليق</strong></td>
</tr>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{other_services_comment_created}</span></div>
</div>
</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{other_services_comment_content}</span></div>
</div>
</td>
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div>
<div>
<div><span>{discussion_link_otherservices}</span></div>
</div>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<div style="text-align: right;"><br /><strong><strong><span style="color: #376894;">التعليقات التي وصلت لك على ملفات الخدمات القانونية<br /><br /></span></strong></strong>
<table border="1" style="height: 34px; width: 100.761%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;"><strong>تاريخ اضافة التعليق&nbsp;</strong></td>
<td style="width: 12.5%; height: 17px; border-style: none;"><strong>نص التعليق</strong></td>
<td style="width: 12.5%; border-style: none;"><strong>رابط التعليق</strong></td>
</tr>
<tr style="height: 17px;">
<td style="width: 25%; height: 17px; border-style: none;">
<div>
<div><span>{other_services_comment_created_file}</span></div>
</div>
</td>
<td style="width: 12.5%; height: 17px; border-style: none;">
<div>
<div><span>{other_services_comment_content_file}</span></div>
</div>
</td>
<td style="width: 12.5%; border-style: none;">
<div>
<div><span>{discussion_link_other_file}</span></div>
</div>
</td>
</tr>
</tbody>
</table>
<strong><span style="color: #376894;"><br /><br /></span></strong></div>
<div style="text-align: right;"><strong>&nbsp;</strong></div>
<div style="text-align: right;"><span style="color: #376894;"><strong> الاعلانات</strong></span></div>
<div><strong><strong><br /><br /></strong></strong>
<table border="1" style="height: 34px; width: 100%; background-color: #ffffff; border-color: #cbd0d4; border-style: solid;">
<tbody>
<tr>
<td style="width: 25%; height: 17px; border-style: none;"><strong> تاريخ الاعلان </strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> موضوع الاعلان</strong></td>
<td style="width: 25%; height: 17px; border-style: none;"><strong> نص الاعلان</strong></td>
</tr>
<tr>
<td style="width: 25%; height: 17px; border-style: none;">{announcement_date}</td>
<td style="width: 25%; height: 17px; border-style: none;">{announcement_name}</td>
<td style="width: 25%; height: 17px; border-style: none;">{announcement_message}</td>
</tr>
</tbody>
</table>
<br /><br /><strong>يوم دوام سعيد</strong><br /><strong>ويكند جميل</strong></div>
</div>
',

        ];
        $this->db->update(db_prefix() . 'emailtemplates', $values);

    }
}
