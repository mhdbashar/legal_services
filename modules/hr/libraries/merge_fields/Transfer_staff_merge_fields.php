<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Not used yet

class Transfer_staff_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => _l('transfer_date'),
                'key'       => '{transfer_date}',
                'available' => [
                    'transfer',
                ],
            ],
            [
                'name'      => _l('transfer_description'),
                'key'       => '{transfer_description}',
                'available' => [
                    'transfer',
                ],
            ],
            [
                'name'      => _l('to_department'),
                'key'       => '{to_department}',
                'available' => [
                    'transfer',
                ],
            ],
            [
                'name'      => _l('to_sub_department'),
                'key'       => '{to_sub_department}',
                'available' => [
                    'transfer',
                ],
            ],
            [
                'name'      => _l('staff_fullname'),
                'key'       => '{staff_fullname}',
                'available' => [
                    'transfer',
                ],
            ],
            [
                'name'      => _l('staff_email'),
                'key'       => '{staff_email}',
                'available' => [
                    'transfer',
                ],
            ]
        ];
    }


    public function format($id)
    {
        $fields = [];

        $this->ci->db->where('id', $id);
        $transfer = $this->ci->db->get(db_prefix().'hr_transfers')->row();

        $fields['{transfer_date}']   = '';
        $fields['{to_department}']       = '';
        $fields['{to_sub_department}']       = '';
        $fields['{transfer_description}'] = '';
        $fields['{staff_fullname}']   = '';
        $fields['{staff_email}']       = '';

        if (!$transfer) {
            return $transfer;
        }


        $fields['{transfer_date}']   = $transfer->transfer_date;

        $this->ci->db->where('departmentid', $transfer->to_department);
        $to_department = $this->ci->db->get(db_prefix() . 'departments')->row();
        if(is_object($to_department))
            $fields['{{to_department}'] = $to_department->name;

        $this->ci->db->where('id', $transfer->to_sub_department);
        $to_sub_department = $this->ci->db->get(db_prefix() . 'hr_sub_departments')->row();
        if(is_object($to_sub_department))
            $fields['{{to_sub_department}'] = $to_sub_department->sub_department_name;

        $fields['{transfer_description}'] = $transfer->transfer_description;
        $this->ci->db->where('staffid', $transfer->staff_id);
        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
        $fields['{staff_fullname}']   = $staff->firstname;
        $fields['{staff_email}']       = $staff->email;


        return hooks()->apply_filters('transfer_merge_fields', $fields, [
            'id'    => $id,
            'transfer' => $transfer,
        ]);
    }
}
