<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__.'/REST_Controller.php';

class Customersdetail extends REST_Controller {

    function __construct()

    {
     // Construct the parent class
        parent::__construct();
        $this->load->model('Customersdetail_model');
        $this->load->model('Api_model');
          
        $this->load->model('projects_model');
        $this->load->model('proposals_model');
        $this->load->model('ProposalInvoice_model');


    }

private $statuses = [
        'UNPAID',
        'PAID',
        'PARTIALLY',
        'OVERDUE',
        'CANCELLED',
        'DRAFT',
    ];

    public function data_get($id = '')

    {

        $customer_id=$this->get('customer_id');
       
        $filters = [
        'customer_id' => $customer_id,  
        'detailtype'=>$this->get('detailtype')?$this->get('detailtype'):null,
        'typeof'=>$this->get('typeof')?$this->get('typeof'):null,
        'start' => $this->get('start') && is_numeric($this->get('start')) ? $this->get('start') : 1,
        'limit' => $this->get('limit') && is_numeric($this->get('limit')) ? $this->get('limit') : 10,   
        
        ];
         $S_data=[];
         $S1_data=[];
        if($filters['detailtype']!=null){
            if($filters['detailtype']=='discussion'){

                $data = $this->Customersdetail_model->getdiscussionDetail($filters);
                foreach ($data as $datas) {
                    $datas->discussion = $this->Customersdetail_model->getComments($datas->id);
                    $S1_data[] = $datas;
                }
                $data=$S1_data;
                if ($data)
                {
                    $S_data =  [
                        'data' => $data,
                        'status' => 1,
                        'message'=>'success',


                    ];
                    $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $S_data =  [
                        'data' => $data,
                        'status' => 0,
                        'message'=>'record not found',


                    ];
                    $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
                }
            }
            if($filters['detailtype']=='case_discussion'){

                $data = $this->Customersdetail_model->getCaseDiscussionDetail($filters);
                foreach ($data as $datas) {
                    $datas->discussion = $this->Customersdetail_model->getCaseComments($datas->id);
                    $S1_data[] = $datas;
                }
                $data=$S1_data;
                if ($data)
                {
                    $S_data =  [
                        'data' => $data,
                        'status' => 1,
                        'message'=>'success',


                    ];
                    $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $S_data =  [
                        'data' => $data,
                        'status' => 0,
                        'message'=>'record not found',


                    ];
                    $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
                }
            }

            if($filters['detailtype']=='invoice'){
                $data = $this->Customersdetail_model->getcustomerinvoice($filters);
                foreach ($data as $datas) {
                    $datas->currency_name = $this->Api_model->get_currency_name($datas->currency);      $datas->status_name = $this->statuses[$datas->status -1];  
                    $datas->Invoice_name = $this->Api_model->get_customer_Name($customer_id);
                    $datas->invoicepayment=$this->ProposalInvoice_model->get_paymentinvoice($datas->id);
                    $datas->duepayment=(string) ($datas->total -   $datas->invoicepayment);         
                    $S1_data[] = $datas;
                }
                $data=$S1_data;
                 if ($data)
            {
             $S_data =  [
                        'data' => $data,  
                        'status' => 1,
                        'message'=>'success',
                        'start' => (int) $filters['start'],
                        'limit'=>(int) $filters['limit'],
                       
                    ];   
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $S_data =  [
                    'data' => $data,
                    'status' => 0,
                    'message'=>'record not found',
                    'start' => (int) $filters['start'],
                    'limit'=>(int) $filters['limit'],
                   
                ];
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
            }
        if($filters['detailtype']=='statement'){
 if ($data)
            {
             $S_data =  [
                        'data' => $data,  
                        'status' => 1,
                        'message'=>'success',
                        'start' => (int) $filters['start'],
                        'limit'=>(int) $filters['limit'],
                       
                    ];   
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $S_data =  [
                    'data' => $data,
                    'status' => 0,
                    'message'=>'record not found',
                    'start' => (int) $filters['start'],
                    'limit'=>(int) $filters['limit'],
                   
                ];
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
        }
        if($filters['detailtype']=='contact'){
             $data = $this->Customersdetail_model->getcustomercontact($filters);
              if ($data)
            {
             $S_data =  [
                        'data' => $data,  
                        'status' => 1,
                        'message'=>'success',
                        'start' => (int) $filters['start'],
                        'limit'=>(int) $filters['limit'],
                       
                    ];   
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $S_data =  [
                    'data' => $data,
                    'status' => 0,
                    'message'=>'record not found',
                    'start' => (int) $filters['start'],
                    'limit'=>(int) $filters['limit'],
                   
                ];
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
        }

        if($filters['detailtype']=='estimate'){
             $data = $this->Customersdetail_model->getcustomerestimate($filters);
             $data1=$this->Customersdetail_model->getestimatecount($filters);
                     
                foreach ($data as $datas) {
                    $datas->status_name=format_estimate_status($datas->status, '', false);
                    $datas->currency_name = $this->Api_model->get_currency_name($datas->currency);             
                    $datas->addedfrom_name = $this->Api_model->get_addedfrom_name($datas->addedfrom);             
                    $S1_data[] = $datas;
                }
               $data=$S1_data;
               
                 if ($data)
            {
             $S_data =  [
                        'data' => $data,  
                        'estimate_count' => $data1,  
                        'status' => 1,
                        'message'=>'success',
                        'start' => (int) $filters['start'],
                        'limit'=>(int) $filters['limit'],
                       
                    ];   
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $S_data =  [
                    'data' => $data,
                    'estimate_count' => array(),
                    'status' => 0,
                    'message'=>'record not found',
                    'start' => (int) $filters['start'],
                    'limit'=>(int) $filters['limit'],
                   
                ];
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
                
        }
            if($filters['detailtype']=='project'){
                $data = $this->Customersdetail_model->getcustomerproject($filters);

$_where = '';
                $statuses = $this->projects_model->get_project_statuses();

                foreach ($statuses as $key => $status) {
                    if($filters['typeof']=='customer'){
                        $where = ($_where == '' ? '' : $_where.' AND ').'status = '.$status['id'] .' AND clientid = '.$filters['customer_id'];

                    }
                    else{
                        $where = ($_where == '' ? '' : $_where.' AND ').'status = '.$status['id'];

                    }
                    $total = total_rows(db_prefix().'projects',$where);
                    $datacount[]= array('status_name' =>$status['name'] ,
                        'status_order'=>$status['order'],
                        'total'=>(String)$total  ,
                        'statuscolor'=>$status['color']);
                }



                foreach ($data as $datas) {

                    $datas->description=strip_tags($datas->description);
                    $datas->currency_name = $this->Api_model->get_currency_name($datas->currency);
                    $datas->addedfrom_name = $this->Api_model->get_addedfrom_name($datas->addedfrom);
                    $datas->projectstatusname=$this->getProjectStatusname($datas->status);
                    $datas->status_color = $this->Api_model->get_task_statuscolor($datas->status);
                    $datas->extra_field=$this->Customersdetail_model->getExtraField($datas->id);
                    $datas->tags_field=$this->Customersdetail_model->getTagsField($datas->id);
                    $datas->datamembers = $this->Customersdetail_model->getcustomerprojectmember($datas->id);

                    $S1_member=[];
                    foreach ( $datas->datamembers as $memberdata) {
                        $memberdata->member_name = $this->Api_model->getStaffbyId($memberdata->staff_id);

                    }

                    $S1_data[] = $datas;

                }
                $data=$S1_data;
                if ($data)
                {
                    $S_data =  [
                        'data' => $data,
                        'projectCount'=>$datacount,
                        'status' => 1,
                        'message'=>'success',
                        'start' => (int) $filters['start'],
                        'limit'=>(int) $filters['limit'],

                    ];
                    $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $S_data =  [
                        'data' => $data,
                        'projectCount'=>$datacount,
                        'status' => 0,
                        'message'=>'record not found',
                        'start' => (int) $filters['start'],
                        'limit'=>(int) $filters['limit'],

                    ];
                    $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
                }
            }
            if($filters['detailtype']=='case'){
                $_where = '';
                $case_id = $this->input->get('case_id');
                $this->load->model('legalservices/Cases_model', 'case');
                $this->load->helper('date_helper');
                if(is_numeric($case_id))
                {

                    $data = [];
                    $id = $case_id;
                    $project = $this->case->get($case_id);
                    $slug = $this->legal->get_service_by_id(1)->row()->slug;
                    $data['slug'] = $slug;
                    $data['statuses'] = $this->case->get_project_statuses();
                    $data['tabs'] = get_case_tabs_admin();
                    $this->load->model('payment_modes_model');
                    $data['payment_modes'] = $this->payment_modes_model->get('', [], true);

                    $data['project']  = $project;
                    $data['currency'] = $this->case->get_currency($id);

                    $data['staff']     = $this->staff_model->get('', ['active' => 1]);
                    $data['members'] = $this->case->get_project_members($id);
                    foreach ($data['members'] as $key => $member) {
                        $data['members'][$key]['total_logged_time'] = 0;
                        $member_timesheets = $this->tasks_model->get_unique_member_logged_task_ids($member['staff_id'], ' AND task_id IN (SELECT id FROM ' . db_prefix() . 'tasks WHERE rel_type="'.$slug.'" AND rel_id="' . $this->db->escape_str($id) . '")');

                        foreach ($member_timesheets as $member_task) {
                            $data['members'][$key]['total_logged_time'] += $this->tasks_model->calc_task_total_time($member_task->task_id, ' AND staff_id=' . $member['staff_id']);
                        }
                    }

                    $data['project_total_days']        = round((human_to_unix($data['project']->deadline . ' 00:00') - human_to_unix($data['project']->start_date . ' 00:00')) / 3600 / 24);
                    $data['project_days_left']         = $data['project_total_days'];
                    $data['project_time_left_percent'] = 100;
                    if ($data['project']->deadline) {
                        if (human_to_unix($data['project']->start_date . ' 00:00') < time() && human_to_unix($data['project']->deadline . ' 00:00') > time()) {
                            $data['project_days_left']         = round((human_to_unix($data['project']->deadline . ' 00:00') - time()) / 3600 / 24);
                            $data['project_time_left_percent'] = $data['project_days_left'] / $data['project_total_days'] * 100;
                            $data['project_time_left_percent'] = round($data['project_time_left_percent'], 2);
                        }
                        if (human_to_unix($data['project']->deadline . ' 00:00') < time()) {
                            $data['project_days_left']         = 0;
                            $data['project_time_left_percent'] = 0;
                        }
                    }

                    $__total_where_tasks = 'rel_type = "'.$slug.'" AND rel_id=' . $this->db->escape_str($id);
                    $staff_id = $this->input->get('staff_id');
                    if (!staff_can('view', 'tasks', $staff_id)) {
                        $__total_where_tasks .= ' AND ' . db_prefix() . 'tasks.id IN (SELECT taskid FROM ' . db_prefix() . 'task_assigned WHERE staffid = ' . get_staff_user_id($staff_id) . ')';

                        if (get_option('show_all_tasks_for_project_member') == 1) {
                            $__total_where_tasks .= ' AND (rel_type="'.$slug.'" AND rel_id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . get_staff_user_id($staff_id) . '))';
                        }
                    }

                    $__total_where_tasks = hooks()->apply_filters('admin_total_project_tasks_where', $__total_where_tasks, $id);

                    $where = ($__total_where_tasks == '' ? '' : $__total_where_tasks . ' AND ') . 'status != ' . Tasks_model::STATUS_COMPLETE;

                    $data['tasks_not_completed'] = total_rows(db_prefix() . 'tasks', $where);
                    $total_tasks                 = total_rows(db_prefix() . 'tasks', $__total_where_tasks);
                    $data['total_tasks']         = $total_tasks;

                    $where = ($__total_where_tasks == '' ? '' : $__total_where_tasks . ' AND ') . 'status = ' . Tasks_model::STATUS_COMPLETE . ' AND rel_type="'.$slug.'" AND rel_id="' . $this->db->escape_str($id) . '"';

                    $data['tasks_completed'] = total_rows(db_prefix() . 'tasks', $where);

                    $data['tasks_not_completed_progress'] = ($total_tasks > 0 ? number_format(($data['tasks_completed'] * 100) / $total_tasks, 2) : 0);
                    $data['tasks_not_completed_progress'] = round($data['tasks_not_completed_progress'], 2);

                    $percent           = $this->case->calc_progress($id, $slug);
                    $percent_circle        = $percent / 100;
                    $data['percent_circle'] = $percent_circle;

                    $other_projects       = [];
                    $other_projects_where = 'id != ' . $id;

                    $statuses = $this->case->get_project_statuses();

                    $other_projects_where .= ' AND (';
                    foreach ($statuses as $status) {
                        if (isset($status['filter_default']) && $status['filter_default']) {
                            $other_projects_where .= 'status = ' . $status['id'] . ' OR ';
                        }
                    }

                    $other_projects_where = rtrim($other_projects_where, ' OR ');

                    $other_projects_where .= ')';

                    if (!staff_can('view', 'projects', $staff_id)) {
                        $other_projects_where .= ' AND ' . db_prefix() . 'projects.id IN (SELECT project_id FROM ' . db_prefix() . 'my_members_cases WHERE staff_id=' . get_staff_user_id($staff_id) . ')';
                    }

                    $data['project_overview_chart'] = $this->case->get_project_overview_weekly_chart_data($slug,$id, ($this->input->get('overview_chart') ? $this->input->get('overview_chart'):'this_week'));
                    $data['other_projects'] = $this->case->get($other_projects_where);
                    $data['judges_case']    = $this->case->GetJudgesCases($id);
                    $data['title']          = $data['project']->name;
                    $data['project_status'] = get_case_status_by_id($project->status);
                    $data['service']        = $this->legal->get_service_by_id(1)->row();
                    $data['case_model']     = $this->case;
                    $data['ServID']         = 1;
                    $data['id'] = $id;
                    $this->db->where('country_id', $project->country);
                    $data['project']->country = $this->db->get('tblcountries')->row();
                    $this->response($data, REST_Controller::HTTP_OK);
                }

                $data = $this->Customersdetail_model->getcustomercase($filters, $case_id);

                $statuses = $this->case->get_project_statuses();

                foreach ($statuses as $key => $status) {
                    if($filters['typeof']=='customer'){
                        $where = ($_where == '' ? '' : $_where.' AND ').'status = '.$status['id'] .' AND clientid = '.$filters['customer_id'];

                    }
                    else{
                        $where = ($_where == '' ? '' : $_where.' AND ').'status = '.$status['id'];

                    }
                    $total = total_rows(db_prefix().'my_cases',$where);
                    $datacount[]= array('status_name' =>$status['name'] ,
                        'status_order'=>$status['order'],
                        'total'=>(String)$total  ,
                        'statuscolor'=>$status['color']);
                }



                foreach ($data as $datas) {
                    $datas->description=strip_tags($datas->description);
                    //$datas->currency_name = $this->Api_model->get_currency_name($datas->currency);
                    $datas->addedfrom_name = $this->Api_model->get_addedfrom_name($datas->addedfrom);
                    $datas->projectstatusname=$this->getProjectStatusname($datas->status);
                  //  $datas->status_color = $this->Api_model->get_task_statuscolor($datas->status);
                    $datas->extra_field=$this->Customersdetail_model->getExtraField($datas->id);
                    $datas->tags_field=$this->Customersdetail_model->getTagsField($datas->id);
                    $datas->datamembers = $this->Customersdetail_model->getcustomerprojectmember($datas->id);

                    $S1_member=[];
                    foreach ( $datas->datamembers as $memberdata) {
                        $memberdata->member_name = $this->Api_model->getStaffbyId($memberdata->staff_id);

                    }

                    $S1_data[] = $datas;

                }
                $data=$S1_data;
                if ($data)
                {
                    $S_data =  [
                        'data' => $data,
                        'projectCount'=>$datacount,
                        'status' => 1,
                        'message'=>'success',
                        'start' => (int) $filters['start'],
                        'limit'=>(int) $filters['limit'],

                    ];
                    $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $S_data =  [
                        'data' => $data,
                        'projectCount'=>$datacount,
                        'status' => 0,
                        'message'=>'record not found',
                        'start' => (int) $filters['start'],
                        'limit'=>(int) $filters['limit'],

                    ];
                    $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
                }
            }
        if($filters['detailtype'] == 'files' and $filters['typeof'] == 'case') {
            $data = $this->Customersdetail_model->getcustomerfile($filters);
            foreach ($data as $datas) {

                if ($filters['typeof'] == 'case') {
                    $datas->rel_id = $datas->id;
                    $datas->rel_type = 'case';
                }
                $datas->filepath = $this->Api_model->GetPath($datas->rel_id, $datas->rel_type);
                $S1_data[] = $datas;
            }
            if ($data) {
                $S_data = [
                    'data' => $data,
                    'status' => 1,
                    'message' => 'success',
                    'start' => (int)$filters['start'],
                    'limit' => (int)$filters['limit'],

                ];
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $S_data = [
                    'data' => $data,
                    'status' => 0,
                    'message' => 'record not found',
                    'start' => (int)$filters['start'],
                    'limit' => (int)$filters['limit'],

                ];
                $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code

            }
        }
        if($filters['detailtype']=='files' and $filters['typeof'] != 'case'){
            $data = $this->Customersdetail_model->getcustomerfile($filters);
          
             foreach ($data as $datas) {
                   
                    $datas->filepath = $this->Api_model->GetPath($datas->rel_id,$datas->rel_type);             
                    $S1_data[] = $datas;
                   
                }
             if ($data)
            {
             $S_data =  [
                        'data' => $data,  
                        'status' => 1,
                        'message'=>'success',
                        'start' => (int) $filters['start'],
                        'limit'=>(int) $filters['limit'],
                       
                    ];   
                $this->response($S_data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }else{
                    $S_data =  [
                    'data' => $data,
                    'status' => 0,
                    'message'=>'record not found',
                    'start' => (int) $filters['start'],
                    'limit'=>(int) $filters['limit'],
                   
                ];
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); // OK (200) being the HTTP response code
        }
               
        }
        }else{
             $S_data =  [
                    'data' => array(),
                    'status' => 0,
                    'message'=>'fill detailtype :invoice / statement/ contact/ estimate/ project/files',
                    'start' => (int) $filters['start'],
                    'limit'=>(int) $filters['limit'],
                   
                ];
            $this->response($S_data, REST_Controller::HTTP_NOT_FOUND); 
        }    
              
       
       
        

    }



public function getProjectStatusname($id)
{
 // $id = 2;
   $projectstatus=$this->projects_model->get_project_statuses();
   foreach ($projectstatus as $key => $status) {
     if ($status['id'] == $id) {
       return $status;
     }
   }
   return false;
}

    public function data_search_get($key = '')

    {

        // If the id parameter doesn't exist return all the

        $data = $this->Api_model->search('customer', $key);



        // Check if the data store contains

        if ($data)

        {

            // Set the response and exit

            $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

        }

        else

        {

            // Set the response and exit

            $this->response([

                'status' => FALSE,

                'message' => 'No data were found'

            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code

        }

    }



    public function data_post()

    {

        // form validation

        $this->form_validation->set_rules('company', 'Company', 'trim|required|max_length[600]', array('is_unique' => 'This %s already exists please enter another Company'));

        if ($this->form_validation->run() == FALSE)

        {

            // form validation error

            $message = array(

                'status' => FALSE,

                'error' => $this->form_validation->error_array(),

                'message' => validation_errors() 

            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);

        }

        else

        {

                $groups_in = $this->Api_model->value($this->input->post('groups_in', TRUE));

            $insert_data = [

                'company' => $this->input->post('company', TRUE),



                'vat' => $this->Api_model->value($this->input->post('vat', TRUE)),

                'phonenumber' => $this->Api_model->value($this->input->post('phonenumber', TRUE)),

                'website' => $this->Api_model->value($this->input->post('website', TRUE)),

                'default_currency' => $this->Api_model->value($this->input->post('default_currency', TRUE)),

                'default_language' => $this->Api_model->value($this->input->post('default_language', TRUE)),

                'address' => $this->Api_model->value($this->input->post('address', TRUE)),

                'city' => $this->Api_model->value($this->input->post('city', TRUE)),

                'state' => $this->Api_model->value($this->input->post('state', TRUE)),

                'zip' => $this->Api_model->value($this->input->post('zip', TRUE)),

                'country' => $this->Api_model->value($this->input->post('country', TRUE)),

                'billing_street' => $this->Api_model->value($this->input->post('billing_street', TRUE)),

                'billing_city' => $this->Api_model->value($this->input->post('billing_city', TRUE)),

                'billing_state' => $this->Api_model->value($this->input->post('billing_state', TRUE)),

                'billing_zip' => $this->Api_model->value($this->input->post('billing_zip', TRUE)),

                'billing_country' => $this->Api_model->value($this->input->post('billing_country', TRUE)),

                'shipping_street' => $this->Api_model->value($this->input->post('shipping_street', TRUE)),

                'shipping_city' => $this->Api_model->value($this->input->post('shipping_city', TRUE)),

                'shipping_state' => $this->Api_model->value($this->input->post('shipping_state', TRUE)),

                'shipping_zip' => $this->Api_model->value($this->input->post('shipping_zip', TRUE)),

                'shipping_country' => $this->Api_model->value($this->input->post('shipping_country', TRUE))

                ];

                if($groups_in != ''){

                    $insert_data['groups_in'] = $groups_in;

                }



            // insert data

            $this->load->model('clients_model');

            $output = $this->clients_model->add($insert_data);

            if($output > 0 && !empty($output)){

                // success

                $message = array(

                'status' => TRUE,

                'message' => 'Client add successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Client add fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        }

    }





    /**

     * @api {delete} api/delete/customers/:id Delete a Customer

     * @apiName DeleteCustomer

     * @apiGroup Customer

     *

     * @apiHeader {String} Authorization Basic Access Authentication token.

     *

     * @apiParam {Number} id Customer unique ID.

     *

     * @apiSuccess {String} status Request status.

     * @apiSuccess {String} message Customer Delete Successful.

     *

     * @apiSuccessExample Success-Response:

     *     HTTP/1.1 200 OK

     *     {

     *       "status": true,

     *       "message": "Customer Delete Successful."

     *     }

     *

     * @apiError {Boolean} status Request status.

     * @apiError {String} message Customer Delete Fail.

     *

     * @apiErrorExample Error-Response:

     *     HTTP/1.1 404 Not Found

     *     {

     *       "status": false,

     *       "message": "Customer Delete Fail."

     *     }

     */

    public function data_delete($id = '')

    { 

        $id = $this->security->xss_clean($id);

        if(empty($id) && !is_numeric($id))

        {

            $message = array(

            'status' => FALSE,

            'message' => 'Invalid Customer ID'

        );

        $this->response($message, REST_Controller::HTTP_NOT_FOUND);

        }

        else

        {

            // delete data

            $this->load->model('clients_model');

            $output = $this->clients_model->delete($id);

            if($output === TRUE){

                // success

                $message = array(

                'status' => TRUE,

                'message' => 'Customer Delete Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Customer Delete Fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        }

    }





    /**

     * @api {put} api/customers/:id Update a Customer

     * @apiName PutCustomer

     * @apiGroup Customer

     *

     * @apiHeader {String} Authorization Basic Access Authentication token.

     *

     * @apiParam {String} company               Mandatory Customer company.

     * @apiParam {String} [vat]                 Optional Vat.

     * @apiParam {String} [phonenumber]         Optional Customer Phone.

     * @apiParam {String} [website]             Optional Customer Website.

     * @apiParam {Number[]} [groups_in]         Optional Customer groups.

     * @apiParam {String} [default_language]    Optional Customer Default Language.

     * @apiParam {String} [default_currency]    Optional default currency.

     * @apiParam {String} [address]             Optional Customer address.

     * @apiParam {String} [city]                Optional Customer City.

     * @apiParam {String} [state]               Optional Customer state.

     * @apiParam {String} [zip]                 Optional Zip Code.

     * @apiParam {String} [country]             Optional country.

     * @apiParam {String} [billing_street]      Optional Billing Address: Street.

     * @apiParam {String} [billing_city]        Optional Billing Address: City.

     * @apiParam {Number} [billing_state]       Optional Billing Address: State.

     * @apiParam {String} [billing_zip]         Optional Billing Address: Zip.

     * @apiParam {String} [billing_country]     Optional Billing Address: Country.

     * @apiParam {String} [shipping_street]     Optional Shipping Address: Street.

     * @apiParam {String} [shipping_city]       Optional Shipping Address: City.

     * @apiParam {String} [shipping_state]      Optional Shipping Address: State.

     * @apiParam {String} [shipping_zip]        Optional Shipping Address: Zip.

     * @apiParam {String} [shipping_country]    Optional Shipping Address: Country.

     *

     * @apiParamExample {json} Request-Example:

     *  {

     *     "company": "Công ty A",

     *     "vat": "",

     *     "phonenumber": "0123456789",

     *     "website": "",

     *     "default_language": "",

     *     "default_currency": "0",

     *     "country": "243",

     *     "city": "TP London",

     *     "zip": "700000",

     *     "state": "Quận 12",

     *     "address": "hẻm 71, số 34\/3 Đường TA 16, Phường Thới An, Quận 12",

     *     "billing_street": "hẻm 71, số 34\/3 Đường TA 16, Phường Thới An, Quận 12",

     *     "billing_city": "TP London",

     *     "billing_state": "Quận 12",

     *     "billing_zip": "700000",

     *     "billing_country": "243",

     *     "shipping_street": "",

     *     "shipping_city": "",

     *     "shipping_state": "",

     *     "shipping_zip": "",

     *     "shipping_country": "0"

     *   }

     *

     * @apiSuccess {Boolean} status Request status.

     * @apiSuccess {String} message Customer Update Successful.

     *

     * @apiSuccessExample Success-Response:

     *     HTTP/1.1 200 OK

     *     {

     *       "status": true,

     *       "message": "Customer Update Successful."

     *     }

     *

     * @apiError {Boolean} status Request status.

     * @apiError {String} message Customer Update Fail.

     *

     * @apiErrorExample Error-Response:

     *     HTTP/1.1 404 Not Found

     *     {

     *       "status": false,

     *       "message": "Customer Update Fail."

     *     }

     */

    public function data_put($id = '')

    {

        $_POST = json_decode($this->security->xss_clean(file_get_contents("php://input")), true);

        $this->form_validation->set_data($_POST);

        

        if(empty($id) && !is_numeric($id))

        {

            $message = array(

            'status' => FALSE,

            'message' => 'Invalid Customers ID'

            );

            $this->response($message, REST_Controller::HTTP_NOT_FOUND);

        }

        else

        {



            $update_data = $this->input->post();

            // update data

            $this->load->model('clients_model');

            $output = $this->clients_model->update($update_data, $id);

            if($output > 0 && !empty($output)){

                // success

                $message = array(

                'status' => TRUE,

                'message' => 'Customers Update Successful.'

                );

                $this->response($message, REST_Controller::HTTP_OK);

            }else{

                // error

                $message = array(

                'status' => FALSE,

                'message' => 'Customers Update Fail.'

                );

                $this->response($message, REST_Controller::HTTP_NOT_FOUND);

            }

        }

    }

}

