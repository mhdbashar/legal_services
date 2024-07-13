<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Not used yet

class Follow_leave_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => _l('start_time'),
                'key'       => '{start_time}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('type_of_leave'),
                'key'       => '{type_of_leave}',
                'available' => [
                    'hr',
                ],
            ],
          
            [
                'name'      => _l('followers_id'),
                'key'       => '{followers_id}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('subject'),
                'key'       => '{subject}',
                'available' => [
                    'hr',
                ],
            ],
//            [
//                'name'      => _l('staff_fullname'),
//                'key'       => '{staff_fullname}',
//                'available' => [
//                    'hr',
//                ],
//            ],
//            [
//                'name'      => _l('staff_email'),
//                'key'       => '{staff_email}',
//                'available' => [
//                    'hr',
//                ],
//            ]
        ];
    }


    public function format($id)
    {
        $fields = [];

        $this->ci->db->where('id', $id);
        $follow = $this->ci->db->get(db_prefix().'timesheets_requisition_leave')->row();

        $fields['{start_time}']   = '';
        $fields['{type_of_leave}']       = '';
        $fields['{staff_id}']   = '';
        $fields['{leave_to}']       = '';
        $fields['{follower_id}'] = '';
        $fields['{subject}'] = '';

        if (!$follow) {
            return $follow;
        }


        $fields['{start_time}']   = $follow->start_time;
        $fields['{type_of_leave}']       = $follow->type_of_leave;
        $fields['{follower_id}'] = $follow->follower_id;
//        $fields['{warning_by}']   = $warning->warning_by;
//        $fields['{warning_to}']       = $warning->warning_to;


        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
        if(is_object($staff))
            $fields['{{leave_by}'] = $staff->firstname;

        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
        if(is_object($staff))
            $fields['{{leave_to}'] = $staff->firstname;


        $fields['{subject}'] = $follow->subject;
//        $this->ci->db->where('staffid', $warning->staff_id);
//        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
//        $fields['{staff_fullname}']   = $staff->firstname;
//        $fields['{staff_email}']       = $staff->email;


        return hooks()->apply_filters('follow_leave_merge_fields', $fields, [
            'id'    => $id,
            'follow' => $follow,
        ]);
    }
}
