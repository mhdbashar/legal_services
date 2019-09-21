<?php
/**
 * Created by PhpStorm.
 * User: Eng. ANAS MATAR
 * Date: 6/4/2019
 * Time: 2:10 PM
 */
defined('BASEPATH') or exit('No direct script access allowed');
/*
Module Name: Branches
Description: Management Branches
Version: 2.3.0
Requires at least: 2.3.*
*/
define('BRANCHES_MODULE_NAME', 'branches');
define('BRANCHES_MODULE_PATH', __DIR__);

register_activation_hook(BRANCHES_MODULE_NAME, 'branch_setup_activation_hook');

hooks()->add_action('admin_init', 'branches_init_BranchApp');

hooks()->add_action('admin_init', 'branch_setup_init_menu_items');



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