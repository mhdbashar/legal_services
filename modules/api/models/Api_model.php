<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login($email, $password)
    {
        $this->db->where('email', $email);
        $user = $this->db->get(db_prefix() . 'contacts')->row();
        if ($user) {
            // Email is okey lets check the password now
            if (!app_hasher()->CheckPassword($password, $user->password)) {
                return
                    ['status' => false,
                        'errors' => 'Failed Login Attempt [Email]'
                    ];
            }
            return
                ['status' => true,
                    'user' => $user
                ];
        } else {
            return
                ['status' => false,
                    'errors' => 'Non Existing User Tried to Login [Email]'
                ];
        }

        return
            ['status' => false,
                'errors' => 'model function login '._l('something_went_wrong')
            ];
    }

    public function get_user_visual_map($user_id)
    {
        $this->db->where('user_id', $user_id);
//        return $this->db->get(db_prefix() . 'feedback_question_api')->result_array();
        $wor = ['id' => 1, 'name' => 'Worker1','avatar'=>''];
        $wor2 = ['id' => 2, 'name' => 'Worker2','avatar'=>''];

        $i = ['id' => 1,
            'name'=>'Service1',
             'workers' => [
                 array_to_object($wor),
                 array_to_object($wor2),
             ]
        ];
        $i2 = ['id' => 2,
            'name'=>'Service2',
            'workers' => [
                array_to_object($wor),
                array_to_object($wor2),
            ]
        ];

        return [
            array_to_object($i), array_to_object($i2)
        ];
    }

    public function get_user_notifications($user_id,$filter)
    {
        $this->db->where('touserid', $user_id);
        if($filter == 'read'){
            $this->db->where('isread', 1);
        }elseif($filter == 'unread'){
            $this->db->where('isread', 0);
        }
        return $this->db->get(db_prefix() . 'notifications')->result_array();
    }

    public function notification_read($id)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'notifications', ['isread' => 1]);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }



    public function update_token($user_id, $token)
    {
        $this->db->where('user_id', $user_id);
        $this->db->update(db_prefix() . 'user_api', ['token' => $token, 'expiration_date' => date('Y-m-d H:i:s', strtotime('+30 days'))]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            $data = [];
            $data['user_id'] = $user_id;
            $data['token'] = $token;
            $data['expiration_date'] = date('Y-m-d H:i:s', strtotime('+30 days'));
            $this->db->insert(db_prefix() . 'user_api', $data);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    public function get_user($token)
    {
        $this->db->where('token', $token);
        $this->db->join(db_prefix() . 'contacts', db_prefix() . 'contacts.id = ' . db_prefix() . 'user_api.user_id');
        $user = $this->db->get(db_prefix().'user_api')->row();
        if (isset($user)) {
            return $user;
        }
        return false;
    }
    public function check_token($token)
    {
        $this->db->where('token', $token);
        $user = $this->db->get(db_prefix().'user_api')->row();
        if (isset($user)) {
            return true;
        }
        return false;
    }

}
