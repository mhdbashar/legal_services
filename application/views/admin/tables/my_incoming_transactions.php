<?php
defined('BASEPATH') or exit('No direct script access allowed');
//$custom_fields         = get_table_custom_fields('procurations');
//var_dump('dshfjkhsdjfhjksdhjfk');exit();
$aColumns = [
    'id',
    'type',
    'origin',
    'incoming_num',
    'incoming_source',
    'incoming_type',
    'is_secret',
    'importance',
    'classification',
    'owner',
    db_prefix() .'my_transactions.date as date',

];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'my_transactions';

$where = ['WHERE definition = 0 AND isDeleted = 0'];


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
    $row[] = $aRow['incoming_num'];
    $row[] = $aRow['incoming_source'];
    $row[] = $aRow['incoming_type'];
    $row[] = $aRow['is_secret'] ==1 ? _l('secret_trans') : _l('normal_trans');
    $row[] = $aRow['importance'];
    $row[] = $aRow['classification'];
    $row[] = $aRow['owner'];

    $row[] = $aRow['date'];
    $options = '';


    if(has_permission('transactions', '', 'edit') || has_permission('transactions', '', 'delete')) {

        if(has_permission('transactions', '', 'edit')) {
            $options .= icon_btn('transactions/incoming/' . $aRow['id']  , 'pencil-square-o', 'btn-default');
        }
        if(has_permission('transactions', '', 'delete')) {
            $options .= icon_btn('#', 'remove', 'btn-danger _delete',['data-id'=> $aRow['id']]);
        }

        $row[] = $options;
        // $options .= icon_btn('procuration/procurationcu/' . $request . '/' . $aRow['id'] . '/' . $addition , 'home', 'btn-default');
    }

    $output['aaData'][] = $row;
}
