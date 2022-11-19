<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix().'branches.id',
    db_prefix().'branches.title_en as title',
    'countries.title_en as country',
    'cities.title_en as city',
    'phone'
    ];
$sIndexColumn = 'id';
$sTable       = db_prefix().'branches';
$join=['join countries on countries.id=tblbranches.country_id','join cities on cities.id=tblbranches.city_id'];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable,$join);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if ($aColumns[$i] == db_prefix().'branches.title_en as title' || $aColumns[$i] == 'id') {
            $_data = '<a href="' . admin_url('branches/field/' . $aRow['id']) . '">' . $aRow['title'] . '</a>';
            if ($aColumns[$i] == db_prefix().'branches.title_en as title') {
                $_data .= '<div class="row-options">';
                $_data .= '<a href="' . admin_url('branches/field/' . $aRow['tblbranches.id']) . '">' . _l('edit') . '</a>';
                $_data .= ' | <a href="' . admin_url('branches/delete/' . $aRow['tblbranches.id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                $_data .= ' | <a href="' . admin_url('branches/departments/' . $aRow['tblbranches.id']) . '" class="text-danger _delete">' . _l('departments') . '</a>';
                $_data .= '</div>';
            }
        }
        if($aColumns[$i]=='countries.title_en as country') {
            $_data = '<a href="">' . $aRow['country'] . '</a>';
        }
        if($aColumns[$i]=='cities.title_en as city') {
            $_data = '<a href="">' . $aRow['city'] . '</a>';
        }

        $row[] = $_data;
    }

    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
