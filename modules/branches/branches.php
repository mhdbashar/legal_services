<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
Author: Babil Team
Module Name: branches_name
Description: branches_desc
Version: 2.3.0
Requires at least: 2.3.*
Author URI: #

*/
define('BRANCHES_MODULE_NAME', 'branches');
define('BRANCHES_MODULE_PATH', __DIR__);

register_activation_hook(BRANCHES_MODULE_NAME, 'branch_setup_activation_hook');

hooks()->add_action('admin_init', 'branches_init_BranchApp');

hooks()->add_action('admin_init', 'branch_setup_init_menu_items');
// Services table
hooks()->add_filter('services_table_columns', 'services_add_table_column', 10, 2);
hooks()->add_filter('services_table_row_data', 'services_add_table_row', 10, 3);
hooks()->add_filter('services_table_aColumns', 'services_add_table_aColumns', 10, 4);
hooks()->add_filter('services_table_sql_join', 'services_add_table_sql_join', 10, 5);
hooks()->add_filter('cases_table_aColumns', 'cases_add_table_aColumns', 10, 6);
hooks()->add_filter('cases_table_sql_join', 'cases_add_table_sql_join', 10, 7);
hooks()->add_filter('services_filter', 'services_add_filter', 10, 8);
hooks()->add_filter('services_table_filter', 'services_table_add_filter', 10, 9);
hooks()->add_filter('services_hidden_filter', 'services_add_hidden_filter', 10, 9);
// Customers table
hooks()->add_filter('customers_table_row_data', 'customers_add_table_row', 10, 3);
hooks()->add_filter('customers_table_columns', 'customers_add_table_column', 10, 2);
hooks()->add_filter('customers_table_aColumns', 'services_add_table_aColumns', 10, 6);
hooks()->add_filter('customers_table_sql_join', 'customers_add_table_sql_join', 10, 7);
//estimates table
hooks()->add_filter('estimates_table_row_data', 'estimates_add_table_row', 10, 3);
hooks()->add_filter('estimates_table_columns', 'estimates_add_table_column', 10, 2);
hooks()->add_filter('estimates_table_aColumns', 'services_add_table_aColumns', 10, 6);
hooks()->add_filter('estimates_table_sql_join', 'estimates_add_table_sql_join', 10, 7);
//Invoices table
hooks()->add_filter('invoices_table_row_data', 'invoices_add_table_row', 10, 3);
hooks()->add_filter('invoices_table_columns', 'invoices_add_table_column', 10, 2);
hooks()->add_filter('invoices_table_aColumns', 'services_add_table_aColumns', 10, 6);
hooks()->add_filter('invoices_table_sql_join', 'invoices_add_table_sql_join', 10, 7);
//Staffs table
hooks()->add_filter('staffs_table_row_data', 'staffs_add_table_row', 10, 3);
hooks()->add_filter('staffs_table_columns', 'staffs_add_table_column', 10, 2);
hooks()->add_filter('staffs_table_aColumns', 'staffs_add_table_aColumns', 10, 6);
hooks()->add_filter('staffs_table_sql_join', 'staffs_add_table_sql_join', 10, 7);
//Departments table
hooks()->add_filter('departments_table_row_data', 'departments_add_table_row', 10, 3);
hooks()->add_filter('departments_table_columns', 'departments_add_table_column', 10, 2);
hooks()->add_filter('departments_table_aColumns', 'departments_add_table_aColumns', 10, 6);
hooks()->add_filter('departments_table_sql_join', 'departments_add_table_sql_join', 10, 7);


function services_table_add_filter($where, $filter){


    $CI = &get_instance();
    $CI->load->model('branches/Branches_model', 'branch');
    $branches = $CI->branch->getBranches();
    $branchIds = [];
    //$filter = [];
    foreach ($branches as $branch) {
        if ($CI->input->post('project_branch_' . $branch['key'])) {
            array_push($branchIds, $branch['key']);
        }
    }
    if (count($branchIds) > 0) {
        array_push($filter, 'AND '.db_prefix().'clients.userid IN (SELECT rel_id FROM '.db_prefix().'branches_services WHERE rel_type="clients" AND branch_id IN (' . implode(', ', $branchIds) . '))');
    }
    if (count($filter) > 0) {
        array_push($where, 'AND (' . prepare_dt_filter($filter) . ')');
    }
    return $where;
}

function services_add_filter($class){
    $CI = &get_instance();
    $CI->load->model('branches/Branches_model', 'branch');
    $branches = $CI->branch->getBranches();
    $data['branches'] = $branches;
    $data['class'] = $class;
    // $CI->load->view('branches_filter', $data);
    require "modules/branches/views/branches_filter.php";
}

