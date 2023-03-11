<?php
defined('BASEPATH') or exit('No direct script access allowed');

if(!$CI->db->table_exists(db_prefix() . 'si_custom_theme_list')) {
	$CI->db->query("CREATE TABLE `" . db_prefix() . "si_custom_theme_list` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`theme_name` VARCHAR(200) NOT NULL,
	`theme_style` text NOT NULL,
	`theme_type` VARCHAR(15) NOT NULL DEFAULT 'custom',
	`class` VARCHAR(200) NOT NULL DEFAULT 'bg-custom|bg-custom|bg-custom',
	`default_style` text NULL,
	`isdefault` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ";");
	
	$CI->db->query('INSERT INTO '.db_prefix() . 'si_custom_theme_list VALUES 
	(NULL, "Default", \'[]\', "default", "bg-default-theme-left|bg-default-theme-right|bg-default-theme-bottom",NULL, 1),
	(NULL, "Dark", \'[{"id":"admin-menu","color":"#232731"},{"id":"admin-menu-submenu-open","color":"#2f333e"},{"id":"admin-menu-links","color":"#ffffff"},{"id":"user-welcome-bg-color","color":"#2d3446"},{"id":"admin-menu-active-item","color":"#2d3446"},{"id":"admin-menu-active-item-color","color":"#c0c6d7"},{"id":"admin-menu-active-subitem","color":"#6c6c6f"},{"id":"admin-menu-submenu-links","color":"#c0c6d7"},{"id":"top-header","color":"#232731"},{"id":"customer-login-background","color":"#2d3446"},{"id":"customers-navigation","color":"#232731"},{"id":"customers-footer-background","color":"#6c6c6f"},{"id":"btn-default","color":"#2d3446"},{"id":"tabs-bg","color":"#2d3446"},{"id":"tabs-links","color":"#aba8ac"},{"id":"tabs-links-active-hover","color":"#1597e6"},{"id":"tabs-active-border","color":"#fbf6f6"},{"id":"modal-heading","color":"#232731"},{"id":"modal-body","color":"#2d3446"},{"id":"admin-login-background","color":"#2d3446"},{"id":"admin-page-background","color":"#2d3446"},{"id":"admin-page-text-color","color":"#fbf4f7"},{"id":"admin-inputs-background","color":"#2d3446"},{"id":"admin-panel-background","color":"#232731"},{"id":"admin-panel-color","color":"#03a9f4"},{"id":"table-headings","color":"#c0c6d7"},{"id":"table-items-heading","color":"#2a2e39"}]\', "default", "bg-gray-dark|bg-gray-dark|bg-gray-dark",NULL, 0),
	(NULL, "Blue", \'[{"id":"admin-menu","color":"#1e1e2d"},{"id":"admin-menu-submenu-open","color":"#d5e6ee"},{"id":"admin-menu-links","color":"#ffffff"},{"id":"admin-menu-active-item","color":"#03a9f4"},{"id":"admin-menu-active-item-color","color":"#fbf7f7"},{"id":"admin-menu-active-subitem","color":"#1e1e2d"},{"id":"admin-menu-submenu-links","color":"#03a9f4"},{"id":"top-header","color":"#18c2f7"},{"id":"customer-login-background","color":"#ffffff"},{"id":"customers-navigation","color":"#18c2f7"},{"id":"customers-footer-background","color":"#d5e6ee"},{"id":"customers-footer-text","color":"#3c3232"},{"id":"tabs-bg","color":"#d7e4eb"},{"id":"admin-login-background","color":"#66d0f1"},{"id":"admin-page-background","color":"#ffffff"},{"id":"admin-panel-background","color":"#e4ecf1"},{"id":"admin-panel-color","color":"#03a9f4"}]\', "default", "bg-info-dark|bg-info|bg-gray-dark",NULL, 0),
	(NULL, "Green", \'[{"id":"admin-menu","color":"#1e1e2d"},{"id":"admin-menu-submenu-open","color":"#dbe6e3"},{"id":"admin-menu-links","color":"#ffffff"},{"id":"user-welcome-bg-color","color":"#37bc9b"},{"id":"user-welcome-text-color","color":"#ffffff"},{"id":"admin-menu-active-item","color":"#37bc9b"},{"id":"admin-menu-active-item-color","color":"#fbf7f7"},{"id":"admin-menu-active-subitem","color":"#1e1e2d"},{"id":"admin-menu-submenu-links","color":"#2b957a"},{"id":"top-header","color":"#2b957a"},{"id":"top-header-links","color":"#ffffff"},{"id":"customer-login-background","color":"#e2eeeb"},{"id":"customers-navigation","color":"#37bc9b"},{"id":"customers-footer-background","color":"#d2f3eb"},{"id":"customers-footer-text","color":"#3c3232"},{"id":"btn-info","color":"#2b957a"},{"id":"tabs-links-active-hover","color":"#2b957a"},{"id":"tabs-active-border","color":"#2b957a"},{"id":"modal-heading","color":"#37bc9b"},{"id":"modal-heading-color","color":"#ffffff"},{"id":"admin-login-background","color":"#85c3b3"},{"id":"admin-page-background","color":"#e2eeeb"},{"id":"admin-panel-color","color":"#4e5855"}]\', "default", "bg-green-dark|bg-green|bg-gray-dark",NULL, 0),
	(NULL, "Purple", \'[{"id":"admin-menu","color":"#1e1e2d"},{"id":"admin-menu-submenu-open","color":"#dedbee"},{"id":"admin-menu-links","color":"#ffffff"},{"id":"user-welcome-bg-color","color":"#7266ba"},{"id":"user-welcome-text-color","color":"#ffffff"},{"id":"admin-menu-active-item","color":"#7266ba"},{"id":"admin-menu-active-item-color","color":"#fbf7f7"},{"id":"admin-menu-active-subitem","color":"#1e1e2d"},{"id":"admin-menu-submenu-links","color":"#564aa3"},{"id":"top-header","color":"#564aa3"},{"id":"top-header-links","color":"#ffffff"},{"id":"customer-login-background","color":"#dedbee"},{"id":"customers-navigation","color":"#7266ba"},{"id":"customers-footer-background","color":"#cbc4f3"},{"id":"customers-footer-text","color":"#3c3232"},{"id":"btn-info","color":"#564aa3"},{"id":"tabs-links-active-hover","color":"#564aa3"},{"id":"tabs-active-border","color":"#564aa3"},{"id":"modal-heading","color":"#7266ba"},{"id":"modal-heading-color","color":"#ffffff"},{"id":"admin-login-background","color":"#8278c3"},{"id":"admin-page-background","color":"#e4e2ee"},{"id":"admin-panel-color","color":"#564aa3"}]\', "default", "bg-purple-dark|bg-purple|bg-gray-dark",NULL, 0),
	(NULL, "Red", \'[{"id":"admin-menu","color":"#1e1e2d"},{"id":"admin-menu-submenu-open","color":"#f1e2e2"},{"id":"admin-menu-links","color":"#ffffff"},{"id":"user-welcome-bg-color","color":"#f66262"},{"id":"user-welcome-text-color","color":"#ffffff"},{"id":"admin-menu-active-item","color":"#f66262"},{"id":"admin-menu-active-item-color","color":"#fbf7f7"},{"id":"admin-menu-active-subitem","color":"#1e1e2d"},{"id":"admin-menu-submenu-links","color":"#f34a4a"},{"id":"top-header","color":"#f34a4a"},{"id":"top-header-links","color":"#ffffff"},{"id":"customer-login-background","color":"#f1e2e2"},{"id":"customers-navigation","color":"#f66262"},{"id":"customers-footer-background","color":"#f8cdcd"},{"id":"customers-footer-text","color":"#3c3232"},{"id":"btn-info","color":"#f34a4a"},{"id":"tabs-links-active-hover","color":"#f34a4a"},{"id":"tabs-active-border","color":"#f34a4a"},{"id":"modal-heading","color":"#f66262"},{"id":"modal-heading-color","color":"#ffffff"},{"id":"admin-login-background","color":"#fb7e7e"},{"id":"admin-page-background","color":"#f6e9e9"},{"id":"admin-panel-color","color":"#f34a4a"}]\',"default",  "bg-red-dark|bg-red|bg-gray-dark",NULL, 0),
	(NULL, "Orange", \'[{"id":"admin-menu","color":"#1e1e2d"},{"id":"admin-menu-submenu-open","color":"#fde5dc"},{"id":"admin-menu-links","color":"#ffffff"},{"id":"user-welcome-bg-color","color":"#fd5c23"},{"id":"user-welcome-text-color","color":"#ffffff"},{"id":"admin-menu-active-item","color":"#fd5c23"},{"id":"admin-menu-active-item-color","color":"#fbf7f7"},{"id":"admin-menu-active-subitem","color":"#1e1e2d"},{"id":"admin-menu-submenu-links","color":"#f34507"},{"id":"top-header","color":"#f34507"},{"id":"top-header-links","color":"#ffffff"},{"id":"customer-login-background","color":"#fde5dc"},{"id":"customers-navigation","color":"#fd5c23"},{"id":"customers-footer-background","color":"#f8c1ac"},{"id":"customers-footer-text","color":"#3c3232"},{"id":"btn-info","color":"#f34507"},{"id":"tabs-links-active-hover","color":"#f34507"},{"id":"tabs-active-border","color":"#f34507"},{"id":"modal-heading","color":"#fd5c23"},{"id":"modal-heading-color","color":"#ffffff"},{"id":"admin-login-background","color":"#fb906a"},{"id":"admin-page-background","color":"#fdece6"},{"id":"admin-panel-color","color":"#f34507"}]\', "default", "bg-orange-dark|bg-orange|bg-gray-dark",NULL, 0),
	(NULL, "Light Blue", \'[{"id":"admin-menu","color":"#ffffff"},{"id":"admin-menu-submenu-open","color":"#e4f4fb"},{"id":"admin-menu-links","color":"#252525"},{"id":"user-welcome-bg-color","color":"#ffffff"},{"id":"user-welcome-text-color","color":"#18c2f7"},{"id":"admin-menu-active-item","color":"#03a9f4"},{"id":"admin-menu-active-item-color","color":"#dae3e6"},{"id":"admin-menu-active-subitem","color":"#aee0f6"},{"id":"admin-menu-submenu-links","color":"#03a9f4"},{"id":"top-header","color":"#18c2f7"},{"id":"top-header-links","color":"#ffffff"},{"id":"customer-login-background","color":"#ffffff"},{"id":"customers-navigation","color":"#18c2f7"},{"id":"customers-footer-background","color":"#d5e6ee"},{"id":"customers-footer-text","color":"#3c3232"},{"id":"btn-info","color":"#18c2f7"},{"id":"admin-login-background","color":"#66d0f1"}]\', "default", "bg-info|bg-info-light|bg-white",NULL, 0),
	(NULL, "Light Green", \'[{"id":"admin-menu","color":"#ffffff"},{"id":"admin-menu-submenu-open","color":"#e4fbf4"},{"id":"admin-menu-links","color":"#252525"},{"id":"user-welcome-bg-color","color":"#ffffff"},{"id":"user-welcome-text-color","color":"#37bc9b"},{"id":"admin-menu-active-item","color":"#37bc9b"},{"id":"admin-menu-active-item-color","color":"#ffffff"},{"id":"admin-menu-active-subitem","color":"#bef1e2"},{"id":"admin-menu-submenu-links","color":"#2b957a"},{"id":"top-header","color":"#58ceb1"},{"id":"top-header-links","color":"#ffffff"},{"id":"customer-login-background","color":"#e2eeeb"},{"id":"customers-navigation","color":"#58ceb1"},{"id":"customers-footer-background","color":"#d2f3eb"},{"id":"customers-footer-text","color":"#3c3232"},{"id":"btn-info","color":"#37bc9b"},{"id":"tabs-links-active-hover","color":"#37bc9b"},{"id":"tabs-active-border","color":"#37bc9b"},{"id":"modal-heading","color":"#58ceb1"},{"id":"admin-login-background","color":"#85c3b3"},{"id":"admin-page-background","color":"#eef6f3"},{"id":"admin-panel-color","color":"#37bc9b"}]\', "default", "bg-green|bg-green-light|bg-white",NULL, 0),
	(NULL, "Light Purple", \'[{"id":"admin-menu","color":"#ffffff"},{"id":"admin-menu-submenu-open","color":"#efedff"},{"id":"admin-menu-links","color":"#252525"},{"id":"user-welcome-bg-color","color":"#ffffff"},{"id":"user-welcome-text-color","color":"#7266ba"},{"id":"admin-menu-active-item","color":"#7266ba"},{"id":"admin-menu-active-item-color","color":"#ffffff"},{"id":"admin-menu-active-subitem","color":"#c2bde6"},{"id":"admin-menu-submenu-links","color":"#564aa3"},{"id":"top-header","color":"#9289ca"},{"id":"top-header-links","color":"#ffffff"},{"id":"customer-login-background","color":"#dedbee"},{"id":"customers-navigation","color":"#9289ca"},{"id":"customers-footer-background","color":"#cbc4f3"},{"id":"customers-footer-text","color":"#3c3232"},{"id":"btn-info","color":"#7266ba"},{"id":"tabs-links-active-hover","color":"#7266ba"},{"id":"tabs-active-border","color":"#7266ba"},{"id":"modal-heading","color":"#9289ca"},{"id":"admin-login-background","color":"#8278c3"},{"id":"admin-page-background","color":"#f2f0fd"},{"id":"admin-panel-color","color":"#7266ba"}]\', "default", "bg-purple|bg-purple-light|bg-white",NULL, 0),
	(NULL, "Light Red", \'[{"id":"admin-menu","color":"#ffffff"},{"id":"admin-menu-submenu-open","color":"#f3ecec"},{"id":"admin-menu-links","color":"#252525"},{"id":"user-welcome-bg-color","color":"#ffffff"},{"id":"user-welcome-text-color","color":"#f66262"},{"id":"admin-menu-active-item","color":"#f66262"},{"id":"admin-menu-active-item-color","color":"#ffffff"},{"id":"admin-menu-active-subitem","color":"#f6d3d3"},{"id":"admin-menu-submenu-links","color":"#f34a4a"},{"id":"top-header","color":"#f47f7f"},{"id":"top-header-links","color":"#ffffff"},{"id":"customer-login-background","color":"#f1e2e2"},{"id":"customers-navigation","color":"#f47f7f"},{"id":"customers-footer-background","color":"#f8cdcd"},{"id":"customers-footer-text","color":"#3c3232"},{"id":"btn-info","color":"#f66262"},{"id":"tabs-links-active-hover","color":"#f66262"},{"id":"tabs-active-border","color":"#f66262"},{"id":"modal-heading","color":"#f47f7f"},{"id":"admin-login-background","color":"#fb7e7e"},{"id":"admin-page-background","color":"#fbf3f3"},{"id":"admin-panel-color","color":"#f66262"}]\',"default",  "bg-red|bg-red-light|bg-white",NULL, 0),
	(NULL, "Light Orange", \'[{"id":"admin-menu","color":"#ffffff"},{"id":"admin-menu-submenu-open","color":"#f1ebe9"},{"id":"admin-menu-links","color":"#252525"},{"id":"user-welcome-bg-color","color":"#ffffff"},{"id":"user-welcome-text-color","color":"#fd5c23"},{"id":"admin-menu-active-item","color":"#fd5c23"},{"id":"admin-menu-active-item-color","color":"#dae3e6"},{"id":"admin-menu-active-subitem","color":"#fbbaa3"},{"id":"admin-menu-submenu-links","color":"#f34507"},{"id":"top-header","color":"#fd8357"},{"id":"top-header-links","color":"#ffffff"},{"id":"customer-login-background","color":"#fbe0d6"},{"id":"customers-navigation","color":"#fd8357"},{"id":"customers-navigation-links","color":"#2a2329"},{"id":"customers-footer-background","color":"#fbbaa3"},{"id":"customers-footer-text","color":"#3c3232"},{"id":"btn-info","color":"#fd5c23"},{"id":"tabs-links-active-hover","color":"#f34507"},{"id":"tabs-active-border","color":"#f34507"},{"id":"modal-heading","color":"#fd8357"},{"id":"admin-login-background","color":"#fd8357"},{"id":"admin-page-background","color":"#ebe6e4"},{"id":"admin-panel-color","color":"#fd5c23"}]\', "default", "bg-orange|bg-orange-light|bg-white",NULL, 0),
	(NULL,
 "Dark Red New",
 \'[{"id":"admin-menu","color":"#bf0000"},
{"id":"admin-menu-submenu-open","color":"#f1e2e2"},
{"id":"admin-menu-links","color":"#ffffff"},
{"id":"user-welcome-bg-color","color":"#ff0000"},
{"id":"user-welcome-text-color","color":"#ffffff"},
{"id":"admin-menu-active-item","color":"#bf0000"},
{"id":"admin-menu-active-item-color","color":"#ffffff"},
{"id":"admin-menu-active-subitem","color":"#ffffff"},
{"id":"admin-menu-submenu-links","color":"#bf0000"},
{"id":"top-header","color":"#bf0000"},
{"id":"top-header-links","color":"#ffffff"},
{"id":"customer-login-background","color":"#ffffff"},
{"id":"customers-navigation","color":"#ff0909"},
{"id":"customers-footer-background","color":"#ff0909"},
{"id":"customers-footer-text","color":"#3c3232"},
{"id":"btn-info","color":"#bf0000"},
{"id":"tabs-links-active-hover","color":"#d90c63"},
{"id":"tabs-active-border","color":"#bf0000"},
{"id":"modal-heading","color":"#f66262"},
{"id":"modal-heading-color","color":"#ffffff"},
{"id":"admin-login-background","color":"#fb7e7e"},
{"id":"admin-page-background","color":"#f6e9e9"},
{"id":"admin-panel-color","color":"#bf0000"},
{"id":"table-headings","color":"#ffffff"},
{"id":"table-items-heading","color":"#bf0000"}]\',
 "default",  "bg-darkred-dark|bg-darkred|bg-gray-dark",NULL, 0),
 
 
 
 (NULL,
 "Dark Brown New",
  \'[{"id":"admin-menu","color":"#5e3030"},
{"id":"admin-menu-submenu-open","color":"#ffffff"},
{"id":"admin-menu-links","color":"#ffffff"},
{"id":"user-welcome-bg-color","color":"#5e3030"},
{"id":"user-welcome-text-color","color":"#ffffff"},
{"id":"admin-menu-active-item","color":"#784949"},
{"id":"admin-menu-active-item-color","color":"#fbf7f7"},
{"id":"admin-menu-active-subitem","color":"#5e3030"},
{"id":"admin-menu-submenu-links","color":"#ad8f8f"},
{"id":"top-header","color":"#5e3030"},
{"id":"top-header-links","color":"#ffffff"},
{"id":"customer-login-background","color":"#ffffff"},
{"id":"customers-navigation","color":"#5e3030"},
{"id":"customers-footer-background","color":"#7e0000"},
{"id":"customers-footer-text","color":"#ffffff"},
{"id":"btn-info","color":"#5e3030"},
{"id":"tabs-links-active-hover","color":"#ad3939"},
{"id":"tabs-active-border","color":"#ffffff"},
{"id":"modal-heading","color":"#5e3030"},
{"id":"modal-heading-color","color":"#ffffff"},
{"id":"text-muted","color":"#5c1b1b"},
{"id":"admin-login-background","color":"#5e3030"},
{"id":"admin-page-background","color":"#f6e9e9"},
{"id":"links-hover-focus","color":"#5b2929"},
{"id":"admin-panel-color","color":"#5e3030"},
{"id":"table-headings","color":"#3f2828"},
{"id":"table-items-heading","color":"#5e3030"}]\',
 "default",  "bg-darkedbrown-dark|bg-darkedbrown|bg-gray-dark",NULL, 0),
 
 
 
 (NULL,
 "Dark Gold New",
 \'[{"id":"admin-menu","color":"#b1976b"},
{"id":"admin-menu-submenu-open","color":"#ffffff"},
{"id":"admin-menu-links","color":"#ffffff"},
{"id":"user-welcome-bg-color","color":"#b1976b"},
{"id":"user-welcome-text-color","color":"#ffffff"},
{"id":"admin-menu-active-item","color":"#b1976b"},
{"id":"admin-menu-active-item-color","color":"#fbf7f7"},
{"id":"admin-menu-active-subitem","color":"#b1976b"},
{"id":"admin-menu-submenu-links","color":"#ad6d00"},
{"id":"top-header","color":"#b1976b"},
{"id":"top-header-links","color":"#ffffff"},
{"id":"customer-login-background","color":"#ffffff"},
{"id":"customers-navigation","color":"#b1976b"},
{"id":"customers-footer-background","color":"#b1750e"},
{"id":"customers-footer-text","color":"#3c3232"},
{"id":"btn-info","color":"#b1976b"},
{"id":"tabs-links-active-hover","color":"#b1976b"},
{"id":"tabs-active-border","color":"#ffffff"},
{"id":"modal-heading","color":"#b1976b"},
{"id":"modal-heading-color","color":"#ffffff"},
{"id":"admin-login-background","color":"#fb7e7e"},
{"id":"admin-page-background","color":"#e7d7bb"},
{"id":"admin-panel-color","color":"#b1976b"},
{"id":"table-headings","color":"#ffffff"},
{"id":"table-items-heading","color":"#b1976b"}]\', 
 "default",  "bg-darkedgold-dark|bg-darkedgold|bg-gray-dark",NULL, 0),
 
 
 
 (NULL,
 "Dark Gray New",
 \'[{"id":"admin-menu","color":"#3c3e62"},
{"id":"admin-menu-submenu-open","color":"#e8e8e8"},
{"id":"admin-menu-links","color":"#ffffff"},
{"id":"user-welcome-bg-color","color":"#acadaf"},
{"id":"user-welcome-text-color","color":"#ffffff"},
{"id":"admin-menu-active-item","color":"#3c3e62"},
{"id":"admin-menu-active-item-color","color":"#fbf7f7"},
{"id":"admin-menu-active-subitem","color":"#797b92"},
{"id":"admin-menu-submenu-links","color":"#343764"},
{"id":"top-header","color":"#3c3e62"},
{"id":"top-header-links","color":"#ffffff"},
{"id":"customer-login-background","color":"#ffffff"},
{"id":"customers-navigation","color":"#3c3e62"},
{"id":"customers-footer-background","color":"#0c0e25"},
{"id":"customers-footer-text","color":"#ffffff"},
{"id":"btn-info","color":"#3c3e62"},
{"id":"tabs-links-active-hover","color":"#7075d3"},
{"id":"tabs-active-border","color":"#3c3e62"},
{"id":"modal-heading","color":"#3c3e62"},
{"id":"modal-heading-color","color":"#ffffff"},
{"id":"admin-login-background","color":"#3c3e62"},
{"id":"admin-page-background","color":"#dbdbdf"},
{"id":"admin-panel-color","color":"#3c3e62"},
{"id":"table-headings","color":"#ffffff"},
{"id":"table-items-heading","color":"#3c3e62"}]\',
 "default",  "bg-darkedgray-dark|bg-darkedgray|bg-gray-dark",NULL, 0),
 
 
 
 
 (NULL,
 "Dark Green New",
   \'[{"id":"admin-menu","color":"#9dc02e"},
{"id":"admin-menu-submenu-open","color":"#eff6e9"},
{"id":"admin-menu-links","color":"#ffffff"},
{"id":"user-welcome-bg-color","color":"#698315"},
{"id":"user-welcome-text-color","color":"#ffffff"},
{"id":"admin-menu-active-item","color":"#698315"},
{"id":"admin-menu-active-item-color","color":"#fbf7f7"},
{"id":"admin-menu-active-subitem","color":"#698315"},
{"id":"admin-menu-submenu-links","color":"#9dc02e"},
{"id":"top-header","color":"#9dc02e"},
{"id":"top-header-links","color":"#ffffff"},
{"id":"customer-login-background","color":"#ffffff"},
{"id":"customers-navigation","color":"#9dc02e"},
{"id":"customers-footer-background","color":"#9dc02e"},
{"id":"customers-footer-text","color":"#628100"},
{"id":"btn-info","color":"#9dc02e"},
{"id":"btn-success","color":"#46cb37"},
{"id":"tabs-links-active-hover","color":"#9dc02e"},
{"id":"tabs-active-border","color":"#9dc02e"},
{"id":"modal-heading","color":"#9dc02e"},
{"id":"modal-heading-color","color":"#ffffff"},
{"id":"modal-body","color":"#ffffff"},
{"id":"admin-login-background","color":"#9dc02e"},
{"id":"admin-page-background","color":"#eff6e9"},
{"id":"admin-panel-color","color":"#9dc02e"},
{"id":"table-headings","color":"#ffffff"},
{"id":"table-items-heading","color":"#9dc02e"}]\',
 "default",  "bg-darkedgreen-dark|bg-darkedgreen|bg-gray-dark",NULL, 0),
 
 
 
 
  (NULL,
 "Dark Greenlight New",
   \'[{"id":"admin-menu","color":"#59aa9b"},
{"id":"admin-menu-submenu-open","color":"#eff6e9"},
{"id":"admin-menu-links","color":"#ffffff"},
{"id":"user-welcome-bg-color","color":"#5ebba6"},
{"id":"user-welcome-text-color","color":"#ffffff"},
{"id":"admin-menu-active-item","color":"#5ebba6"},
{"id":"admin-menu-active-item-color","color":"#fbf7f7"},
{"id":"admin-menu-active-subitem","color":"#5ebba6"},
{"id":"admin-menu-submenu-links","color":"#cdcb97"},
{"id":"top-header","color":"#ede5da"},
{"id":"top-header-links","color":"#ffffff"},
{"id":"customer-login-background","color":"#ffffff"},
{"id":"customers-navigation","color":"#9dc02e"},
{"id":"customers-footer-background","color":"#9dc02e"},
{"id":"customers-footer-text","color":"#628100"},
{"id":"btn-info","color":"#5ebba6"},
{"id":"btn-success","color":"#46cb37"},
{"id":"tabs-links-active-hover","color":"#5ebba6"},
{"id":"tabs-active-border","color":"#5ebba6"},
{"id":"modal-heading","color":"#5ebba6"},
{"id":"modal-heading-color","color":"#ffffff"},
{"id":"modal-body","color":"#ffffff"},
{"id":"admin-login-background","color":"##5ebba6"},
{"id":"admin-page-background","color":"#e3dbd0"},
{"id":"admin-panel-color","color":"#5ebba6"},
{"id":"table-headings","color":"#ffffff"},
{"id":"table-items-heading","color":"#5ebba6"}]\',
 "default",  "bg-darkedgreenlight-dark|bg-darkedgreenlight|bg-gray-dark",NULL, 0)
	
	
	
	
	
	
	
	');
	$CI->db->query('UPDATE tblsi_custom_theme_list SET default_style = theme_style');
}

add_option(SI_CUSTOM_THEME_MODULE_NAME.'_activated',1);
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_activation_code','fsdfsd');
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_default_theme', '1');
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_default_clients_theme', '1');
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_style', '[]');
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_custom_admin_area', '');
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_custom_clients_area', '');
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_custom_clients_and_admin_area', '');
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_bg_img_admin_login', '');
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_bg_img_customer_login', '');
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_bg_img_admin_menu', '');
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_bg_img_admin_pages', '');
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_bg_img_customer_pages', '');

##v-1.0.3
if(!$CI->db->table_exists(db_prefix() . 'si_custom_theme_staff')) {
	$CI->db->query("CREATE TABLE `" . db_prefix() . "si_custom_theme_staff` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`theme_id` int(11) NOT NULL DEFAULT '1',
	`staff_id` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ";");
}
if(!$CI->db->table_exists(db_prefix() . 'si_custom_theme_client')) {
	$CI->db->query("CREATE TABLE `" . db_prefix() . "si_custom_theme_client` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`theme_id` int(11) NOT NULL DEFAULT '1',
	`contact_id` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ";");
}
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_customer_login_header', 1); 
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_customer_login_footer', 1);
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_enable_staff_theme', 1);
add_option(SI_CUSTOM_THEME_MODULE_NAME.'_enable_client_theme', 1);
