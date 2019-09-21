<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Session_Info extends AdminController{
	

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Service_sessions_model');
        $this->load->model('file_model');
        $this->load->model('Session_discussions_model');
        $this->load->model('currencies_model');
        $this->load->helper('date');
    }


    public function discussion($id = "")
    {
        if ($this->input->get()) {
            $message = '';
            $success = false;
            if (!$this->input->get('id')) {
                $id = $this->Session_discussions_model->add_discussion($this->input->get());
                if ($id) {
                    $success = true;
                    $message = _l('added_successfully', _l('project_discussion'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                ]);
            } else {
                $data = $this->input->get();
                $id   = $data['id'];
                unset($data['id']);
                $success = $this->Session_discussions_model->edit_discussion($data, $id);
                if ($success) {
                    $message = _l('updated_successfully', _l('project_discussion'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
            redirect($_SERVER['HTTP_REFERER']);
        }
    }    
    public function get_discussion($id = ''){
        $this->db->where('id', $id);

        $discussion = $this->db->get(db_prefix() . 'my_sessiondiscussions')->row();
        echo json_encode($discussion);
    }

    public function delete_discussion($id)
    {
        $success = false;
        if (has_permission('projects', '', 'delete')) {
            $success = $this->Session_discussions_model->delete_discussion($id);
        }
        $alert_type = 'warning';
        $message    = _l('project_discussion_failed_to_delete');
        if ($success) {
            $alert_type = 'success';
            $message    = _l('project_discussion_deleted');
        }
        echo json_encode([
            'alert_type' => $alert_type,
            'message'    => $message,
        ]);
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function session_detail($id = '', $service_id = '', $rel_id = '')
    {
        if($this->input->get('tab') == 'reminders')
            {
                if ($this->input->is_ajax_request()) {
                    $this->app->get_table_data('reminders', [
                        'id' => $rel_id,
                        'rel_type' => $service_id,
                    ]);
                }
            }
        if($this->input->get('tab'))
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('my_project_discussions', [
                    'session_id' => $id,
                ]);
            }
            
            $this->app_scripts->add(
                'projects-js',
                base_url($this->app_scripts->core_file('assets/js', 'projects.js')) . '?v=' . $this->app_scripts->core_version(),
                'admin',
                ['app-js', 'jquery-comments-js', 'jquery-gantt-js', 'circle-progress-js']
            );
            // Discussions
            if ($this->input->get('discussion_id')) {
                $data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
                $data['discussion']                        = $this->Session_discussions_model->get_discussion($this->input->get('discussion_id'), $id);
                $data['current_user_is_admin']             = is_admin();
            }
        $data['contract'] = $this->file_model->get_session_file($id);
        $data['title'] = 'Sessions Detail';
        $data['session_id'] = $id;
        $data['service_id'] = $service_id;
        $data['rel_id'] = $rel_id;
        $data['staff'] = $this->staff_model->get('', ['active' => 1]);
        $data['members'] = $data['staff'];
        $data['session'] = $this->Service_sessions_model->get($id);
        $data['court_name'] = $this->Service_sessions_model->get_court($data['session']->court_id);
        $data['judge_name'] = $this->Service_sessions_model->get_judges($data['session']->judge_id);
        $data['bodyclass']     = 'contract';
        $this->app_scripts->add('circle-progress-js', 'assets/plugins/jquery-circle-progress/circle-progress.min.js');
        $this->app_scripts->add('jquery-comments-js', 'assets/plugins/jquery-comments/js/jquery-comments.min.js');

        $this->load->view('admin/old_service_sessions/session', $data);
    }

    public function get_discussion_comments($id, $type)
    {
        echo json_encode($this->Session_discussions_model->get_discussion_comments($id, $type));
    }


    public function update_discussion_comment()
    {
        echo json_encode($this->Session_discussions_model->update_discussion_comment($this->input->post()));
    }

    public function delete_discussion_comment($id)
    {
        echo json_encode($this->Session_discussions_model->delete_discussion_comment($id));
    }
    public function add_discussion_comment($discussion_id, $type)
    {
        echo json_encode($this->Session_discussions_model->add_discussion_comment($this->input->post(), $discussion_id, $type));
    }

    public function edit_detail($id)
    {
    	$details = $this->input->get('details');
    	$success = $this->Service_sessions_model->update_details($id, ['details' => $details]);
    	if ($success){
    		set_alert('success', _l('detail_updated_successfuly'));
    	}else{
    		set_alert('danger', _l('problem_updating'));
    	}
    	redirect($_SERVER['HTTP_REFERER']);
    }
    public function edit_status($id){
        $status = $this->input->get('status');
        $success = $this->Service_sessions_model->update_details($id, ['status' => $status]);
        if ($success){
            set_alert('success', _l('status_updated_successfuly'));
        }else{
            set_alert('danger', _l('problem_updating'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function edit_result($id){
        $result = $this->input->get('result');
        $success = $this->Service_sessions_model->update_details($id, ['result' => $result]);
        if ($success){
            set_alert('success', _l('result_updated_successfuly'));
        }else{
            set_alert('danger', _l('problem_updating'));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function edit_next_action($id)
    {
    	$next_action = $this->input->get('next_action');
    	$success = $this->Service_sessions_model->update_details($id, ['next_action' => $next_action]);
    	if ($success){
    		set_alert('success', _l('next_action_updated_successfuly'));
    	}else{
    		set_alert('danger', _l('problem_updating'));
    	}
    	redirect($_SERVER['HTTP_REFERER']);
    }

	public function edit_next_date($id)
    {
    	$next_date = $this->input->get('next_date');
    	$success = $this->Service_sessions_model->update_details($id, ['next_date' => $next_date]);
    	if ($success){
    		set_alert('success', _l('next_date_updated_successfuly'));
    	}else{
    		set_alert('danger', _l('problem_updating'));
    	}
    	redirect($_SERVER['HTTP_REFERER']);
    }


    public function add_external_attachment()
    {
        if ($this->input->post()) {
            $this->add_attachment_to_database(
                $this->input->post('contract_id'),
                'attachments',
                $this->input->post('files'),
                $this->input->post('external')
            );
        }
    }

    public function add_contract_attachment($id)
    {
        $this->file_model->handle_contract_attachment($id);
    }


    public function delete_session_attachment($attachment_id)
    {
            echo json_encode([
                'success' => $this->file_model->delete_session_attachment($attachment_id),
            ]);
    }
    public function add_attachment_to_database($lead_id, $attachment, $external = false, $form_activity = false)
    {
        $this->file_model->add_attachment_to_database($lead_id, 'lead', $attachment, $external);

        if ($form_activity == false) {
            $this->leads_model->log_lead_activity($lead_id, 'not_lead_activity_added_attachment');
        } else {
            $this->leads_model->log_lead_activity($lead_id, 'not_lead_activity_log_attachment', true, serialize([
                $form_activity,
            ]));
        }

        // No notification when attachment is imported from web to lead form
        if ($form_activity == false) {
            $lead         = $this->get($lead_id);
            $not_user_ids = [];
            if ($lead->addedfrom != get_staff_user_id()) {
                array_push($not_user_ids, $lead->addedfrom);
            }
            if ($lead->assigned != get_staff_user_id() && $lead->assigned != 0) {
                array_push($not_user_ids, $lead->assigned);
            }
            $notifiedUsers = [];
            foreach ($not_user_ids as $uid) {
                $notified = add_notification([
                    'description'     => 'not_lead_added_attachment',
                    'touserid'        => $uid,
                    'link'            => '#leadid=' . $lead_id,
                    'additional_data' => serialize([
                        $lead->name,
                    ]),
                ]);
                if ($notified) {
                    array_push($notifiedUsers, $uid);
                }
            }
            pusher_trigger_notification($notifiedUsers);
        }
    }

}