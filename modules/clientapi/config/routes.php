<?php

defined('BASEPATH') OR exit('No direct script access allowed');



$route['clientapi/delete/(:any)/(:num)'] = '$1/data/$2'; 

$route['clientapi/(:any)/search/(:any)'] = '$1/data_search/$2';

$route['clientapi/(:any)/search'] = '$1/data_search';

$route['clientapi/login/auth'] = 'login/login_api';

$route['clientapi/login/view'] = 'login/view';

$route['clientapi/login/key'] = 'login/api_key';

$route['clientapi/(:any)/(:num)'] = '$1/data/$2'; 

$route['clientapi/(:any)'] = '$1/data';

