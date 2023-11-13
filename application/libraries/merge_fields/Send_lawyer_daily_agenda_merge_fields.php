<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Send_lawyer_daily_agenda_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [

            [
                'name' => _l('staff_contact'),
                'key' => '{staff_contact}',
                'available' => [
                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],
            [
                'name' => _l('session_link'),
                'key' => '{session_url}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],
            [
                'name' => _l('session_due_date'),
                'key' => '{session_time}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('appoint_url'),
                'key' => '{appoint_url}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('appointment_date'),
                'key' => '{appointment_date}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('appointment_start_hour'),
                'key' => '{appointment_start_hour}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('appointlycallback_date'),
                'key' => '{appointlycallback_date}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('appointlycallback_date'),
                'key' => '{appointlycallback_phone_number}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('call_start_time'),
                'key' => '{call_start_time}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('call_user_phone'),
                'key' => '{call_user_phone}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('todo_date_added'),
                'key' => '{todo_date_added}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('todo_description'),
                'key' => '{todo_description}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],



            [
                'name' => _l('tick_start_date'),
                'key' => '{tick_start_date}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('tick_subject'),
                'key' => '{tick_subject}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],
            [
                'name' => _l('ticket_url'),
                'key' => '{ticket_url}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],



            [
                'name' => _l('case_comment_created'),
                'key' => '{case_comment_created}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('case_comment_content'),
                'key' => '{case_comment_content}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],
            [
                'name' => _l('discussion_link_cases'),
                'key' => '{discussion_link_cases}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('case_comment_created_file'),
                'key' => 'case_comment_created_file}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('نص التعليق'),
                'key' => '{case_comment_content_file}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('رابط التعليق'),
                'key' => '{discussion_link_cases_disputes}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('تاريخ الاضافة'),
                'key' => 'case_disputes_comment_created}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('نص التعليق'),
                'key' => '{case_disputes_comment_content}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('رابط التعليق'),
                'key' => '{discussion_link_cases_disputes_file}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('تاريخ الاضافة'),
                'key' => 'case_disputes_comment_created_file}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('نص التعليق'),
                'key' => '{case_disputes_comment_content_file}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],



            [
                'name' => _l('تاريخ اضافة الاعلان'),
                'key' => 'announcement_date}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('موضوع الاعلان'),
                'key' => '{announcement_name}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('محتوى الاعلان'),
                'key' => '{announcement_message}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('عنوان المهام التي تاريخ استحقاقها اليوم'),
                'key' => '{task_duedate_today_name}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('تاريخ المهمة التي استحقاقها اليوم'),
                'key' => '{task_duedate_today_date_added}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('رابط المهمة'),
                'key' => '{task_link_today}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('عنوان المهمة التي انتهى تاريخ استحقاقها'),
                'key' => '{task_duedate_today_name_duedate_ended}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('تاريخ المهمة التي انتهى تاريخ استحقاقها'),
                'key' => '{task_duedate_today_date_added_duedate_ended}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],
            [
                'name' => _l('رابط المهمة'),
                'key' => '{task_link_duedate_ended}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],
   

            [
                'name' => _l('رابط القضية'),
                'key' => '{{case_url_open}}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('حالة القضية'),
                'key' => '{case_status_open}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('عنوان القضية'),
                'key' => '{case_name_open}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l(' رابط قضية التنفيذ والتحصيل'),
                'key' => '{case_disputes_url_open}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('حالة قضية التنفيذ والتحصيل'),
                'key' => '{case_disputes_status_open}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('عنوان قضية التنفيذ والتحصيل'),
                'key' => '{case_disputes_name_open}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('رابط الخدمة القانونية'),
                'key' => '{other_services_link_open}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('حالة الخدمة القنونية'),
                'key' => '{other_services_status_open}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('عنوان الخدمة القانونية'),
                'key' => '{other_services_name_open}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],



            [
                'name' => _l('تاريخ اضافة التعليق  '),
                'key' => '{task_comment_dateadded}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('نص التعليق'),
                'key' => '{task_comment_content}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('رابط التعليق'),
                'key' => '{task_comment_link}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],



            [
                'name' => _l('تاريخ اضافة التعليق  على ملف الخدمات القنونية'),
                'key' => '{other_services_comment_created_file}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('نص التعليق'),
                'key' => '{other_services_comment_content_file}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('رابط'),
                'key' => '{discussion_link_other_file}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('تاريخ اضافة التعليق  على  الخدمات القانونية'),
                'key' => '{other_services_comment_created}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('نص التعليق'),
                'key' => '{other_services_comment_content}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

            [
                'name' => _l('نص التعليق'),
                'key' => '{discussion_link_otherservices}',
                'available' => [

                ],
                'templates' => [
                    'send_lawyer_daily_agenda_to_staff',

                ],
            ],

        ];
    }

    /**
     * Merge fields for lawyer daily agenda
     * @param  mixed  $case_id         case_id
     * @return array
     */
    public function format($staffid)
    {

        $fields = [];
        $fields['{session_url}'] = '';
        $fields['{session_time}'] = '';

        $fields['{appoint_url}'] = '';
        $fields['{appointment_date}'] = '';

        $fields['{appointment_start_hour}'] = '';

        $fields['{appointlycallback_date}'] = '';
        $fields['{appointlycallback_phone_number}'] = '';

        $fields['{call_start_time}'] = '';
        $fields['{call_user_phone}'] = '';

        $fields['{todo_date_added}'] = '';
        $fields['{todo_description}'] = '';

        $fields['{case_start_date}'] = '';
        $fields['{case_name}'] = '';

        $fields['{case_start_date_not_changed}'] = '';
        $fields['{case_name_not_cahnged}'] = '';

        $fields['{case_start_date_dispute}'] = '';
        $fields['{case_name_dispute}'] = '';



        $fields['{tick_start_date}'] = '';
        $fields['{tick_subject}'] = '';

        $fields['{tick_comment_dateadded}'] = '';
        $fields['{tick_comment_content}'] = '';

        $fields['{case_comment_created}'] = '';
        $fields['{case_comment_content}'] = '';

        $fields['{oservice_comment_created}'] = '';
        $fields['{oservice_comment_content}'] = '';

        $fields['{oservice_comment_created_file}'] = '';
        $fields['{oservice_comment_content_file}'] = '';

        $fields['{announcement_date}'] = '';
        $fields['{announcement_name}'] = '';
        $fields['{announcement_message}'] = '';
        $fields['{case_comment_created_file}'] = '';

        $fields['{case_comment_content_file}'] = '';
        $fields['{ticket_url}'] = '';
        $fields['{task_duedate_today_name}'] = '';
        $fields['{task_duedate_today_date_added}'] = '';

        $fields['{task_duedate_today_name_duedate_ended}'] = '';
        $fields['{task_duedate_today_date_added_duedate_ended}'] = '';
        $fields['{case_url_open}'] = '';
        $fields['{case_status_open}'] = '';

        $fields['{case_name_open}'] = '';

        $fields['{case_disputes_url_open}'] = '';
        $fields['{discussion_link_cases}'] = '';
        $fields['{discussion_link_cases_file}'] = '';

        $fields['{discussion_link_cases_disputes}'] = '';
        $fields['{case_disputes_comment_created}'] = '';
        $fields['{case_disputes_comment_content}'] = '';

        $fields['{case_disputes_comment_created_file}'] = '';
        $fields['{case_disputes_comment_content_file}'] = '';
        $fields['{discussion_link_cases_disputes_file}'] = '';

        $fields['{case_disputes_status_open}'] = '';
        $fields['{case_disputes_name_open}'] = '';
        $fields['{task_comment_dateadded}'] = '';
        $fields['{task_comment_content}'] = '';

        $fields['{other_services_comment_created}'] = '';
        $fields['{other_services_comment_content}'] = '';

        $fields['{other_services_comment_created_file}'] = '';
        $fields['{other_services_comment_content_file}'] = '';
        $fields['{discussion_link_other_file}'] = '';

        $fields['{discussion_link_otherservices}'] = '';

        $fields['{other_services_status_open}'] = '';
        $fields['{other_services_link_open}'] = '';

        $fields['{other_services_name_open}'] = '';
        $fields['{task_link_today}'] = '';
        $fields['{task_link_duedate_ended}'] = '';
  
    
        $fields['{task_comment_link}'] = '';

        //----------------------------------------------------------- SESSION-------------------------------------------------------------
        $date = new DateTime();
        $today = $date->format('Y-m-d');
        $this->ci->db->where('startdate = "' . $today . '"');
        $this->ci->db->where('addedfrom', $staffid);
        $this->ci->db->where('is_session', 1);
        $this->ci->db->where('status !=', 5);
        $this->ci->db->where('deleted', 0);
     
        $session_infomation = $this->ci->db->get(db_prefix() . 'tasks')->result_array();

        if (is_array($session_infomation)) {
            $sn = 1;
            foreach ($session_infomation as $data) {

                $session_info = $this->ci->sessions_model->get($data['id']);
                 if (!$session_info) {
                    return $fields;
                }



                if (isset($data['rel_type']) && ($data['rel_type'] != null) && ($data['rel_type'] !== 'customer')) {
                    $service_id = $this->ci->legal->get_service_id_by_slug($data['rel_type']);

                    if ($service_id == 1) {

                        $fields['{session_url}'] .= '<br/><a href="' . admin_url('Case/view/' . $service_id . '/' . $data['rel_id'] . '?group=CaseSession&sessionid=' . $data['id']) . '">رابط الجلسة</a><br/> ';

                    } elseif ($service_id == 22) {
                        $fields['{session_url}'] .= '<br/><a href="' . admin_url('Disputes_cases/view/' . $service_id . '/' . $data['rel_id'] . '?group=CaseSession&sessionid=' . $data['id']) . '">رابط الجلسة</a><br/> ';

                    } else {
                        $fields['{session_url}'] .= '<br/><a href="' . admin_url('SOther/view/' . $service_id . '/' . $data['rel_id'] . '?group=OserviceSession&sessionid=' . $data['id']) . '">رابط الجلسة</a><br/> ';

                    }

                } elseif (isset($data['rel_type']) && ($data['rel_type'] != null) && ($data['rel_type'] == 'customer')) {

                    $fields['{session_url}'] .= '<br/><a href="' . site_url('clients/project/' . $data['rel_id'] . '?group=project_tasks&taskid=' . $data['id']) . '">رابط الجلسة</a><br/> ';

                }
                $this->ci->db->where('task_id', $data['id']);
             
             
                 $this->ci->db->order_by("time", "ASC");
                $session_link = $this->ci->db->get(db_prefix() . 'my_session_info')->row();

                $session_link->time =  date('h:i A', strtotime($session_link->time));
                $fields['{session_time}'] .= '<br/>' . $session_link->time . '<br/> ';

                $sn++;

            }
        
        }

        //---------------------------------------------------------------------------------------- TODY TASK-------------------------------------------------------------------
        $date = new DateTime();
        $today = $date->format('Y-m-d');

        $this->ci->db->where('duedate IS NOT NULL');
        $this->ci->db->where('DATE(duedate)= "' . $today . '"');
        $this->ci->db->where('addedfrom', $staffid);
        $this->ci->db->where('is_session', 0);
        $this->ci->db->where('status !=', 5);
        $this->ci->db->where('deleted', 0);
        $this->ci->db->order_by("dateadded", "asc");
       
        $task_info = $this->ci->db->get(db_prefix() . 'tasks')->result_array();

        if (is_array($task_info)) {
            $sn = 1;
            foreach ($task_info as $data) {

                $fields['{task_link_today}'] .= '<br/><a href="' . admin_url('tasks/view/' . $data['id']) . '">رابط المهمة</a><br/>';

                $fields['{task_duedate_today_name}'] .= '<br/>' . $data['name'] . '<br/> ';

                $fields['{task_duedate_today_date_added}'] .= '<br/>' . $data['dateadded'] . '<br/> ';

                $sn++;

            }

        }

        //-----------------------------------------------------------------------------------------TASKS DUEDATE ENDED-----------------------------------------------------------
        $date = new DateTime();
        $today = $date->format('Y-m-d');

        $this->ci->db->select('*');
        $this->ci->db->where('duedate IS NOT NULL');
        $this->ci->db->where('duedate < "' . $today . '"');
        $this->ci->db->where('addedfrom', $staffid);
        $this->ci->db->where('is_session', 0);
        $this->ci->db->where('status !=', 5);
        $this->ci->db->where('deleted', 0);
        $this->ci->db->order_by("dateadded", "asc");
        
        $task_info_duedate_ended = $this->ci->db->get(db_prefix() . 'tasks')->result_array();

        if (is_array($task_info_duedate_ended)) {
            $sn = 1;
            foreach ($task_info_duedate_ended as $data) {

                $fields['{task_link_duedate_ended}'] .= '<br/><a href="' . admin_url('tasks/view/' . $data['id']) . '">رابط المهمة</a><br/>';
                $fields['{task_duedate_today_name_duedate_ended}'] .= '<br/>' . $data['name'] . '<br/> ';

                $fields['{task_duedate_today_date_added_duedate_ended}'] .= '<br/>' . $data['duedate'] . '<br/> ';

                $sn++;

            }

        }

//-----------------------------------------------------------------------------------------APPOINTMENT-----------------------------------------------------------

        $CI = &get_instance();
        $CI->load->library('app_modules');
        $date = new DateTime();
        $today = $date->format('Y-m-d');
        if ($CI->app_modules->is_active('appointly')) {

            // $this->ci->db->where('id IN (SELECT appointment_id FROM ' . db_prefix() . 'appointly_attendees WHERE staff_id=' . $staffid . ')');
            $this->ci->db->where('created_by', $staffid);
            $this->ci->db->where('date = "' . $today . '"');
            $this->ci->db->where('approved', 1);
              $this->ci->db->order_by('start_hour','asc');
            $appointmentss = $this->ci->db->get(db_prefix() . 'appointly_appointments')->result_array();
            if ($appointmentss) {

                if (is_array($appointmentss)) {

                    $sn = 1;
                    foreach ($appointmentss as $data) {

                        $fields['{appoint_url}'] .= '<br/><a href="' . admin_url('appointly/appointments/view?appointment_id=' . $data['id']) . '">' . $data['subject'] . '</a><br/>';
                        $fields['{appointment_date}'] .= '<br/>' . $data['date'] . '<br/> ';
                        
                        $data['start_hour'] =  date('h:i A', strtotime($data['start_hour']));
                           
                        $fields['{appointment_start_hour}'] .= '<br/>' . $data['start_hour'] . '<br/> ';

                        $sn++;

                    }

                }

            }
        }

//-----------------------------------------------------------------------------callback-----------------------------------------------------------

        $responsiblePerson = get_option('callbacks_responsible_person');

        if ($responsiblePerson != '') {

            $staff = appointly_get_staff($responsiblePerson);

            if ($staff['staffid'] == $staffid) {

                $date = new DateTime();
                $today = $date->format('Y-m-d');
                $this->ci->db->where('DATE(date_added) = "' . $today . '"');

                $this->ci->db->order_by("date_start", "asc");
                $appointlycallbacks = $this->ci->db->get(db_prefix() . 'appointly_callbacks');
                $appointlycallback = $appointlycallbacks->result_array();

                if (is_array($appointlycallback)) {

                    $sn = 1;
                    foreach ($appointlycallback as $data) {

                        $fields['{appointlycallback_date}'] .= '<br/>' . $data['date_start'] . '<br/> ';
                        $fields['{appointlycallback_phone_number}'] .= '<br/>' . $data['phone_number'] . '<br/> ';

                        $sn++;

                    }

                }
            }

        }

        //---------------------------------------------------------------------TODOS------------------------------------------------------------
        $this->ci->db->where('staffid', $staffid);
        $this->ci->db->where('finished', 0);
        $today = $date->format('Y-m-d');
        $this->ci->db->where('DATE(dateadded) = "' . $today . '"');
        $this->ci->db->order_by("dateadded", "asc");

        $todos = $this->ci->db->get(db_prefix() . 'todos');
        $todo = $todos->result_array();

        if (is_array($todo)) {

            $sn = 1;
            foreach ($todo as $data) {

                $fields['{todo_date_added}'] .= '<br/>' . $data['dateadded'] . '<br/> ';
                $fields['{todo_description}'] .= '<br/>' . $data['description'] . '<br/> ';

                $sn++;

            }

        }

        //------------------------------------------------------------------------------OPEN CASES---------------------------------------------------

        $date = new DateTime();

        $today = $date->format('Y-m-d');

        $cases = $this->ci->db->query('select * from tblmy_cases
         where tblmy_cases.id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . $staffid . ')
         and status in(2,3) and start_date ="' . $today . '" ');

        $case = $cases->result_array();

        if (is_array($case)) {

            $sn = 1;
            $status = '';
            foreach ($case as $data) {
                $status = '';
                $fields['{case_url_open}'] .= '<br/><a href="' . admin_url('Case/view/1/' . $data['id']) . '">رابط القضية</a><br/> ';
                if ($data['status'] == 2) {
                    $status = 'متداولة';
                } elseif (($data['status'] == 3)) {
                    $status = 'في الانتظار';
                }

                $fields['{case_status_open}'] .= '<br/>' . $status . '<br/> ';

                $fields['{case_name_open}'] .= '<br/>' . $data['name'] . '<br/> ';

                $sn++;

            }

        }

        //----------------------------------------------------------------------OPEN DISPUTES CASES------------------------------------------------
        $fields['{case_disputes_url_open}'] = '';
        $fields['{case_disputes_status_open}'] = '';
        $fields['{case_disputes_name_open}'] = '';
        $date = new DateTime();

        $today = $date->format('Y-m-d');

        $cases = $this->ci->db->query('select * from tblmy_disputes_cases
         where tblmy_disputes_cases.id IN (SELECT project_id FROM ' . db_prefix() . 'my_disputes_cases_members WHERE staff_id=' . $staffid . ')
         and start_date ="' . $today . '"
         and status in(2,3) ');

        $case = $cases->result_array();

        if (is_array($case)) {

            $sn = 1;
            $status = '';
            foreach ($case as $data) {
                $status = '';

                $fields['{case_disputes_url_open}'] .= '<br/><a href="' . admin_url('Disputes_cases/view/22/' . $data['id']) . '">رابط القضية</a><br/> ';
                if ($data['status'] == 2) {
                    $status = 'متداولة';
                } elseif (($data['status'] == 3)) {
                    $status = 'في الانتظار';
                }

                $fields['{case_disputes_status_open}'] .= '<br/>' . $status . '<br/> ';

                $fields['{case_disputes_name_open}'] .= '<br/>' . $data['name'] . '<br/> ';

                $sn++;

            }

        }

        //------------------------------------------------------------------------OPEN OTHERSERVICES---------------------------------------------------
        $fields['{other_services_status_open}'] = '';
        $fields['{other_services_link_open}'] = '';
        $fields['{other_services_name_open}'] = '';
        $today = $date->format('Y-m-d');
        $akds = $this->ci->db->query('select * from tblmy_other_services
          where    tblmy_other_services.id IN (SELECT oservice_id FROM ' . db_prefix() . 'my_members_services WHERE staff_id=' . $staffid . ')
        and start_date ="' . $today . '"
         and status in(2,3)  ');

        $akd = $akds->result_array();

        if (is_array($akd)) {

            $sn = 1;
            $status = '';
            foreach ($akd as $data) {

                $status = '';

                $fields['{other_services_link_open}'] .= '<br/><a href="' . admin_url('SOther/view/' . $data['service_id'] . '/' . $data['id']) . '"> الرابط</a><br/> ';
                if ($data['status'] == 2) {
                    $status = 'متداولة';
                } elseif (($data['status'] == 3)) {
                    $status = 'في الانتظار';
                }

                $fields['{other_services_status_open}'] .= '<br/>' . $status . '<br/> ';

                $fields['{other_services_name_open}'] .= '<br/>' . $data['name'] . '<br/> ';

                $sn++;

            }

        }

        //---------------------------------------------------------------------------------------------------TICKETS---------------------------------------------
        $date = new DateTime();
        $today = $date->format('Y-m-d');
        $this->ci->db->where('admin', $staffid);
        $this->ci->db->where('status != 5');
       // $this->ci->db->where('DATE(date) = "' . $today . '"');
        $this->ci->db->order_by("date", "asc");
        $ticks = $this->ci->db->get(db_prefix() . 'tickets');
        $tick = $ticks->result_array();

        if (is_array($tick)) {

            $sn = 1;

            foreach ($tick as $data) {

                $fields['{ticket_url}'] .= '<br/><a href="' . admin_url('tickets/ticket/' . $data['ticketid']) . '">رابط التذكرة</a><br/> ';
                $fields['{tick_start_date}'] .= '<br/>' . $data['date'] . '<br/> ';
                $fields['{tick_subject}'] .= '<br/>' . $data['subject'] . '<br/> ';

                $sn++;

            }

        }

        //----------------------------------------------------------------------------------TASK COMMENT-----------------------------------------
        $this->ci->db->where('duedate IS NOT NULL');
        $this->ci->db->where('addedfrom', $staffid);
        $this->ci->db->where('is_session', 0);
        $this->ci->db->where('status !=', 5);
        $date = new DateTime();
        $today = $date->format('Y-m-d');
        $this->ci->db->where('DATE(dateadded) = "' . $today . '"');
        $this->ci->db->order_by("dateadded", "asc");
        $tasks = $this->ci->db->get(db_prefix() . 'tasks');
        $task = $tasks->result_array();

        if (is_array($task)) {

            $sn = 1;

            foreach ($task as $data) {

                $this->ci->db->where('taskid', $data['id']);
                $this->ci->db->where('DATE(dateadded) = "' . $today . '"');
                $this->ci->db->order_by("dateadded", "asc");
                $task_comment = $this->ci->db->get(db_prefix() . 'task_comments')->result_array();

                if ($task_comment !== null) {
                    foreach ($task_comment as $task_comment_info) {

                        $fields['{task_comment_dateadded}'] .= '<br/>' . $task_comment_info['dateadded'] . '<br/> ';
                        $fields['{task_comment_content}'] .= '<br/>' . $task_comment_info['content'] . '<br/> ';

                        $fields['{task_comment_link}'] .= '<br/><a href="' . admin_url('tasks/view/' . $data['id']) . '#comment_' . $task_comment_info['id'] . '">الرابط </a><br/> ';
                        $sn++;
                    }

                }

            }

        }

        //-------------------------------------------------------------------------------------------------CASE COMMENT---------------------------------
        $fields['{discussion_link_cases}'] = '';
        $fields['{case_comment_content_file}'] = '';
        $fields['{discussion_link_cases_file}'] = '';

        $cases = $this->ci->db->query('select * from tblmy_cases
         where tblmy_cases.id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . $staffid . ')

         and status in(2,3) ');

        $case = $cases->result_array();
        if (is_array($case)) {

            foreach ($case as $dataa) {
                $this->ci->db->where('project_id', $dataa['id']);
                $casediscussions = $this->ci->db->get(db_prefix() . 'casediscussions');
                $casediscussion = $casediscussions->result_array();

                if (is_array($casediscussion)) {

                    $sn = 1;

                    foreach ($casediscussion as $data) {

                        $this->ci->db->where('discussion_id', $data['id']);
                        $this->ci->db->where('discussion_type', 'regular');
                        $today = $date->format('Y-m-d');
                        $this->ci->db->where('DATE(created) = "' . $today . '"');
                        $this->ci->db->order_by("created", "asc");
                        $casediscussioncomments = $this->ci->db->get(db_prefix() . 'casediscussioncomments')->result_array();

                        foreach ($casediscussioncomments as $casediscussioncomment) {

                            if ($casediscussioncomment !== null) {
                                $fields['{case_comment_created}'] .= '<br/>' . $casediscussioncomment['created'] . '<br/> ';

                                $fields['{case_comment_content}'] .= '<br/>' . $casediscussioncomment['content'] . '<br/> ';

                                $fields['{discussion_link_cases}'] .= '<br/><a href="' . admin_url('Case/view/1/' . $dataa['id'] . '?group=project_discussions&discussion_id=' . $data['id']) . '">الرابط </a><br/> ';
                                $sn++;
                            }
                        }
                    }

                }

            }

        }

        //-----------------------------------------------------------------------------CASE COMMENT FILES-----------------------------------------------------------------
        $cases_file = $this->ci->db->query('select * from tblmy_cases
        where tblmy_cases.id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . $staffid . ')

        and status in(2,3) ');

        $case_file = $cases_file->result_array();
        if (is_array($case_file)) {

            foreach ($case_file as $dataa_file) {
                $this->ci->db->where('project_id', $dataa_file['id']);
                $casediscussions_file = $this->ci->db->get(db_prefix() . 'case_files');
                $casediscussion_file = $casediscussions_file->result_array();

                if (is_array($casediscussion_file)) {

                    $sn = 1;

                    foreach ($casediscussion_file as $data) {

                        $this->ci->db->where('discussion_id', $data['id']);
                        $this->ci->db->where('discussion_type', 'file');
                        $today = $date->format('Y-m-d');
                        $this->ci->db->where('DATE(created) = "' . $today . '"');
                        $this->ci->db->order_by("created", "asc");

                        $casediscussioncomments_file = $this->ci->db->get(db_prefix() . 'casediscussioncomments')->result_array();

                        foreach ($casediscussioncomments_file as $casediscussioncomment) {

                            if ($casediscussioncomment !== null) {
                                $fields['{case_comment_created_file}'] .= '<br/>' . $casediscussioncomment['created'] . '<br/> ';

                                $fields['{case_comment_content_file}'] .= '<br/>' . $casediscussioncomment['content'] . '<br/> ';

                                $fields['{discussion_link_cases_file}'] .= '<br/><a href="' . admin_url('Case/view/1/' . $dataa_file['id'] . '?group=project_files&file_id=' . $data['id']) . '">الرابط </a><br/> ';

                                $sn++;
                            }
                        }

                    }

                }

            }

        }

//------------------------------------------------------------------------------CASE DISPUTES COMMENTS----------------------------------------------------------------------------
        $cases = $this->ci->db->query('select * from tblmy_disputes_cases
        where tblmy_disputes_cases.id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . $staffid . ')

        and status in(2,3) ');

        $case = $cases->result_array();

        if (is_array($case)) {

            foreach ($case as $dataa) {
                $this->ci->db->where('project_id', $dataa['id']);
                $casediscussions = $this->ci->db->get(db_prefix() . 'my_disputes_casediscussions');
                $casediscussion = $casediscussions->result_array();

                if (is_array($casediscussion)) {

                    $sn = 1;

                    foreach ($casediscussion as $data) {

                        $this->ci->db->where('discussion_id', $data['id']);
                        $this->ci->db->where('discussion_type', 'regular');
                        $today = $date->format('Y-m-d');
                        $this->ci->db->where('DATE(created) = "' . $today . '"');
                        $this->ci->db->order_by("created", "asc");
                        $casediscussioncomments = $this->ci->db->get(db_prefix() . 'my_disputes_casediscussioncomments')->result_array();
                        foreach ($casediscussioncomments as $casediscussioncomment) {

                            if ($casediscussioncomment !== null) {
                                $fields['{case_disputes_comment_created}'] .= '<br/>' . $casediscussioncomment['created'] . '<br/> ';

                                $fields['{case_disputes_comment_content}'] .= '<br/>' . $casediscussioncomment['content'] . '<br/> ';

                                $fields['{discussion_link_cases_disputes}'] .= '<br/><a href="' . admin_url('Case/view/22/' . $dataa['id'] . '?group=project_discussions&discussion_id=' . $data['id']) . '">الرابط </a><br/> ';

                                $sn++;
                            }
                        }
                    }

                }

            }

        }
//--------------------------------------------------------------------------------------CASE DISPUTES COMMENTS FILES-------------------------------------------------------------
        $cases = $this->ci->db->query('select * from tblmy_disputes_cases
       where tblmy_disputes_cases.id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . $staffid . ') and status in(2,3) ');

        $case = $cases->result_array();
        if (is_array($case)) {

            foreach ($case as $dataa) {
                $this->ci->db->where('project_id', $dataa['id']);
                $casediscussions = $this->ci->db->get(db_prefix() . 'my_disputes_case_files');
                $casediscussion = $casediscussions->result_array();

                if (is_array($casediscussion)) {

                    $sn = 1;

                    foreach ($casediscussion as $data) {

                        $this->ci->db->where('discussion_id', $data['id']);
                        $this->ci->db->where('discussion_type', 'file');
                        $this->ci->db->order_by("created", "asc");
                        $today = $date->format('Y-m-d');
                        $this->ci->db->where('DATE(created) = "' . $today . '"');
                        $casediscussioncomments = $this->ci->db->get(db_prefix() . 'my_disputes_casediscussioncomments')->result_array();

                        foreach ($casediscussioncomments as $casediscussioncomment) {

                            if ($casediscussioncomment !== null) {
                                $fields['{case_disputes_comment_created_file}'] .= '<br/>' . $casediscussioncomment['created'] . '<br/> ';

                                $fields['{case_disputes_comment_content_file}'] .= '<br/>' . $casediscussioncomment['content'] . '<br/> ';

                                $fields['{discussion_link_cases_disputes_file}'] .= '<br/><a href="' . admin_url('Case/view/22/' . $dataa['id'] . '?group=project_files&file_id=' . $data['id']) . '">الرابط </a><br/> ';

                                $sn++;
                            }
                        }
                    }

                }

            }

        }
//----------------------------------------------------------------------------------OTHERSERVICES COMMENTS---------------------------------------------------------------------
        $tans = $this->ci->db->query('select * from tblmy_other_services
        where tblmy_other_services.id IN (SELECT oservice_id FROM ' . db_prefix() . 'my_members_services WHERE staff_id=' . $staffid . ') and status in(2,3)  ');

        $case_otherservices = $tans->result_array();

        if (is_array($case_otherservices)) {

            foreach ($case_otherservices as $dataa) {

                $this->ci->db->where('oservice_id', $dataa['id']);
                $casediscussions_otherservices = $this->ci->db->get(db_prefix() . 'oservicediscussions');

                $otherservices_discussion = $casediscussions_otherservices->result_array();

                $sn = 1;

                foreach ($otherservices_discussion as $data) {

                    $this->ci->db->where('discussion_id', $data['id']);
                    $this->ci->db->where('discussion_type', 'regular');
                    $this->ci->db->order_by("created", "asc");
                    $today = $date->format('Y-m-d');
                    $this->ci->db->where('DATE(created) = "' . $today . '"');
                    $casediscussioncomments = $this->ci->db->get(db_prefix() . 'oservicediscussioncomments')->result_array();

                    foreach ($casediscussioncomments as $casediscussioncomment) {

                        if ($casediscussioncomment !== null) {
                            $fields['{other_services_comment_created}'] .= '<br/>' . $casediscussioncomment['created'] . '<br/> ';

                            $fields['{other_services_comment_content}'] .= '<br/>' . $casediscussioncomment['content'] . '<br/> ';

                            $fields['{discussion_link_otherservices}'] .= '<br/><a href="' . admin_url('SOther/view/' . $dataa['service_id'] . '/' . $dataa['id'] . '?group=project_discussions&discussion_id=' . $data['id']) . '">الرابط </a><br/> ';

                            $sn++;
                        }

                    }
                }

            }

        }
//---------------------------------------------------------------------OTHERSERVICES COMMENTS FILES----------------------------------------------------------------------------
        $akds = $this->ci->db->query('select * from tblmy_other_services
        where tblmy_other_services.id IN (SELECT oservice_id FROM ' . db_prefix() . 'my_members_services WHERE staff_id=' . $staffid . ') and status in(2,3)  ');

        $case = $akds->result_array();

        if (is_array($case)) {

            foreach ($case as $dataa) {
                $this->ci->db->where('oservice_id', $dataa['id']);
                $casediscussions = $this->ci->db->get(db_prefix() . 'oservice_files');
                $casediscussion = $casediscussions->result_array();

                if (is_array($casediscussion)) {

                    $sn = 1;

                    foreach ($casediscussion as $data) {

                        $this->ci->db->where('discussion_id', $data['id']);
                        $this->ci->db->where('discussion_type', 'file');
                        $this->ci->db->order_by("created", "asc");
                        $today = $date->format('Y-m-d');
                        $this->ci->db->where('DATE(created) = "' . $today . '"');
                        $casediscussioncomments = $this->ci->db->get(db_prefix() . 'oservicediscussioncomments')->result_array();

                        foreach ($casediscussioncomments as $casediscussioncomment) {

                            if ($casediscussioncomment !== null) {
                                $fields['{other_services_comment_created_file}'] .= '<br/>' . $casediscussioncomment['created'] . '<br/> ';

                                $fields['{other_services_comment_content_file}'] .= '<br/>' . $casediscussioncomment['content'] . '<br/> ';

                                $fields['{discussion_link_other_file}'] .= '<br/><a href="' . admin_url('SOther/view/' . $dataa['service_id'] . '/' . $dataa['id'] . '?group=project_files&file_id=' . $data['id']) . '">الرابط </a><br/> ';

                                $sn++;
                            }
                        }

                    }

                }

            }

        }

        $date = new DateTime();
        $today = $date->format('Y-m-d');
        $this->ci->db->where('DATE(dateadded) = "' . $today . '"');
        $this->ci->db->order_by("dateadded", "asc");
        $announcements = $this->ci->db->get(db_prefix() . 'announcements');
        $announcement = $announcements->result_array();

        if (is_array($announcement)) {

            $sn = 1;
            foreach ($announcement as $data) {

                $fields['{announcement_date}'] .= '<br/>' . $data['dateadded'] . '<br/> ';
                $fields['{announcement_name}'] .= '<br/>' . $data['name'] . '<br/> ';
                $fields['{announcement_message}'] .= '<br/>' . $data['message'] . '<br/> ';

                $sn++;

            }

        }

        return hooks()->apply_filters('send_lawyer_daily_agenda_merge_fields', $fields);

    }
}
