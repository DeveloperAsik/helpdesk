<?php

defined('BASEPATH') OR exit('No direct script access allowed');
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $config['base_url'] = "http://{$_SERVER['HTTP_HOST']}/" . APPLICATION . '/';
    $config['app_url'] = "http://{$_SERVER['HTTP_HOST']}/" . APPLICATION . "/app/";
    $config['global_view_url'] = "http://{$_SERVER['HTTP_HOST']}/" . APPLICATION . "/app/public_views/";
    $config['app_modules_url'] = "{$config['app_url']}modules/";
    $config['base_helpdesk_url'] = "http://{$_SERVER['HTTP_HOST']}/" . APPLICATION . "/helpdesk/";
    $config['base_backend_url'] = "http://{$_SERVER['HTTP_HOST']}/" . APPLICATION . "/backend/";
    $config['base_vendor_url'] = "http://{$_SERVER['HTTP_HOST']}/" . APPLICATION . "/vendor/";
    $config['base_api_url'] = "http://{$_SERVER['HTTP_HOST']}/" . APPLICATION . "/api/";
} else {
    $config['base_url'] = "http://{$_SERVER['HTTP_HOST']}" . '/';
    $config['app_url'] = "http://{$_SERVER['HTTP_HOST']}/app/";
    $config['global_view_url'] = "http://{$_SERVER['HTTP_HOST']}/app/public_views/";
    $config['app_modules_url'] = "{$config['app_url']}modules/";
    $config['base_helpdesk_url'] = "http://{$_SERVER['HTTP_HOST']}/helpdesk/";
    $config['base_backend_url'] = "http://{$_SERVER['HTTP_HOST']}/backend/";
    $config['base_vendor_url'] = "http://{$_SERVER['HTTP_HOST']}/vendor/";
    $config['base_api_url'] = "http://{$_SERVER['HTTP_HOST']}/api/";
}
$config['static_url'] = $config['base_url'] . 'var/static/';
$config['modules_locations'] = array(APPPATH . 'modules/' => '../modules/');
$config['path'] = array(
    'dir.app_modules' => APPPATH . 'modules',
    'dir.ticket_file' => DOCUMENT_ROOT . '/var/static/tickets/',
    'dir.chat_file' => DOCUMENT_ROOT . '/var/static/chats/',
    'url.chat_file' => $config['static_url'] . 'chats/',
    'dir.user_logs' => DOCUMENT_ROOT . '/var/static/logs/users/',
    'url.user_logs' => $config['static_url'] . 'logs/users/',
    'dir.user_profile_img' => DOCUMENT_ROOT . '/var/static/images/user_profile/',
    'url.user_profile_img' => $config['static_url'] . 'images/user_profile/',    
    'dir.archive_file' => DOCUMENT_ROOT . '/var/static/archives/',
    'url.archive_file' => $config['static_url'] . 'archives/',
);

$config['index_page'] = '';
$config['uri_protocol'] = 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language'] = 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
$config['composer_autoload'] = FALSE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-=';
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';
$config['allow_get_array'] = TRUE;
$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['error_views_path'] = '';
$config['cache_path'] = 'app/cache/';
$config['cache_query_string'] = TRUE;
$config['encryption_key'] = 'ughwejbrfi98dsyuihsdf0sd89uipcko9i';
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 14400;
$config['sess_save_path'] = NULL;
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 14400;
$config['sess_regenerate_destroy'] = FALSE;
$config['cookie_prefix'] = '';
$config['cookie_domain'] = '';
$config['cookie_path'] = '/';
$config['cookie_secure'] = FALSE;
$config['cookie_httponly'] = FALSE;
$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = TRUE;
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 14400;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';
