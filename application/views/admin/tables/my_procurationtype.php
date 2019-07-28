<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'id',
    'procurationtype',
];


$join = [];
$where  = [];
$filter = [];
$sIndexColumn = 'id';
$sTable       = db_prefix() .'my_procurationtype';


$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where);

// echo "hello test"
$output  = $result['output'];
$rResult = $result['rResult'];

// foreach ($rResult as $aRow) {
//     $row = [];

//     $row[] = $aRow['id'];
//     $row[] = $aRow['procurationstate'];

//     $output['aaData'][] = $row;
// }

$is_admin = is_admin();
foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'procurationtype') {
            if ($is_admin) {
                $_data = '<a href="' . admin_url('procuration/typecu/' . $aRow['id']) . '">' . $_data . '</a>';
            } else {
                $_data = '<a href="' . admin_url('procuration/view/' . $aRow['id']) . '">' . $_data . '</a>';
            }
            $_data .= '<div class="row-options">';
            // $_data .= '<a href="' . admin_url('announcements/view/' . $aRow['announcementid']) . '">' . _l('view') . '</a>';

            if (is_admin()) {
                $_data .= ' <a href="' . admin_url('procuration/typecu/' . $aRow['id']) . '">' . _l('edit') . '</a>';
                $_data .= ' | <a href="' . admin_url('procuration/typed/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
            }

            $_data .= '</div>';
        } elseif ($aColumns[$i] == 'id') {
            $_data = $_data;
        }
        $row[] = $_data;
    }
    $row['DT_RowClass'] = 'has-row-options';
    // if (!$aRow['is_dismissed'] && $aRow['showtostaff'] == '1') {
    //     $row['DT_RowClass'] .= ' alert-info';
    // }
    $output['aaData'][] = $row;
}
