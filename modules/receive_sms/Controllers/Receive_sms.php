<?php

class Receive_sms extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Receive_sms_model');
        $this->load->model('LegalServices/LegalServicesModel', 'legal');
    }

    public function index()
    {
        $messages = get_messages();
        if(is_array($messages)){
            $data['messages'] = [];

            foreach ($messages as $message){
                if($this->Receive_sms_model->is_set([
                    'msg' => ($message->msg),
                    'created_at' => ($message->date),
                    'sender' => ($message->phone)
                ]))
                    $data['messages'][] = $message;

            }
        }
        else
        {
            $data['error'] = $messages;
        }
        $data['title'] = _l('messages');
        $data['legal_services'] = $this->legal->get_all_services();
        $data['rel_type']    = $this->input->get('rel_type');
        $data['rel_id']    = $this->input->get('rel_id');
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

    public function get_sms($id)
    {
        $sms = get_sms($id);
        if (is_object($sms))
        {
            $data = [
                'sender' => $sms->phone,
                'msg' => $sms->msg,
                'msg_id' => $id,
                'created_at' => $sms->date,
                'staff_id' => get_staff_user_id()
            ];

            $success = $this->Receive_sms_model->add($data);
            if($success){
                echo json_encode(['status' => true, 'data' => $sms]);
                die();
            }
        }
        echo json_encode(['status' => false, 'msg' => 'Something went wrong!']);
    }

    public function save_sms()
    {
        $data = $this->input->post();

        $msg_id = $data['id'];

        $success = $this->Receive_sms_model->update($msg_id, $data);
        if($success){
            set_alert('success', _l('added_successfully'));
            redirect(admin_url('receive_sms'));
        }
        else{
            set_alert('warning', _l('problem'));
            redirect(admin_url('receive_sms'));
        }
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