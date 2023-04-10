<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Messages extends ClientsController
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Messages_model');
        //check user's login status, if not logged in redirect to signin page

    }
    public function index()
    {

        redirect("messages/inbox");
    }
    public function get_staff()
    {

        $data['staff'] = $this->Messages_model->get('', ['active' => 1]);
        $data['contact'] = $this->Messages_model->get_contact('', ['active' => 1]);

        return $data;

    }

    public function inbox()
    {
        if (!has_contact_permission('customer_see_email_only') && !has_contact_permission('messages') ) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }
        $mode = "inbox";

        $options = array("user_id" => get_contact_user_id(), "mode" => $mode);
        $data['messages'] = $this->Messages_model->get_list_client_contacts($options)->result_array();

        $data['title'] = _l('internal_messages');
        $data['mode'] = "inbox";
        $data['model'] = $this->Messages_model;

        $this->view('messages/index_inbox');
        $this->data($data);
        $this->layout();

    }

    public function sent_items()
    {
        $mode = "sent_items";

        $options = array("user_id" => get_contact_user_id(), "mode" => $mode);
        $data['messages'] = $this->Messages_model->get_list_client_contacts($options)->result_array();
        $data['model'] = $this->Messages_model;

        $data['title'] = _l('internal_messages');
        $data['mode'] = "sent_items";

        $this->view('messages/index');
        $this->data($data);
        $this->layout();

    }

    public function messagescu($id = '')
    {
        if (!has_contact_permission('messages')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('to_user_id', _l('to_user_id'), 'required');
            $this->form_validation->set_rules('subject', _l('subject'), 'required');
            $this->form_validation->set_rules('message', _l('message'), 'required');
            if ($this->form_validation->run() !== false) {
                $data = $this->input->post();
                $data['files'] = $_FILES['files']['name'];
                $data['to_user_id'] = $data['to_user_id'] . '_staff';
                $data['from_user_id'] = $data['from_user_id'] . '_client';

                if ($id == '') {
                    $id = $this->Messages_model->add($data);

                    if ($id) {
                        if(!file_exists('uploads/message')){
                            mkdir(FCPATH.'uploads/message', 0755);
                        }
                        handle_message_upload($id);

                        set_alert('success', _l('added_successfully', _l('Message')));
                        redirect('messages');
                    }
                } else {
                    $success = $this->Messages_model->update($data, $id);
                    if ($success) {
                        set_alert('success', _l('updated_successfully', _l('Messages')));
                    }
                    redirect('messages');
                }
            }
        }
        if ($id == '') {
            $title = _l('ارسال رسالة', _l(''));
        } else {
            $data['Messages'] = $this->Messages_model->get($id);
            $title = _l('edit', _l('messages'));
        }

        $data['users_dropdown'] = array("" => "-");

        $staffs = $this->get_staff()['staff'];

        foreach ($staffs as $staff) {

            if ($staff->staffid == get_staff_user_id()) {
                continue;
            }

            $user_name = $staff->firstname . " " . $staff->lastname . '.....:موظف';

            $data['users_dropdown'][$staff->staffid] = $user_name;
        }

        $data['title'] = $title;

        $this->view('messages/message');
        $this->data($data);
        $this->layout();

    }

    public function messagesd($id)
    {

        if (!$id) {
            redirect(admin_url('Messages/messagecu'));
        }
        $response = $this->Messages_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('Message')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Message')));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function view_view($message_id = 0, $mode = "sent_items", $reply = 0)
    {

        $message_mode = $mode;
        if ($reply == 1 && $mode == "inbox") {
            $message_mode = "sent_items";
        } else if ($reply == 1 && $mode == "sent_items") {
            $message_mode = "inbox";
        }

        $options = array("id" => $message_id, "user_id" => get_contact_user_id(), "mode" => $message_mode);
        $view_data["message_info"] = $this->Messages_model->get_details($options)->row;

        //change message status to read
        // $this->Messages_model->set_message_status_as_read($view_data["message_info"]->id, 3);

        $replies_options = array("message_id" => $message_id, "user_id" => get_contact_user_id(), "limit" => 4);
        $messages = $this->Messages_model->get_details($replies_options);
        $view_data["replies"] = $messages->result;
        $view_data["found_rows"] = $messages->found_rows;
        $view_data["mode"] = $mode;
        $view_data["is_reply"] = $reply;
        $view_data['reply_messages'] = $this->Messages_model->get_reply_all($message_id);
        $view_data['model'] = $this->Messages_model;
        $this->view('messages/view');
        $this->data($view_data);
        $this->layout();

    }

    public function send_message()
    {
        $data = $this->input->post();
        $data['from_user_id'] = get_staff_user_id();

        $data['created_at'] = get_current_utc_time();
        $data['deleted_by_users'] = "1";

        $this->Messages_model->add($data);

        redirect("admin/messages/inbox");

    }
    public function reply_client()
    {

        $message_id = $this->input->post('message_id');

        $message_info = $this->Messages_model->get_one($message_id);
        if ($message_info->id) {
            //check, where we have to send this message
            $to_user_id = 0;
            if ($message_info->from_user_id === get_contact_user_id() . '_client') {
                $to_user_id = $message_info->to_user_id;
            } else {
                $to_user_id = $message_info->from_user_id;
            }

            // $message = $this->request->getPost('message');
            $data['message'] = $this->input->post('description');
            $data['files'] = $_FILES['files']['name'];

            $message_data = array(
                "from_user_id" => get_contact_user_id() . '_client',
                "to_user_id" => $to_user_id,
                "message_id" => $message_id,
                "message" => $data['message'],
                // "created_at" => '',
                "files" => $data['files'],

            );
            $from_user_id = get_contact_user_id() . '_client';
            //don't clean serilized data

            $id = $this->Messages_model->add($message_data);

            if ($id) {
                handle_message_upload($id);

                $message_data = $this->Messages_model->get_one($id);

            }
            $member = $this->Messages_model->GetSender($from_user_id);
            echo json_encode(array('member' => $member, 'message' => $message_data));
            // echo json_encode($message_data);

        } else {
            echo json_encode(array("success" => true));
        }

    }

    public function reply_messages_all($message_id)
    {
        $data['result'] = $this->Messages_model->get_reply_all($message_id);

    }

    public function messages_notefication()
    {

        $view = $this->input->post('view');
        if ($view !== '') {
            $this->Messages_model->update_notification($view);

        }

        $count = $this->Messages_model->get_unread_messages_client();

        $data = array(

            'unseen_notification' => $count,
        );

        echo json_encode($data);
    }

}

/* End of file messages.php */
/* Location: ./app/controllers/messages.php */
