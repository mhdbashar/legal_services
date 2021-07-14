<?php

defined('BASEPATH') or exit('No direct script access allowed');
require __DIR__.'/REST_Controller.php';

class Tickets extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // if (get_option('access_tickets_to_none_staff_members') == 0 && !is_staff_member()) {
        //     redirect(admin_url());
        // }
        $this->load->model('tickets_model');
        $this->load->model('Api_model');
        $this->load->model('Sendnotification');
    }

    
  
    public function data_post($userid = false)
    {
       
         if ($this->input->post()) {
            $this->form_validation->set_rules('subject', _l('customer_ticket_subject'), 'required');
            $this->form_validation->set_rules('department', _l('clients_ticket_open_departments'), 'required');
            $this->form_validation->set_rules('priority', _l('priority'), 'required');
            $custom_fields = get_custom_fields('tickets', [
                'show_on_client_portal' => 1,
                'required'              => 1,
            ]);
            foreach ($custom_fields as $field) {
                $field_name = 'custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']';
                if ($field['type'] == 'checkbox' || $field['type'] == 'multiselect') {
                    $field_name .= '[]';
                }
                $this->form_validation->set_rules($field_name, $field['name'], 'required');
            }
            if ($this->form_validation->run() !== false) {
                $data = $this->input->post();
                $data['contactid']=$this->Api_model->getcontactuser_id($data['userid']);
                $id = $this->tickets_model->add([
                    'subject'    => $data['subject'],
                    'department' => $data['department'],
                    'priority'   => $data['priority'],
                    'userid'=>$data['userid'],
                    'service'    => isset($data['service']) && is_numeric($data['service'])
                    ? $data['service']
                    : null,
                    'project_id' => isset($data['project_id']) && is_numeric($data['project_id'])
                    ? $data['project_id']
                    : 0,
                    'custom_fields' => isset($data['custom_fields']) && is_array($data['custom_fields'])
                    ? $data['custom_fields']
                    : [],
                    'message'   => $data['message'],
                    'contactid' => $data['contactid'],
                    'userid'    => $data['userid'],
                ]);


                $data1             = [];
                if($id>0){   
                        $this->db->select('staff_id');
                        $this->db->where('project_id', $data['project_id']);
                        $q = $this->db->get('tblproject_members');
                        $data = $q->result();

                    foreach ($data as $key ) {
                   
       
                            $tokenid=$this->Api_model->getToken($key->staff_id);
                            $tokenkey=$this->Api_model->getKey($key->staff_id);
                if($tokenid){
                           $this->Sendnotification->send_fcm('New Ticket Created #'.$id,$tokenid,'Ticket',$tokenkey);
                       }
                    }
                     
                   
                }
       //  $data1 = $this->projects_model->get_projects_for_ticket($data['userid']);

        // $data1['title']    = _l('new_ticket');
                if ($id) {
                   
                    $s_data =  [
                         //'data' => $data1,
                        'message' =>'success',
                        'status' => 1,
                        ];
                 $this->response($s_data, REST_Controller::HTTP_OK);

                }else{
                     $s_data =  [
                        // 'data' => $data1,
                        'message' =>'error',
                        'status' => 0,
                        ];
                 $this->response($s_data, REST_Controller::HTTP_NOT_FOUND);
                }

            }

        }

        
        
    }


    
   public function ticketreply_post()
   {
        $ticketid=$this->input->post('ticketid');
        $userid=$this->input->post('userid');
        $replydata=$this->input->post('replydata');
        $data['ticket'] = $this->tickets_model->get_ticket_by_id($ticketid, $userid);
        
      
        $replyfatchdata=[];
        $temp=[];
        
        if ($this->input->post()) {

            // $this->form_validation->set_rules('message', _l('ticket_reply'), 'required');
            // if ($this->form_validation->run() !== false) {
            
                $data = $this->input->post();
               
            
            if($data['replydata']=='no'){


                $data['contactid']=$this->Api_model->getcontactuser_id($data['userid']);
                $replyid = $this->tickets_model->add_reply([
                    'message'   => $data['message'],
                    'contactid' =>  $data['contactid'],
                    'userid'    =>  $data['userid'],
                ], $ticketid); 
                      

                      if($replyid>0){   

                        $this->db->select('project_id');
                        $this->db->where('ticketid', $ticketid);
                        $r = $this->db->get('tbltickets');
                        $dataticket = $r->row();

                        $this->db->select('staff_id');
                        $this->db->where('project_id', $dataticket->project_id);
                        $q = $this->db->get('tblproject_members');
                        $data = $q->result();
        
                    foreach ($data as $key ) {
                   

                            $tokenid=$this->Api_model->getToken($key->staff_id);
                            $tokenkey=$this->Api_model->getKey($key->staff_id);
                           
                             if($tokenid){
                                       
                           $q=$this->Sendnotification->send_fcm('Ticket Reply on #'.$ticketid,$tokenid,'Ticket Reply',$tokenkey);

                       }
                    }
                   
                   
                }
                if ($replyid) {
                    $s_data =  [
                        // 'data'=>$replyfatchdata,
                        'message' =>'success',
                        'status' => 1,
                        ];
                 $this->response($s_data, REST_Controller::HTTP_OK);

                }else{
                     $s_data =  [
                        // 'data' => array(),
                        'message' =>'error',
                        'status' => 0,
                        ];
                 $this->response($s_data, REST_Controller::HTTP_NOT_FOUND);
                }
            }else{
                     $replyfatchdata=$this->tickets_model->get_ticket_replies($ticketid);
                    foreach ($replyfatchdata as $ticket) {

$ticket['message'] = strip_tags($ticket['message']);

                          
                          $temp[]=$ticket;
                            }
                    $replyfatchdata=$temp;
                            
                          
               $s_data =  [
                        'data'=>$replyfatchdata,
                        'message' =>'success',
                        'status' => 1,
                        ];
                 $this->response($s_data, REST_Controller::HTTP_OK); 
            }
            // }

        }

    }



       
   

    public function edit_message()
    {
        if ($this->input->post()) {
            $data         = $this->input->post();
            $data['data'] = $this->input->post('data', false);

            if ($data['type'] == 'reply') {
                $this->db->where('id', $data['id']);
                $this->db->update(db_prefix().'ticket_replies', [
                    'message' => $data['data'],
                ]);
            } elseif ($data['type'] == 'ticket') {
                $this->db->where('ticketid', $data['id']);
                $this->db->update(db_prefix().'tickets', [
                    'message' => $data['data'],
                ]);
            }
            if ($this->db->affected_rows() > 0) {
                set_alert('success', _l('ticket_message_updated_successfully'));
            }
            redirect(admin_url('tickets/ticket/' . $data['main_ticket']));
        }
    }

    public function delete_ticket_reply($ticket_id, $reply_id)
    {
        if (!$reply_id) {
            redirect(admin_url('tickets'));
        }
        $response = $this->tickets_model->delete_ticket_reply($ticket_id, $reply_id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('ticket_reply')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('ticket_reply')));
        }
        redirect(admin_url('tickets/ticket/' . $ticket_id));
    }

    public function change_status_ajax($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            echo json_encode($this->tickets_model->change_ticket_status($id, $status));
        }
    }

    public function update_single_ticket_settings()
    {
        if ($this->input->post()) {
            $this->session->mark_as_flash('active_tab');
            $this->session->mark_as_flash('active_tab_settings');
            $success = $this->tickets_model->update_single_ticket_settings($this->input->post());
            if ($success) {
                $this->session->set_flashdata('active_tab', true);
                $this->session->set_flashdata('active_tab_settings', true);
                if (get_option('staff_access_only_assigned_departments') == 1) {
                    $ticket = $this->tickets_model->get_ticket_by_id($this->input->post('ticketid'));
                    $this->load->model('departments_model');
                    $staff_departments = $this->departments_model->get_staff_departments(get_staff_user_id(), true);
                    if (!in_array($ticket->department, $staff_departments) && !is_admin()) {
                        set_alert('success', _l('ticket_settings_updated_successfully_and_reassigned', $ticket->department_name));
                        echo json_encode([
                            'success'               => $success,
                            'department_reassigned' => true,
                        ]);
                        die();
                    }
                }
                set_alert('success', _l('ticket_settings_updated_successfully'));
            }
            echo json_encode([
                'success' => $success,
            ]);
            die();
        }
    }

    // Priorities
    /* Get all ticket priorities */
    public function priorities()
    {
        if (!is_admin()) {
            access_denied('Ticket Priorities');
        }
        $data['priorities'] = $this->tickets_model->get_priority();
        $data['title']      = _l('ticket_priorities');
        $this->load->view('admin/tickets/priorities/manage', $data);
    }

    /* Add new priority od update existing*/
    public function priority()
    {
        if (!is_admin()) {
            access_denied('Ticket Priorities');
        }
        if ($this->input->post()) {
            if (!$this->input->post('id')) {
                $id = $this->tickets_model->add_priority($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('ticket_priority')));
                }
            } else {
                $data = $this->input->post();
                $id   = $data['id'];
                unset($data['id']);
                $success = $this->tickets_model->update_priority($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('ticket_priority')));
                }
            }
            die;
        }
    }

    /* Delete ticket priority */
    public function delete_priority($id)
    {
        if (!is_admin()) {
            access_denied('Ticket Priorities');
        }
        if (!$id) {
            redirect(admin_url('tickets/priorities'));
        }
        $response = $this->tickets_model->delete_priority($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('ticket_priority_lowercase')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('ticket_priority')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('ticket_priority_lowercase')));
        }
        redirect(admin_url('tickets/priorities'));
    }

    /* List all ticket predefined replies */
    public function predefined_replies()
    {
        if (!is_admin()) {
            access_denied('Predefined Replies');
        }
        if ($this->input->is_ajax_request()) {
            $aColumns = [
                'name',
            ];
            $sIndexColumn = 'id';
            $sTable       = db_prefix().'tickets_predefined_replies';
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], [
                'id',
            ]);
            $output  = $result['output'];
            $rResult = $result['rResult'];
            foreach ($rResult as $aRow) {
                $row = [];
                for ($i = 0; $i < count($aColumns); $i++) {
                    $_data = $aRow[$aColumns[$i]];
                    if ($aColumns[$i] == 'name') {
                        $_data = '<a href="' . admin_url('tickets/predefined_reply/' . $aRow['id']) . '">' . $_data . '</a>';
                    }
                    $row[] = $_data;
                }
                $options            = icon_btn('tickets/predefined_reply/' . $aRow['id'], 'pencil-square-o');
                $row[]              = $options .= icon_btn('tickets/delete_predefined_reply/' . $aRow['id'], 'remove', 'btn-danger _delete');
                $output['aaData'][] = $row;
            }
            echo json_encode($output);
            die();
        }
        $data['title'] = _l('predefined_replies');
        $this->load->view('admin/tickets/predefined_replies/manage', $data);
    }

    public function get_predefined_reply_ajax($id)
    {
        echo json_encode($this->tickets_model->get_predefined_reply($id));
    }

    public function ticket_change_data()
    {
        if ($this->input->is_ajax_request()) {
            $contact_id = $this->input->post('contact_id');
            echo json_encode([
                'contact_data'          => $this->clients_model->get_contact($contact_id),
                'customer_has_projects' => customer_has_projects(get_user_id_by_contact_id($contact_id)),
            ]);
        }
    }

    /* Add new reply or edit existing */
    public function predefined_reply($id = '')
    {
        if (!is_admin() && get_option('staff_members_save_tickets_predefined_replies') == '0') {
            access_denied('Predefined Reply');
        }
        if ($this->input->post()) {
            $data              = $this->input->post();
            $data['message']   = $this->input->post('message', false);
            $ticketAreaRequest = isset($data['ticket_area']);

            if (isset($data['ticket_area'])) {
                unset($data['ticket_area']);
            }

            if ($id == '') {
                $id = $this->tickets_model->add_predefined_reply($data);
                if (!$ticketAreaRequest) {
                    if ($id) {
                        set_alert('success', _l('added_successfully', _l('predefined_reply')));
                        redirect(admin_url('tickets/predefined_reply/' . $id));
                    }
                } else {
                    echo json_encode(['success' => $id ? true : false, 'id' => $id]);
                    die;
                }
            } else {
                $success = $this->tickets_model->update_predefined_reply($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('predefined_reply')));
                }
                redirect(admin_url('tickets/predefined_reply/' . $id));
            }
        }
        if ($id == '') {
            $title = _l('add_new', _l('predefined_reply_lowercase'));
        } else {
            $predefined_reply         = $this->tickets_model->get_predefined_reply($id);
            $data['predefined_reply'] = $predefined_reply;
            $title                    = _l('edit', _l('predefined_reply_lowercase')) . ' ' . $predefined_reply->name;
        }
        $data['title'] = $title;
        $this->load->view('admin/tickets/predefined_replies/reply', $data);
    }

    /* Delete ticket reply from database */
    public function delete_predefined_reply($id)
    {
        if (!is_admin()) {
            access_denied('Delete Predefined Reply');
        }
        if (!$id) {
            redirect(admin_url('tickets/predefined_replies'));
        }
        $response = $this->tickets_model->delete_predefined_reply($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('predefined_reply')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('predefined_reply_lowercase')));
        }
        redirect(admin_url('tickets/predefined_replies'));
    }

    // Ticket statuses
    /* Get all ticket statuses */
    public function statuses()
    {
        if (!is_admin()) {
            access_denied('Ticket Statuses');
        }
        $data['statuses'] = $this->tickets_model->get_ticket_status();
        $data['title']    = 'Ticket statuses';
        $this->load->view('admin/tickets/tickets_statuses/manage', $data);
    }

    /* Add new or edit existing status */
    public function status()
    {
        if (!is_admin()) {
            access_denied('Ticket Statuses');
        }
        if ($this->input->post()) {
            if (!$this->input->post('id')) {
                $id = $this->tickets_model->add_ticket_status($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('ticket_status')));
                }
            } else {
                $data = $this->input->post();
                $id   = $data['id'];
                unset($data['id']);
                $success = $this->tickets_model->update_ticket_status($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('ticket_status')));
                }
            }
            die;
        }
    }

    /* Delete ticket status from database */
    public function delete_ticket_status($id)
    {
        if (!is_admin()) {
            access_denied('Ticket Statuses');
        }
        if (!$id) {
            redirect(admin_url('tickets/statuses'));
        }
        $response = $this->tickets_model->delete_ticket_status($id);
        if (is_array($response) && isset($response['default'])) {
            set_alert('warning', _l('cant_delete_default', _l('ticket_status_lowercase')));
        } elseif (is_array($response) && isset($response['referenced'])) {
            set_alert('danger', _l('is_referenced', _l('ticket_status_lowercase')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('ticket_status')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('ticket_status_lowercase')));
        }
        redirect(admin_url('tickets/statuses'));
    }

    /* List all ticket services */
    public function services()
    {
        if (!is_admin()) {
            access_denied('Ticket Services');
        }
        if ($this->input->is_ajax_request()) {
            $aColumns = [
                'name',
            ];
            $sIndexColumn = 'serviceid';
            $sTable       = db_prefix().'services';
            $result       = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], [
                'serviceid',
            ]);
            $output  = $result['output'];
            $rResult = $result['rResult'];
            foreach ($rResult as $aRow) {
                $row = [];
                for ($i = 0; $i < count($aColumns); $i++) {
                    $_data = $aRow[$aColumns[$i]];
                    if ($aColumns[$i] == 'name') {
                        $_data = '<a href="#" onclick="edit_service(this,' . $aRow['serviceid'] . ');return false" data-name="' . $aRow['name'] . '">' . $_data . '</a>';
                    }
                    $row[] = $_data;
                }
                $options = icon_btn('#', 'pencil-square-o', 'btn-default', [
                    'data-name' => $aRow['name'],
                    'onclick'   => 'edit_service(this,' . $aRow['serviceid'] . '); return false;',
                ]);
                $row[]              = $options .= icon_btn('tickets/delete_service/' . $aRow['serviceid'], 'remove', 'btn-danger _delete');
                $output['aaData'][] = $row;
            }
            echo json_encode($output);
            die();
        }
        $data['title'] = _l('services');
        $this->load->view('admin/tickets/services/manage', $data);
    }

    /* Add new service od delete existing one */
    public function service($id = '')
    {
        if (!is_admin() && get_option('staff_members_save_tickets_predefined_replies') == '0') {
            access_denied('Ticket Services');
        }

        if ($this->input->post()) {
            $post_data = $this->input->post();
            if (!$this->input->post('id')) {
                $requestFromTicketArea = isset($post_data['ticket_area']);
                if (isset($post_data['ticket_area'])) {
                    unset($post_data['ticket_area']);
                }
                $id = $this->tickets_model->add_service($post_data);
                if (!$requestFromTicketArea) {
                    if ($id) {
                        set_alert('success', _l('added_successfully', _l('service')));
                    }
                } else {
                    echo json_encode(['success' => $id ? true : false, 'id' => $id, 'name' => $post_data['name']]);
                }
            } else {
                $id = $post_data['id'];
                unset($post_data['id']);
                $success = $this->tickets_model->update_service($post_data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('service')));
                }
            }
            die;
        }
    }

    /* Delete ticket service from database */
    public function delete_service($id)
    {
        if (!is_admin()) {
            access_denied('Ticket Services');
        }
        if (!$id) {
            redirect(admin_url('tickets/services'));
        }
        $response = $this->tickets_model->delete_service($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('service_lowercase')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('service')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('service_lowercase')));
        }
        redirect(admin_url('tickets/services'));
    }

    public function block_sender()
    {
        if ($this->input->post()) {
            $this->load->model('spam_filters_model');
            $sender  = $this->input->post('sender');
            $success = $this->spam_filters_model->add(['type' => 'sender', 'value' => $sender], 'tickets');
            if ($success) {
                set_alert('success', _l('sender_blocked_successfully'));
            }
        }
    }

    public function bulk_action()
    {
        hooks()->do_action('before_do_bulk_action_for_tickets');
        if ($this->input->post()) {
            $total_deleted = 0;
            $ids           = $this->input->post('ids');
            $status        = $this->input->post('status');
            $department    = $this->input->post('department');
            $service       = $this->input->post('service');
            $priority      = $this->input->post('priority');
            $tags          = $this->input->post('tags');
            $is_admin      = is_admin();
            if (is_array($ids)) {
                foreach ($ids as $id) {
                    if ($this->input->post('mass_delete')) {
                        if ($is_admin) {
                            if ($this->tickets_model->delete($id)) {
                                $total_deleted++;
                            }
                        }
                    } else {
                        if ($status) {
                            $this->db->where('ticketid', $id);
                            $this->db->update(db_prefix().'tickets', [
                                'status' => $status,
                            ]);
                        }
                        if ($department) {
                            $this->db->where('ticketid', $id);
                            $this->db->update(db_prefix().'tickets', [
                                'department' => $department,
                            ]);
                        }
                        if ($priority) {
                            $this->db->where('ticketid', $id);
                            $this->db->update(db_prefix().'tickets', [
                                'priority' => $priority,
                            ]);
                        }

                        if ($service) {
                            $this->db->where('ticketid', $id);
                            $this->db->update(db_prefix().'tickets', [
                                'service' => $service,
                            ]);
                        }
                        if ($tags) {
                            handle_tags_save($tags, $id, 'ticket');
                        }
                    }
                }
            }

            if ($this->input->post('mass_delete')) {
                set_alert('success', _l('total_tickets_deleted', $total_deleted));
            }
        }
    }
}
