<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['short_name'];

$sIndexColumn = 'country_id';
$sTable       = db_prefix().'countries';

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['country_id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $aRow['short_name'];
    
    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#countries_modal', 'data-id' => $aRow['country_id'], 'onclick' => 'edit_country_json(' . $aRow['country_id'] . ')']);
    $options .= icon_btn(admin_url('location_module/L_Locations/cities_index/') . $aRow['country_id'], 'home', 'btn-default');
    $row[]   = $options .= icon_btn('location_module/L_Locations/delete_Country/' . $aRow['country_id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
