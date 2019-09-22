<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: disputes
Description: Default module for managing Financial disputes
Version: 1.0.0
Requires at least: 2.3.*
*/

define('DISPUTES_MODULE_NAME', 'disputes');
define('DISPUTES_MODULE_PATH', __DIR__ );

register_activation_hook('disputes', 'disputes_module_activation_hook');
hooks()->add_action('admin_init', 'disputes_module_init_menu_items');
hooks()->add_action('admin_init', 'disputes_init_library');
hooks()->add_action('admin_init', 'disputes_init_invoice_tabs');
hooks()->add_action('after_render_single_setup_menu','my_custom_menu_items');




function my_custom_menu_items($item){
    //print_r($item);
    if($item['slug']==2) echo '<li><a href="'.admin_url('disputes/statuses').'">إدارة حالات النزاع المالي</a></li>';
}

function disputes_init_invoice_tabs()
{
    $CI = &get_instance();

    $CI->app_tabs->add_project_tab_children_item('sales', [
        'slug'     => 'disputes_invoices',
        'name'     => _l('disputes_invoices'),
        'view'     => 'disputes/disputes_invoices',
        'position' => 5,
        'visible'  => true,//(has_permission('invoices', '', 'view') || has_permission('invoices', '', 'view_own') || (get_option('allow_staff_view_invoices_assigned') == 1 && disputes_staff_has_assigned_invoices())),
    ]);
    /*
    $CI->app_tabs->add_case_tab('CaseSession', [
        'name'                      => _l('CaseSession'),
        'icon'                      => 'fa fa-map-marker',
        'view'                      => 'admin/LegalServices/cases/case_session',
        'position'                  => 65,
    ]);*/
}

/**
 * Init disputes module menu items in setup in admin_init hook
 * @return null
 */
function disputes_module_init_menu_items()
{
    $CI = &get_instance();

    $CI->app->add_quick_actions_link([
            'name'       => _l('disputes'),
            'url'        => 'disputes/disputes',
            'permission' => 'disputes',
            'position'   => 56,
            ]);


    if (has_permission('disputes', '', 'view')) {
        $CI->app_menu->add_sidebar_children_item('custom-menu-unique-id', [
                'slug'     => 'disputes',
                'name'     => _l('نزاعات مالية'),
                'href'     => admin_url('disputes'),
                'position' => 24,
        ]);
        /*$CI->app_menu->add_sidebar_children_item('custom-menu-unique-id', [
                'slug'     => 'disputes',
                'name'     => _l('إدارة حالات النزاع'),
                'href'     => admin_url('disputes/statuses'),
                'position' => 24,
        ]);*/
    }
}

function disputes_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

function disputes_init_library(){
    $CI = & get_instance();
    $CI->load->library(DISPUTES_MODULE_NAME . '/' . 'disputesApp');
    $CI->load->helper(DISPUTES_MODULE_NAME . '/' . 'disputes_invoices');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(DISPUTES_MODULE_NAME, [DISPUTES_MODULE_NAME]);
