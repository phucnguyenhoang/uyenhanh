<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] 					= 'home';
$route['404_override'] 							= '';
$route['translate_uri_dashes'] 					= FALSE;

$route['orders/is-exist'] 						= 'Orders/isExist';
$route['orders/add-product'] 					= 'Orders/addProduct';
$route['orders/view-product/(:num)']			= 'Orders/viewProduct/$1';
$route['orders/edit-product/(:num)']			= 'Orders/editProduct/$1';
$route['orders/(:num)/delete/(:num)'] 			= 'Orders/deleteProduct/$1/$2';

$route['quotations/add-product']				= 'Quotations/addProduct';
$route['quotations/view-product/(:num)']		= 'Quotations/viewProduct/$1';
$route['quotations/edit-product/(:num)']		= 'Quotations/editProduct/$1';
$route['quotations/(:num)/delete/(:num)'] 		= 'Quotations/deleteProduct/$1/$2';
//$route['exports/(:any)']						= 'Exports/index/$1';
