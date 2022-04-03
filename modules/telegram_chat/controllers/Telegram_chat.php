<?php

defined('BASEPATH') or exit('No direct script access allowed');
set_time_limit(0);
class Telegram_chat extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('telegram_model');
    }

    public function index()
    {

        $currentUserID = 1;
        $userTelegramInfo = $this->telegram_model->get($currentUserID);

        $data['title'] = 'Telegram';
        $data['userTeleInfo'] = $userTelegramInfo;

        $this->load->view('telegram_chat/settings', $data);
    }

    function addTelegramInfo() {
        $currentUserID = 1;
        $obj = array(
            'chat_id' =>    $this->input->post('chat_id'),
            'bot_token'=>   $this->input->post('bot_token'),
            'user_id' =>    $GLOBALS['current_user']->staffid,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $userInfo = $this->telegram_model->get($currentUserID);
        if(true) {
            $this->telegram_model->update($obj, 1);
        }
        set_alert('success', _l('telegram_settings_added', _l('telegram')));
        redirect(admin_url('telegram_chat'));
    }


}