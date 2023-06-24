<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['name', 'relation', 'email', 'mobile'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_emergency_contact';

$where = ['AND staff_id='.$staff_id];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['name'];

    $row[] = $aRow['relation'];

    $row[] = $aRow['email'];

    $row[] = $aRow['mobile'];

    $options = ''; if (has_permission('emergency_contacts', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_emergency_contact', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('emergency_contacts', '', 'delete')) $options .= icon_btn('hr/general/delete_emergency_contact/' . $aRow['id'], 'remove', 'btn-danger _delete');
    $options .= '<a href="' . admin_url('hr_profile/emergency_contacts_view_edit/' . $aRow['id']) . '">' . _l('hr_view') . '</a>';

    $row[]   = $options;

    $output['aaData'][] = $row;
}
