<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'departmentid',
    'name',
    'email',
    'calendar_id',
    ];

$count_columns = count($aColumns);
$aColumns = hooks()->apply_filters('departments_table_aColumns', $aColumns);

$sIndexColumn = 'departmentid';
$sTable       = db_prefix() . 'departments';
$join = [];
$join = hooks()->apply_filters('departments_table_sql_join', $join);
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], ['email', 'hidefromclient', 'host', 'encryption', 'password', 'delete_after_import', 'imap_username', 'folder']);


$ci = &get_instance();

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < $count_columns; $i++) {
        $_data = $aRow[$aColumns[$i]];
        $ps    = '';
        if (!empty($aRow['password'])) {
            $ps = $this->ci->encryption->decrypt($aRow['password']);
        }
        if ($aColumns[$i] == 'name') {
            $_data = '<a href="#" onclick="edit_department(this,' . $aRow['departmentid'] . '); return false" data-name="' . $aRow['name'] . '" data-calendar-id="' . $aRow['calendar_id'] . '" data-email="' . $aRow['email'] . '" data-hide-from-client="' . $aRow['hidefromclient']  . '" data-password="' . $ps . '" data-folder="' . $aRow['folder'] . '" data-imap_username="' . $aRow['imap_username'] . '" data-encryption="' . $aRow['encryption'] . '" data-delete-after-import="' . $aRow['delete_after_import'] . '">' . $_data . '</a>';
        }
        $row[] = $_data;
    }

    $row = hooks()->apply_filters('departments_table_row_data', $row, $aRow);

    $options = icon_btn('departments/department/' . $aRow['departmentid'], 'pencil-square-o', 'btn-default', [
        'onclick' => 'edit_department(this,' . $aRow['departmentid'] . '); return false', 'data-name' => $aRow['name'], 'data-calendar-id' => $aRow['calendar_id'], 'data-email' => $aRow['email'], 'data-hide-from-client' => $aRow['hidefromclient'], 'data-host' => $aRow['host'], 'data-password' => $ps, 'data-encryption' => $aRow['encryption'], 'data-folder' => $aRow['folder'], 'data-imap_username' => $aRow['imap_username'], 'data-delete-after-import' => $aRow['delete_after_import'],
        ]);
    if($ci->app_modules->is_active('branches')){
        $options = icon_btn('departments/department/' . $aRow['departmentid'], 'pencil-square-o', 'btn-default', [
        'onclick' => 'edit_department(this,' . $aRow['departmentid'] . '); return false', 'data-name' => $aRow['name'], 'data-calendar-id' => $aRow['calendar_id'], 'data-email' => $aRow['email'], 'data-hide-from-client' => $aRow['hidefromclient'], 'data-host' => $aRow['host'], 'data-password' => $ps, 'data-encryption' => $aRow['encryption'], 'data-folder' => $aRow['folder'], 'data-imap_username' => $aRow['imap_username'], 'data-delete-after-import' => $aRow['delete_after_import']
        ]);
    }
    $row[] = $options .= icon_btn('departments/delete/' . $aRow['departmentid'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}