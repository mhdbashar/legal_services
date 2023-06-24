<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['account_title', 'account_number', 'bank_name', 'bank_code', 'bank_branch'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'hr_bank_account';

$where = ['AND staff_id='.$staff_id];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    
    $row[] = $aRow['account_title'];

    $row[] = $aRow['account_number'];

    $row[] = $aRow['bank_name'];

    $row[] = $aRow['bank_code'];

    $row[] = $aRow['bank_branch'];

    $options = ''; if (has_permission('bank_account', '', 'edit')) $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#update_bank_account', 'data-id' => $aRow['id'], 'onclick' => 'edit(' . $aRow['id'] . ')']);
    if (has_permission('bank_account', '', 'delete')) $options .= icon_btn('hr_profile/delete_bank_account/' . $aRow['id'], 'remove', 'btn-danger _delete');

        $options .= '<a href="' . admin_url('hr_profile/bank_account_view_edit/' . $aRow['id']) . '">' . _l('hr_view') . '</a>';

    $row[]   = $options;

    $output['aaData'][] = $row;
}
