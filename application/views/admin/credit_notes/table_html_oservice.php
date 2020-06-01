<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
    _l('credit_note_number'),
    _l('credit_note_date'),
    (!isset($client) ? _l('client') : array(
        'name'=>_l('client'),
        'th_attrs'=>array('class'=>'not_visible')
    )),
    _l('credit_note_status'),
    (!isset($project) ? _l('LegalService') : array(
        'name'=>_l('LegalService'),
        'th_attrs'=>array('class'=>'not_visible')
    )),
    _l('reference_no'),
    _l('credit_note_amount'),
    _l('credit_note_remaining_credits'),
);

$custom_fields = get_custom_fields('credit_note',array('show_on_table'=>1));
foreach($custom_fields as $field){
    array_push($table_data,$field['name']);
}
$table_attributes['data-ServID'] = $ServID;
$table_attributes['data-slug'] = $service->slug;
render_datatable($table_data,'credit-notes_oservice', [], $table_attributes);
?>
