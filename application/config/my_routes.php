<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Courts Managment
$route['admin/courts_control'] = 'admin/LegalServices/Courts_controller/courts_managment';
$route['admin/judicial_control/(:num)'] = 'admin/LegalServices/Courts_controller/judicial_managment/$1';
$route['admin/add_court'] = 'admin/LegalServices/Courts_controller/add_new_court';
$route['admin/add_judicial/(:num)'] = 'admin/LegalServices/Courts_controller/Add_new_judicial_department/$1';
$route['admin/delete_jud/(:num)/(:num)'] = 'admin/LegalServices/Courts_controller/del_judicial/$1/$2';
$route['admin/delete_court/(:num)'] = 'admin/LegalServices/Courts_controller/del_court/$1';
$route['admin/edit_court/(:num)'] = 'admin/LegalServices/Courts_controller/edit_court_data/$1';
$route['admin/edit_judicial/(:num)/(:num)'] = 'admin/LegalServices/Courts_controller/edit_judicial_data/$1/$2';
$route['admin/judicialByCourt/(:num)'] = 'admin/LegalServices/Courts_controller/GetJudicialByCourtID/$1';

//Legal Services Managment
$route['admin/ServicesControl'] = 'admin/LegalServices/LegalServices_controller/ShowLegalServices';
$route['admin/add_service'] = 'admin/LegalServices/LegalServices_controller/AddNewServices';
$route['admin/delete_service/(:num)'] = 'admin/LegalServices/LegalServices_controller/del_service/$1';
$route['admin/edit_service/(:num)'] = 'admin/LegalServices/LegalServices_controller/edit_service_data/$1';
$route['admin/MkPrimary/(:num)'] = 'admin/LegalServices/LegalServices_controller/PrimaryService/$1';
$route['admin/CategoryControl/(:num)'] = 'admin/LegalServices/LegalServices_controller/CategoriesManagment/$1';
$route['admin/AddCategory/(:num)'] = 'admin/LegalServices/LegalServices_controller/AddNewCategory/$1/';
$route['admin/delete_category/(:num)/(:num)'] = 'admin/LegalServices/LegalServices_controller/del_category/$1/$2';
$route['admin/edit_category/(:num)/(:num)'] = 'admin/LegalServices/LegalServices_controller/edit_category_data/$1/$2';
$route['admin/ChildCategory/(:num)/(:num)'] = 'admin/LegalServices/LegalServices_controller/GetChildCat/$1/$2';
$route['admin/AddChildCat/(:num)/(:num)'] = 'admin/LegalServices/LegalServices_controller/AddChildCategory/$1/$2';
$route['admin/Service/(:num)'] = 'admin/LegalServices/LegalServices_controller/ViewSubService/$1';
$route['admin/imported_services'] = 'admin/LegalServices/LegalServices_controller/ViewImportedService';

//Sub Services
$route['admin/SOther/view/(:num)/(:num)'] = 'admin/LegalServices/Other_services_controller/view/$1/$2';
$route['admin/SOther/add/(:num)'] = 'admin/LegalServices/Other_services_controller/add/$1';
$route['admin/SOther/edit/(:num)/(:num)'] = 'admin/LegalServices/Other_services_controller/edit/$1/$2';
$route['admin/SOther/delete/(:num)/(:num)'] = 'admin/LegalServices/Other_services_controller/delete/$1/$2';
//$route['admin/ServiceDetails/(:num)/(:num)'] = 'admin/LegalServices/LegalServices_controller/ViewDetailsSubService/$1/$2';

//Cases
$route['admin/Case/view/(:num)/(:num)'] = 'admin/LegalServices/Cases_controller/view/$1/$2';
$route['admin/Case/add/(:num)'] = 'admin/LegalServices/Cases_controller/add/$1';
$route['admin/Case/edit/(:num)/(:num)'] = 'admin/LegalServices/Cases_controller/edit/$1/$2';
$route['admin/Case/delete/(:num)/(:num)'] = 'admin/LegalServices/Cases_controller/delete/$1/$2';