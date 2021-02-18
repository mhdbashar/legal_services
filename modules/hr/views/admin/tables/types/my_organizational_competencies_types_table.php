<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['value'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'options';

$where = ['AND name="organizational_competencies_type"'];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

$values = '';
foreach ($rResult as $aRow) {
    $values = $aRow['value'];
}
if(json_decode($values) == null){
    $output['aaData'] = [];
}else
foreach (json_decode($values) as $value) {

	$a = $value->key;

	foreach ($rResult as $aRow) {
	    $row = [];

	    $row[] = $a;

	    $options = icon_btn('#', 'pencil-square-o', 'btn-default old', ['data-toggle' => 'modal', 'data-target' => '#update_type', 'data-id' => $a, 'data-old' => $a, 'onclick' => "edit('" . $a . "')"]);
	    $row[]   = $options .= icon_btn('hr/setting/delete_type/' . $a .'/organizational_competencies_type', 'remove', 'btn-danger _delete');
	    

	    $output['aaData'][] = $row;
	}
}


