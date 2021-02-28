<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Not used yet

class Travel_staff_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => _l('start_date'),
                'key'       => '{start_date}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('end_date'),
                'key'       => '{end_date}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('expected_budget'),
                'key'       => '{expected_budget}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('actual_budget'),
                'key'       => '{actual_budget}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('purpose'),
                'key'       => '{purpose}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('place'),
                'key'       => '{place}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('travel_mode_type'),
                'key'       => '{travel_mode_type}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('travel_description'),
                'key'       => '{travel_description}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('arrangement_type'),
                'key'       => '{arrangement_type}',
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
        $travel = $this->ci->db->get(db_prefix().'hr_travels')->row();

        $fields['{start_date}']       = '';
        $fields['{end_date}']       = '';
        $fields['{expected_budget}']       = '';
        $fields['{actual_budget}']       = '';
        $fields['{purpose}']       = '';
        $fields['{place}']       = '';
        $fields['{travel_mode_type}']       = '';
        $fields['{travel_description}']       = '';
        $fields['{arrangement_type}']       = '';
        $fields['{staff_fullname}']   = '';
        $fields['{staff_email}']       = '';

        if (!$travel) {
            return $travel;
        }


        $fields['{start_date}']       = $travel->start_date;
        $fields['{end_date}']       = $travel->end_date;
        $fields['{expected_budget}']       = $travel->expected_budget;
        $fields['{actual_budget}']       = $travel->actual_budget;
        $fields['{purpose}']       = $travel->purpose;
        $fields['{place}']       = $travel->place;
        $fields['{travel_mode_type}']       = $travel->travel_mode_type;
        $fields['{arrangement_type}']       = $travel->arrangement_type;
        $fields['{travel_description}'] = $travel->description;
        $this->ci->db->where('staffid', $travel->staff_id);
        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
        $fields['{staff_fullname}']   = $staff->firstname;
        $fields['{staff_email}']       = $staff->email;


        return hooks()->apply_filters('travel_merge_fields', $fields, [
            'id'    => $id,
            'travel' => $travel,
        ]);
    }
}
