<?php

class Receive_sms extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $messages = get_messages();
        if(is_array($messages))
            $data['messages'] = $messages;
        else
        {
            $data['error'] = $messages;
        }
        $data['title'] = 'Messages';
        $this->load->view('messages/manage', $data);
    }

    public function get_senders()
    {
        if($this->app->get_option('sms_senders') != null){
            $json['sms_senders'] =  $this->app->get_option('sms_senders');
        }else{
            $json['sms_senders'] = "";
        }
        echo json_encode($json) ;

    }
}