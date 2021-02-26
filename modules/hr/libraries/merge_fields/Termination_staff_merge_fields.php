<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Not used yet

class Termination_staff_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => _l('termination_date'),
                'key'       => '{termination_date}',
                'available' => [
                    'termination',
                ],
            ],
            [
                'name'      => _l('termination_type'),
                'key'       => '{termination_type}',
                'available' => [
                    'termination',
                ],
            ],
            [
                'name'      => _l('staff_fullname'),
                'key'       => '{staff_fullname}',
                'available' => [
                    'termination',
                ],
            ],
            [
                'name'      => _l('staff_email'),
                'key'       => '{staff_email}',
                'available' => [
                    'termination',
                ],
            ]
        ];
    }


    public function format($id)
    {
        $fields = [];

        $this->ci->db->where('id', $id);
        $termination = $this->ci->db->get(db_prefix().'hr_terminations')->row();

        $fields['{termination_date}']   = '';
        $fields['{termination_type}']       = '';
        $fields['{description}'] = '';
        $fields['{staff_fullname}']   = '';
        $fields['{staff_email}']       = '';

        if (!$termination) {
            return $termination;
        }


        $fields['{termination_date}']   = $termination->termination_date;
        $fields['{termination_type}']       = $termination->termination_type;
        $fields['{description}'] = $termination->description;
        $this->ci->db->where('staffid', $termination->staff_id);
        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
        $fields['{staff_fullname}']   = $staff->firstname;
        $fields['{staff_email}']       = $staff->email;


        return hooks()->apply_filters('termination_merge_fields', $fields, [
            'id'    => $id,
            'termination' => $termination,
        ]);
    }
}
