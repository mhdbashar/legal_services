<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Regular_durations extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('legalservices/regular_duration_model','duration');
    }
//************ index **************
    public function index()
    {
        if (!has_permission('legal_services', '', 'create') ) {
            access_denied('legal_services');
        }
        $data['durations']= $this->duration->get_durations();
        $data['title']  = _l('regular_durations');
        $this->load->view('admin/legalservices/regular_duration/view',$data);
    }
//************* add *****************
    public function add()
    {
        if (!has_permission('legal_services', '', 'create'))
        {
            access_denied('legal_services');
        }

        if ($this->input->post())
        {
            $data = $this->input->post();
            $added = $this->duration->add_new_duration($data);
            if ($added)
            {
                set_alert('success', _l('added_successfully', _l('regular_duration')));
                redirect(admin_url("legalservices/regular_durations"));
            }
        }
        $this->load->view('admin/legalservices/regular_duration/add');
    }
//*************** edit_duration *******************
    public function edit_duration($id)
    {
        if (!has_permission('legal_services', '', 'edit'))
        {
            access_denied('legal_services');
        }
        if (!$id)
        {
            redirect(admin_url('legalservices/regular_durations'));
        }
        $data['title']  = _l('edit_regular_duration');
        $data['regular_duration']=$this->duration->get_duration_by_id($id);

        $this->load->view('admin/legalservices/regular_duration/edit',$data);

        if ($this->input->post())
        {
            $success = $this->duration->update_duration_data($id, $this->input->post());
            if ($success)
            {
                set_alert('success', _l('updated_successfully', _l('regular_duration')));
                redirect(admin_url('legalservices/regular_durations'));
            }
            else
            {
                set_alert('warning', _l('problem_updating', _l('regular_duration')));
                redirect(admin_url('legalservices/regular_durations'));
            }
        }
    }

//******************* delete_duration ***********************
    public function delete_duration($id)
    {

        if (!has_permission('legal_services', '', 'delete')) {
            access_denied('legal_services');
        }
        if (!$id)
        {
            redirect(admin_url('legalservices/regular_durations'));
        }
        $response = $this->duration->delete_duration($id);
        if ($response == true)
        {
            set_alert('success', _l('deleted', _l('regular_duration')));
        } else
        {
            set_alert('warning', _l('problem_deleting', _l('regular_duration')));
        }
        redirect(admin_url('legalservices/regular_durations'));
    }
//********* tab ***************************
    public function add_duration_cases($project_id)
    {
        if (!has_permission('legal_services', '', 'create'))
        {
            access_denied('legal_services');
        }
        $ServID = 1;
        $route ='Case';
        $data1['case_id']=$project_id;
        if ($this->input->post())
        {

            $data = $this->input->post();
            $added = $this->duration->add_new_duration_cases($data);
            if ($added)
            {
                set_alert('success', _l('added_successfully'));
                redirect(admin_url($route.'/view/'.$ServID.'/'.$project_id.'?group=regular_duration'));
            }
        }
        $this->load->view('admin/legalservices/regular_duration/add_case_duration',$data1);

    }
    //***************edit_case_duration*****************
    public function edit_case_duration($case_id,$duration_id,$case_duration_id)
    {
        if (!has_permission('legal_services', '', 'edit'))
        {
            access_denied('legal_services');
        }
        //if (!$id)
        // {
        // redirect(admin_url('legalservices/regular_durations'));
        //}
        $data['title']  = _l('edit_regular_duration');
        $data['case_duration']=$this->duration->get_case_duration_by_id($case_duration_id);
        $data['case_id']=$case_id;
        $data['id']=$case_duration_id;


        $route = 'Case';
        $ServID=1;
        $this->load->view('admin/legalservices/regular_duration/edit_case_duration',$data);

        if ($this->input->post())
        {
            $success = $this->duration->update_case_duration_data($case_duration_id, $this->input->post());
            if ($success)
            {
                set_alert('success', _l('updated_successfully'));
                redirect(admin_url($route.'/view/'.$ServID.'/'.$case_id.'?group=regular_duration'));
            }
            else
            {
                set_alert('warning', _l('problem_updating', _l('regular_duration')));
                redirect(admin_url($route.'/view/'.$ServID.'/'.$case_id.'?group=regular_duration'));
            }
        }
    }
    //*******************delete_case_duration*******************
    public function delete_case_duration($case_duration_id,$case_id)
    {
        $route = 'Case';
        $ServID=1;

        if (!has_permission('legal_services', '', 'delete')) {
            access_denied('legal_services');
        }
        if (!$case_duration_id)
        {
            //redirect(admin_url('legalservices/regular_durations'));
        }
        $response = $this->duration->delete_case_duration($case_duration_id);
        if ($response == true)
        {
            set_alert('success', _l('deleted', _l('regular_duration')));
        } else
        {
            set_alert('warning', _l('problem_deleting', _l('regular_duration')));
        }
        redirect(admin_url($route.'/view/'.$ServID.'/'.$case_id.'?group=regular_duration'));
    }



//*************close alert*******************
    public  function dur_alert_close($case_reg_id)
    {
        $this->duration->dur_alert_close_model($case_reg_id);
    }

    //************clear duration notified****************
    public  function clear_dur_notified($case_id)
    {
        $this->duration->clear_dur_notified_model($case_id);
    }
//***********************
    public  function add_case_regular($case_reg_id)
    {
        // $this->duration->clear_dur_notified_model($case_reg_id);
    }
//********************



}
