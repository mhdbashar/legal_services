<?php
defined('BASEPATH') or exit('No direct script access allowed');

$project_id = $this->ci->input->post('project_id');

$aColumns = [
    'number',
    'total',
    'total_tax',
    'YEAR(date) as year',
    'date',
    get_sql_select_client_company(),
    db_prefix() . 'projects.name as project_name',
    '(SELECT GROUP_CONCAT(name SEPARATOR ",") FROM ' . db_prefix() . 'taggables JOIN ' . db_prefix() . 'tags ON ' . db_prefix() . 'taggables.tag_id = ' . db_prefix() . 'tags.id WHERE rel_id = ' . db_prefix() . 'my_project_invoices.id and rel_type="invoice" ORDER by tag_order ASC) as tags',
    'duedate',
    db_prefix() . 'my_project_invoices.status',
    ];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'my_project_invoices';

$join = [
    'LEFT JOIN ' . db_prefix() . 'clients ON ' . db_prefix() . 'clients.userid = ' . db_prefix() . 'my_project_invoices.clientid',
    'LEFT JOIN ' . db_prefix() . 'currencies ON ' . db_prefix() . 'currencies.id = ' . db_prefix() . 'my_project_invoices.currency',
    'LEFT JOIN ' . db_prefix() . 'projects ON ' . db_prefix() . 'projects.id = ' . db_prefix() . 'my_project_invoices.project_id',
];

$ci = &get_instance();
if($ci->app_modules->is_active('branches')){
    $aColumns[] = db_prefix().'branches.title_en as branch_id';
    $join[] = 'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_id='.db_prefix().'my_project_invoices.clientid AND '.db_prefix().'branches_services.rel_type="clients"';

    $join[] = 'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id';
}


$custom_fields = get_table_custom_fields('invoice');

foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);

    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'my_project_invoices.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}

$where  = [];
$filter = [];

if ($this->ci->input->post('not_sent')) {
    array_push($filter, 'AND sent = 0 AND ' . db_prefix() . 'my_project_invoices.status NOT IN('.Invoices_model::STATUS_PAID.','.Invoices_model::STATUS_CANCELLED.')');
}
if ($this->ci->input->post('not_have_payment')) {
    array_push($filter, 'AND ' . db_prefix() . 'my_project_invoices.id NOT IN(SELECT invoiceid FROM ' . db_prefix() . 'my_project_invoicepaymentrecords) AND ' . db_prefix() . 'my_project_invoices.status != '.Invoices_model::STATUS_CANCELLED);
}
if ($this->ci->input->post('recurring')) {
    array_push($filter, 'AND recurring > 0');
}

$statuses  = $this->ci->invoices_model->get_statuses();
$statusIds = [];
foreach ($statuses as $status) {
    if ($this->ci->input->post('invoices_' . $status)) {
        array_push($statusIds, $status);
    }
}
if (count($statusIds) > 0) {
    array_push($filter, 'AND ' . db_prefix() . 'my_project_invoices.status IN (' . implode(', ', $statusIds) . ')');
}

$agents    = $this->ci->invoices_model->get_sale_agents();
$agentsIds = [];
foreach ($agents as $agent) {
    if ($this->ci->input->post('sale_agent_' . $agent['sale_agent'])) {
        array_push($agentsIds, $agent['sale_agent']);
    }
}
if (count($agentsIds) > 0) {
    array_push($filter, 'AND sale_agent IN (' . implode(', ', $agentsIds) . ')');
}

$modesIds = [];
foreach ($data['payment_modes'] as $mode) {
    if ($this->ci->input->post('invoice_payments_by_' . $mode['id'])) {
        array_push($modesIds, $mode['id']);
    }
}
if (count($modesIds) > 0) {
    array_push($where, 'AND ' . db_prefix() . 'my_project_invoices.id IN (SELECT invoiceid FROM ' . db_prefix() . 'my_project_invoicepaymentrecords WHERE paymentmode IN ("' . implode('", "', $modesIds) . '"))');
}

