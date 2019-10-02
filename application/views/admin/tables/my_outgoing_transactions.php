<?php
defined('BASEPATH') or exit('No direct script access allowed');
//$custom_fields         = get_table_custom_fields('procurations');
//var_dump('dshfjkhsdjfhjksdhjfk');exit();
$aColumns = [
    'id',
    'type',
    'origin',
    'is_secret',
    'importance',
    'classification',
    'owner',

];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'my_transactions';

$where = ['WHERE definition = 1 AND isDeleted = 0'];


$join = [];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];

$ci = &get_instance();
$ci->load->model('transactions_model');

foreach ($rResult as $aRow) {
    $row = [];
    $row[] = $aRow['id'];
    $row[] = $aRow['type'];
    $row[] = $aRow['origin'];
    $row[] = $aRow['is_secret'];
    $row[] = $aRow['importance'];
    $row[] = $aRow['classification'];
    $row[] = $aRow['owner'];



    $options = icon_btn('transactions/outgoing/' . $aRow['id']  , 'pencil-square-o', 'btn-default');
    // $options .= icon_btn('procuration/procurationcu/' . $request . '/' . $aRow['id'] . '/' . $addition , 'home', 'btn-default');
    $row[]   = $options .= icon_btn('#' , 'remove', 'btn-danger _delete',['data-id'=> $aRow['id']]);


    $output['aaData'][] = $row;
}
