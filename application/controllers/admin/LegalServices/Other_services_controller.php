
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Other_services_controller extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->load->model('LegalServices/LegalServicesModel', 'legal');
        $this->load->model('LegalServices/Other_services_model', 'other');
        $this->load->model('Customer_representative_model', 'representative');
        $this->load->model('LegalServices/ServicesSessions_model', 'service_sessions');
        $this->load->model('currencies_model');
        $this->load->model('tasks_model');
        $this->load->model('LegalServices/Phase_model', 'phase');
        $this->load->helper('date');
        $this->load->model('Staff_model');
        $this->load->model('LegalServices/Legal_procedures_model', 'procedures');
        $this->load->model('emails_model');
    }

    public function get_token_by_office_name($office_name){
        $cURLConnection = curl_init();
        $url = 'https://legaloffices.babillawnet.com/api/get_token/'.$office_name;
        curl_setopt($cURLConnection, CURLOPT_URL, $url);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);



        $List = curl_exec($cURLConnection);
        curl_close($cURLConnection);

        $jsonArrayResponse = json_decode($List);
        if (!isset($jsonArrayResponse->token)) {
            // var_dump($jsonArrayResponse); echo $url; exit;
            set_alert('danger', _l('problem_exporting'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        return $jsonArrayResponse;
    }

    private function check_if_client_exists($token, $url, $email) {
        $url .= 'customers/data_search/' . $email;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", $token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $url);


        $result = curl_exec($ch);
        $client = json_decode($result);
        curl_close($ch);

        if (is_array($client))
            return ($client[0]->userid);
        return false;
    }

    private function create_client_for_company($token, $url, $company, $email, $password) {
        $url .= 'customers/data';
        $data = [
            'company' => $company,
            'is_primary' => 1,
            'firstname' => $company,
            'email' => $email,
            'createddate' => date("Y-m-d h:i:sa"),
            'password' => $password,
            'email_verified_at' => date("Y-m-d h:i:sa"),
            'active' => 1,
            'invoice_emails' => 1,
            'estimate_emails' => 1
        ];
        $post_data = http_build_query($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", $token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);
        $response_object = (json_decode($result));
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
            return false;
        } else {
            return true;
        }
        curl_close($ch);
    }

    public function encode_string($office_name = '', $length = 1000) {

        $key = '';
        $k = $office_name;
        $c = "شبكة بابل للقانون";

        for ($i = 0; $i < $length; $i++) {
            $key = base64_encode(base64_encode(base64_encode($k) . $i . $c));
            $rr = base64_encode($key);
        }

        return $rr;
    }

    // Example URL : http://localhost/legalserv1/admin/LegalServices/other_services_controller/export_service/2/1
    public function export_service($ServID, $id, $case = false) {

        //$token = 'authtoken: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoia2FtZWwiLCJuYW1lIjoia2FtZWwiLCJwYXNzd29yZCI6bnVsbCwiQVBJX1RJTUUiOjE1OTQ0ODA4MDV9.XP3GpLSFnjZDrpPp9yEm22V80Y385iBeAo3TmTRgZ78	';

        $this->load->model('LegalServices/Cases_model', 'case');

        $office_name = $this->input->post('office_name');


        // $keycode = $this->encode_string($office_name);



        // $cURLConnection = curl_init();

        //$url = 'http://localhost/legal/api/get_token/';


//================== Unknown method =====================
        // $url = 'https://legaloffices.babillawnet.com/api/get_token/';
        // curl_setopt($cURLConnection, CURLOPT_URL, $url);
        // curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($cURLConnection, CURLOPT_POST, 1);
        // curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, "office_name=$office_name&keycode=$keycode");
        // $List = curl_exec($cURLConnection);
        // curl_close($cURLConnection);
//================== Unknown method =====================


//         $url = 'https://legaloffices.babillawnet.com/api/get_token/'.$office_name;
//         curl_setopt($cURLConnection, CURLOPT_URL, $url);
//         curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);



//         $List = curl_exec($cURLConnection);
//         curl_close($cURLConnection);

//         $jsonArrayResponse = json_decode($List);
//         if (!isset($jsonArrayResponse->token)) {
//             // var_dump($jsonArrayResponse); echo $url; exit;
//             set_alert('danger', _l('problem_exporting'));
//             redirect($_SERVER['HTTP_REFERER']);
//         }
//         $t = $jsonArrayResponse->token;
//         $office_url = $jsonArrayResponse->office_url;

// //$token = 'authtoken: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoia2FtZWwiLCJuYW1lIjoia2FtZWwiLCJwYXNzd29yZCI6bnVsbCwiQVBJX1RJTUUiOjE1OTQ0ODA4MDV9.XP3GpLSFnjZDrpPp9yEm22V80Y385iBeAo3TmTRgZ78	';
//         $token = 'authtoken:' . $t;
//         $main_url = $office_url . 'api/';
        $token_object = $this->get_token_by_office_name($office_name);

        // print_r($token_object->office_url); exit;
        $token = 'authtoken:' . $token_object->token;
        $office_url = $token_object->office_url;
        $main_url = $office_url . 'api/';
        $url = $main_url . 'Service/data';

        $post_data = '';
        if ($case) {
            $this->db->where(['id' => $id]);
            $data = ($this->db->get('tblmy_cases')->row_array());
            $data['service_id'] = 1;
            $data['rel_id'] = $id;
            $data['files'] = $this->case->get_files($id);
            $this->db->where('case_id', $id);
            $data['available_features'] = $this->db->get("tblcase_settings")->row_array()['value'];
        } else {
            $this->db->where(['id' => $id, 'service_id' => $ServID]);
            $data = ($this->db->get('tblmy_other_services')->row_array());
            $data['files'] = $this->other->get_files($id);
            $data['rel_id'] = $id;
            $this->db->where('oservice_id', $id);
            $data['available_features'] = $this->db->get("tbloservice_settings")->row_array()['value'];
        }

        //echo '<pre>'; print_r($data['files']); exit;

        $service_name = $data['name'];
        // $data['settings'] = array( 'available_features' => array( 'project_overview => 1','project_estimates => 1'
        //     ,'project_milestones => 1', 'project_gantt => 1', 'project_tasks => 1', 'project_estimates => 1', 'project_subscriptions => 1', 'project_invoices => 1', 'project_expenses => 1', 
        //     'project_credit_notes => 1', 'project_tickets => 1', 'project_timesheets => 1', 'project_files => 1', 'project_discussions => 1', 'project_notes => 1', 'project_activity => 1'
        // ));

        $this->db->where('country_id', $data['country']);
        $country = null;
        $country_array = $this->db->get("tblcountries")->row_array();
        if (isset($country_array['short_name_ar']))
            $country = $country_array['short_name_ar'];

        if ($country == null)
            $country = '';
        $data['country'] = $country;
        $data['company_url'] = base_url();



        $this->db->where('name', 'companyname');
        $companyname = $this->db->get('tbloptions')->row_array()['value'];

        $this->db->where('name', 'smtp_email');
        $smtp_email = $this->db->get('tbloptions')->row_array()['value'];

        $client_id = 0;
        //$smtp_email = 'hiastskype@gmail.com';
        if ($smtp_email == '') {
            set_alert('danger', _l('problem_exporting'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        $charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($charset), -5, 4);

        $client_exists = $this->check_if_client_exists($token, $main_url, $smtp_email);
        if ($client_exists)
            $client_id = $client_exists;
        else {
            if ($this->create_client_for_company($token, $main_url, $companyname, $smtp_email, $password)) {
                $try_2 = $this->check_if_client_exists($token, $main_url, $smtp_email);
                if ($try_2)
                    $client_id = $try_2;
            }
        }
        if ($client_id == 0) {
            set_alert('danger', _l('problem_exporting'));
            redirect($_SERVER['HTTP_REFERER']);
        }



        $data['clientid'] = $client_id;
        $post_data = http_build_query($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", $token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);
        $response_object = (json_decode($result));
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
            var_dump($result);
            exit;
        } else {
            $office_id = $response_object->office_id;
            if ($client_exists) {
                $this->db->where('url', $office_url);
                $old_exported = $this->db->get('tblmy_exported_services')->row();
                if (isset($old_exported->email) and isset($old_exported->password)) {
                    $smtp_email = $old_exported->email;
                    $password = $old_exported->password;
                } else {
                    $password = '';
                }
            }
            $exported_data = [
                'email' => $smtp_email,
                'password' => $password,
                'url' => $office_url,
                'service_id' => $ServID,
                'rel_id' => $id,
                'office_id' => $office_id,
                'office_name' => $office_name
            ];
            $this->db->insert('tblmy_exported_services', $exported_data);
            $insert_id = $this->db->insert_id();
            $notified = add_notification([
                'description' => 'Service exported successfully <br>email: ' . $smtp_email . ' <br>password: ' . $password,
                'touserid' => get_staff_user_id(),
                'fromcompany' => 1,
                'fromuserid' => null,
                'link' => 'LegalServices/other_services_controller/follow_service_from_notification?url=' . $office_url,
                'description' => 'Service exported successfully<br>Service name: ' . $service_name . '<br>Email: ' . $smtp_email . '<br>Password: ' . $password,
                'touserid' => get_staff_user_id(),
                'fromcompany' => 1,
                'fromuserid' => null,
                'link' => 'LegalServices/other_services_controller/follow_service_from_notification?url=' . $office_url,
            ]);
            set_alert('success', _l('exported_successfully'));
        }
        curl_close($ch);
        redirect($_SERVER['HTTP_REFERER']);
    }

    // Example URL : http://localhost/legalserv1/admin/LegalServices/other_services_controller/export_service/2/1
    public function export_case($id) {
        $this->export_service(1, $id, true);
    }

    public function follow_service($ServID, $id) {
        $this->db->where(['service_id' => $ServID, 'rel_id' => $id]);
        $exported_service = $this->db->get('tblmy_exported_services')->row();


        $tokenObject = $this->get_token_by_office_name($exported_service->office_name);
        $token = 'authtoken:' . $tokenObject->token;
        $url = $tokenObject->office_url;

        $url .= 'api/Service/deleted_imported?id=' . $exported_service->office_id;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", $token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $url);


        $result = curl_exec($ch);
        $result = json_decode($result);
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
            $this->db->where(['service_id' => $ServID, 'rel_id' => $id]);
            $this->db->delete('tblmy_exported_services');
            set_alert('danger', _l('LService_not_found'));
            redirect($_SERVER['HTTP_REFERER']);
        } 
        curl_close($ch);

        redirect($exported_service->url);
    }


    public function add($ServID) {
        if (!has_permission('projects', '', 'edit') && !has_permission('projects', '', 'create')) {
            access_denied('Projects');
        }
        $ExistServ = $this->legal->CheckExistService($ServID);
        if ($ExistServ == 0 || !$ServID) {
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("Service/$ServID"));
        }
        if ($this->input->post()) {
            $data = $this->input->post();
            $data['description'] = html_purify($this->input->post('description', false));
            $id = $this->other->add($ServID, $data);
            if ($id) {
                foreach ($data['project_members'] as $staff_id) {
                    $staff = $this->Staff_model->get($staff_id);
                    $send = $this->emails_model->send_email_template('new-other_services-created-to-staff', $staff->email, [
                        'other_service_name' => $data['name'],
                        'staff_firstname' => $staff->firstname,
                        'other_service_description' => $data['description'],
                        'other_service_link' => admin_url('SOther/view/' . $ServID . '/' . $id),
                            ]
                    );
                }
                set_alert('success', _l('added_successfully'));
                redirect(admin_url("SOther/view/$ServID/$id"));
            }
        }

        $data['Numbering'] = $this->other->GetTopNumbering();
        $data['service'] = $this->legal->get_service_by_id($ServID)->row();
        $data['auto_select_billing_type'] = $this->other->get_most_used_billing_type();
        $data['last_project_settings'] = $this->other->get_last_project_settings();
        if (count($data['last_project_settings'])) {
            $key = array_search('available_features', array_column($data['last_project_settings'], 'name'));
            $data['last_project_settings'][$key]['value'] = unserialize($data['last_project_settings'][$key]['value']);
        }
        if ($this->input->get('customer_id')) {
            $data['customer_id'] = $this->input->get('customer_id');
        }
        $data['settings'] = $this->other->get_settings();
        $data['statuses'] = $this->other->get_project_statuses();
        $data['staff'] = $this->staff_model->get('', ['active' => 1]);
        $data['ServID'] = $ServID;
        $data['title'] = _l('permission_create') . ' ' . _l('LegalService');
        $this->load->view('admin/LegalServices/other_services/Add', $data);
    }

    public function edit($ServID, $id) {
        if (!has_permission('projects', '', 'edit') && !has_permission('projects', '', 'create')) {
            access_denied('Projects');
        }
        if (!$id) {
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("Service/$ServID"));
        }
        if ($this->input->post()) {
            $data = $this->input->post();
            $success = $this->other->update($ServID, $id, $data);
            if ($success) {
                set_alert('success', _l('updated_successfully'));
                redirect(admin_url("Service/$ServID"));
            } else {
                set_alert('warning', _l('problem_updating'));
                redirect(admin_url("Service/$ServID"));
            }
        }
        $data['OtherServ'] = $this->other->get($ServID, $id);
        $data['other_members'] = $this->other->get_project_members($id);
        $data['OtherServ']->settings->available_features = unserialize($data['OtherServ']->settings->available_features);
        $data['service'] = $this->legal->get_service_by_id($ServID)->row();
        $data['auto_select_billing_type'] = $this->other->get_most_used_billing_type();
        $data['last_project_settings'] = $this->other->get_last_project_settings();
        if (count($data['last_project_settings'])) {
            $key = array_search('available_features', array_column($data['last_project_settings'], 'name'));
            $data['last_project_settings'][$key]['value'] = unserialize($data['last_project_settings'][$key]['value']);
        }
        if ($this->input->get('customer_id')) {
            $data['customer_id'] = $this->input->get('customer_id');
        }
        $data['settings'] = $this->other->get_settings();
        $data['statuses'] = $this->other->get_project_statuses();
        $data['staff'] = $this->staff_model->get('', ['active' => 1]);
        $data['ServID'] = $ServID;
        $data['title'] = _l('edit') . ' ' . _l('LegalService');
        $this->load->view('admin/LegalServices/other_services/Edit', $data);
    }

    public function delete($ServID, $id) {
        if (!has_permission('legal_recycle_bin', '', 'delete')) {
            access_denied('legal_recycle_bin');
        }
        if (!$id) {
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("LegalServices/LegalServices_controller/legal_recycle_bin/$ServID"));
        }
        $response = $this->other->delete($ServID, $id);
        if ($response == true) {
            set_alert('success', _l('deleted'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect(admin_url("LegalServices/LegalServices_controller/legal_recycle_bin/$ServID"));
    }

    public function move_to_recycle_bin($ServID, $id) {
        if (!$id) {
            set_alert('danger', _l('WrongEntry'));
            redirect(admin_url("Service/$ServID"));
        }
        $response = $this->other->move_to_recycle_bin($ServID, $id);
        if ($response == true) {
            set_alert('success', _l('deleted'));
        } else {
            set_alert('warning', _l('problem_deleting'));
        }
        redirect(admin_url("Service/$ServID"));
    }

    public function table($clientid = '') {
        $this->app->get_table_data('cases', [
            'clientid' => $clientid,
        ]);
    }

    public function staff_services() {
        $this->app->get_table_data('staff_services');
    }

    public function expenses($id, $slug = '') {
        $this->load->model('expenses_model');
        $this->app->get_table_data('oservice_expenses', [
            'project_id' => $id,
            'slug' => $slug
        ]);
    }

    public function add_expense($ServID = '', $project_id = '') {
        if ($this->input->post()) {
            $this->load->model('expenses_model');
            $data = array();
            $data = $this->input->post();
            $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
            $data['rel_stype'] = $slug;
            $data['rel_sid'] = $project_id;
            $data['project_id'] = 0;
            $id = $this->expenses_model->add_for_oservice($ServID, $data);
            if ($id) {
                set_alert('success', _l('added_successfully', _l('expense')));
                echo json_encode([
                    'url' => admin_url('SOther/view/' . $ServID . '/' . $this->input->post('project_id') . '/?group=project_expenses'),
                    'expenseid' => $id,
                ]);
                die;
            }
            echo json_encode([
                'url' => admin_url('SOther/view/' . $ServID . '/' . $this->input->post('project_id') . '/?group=project_expenses'),
            ]);
            die;
        }
    }

    public function gantt($ServID) {
        $data['title'] = _l('project_gant');
        $selected_statuses = [];
        $selectedMember = null;
        $data['statuses'] = $this->other->get_project_statuses();

        $appliedStatuses = $this->input->get('status');
        $appliedMember = $this->input->get('member');

        $allStatusesIds = [];
        foreach ($data['statuses'] as $status) {
            if (!isset($status['filter_default']) || (isset($status['filter_default']) && $status['filter_default']) && !$appliedStatuses) {
                $selected_statuses[] = $status['id'];
            } elseif ($appliedStatuses) {
                if (in_array($status['id'], $appliedStatuses)) {
                    $selected_statuses[] = $status['id'];
                }
            } else {
                // All statuses
                $allStatusesIds[] = $status['id'];
            }
        }

        if (count($selected_statuses) == 0) {
            $selected_statuses = $allStatusesIds;
        }

        $data['selected_statuses'] = $selected_statuses;

        if (has_permission('projects', '', 'view')) {
            $selectedMember = $appliedMember;
            $data['selectedMember'] = $selectedMember;
            $data['project_members'] = $this->other->get_distinct_projects_members();
        }

        $data['gantt_data'] = $this->other->get_all_projects_gantt_data($ServID, [
            'status' => $selected_statuses,
            'member' => $selectedMember,
        ]);

        $this->load->view('admin/LegalServices/other_services/gantt', $data);
    }

    public function view($ServID, $id) {
        if (has_permission('projects', '', 'view') || $this->other->is_member($id)) {
            $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
            close_setup_menu();
            $project = $this->other->get($ServID, $id);

            if (!$project) {
                blank_page(_l('LService_not_found'));
            }

            $project->settings->available_features = unserialize($project->settings->available_features);
            $data['statuses'] = $this->other->get_project_statuses();

            $group = !$this->input->get('group') ? 'project_overview' : $this->input->get('group');

            // Unable to load the requested file: admin/projects/project_tasks#.php - FIX
            if (strpos($group, '#') !== false) {
                $group = str_replace('#', '', $group);
            }

            $data['tabs'] = get_oservice_tabs_admin();
            $data['tab'] = $this->app_tabs->filter_tab($data['tabs'], $group);

            if (!$data['tab']) {
                show_404();
            }

            $this->load->model('payment_modes_model');
            $data['payment_modes'] = $this->payment_modes_model->get('', [], true);

            $data['project'] = $project;
            $data['currency'] = $this->other->get_currency($id);

            $data['project_total_logged_time'] = $this->other->total_logged_time($slug, $id);

            $data['staff'] = $this->staff_model->get('', ['active' => 1]);
            $percent = $this->other->calc_progress($slug, $id);
            $data['bodyclass'] = '';

            //$this->app_scripts->add('oservices-js', 'assets/js/oservices.js');
            $this->app_scripts->add(
                    'projects-js', base_url($this->app_scripts->core_file('assets/js', 'oservices.js')) . '?v=' . $this->app_scripts->core_version(), 'admin', ['app-js', 'jquery-comments-js', 'jquery-gantt-js', 'circle-progress-js']
            );
            $this->app_scripts->add('legal_proc', 'assets/js/legal_proc.js');

            if ($group == 'project_overview') {
                $data['members'] = $this->other->get_project_members($id);
                foreach ($data['members'] as $key => $member) {
                    $data['members'][$key]['total_logged_time'] = 0;
                    $member_timesheets = $this->tasks_model->get_unique_member_logged_task_ids($member['staff_id'], ' AND task_id IN (SELECT id FROM ' . db_prefix() . 'tasks WHERE rel_type="' . $slug . '" AND rel_id="' . $this->db->escape_str($id) . '")');

                    foreach ($member_timesheets as $member_task) {
                        $data['members'][$key]['total_logged_time'] += $this->tasks_model->calc_task_total_time($member_task->task_id, ' AND staff_id=' . $member['staff_id']);
                    }
                }

                $data['project_total_days'] = round((human_to_unix($data['project']->deadline . ' 00:00') - human_to_unix($data['project']->start_date . ' 00:00')) / 3600 / 24);
                $data['project_days_left'] = $data['project_total_days'];
                $data['project_time_left_percent'] = 100;
                if ($data['project']->deadline) {
                    if (human_to_unix($data['project']->start_date . ' 00:00') < time() && human_to_unix($data['project']->deadline . ' 00:00') > time()) {
                        $data['project_days_left'] = round((human_to_unix($data['project']->deadline . ' 00:00') - time()) / 3600 / 24);
                        $data['project_time_left_percent'] = $data['project_days_left'] / $data['project_total_days'] * 100;
                        $data['project_time_left_percent'] = round($data['project_time_left_percent'], 2);
                    }
                    if (human_to_unix($data['project']->deadline . ' 00:00') < time()) {
                        $data['project_days_left'] = 0;
                        $data['project_time_left_percent'] = 0;
                    }
                }

                $__total_where_tasks = 'rel_type = "' . $slug . '" AND rel_id=' . $this->db->escape_str($id);
                if (!has_permission('tasks', '', 'view')) {
                    $__total_where_tasks .= ' AND ' . db_prefix() . 'tasks.id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid = ' . get_staff_user_id() . ')';

                    if (get_option('show_all_tasks_for_project_member') == 1) {
                        $__total_where_tasks .= ' AND (rel_type="' . $slug . '" AND rel_id IN (SELECT oservice_id FROM ' . db_prefix() . 'my_members_services WHERE staff_id=' . get_staff_user_id() . '))';
                    }
                }

                $__total_where_tasks = hooks()->apply_filters('admin_total_project_tasks_where', $__total_where_tasks, $id);

                $where = ($__total_where_tasks == '' ? '' : $__total_where_tasks . ' AND ') . 'status != ' . Tasks_model::STATUS_COMPLETE;

                $data['tasks_not_completed'] = total_rows(db_prefix() . 'tasks', $where);
                $total_tasks = total_rows(db_prefix() . 'tasks', $__total_where_tasks);
                $data['total_tasks'] = $total_tasks;

                $where = ($__total_where_tasks == '' ? '' : $__total_where_tasks . ' AND ') . 'status = ' . Tasks_model::STATUS_COMPLETE . ' AND rel_type="' . $slug . '" AND rel_id="' . $id . '"';

                $data['tasks_completed'] = total_rows(db_prefix() . 'tasks', $where);

                $data['tasks_not_completed_progress'] = ($total_tasks > 0 ? number_format(($data['tasks_completed'] * 100) / $total_tasks, 2) : 0);
                $data['tasks_not_completed_progress'] = round($data['tasks_not_completed_progress'], 2);

                @$percent_circle = $percent / 100;
                $data['percent_circle'] = $percent_circle;


                $data['project_overview_chart'] = $this->other->get_project_overview_weekly_chart_data($id, ($this->input->get('overview_chart') ? $this->input->get('overview_chart') : 'this_week'));
            } elseif ($group == 'project_invoices') {
                $this->load->model('invoices_model');

                $data['invoiceid'] = '';
                $data['status'] = '';
                $data['custom_view'] = '';

                $data['invoices_years'] = $this->invoices_model->get_invoices_years();
                $data['invoices_sale_agents'] = $this->invoices_model->get_sale_agents();
                $data['invoices_statuses'] = $this->invoices_model->get_statuses();
            } elseif ($group == 'project_gantt') {
                $gantt_type = (!$this->input->get('gantt_type') ? 'milestones' : $this->input->get('gantt_type'));
                $taskStatus = (!$this->input->get('gantt_task_status') ? null : $this->input->get('gantt_task_status'));
                $data['gantt_data'] = $this->other->get_gantt_data($slug, $id, $gantt_type, $taskStatus);
            } elseif ($group == 'project_milestones') {
                $data['bodyclass'] .= 'project-milestones ';
                $data['milestones_exclude_completed_tasks'] = $this->input->get('exclude_completed') && $this->input->get('exclude_completed') == 'yes' || !$this->input->get('exclude_completed');

                $data['total_milestones'] = total_rows(db_prefix() . 'milestones', ['rel_sid' => $id, 'rel_stype' => $slug]);
                $data['milestones_found'] = $data['total_milestones'] > 0 || (!$data['total_milestones'] && total_rows(db_prefix() . 'tasks', ['rel_id' => $id, 'rel_type' => $slug, 'milestone' => 0]) > 0);
            } elseif ($group == 'project_files') {
                $data['files'] = $this->other->get_files($id);
            } elseif ($group == 'project_expenses') {
                $this->load->model('taxes_model');
                $this->load->model('expenses_model');
                $data['taxes'] = $this->taxes_model->get();
                $data['expense_categories'] = $this->expenses_model->get_category();
                $data['currencies'] = $this->currencies_model->get();
            } elseif ($group == 'project_activity') {
                $data['activity'] = $this->other->get_activity($id);
            } elseif ($group == 'project_notes') {
                $data['staff_notes'] = $this->other->get_staff_notes($id);
            } elseif ($group == 'project_estimates') {
                $this->load->model('estimates_model');
                $data['estimates_years'] = $this->estimates_model->get_estimates_years();
                $data['estimates_sale_agents'] = $this->estimates_model->get_sale_agents();
                $data['estimate_statuses'] = $this->estimates_model->get_statuses();
                $data['estimateid'] = '';
                $data['switch_pipeline'] = '';
            } elseif ($group == 'project_tickets') {
                $data['chosen_ticket_status'] = '';
                $this->load->model('tickets_model');
                $data['ticket_assignees'] = $this->tickets_model->get_tickets_assignes_disctinct();

                $this->load->model('departments_model');
                $data['staff_deparments_ids'] = $this->departments_model->get_staff_departments(get_staff_user_id(), true);
                $data['default_tickets_list_statuses'] = hooks()->apply_filters('default_tickets_list_statuses', [1, 2, 4]);
            } elseif ($group == 'project_timesheets') {
                // Tasks are used in the timesheet dropdown
                // Completed tasks are excluded from this list because you can't add timesheet on completed task.
                $data['tasks'] = $this->other->get_tasks($ServID, $id, 'status != ' . Tasks_model::STATUS_COMPLETE . ' AND billed=0');
                $data['timesheets_staff_ids'] = $this->other->get_distinct_tasks_timesheets_staff($id, $slug);
            } elseif ($group == 'OserviceSession') {
                $data['service_id'] = $ServID;
                $data['rel_id'] = $id;
                //$data['num_session'] = $this->service_sessions->count_sessions($ServID, $id);
                $data['judges'] = $this->service_sessions->get_judges();
                $data['courts'] = $this->service_sessions->get_court();
            } elseif ($group == 'Phase') {
                $data['phases'] = $this->phase->get_all(['service_id' => $ServID]);
            } elseif ($group == 'Procedures') {
                $data['category'] = $this->procedures->get('', ['type_id' => 2, 'parent_id' => 0]);
                $data['procedure_lists'] = $this->procedures->get_lists_procedure('', ['rel_id' => $id, 'rel_type' => $slug]);
            } elseif ($group == 'help_library') {
                $tags_array = get_service_tags($id, $slug);
                $tags = array();
                foreach ($tags_array as $tag) {
                    $tags[] = $tag['tag'];
                }
                $tags = implode(',', $tags);
                $data['books'] = json_decode(get_books_by_api($tags));
            }

            // Discussions
            if ($this->input->get('discussion_id')) {
                $data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
                $data['discussion'] = $this->other->get_discussion($this->input->get('discussion_id'), $id);
                $data['current_user_is_admin'] = is_admin();
            }

            $data['percent'] = $percent;

            $this->app_scripts->add('circle-progress-js', 'assets/plugins/jquery-circle-progress/circle-progress.min.js');

            $other_projects = [];
            $other_projects_where = 'id != ' . $id;

            $statuses = $this->other->get_project_statuses();

            $other_projects_where .= ' AND (';
            foreach ($statuses as $status) {
                if (isset($status['filter_default']) && $status['filter_default']) {
                    $other_projects_where .= 'status = ' . $status['id'] . ' OR ';
                }
            }

            $other_projects_where = rtrim($other_projects_where, ' OR ');

            $other_projects_where .= ')';

            if (!has_permission('projects', '', 'view')) {
                $other_projects_where .= ' AND ' . db_prefix() . 'my_other_services.id IN (SELECT oservice_id FROM ' . db_prefix() . 'my_members_services WHERE staff_id=' . get_staff_user_id() . ')';
            }


            $data['project_id'] = $id;
            $data['other_projects'] = $this->other->get($ServID, '', $other_projects_where);
            $data['title'] = $data['project']->name;
            $data['bodyclass'] .= 'project invoices-total-manual estimates-total-manual';
            $data['project_status'] = get_project_status_by_id($project->status);
            $data['service'] = $this->legal->get_service_by_id($ServID)->row();
            $data['ServID'] = $ServID;
            $data['oservice_model'] = $this->other;
            $this->load->view('admin/LegalServices/other_services/view', $data);
        } else {
            access_denied('Other services View');
        }
    }

    public function mark_as($slug) {
        $ServID = $this->legal->get_service_id_by_slug($slug);
        $success = false;
        $message = '';
        if ($this->input->is_ajax_request()) {
            if (has_permission('projects', '', 'create') || has_permission('projects', '', 'edit')) {
                $status = get_oservice_status_by_id($this->input->post('status_id'));

                $message = _l('project_marked_as_failed', $status['name']);
                $success = $this->other->mark_as($ServID, $this->input->post(), $slug);

                if ($success) {
                    $message = _l('project_marked_as_success', $status['name']);
                }
            }
        }
        echo json_encode([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function file($id, $project_id) {
        $data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id());
        $data['current_user_is_admin'] = is_admin();

        $data['file'] = $this->other->get_file($id, $project_id);
        if (!$data['file']) {
            header('HTTP/1.0 404 Not Found');
            die;
        }
        $this->load->view('admin/LegalServices/other_services/_file', $data);
    }

    public function update_file_data() {
        if ($this->input->post()) {
            $this->other->update_file_data($this->input->post());
        }
    }

    public function add_external_file() {
        if ($this->input->post()) {
            $data = [];
            $data['project_id'] = $this->input->post('project_id');
            $data['files'] = $this->input->post('files');
            $data['external'] = $this->input->post('external');
            $data['visible_to_customer'] = ($this->input->post('visible_to_customer') == 'true' ? 1 : 0);
            $data['staffid'] = get_staff_user_id();
            $this->other->add_external_file($data);
        }
    }

    public function download_all_files($ServID = '', $id) {
        if ($this->other->is_member($id) || has_permission('projects', '', 'view')) {
            $files = $this->other->get_files($id);
            if (count($files) == 0) {
                set_alert('warning', _l('no_files_found'));
                redirect(admin_url('SOther/view/' . $ServID . '/' . $id . '?group=project_files'));
            }
            $path = get_upload_path_by_type_oservice('oservice') . $id;
            $this->load->library('zip');
            foreach ($files as $file) {
                $this->zip->read_file($path . '/' . $file['file_name']);
            }
            $this->zip->download(slug_it(get_oservice_name_by_id($id)) . '-files.zip');
            $this->zip->clear_data();
        }
    }

    public function export_project_data($ServID, $id) {
        if (has_permission('projects', '', 'create')) {
            app_pdf('oservice-data', LIBSPATH . 'pdf/Oservice_data_pdf', $ServID, $id);
        }
    }

    public function update_task_milestone() {
        if ($this->input->post()) {
            $this->other->update_task_milestone($this->input->post());
        }
    }

    public function update_milestones_order() {
        if ($post_data = $this->input->post()) {
            $this->other->update_milestones_order($post_data);
        }
    }

    public function pin_action($project_id) {
        $this->other->pin_action($project_id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function add_edit_members($ServID = '', $project_id) {
        if (has_permission('projects', '', 'edit') || has_permission('projects', '', 'create')) {
            $this->other->add_edit_members($this->input->post(), $ServID, $project_id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function discussions($project_id, $slug) {
        $ServID = $this->legal->get_service_id_by_slug($slug);
        if ($this->other->is_member($project_id) || has_permission('projects', '', 'view')) {
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('oservice_discussions', [
                    'project_id' => $project_id,
                    'ServID' => $ServID
                ]);
            }
        }
    }

    public function discussion($ServID = '', $id = '') {
        if ($this->input->post()) {
            $message = '';
            $success = false;
            if (!$this->input->post('id')) {
                $id = $this->other->add_discussion($this->input->post(), $ServID);
                if ($id) {
                    $success = true;
                    $message = _l('added_successfully', _l('project_discussion'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                ]);
            } else {
                $data = $this->input->post();
                $id = $data['id'];
                unset($data['id']);
                $success = $this->other->edit_discussion($data, $id);
                if ($success) {
                    $message = _l('updated_successfully', _l('project_discussion'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
            die;
        }
    }

    public function get_discussion_comments($id, $type) {
        echo json_encode($this->other->get_discussion_comments($id, $type));
    }

    public function add_discussion_comment($ServID = '', $discussion_id, $type) {
        echo json_encode($this->other->add_discussion_comment($ServID, $this->input->post(null, false), $discussion_id, $type));
    }

    public function update_discussion_comment() {
        echo json_encode($this->other->update_discussion_comment($this->input->post(null, false)));
    }

    public function delete_discussion_comment($id) {
        echo json_encode($this->other->delete_discussion_comment($id));
    }

    public function delete_discussion($id) {
        $success = false;
        if (has_permission('projects', '', 'delete')) {
            $success = $this->other->delete_discussion($id);
        }
        $alert_type = 'warning';
        $message = _l('project_discussion_failed_to_delete');
        if ($success) {
            $alert_type = 'success';
            $message = _l('project_discussion_deleted');
        }
        echo json_encode([
            'alert_type' => $alert_type,
            'message' => $message,
        ]);
    }

    public function change_milestone_color() {
        if ($this->input->post()) {
            $this->other->update_milestone_color($this->input->post());
        }
    }

    public function upload_file($ServID = '', $project_id) {
        handle_oservice_file_uploads($ServID, $project_id);
    }

    public function change_file_visibility($id, $visible) {
        if ($this->input->is_ajax_request()) {
            $this->other->change_file_visibility($id, $visible);
        }
    }

    public function project_invoices($id, $visible) {
        if (has_permission('projects', '', 'create')) {
            if ($this->input->is_ajax_request()) {
                $this->other->change_activity_visibility($id, $visible);
            }
        }
    }

    public function remove_file($ServID = '', $project_id, $id) {
        $this->other->remove_file($id);
        redirect(admin_url('SOther/view/' . $ServID . '/' . $project_id . '?group=project_files'));
    }

    public function milestones_kanban($slug = '') {
        $ServID = $this->legal->get_service_id_by_slug($slug);
        $data['ServID'] = $ServID;
        $data['milestones_exclude_completed_tasks'] = $this->input->get('exclude_completed_tasks') && $this->input->get('exclude_completed_tasks') == 'yes';

        $data['project_id'] = $this->input->get('project_id');
        $data['milestones'] = [];

        $data['milestones'][] = [
            'name' => _l('milestones_uncategorized'),
            'id' => 0,
            'total_logged_time' => $this->other->calc_milestone_logged_time($slug, $data['project_id'], 0),
            'color' => null,
        ];

        $_milestones = $this->other->get_milestones($slug, $data['project_id']);

        foreach ($_milestones as $m) {
            $data['milestones'][] = $m;
        }

        echo $this->load->view('admin/LegalServices/other_services/milestones_kan_ban', $data, true);
    }

    public function milestones_kanban_load_more($ServID) {
        $milestones_exclude_completed_tasks = $this->input->get('exclude_completed_tasks') && $this->input->get('exclude_completed_tasks') == 'yes';

        $status = $this->input->get('status');
        $page = $this->input->get('page');
        $project_id = $this->input->get('project_id');
        $where = [];
        if ($milestones_exclude_completed_tasks) {
            $where['status !='] = Tasks_model::STATUS_COMPLETE;
        }
        $tasks = $this->other->do_milestones_kanban_query($ServID, $status, $project_id, $page, $where);
        foreach ($tasks as $task) {
            $this->load->view('admin/LegalServices/other_services/_milestone_kanban_card', ['task' => $task, 'milestone' => $status]);
        }
    }

    public function milestones($project_id, $ServID, $slug) {
        if ($this->other->is_member($project_id) || has_permission('projects', '', 'view')) {
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('milestones_oservice', [
                    'project_id' => $project_id,
                    'ServID' => $ServID,
                    'slug' => $slug
                ]);
            }
        }
    }

    public function milestone($ServID = '', $id = '') {
        if ($this->input->post()) {
            $message = '';
            $success = false;
            if (!$this->input->post('id')) {
                $id = $this->other->add_milestone($ServID, $this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('project_milestone')));
                }
            } else {
                $data = $this->input->post();
                $id = $data['id'];
                unset($data['id']);
                $success = $this->other->update_milestone($ServID, $data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('project_milestone')));
                }
            }
        }
        redirect(admin_url('SOther/view/' . $ServID . '/' . $this->input->post('rel_sid') . '?group=project_milestones'));
    }

    public function delete_milestone($ServID = '', $project_id, $id) {
        if (has_permission('projects', '', 'delete')) {
            if ($this->other->delete_milestone($ServID, $id)) {
                set_alert('deleted', 'project_milestone');
            }
        }
        redirect(admin_url('SOther/view/' . $ServID . '/' . $project_id . '?group=project_milestones'));
    }

    public function bulk_action_files() {
        hooks()->do_action('before_do_bulk_action_for_project_files');
        $total_deleted = 0;
        $hasPermissionDelete = has_permission('projects', '', 'delete');
        // bulk action for projects currently only have delete button
        if ($this->input->post()) {
            $fVisibility = $this->input->post('visible_to_customer') == 'true' ? 1 : 0;
            $ids = $this->input->post('ids');
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    if ($hasPermissionDelete && $this->input->post('mass_delete') && $this->other->remove_file($id)) {
                        $total_deleted++;
                    } else {
                        $this->other->change_file_visibility($id, $fVisibility);
                    }
                }
            }
        }
        if ($this->input->post('mass_delete')) {
            set_alert('success', _l('total_files_deleted', $total_deleted));
        }
    }

    public function timesheets($project_id, $slug) {
        if ($this->other->is_member($project_id) || has_permission('projects', '', 'view')) {
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data('timesheets_oservice', [
                    'project_id' => $project_id,
                    'slug' => $slug
                ]);
            }
        }
    }

    public function timesheet() {
        if ($this->input->post()) {
            $message = '';
            $success = false;
            $success = $this->tasks_model->timesheet($this->input->post());
            if ($success === true) {
                $message = _l('added_successfully', _l('project_timesheet'));
            } elseif (is_array($success) && isset($success['end_time_smaller'])) {
                $message = _l('failed_to_add_project_timesheet_end_time_smaller');
            } else {
                $message = _l('project_timesheet_not_updated');
            }
            echo json_encode([
                'success' => $success,
                'message' => $message,
            ]);
            die;
        }
    }

    public function timesheet_task_assignees($task_id, $project_id, $staff_id = 'undefined') {
        $assignees = $this->tasks_model->get_task_assignees($task_id);
        $data = '';
        $has_permission_edit = has_permission('projects', '', 'edit');
        $has_permission_create = has_permission('projects', '', 'edit');
        // The second condition if staff member edit their own timesheet
        if ($staff_id == 'undefined' || $staff_id != 'undefined' && (!$has_permission_edit || !$has_permission_create)) {
            $staff_id = get_staff_user_id();
            $current_user = true;
        }
        foreach ($assignees as $staff) {
            $selected = '';
            // maybe is admin and not project member
            if ($staff['assigneeid'] == $staff_id && $this->other->is_member($project_id, $staff_id)) {
                $selected = ' selected';
            }
            if ((!$has_permission_edit || !$has_permission_create) && isset($current_user)) {
                if ($staff['assigneeid'] != $staff_id) {
                    continue;
                }
            }
            $data .= '<option value="' . $staff['assigneeid'] . '"' . $selected . '>' . get_staff_full_name($staff['assigneeid']) . '</option>';
        }
        echo $data;
    }

    public function remove_team_member($ServID, $project_id, $staff_id) {
        if (has_permission('projects', '', 'edit') || has_permission('projects', '', 'create')) {
            if ($this->other->remove_team_member($ServID, $project_id, $staff_id)) {
                set_alert('success', _l('project_member_removed'));
            }
        }
        redirect(admin_url('SOther/view/' . $ServID . '/' . $project_id));
    }

    public function save_note($ServID = '', $project_id) {
        if ($this->input->post()) {
            $success = $this->other->save_note($this->input->post(null, false), $project_id);
            if ($success) {
                set_alert('success', _l('updated_successfully', _l('project_note')));
            }
            redirect(admin_url('SOther/view/' . $ServID . '/' . $project_id . '?group=project_notes'));
        }
    }

    public function copy($ServID, $project_id) {
        if (has_permission('projects', '', 'create')) {
            $id = $this->other->copy($ServID, $project_id, $this->input->post());
            if ($id) {
                set_alert('success', _l('project_copied_successfully'));
                redirect(admin_url('SOther/view/' . $ServID . '/' . $id));
            } else {
                set_alert('danger', _l('failed_to_copy_project'));
                redirect(admin_url('SOther/view/' . $ServID . '/' . $project_id));
            }
        }
    }

    public function mass_stop_timers($project_id, $billable = 'false', $ServID) {
        if (has_permission('invoices', '', 'create')) {
            $where = [
                'billed' => 0,
                'startdate <=' => date('Y-m-d'),
            ];
            if ($billable == 'true') {
                $where['billable'] = true;
            }
            $tasks = $this->other->get_tasks($ServID, $project_id, $where);
            $total_timers_stopped = 0;
            foreach ($tasks as $task) {
                $this->db->where('task_id', $task['id']);
                $this->db->where('end_time IS NULL');
                $this->db->update(db_prefix() . 'taskstimers', [
                    'end_time' => time(),
                ]);
                $total_timers_stopped += $this->db->affected_rows();
            }
            $message = _l('project_tasks_total_timers_stopped', $total_timers_stopped);
            $type = 'success';
            if ($total_timers_stopped == 0) {
                $type = 'warning';
            }
            echo json_encode([
                'type' => $type,
                'message' => $message,
            ]);
        }
    }

    public function get_pre_invoice_project_info($ServID, $project_id) {
        if (has_permission('invoices', '', 'create')) {
            $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
            $data['billable_tasks'] = $this->other->get_tasks($ServID, $project_id, [
                'billable' => 1,
                'billed' => 0,
                'startdate <=' => date('Y-m-d'),
            ]);
            $data['not_billable_tasks'] = $this->other->get_tasks($ServID, $project_id, [
                'billable' => 1,
                'billed' => 0,
                'startdate >' => date('Y-m-d'),
            ]);
            $data['project_id'] = $project_id;
            $data['ServID'] = $ServID;
            $data['billing_type'] = get_oservice_billing_type($project_id);
            $this->load->model('expenses_model');
            $this->db->where('invoiceid IS NULL');
            $data['expenses'] = $this->expenses_model->get('', [
                'rel_sid' => $project_id,
                'rel_stype' => $slug,
                'billable' => 1,
            ]);
            $this->load->view('admin/LegalServices/other_services/project_pre_invoice_settings', $data);
        }
    }

    public function get_invoice_project_data($ServID) {
        if (has_permission('invoices', '', 'create')) {
            $type = $this->input->post('type');
            $project_id = $this->input->post('project_id');
            // Check for all cases
            if ($type == '') {
                $type == 'single_line';
            }
            $this->load->model('payment_modes_model');
            $data['payment_modes'] = $this->payment_modes_model->get('', [
                'expenses_only !=' => 1,
            ]);
            $this->load->model('taxes_model');
            $data['taxes'] = $this->taxes_model->get();
            $data['currencies'] = $this->currencies_model->get();
            $data['base_currency'] = $this->currencies_model->get_base_currency();
            $this->load->model('invoice_items_model');

            $data['ajaxItems'] = false;
            if (total_rows(db_prefix() . 'items') <= ajax_on_total_items()) {
                $data['items'] = $this->invoice_items_model->get_grouped();
            } else {
                $data['items'] = [];
                $data['ajaxItems'] = true;
            }

            $data['items_groups'] = $this->invoice_items_model->get_groups();
            $data['staff'] = $this->staff_model->get('', ['active' => 1]);
            $project = $this->other->get($ServID, $project_id);
            $data['project'] = $project;

            $items = [];

            $project = $this->other->get($ServID, $project_id);
            $item['id'] = 0;

            $default_tax = unserialize(get_option('default_tax'));
            $item['taxname'] = $default_tax;

            $tasks = $this->input->post('tasks');
            if ($tasks) {
                $item['long_description'] = '';
                $item['qty'] = 0;
                $item['task_id'] = [];
                if ($type == 'single_line') {
                    $item['description'] = $project->name;
                    foreach ($tasks as $task_id) {
                        $task = $this->tasks_model->get($task_id);
                        $sec = $this->tasks_model->calc_task_total_time($task_id);
                        $item['long_description'] .= $task->name . ' - ' . seconds_to_time_format($sec) . ' ' . _l('hours') . "\r\n";
                        $item['task_id'][] = $task_id;
                        if ($project->billing_type == 2) {
                            if ($sec < 60) {
                                $sec = 0;
                            }
                            $item['qty'] += sec2qty($sec);
                        }
                    }
                    if ($project->billing_type == 1) {
                        $item['qty'] = 1;
                        $item['rate'] = $project->project_cost;
                    } elseif ($project->billing_type == 2) {
                        $item['rate'] = $project->project_rate_per_hour;
                    }
                    $item['unit'] = '';
                    $items[] = $item;
                } elseif ($type == 'task_per_item') {
                    foreach ($tasks as $task_id) {
                        $task = $this->tasks_model->get($task_id);
                        $sec = $this->tasks_model->calc_task_total_time($task_id);
                        $item['description'] = $project->name . ' - ' . $task->name;
                        $item['qty'] = floatVal(sec2qty($sec));
                        $item['long_description'] = seconds_to_time_format($sec) . ' ' . _l('hours');
                        if ($project->billing_type == 2) {
                            $item['rate'] = $project->project_rate_per_hour;
                        } elseif ($project->billing_type == 3) {
                            $item['rate'] = $task->hourly_rate;
                        }
                        $item['task_id'] = $task_id;
                        $item['unit'] = '';
                        $items[] = $item;
                    }
                } elseif ($type == 'timesheets_individualy') {
                    $timesheets = $this->other->get_timesheets($ServID, $project_id, $tasks);
                    $added_task_ids = [];
                    foreach ($timesheets as $timesheet) {
                        if ($timesheet['task_data']->billed == 0 && $timesheet['task_data']->billable == 1) {
                            $item['description'] = $project->name . ' - ' . $timesheet['task_data']->name;
                            if (!in_array($timesheet['task_id'], $added_task_ids)) {
                                $item['task_id'] = $timesheet['task_id'];
                            }

                            array_push($added_task_ids, $timesheet['task_id']);

                            $item['qty'] = floatVal(sec2qty($timesheet['total_spent']));
                            $item['long_description'] = _l('project_invoice_timesheet_start_time', _dt($timesheet['start_time'], true)) . "\r\n" . _l('project_invoice_timesheet_end_time', _dt($timesheet['end_time'], true)) . "\r\n" . _l('project_invoice_timesheet_total_logged_time', seconds_to_time_format($timesheet['total_spent'])) . ' ' . _l('hours');

                            if ($this->input->post('timesheets_include_notes') && $timesheet['note']) {
                                $item['long_description'] .= "\r\n\r\n" . _l('note') . ': ' . $timesheet['note'];
                            }

                            if ($project->billing_type == 2) {
                                $item['rate'] = $project->project_rate_per_hour;
                            } elseif ($project->billing_type == 3) {
                                $item['rate'] = $timesheet['task_data']->hourly_rate;
                            }
                            $item['unit'] = '';
                            $items[] = $item;
                        }
                    }
                }
            }
            if ($project->billing_type != 1) {
                $data['hours_quantity'] = true;
            }
            if ($this->input->post('expenses')) {
                if (isset($data['hours_quantity'])) {
                    unset($data['hours_quantity']);
                }
                if (count($tasks) > 0) {
                    $data['qty_hrs_quantity'] = true;
                }
                $expenses = $this->input->post('expenses');
                $addExpenseNote = $this->input->post('expenses_add_note');
                $addExpenseName = $this->input->post('expenses_add_name');

                if (!$addExpenseNote) {
                    $addExpenseNote = [];
                }

                if (!$addExpenseName) {
                    $addExpenseName = [];
                }

                $this->load->model('expenses_model');
                foreach ($expenses as $expense_id) {
                    // reset item array
                    $item = [];
                    $item['id'] = 0;
                    $expense = $this->expenses_model->get($expense_id);
                    $item['expense_id'] = $expense->expenseid;
                    $item['description'] = _l('item_as_expense') . ' ' . $expense->name;
                    $item['long_description'] = $expense->description;

                    if (in_array($expense_id, $addExpenseNote) && !empty($expense->note)) {
                        $item['long_description'] .= PHP_EOL . $expense->note;
                    }

                    if (in_array($expense_id, $addExpenseName) && !empty($expense->expense_name)) {
                        $item['long_description'] .= PHP_EOL . $expense->expense_name;
                    }

                    $item['qty'] = 1;

                    $item['taxname'] = [];
                    if ($expense->tax != 0) {
                        array_push($item['taxname'], $expense->tax_name . '|' . $expense->taxrate);
                    }
                    if ($expense->tax2 != 0) {
                        array_push($item['taxname'], $expense->tax_name2 . '|' . $expense->taxrate2);
                    }
                    $item['rate'] = $expense->amount;
                    $item['order'] = 1;
                    $item['unit'] = '';
                    $items[] = $item;
                }
            }
            $data['customer_id'] = $project->clientid;
            $data['invoice_from_project'] = true;
            $data['add_items'] = $items;
            $data['ServID'] = $ServID;
            $this->load->view('admin/LegalServices/other_services/invoice_project', $data);
        }
    }

    public function get_rel_project_data($id, $task_id = '') {
        if ($this->input->is_ajax_request()) {
            $selected_milestone = '';
            if ($task_id != '' && $task_id != 'undefined') {
                $task = $this->tasks_model->get($task_id);
                $selected_milestone = $task->milestone;
            }

            $allow_to_view_tasks = 0;
            $this->db->where('oservice_id', $id);
            $this->db->where('name', 'view_tasks');
            $project_settings = $this->db->get(db_prefix() . 'oservice_settings')->row();
            if ($project_settings) {
                $allow_to_view_tasks = $project_settings->value;
            }

            $deadline = get_oservice_deadline($id);

            echo json_encode([
                'deadline' => $deadline,
                'deadline_formatted' => $deadline ? _d($deadline) : null,
                'allow_to_view_tasks' => $allow_to_view_tasks,
                'billing_type' => get_oservice_billing_type($id),
                'milestones' => render_select('milestone', $this->other->get_milestones($id), [
                    'id',
                    'name',
                        ], 'task_milestone', $selected_milestone),
            ]);
        }
    }

    public function invoice_project($ServID, $project_id) {
        if (has_permission('invoices', '', 'create')) {
            $slug = $this->legal->get_service_by_id($ServID)->row()->slug;
            $this->load->model('invoices_model');
            $data = $this->input->post();
            $data['rel_stype'] = $slug;
            $data['rel_sid'] = $project_id;
            $data['project_id'] = null;
            $invoice_id = $this->invoices_model->add($data);
            if ($invoice_id) {
                $this->other->log_activity($project_id, 'LService_activity_invoiced_project', format_invoice_number($invoice_id));
                set_alert('success', _l('project_invoiced_successfully'));
            }
            redirect(admin_url('SOther/view/' . $ServID . '/' . $project_id . '?group=project_invoices'));
        }
    }

    public function view_project_as_client($id, $clientid, $ServID = '') {
        if (is_admin()) {
            login_as_client($clientid);
            redirect(site_url('clients/legal_services/' . $id . '/' . $ServID));
        }
    }

    function add_task_to_select_timesheet() {
        $data = $this->input->post();
        echo $this->tasks_model->new_task_to_select_timesheet($data);
    }

}
