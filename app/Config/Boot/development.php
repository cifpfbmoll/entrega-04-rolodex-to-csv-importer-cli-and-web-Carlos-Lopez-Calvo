<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

/*
 |--------------------------------------------------------------------------
 | ERROR DISPLAY
 |--------------------------------------------------------------------------
 | Don't show ANY in production environments. Instead, let the system catch
 | it and display a generic error message.
 */
ini_set('display_errors', '1');
error_reporting(E_ALL);

/*
 |--------------------------------------------------------------------------
 | DEBUG MODE
 |--------------------------------------------------------------------------
 | Debug mode is an experimental flag that can provide additional debugging
 | information throughout the framework.
 */
// Deshabilitar CI_DEBUG para evitar problemas con Debug Toolbar
defined('CI_DEBUG') || define('CI_DEBUG', false);

// Load helpers early to avoid namespace issues
if (file_exists(SYSTEMPATH . 'Helpers/array_helper.php')) {
    require_once SYSTEMPATH . 'Helpers/array_helper.php';
}
if (file_exists(SYSTEMPATH . 'Helpers/url_helper.php')) {
    require_once SYSTEMPATH . 'Helpers/url_helper.php';
}
if (file_exists(SYSTEMPATH . 'Helpers/filesystem_helper.php')) {
    require_once SYSTEMPATH . 'Helpers/filesystem_helper.php';
}

// Development bootstrap loaded successfully

