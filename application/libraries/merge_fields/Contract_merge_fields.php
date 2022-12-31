<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Contract_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
            [
                'name' => _l('contract_id'),
                'key' => '{contract_id}',
                'available' => [
                    'contract',
                ],
            ],
            [
                'name' => _l('contract_subject'),
                'key' => '{contract_subject}',
                'available' => [
                    'contract',
                ],
            ],
            [
                'name' => _l('contract_description'),
                'key' => '{contract_description}',
                'available' => [
                    'contract',
                ],
            ],
            [
                'name' => _l('contract_date_start'),
                'key' => '{contract_datestart}',
                'available' => [
                    'contract',
                ],
            ],
            [
                'name' => _l('contract_date_end'),
                'key' => '{contract_dateend}',
                'available' => [
                    'contract',
                ],
            ],
            [
                'name' => _l('contract_value'),
                'key' => '{contract_contract_value}',
                'available' => [
                    'contract',
                ],
            ],
            [
                'name' => _l('contract_link'),
                'key' => '{contract_link}',
                'available' => [
                    'contract',
                ],
            ],
            [
                'name' => 'Contract Type',
                'key' => '{contract_type}',
                'available' => [
                    'contract',
                ],
            ],
            [
                'name' => 'Project name',
                'key' => '{service_name}',
                'available' => [
                    'contract',
                ],
            ],
            [
                'name' => _l('staff_document_number'),
                'key' => '{document_number}',
                'available' => [
                    'contract',
                ],
            ],
        ];
    }

    /**
     * Merge field for contracts
     * @param mixed $contract_id contract id
     * @return array
     */
    public function format($contract_id)
    {
        $fields = [];
        $this->ci->db->select(db_prefix() . 'contracts.id as id, subject, description, datestart, dateend, contract_value, hash, project_id, rel_sid, rel_stype, staff, ' . db_prefix() . 'contracts_types.name as type_name');
        $this->ci->db->where('contracts.id', $contract_id);
        $this->ci->db->join(db_prefix() . 'contracts_types', '' . db_prefix() . 'contracts_types.id = ' . db_prefix() . 'contracts.contract_type', 'left');
        $contract = $this->ci->db->get(db_prefix() . 'contracts')->row();

        if (!$contract) {
            return $fields;
        }


        $currency = get_base_currency();

        $CI = &get_instance();
        $CI->load->library('app_modules');
        if($CI->app_modules->is_active('hr')) {
            $this->ci->db->where('staff_id', $contract->staff);
            $staff = $this->ci->db->get(db_prefix() . 'hr_immigration')->row();
            if ($staff) {
                $fields['{document_number}'] = $staff->document_number;
            }
        }else{
            $fields['{document_number}'] = '';
        }

        $fields['{contract_id}'] = $contract->id;
        $fields['{contract_subject}'] = $contract->subject;
        $fields['{contract_type}'] = $contract->type_name;
        $fields['{contract_description}'] = nl2br($contract->description);
        $fields['{contract_datestart}'] = _d($contract->datestart);
        $fields['{contract_dateend}'] = _d($contract->dateend);
        $fields['{contract_contract_value}'] = app_format_money($contract->contract_value, $currency);

        $fields['{contract_link}'] = site_url('contract/' . $contract->id . '/' . $contract->hash);

        if ($contract->rel_stype == 'kd-y') {
            $fields['{service_name}'] = get_case_name_by_id($contract->rel_sid);
        } else if ($contract->rel_stype == 'kdaya_altnfith') {
            $fields['{service_name}'] = get_disputes_case_name_by_id($contract->rel_sid);
        } else {
            $fields['{service_name}'] = get_project_name_by_id($contract->rel_sid);
        }


        $fields['{contract_short_url}'] = get_contract_shortlink($contract);

        $custom_fields = get_custom_fields('contracts');
        foreach ($custom_fields as $field) {
            $fields['{' . $field['slug'] . '}'] = get_custom_field_value($contract_id, $field['id'], 'contracts');
        }

        return hooks()->apply_filters('contract_merge_fields', $fields, [
            'id' => $contract_id,
            'contract' => $contract,
        ]);
    }
}
