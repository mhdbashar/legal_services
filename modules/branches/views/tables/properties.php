<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'id',
    'title',
    ];
$sIndexColumn = 'id';
$sTable       = 'tblproperties';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'title' || $aColumns[$i] == 'id') {
            $_data = '<a href="' . admin_url('branches/field/' . $aRow['id']) . '">' . $_data . '</a>';
            if ($aColumns[$i] == 'title') {
                $_data .= '<div class="row-options">';
                $_data .= '<a href="' . admin_url('branches/field/' . $aRow['id']) . '">' . _l('edit') . '</a>';
                $_data .= ' | <a href="' . admin_url('branches/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                $_data .= '</div>';
            }
        }
        $row[] = $_data;
    }

    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
