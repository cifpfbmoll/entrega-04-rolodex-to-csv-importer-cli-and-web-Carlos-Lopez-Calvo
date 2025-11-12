<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2024, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    CodeIgniter
 * @author     CodeIgniter Dev Team
 * @copyright  2014 - 2024, British Columbia Institute of Technology (https://bcit.ca/)
 * @license    https://opensource.org/licenses/MIT	MIT License
 * @link       https://codeigniter.com
 * @since      Version 4.0.0
 * @filesource
 */

/*
 *---------------------------------------------------------------
 * CHECK PHP VERSION
 *---------------------------------------------------------------
 *
 * We need to make sure that the version of PHP being used is
 * compatible with the version of CodeIgniter that we are
 * running.
 */
$minPHPVersion = '7.4';
if (version_compare(PHP_VERSION, $minPHPVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPHPVersion,
        PHP_VERSION
    );

    exit($message);
}

/*
 *---------------------------------------------------------------
 * SET THE CURRENT DIRECTORY
 *---------------------------------------------------------------
 */
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 *
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// LOAD OUR PATHS CONFIG FILE
// This is the line that might need to be changed.
require FCPATH . '../app/Config/Paths.php';

// ^^^ Change this line if you move your application folder
$paths = new Config\Paths();

// Define path constants early (needed for .env loading and autoloader)
if (! defined('ROOTPATH')) {
    define('ROOTPATH', realpath(FCPATH . '../') . DIRECTORY_SEPARATOR);
}
if (! defined('APPPATH')) {
    define('APPPATH', realpath($paths->appDirectory) . DIRECTORY_SEPARATOR);
}
if (! defined('SYSTEMPATH')) {
    define('SYSTEMPATH', realpath($paths->systemDirectory) . DIRECTORY_SEPARATOR);
}

// Load .env manually to ensure ENVIRONMENT is available
if (file_exists(ROOTPATH . '.env')) {
    $envFile = file_get_contents(ROOTPATH . '.env');
    foreach (explode("\n", $envFile) as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            if ($key === 'CI_ENVIRONMENT') {
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
}

// Define ENVIRONMENT early to ensure it's available when loadEnvironmentBootstrap() is called
if (! defined('ENVIRONMENT')) {
    $env = $_ENV['CI_ENVIRONMENT'] ?? $_SERVER['CI_ENVIRONMENT'] ?? getenv('CI_ENVIRONMENT') ?: 'development';
    define('ENVIRONMENT', $env);
}

// Load Composer autoloader first (needed for CodeIgniter namespace)
if (file_exists(ROOTPATH . 'vendor/autoload.php')) {
    require_once ROOTPATH . 'vendor/autoload.php';
}

// Load Constants file (defines APP_NAMESPACE and other constants)
if (file_exists(APPPATH . 'Config/Constants.php')) {
    require APPPATH . 'Config/Constants.php';
}

// Define APP_NAMESPACE if not already defined
if (! defined('APP_NAMESPACE')) {
    define('APP_NAMESPACE', 'App');
}


// LOAD THE FRAMEWORK BOOT FILE (CodeIgniter 4.5+)
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'Boot.php';

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 *
 * Now that everything is setup, it's time to actually fire
 * up the engines and make this app do its thang.
 */
CodeIgniter\Boot::bootWeb($paths);
