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
                'name'      => _l('description'),
                'key'       => '{description}',
                'available' => [
                    'termination',
                ],
            ]
        ];
    }

    /**
     * Merge field for staff members
     * @param  mixed $staff_id staff id
     * @param  string $password password is used only when sending welcome email, 1 time
     * @return array
     */
    public function format($id)
    {
        $fields = [];

        $this->ci->db->where('id', $id);
        $termination = $this->ci->db->get(db_prefix().'hr_terminations')->row();

        $fields['{termination_date}']   = '';
        // $fields['{staff_lastname}']    = '';
        $fields['{termination_type}']       = '';
        $fields['{description}'] = '';

        if (!$termination) {
            return $termination;
        }

        $fields['{termination_date}']   = $termination->termination_date;
        $fields['{termination_type}']       = $termination->termination_type;
        $fields['{description}'] = $termination->description;


        return hooks()->apply_filters('termination_merge_fields', $fields, [
            'id'    => $id,
            'termination' => $termination,
        ]);
    }
}
