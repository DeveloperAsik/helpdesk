<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//gobal router
$route['default_controller'] = 'auth/user';
$route['/'] = 'auth/user/index';
$route['login'] = 'auth/user/login';
$route['logout'] = 'auth/user/logout';
$route['helpdesk/login'] = 'auth/user/login';
$route['helpdesk/logout'] = 'auth/user/logout';
$route['auth-user'] = 'auth/user/check_data';

//frontend route
$route['dashboard'] = 'helpdesk/user/dashboard';
$route['ticket/(:any)'] = 'helpdesk/ticket/$1';
$route['ticket/(:any)/(:any)'] = 'helpdesk/ticket/$1/$2';
$route['my-profile'] = 'helpdesk/user/my_profile';
$route['my-inbox'] = 'helpdesk/user/my_inbox';
$route['my-task'] = 'helpdesk/user/my_task';
$route['my-notif'] = 'helpdesk/user/my_notif';
$route['lock-screen'] = 'helpdesk/user/lock_screen';
$route['unlock-screen'] = 'helpdesk/user/un_lock_screen';
$route['switch-lang'] = 'helpdesk/user/switch_lang';
$route['report/(:any)/(:any)'] = 'helpdesk/report/$1/$2';

//backend route
$route['backend'] = 'backend/prefferences/user/login';
$route['backend/auth-user'] = 'auth/user/check_data';
$route['backend/login'] = 'auth/user/login';
$route['backend/logout'] = 'auth/user/logout';
$route['backend/dashboard'] = 'backend/prefferences/user/dashboard';
$route['backend/my-profile'] = 'backend/prefferences/user/my_profile';
$route['backend/my-inbox'] = 'backend/prefferences/user/my_inbox';
$route['backend/my-task'] = 'backend/prefferences/user/my_task';
$route['backend/lock-screen'] = 'backend/prefferences/user/lock_screen';
$route['backend/unlock-screen'] = 'backend/prefferences/user/un_lock_screen';

//support route
$route['support'] = 'support/user/login';
$route['support/auth-user'] = 'auth/user/check_data';
$route['support/login'] = 'auth/user/login';
$route['support/logout'] = 'auth/user/logout';
$route['support/dashboard'] = 'support/user/dashboard';
$route['support/my-profile'] = 'support/user/my_profile';
$route['support/lock-screen'] = 'support/user/lock_screen';
$route['support/unlock-screen'] = 'support/user/un_lock_screen';

//monitor route
$route['monitor'] = 'auth/user/login';
$route['monitor/auth-user'] = 'auth/user/check_data';
$route['monitor/login'] = 'auth/user/login';
$route['monitor/logout'] = 'auth/user/logout';
$route['monitor/dashboard'] = 'monitor/user/dashboard';
$route['monitor/my-profile'] = 'monitor/user/my_profile';
$route['monitor/lock-screen'] = 'monitor/user/lock_screen';
$route['monitor/unlock-screen'] = 'monitor/user/un_lock_screen';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
