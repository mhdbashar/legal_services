<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Not used yet

class resignation_staff_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => _l('resignation_date'),
                'key'       => '{resignation_date}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('resignation_reason'),
                'key'       => '{resignation_reason}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('staff_fullname'),
                'key'       => '{staff_fullname}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('staff_email'),
                'key'       => '{staff_email}',
                'available' => [
                    'hr',
                ],
            ]
        ];
    }


    public function format($id)
    {
        $fields = [];

        $this->ci->db->where('id', $id);
        $resignation = $this->ci->db->get(db_prefix().'hr_resignations')->row();

        $fields['{resignation_date}']   = '';
        $fields['{resignation_reason}'] = '';
        $fields['{staff_fullname}']   = '';
        $fields['{staff_email}']       = '';

        if (!$resignation) {
            return $resignation;
        }


        $fields['{resignation_date}']   = $resignation->resignation_date;
        $fields['{resignation_reason}']       = $resignation->resignation_reason;
        $fields['{resignation_description}'] = $resignation->description;
        $this->ci->db->where('staffid', $resignation->staff_id);
        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
        $fields['{staff_fullname}']   = $staff->firstname;
        $fields['{staff_email}']       = $staff->email;


        return hooks()->apply_filters('resignation_merge_fields', $fields, [
            'id'    => $id,
            'resignation' => $resignation,
        ]);
    }
}
