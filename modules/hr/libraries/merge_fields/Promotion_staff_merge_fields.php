<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Not used yet

class Promotion_staff_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => _l('promotion_date'),
                'key'       => '{promotion_date}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('promotion_title'),
                'key'       => '{promotion_title}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('designation'),
                'key'       => '{designation}',
                'available' => [
                    'hr',
                ],
            ],
            [
                'name'      => _l('promotion_description'),
                'key'       => '{promotion_description}',
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
        $promotion = $this->ci->db->get(db_prefix().'hr_promotions')->row();

        $fields['{promotion_date}']   = '';
        $fields['{promotion_type}']       = '';
        $fields['{promotion_description}'] = '';
        $fields['{designation}'] = '';
        $fields['{staff_fullname}']   = '';
        $fields['{staff_email}']       = '';

        if (!$promotion) {
            return $promotion;
        }


        $fields['{promotion_date}']   = $promotion->promotion_date;
        $fields['{promotion_type}']       = $promotion->promotion_type;
        $fields['{promotion_description}'] = $promotion->description;
        $this->ci->db->where('id', $promotion->designation);
        $designation = $this->ci->db->get(db_prefix() . 'hr_designations')->row();
        if(is_object($designation))
            $fields['{{designation}'] = $designation->designation_name;
        $this->ci->db->where('staffid', $promotion->staff_id);
        $staff = $this->ci->db->get(db_prefix() . 'staff')->row();
        $fields['{staff_fullname}']   = $staff->firstname;
        $fields['{staff_email}']       = $staff->email;


        return hooks()->apply_filters('promotion_merge_fields', $fields, [
            'id'    => $id,
            'promotion' => $promotion,
        ]);
    }
}
