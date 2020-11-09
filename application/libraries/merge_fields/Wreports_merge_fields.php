<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Wreports_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name'      => _l('clients_notes_table_description_heading'),
                'key'       => '{report}',
                'available' => [
                    'written_report',
                ],
                'templates' => [
                    'send_written_report_to_customer',
                ],
            ],
            [
                'name'      => _l('date_created'),
                'key'       => '{created_at}',
                'available' => [
                    'written_report',
                ],
                'templates' => [
                    'send_written_report_to_customer',
                ],
            ],
            [
                'name'      => _l('updated_at'),
                'key'       => '{updated_at}',
                'available' => [
                    'written_report',
                ],
                'templates' => [
                    'send_written_report_to_customer',
                ],
            ],
        ];
    }

    /**
     * Merge field for Writtem repots
     * @param  mixed $report_id report_id id
     * @return array
     */
    public function format($report_id)
    {
        $fields = [];
        $this->ci->db->where('id', $report_id);
        $report = $this->ci->db->get(db_prefix().'written_reports')->row();
        $fields['{report}']     = $report->report;
        $fields['{created_at}'] = _dt($report->created_at);
        $fields['{updated_at}'] = _dt($report->updated_at);

        if (!$report) {
            return $fields;
        }
        return hooks()->apply_filters('wreports_merge_fields', $fields, [
            'id'     => $report_id,
            'report' => $report,
        ]);
    }
}
