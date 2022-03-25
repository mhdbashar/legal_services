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