$years     = $this->ci->invoices_model->get_invoices_years();
$yearArray = [];
foreach ($years as $year) {
    if ($this->ci->input->post('year_' . $year['year'])) {
        array_push($yearArray, $year['year']);
    }
}
if (count($yearArray) > 0) {
    array_push($where, 'AND YEAR(date) IN (' . implode(', ', $yearArray) . ')');
}

if (count($filter) > 0) {
    array_push($where, 'AND (' . prepare_dt_filter($filter) . ')');
}

if ($clientid != '') {
    array_push($where, 'AND ' . db_prefix() . 'my_project_invoices.clientid=' . $clientid);
}

if ($project_id) {
    array_push($where, 'AND project_id=' . $project_id);
}

if (!has_permission('invoices', '', 'view')) {
    $userWhere = 'AND ' . disputes_get_invoices_where_sql_for_staff(get_staff_user_id());
    array_push($where, $userWhere);
}

$aColumns = hooks()->apply_filters('invoices_table_sql_columns', $aColumns);

// Fix for big queries. Some hosting have max_join_limit
if (count($custom_fields) > 4) {
    @$this->ci->db->query('SET SQL_BIG_SELECTS=1');
}

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
    db_prefix() . 'my_project_invoices.id',
    db_prefix() . 'my_project_invoices.clientid',
    db_prefix(). 'currencies.name as currency_name',
    'project_id',
    'hash',
    'recurring',
    'deleted_customer_name',
    ]);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

    $numberOutput = '';

    // If is from client area table
    if (is_numeric($clientid) || $project_id) {
        $numberOutput = '<a href="' . admin_url('disputes/invoices/list_invoices/' . $aRow['id']) . '" target="_blank">' . disputes_format_invoice_number($aRow['id']) . '</a>';
    } else {
        $numberOutput = '<a href="' . admin_url('disputes/invoices/list_invoices/' . $aRow['id']) . '" onclick="init_invoice_disputes(' . $aRow['id'] . '); return false;">' . disputes_format_invoice_number($aRow['id']) . '</a>';
    }

    if ($aRow['recurring'] > 0) {
        $numberOutput .= '<br /><span class="label label-primary inline-block mtop4"> ' . _l('invoice_recurring_indicator') . '</span>';
    }

    $numberOutput .= '<div class="row-options">';

    $numberOutput .= '<a href="' . site_url('disputes/invoice/' . $aRow['id'] . '/' . $aRow['hash']) . '" target="_blank">' . _l('view') . '</a>';
    if (has_permission('invoices', '', 'edit')) {
        $numberOutput .= ' | <a href="' . admin_url('disputes/invoices/invoice/' . $aRow['id']) . '">' . _l('edit') . '</a>';
    }
    $numberOutput .= '</div>';

    $row[] = $numberOutput;

    $row[] = app_format_money($aRow['total'], $aRow['currency_name']);

    $row[] = app_format_money($aRow['total_tax'], $aRow['currency_name']);

    $row[] = $aRow['year'];

    $row[] = _d($aRow['date']);

    if (empty($aRow['deleted_customer_name'])) {
        $row[] = '<a href="' . admin_url('clients/client/' . $aRow['clientid']) . '">' . $aRow['company'] . '</a>';
    } else {
        $row[] = $aRow['deleted_customer_name'];
    }

    $row[] = '<a href="' . admin_url('disputes/view/' . $aRow['project_id']) . '">' . $aRow['project_name'] . '</a>';
    ;

    $row[] = render_tags($aRow['tags']);

    $row[] = _d($aRow['duedate']);

    $row[] = disputes_format_invoice_status($aRow[db_prefix() . 'my_project_invoices.status']);

    // Custom fields add values
    foreach ($customFieldsColumns as $customFieldColumn) {
        $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
    }

    $row['DT_RowClass'] = 'has-row-options';

    if($ci->app_modules->is_active('branches')){
        $row[] = $aRow['branch_id'];
    }

    $row = hooks()->apply_filters('invoices_table_row_data', $row, $aRow);

    $output['aaData'][] = $row;
}
