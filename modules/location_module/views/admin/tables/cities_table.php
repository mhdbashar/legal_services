<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['Name_en', 'Name_ar'];

$sIndexColumn = 'Id';
$sTable       = db_prefix().'cities';

$where = ['WHERE country_id = ' . $country_id];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['Id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $aRow['Name_en'];
    $row[] = $aRow['Name_ar'];


    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#cities_modal', 'data-id' => $aRow['Id'], 'onclick' => 'edit_city_json(' . $aRow['Id'] . ')']);
    $row[]   = $options .= icon_btn('location_module/L_Locations/delete_City/' . $aRow['Id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
