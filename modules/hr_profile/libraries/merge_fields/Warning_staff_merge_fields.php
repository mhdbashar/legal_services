<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Not used yet

class Warning_staff_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => _l('warning_date'),
                'key'       => '{warning_date}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('warning_type'),
                'key'       => '{warning_type}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('warning_by'),
                'key'       => '{warning_by}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('warning_to'),
                'key'       => '{warning_to}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('warning_description'),
                'key'       => '{warning_description}',
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
        $warning = $this->ci->db->get(db_prefix().'hr_warnings')->row();

        $fields['{warning_date}']   = '';
        $fields['{warning_type}']       = '';
        $fields['{warning_by}']   = '';
        $fields['{warning_to}']       = '';
        $fields['{warning_description}'] = '';
        $fields['{subject}'] = '';
        $fields['{staff_fullname}']   = '';
        $fields['{staff_email}']       = '';

        if (!$warning) {
            return $warning;
        }


        $fields['{warning_date}']   = $warning->warning_date;
        $fields['{warning_type}']       = $warning->warning_type;
        $fields['{warning_description}'] = $warning->description;
//        $fields['{warning_by}']   = $warning->warning_by;
//        $fields['{warning_to}']       = $warning->warning_to;


        $this->ci->db->where('staffid', $warning->warning_by);
        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
        if(is_object($staff))
            $fields['{{warning_by}'] = $staff->firstname;

        $this->ci->db->where('staffid', $warning->warning_to);
        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
        if(is_object($staff))
            $fields['{{warning_to}'] = $staff->firstname;


        $fields['{subject}'] = $warning->subject;
//        $this->ci->db->where('staffid', $warning->staff_id);
//        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
//        $fields['{staff_fullname}']   = $staff->firstname;
//        $fields['{staff_email}']       = $staff->email;


        return hooks()->apply_filters('warning_merge_fields', $fields, [
            'id'    => $id,
            'warning' => $warning,
        ]);
    }
}
