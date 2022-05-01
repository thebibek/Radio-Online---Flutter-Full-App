<?php
defined('BASEPATH') || exit('No direct script access allowed');

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

$route['default_controller'] = 'Login';
$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;

/*********** USER DEFINED ROUTES FOR ADMIN PANEL *******************/
$route['loginMe'] = 'Login/loginMe';

$route['profile'] ='Dashboard/profile';

$route['resetpassword'] = 'Dashboard/resetpassword';
$route['checkOldPass'] = 'Dashboard/checkOldPass';

$route['logout'] = 'Dashboard/logout';

$route['Dashboard'] = 'Dashboard';

$route['category'] = 'Dashboard/category';

$route['city'] = 'Dashboard/city';

$route['radio_station'] = 'Dashboard/radio_station';

$route['radio_station_report'] ='Dashboard/radio_station_report';

$route['send_notifications'] ='Dashboard/send_notifications';

$route['system_configurations'] = 'Dashboard/system_configurations';

$route['notification_settings'] ='Dashboard/notification_settings';

$route['about_us'] ='Dashboard/about_us';
$route['play_store_about_us'] ='Dashboard/play_store_about_us';

$route['privacy_policy'] ='Dashboard/privacy_policy';
$route['play_store_privacy_policy'] ='Dashboard/play_store_privacy_policy';

$route['terms_conditions'] ='Dashboard/terms_conditions';
$route['play_store_terms_conditions'] ='Dashboard/play_store_terms_conditions';

$route['slider'] ='Dashboard/slider';