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
        $mode = "inbox";
        $model = $this->Messages_model;
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data('my_messages', [
                'mode' => $mode,
                'model' => $model,

            ]);
        }

        // $options = array("user_id" => get_staff_user_id(), "mode" =>$mode );
        // $data['messages'] = $this->Messages_model->get_list($options)->result_array();

        $data['title'] = _l('internal_messages');
        $data['mode'] = "inbox";

        $this->load->view('admin/messages/manage', $data);

    }

    public function sent_items()
    {

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
                    handle_message_upload($id);
                    echo handle_message_upload($id);

                    set_alert('success', _l('added_successfully', _l('Message')));
                    redirect(admin_url('messages'));
                }
            } else {
                $success = $this->Messages_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Messages')));
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

        foreach ($staffs as $staff) {

            if ($staff->staffid == get_staff_user_id()) {
                continue;
            }
            // get_client_user_id()
            $user_name = $staff->firstname . " " . $staff->lastname . '.....موظف';

            $data['users_dropdown'][$staff->staffid] = $user_name;

        }
        foreach ($contacts as $contact) {

            if ($contact->id == get_contact_user_id()) {
                continue;
            }

            $user_name = $contact->firstname . " " . $contact->lastname . '......زبون';

            $data['users_dropdown'][$contact->id] = $user_name;
        }

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
                    echo handle_message_upload($id);

                    set_alert('success', _l('added_successfully', _l('Message')));
                    redirect(admin_url('messages'));
                }
            } else {
                $success = $this->Messages_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('Messages')));
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
            set_alert('success', _l('deleted', _l('Message')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('Message')));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function list_data($mode = "inbox")
    {

        if ($mode !== "inbox") {
            $mode = "sent_items";
        }

        $options = array("user_id" => get_staff_user_id(), "mode" => $mode);
        $list_data = $this->Messages_model->get_list($options)->result();

        $result = array();

        foreach ($list_data as $data) {
            $result[] = $this->make_row($data, $mode);
        }

        echo json_encode(array("data" => $result));
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

        $this->load->view('admin/messages/view', $view_data);

    }

    protected function get_access_info($group)
    {
        $info = new \stdClass();
        $info->access_type = "";
        $info->allowed_members = array();
        $info->allowed_ticket_types = array();
        $info->allowed_client_groups = array();
        $info->module_group = $group;

        //admin users has access to everything
        if ($this->login_user->is_admin) {
            $info->access_type = "all";
        } else {

            //not an admin user? check module wise access permissions
            $module_permission = get_array_value($this->login_user->permissions, $group);

            if ($module_permission === "all") {
                //this user's has permission to access/manage everything of this module (same as admin)
                $info->access_type = "all";
            } else if ($module_permission === "specific" || $module_permission === "specific_excluding_own") {
                //this user's has permission to access/manage sepcific items of this module

                $info->access_type = "specific";
                $module_permission = get_array_value($this->login_user->permissions, $group . "_specific");
                $permissions = explode(",", $module_permission);

                //check the accessable users list
                if ($group === "leave" || $group === "attendance" || $group === "team_member_update_permission" || $group === "timesheet_manage_permission" || $group == "message_permission" || $group == "timeline_permission") {
                    $info->allowed_members = prepare_allowed_members_array($permissions, $this->login_user->id);
                } else if ($group === "ticket") {
                    //check the accessable ticket types
                    $info->allowed_ticket_types = $permissions;
                } else if ($group === "client") {
                    //check the accessable client groups
                    $info->allowed_client_groups = $permissions;
                }
            } else if ($module_permission === "own" || $module_permission === "read_only" || $module_permission === "assigned_only" || $module_permission === "own_project_members" || $module_permission === "own_project_members_excluding_own") {
                $info->access_type = $module_permission;
            }
        }
        return $info;
    }

    public function make_row($data = null, $mode = "", $return_only_message = false, $online_status = false)
    {
        $image_url = "http://localhost:8012/codeigniter4/assets/images/avatar.jpg";
        $created_at = $data->created_at;
        $message_id = $data->main_message_id;
        $label = "";
        $reply = "";
        $status = "";
        $attachment_icon = "";
        $subject = $data->subject;
        if ($mode == "inbox") {
            $status = $data->status;
        }

        if ($data->reply_subject) {
            $label = " <label class='badge bg-success d-inline-block'>reply</label>";
            $reply = "1";
            $subject = $data->reply_subject;
        }

        if ($data->files && is_array(unserialize($data->files)) && count(unserialize($data->files))) {
            $attachment_icon = "<i data-feather='paperclip' class='icon-14 mr15'></i>";
        }

        //prepare online status
        $online = "";
        if ($online_status) {
            $online = "<i class='online'></i>";
        }

        $message = "<div class='message-row $status' data-id='$message_id' data-index='$data->main_message_id' data-reply='$reply'><div class='d-flex'><div class='flex-shrink-0'>
                        <span class='avatar avatar-xs'>
                            <img src='$image_url' />
                                $online
                        </span>
                    </div>
                    <div class='w-100 ps-3'>
                        <div class='mb5'>
                            <strong> $data->user_name</strong>
                                  <span class='text-off float-end time'>$attachment_icon $created_at</span>
                        </div>
                        $label $subject
                    </div></div></div>

                ";
        if ($return_only_message) {
            return $message;
        } else {
            return array(
                $message,
                $data->created_at,
                $status,
            );
        }
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

            //don't clean serilized data

            $id = $this->Messages_model->add($message_data);

            if ($id) {
                handle_message_upload($id);
                echo handle_message_upload($id);
                $message_data = $this->Messages_model->get_one($id);

            }
            echo json_encode($message_data);

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

        $count = $this->Messages_model->get_unread_messages();

        $data = array(

            'unseen_notification' => $count,
        );

        echo json_encode($data);
    }

}

/* End of file messages.php */
/* Location: ./app/controllers/messages.php */
