<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() .'transaction_importance.id as id',
    'name'
];

$join = [];



$where  = [];
$filter = [];
$sIndexColumn = 'id';
$sTable       = db_prefix() . 'transaction_importance';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [

]);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {

    $row = [];

   // $row[] = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';

    $row[] = $aRow['id'];
    $_data =  $aRow['name'];
    $_data .= '<div class="row-options">';
        $_data .= ' <a href="' . admin_url('transactions/add_importance/' . $aRow['id']) . '">' . _l('edit') . '</a>';
        $_data .= ' | <a href="' . admin_url('transactions/delete_importance/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    $row[] = $_data;
    // Custom fields add values

    $output['aaData'][] = $row;
}
