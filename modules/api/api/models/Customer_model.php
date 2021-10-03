<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Customer_model extends CI_Model

{

    public function __construct() {

        parent::__construct();

     }


     public function Count_Customer()
     {
     	

            $total_customer=$this->db->select('Count(*)')->from('tblclients')->count_all_results();

            $total_Active_customer=$this->db->select('Count(*)')->from('tblclients')->where('active','1')->count_all_results();
            $total_InActive_customer=$this->db->select('Count(*)')->from('tblclients')->where('active','0')->count_all_results();
            $total_Active_contacts=$this->db->select('Count(*)')->from('tblcontacts')->where('active','1')->count_all_results();
            $total_InActive_contacts=$this->db->select('Count(*)')->from('tblcontacts')->where('active','0')->count_all_results();
            
            $data = array('total_customer' =>$total_customer,
                'total_Active_customer'=>$total_Active_customer,
                'total_InActive_customer'=>$total_InActive_customer,
                'total_Active_contacts'=>$total_Active_contacts,
                'total_InActive_contacts'=>$total_InActive_contacts) ;

        return $data;
     	
     }


  public function get_proposalinvoice($invoiceid)
     {
      # code...
     $this->db->where('rel_id',$invoiceid);
                $this->db->where('rel_type','invoice');
                $this->db->select('*')->from('tblitemable');
                    // $this->db->where('invoiceid',$invoiceid);                    
                    // $this->db->select('*')->from('tblinvoicepaymentrecords');
                
      
       return $this->db->get()->result();

     }
       public function get_Invoice_name($id)
     { 
         $this->db->where('id', $id);
         $q = $this->db->get('tblinvoices');
         $data = $q->row();
         
         $this->db->where('userid',$data->clientid);
         $qq=$this->db->get('tblclients');
         $data1=$qq->row();
         return $data1->company;
     }

     public function Customer_customfield($filters)
        {
   
          $this->db->select('tblcustomfields.id,tblcustomfields.name,tblcustomfieldsvalues.value')        
           ->from('tblcustomfieldsvalues')
         ->join('tblcustomfields', 'tblcustomfieldsvalues.fieldid = tblcustomfields.id');
          $this->db->where('tblcustomfieldsvalues.relid', $filters['staff_id']);
           $this->db->where('tblcustomfields.fieldto', 'customers');
           $this->db->order_by('tblcustomfields.id','asc');
          
           return $this->db->get()->result();

        }

public function Customer_customfield_get($filters)
{
        if($filters['type']=='customers'){
           $this->db->select('tblcustomfields.id,tblcustomfields.name')        
           ->from('tblcustomfields'); 
           $this->db->where('active','1');
           $this->db->where('tblcustomfields.fieldto', $filters['type']);
           $this->db->order_by("id", "asc");
          }
        if($filters['type']=='group'){

          }
        if($filters['type']=='country'){
          $this->db->select('country_id,short_name')        
          ->from('tblcountries');
          }
        if($filters['type']=='currency'){
          $this->db->select('id,name,symbol')        
          ->from('tblcurrencies');
          }
        if($filters['type']=='contact'){
          $this->db->select('id,firstname ,lastname,email')        
          ->from('tblcontacts');
          $this->db->where('userid',$filters['userid']);
          $this->db->where('active','1');
          }
            if($filters['type']=='department'){
          $this->db->select('departmentid,name')        
          ->from('tbldepartments');
          $this->db->order_by('name','asc');
          
          }
          if($filters['type']=='priority'){
          $this->db->select('*')        
          ->from('tbltickets_priorities'); 
          }
          if($filters['type']=='project'){
          $this->db->select('id,name')        
          ->from('tblprojects');
          $this->db->where('clientid',$filters['userid']);
          $this->db->order_by('name','asc');
          }
             if($filters['type']=='staff'){
          $this->db->select('staffid,firstname, lastname')        
          ->from('tblstaff');
          $this->db->where('active','1');
          }
          if($filters['type']=='tags'){
          $this->db->select('id,name')        
          ->from('tbltags');
          }
            if($filters['type']=='reply'){
          $this->db->select('id,name,message')        
          ->from('tbltickets_predefined_replies');
          }
           return $this->db->get()->result();
}
          

        public function getPrimarynamebyId($id)
        {
   
           $this->db->where('userid', $id);
           $this->db->where('is_primary', '1');
           $q = $this->db->get('tblcontacts'); 
           $data = $q->row();
           $name = $data->firstname.' '.$data->lastname;
           return $name;

        }
            public function getPrimaryemailbyId($id)
        {
   
           $this->db->where('userid', $id);
           $this->db->where('is_primary', '1');
           $q = $this->db->get('tblcontacts'); 
           $data = $q->row();
           $email = $data->email;
           return $email;

        }

        public function Customer_List($filters)
        {
            $this->db->select('*')->from('tblclients');
            $this->db->where('active','1');
            $this->db->limit($filters['limit'], ($filters['start']-1));
            return $this->db->get()->result();
         # code...
        }
     
        public function Total_Customer()
        {   
            $this->db->select('Count(*)')
                         ->from('tblclients');
            $this->db->where('active','1');
            return $this->db->count_all_results();
         # code...
       }
       public function Insert_CustomerDetail($userid='',$inputtype,$insert_data)
       {
        if($inputtype=='profile'){
         if($userid==''){
            $this->db->insert('tblclients', $insert_data);
            $insert_id = $this->db->insert_id();

             return  $insert_id;
         }else{
            $this->db->where('userid', $userid); 
            $this->db->update('tblclients', $insert_data);
            return  $userid;
         }
          
        
        }if($inputtype=='fielddata'){
         
         if($userid==''){
          $this->db->insert_batch('tblcustomfieldsvalues',$customer_data);
        return 1;}else{
           // $this->db->where('relid', $userid); 
          $this->db->update_batch('tblcustomfieldsvalues',$customer_data,'relid');
        return 1;
        }
        }if($inputtype=='address'){
           $this->db->where('userid', $userid); 
           $this->db->update('tblclients', $insert_data);
          return  $userid;
          
        }
        return 0;
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

                $this->transfer_email_tickets_to_contact($data['email'], $contact_id);

            }



            log_activity('Contact Created [ID: ' . $contact_id . ']');



            hooks()->do_action('contact_created', $contact_id);



            return 1;

        }



        return 0;

    }

      public function transfer_email_tickets_to_contact($email, $contact_id)
    {
        // Some users don't want to fill the email
        if (empty($email)) {
            return false;
        }

        $customer_id = get_user_id_by_contact_id($contact_id);

        $this->db->where('userid', 0)
                ->where('contactid', 0)
                ->where('admin IS NULL')
                ->where('email', $email);

        $this->db->update(db_prefix() . 'tickets', [
                    'email'     => null,
                    'name'      => null,
                    'userid'    => $customer_id,
                    'contactid' => $contact_id,
                ]);

        $this->db->where('userid', 0)
                ->where('contactid', 0)
                ->where('admin IS NULL')
                ->where('email', $email);

        $this->db->update(db_prefix() . 'ticket_replies', [
                    'email'     => null,
                    'name'      => null,
                    'userid'    => $customer_id,
                    'contactid' => $contact_id,
                ]);

        return true;
    }

    public function getCheckemail($email='')
    {

      if($email){
         $this->db->where('email',$email);          
       $data= $this->db->select('Count(*)')->from('tblcontacts')->count_all_results();
if($data>=1){
return 1;
}else{
return 0;
}
  
      }else{
        return 0;
      }
    }
}