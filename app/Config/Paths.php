<?php

namespace Config;

// Define ENVIRONMENT based on IP address from .env file
if (!defined('ENVIRONMENT')) {
    $envFile = __DIR__ . '/../../.env';
    $developmentIps = '';
    
    if (file_exists($envFile)) {
        $envContent = file_get_contents($envFile);
        if (preg_match('/^development\.ip\s*=\s*["\']?([^"\'\r\n]+)["\']?$/m', $envContent, $matches)) {
            $developmentIps = trim($matches[1]);
        }
    }
    
    if (!empty($developmentIps)) {
        $ip_arr = explode('||', $developmentIps);
        $ip_addr = $_SERVER['REMOTE_ADDR'] ?? '';
        define('ENVIRONMENT', in_array($ip_addr, $ip_arr) ? 'development' : 'production');
    } else {
        define('ENVIRONMENT', 'production');
    }
}

/**
 * Paths
 *
 * Holds the paths that are used by the system to
 * locate the main directories, app, system, etc.
 *
 * Modifying these allows you to restructure your application,
 * share a system folder between multiple applications, and more.
 *
 * All paths are relative to the project's root folder.
 */
class Paths
{
    /**
     * ---------------------------------------------------------------
     * SYSTEM FOLDER NAME
     * ---------------------------------------------------------------
     *
     * This must contain the name of your "system" folder. Include
     * the path if the folder is not in the same directory as this file.
     */
    public string $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';

    /**
     * ---------------------------------------------------------------
     * APPLICATION FOLDER NAME
     * ---------------------------------------------------------------
     *
     * If you want this front controller to use a different "app"
     * folder than the default one you can set its name here. The folder
     * can also be renamed or relocated anywhere on your server. If
     * you do, use a full server path.
     *
     * @see http://codeigniter.com/user_guide/general/managing_apps.html
     */
    public string $appDirectory = __DIR__ . '/..';

    /**
     * ---------------------------------------------------------------
     * WRITABLE DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of your "writable" directory.
     * The writable directory allows you to group all directories that
     * need write permission to a single place that can be tucked away
     * for maximum security, keeping it out of the app and/or
     * system directories.
     */
    public string $writableDirectory = __DIR__ . '/../../writable';

    /**
     * ---------------------------------------------------------------
     * TESTS DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of your "tests" directory.
     */
    public string $testsDirectory = __DIR__ . '/../../tests';

    /**
     * ---------------------------------------------------------------
     * VIEW DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of the directory that
     * contains the view files used by your application. By
     * default this is in `app/Views`. This value
     * is used when no value is provided to `Services::renderer()`.
     */
    public string $viewDirectory = __DIR__ . '/../Views';
}
