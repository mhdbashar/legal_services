<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Messages extends AdminController
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Messages_model');
        //check user's login status, if not logged in redirect to signin page

    }
    public function index()
    {

        redirect("admin/messages/inbox");
    }
    public function get_staff()
    {

        $data['staff'] = $this->Messages_model->get('', ['active' => 1]);
        $data['contact'] = $this->Messages_model->get_contact('', ['active' => 1]);

        return $data;

    }

    public function inbox()
    {
        if (!has_permission('system_messages', '', 'create') && !has_permission('system_messages_client', '', 'create') && !has_permission('see_email_only', '', 'view')) {
            access_denied('system_messages');
        }
        $mode = "inbox";
        $model = $this->Messages_model;
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_messages', [
                'mode' => $mode,
                'model' => $model,

            ]);
        }

        $data['title'] = _l('internal_messages');
        $data['mode'] = "inbox";

        $this->load->view('admin/messages/manage', $data);

    }

    public function sent_items()
    {
        if (!has_permission('system_messages', '', 'create') && !has_permission('system_messages_client', '', 'create') && !has_permission('see_email_only', '', 'view')) {
            access_denied('system_messages');
        }
        $mode = "sent_items";
        $model = $this->Messages_model;
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_messages_sent_items', [
                'mode' => $mode,
                'model' => $model,

            ]);
        }

        //$options = array("user_id" => get_staff_user_id(), "mode" => $mode);
        // $data['messages'] = $this->Messages_model->get_list_sent_items($options)->result_array();

        $data['title'] = _l('internal_messages');
        $data['mode'] = "sent_items";

        $this->load->view('admin/messages/manage_sent_items', $data);

    }

    public function messagescu($id = '')
    {
        if (!has_permission('system_messages', '', 'create')) {
            access_denied('system_messages');
        }

        if ($this->input->post()) {
            $data = $this->input->post();
            $data['files'] = $_FILES['files']['name'];
            $data['to_user_id'] = $this->input->post('to_user_id');

            $data['from_user_id'] = $data['from_user_id'] . '_staff';

            if ($id == '') {
                $id = $this->Messages_model->add($data);

                if ($id) {
                    if (!file_exists('uploads/message')) {
                        mkdir(FCPATH . 'uploads/message', 0755);
                    }
                    handle_message_upload($id);

                    set_alert('success', _l('added_successfully', _l('message')));
                    redirect(admin_url('messages/sent_items'));
                }
            } else {
                $success = $this->Messages_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('message')));
                }
                redirect(admin_url('Messages'));
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
        $contacts = $this->get_staff()['contact'];

        $data['staffs'] = $staffs;
        $data['contacts'] = $contacts;

        $data['user_type'] = 'staff';
        $data['title'] = $title;
        $this->load->view('admin/messages/message', $data);
    }

    public function messagescu_client($id = '')
    {
        if (!has_permission('system_messages_client', '', 'create')) {
            access_denied('system_messages_client');
        }

        if ($this->input->post()) {
            $data = $this->input->post();
            $data['files'] = $_FILES['files']['name'];
            $data['to_user_id'] = $this->input->post('to_user_id');

            $data['from_user_id'] = $data['from_user_id'] . '_staff';
            if ($id == '') {
                $id = $this->Messages_model->add($data);

                if ($id) {
                    handle_message_upload($id);

                    set_alert('success', _l('added_successfully', _l('message')));
                    redirect(admin_url('messages/sent_items'));
                }
            } else {
                $success = $this->Messages_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('message')));
                }
                redirect(admin_url('messages/sent_items'));
            }
        }
        if ($id == '') {
            $title = _l('ارسال رسالة', _l(''));
        } else {
            $data['Messages'] = $this->Messages_model->get($id);
            $title = _l('edit', _l('messages'));
        }

        $data['users_dropdown'] = array("" => "-");

        $contacts = $this->get_staff()['contact'];

        $data['contacts'] = $contacts;

        foreach ($contacts as $contact) {

            if ($contact->id == get_contact_user_id()) {
                continue;
            }

            $user_name = $contact->firstname . " " . $contact->lastname . '......زبون';

            $data['users_dropdown'][$contact->id] = $user_name;
        }

        $data['title'] = $title;
        $this->load->view('admin/messages/message_client', $data);
    }

    public function messagesd($id)
    {
        if (!has_permission('system_messages', '', 'delete')) {
            access_denied('system_messages');
        }
        if (!$id) {
            redirect(admin_url('Messages/messagecu'));
        }
        $response = $this->Messages_model->delete($id);

        if ($response == true) {
            set_alert('success', _l('deleted', _l('message')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('message')));
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

        $options = array("id" => $message_id, "user_id" => get_staff_user_id(), "mode" => $message_mode);
        $view_data["message_info"] = $this->Messages_model->get_details($options)->row;

        //change message status to read
        // $this->Messages_model->set_message_status_as_read($view_data["message_info"]->id, 3);

        $replies_options = array("message_id" => $message_id, "user_id" => get_staff_user_id());
        $messages = $this->Messages_model->get_details($replies_options);

        $view_data["replies"] = $messages->result;
        $view_data["found_rows"] = $messages->found_rows;

        $view_data["mode"] = $mode;
        $view_data["is_reply"] = $reply;
        $view_data['reply_messages'] = $this->Messages_model->get_reply_all($message_id);
        $view_data['model'] = $this->Messages_model;

        $this->load->view('admin/messages/view', $view_data);

    }
    public function view_view_sent_items($message_id = 0, $mode = "sent_items", $reply = 0)
    {

        $message_mode = $mode;
        if ($reply == 1 && $mode == "inbox") {
            $message_mode = "sent_items";
        } else if ($reply == 1 && $mode == "sent_items") {
            $message_mode = "inbox";
        }

        $options = array("id" => $message_id, "user_id" => get_staff_user_id(), "mode" => $message_mode);
        $view_data["message_info"] = $this->Messages_model->get_details($options)->row;

        //change message status to read
        // $this->Messages_model->set_message_status_as_read($view_data["message_info"]->id, 3);

        $replies_options = array("message_id" => $message_id, "user_id" => get_staff_user_id());
        $messages = $this->Messages_model->get_details($replies_options);

        $view_data["replies"] = $messages->result;
        $view_data["found_rows"] = $messages->found_rows;

        $view_data["mode"] = $mode;
        $view_data["is_reply"] = $reply;
        $view_data['reply_messages'] = $this->Messages_model->get_reply_all($message_id);
        $view_data['model'] = $this->Messages_model;

        $this->load->view('admin/messages/view_sent_items', $view_data);

    }

    public function is_my_message($message_info)
    {
        if ($message_info->from_user_id == get_staff_user_id() || $message_info->to_user_id == get_staff_user_id()) {
            return true;
        }
    }
    public function reply()
    {

        $message_id = $this->input->post('message_id');
        $message_info = $this->Messages_model->get_one($message_id);
        if ($message_info->id) {
            //check, where we have to send this message
            $to_user_id = 0;
            if ($message_info->from_user_id === get_staff_user_id() . '_staff') {
                $to_user_id = $message_info->to_user_id;
            } else {
                $to_user_id = $message_info->from_user_id;

            }

            // $message = $this->request->getPost('message');
            $data['message'] = $this->input->post('description');
            $data['files'] = $_FILES['files']['name'];

            $message_data = array(
                "from_user_id" => get_staff_user_id() . '_staff',
                "to_user_id" => $to_user_id,
                "message_id" => $message_id,
                "message" => $data['message'],
                // "created_at" => '',
                "files" => $data['files'],

            );
            $from_user_id = get_staff_user_id() . '_staff';
            //don't clean serilized data

            $id = $this->Messages_model->add($message_data);

            if ($id) {
                handle_message_upload($id);

                $message_data = $this->Messages_model->get_one($id);
                $member = $this->Messages_model->GetSender($from_user_id);
            }
            echo json_encode(array('member' => $member, 'message' => $message_data));

        } else {
            echo json_encode(array("success" => true));
        }

    }

    public function messages_notefication()
    {

        $view = $this->input->post('view');
        if ($view !== '') {
            $this->Messages_model->update_notification($view);

        }

        $count = $this->Messages_model->get_unread_messages();

        $data = array(

            'unseen_notification' => $count,
        );

        echo json_encode($data);
    }

}

/* End of file messages.php */
/* Location: ./app/controllers/messages.php */
