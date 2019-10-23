<?php defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() .'my_service_phases.id as id',
    'name',
    'is_active',
];

$join = [];
$where  = [];
$filter = [];
$sIndexColumn = 'id';
$sTable       = db_prefix() . 'my_service_phases';
array_push($where, 'AND deleted = 0');

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where);
$output  = $result['output'];
$rResult = $result['rResult'];
$i = 1;
foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $i;
    $_data =  '<a href="#">' . $aRow['name'] . '</a>';
    $_data .= '<div class="row-options">';
    $_data .= ' <a href="' . admin_url('LegalServices/Phases_controller/add_edit_phase/' . $aRow['id']) . '">' . _l('edit') . '</a>';
    $_data .= ' | <a href="' . admin_url('LegalServices/Phases_controller/delete_phase/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    $_data .= '</div>';
    $row[] = $_data;
    $cond  = $aRow['is_active'] == 1 ? 'checked' : '';
    $html  = '<div class="onoffswitch">';
    $html  .= '<input type="checkbox" name="is_primary" class="onoffswitch-checkbox" onchange="active(this.id)" id="'.$aRow['id'].'" value="'.$aRow['is_active'].'" data-id="'.$aRow['id'].'" '.$cond.'>';
    $html  .= '<label class="onoffswitch-label" for="'.$aRow['id'].'"></label>';
    $html  .= '</div>';
    $row[] = $html;
    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
    $i++;
}