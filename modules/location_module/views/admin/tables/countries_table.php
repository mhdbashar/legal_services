<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = ['short_name', 'short_name_ar'];

$sIndexColumn = 'country_id';
$sTable       = db_prefix().'countries';
$where = ['AND short_name_ar > ""'];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['country_id']);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $aRow['short_name'];
    $row[] = $aRow['short_name_ar'];
    
    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#countries_modal', 'data-id' => $aRow['country_id'], 'onclick' => 'edit_country_json(' . $aRow['country_id'] . ')']);
    $options .= icon_btn(admin_url('location_module/L_Locations/cities_index/') . $aRow['country_id'], 'home', 'btn-default');
    $row[]   = $options .= icon_btn('location_module/L_Locations/delete_Country/' . $aRow['country_id'], 'remove', 'btn-danger _delete');

    $output['aaData'][] = $row;
}
