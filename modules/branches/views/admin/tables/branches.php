<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'id',
    'title_en',
    'short_name',
    'phone'
];
$sIndexColumn = 'id';
$sTable       = 'tblbranches';
$join=[
    'join tblcountries on tblcountries.country_id=tblbranches.country_id'
    ];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable,$join);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    //var_dump($aColumns);die();
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == 'title_en' || $aColumns[$i] == 'id') {
            $_data = '<a href="' . admin_url('branches/field/' . $aRow['id']) . '">' . $aRow['title_en'] . '</a>';
            if ($aColumns[$i] == 'title_en') {
                $_data .= '<div class="row-options">';
                $_data .= '<a href="' . admin_url('branches/field/' . $aRow['id']) . '">' . _l('edit') . '</a>';
                $_data .= ' | <a href="' . admin_url('branches/delete/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                $_data .= ' | <a href="' . admin_url('branches/departments/' . $aRow['id']) . '" class="text-danger">' . _l('departments') . '</a>';
                $_data .= '</div>';
            }
        }
        /*if($aColumns[$i]=='countries.title_en as country') {
            $_data = '<a href="">' . $aRow['country'] . '</a>';
        }
        if($aColumns[$i]=='cities.title_en as city') {
            $_data = '<a href="">' . $aRow['city'] . '</a>';
        }*/

        $row[] = $_data;
    }

    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
