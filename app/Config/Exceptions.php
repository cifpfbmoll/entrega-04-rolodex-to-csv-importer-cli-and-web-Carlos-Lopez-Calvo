<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Exception & Error Handling Configuration
 */
class Exceptions extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * LOG EXCEPTIONS?
     * --------------------------------------------------------------------------
     * If true, then exceptions will be logged
     * through Services::Log.
     *
     * Default: true
     */
    public bool $log = true;

    /**
     * --------------------------------------------------------------------------
     * DO NOT LOG STATUS CODES
     * --------------------------------------------------------------------------
     * Any status codes here will NOT be logged if logging is turned on.
     * By default, only 404 (Page Not Found) exceptions are ignored.
     */
    public array $ignoreCodes = [404];

    /**
     * --------------------------------------------------------------------------
     * Error Views Path
     * --------------------------------------------------------------------------
     * This is the path to the directory that contains the 'cli' and 'html'
     * subdirectories that hold the views used to generate errors.
     *
     * This path constant may be changed from within the app/Config/Paths.php file.
     */
    public string $errorViewPath = APPPATH . 'Views/errors/';

    /**
     * --------------------------------------------------------------------------
     * HIDE FROM DEBUG TRACE
     * --------------------------------------------------------------------------
     * Any data that you would like to hide from the debug trace.
     * In order to specify 2 levels, use "/" to separate.
     * ex. ['server', 'setup/password', 'secret_token']
     */
    public array $sensitiveDataInTrace = [];

    /**
     * --------------------------------------------------------------------------
     * LOG DEPRECATIONS
     * --------------------------------------------------------------------------
     */
    public bool $logDeprecations = false;

    /**
     * --------------------------------------------------------------------------
     * DEPRECATION LOG LEVEL
     * --------------------------------------------------------------------------
     */
    public string $deprecationLogLevel = 'WARNING';
}

