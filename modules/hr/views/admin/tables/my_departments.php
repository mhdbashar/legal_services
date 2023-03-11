<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'departmentid',
    'name',
    'email',
    'calendar_id',
    ];
$sIndexColumn = 'departmentid';
$sTable       = db_prefix().'departments';

$other_cols = ['email', 'hidefromclient', 'host', 'encryption', 'password', 'delete_after_import', 'imap_username'];
$join = [];
$ci = &get_instance();
if($ci->app_modules->is_active('branches')){
    $join = [
        'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_type="departments" AND '.db_prefix().'branches_services.rel_id='.db_prefix().'departments.departmentid',
        //'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id',
    ];
    $other_cols[] = db_prefix().'branches_services.branch_id as branch_id';
}

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], $other_cols);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    $name_branch = '';
    if($ci->app_modules->is_active('branches')){
        $name_branch = '" data-branch_id="' . $aRow['branch_id'];
    }
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        $ps    = '';
        if (!empty($aRow['password'])) {
            $ps = $this->ci->encryption->decrypt($aRow['password']);
        }
        if ($aColumns[$i] == 'name') {
            $_data = '<a href="#" onclick="edit_department(this,' . $aRow['departmentid'] . '); return false" data-name="' . $aRow['name'] . '" data-calendar-id="' . $aRow['calendar_id'] . '" data-email="' . $aRow['email'] . '" data-hide-from-client="' . $aRow['hidefromclient'] . '" data-host="' . $aRow['host']. $name_branch . '" data-password="' . $ps . '" data-imap_username="' . $aRow['imap_username'] . '" data-encryption="' . $aRow['encryption'] . '" data-delete-after-import="' . $aRow['delete_after_import'] . '">' . $_data . '</a>';
        }
        $row[] = $_data;
    }

    $options = icon_btn('departments/department/' . $aRow['departmentid'], 'pencil-square-o', 'btn-default', [
        'onclick' => 'edit_department(this,' . $aRow['departmentid'] . '); return false', 'data-name' => $aRow['name'], 'data-calendar-id' => $aRow['calendar_id'], 'data-email' => $aRow['email'], 'data-hide-from-client' => $aRow['hidefromclient'], 'data-host' => $aRow['host'], 'data-password' => $ps, 'data-encryption' => $aRow['encryption'], 'data-imap_username' => $aRow['imap_username'], 'data-delete-after-import' => $aRow['delete_after_import']
        ]);
    if($ci->app_modules->is_active('branches')){
        $options = icon_btn('departments/department/' . $aRow['departmentid'], 'pencil-square-o', 'btn-default', [
        'onclick' => 'edit_department(this,' . $aRow['departmentid'] . '); return false', 'data-name' => $aRow['name'], 'data-calendar-id' => $aRow['calendar_id'], 'data-email' => $aRow['email'], 'data-hide-from-client' => $aRow['hidefromclient'], 'data-host' => $aRow['host'], 'data-password' => $ps, 'data-encryption' => $aRow['encryption'], 'data-imap_username' => $aRow['imap_username'], 'data-delete-after-import' => $aRow['delete_after_import'], 'data-branch_id' => $aRow['branch_id']
        ]);
    }
    $options .= icon_btn('departments/delete/' . $aRow['departmentid'], 'remove', 'btn-danger _delete');

    $row[]   = $options;
    $output['aaData'][] = $row;
}
