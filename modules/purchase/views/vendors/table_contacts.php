<?php

defined('BASEPATH') or exit('No direct script access allowed');

$total_client_contacts = total_rows(db_prefix() . 'pur_contacts', ['userid' => $client_id]);
$this->ci->load->model('gdpr_model');

$consentContacts = get_option('gdpr_enable_consent_for_contacts');
$aColumns        = [ 'CONCAT(firstname, \' \', lastname) as full_name'];
if (is_gdpr() && $consentContacts == '1') {
    array_push($aColumns, '1');
}
$aColumns = array_merge($aColumns, [
    'email',
    'title',
    'phonenumber',
    'active',
    
]);

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'pur_contacts';
$join         = [];

$custom_fields = get_table_custom_fields('contacts');

foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'pur_contacts.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}

$where = ['AND userid=' . $client_id];

// Fix for big queries. Some hosting have max_join_limit
if (count($custom_fields) > 4) {
    @$this->ci->db->query('SET SQL_BIG_SELECTS=1');
}

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix() . 'pur_contacts.id as id', 'userid', 'is_primary']);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $rowName = '<a href="#" onclick="vendor_contact(' . $aRow['userid'] . ',' . $aRow['id'] . ');return false;">' . $aRow['full_name'] . '</a>';

    $rowName .= '<div class="row-options">';

    $rowName .= '<a href="#" onclick="vendor_contact(' . $aRow['userid'] . ',' . $aRow['id'] . ');return false;">' . _l('edit') . '</a>';


    if (has_permission('purchase_vendors', '', 'delete') || is_vendor_admin($aRow['userid']) || is_admin()) {
        if ($aRow['is_primary'] == 0 || ($aRow['is_primary'] == 1 && $total_client_contacts == 1)) {
            $rowName .= ' | <a href="' . admin_url('purchase/delete_vendor_contact/' . $aRow['userid'] . '/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
        }
    }

    $rowName .= '</div>';


    $row[] = $rowName;

    if (is_gdpr() && $consentContacts == '1') {
        $consentHTML = '<p class="bold"><a href="#" onclick="view_contact_consent(' . $aRow['id'] . '); return false;">' . _l('view_consent') . '</a></p>';
        $consents    = $this->ci->gdpr_model->get_consent_purposes($aRow['id'], 'contact');
        foreach ($consents as $consent) {
            $consentHTML .= '<p class="m-bot-0">' . $consent['name'] . (!empty($consent['consent_given']) ? '<i class="fa fa-check text-success pull-right"></i>' : '<i class="fa fa-remove text-danger pull-right"></i>') . '</p>';
        }
        $row[] = $consentHTML;
    }

    $row[] = '<a href="mailto:' . $aRow['email'] . '">' . $aRow['email'] . '</a>';

    $row[] = $aRow['title'];

    $row[] = '<a href="tel:' . $aRow['phonenumber'] . '">' . $aRow['phonenumber'] . '</a>';

    $outputActive = '<div class="onoffswitch">
                <input type="checkbox"' . (total_rows(db_prefix() . 'pur_vendor', 'registration_confirmed=0 AND userid=' . $aRow['userid']) > 0 ? ' disabled' : '') . ' data-switch-url="' . admin_url() . 'purchase/change_contact_status" name="onoffswitch" class="onoffswitch-checkbox" id="c_' . $aRow['id'] . '" data-id="' . $aRow['id'] . '"' . ($aRow['active'] == 1 ? ' checked': '') . '>
                <label class="onoffswitch-label" for="c_' . $aRow['id'] . '"></label>
            </div>';
    // For exporting
    $outputActive .= '<span class="hide">' . ($aRow['active'] == 1 ? _l('is_active_export') : _l('is_not_active_export')) . '</span>';
    $row[] = $outputActive;


    // Custom fields add values
    foreach ($customFieldsColumns as $customFieldColumn) {
        $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
    }

    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
