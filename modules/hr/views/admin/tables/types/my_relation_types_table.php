<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
id int(11)
title varchar(200)
num_days int(11)
num_hours int(11)
rate bigint
staff_id int(11)
*/
$aColumns = ['value'];

$sIndexColumn = 'id';
$sTable       = db_prefix().'options';

$where = ['AND name="relation_type"'];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

$values = '';
foreach ($rResult as $aRow) {
    $values = $aRow['value'];
}

foreach (json_decode($values) as $value) {

	$a = $value->key;

	foreach ($rResult as $aRow) {
	    $row = [];

	    $row[] = $a;

	    $options = icon_btn('#', 'pencil-square-o', 'btn-default old', ['data-toggle' => 'modal', 'data-target' => '#update_type', 'data-id' => $a, 'data-old' => $a, 'onclick' => "edit('" . $a . "')"]);
	    $row[]   = $options .= icon_btn('hr/setting/delete_type/' . $a .'/relation_type', 'remove', 'btn-danger _delete');
	    

	    $output['aaData'][] = $row;
	}
}

