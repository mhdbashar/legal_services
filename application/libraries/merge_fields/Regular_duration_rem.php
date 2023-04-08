<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Regular_duration_rem extends App_merge_fields
{
    public function build()
    {
        return [

            [
                'name'      => _l('regular_duration_name'),
                'key'       => '{regular_duration_name}',
                'available' => [
                ],
                'templates' => [
                    'regular-duration-deadline-notification',
                ],
            ],
            [
                'name'      => _l('duration_start_date'),
                'key'       => '{regular_duration_start_date}',
                'available' => [
                ],
                'templates' => [
                    'regular-duration-deadline-notification',
                ],
            ],
            [
                'name'      => _l('duration_end_date'),
                'key'       => '{regular_duration_end_date}',
                'available' => [
                ],
                'templates' => [
                    'regular-duration-deadline-notification',
                ],
            ],
            [
                'name'      => _l('case_name'),
                'key'       => '{case_name}',
                'available' => [
                ],
                'templates' => [
                    'regular-duration-deadline-notification',
                ],
            ],
            [
                'name'      => _l('regular_duration_notification'),
                'key'       => '{regular_duration_notification}',
                'available' => [
                ],
                'templates' => [
                    'regular-duration-deadline-notification',
                ],
            ],
            [
                'name'      => _l('regular_duration_description'),
                'key'       => '{regular_duration_description}',
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
    public function format($case_id,$reg_id)
    {
        $fields = [];

        $this->ci->db->where('case_id', $case_id);
        $this->ci->db->where('	reg_id', $reg_id);
        $duration = $this->ci->db->get(db_prefix() . 'cases_regular_durations')->row();

        if (!$duration) {
            return $fields;
        }

                $fields['{regular_duration_name}'] = get_dur_name_by_id($reg_id);
        $fields['{duration_start_date}'] = _d($duration->start_date);
        $fields['{duration_end_date}'] = _d($duration->end_date);
        $fields['{case_name}'] = get_case_by_id($case_id);


                return hooks()->apply_filters('regular_duration_rem', $fields);
         }
    }