function services_add_hidden_filter($data) {
    $CI = &get_instance();
    $CI->load->model('branches/Branches_model', 'branch');
    $branches = $CI->branch->getBranches();
    require "modules/branches/views/branches_hidden_filter.php";
}

function staffs_add_table_column($table_data) {
    array_push($table_data, _l('branch_id'));
    return $table_data;
}


function customers_add_table_row($row ,$aRow) {
    $CI = &get_instance();
    $CI->db->where(['rel_id' => $aRow['userid'], 'rel_type' => 'clients']);
    $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
    $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
    if(empty($branch)){
        $data = [
            'branch_id' => 1,
            'rel_type' => 'clients',
            'rel_id' => $aRow['userid']
        ];
        $CI->db->insert('tblbranches_services', $data);
        if($CI->db->insert_id()){
            $CI->db->where(['rel_id' => $aRow['userid'], 'rel_type' => 'clients']);
            $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
            $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
        }
    }
    $branch_id = !empty($branch) ? $branch['branch_id'] : '';

    $CI->load->model('branches/Branches_model', 'branch');
    $branches = $CI->branch->getBranches();
    $select = "<select onchange='window.location = \" ".admin_url('branches/switch/clients/'.$aRow['userid'].'/')."\" + this.value '>";

    $select .= '<option disabled selected="true">  ....  </option>';
    foreach($branches as $b){
        $selected = $b['key'] == $branch_id ? "selected" : "";
        $select .= '<option '.$selected.' value="'. $b['key'] .'" >'.$b["value"].'</option>';
    }
    $select .=    '</select>';

    $row[] = $select;

    return $row;
}

function staffs_add_table_row($row ,$aRow) {

    $CI = &get_instance();
    $CI->db->where(['rel_id' => $aRow['staffid'], 'rel_type' => 'staff']);
    $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
    $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
    if(empty($branch)){
        $data = [
            'branch_id' => 1,
            'rel_type' => 'staff',
            'rel_id' => $aRow['staffid']
        ];
        $CI->db->insert('tblbranches_services', $data);
        if($CI->db->insert_id()){
            $CI->db->where(['rel_id' => $aRow['staffid'], 'rel_type' => 'staff']);
            $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
            $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
        }
    }
    $branch_id = !empty($branch) ? $branch['branch_id'] : '';

    $CI->load->model('branches/Branches_model', 'branch');
    $branches = $CI->branch->getBranches();
    $select = "<select onchange='window.location = \" ".admin_url('branches/switch/staff/'.$aRow['staffid'].'/')."\" + this.value '>";

    $select .= '<option disabled selected="true">  ....  </option>';
    foreach($branches as $b){
        $selected = $b['key'] == $branch_id ? "selected" : "";
        $select .= '<option '.$selected.' value="'. $b['key'] .'" >'.$b["value"].'</option>';
    }
    $select .=    '</select>';
    // unset($row[5]);
    // var_dump($row); exit;

    $row[] = $select;

    return $row;
}

function departments_add_table_column($table_data) {
    array_push($table_data, _l('branch_id'));
    return $table_data;
}


function departments_add_table_row($row ,$aRow) {

    $CI = &get_instance();
    $CI->db->where(['rel_id' => $aRow['departmentid'], 'rel_type' => 'departments']);
    $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
    $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
    if(empty($branch)){
        $data = [
            'branch_id' => 1,
            'rel_type' => 'departments',
            'rel_id' => $aRow['departmentid']
        ];
        $CI->db->insert('tblbranches_services', $data);
        if($CI->db->insert_id()){
            $CI->db->where(['rel_id' => $aRow['departmentid'], 'rel_type' => 'departments']);
            $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
            $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
        }
    }
    $branch_id = !empty($branch) ? $branch['branch_id'] : '';

    $CI->load->model('branches/Branches_model', 'branch');
    $branches = $CI->branch->getBranches();
    $select = "<select onchange='window.location = \" ".admin_url('branches/switch/departments/'.$aRow['departmentid'].'/')."\" + this.value '>";

    $select .= '<option disabled selected="true">  ....  </option>';
    foreach($branches as $b){
        $selected = $b['key'] == $branch_id ? "selected" : "";
        $select .= '<option '.$selected.' value="'. $b['key'] .'" >'.$b["value"].'</option>';
    }
    $select .=    '</select>';

    $row[] = $select;

    return $row;
}

function services_add_table_column($table_data) {
    array_push($table_data, _l('branch_id'));
    return $table_data;
}


