<?php

defined('BASEPATH') or exit('No direct script access allowed');

class regular_duration_rem extends App_merge_fields
{
    public function build()
    {
        return [

            [
                'name'      => _l('regular_duration'),
                'key'       => '{regular_duration}',
                'available' => [
                ],
                'templates' => [
                    'regular-duration-deadline-notification',
                ],
            ],

        ];
    }

    /**
     * Merge fields for regular duration
     * @param  mixed  $case_id         case_id
     * @return array
         */
    public function format($case_id)
    {
        $fields = [];

        $this->ci->db->where('id', $case_id);
        $case = $this->ci->db->get(db_prefix() . 'my_cases')->row();

        if (!$case) {
            return $fields;
        }

                $fields['{regular_duration}'] = get_dur_name_by_id($case->duration_id);


                return hooks()->apply_filters('regular_duration_rem', $fields);
         }
    }
