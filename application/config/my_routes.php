<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Courts Managment
$route['admin/courts'] = 'admin/legalservices/courts/courts_managment';
$route['admin/judicial_control/(:num)'] = 'admin/legalservices/courts/judicial_managment/$1';
$route['admin/add_court'] = 'admin/legalservices/courts/add_new_court';
$route['admin/add_judicial/(:num)'] = 'admin/legalservices/courts/Add_new_judicial_department/$1';
$route['admin/delete_jud/(:num)/(:num)'] = 'admin/legalservices/courts/del_judicial/$1/$2';
$route['admin/delete_court/(:num)'] = 'admin/legalservices/courts/del_court/$1';
$route['admin/edit_court/(:num)'] = 'admin/legalservices/courts/edit_court_data/$1';
$route['admin/edit_judicial/(:num)/(:num)'] = 'admin/legalservices/courts/edit_judicial_data/$1/$2';
$route['admin/judicialByCourt/(:num)'] = 'admin/legalservices/courts/GetJudicialByCourtID/$1';

//Legal Services Managment
$route['admin/ServicesControl'] = 'admin/legalservices/legal_services/ShowLegalServices';
$route['admin/add_service'] = 'admin/legalservices/legal_services/AddNewServices';
$route['admin/delete_service/(:num)'] = 'admin/legalservices/legal_services/del_service/$1';
$route['admin/edit_service/(:num)'] = 'admin/legalservices/legal_services/edit_service_data/$1';
$route['admin/MkPrimary/(:num)'] = 'admin/legalservices/legal_services/PrimaryService/$1';
$route['admin/CategoryControl/(:num)'] = 'admin/legalservices/legal_services/CategoriesManagment/$1';
$route['admin/AddCategory/(:num)'] = 'admin/legalservices/legal_services/AddNewCategory/$1/';
$route['admin/delete_category/(:num)/(:num)'] = 'admin/legalservices/legal_services/del_category/$1/$2';
$route['admin/edit_category/(:num)/(:num)'] = 'admin/legalservices/legal_services/edit_category_data/$1/$2';
$route['admin/ChildCategory/(:num)/(:num)'] = 'admin/legalservices/legal_services/GetChildCat/$1/$2';
$route['admin/AddChildCat/(:num)/(:num)'] = 'admin/legalservices/legal_services/AddChildCategory/$1/$2';
$route['admin/Service/(:num)'] = 'admin/legalservices/legal_services/ViewSubService/$1';
$route['admin/imported_services'] = 'admin/legalservices/legal_services/ViewImportedService';

//Sub Services
$route['admin/SOther/view/(:num)/(:num)'] = 'admin/legalservices/other_services/view/$1/$2';
$route['admin/SOther/add/(:num)'] = 'admin/legalservices/other_services/add/$1';
$route['admin/SOther/edit/(:num)/(:num)'] = 'admin/legalservices/other_services/edit/$1/$2';
$route['admin/SOther/delete/(:num)/(:num)'] = 'admin/legalservices/other_services/delete/$1/$2';
//$route['admin/ServiceDetails/(:num)/(:num)'] = 'admin/legalservices/legal_services/ViewDetailsSubService/$1/$2';
// Imported Services
$route['admin/SImported/view/(:num)'] = 'admin/legalservices/imported_services/view/$1';

//Cases
$route['admin/Case/view/(:num)/(:num)'] = 'admin/legalservices/cases/view/$1/$2';
$route['admin/Case/add/(:num)'] = 'admin/legalservices/cases/add/$1';
$route['admin/Case/edit/(:num)/(:num)'] = 'admin/legalservices/cases/edit/$1/$2';
$route['admin/Case/delete/(:num)/(:num)'] = 'admin/legalservices/cases/delete/$1/$2';