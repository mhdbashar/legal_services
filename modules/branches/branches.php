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
// Customers table
hooks()->add_filter('customers_table_row_data', 'customers_add_table_row', 10, 3);
hooks()->add_filter('customers_table_columns', 'customers_add_table_column', 10, 2);
//estimates table
hooks()->add_filter('estimates_table_row_data', 'estimates_add_table_row', 10, 3);
hooks()->add_filter('estimates_table_columns', 'estimates_add_table_column', 10, 2);
//Invoices table
hooks()->add_filter('invoices_table_row_data', 'invoices_add_table_row', 10, 3);
hooks()->add_filter('invoices_table_columns', 'invoices_add_table_column', 10, 2);
//Staffs table
hooks()->add_filter('staffs_table_row_data', 'staffs_add_table_row', 10, 3);
hooks()->add_filter('staffs_table_columns', 'staffs_add_table_column', 10, 2);

function staffs_add_table_column($table_data) {
    array_push($table_data, _l('branch_id'));
    return $table_data;
}


function staffs_add_table_row($row ,$aRow) {
    $CI = &get_instance();
    $icon = '';
    $CI->db->where(['rel_id' => $aRow['staffid'], 'rel_type' => 'staff']);
    $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
    $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
    $row[] = !empty($branch) ? $branch['title_en'] : '';
    return $row;
}

function services_add_table_column($table_data) {
    array_push($table_data, _l('branch_id'));
    return $table_data;
}


function services_add_table_row($row ,$aRow) {
    $CI = &get_instance();
    $icon = '';
    $CI->db->where(['rel_id' => $aRow['clientid'], 'rel_type' => 'clients']);
    $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
    $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
    $row[] = !empty($branch) ? $branch['title_en'] : '';
    return $row;
}

function invoices_add_table_column($table_data) {
    array_push($table_data, _l('branch_id'));
    return $table_data;
}


function invoices_add_table_row($row ,$aRow) {
    $CI = &get_instance();
    $icon = '';
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
    $icon = '';
    $CI->db->where(['rel_id' => $aRow['clientid'], 'rel_type' => 'clients']);
    $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
    $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
    $branch_name = !empty($branch) ? $branch['title_en'] : '';
    $branch_id = !empty($branch) ? $branch['branch_id'] : '';
    $row[] =
        '<select>'.
            '<option value="0">no thing selected</option>'.
            '<option '.$branch_id.'>'.$branch_name.'</option>'.
        '</select>';

    return $row;
}

function customers_add_table_column($table_data) {
    array_push($table_data, _l('branch_id'));
    return $table_data;
}

function customers_add_table_row($row ,$aRow) {
    $CI = &get_instance();
    $icon = '';
    $CI->db->where(['rel_id' => $aRow['userid'], 'rel_type' => 'clients']);
    $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
    $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
    if(empty($branch)){
        $data = [
            'branch_id' => 1,
            'rel_type' => 'client',
            'rel_id' => $aRow['userid']
        ];
        $CI->db->insert('tblbranches_services', $data);
        if($CI->db->insert_id()){
            $CI->db->where(['rel_id' => $aRow['userid'], 'rel_type' => 'clients']);
            $CI->db->join(db_prefix().'branches', db_prefix().'branches.id='.db_prefix().'branches_services.branch_id');
            $branch = $CI->db->get(db_prefix().'branches_services')->row_array();
        }
    }
    $branch_name = !empty($branch) ? $branch['title_en'] : '';
    $branch_id = !empty($branch) ? $branch['branch_id'] : '';

    $CI->load->model('branches/Branches_model', 'branch');
    $branches = $CI->branch->getBranches();
    $select = "<select onchange='window.location = \" ".admin_url('branches/switchfadfsdaf')."\" + this.value '>";
    foreach($branches as $b){
        $selected = $b['key'] == $branch_id ? "selected" : "";
        $select .= '<option '.$selected.' value="'. $b['key'] .'" >'.$b["value"].'</option>';
    }
//    $select .=        '<option value="0">no thing selected</option>';
//    $select .=        '<option selected=" selected" '.$branch_id.'>'.$branch_name.'</option>';
    $select .=    '</select>';

    $row[] = $select;

    return $row;
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