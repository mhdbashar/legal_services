<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Auth_model extends CI_Model

{



    public function __construct() {

        parent::__construct();

          $this->load->model('user_autologin');

    }


public function CheckPhoneNumber($phonenumber='',$otp_number)
{
    $this->db->select('count(*) as total,id');
        $this->db->where('phonenumber', $phonenumber);
       $q = $this->db->get('tblcontacts');
       $data = $q->row();
          
       if($data->total==0){
        return 0;
       }else{
    
        $this->db->select('count(*) as total');
        $this->db->where('phonenumber', $phonenumber);
        $q = $this->db->get('tbl_otp');
        $phone = $q->row();
                if($phone->total==0){
                    $insertdata = array('phonenumber' =>$phonenumber ,
                                        'otp'=>$otp_number,
                                        'fcontact_id'=>$data->id);
                    $this->db->insert('tbl_otp',$insertdata);
                    return $data->id;
                }else{
                    $insertdata = array('phonenumber' =>$phonenumber ,
                                        'otp'=>$otp_number,
                                         'fcontact_id'=>$data->id );
                    $this->db->update('tbl_otp',$insertdata);
                return $data->id;
    
                }
     
       }
       
       
       
}

public function Userdetail($id='')
{
    
     $this->db->select('*');
        $this->db->where('id', $id);
       $q = $this->db->get('tblcontacts');
       $data = $q->result();
       return $data;
}

public function CheckOTP($phonenumber,$otp_number)
{
   $this->db->select('count(*) as total,fcontact_id');
        $this->db->where('phonenumber', $phonenumber);
        $this->db->where('otp',$otp_number);
       $q = $this->db->get('tbl_otp');
       $data = $q->row();
          
       if($data->total==0){
        return 0;
       }else{
    
        return $data->fcontact_id;
     
       }
}
  public function setToken($id,$tokenid,$type,$tokenkey)
{

$this->db->select('count(*) as total');
        $this->db->where('rel_id', $id);
       $q = $this->db->get('tbltoken');
       $data = $q->row();
         


    if($data->total==0){
          $arrayName =array('rel_id' =>$id ,
                                    'rel_type'=>$type,
                                     'token_key'=>$tokenkey,
                                    'token_id'=>$tokenid
                                    );
        $this->db->insert('tbltoken',$arrayName);
        return $tokenid;
    }else{
  $arrayName =array(       'rel_type'=>$type,
                                     'token_key'=>$tokenkey,
                                    'token_id'=>$tokenid
                                    );
  $this->db->where('rel_id',$id);
    $this->db->update('tbltoken',$arrayName);  
    return $tokenid;
    }
    return false;
    
}
     public function login($email, $password, $remember, $staff)

    {

        if ((!empty($email)) and (!empty($password))) {

            $table = db_prefix() . 'contacts';

            $_id   = 'id';

            if ($staff == true) {

                $table = db_prefix() . 'staff';

                $_id   = 'staffid';

            }

            $this->db->where('email', $email);

            $user = $this->db->get($table)->row();

            if ($user) {

                // Email is okey lets check the password now

                if (!app_hasher()->CheckPassword($password, $user->password)) {

                    hooks()->do_action('failed_login_attempt', [

                        'user'            => $user,

                        'is_staff_member' => $staff,

                    ]);



                    log_activity('Failed Login Attempt FROM API  [Email: ' . $email . ', Is Staff Member: ' . ($staff == true ? 'Yes' : 'No') . ', IP: ' . $this->input->ip_address() . ']');

                    $reason = 'invalid Password';

                    // Password failed, return

                    return $reason;

                }

            } else {



                hooks()->do_action('non_existent_user_login_attempt', [

                        'email'           => $email,

                        'is_staff_member' => $staff,

                ]);



                log_activity('Non Existing User Tried to Login FROM API [Email: ' . $email . ', Is Staff Member: ' . ($staff == true ? 'Yes' : 'No') . ', IP: ' . $this->input->ip_address() . ']');

                $reason = 'User Does Not Exist';



                return $reason;

            }



            if ($user->active == 0) {

                hooks()->do_action('inactive_user_login_attempt', [

                        'user'            => $user,

                        'is_staff_member' => $staff,

                ]);

                log_activity('Inactive User Tried to Login FROM API [Email: ' . $email . ', Is Staff Member: ' . ($staff == true ? 'Yes' : 'No') . ', IP: ' . $this->input->ip_address() . ']');



                $reason = 'USER Inactive';



                return $reason;

            }



            $twoFactorAuth = false;

            if ($staff == true) {

                $twoFactorAuth = $user->two_factor_auth_enabled == 0 ? false : true;



                if (!$twoFactorAuth) {

                    hooks()->do_action('before_staff_login', [

                        'email'  => $email,

                        'userid' => $user->$_id,

                    ]);



                    $user_data = [

                       'client_user_id'   => $user,

                        'staff_logged_in' => true,

                        'status'           => 1,

                    ];

                } else {

                    $user_data = [];

                    if ($remember) {

                        $user_data['tfa_remember'] = true;

                    }

                }

            } else {

                hooks()->do_action('before_client_login', [

                    'email'           => $email,

                    'userid'          => $user->userid,

                    'contact_user_id' => $user->$_id,

                ]);



                $user_data = [

                    'client_user_id'   => $user,

                    'status'           => 1,

                    'contact_user_id'  => $user->$_id,

                    'client_logged_in' => true,

                ];

            }



           // $this->session->set_userdata($user_data);

            return $user_data;



            if (!$twoFactorAuth) {

                if ($remember) {

                    $this->create_autologin($user->$_id, $staff);

                }



                $this->update_login_info($user->$_id, $staff);

            } else {

                return ['two_factor_auth' => true, 'user' => $user];

            }



            return true;

        }



        return false;

    }

        /**

     * @param  integer ID

     * @param  boolean Is Client or Staff

     * @return none

     * Update login info on autologin

     */

    private function update_login_info($user_id, $staff)

    {

        $table = db_prefix() . 'contacts';

        $_id   = 'id';

        if ($staff == true) {

            $table = db_prefix() . 'staff';

            $_id   = 'staffid';

        }

        $this->db->set('last_ip', $this->input->ip_address());

        $this->db->set('last_login', date('Y-m-d H:i:s'));

        $this->db->where($_id, $user_id);

        $this->db->update($table);

    }

      public function ticket_detail($id='')
      {
            $this->db->select('*')->from('tbltickets');
            $this->db->where('userid',$id);
           $this->db->order_by('date','desc');
            $this->db->limit(3);
            return $this->db->get()->result();
      }

}

