<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Contact_model extends CI_Model

{

    public function __construct() {

        parent::__construct();

     }


public function update_contact($data, $id, $client_request = false)

    {

       
        $affectedRows = 0;

        $contact      = $this->get_contact($id);

        if (empty($data['password'])) {

            unset($data['password']);

        } else {

            $data['password']             = app_hash_password($data['password']);

            $data['last_password_change'] = date('Y-m-d H:i:s');

        }



        $send_set_password_email = isset($data['send_set_password_email']) ? true : false;

        $set_password_email_sent = false;



        $permissions        = isset($data['permissions']) ? $data['permissions'] : [];

        $data['is_primary'] = isset($data['is_primary']) ? 1 : 0;



        // Contact cant change if is primary or not

        if ($client_request == true) {

            unset($data['is_primary']);

        }



        if (isset($data['custom_fields'])) {

            $custom_fields = $data['custom_fields'];

            if (handle_custom_fields_post($id, $custom_fields)) {

                $affectedRows++;

            }

            unset($data['custom_fields']);

        }



        if ($client_request == false) {

            $data['invoice_emails']     = isset($data['invoice_emails']) ? 1 :0;

            $data['estimate_emails']    = isset($data['estimate_emails']) ? 1 :0;

            $data['credit_note_emails'] = isset($data['credit_note_emails']) ? 1 :0;

            $data['contract_emails']    = isset($data['contract_emails']) ? 1 :0;

            $data['task_emails']        = isset($data['task_emails']) ? 1 :0;

            $data['project_emails']     = isset($data['project_emails']) ? 1 :0;

            $data['ticket_emails']      = isset($data['ticket_emails']) ? 1 :0;

        }



        $data = hooks()->apply_filters('before_update_contact', $data, $id);



        $this->db->where('id', $id);

        $this->db->update(db_prefix() . 'contacts', $data);



        if ($this->db->affected_rows() > 0) {

            $affectedRows++;

            if (isset($data['is_primary']) && $data['is_primary'] == 1) {

                $this->db->where('userid', $contact->userid);

                $this->db->where('id !=', $id);

                $this->db->update(db_prefix() . 'contacts', [

                    'is_primary' => 0,

                ]);

            }

        }



        if ($client_request == false) {

            $customer_permissions = $this->roles_model->get_contact_permissions($id);

            if (sizeof($customer_permissions) > 0) {

                foreach ($customer_permissions as $customer_permission) {

                    if (!in_array($customer_permission['permission_id'], $permissions)) {

                        $this->db->where('userid', $id);

                        $this->db->where('permission_id', $customer_permission['permission_id']);

                        $this->db->delete(db_prefix() . 'contact_permissions');

                        if ($this->db->affected_rows() > 0) {

                            $affectedRows++;

                        }

                    }

                }

                foreach ($permissions as $permission) {

                    $this->db->where('userid', $id);

                    $this->db->where('permission_id', $permission);

                    $_exists = $this->db->get(db_prefix() . 'contact_permissions')->row();

                    if (!$_exists) {

                        $this->db->insert(db_prefix() . 'contact_permissions', [

                            'userid'        => $id,

                            'permission_id' => $permission,

                        ]);

                        if ($this->db->affected_rows() > 0) {

                            $affectedRows++;

                        }

                    }

                }

            } else {

                foreach ($permissions as $permission) {

                    $this->db->insert(db_prefix() . 'contact_permissions', [

                        'userid'        => $id,

                        'permission_id' => $permission,

                    ]);

                    if ($this->db->affected_rows() > 0) {

                        $affectedRows++;

                    }

                }

            }

            if ($send_set_password_email) {

                $set_password_email_sent = $this->authentication_model->set_password_email($data['email'], 0);

            }

        }



        if ($affectedRows > 0) {

            hooks()->do_action('contact_updated', $id, $data);

        }



        if ($affectedRows > 0 && !$set_password_email_sent) {

            log_activity('Contact Updated [ID: ' . $id . ']');



            return true;

        } elseif ($affectedRows > 0 && $set_password_email_sent) {

            return [

                'set_password_email_sent_and_profile_updated' => true,

            ];

        } elseif ($affectedRows == 0 && $set_password_email_sent) {

            return [

                'set_password_email_sent' => true,

            ];

        }



        return false;

    }



    

    public function add_contact($data, $customer_id, $not_manual_request = false)

    {


        $send_set_password_email = isset($data['send_set_password_email']) ? true : false;



        if (isset($data['custom_fields'])) {

            $custom_fields = $data['custom_fields'];

            unset($data['custom_fields']);

        }



        if (isset($data['permissions'])) {

            $permissions = $data['permissions'];

            unset($data['permissions']);

        }



        $data['email_verified_at'] = date('Y-m-d H:i:s');



        $send_welcome_email = true;



        if (isset($data['donotsendwelcomeemail'])) {

            $send_welcome_email = false;

        }



        if (defined('CONTACT_REGISTERING')) {

            $send_welcome_email = true;



            // Do not send welcome email if confirmation for registration is enabled

            if (get_option('customers_register_require_confirmation') == '1') {

                $send_welcome_email = false;

            }



            // If client register set this contact as primary

            $data['is_primary'] = 1;

            if (is_email_verification_enabled() && !empty($data['email'])) {

                // Verification is required on register

                $data['email_verified_at']      = null;

                $data['email_verification_key'] = app_generate_hash();

            }

        }



        if (isset($data['is_primary'])) {

            $data['is_primary'] = 1;

            $this->db->where('userid', $customer_id);

            $this->db->update(db_prefix() . 'contacts', [

                'is_primary' => 0,

            ]);

        } else {

            $data['is_primary'] = 0;

        }



        $password_before_hash = '';

        $data['userid']       = $customer_id;

        if (isset($data['password'])) {

            $password_before_hash = $data['password'];

            $data['password']     = app_hash_password($data['password']);

        }



        $data['datecreated'] = date('Y-m-d H:i:s');



        if (!$not_manual_request) {

            $data['invoice_emails']     = isset($data['invoice_emails']) ? 1 :0;

            $data['estimate_emails']    = isset($data['estimate_emails']) ? 1 :0;

            $data['credit_note_emails'] = isset($data['credit_note_emails']) ? 1 :0;

            $data['contract_emails']    = isset($data['contract_emails']) ? 1 :0;

            $data['task_emails']        = isset($data['task_emails']) ? 1 :0;

            $data['project_emails']     = isset($data['project_emails']) ? 1 :0;

            $data['ticket_emails']      = isset($data['ticket_emails']) ? 1 :0;

        }



        $data['email'] = trim($data['email']);



        $data = hooks()->apply_filters('before_create_contact', $data);



        $this->db->insert(db_prefix() . 'contacts', $data);

        $contact_id = $this->db->insert_id();



        if ($contact_id) {

            if (isset($custom_fields)) {

                handle_custom_fields_post($contact_id, $custom_fields);

            }

            // request from admin area

            if (!isset($permissions) && $not_manual_request == false) {

                $permissions = [];

            } elseif ($not_manual_request == true) {

                $permissions         = [];

                $_permissions        = get_contact_permissions();

                $default_permissions = @unserialize(get_option('default_contact_permissions'));

                if (is_array($default_permissions)) {

                    foreach ($_permissions as $permission) {

                        if (in_array($permission['id'], $default_permissions)) {

                            array_push($permissions, $permission['id']);

                        }

                    }

                }

            }



            if ($not_manual_request == true) {

                // update all email notifications to 0

                $this->db->where('id', $contact_id);

                $this->db->update(db_prefix() . 'contacts', [

                    'invoice_emails'     => 0,

                    'estimate_emails'    => 0,

                    'credit_note_emails' => 0,

                    'contract_emails'    => 0,

                    'task_emails'        => 0,

                    'project_emails'     => 0,

                    'ticket_emails'      => 0,

                ]);

            }

            foreach ($permissions as $permission) {

                $this->db->insert(db_prefix() . 'contact_permissions', [

                    'userid'        => $contact_id,

                    'permission_id' => $permission,

                ]);



                // Auto set email notifications based on permissions

                if ($not_manual_request == true) {

                    if ($permission == 6) {

                        $this->db->where('id', $contact_id);

                        $this->db->update(db_prefix() . 'contacts', ['project_emails' => 1, 'task_emails' => 1]);

                    } elseif ($permission == 3) {

                        $this->db->where('id', $contact_id);

                        $this->db->update(db_prefix() . 'contacts', ['contract_emails' => 1]);

                    } elseif ($permission == 2) {

                        $this->db->where('id', $contact_id);

                        $this->db->update(db_prefix() . 'contacts', ['estimate_emails' => 1]);

                    } elseif ($permission == 1) {

                        $this->db->where('id', $contact_id);

                        $this->db->update(db_prefix() . 'contacts', ['invoice_emails' => 1, 'credit_note_emails' => 1]);

                    } elseif ($permission == 5) {

                        $this->db->where('id', $contact_id);

                        $this->db->update(db_prefix() . 'contacts', ['ticket_emails' => 1]);

                    }

                }

            }



            if ($send_welcome_email == true) {

                send_mail_template('customer_created_welcome_mail', $data['email'], $data['userid'], $contact_id, $password_before_hash);

            }



            if ($send_set_password_email) {

                $this->authentication_model->set_password_email($data['email'], 0);

            }



            if (defined('CONTACT_REGISTERING')) {

                $this->send_verification_email($contact_id);

            } else {

                // User already verified because is added from admin area, try to transfer any tickets

                $this->load->model('tickets_model');

                $this->tickets_model->transfer_email_tickets_to_contact($data['email'], $contact_id);

            }



            log_activity('Contact Created [ID: ' . $contact_id . ']');



            hooks()->do_action('contact_created', $contact_id);



            return $contact_id;

        }



        return false;

    }
}