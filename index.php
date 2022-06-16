<?php
require_once 'var/vendor/orenoframework/orenoframework.php';
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');
switch (ENVIRONMENT) {
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;

    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>=')) {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
        break;

    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}

$system_path = 'system';
$dbpath = 'db';
$application_folder = 'app';
$view_folder = 'app/public_views';

// Set the current directory correctly for CLI requests
if (defined('STDIN')) {
    chdir(dirname(__FILE__));
}
if (($_temp = realpath($system_path)) !== FALSE) {
    $system_path = $_temp . DS;
} else {
    // Ensure there's a trailing slash
    $system_path = strtr(rtrim($system_path, '/\\'), '/\\', DS . DS) . DS;
}
// Is the system path correct?
if (!is_dir($system_path)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
    exit(3); // EXIT_CONFIG
}

if (($_temp = realpath($dbpath)) !== FALSE) {
    $dbpath = $_temp . DS;
} else {
    // Ensure there's a trailing slash
    $dbpath = strtr(rtrim($dbpath, '/\\'), '/\\', DS . DS) . DS;
}
// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

//db path
define('DBPATH', $dbpath);

// Path to the system directory
define('BASEPATH', $system_path);

// Path to the front controller (this file) directory
define('FCPATH', dirname(__FILE__) . DS);

// Name of the "system" directory
define('SYSDIR', basename(BASEPATH));

// The path to the "application" directory
if (is_dir($application_folder)) {
    if (($_temp = realpath($application_folder)) !== FALSE) {
        $application_folder = $_temp;
    } else {
        $application_folder = strtr(
                rtrim($application_folder, '/\\'), '/\\', DS . DS
        );
    }
} elseif (is_dir(BASEPATH . $application_folder . DS)) {
    $application_folder = BASEPATH . strtr(
                    trim($application_folder, '/\\'), '/\\', DS . DS
    );
} else {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
    exit(3); // EXIT_CONFIG
}

define('APPPATH', $application_folder . DS);

// The path to the "views" directory
if (!isset($view_folder[0]) && is_dir(APPPATH . 'views' . DS)) {
    $view_folder = APPPATH . 'views';
} elseif (is_dir($view_folder)) {
    if (($_temp = realpath($view_folder)) !== FALSE) {
        $view_folder = $_temp;
    } else {
        $view_folder = strtr(
                rtrim($view_folder, '/\\'), '/\\', DS . DS
        );
    }
} elseif (is_dir(APPPATH . $view_folder . DS)) {
    $view_folder = APPPATH . strtr(
                    trim($view_folder, '/\\'), '/\\', DS . DS
    );
} else {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: ' . SELF;
    exit(3); // EXIT_CONFIG
}

define('VIEWPATH', $view_folder . DS);

require_once BASEPATH . 'core/CodeIgniter.php';
