<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Dashboard_model extends CI_Model

{

    public function __construct() {

        parent::__construct();

     }


     public function count_leadbystatus($staff_id)
     {
     	if($staff_id){

            $this->db->select('tblleads.status,tblleads_status.name,tblleads_status.color,Count(tblleads.id) as Total')
                         ->from('tblleads')
                         ->join('tblleads_status', 'tblleads.status = tblleads_status.id');

            $this->db->where('assigned', $staff_id);
            $this->db->group_by('status'); 
            $this->db->order_by('Total', 'desc');  # or desc

        }
        return $this->db->get()->result();
     	
     }

     public function total_leads($staff_id)
     {
        if($staff_id){
            $this->db->select('Count(tblleads.id) as Total')
                         ->from('tblleads');
            $this->db->where('assigned', $staff_id);
        }
        return $this->db->count_all_results();
         # code...
     }
     
  public function total_customer($staff_id)
     {
        if($staff_id){
            $this->db->select('Count(userid) as Total')
                         ->from('tblclients');
            
        }
        return $this->db->count_all_results();
         # code...
     }

       public function total_project($staff_id)
     {
        if($staff_id){
            $this->db->select('Count(userid) as Total')
                         ->from('tblprojects');
            
        }
        return $this->db->count_all_results();
         # code...
     }

      public function get_upcoming_events($staff_id)
    {
        $this->db->where('(start BETWEEN "' . date('Y-m-d', strtotime('monday this week')) . '" AND "' . date('Y-m-d', strtotime('sunday this week')) . '")');
        $this->db->where('(userid = ' . $staff_id . ' OR public = 1)');
        $this->db->order_by('start', 'desc');
        $this->db->limit(6);

        return $this->db->get(db_prefix() . 'events')->result_array();
    }

    

    public function projects_status_stats($staff_id)
    {
                // echo "<pre>";print_r($staff_id);echo "</pre>"; die();
        $this->load->model('projects_model');
        $statuses = $this->projects_model->get_project_statuses();
        $colors   = get_system_favourite_colors();

        $chart = [];

        $_data                         = [];
        $_data['labels']                 = [];
        $_data['data']                 = [];
        $_data['backgroundColor']      = [];
        $_data['hoverBackgroundColor'] = [];
        $_data['statusLink']           = [];


        $has_permission = has_permission('projects', '', 'view');
        $sql            = '';
        foreach ($statuses as $status) {
            $sql .= ' SELECT COUNT(*) as total';
            $sql .= ' FROM ' . db_prefix() . 'projects';
            $sql .= ' WHERE status=' . $status['id'];
            if (!$has_permission) {
                $sql .= ' AND id IN (SELECT project_id FROM ' . db_prefix() . 'project_members WHERE staff_id=' . $staff_id . ')';
            }
            $sql .= ' UNION ALL ';
            $sql = trim($sql);
        }

        $result = [];
        if ($sql != '') {
            // Remove the last UNION ALL
            $sql    = substr($sql, 0, -10);
            $result = $this->db->query($sql)->result();
        }

        foreach ($statuses as $key => $status) {
            array_push($_data['statusLink'], admin_url('projects?status=' . $status['id']));
            array_push($_data['labels'], $status['name']);
            array_push($_data['backgroundColor'], $status['color']);
            array_push($_data['hoverBackgroundColor'], adjust_color_brightness($status['color'], -20));
            array_push($_data['data'], $result[$key]->total);
        }

        $chart[]           = $_data;
       
                

        return $chart;
    }

    public function leads_status_stats($staff_id)
    {
        $chart = [];

        $_data                         = [];
         $_data['labels']                  = [];
        $_data['data']                 = [];
        $_data['backgroundColor']      = [];
        $_data['hoverBackgroundColor'] = [];
        $_data['statusLink']           = [];
        $result = get_leads_summary_from_helper($staff_id);
        foreach ($result as $status) {
            if (!isset($status['junk']) && !isset($status['lost'])) {
                if ($status['color'] == '') {
                    $status['color'] = '#737373';
                }
                array_push($_data['labels'], $status['name']);
                array_push($_data['backgroundColor'], $status['color']);
                array_push($_data['statusLink'], admin_url('leads?status=' . $status['id']));
                array_push($_data['hoverBackgroundColor'], adjust_color_brightness($status['color'], -20));
                array_push($_data['data'], $status['total']);
            }
        }

        $chart[] = $_data;
        return $chart;
    }

    /**
     * Display total tickets awaiting reply by department (chart)
     * @return array
     */
    public function tickets_awaiting_reply_by_department($staff_id)
    {
        $this->load->model('departments_model');
        $departments = $this->departments_model->get();
        $colors      = get_system_favourite_colors();
        $chart       = [];

        $_data                         = [];
        $_data['labels']                 = [];
        $_data['data']                 = [];
        $_data['backgroundColor']      = [];
        $_data['hoverBackgroundColor'] = [];

        $i = 0;
        foreach ($departments as $department) {
            if (!is_admin($staff_id)) {
                if (get_option('staff_access_only_assigned_departments') == 1) {
                    $staff_deparments_ids = $this->departments_model->get_staff_departments($staff_id, true);
                    $departments_ids      = [];
                    if (count($staff_deparments_ids) == 0) {
                        $departments = $this->departments_model->get();
                        foreach ($departments as $department) {
                            array_push($departments_ids, $department['departmentid']);
                        }
                    } else {
                        $departments_ids = $staff_deparments_ids;
                    }
                    if (count($departments_ids) > 0) {
                        $this->db->where('department IN (SELECT departmentid FROM ' . db_prefix() . 'staff_departments WHERE departmentid IN (' . implode(',', $departments_ids) . ') AND staffid="' . $staff_id . '")');
                    }
                }
            }
            $this->db->where_in('status', [
                1,
                2,
                4,
            ]);

            $this->db->where('department', $department['departmentid']);
            $total = $this->db->count_all_results(db_prefix() . 'tickets');

            if ($total > 0) {
                $color = '#333';
                if (isset($colors[$i])) {
                    $color = $colors[$i];
                }
                array_push($_data['labels'], $department['name']);
                array_push($_data['backgroundColor'], $color);
                array_push($_data['hoverBackgroundColor'], adjust_color_brightness($color, -20));
                array_push($_data['data'], $total);
            }
            $i++;
        }

        $chart[] = $_data;

        return $chart;
    }

    /**
     * Display total tickets awaiting reply by status (chart)
     * @return array
     */
    public function tickets_awaiting_reply_by_status($staff_id)
    {
        $this->load->model('tickets_model');
        $statuses             = $this->tickets_model->get_ticket_status();
        $_statuses_with_reply = [
            1,
            2,
            4,
        ];

        $chart = [];

        $_data                         = [];
        $_data['labels']                 = [];
        $_data['data']                 = [];
        $_data['backgroundColor']      = [];
        $_data['hoverBackgroundColor'] = [];
        $_data['statusLink']           = [];

        foreach ($statuses as $status) {
            if (in_array($status['ticketstatusid'], $_statuses_with_reply)) {

 
                if (!is_admin($staff_id)) {
                    if (get_option('staff_access_only_assigned_departments') == 1) {
                        $staff_deparments_ids = $this->departments_model->get_staff_departments($staff_id, true);

                        $departments_ids      = [];
                        if (count($staff_deparments_ids) == 0) {
                            $departments = $this->departments_model->get();
                            foreach ($departments as $department) {
                                array_push($departments_ids, $department['departmentid']);
                            }
                        } else {
                            $departments_ids = $staff_deparments_ids;
                        }
                        if (count($departments_ids) > 0) {
                            $this->db->where('department IN (SELECT departmentid FROM ' . db_prefix() . 'staff_departments WHERE departmentid IN (' . implode(',', $departments_ids) . ') AND staffid="' . $staff_id . '")');
                        }
                    }
                }

        

                $this->db->where('status', $status['ticketstatusid']);
                $total = $this->db->count_all_results(db_prefix() . 'tickets');
                if ($total > 0) {
                    array_push($_data['labels'], ticket_status_translate($status['ticketstatusid']));
                    array_push($_data['statusLink'], admin_url('tickets/index/' . $status['ticketstatusid']));
                    array_push($_data['backgroundColor'], $status['statuscolor']);
                    array_push($_data['hoverBackgroundColor'], adjust_color_brightness($status['statuscolor'], -20));
                    array_push($_data['data'], $total);
                }
            }
        }
        $chart[] = $_data;

        return $chart;
    }
}