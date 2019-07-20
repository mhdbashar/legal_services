<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['Name_en'];

$sIndexColumn = 'Id';
$sTable       = db_prefix().'cities';

$where = ['WHERE country_id = ' . $country_id];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['Id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0 ; $i < count($aColumns) ; $i++) {
        $_data = '<a href="#" data-toggle="modal" data-target="#cities_modal" data-id="' . $aRow['Id'] . '">' . $aRow[$aColumns[$i]] . '</a>';

        $row[] = $_data;
    }
    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#cities_modal', 'data-id' => $aRow['Id']]);
    $row[]   = $options .= icon_btn('location_module/L_Locations/delete_City/' . $aRow['Id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
