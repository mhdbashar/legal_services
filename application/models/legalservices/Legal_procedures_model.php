<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Legal_procedures_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('contracts_model');
    }

    public function get($id = '', $where = [])
    {
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            $this->db->get(db_prefix() . 'my_categories')->row();
        }
        return $this->db->get(db_prefix() . 'my_categories')->result_array();
    }

    public function add($parent_id, $data)
    {
        $data['datecreated'] = date('Y-m-d H:i:s');
        if(isset($parent_id) && $parent_id != ''):
            $data['parent_id'] = $parent_id;
        endif;
        $this->db->insert('my_categories', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('New Category Added [CatID: ' . $insert_id . ']');
        }
        return $insert_id;
    }

    public function add_list($data)
    {
        $check = $this->db->get_where(db_prefix() .'legal_procedures_lists', array('cat_id' => $data['cat_id'] ,'rel_id' => $data['rel_id']  ,'rel_type' => $data['rel_type']))->num_rows();
        if($check > 0){
            return false;
        }else{
            $data['datecreated'] = date('Y-m-d H:i:s');
            $this->db->insert('legal_procedures_lists', $data);
            $insert_id = $this->db->insert_id();
            if ($insert_id) {
                log_activity('New Legal procedure list Added [ID: ' . $insert_id . ']');
            }
            return $insert_id;
        }
    }

    public function delete_list($id, $where = [])
    {
        $procedures = legal_procedure_by_list_id($id);
        foreach ($procedures as $contract):
            $this->delete_contract($contract['reference_id']);
        endforeach;
        $this->db->where($where);
        $this->db->where(array('id' => $id));
        $this->db->delete(db_prefix() . 'legal_procedures_lists');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function add_legal_procedure($data)
    {
        $contract_data = array();
        $data['datecreated'] = date('Y-m-d H:i:s');
        if(isset($data['cat_id'])):
            unset($data['cat_id']);
        endif;
        $contract_data['subject'] = get_cat_name_by_id($data['subcat_id']);
        $contract_data['type_id'] = 2;
        $contract_data['datestart'] = date('Y-m-d');
        $contract_data['contract_type'] = 0;
        $contract_data['client'] = get_staff_user_id();
        if(isset($data['content'])):
            $contract_data['content'] = $data['content'];
            unset($data['content']);
        endif;
        $ref_id = $this->contracts_model->add($contract_data);
        if ($ref_id) {
            $data['reference_id'] = $ref_id;
            $this->db->insert(db_prefix() . 'legal_procedures', $data);
            $insert_id = $this->db->insert_id();
            if ($insert_id) {
                log_activity('New legal procedure Added [ID: ' . $insert_id . ']');
            }
            return $insert_id;
        }
        return false;
    }

    public function delete_procedure($id, $where = [])
    {
        $this->db->where($where);
        $this->db->where(array('id' => $id));
        $this->db->delete(db_prefix() . 'legal_procedures');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function get_lists_procedure($id = '', $where = [])
    {
        $this->db->where($where);
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            $this->db->select(db_prefix() . 'legal_procedures_lists.*,cat.name AS cat_name');
            $this->db->join(db_prefix() . 'my_categories AS cat', 'cat.id = ' . db_prefix() . 'legal_procedures_lists.cat_id', 'left');
            return $this->db->get(db_prefix() . 'legal_procedures_lists')->row();
        }
        $this->db->select(db_prefix() . 'legal_procedures_lists.*,cat.name AS cat_name');
        $this->db->join(db_prefix() . 'my_categories AS cat', 'cat.id = ' . db_prefix() . 'legal_procedures_lists.cat_id', 'left');
        return $this->db->get(db_prefix() . 'legal_procedures_lists')->result_array();
    }


    ///////////////////////////////////////////////////////
    /* Contract Model */

    /**
     * Get contract/s
     * @param  mixed  $id         contract id
     * @param  array   $where      perform where
     * @param  boolean $for_editor if for editor is false will replace the field if not will not replace
     * @return mixed
     */
    public function get_contract($id = '', $where = [], $for_editor = false)
    {
        $this->db->select('*,' /*. db_prefix() . 'contracts_types.name as type_name,' */. db_prefix() . 'contracts.id as id, ' . db_prefix() . 'contracts.addedfrom');
        $this->db->where($where);
        //$this->db->join(db_prefix() . 'contracts_types', '' . db_prefix() . 'contracts_types.id = ' . db_prefix() . 'contracts.contract_type', 'left');
        //$this->db->join(db_prefix() . 'clients', '' . db_prefix() . 'clients.userid = ' . db_prefix() . 'contracts.client');
        if (is_numeric($id)) {
            $this->db->where(db_prefix() . 'contracts.id', $id);
            $contract = $this->db->get(db_prefix() . 'contracts')->row();
            if ($contract) {
                $contract->attachments = $this->contracts_model->get_contract_attachments('', $contract->id);
                if ($for_editor == false) {
                    $this->load->library('merge_fields/client_merge_fields');
                    $this->load->library('merge_fields/contract_merge_fields');
                    $this->load->library('merge_fields/other_merge_fields');

                    $merge_fields = [];
                    $merge_fields = array_merge($merge_fields, $this->contracts_model->contract_merge_fields->format($id));
                    $merge_fields = array_merge($merge_fields, $this->contracts_model->client_merge_fields->format($contract->client));
                    $merge_fields = array_merge($merge_fields, $this->contracts_model->other_merge_fields->format());
                    foreach ($merge_fields as $key => $val) {
                        if (stripos($contract->content, $key) !== false) {
                            $contract->content = str_ireplace($key, $val, $contract->content);
                        } else {
                            $contract->content = str_ireplace($key, '', $contract->content);
                        }
                    }
                }
            }

            return $contract;
        }
        $contracts = $this->db->get(db_prefix() . 'contracts')->result_array();
        $i         = 0;
        foreach ($contracts as $contract) {
            $contracts[$i]['attachments'] = $this->contracts_model->get_contract_attachments('', $contract['id']);
            $i++;
        }

        return $contracts;
    }

    public function add_comment($data, $client = false)
    {
        if (is_staff_logged_in()) {
            $client = false;
        }

        if (isset($data['action'])) {
            unset($data['action']);
        }

        if (isset($data['service_type_id'])) {
            unset($data['service_type_id']);
        }
        
        if (isset($data['service_id'])) {
            unset($data['service_id']);
        }

        $data['dateadded'] = date('Y-m-d H:i:s');

        if ($client == false) {
            $data['staffid'] = get_staff_user_id();
        }
        
        $data['content'] = nl2br($data['content']);
        $this->db->insert(db_prefix() . 'contract_comments', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            $contract = $this->get_contract($data['contract_id']);
            
            if (($contract->not_visible_to_client == '1' || $contract->trash == '1') && $client == false) {
                return true;
            }

            if ($client == true) {

                // Get creator
                $this->db->select('staffid, email, phonenumber');
                $this->db->where('staffid', $contract->addedfrom);
                $staff_contract = $this->db->get(db_prefix() . 'staff')->result_array();
                $notifiedUsers = [];
                
                foreach ($staff_contract as $member) {
                    $notified = add_notification([
                        'description'     => 'not_contract_comment_from_client',
                        'touserid'        => $member['staffid'],
                        'fromcompany'     => 1,
                        'fromuserid'      => null,
                        'link'            => 'legalservices/legal_procedures/procedure_text/' . $data['contract_id']. '/' .$data['service_type_id'] .'/'. $data['service_id'],
                        'additional_data' => serialize([
                            $contract->subject,
                        ]),
                    ]);

                    if ($notified) {
                        array_push($notifiedUsers, $member['staffid']);
                    }

                    $template     = mail_template('contract_comment_to_staff', $contract, $member);
                    $merge_fields = $template->get_merge_fields();
                    $template->send();

                    // Send email/sms to admin that client commented
                    $this->app_sms->trigger(SMS_TRIGGER_CONTRACT_NEW_COMMENT_TO_STAFF, $member['phonenumber'], $merge_fields);
                }
                pusher_trigger_notification($notifiedUsers);
            } else {
                $contacts = $this->clients_model->get_contacts($contract->client, ['active' => 1, 'contract_emails' => 1]);

                foreach ($contacts as $contact) {
                    $template     = mail_template('contract_comment_to_customer', $contract, $contact);
                    $merge_fields = $template->get_merge_fields();
                    $template->send();

                    $this->app_sms->trigger(SMS_TRIGGER_CONTRACT_NEW_COMMENT_TO_CUSTOMER, $contact['phonenumber'], $merge_fields);
                }
            }

            return true;
        }

        return false;
    }

    /**
     * @param  integer ID
     * @return boolean
     * Delete contract, also attachment will be removed if any found
     */
    public function delete_contract($id)
    {
        hooks()->do_action('before_contract_deleted', $id);
        //$this->clear_signature($id);
        //$contract = $this->get_contract($id);
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'contracts');
        if ($this->db->affected_rows() > 0) {
            $this->db->where('contract_id', $id);
            $this->db->delete(db_prefix() . 'contract_comments');

            // Delete the custom field values
            $this->db->where('relid', $id);
            $this->db->where('fieldto', 'contracts');
            $this->db->delete(db_prefix() . 'customfieldsvalues');

            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'contract');
            $attachments = $this->db->get(db_prefix() . 'files')->result_array();
            foreach ($attachments as $attachment) {
                $this->contracts_model->delete_contract_attachment($attachment['id']);
            }

            $this->db->where('rel_id', $id);
            $this->db->where('rel_type', 'contract');
            $this->db->delete(db_prefix() . 'notes');


            $this->db->where('contractid', $id);
            $this->db->delete(db_prefix() . 'contract_renewals');
            // Get related tasks
            $this->db->where('rel_type', 'contract');
            $this->db->where('rel_id', $id);
            $tasks = $this->db->get(db_prefix() . 'tasks')->result_array();
            foreach ($tasks as $task) {
                $this->tasks_model->delete_task($task['id']);
            }

            delete_tracked_emails($id, 'contract');

            $proc_id = legal_procedure_by_ref_id($id)->id;

            $this->delete_procedure($proc_id, ['reference_id'=>$id]);

            log_activity('Contract Deleted [' . $id . ']');


            return true;
        }

        return false;
    }

}