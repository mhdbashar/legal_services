<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_523 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }
    public function up()
    {
        //add filds to tblmy_session_info
        if (!$this->db->field_exists('clientid', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `clientid` int(11) NULL DEFAULT NULL');
        }
        if (!$this->db->field_exists('contact_notification', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `contact_notification` INT DEFAULT 1');
        }
        if (!$this->db->field_exists('notify_contacts', db_prefix() . 'my_session_info')) {
            $this->db->query('ALTER TABLE `' . db_prefix() . 'my_session_info` ADD `notify_contacts` TEXT DEFAULT NULL');
        }

        $emailtemplate = $this->db->get_where('tblemailtemplates', array('slug' => 'next_session_action_to_opponent','type'=>'sessions','language'=>'arabic'))->num_rows();
        if($emailtemplate == 0) {
            $data = [
                'type' => 'sessions', 'slug' => 'next_session_action_to_opponent', 'language' => 'arabic', 'name' => 'تذكير بالجلسة القادمة (مرسل جهات اتصال الخصم)', 'subject' => 'تم إنشاء جلسة قادمة',
                'message' => '
                السيد : {contact_firstname}{contact_lastname}<br />السلام عليكم ورحمة الله وبركاته,,, وأسعد الله أوقاتكم بكل خير<br />فيما يلي نفيدكم بموعد الجلسة المقبلة الخاصة بكم. <br />تاريخ الجلسة القادمة : {next_session_date}<br />وقت الجلسة القادمة : {next_session_time}
                ',
                'fromname' => '{companyname}', 'fromemail' => '{companyname}', 'plaintext' => '0', 'active' => '1', 'order' => '0',
            ];
            $this->db->insert(db_prefix() . 'emailtemplates', $data);
        }

    }
}