<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_518 extends CI_Migration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up()
    {
        $automatically_send_lawyer_daily_agenda = '0'.get_option('automatically_send_lawyer_daily_agenda').':00';
        $automatically_send_lawyer_daily_agenda = date('H:i', strtotime($automatically_send_lawyer_daily_agenda . 'PM'));
        update_option('automatically_send_lawyer_daily_agenda', $automatically_send_lawyer_daily_agenda);
        add_option('daily_agenda_last_check', date('Y-m-d'));
        add_option('invoice_info_format', '{company_name} اسم الشركة : <br />
{building_number} رقم المبنى : <br />
{street_name} اسم الشارع:<br />
{district_name}  الحي: <br />
{city}  المدينة: <br />
{country} البلد: <br />
{zip_code} الرمز البريدي:<br />
{additional_number} الرقم الاضافي للعنوان: <br />
{vat_number} رقم تسجيل ضريبة القيمة المضافة:<br />
{other_number} معرف اّخر:');
        $ids = $this->db->select('id')->get('tblmy_cases')->result_array();
        
        foreach ($ids as $id) {
            if ($this->db->from(db_prefix() . 'case_settings')->where('case_id', $id)) {
                $sessions_settings = [
                    'create_sessions',
                    'edit_sessions',
                    'upload_on_sessions',
                    'comment_on_sessions',
                    'view_session_comments',
                    'view_session_attachments',
                    'view_session_checklist_items',
                    'view_session_total_logged_time'
                ];
                foreach ($sessions_settings as $setting) {
                    $this->db->insert(db_prefix() . 'case_settings', [
                        'case_id' => $id['id'],
                        'name' => $setting,
                        'value' => 0
                    ]);
                }
            }
        }
    }
}
