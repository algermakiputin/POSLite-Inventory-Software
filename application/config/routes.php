<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['installer'] = "InstallerController/install";
$route['backups'] = "BackupController/index";

$route['upgrade'] = "AppController/upgrade";

$route['preference'] = "SettingsController/preference";

$route['supplier/po'] = "PurchaseOrderController/purchase_order";
$route['purchase-orders'] = "PurchaseOrderController/purchase_order_list";
$route['po/view/(:any)'] = "PurchaseOrderController/view/$1";

$route['credits'] = "TransactionsController/index";
$route['credit/view/(:any)'] = "TransactionsController/view_credit/$1";
$route['credit/destroy/(:any)'] = "TransactionsController/destroy_credit/$1";

$route['invoice'] = "TransactionsController/invoice";
$route['invoice/view/(:any)'] = "TransactionsController/view_invoice/$1";
$route['invoice/destroy/(:any)'] = "TransactionsController/destroy_invoice/$1"; 

$route['standby-orders'] = "TransactionsController/standby_order";
$route['standby-order/view/(:any)'] = "TransactionsController/view_standby_order/$1";
$route['standby-order/destroy/(:any)'] = "TransactionsController/destroy_standby_order/$1"; 

$route['transactions'] = "TransactionsController/index";
$route['credit/view/(:any)'] = "TransactionsController/view_credit/$1";
$route['credit/destroy/(:any)'] = "TransactionsController/destroy_credit/$1";

$route['payments/new/(:any)'] = "PaymentsController/add_payment/$1";



$route['expenses'] = "ExpensesController/index";
$route['expenses/new'] = "ExpensesController/new";
$route['expenses/insert'] = "ExpensesController/insert";
$route['expenses/reports'] = "ExpensesController/reports";

$route['default_controller'] = 'AuthController/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['test'] = 'AuthController/test';

$route['accounting'] = "AccountingController/index";

$route['reports'] = "ReportsController/index";
$route['reports/products'] = "ReportsController/products";
$route['reports/category'] = "ReportsController/category";
$route['reports/summary'] = "ReportsController/summary";
$route['reports/best-seller'] = "ReportsController/best_seller";

$route['sales'] = 'SalesController/sales';
$route['sales/report'] ='SalesController/reports';
$route['sales/graph-filter'] = 'SalesController/graphFilter';

$route['items'] = 'ItemController/items';
$route['items/new'] = 'ItemController/new';
$route['items/insert'] = 'ItemController/insert';
$route['items/stock-in/(:any)'] = 'ItemController/stock_in/$1';
$route['items/update'] = "ItemController/update";
$route['items/data'] = "ItemController/data";
$route['items/edit/(:any)'] = "ItemController/edit/$1";
$route['items/find'] = "ItemController/find";
$route['items/delete'] = "ItemController/delete";

$route['categories'] = 'CategoriesController/categories';
$route['categories/insert'] = 'CategoriesController/insert';
$route['users'] = 'UsersController/accounts';
$route['user/edit/(:any)'] = 'UsersController/edit/$1';
$route['logout'] = 'AuthController/logout';
$route['users/history'] = 'UsersController/history';
$route['pos'] = 'pos_con/pos';

$route['categories/get'] = 'CategoriesController/get';

$route['customers'] = "CustomersController/index";
$route['customers/insert'] = "CustomersController/insert";
$route['customers/delete/(:any)'] = "CustomersController/destroy/$1";
$route['customers/open/(:any)'] = "CustomersController/open/$1";
$route['customers/find'] = "CustomersController/find";
$route['customers/update'] = "CustomersController/update";
$route['customers/open-membership'] = "CustomersController/openMembership";

$route['suppliers'] = "SuppliersController/index";
$route['suppliers/insert'] = "SuppliersController/insert";
$route['suppliers/delete/(:any)'] = "SuppliersController/destroy/$1";
$route['suppliers/find'] = "SuppliersController/find";
$route['suppliers/update'] = "SuppliersController/update";
$route['out-of-stocks'] = "ItemController/outOfStocks";

$route['deliveries'] = "DeliveriesController/index";
$route['deliveries/details/(:any)'] = "DeliveriesController/details/$1";
$route['new-delivery'] = "DeliveriesController/new";
$route['delivery/insert'] = "DeliveriesController/insert";
$route['license'] = "LicenseController/index";

$route['activate'] = 'LicenseController/activate';
$route['users'] = "UsersController/users";

$route['login'] = 'AuthController/login';
