<?php

defined('BASEPATH') or exit('No direct script access allowed');
hooks()->add_action('app_admin_head', 'babil_multi_theme_head_component');
hooks()->add_action('admin_init', 'babil_multi_theme_settings_tab');
hooks()->add_action('app_admin_authentication_head', 'babil_multi_theme_staff_login');

// Check if customers theme is enabled
if (get_option('babil_multi_theme_clients') == '1') {
    hooks()->add_action('app_customers_head', 'babil_app_client_multi_head_includes');
   
}

/**
 * Theme customers login includes
 * @return stylesheet / script
 */
function babil_multi_theme_staff_login()
{
    $CI = &get_instance();
    $color = $CI->db->select('theme_css')->from(db_prefix() . '_multi_theme')->get()->row();
    if(isset($color) && !empty($color->theme_css)){
        echo '<link href="' . base_url('modules/babil_multi_theme/assets/'.$color->theme_css.'-css/staff.css') . '"  rel="stylesheet" type="text/css" >';
       
    }
}

/**
 * Theme clients footer includes
 * @return stylesheet
 */
function babil_app_client_multi_head_includes()
{
    $CI = &get_instance();
    $color = $CI->db->select('theme_css')->from(db_prefix() . '_multi_theme')->get()->row();
    if(isset($color) && !empty($color->theme_css)){
        echo '<link href="' . module_dir_url('babil_multi_theme', 'assets/'.$color->theme_css.'-css/clients/customer.css') . '"  rel="stylesheet" type="text/css" >';
    }
}

/**
 * [babil_multi_theme_settings_tab net menu item in setup->settings]
 * @return void
 */
function babil_multi_theme_settings_tab()
{
    $CI = &get_instance();
    $CI->app_tabs->add_settings_tab('babil-theme-multi-settings', [
        'name'     => '' . _l('babil_multi_theme_settings_first') . '',
        'view'     => 'babil_multi_theme/babil_multi_theme_settings',
        'position' => 50,
    ]);
}

/**
 * Injects theme CSS
 * @return null
 */
function babil_multi_theme_head_component()
{
    $CI = &get_instance();
    $color = $CI->db->select('theme_css')->from(db_prefix() . '_multi_theme')->get()->row();
    if(isset($color) && !empty($color->theme_css)){
        echo '<link id="'.$color->theme_css.'_styles_color" href="' . base_url('modules/babil_multi_theme/assets/'.$color->theme_css.'-css/'.$color->theme_css.'_styles.css') . '"  rel="stylesheet" type="text/css" >';
    
    }
}

function current_theme_applied()
{
    $CI = &get_instance();
    $color = $CI->db->select('theme_css')->from(db_prefix() . '_multi_theme')->get()->row();
    $css = null;
     if(isset($color) && !empty($color->theme_css)){
        $css = $color->theme_css;
     }
    return $css;
}