<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Not used yet

class Complaint_staff_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => _l('complaint_date'),
                'key'       => '{complaint_date}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('complaint_title'),
                'key'       => '{complaint_title}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('complaint_againts'),
                'key'       => '{complaint_againts}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('complaint_from'),
                'key'       => '{complaint_from}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('complaint_description'),
                'key'       => '{complaint_description}',
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
        $complaints = $this->ci->db->get(db_prefix().'hr_complaints')->row();

        $fields['{complaint_date}']   = '';
        $fields['{complaint_title}']   = '';
        $fields['{complaint_againts}']       = '';
        $fields['{complaint_from}']       = '';
        $fields['{complaint_description}'] = '';
        $fields['{staff_fullname}']   = '';
        $fields['{staff_email}']       = '';

        if (!$complaints) {
            return $complaints;
        }


        $fields['{complaint_date}']   = $complaints->complaint_date;
        $fields['{complaint_title}']       = $complaints->complaint_title;
        //$fields['{complaint_againts}']   = $complaints->complaint_againts;
        //$fields['{complaint_from}']       = $complaints->complaint_from;

        $this->ci->db->where('staffid', $complaints->complaint_from);
        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
        if(is_object($staff))
            $fields['{{complaint_from}'] = $staff->firstname;

        $this->ci->db->where('staffid', $complaints->complaint_againts);
        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
        if(is_object($staff))
            $fields['{{complaint_againts}'] = $staff->firstname;


        $fields['{complaint_description}'] = $complaints->description;
        $this->ci->db->where('staffid', $complaints->complaint_from);
        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
        $fields['{staff_fullname}']   = $staff->firstname;
        $fields['{staff_email}']       = $staff->email;


        return hooks()->apply_filters('complaints_merge_fields', $fields, [
            'id'    => $id,
            'complaints' => $complaints,
        ]);
    }
}
