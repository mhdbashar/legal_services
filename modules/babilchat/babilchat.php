<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
Module Name: المحادثة الحية
Description: وحدة المحادثة الحية والمجموعات
Version: 1.4.7
Author: Babil Team
Author URI: https://www.babiltec.com
Requires at least: 2.3.2
*/

define('BABIL_CHAT_MODULE_NAME', 'babilchat');
define('BABIL_CHAT_MODULE_UPLOAD_FOLDER', module_dir_path(BABIL_CHAT_MODULE_NAME, 'uploads'));
define('BABIL_CHAT_MODULE_GROUPS_UPLOAD_FOLDER', module_dir_path(BABIL_CHAT_MODULE_NAME, 'uploads/groups'));
define('BABIL_CHAT_MODULE_AUDIO_UPLOAD_FOLDER', module_dir_path(BABIL_CHAT_MODULE_NAME, 'uploads/audio'));

/*
 Defined group chat table names
*/
define('TABLE_STAFF', db_prefix() . 'staff');
define('TABLE_CHATMESSAGES', db_prefix() . 'chatmessages');
define('TABLE_CHATSETTINGS', db_prefix() . 'chatsettings');
define('TABLE_CHATSHAREDFILES', db_prefix() . 'chatsharedfiles');
define('TABLE_CHATGROUPS', db_prefix() . 'chatgroups');
define('TABLE_CHATGROUPMEMBERS', db_prefix() . 'chatgroupmembers');
define('TABLE_CHATGROUPMESSAGES', db_prefix() . 'chatgroupmessages');
define('TABLE_CHATGROUPSHAREDFILES', db_prefix() . 'chatgroupsharedfiles');
define('TABLE_CHATCLIENTMESSAGES', db_prefix() . 'chatclientmessages');

$CI = &get_instance();

/**
 * Register the activation chat
 */
register_activation_hook(BABIL_CHAT_MODULE_NAME, 'babilchat_activation_hook');

/**
 * The activation function
 */
function babilchat_activation_hook()
{
    require(__DIR__ . '/install.php');
}

/**
 * Register chat language files
 */
register_language_files(BABIL_CHAT_MODULE_NAME, ['chat']);

/**
 * Register new menu item in sidebar menu
 */
if (staff_can('view', BABIL_CHAT_MODULE_NAME)) {
    if (get_option('pusher_chat_enabled') == '1') {
        $CI->app_menu->add_sidebar_menu_item('babilchat', [
            'name'     => 'Chat',
            'href'     => admin_url('babilchat/Babilchat_Controller/chat_full_view'),
            'icon'     => 'fa fa-comments-o',
            'position' => 9,
        ]);
    }
}


/**
 * Hook for assigning staff permissions for chat
 *
 * @return void
 */
hooks()->add_action('admin_init', 'chat_register_staff_permissions');

function chat_register_staff_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'view' => _l('chat_grant_access_label'),
    ];

    register_staff_capabilities(BABIL_CHAT_MODULE_NAME, $capabilities, _l('chat_access_label'));
}


/**
 * Load the chat helper
 */
$CI->load->helper(BABIL_CHAT_MODULE_NAME . '/babilchat');
