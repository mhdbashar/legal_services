<?php

defined('BASEPATH') or exit('No direct script access allowed');

$route['finger_api/delete/(:any)/(:num)'] = '$1/data/$2';
$route['finger_api/(:any)/search/(:any)'] = '$1/data_search/$2';
$route['finger_api/(:any)/search']        = '$1/data_search';
$route['finger_api/login/auth']           = 'login/login_api';
$route['finger_api/login/view']           = 'login/view';
$route['finger_api/login/key']            = 'login/api_key';
$route['finger_api/(:any)/(:any)/(:num)'] = '$1/data/$2/$3';
$route['finger_api/(:any)/(:num)/(:num)'] = '$1/data/$2/$3';
$route['finger_api/custom_fields/(:any)/(:num)'] = 'custom_fields/data/$1/$2';
$route['finger_api/custom_fields/(:any)'] = 'custom_fields/data/$1';
$route['finger_api/(:any)/(:num)']        = '$1/data/$2';
$route['finger_api/(:any)']               = '$1/data';
