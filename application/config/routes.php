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
$route['default_controller'] = 'device';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// global device section
$route['device/'] = 'device';
$route['device/add'] = 'device/add';
$route['device/edit/(:num)'] = 'device/edit/$1';
$route['device/delete/(:num)'] = 'device/delete/$1';

// device interfaces operations
$route['device/initial/(:num)'] = 'device/initial/$1';
$route['device/edit/(:num)/interface/(:num)'] = 'device/edit_interface/$2';
$route['device/view/(:num)/interface/(:num)'] = 'device/view_interface/$2';

// ONT search
$route['search'] = 'device/search/';

// ONT find new
$route['device/unregistered/(:num)'] = 'device/unregistered/$1';
// ONT register
$route['device/register/'] = 'device/register';
// ONT unregister
$route['device/unregister/(:num)'] = 'device/unregister/$1';
// ONT view all registered
$route['device/registered/(:num)'] = 'device/registered/$1';

// ONT info
$route['device/view_ont/(:num)'] = 'device/view_ont/$1';
$route['device/view_ont_iface/(:num)/(:num)/(:num)'] = 'device/view_ont_iface/$1/$2/$3';
// Autorization
$route['auth'] = 'auth/index';

