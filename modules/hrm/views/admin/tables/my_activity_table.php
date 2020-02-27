<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['id', 'description', 'date', 'staffid'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'activity_log';
$where = ['AND staffid ="'.$staffname.'"'];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $row[] = $aRow['id'];
    
    $row[] = $aRow['description'];

    $row[] = $aRow['date'];

    $row[] = $aRow['staffid'];

    


    $output['aaData'][] = $row;
}
