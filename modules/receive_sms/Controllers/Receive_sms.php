<?php

class Receive_sms extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Receive_sms_model');
    }

    public function index()
    {
        $messages = get_messages();
        if(is_array($messages)){
            $data['messages'] = [];
            foreach ($messages as $message){
                if($this->Receive_sms_model->is_set([
                    'msg' => $message->msg,
                    'created_at' => $message->date,
                    'sender' => $message->phone
                ]))
                    $data['messages'][] = $message;

            }
        }
        else
        {
            $data['error'] = $messages;
        }
        $data['title'] = _l('messages');
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

    public function save_sms()
    {
        $data = $this->input->post();

        $data['staff_id'] = get_staff_user_id();

        $success = $this->Receive_sms_model->add($data);

        $status = false;

        if($success)
            $status = true;

        echo json_encode(['status' => $status]);
    }

    public function saved_messages()
    {

        if($this->input->is_ajax_request())
        {
            $this->receivesms->get_table_data('saved_messages_table');
        }

        $data['title'] = _l('saved_messages');
        $this->load->view('saved_messages/manage', $data);
    }
}