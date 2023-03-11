<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = [
    _l('the_number_sign'),
    [
        'name'     => _l('name'),
        'th_attrs' => [
            'style' => 'min-width:150px',
        ],
    ],
    _l('session_assigned'),
    _l('Court'),
    //_l('Court_decision'),
    _l('Customer_report'),
    _l('Send_to_customer'),
    _l('session_date'),
    _l('session_time'),
    _l('Customer_report'),
];

$custom_fields = get_custom_fields('sessions', [
    'show_on_table' => 1,
]);

foreach ($custom_fields as $field) {
    array_push($table_data, $field['name']);
}

$table_data = hooks()->apply_filters('sessions_table_columns', $table_data);
render_datatable($table_data, 'previous_sessions_log', [], array('all' => true));