function services_add_table_row($row ,$aRow) {
    $CI = &get_instance();
    $CI->db->where(['rel_id' => $aRow['clientid'], 'rel_type' => 'clients']);
    $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
    $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
    $row[] = !empty($branch) ? $branch['title_en'] : '';
    return $row;
}


function services_add_table_aColumns($aColumns) {
    $aColumns[] = db_prefix().'branches.title_en as branch_id';
    return $aColumns;
}

function staffs_add_table_aColumns($aColumns) {
    $aColumns[] = db_prefix().'branches.title_en as branch_id';
    return $aColumns;
}
function departments_add_table_aColumns($aColumns) {
    $aColumns[] = db_prefix().'branches.title_en as branch_id';
    return $aColumns;
}
function services_add_table_sql_join($join) {
    $join[] = 'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_type="clients" AND '.db_prefix().'branches_services.rel_id='.db_prefix().'my_other_services.clientid';
    $join[] = 'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id';
    return $join;
}

function customers_add_table_sql_join($join) {
    $join[] = 'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_type="clients" AND '.db_prefix().'branches_services.rel_id='.db_prefix().'clients.userid';
    $join[] = 'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id';
    return $join;
}

function estimates_add_table_sql_join($join) {
    $join[] = 'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_type="clients" AND '.db_prefix().'branches_services.rel_id='.db_prefix().'estimates.clientid';
    $join[] = 'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id';
    return $join;
}
function invoices_add_table_sql_join($join) {
    $join[] = 'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_type="clients" AND '.db_prefix().'branches_services.rel_id='.db_prefix().'invoices.clientid';
    $join[] = 'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id';
    return $join;
}


function staffs_add_table_sql_join($join) {
    $join[] = 'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_type="staff" AND '.db_prefix().'branches_services.rel_id='.db_prefix().'staff.staffid';
    $join[] = 'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id';
    return $join;
}

function departments_add_table_sql_join($join) {
    $join[] = 'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_type="departments" AND '.db_prefix().'branches_services.rel_id='.db_prefix().'departments.departmentid';
    $join[] = 'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id';
    return $join;
}


function cases_add_table_aColumns($aColumns) {
    $aColumns[] = db_prefix().'branches.title_en as branch_id';
    return $aColumns;
}
function cases_add_table_sql_join($join) {
    $join[] = 'LEFT JOIN '.db_prefix().'branches_services ON '.db_prefix().'branches_services.rel_type="clients" AND '.db_prefix().'branches_services.rel_id='.db_prefix().'my_cases.clientid';
    $join[] = 'LEFT JOIN '.db_prefix().'branches ON '.db_prefix().'branches.id='.db_prefix().'branches_services.branch_id';
    return $join;
}


function invoices_add_table_column($table_data) {
    array_push($table_data, _l('branch_id'));
    return $table_data;
}


function invoices_add_table_row($row ,$aRow) {
    $CI = &get_instance();
    $CI->db->where(['rel_id' => $aRow['clientid'], 'rel_type' => 'clients']);
    $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
    $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
    $row[] = !empty($branch) ? $branch['title_en'] : '';
    return $row;
}


function estimates_add_table_column($table_data) {
    array_push($table_data, _l('branch_id'));
    return $table_data;
}


function estimates_add_table_row($row ,$aRow) {
    $CI = &get_instance();
    $CI->db->where(['rel_id' => $aRow['clientid'], 'rel_type' => 'clients']);
    $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
    $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
    $branch_name = !empty($branch) ? $branch['title_en'] : '';
    $branch_id = !empty($branch) ? $branch['branch_id'] : '';
    $row[] = $branch_name;

    return $row;
}

function customers_add_table_column($table_data) {
    array_push($table_data, _l('branch_id'));
    return $table_data;
}


function branch_setup_init_menu_items()
{
    /**
     * If the logged in user is administrator, add custom menu in Setup
     */
    if (is_admin()) {
        $CI = &get_instance();
        $CI->app_menu->add_setup_menu_item('branch-options', [
            'collapse' => true,
            'name'     => _l('Branches'),
            'position' => 60,
        ]);

        $CI->app_menu->add_setup_children_item('branch-options', [
            'slug'     => 'browse-branch',
            'name'     => _l('Browse Branch'),
            'href'     => admin_url('branches/'),
            'position' => 5,
        ]);

        $CI->app_menu->add_setup_children_item('branch-options', [
            'slug'     => 'add-branch',
            'name'     => _l('Add Branch'),
            'href'     => admin_url('branches/field'),
            'position' => 10,
        ]);
    }
}

function branch_setup_activation_hook()
{
    require_once(__DIR__ . '/install.php');
}

function branches_init_BranchApp(){
    $CI = & get_instance();
    $CI->load->library(BRANCHES_MODULE_NAME . '/' . 'BranchApp');
}