<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Procuration_rem extends App_merge_fields
{
    public function build()
    {
        return [

            [
                'name'      => _l('Procuration_name'),
                'key'       => '{Procuration_name}',
                'available' => [
                ],
                'templates' => [
                    'Procuration-deadline-notification',
                ],
            ],
            [
                'name'      => _l('Procuration_start_date'),
                'key'       => '{Procuration_start_date}',
                'available' => [
                ],
                'templates' => [
                    'Procuration-deadline-notification',
                ],
            ],
            [
                'name'      => _l('Procuration_end_date'),
                'key'       => '{Procuration_end_date}',
                'available' => [
                ],
                'templates' => [
                    'Procuration-deadline-notification',
                ],
            ],
            [
                'name'      => _l('case_name'),
                'key'       => '{case_name}',
                'available' => [
                ],
                'templates' => [
                    'Procuration-deadline-notification',
                ],
            ],
            [
                'name'      => _l('Procuration_notification'),
                'key'       => '{Procuration_notification}',
                'available' => [
                ],
                'templates' => [
                    'Procuration-deadline-notification',
                ],
            ],
            [
                'name'      => _l('Procuration_description'),
                'key'       => '{Procuration_description}',
                'available' => [
                ],
                'templates' => [
                    'Procuration-deadline-notification',
                ],
            ],



        ];
    }

    /**
     * Merge fields for regular duration
     * @param  mixed  $case_id         case_id
     * @return array
         */
    public function format($case_id,$proc_id)
    {
        $fields = [];


        $this->ci->db->where('id', $proc_id);
        $procuration_details = $this->ci->db->get(db_prefix() . 'procurations')->row();

        if (!$procuration_details) {
            return $fields;
        }

                $fields['{Procuration_name}'] = get_procuration_name_by_id($proc_id);
        $fields['{Procuration_start_date}'] = _d($procuration_details->start_date);
        $fields['{Procuration_end_date}'] = _d($procuration_details->end_date);
        $fields['{case_name}'] = get_case_name_by_id($case_id);
        $fields['{Procuration_description}'] = _l('Procuration_description');
        $fields['{Procuration_notification}'] = _l('Procuration_notification');


                return hooks()->apply_filters('procuration_rem', $fields);
         }
    }
