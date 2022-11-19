<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Not used yet

class Award_staff_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => _l('date'),
                'key'       => '{date}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('award_type'),
                'key'       => '{award_type}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('gift'),
                'key'       => '{gift}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('cash'),
                'key'       => '{cash}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('award_description'),
                'key'       => '{award_description}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('award_information'),
                'key'       => '{award_information}',
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
        $award = $this->ci->db->get(db_prefix().'hr_awards')->row();



        $fields['{date}']   = '';
        $fields['{award_type}']       = '';
        $fields['{gift}']       = '';
        $fields['{cash}']       = '';
        $fields['{award_information}']       = '';
        $fields['{award_description}'] = '';
        $fields['{staff_fullname}']   = '';
        $fields['{staff_email}']       = '';

        if (!$award) {
            return $award;
        }


        $fields['{date}']   = $award->date;
        $fields['{award_type}']       = $award->award_type;
        $fields['{award_description}'] = $award->description;
        $fields['{gift}'] = $award->gift;
        $fields['{award_information}'] = $award->award_information;
        $fields['{cash}'] = $award->cash;
        $this->ci->db->where('staffid', $award->staff_id);
        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
        $fields['{staff_fullname}']   = $staff->firstname;
        $fields['{staff_email}']       = $staff->email;


        return hooks()->apply_filters('award_merge_fields', $fields, [
            'id'    => $id,
            'award' => $award,
        ]);
    }
}
