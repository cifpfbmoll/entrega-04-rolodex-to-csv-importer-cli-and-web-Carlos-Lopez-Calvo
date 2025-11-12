<?php

namespace Config;

/**
 * Paths
 *
 * Provides a location-aware configuration of the
 * directories used by the application.
 */
class Paths
{
    /**
     * ---------------------------------------------------------------
     * SYSTEM DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of your "system" directory.
     * By default the system directory is located in your project root.
     */
    public $systemDirectory;

    /**
     * ---------------------------------------------------------------
     * APPLICATION DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * If you want this front controller to use a different "app"
     * folder than the default one you can set its name here. The folder
     * can also be renamed or relocated anywhere on your server.
     * For more info please see the user guide:
     * https://codeigniter.com/user_guide/general/managing_apps.html
     */
    public $appDirectory;

    /**
     * ---------------------------------------------------------------
     * WRITABLE DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of your "writable" directory.
     * By default the "writable" directory is located inside your
     * application directory.
     */
    public $writableDirectory;

    /**
     * ---------------------------------------------------------------
     * TESTS DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of your "tests" directory.
     * By default the "tests" directory is located inside your
     * application directory.
     */
    public $testsDirectory;

    /**
     * ---------------------------------------------------------------
     * VIEW DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of the directory that
     * contains the view files used by your application. By default
     * this is in "app/Views". This value is used by the core View
     * class when locating view files.
     */
    public $viewDirectory;

    /**
     * ---------------------------------------------------------------
     * HAMMER DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of the directory that
     * contains the "hammer" command line utility.
     */
    public $hammerDirectory;

    /**
     * ---------------------------------------------------------------
     * NAMESPACE ROOT DIRECTORY NAME
     * ---------------------------------------------------------------
     *
     * This variable must contain the name of the directory that
     * contains the "namespace root directory". By default this is
     * the "src" directory.
     */
    public $namespaceRootDirectory;

    public function __construct()
    {
        $this->appDirectory = realpath(__DIR__ . '/../../app') ?: __DIR__ . '/../../app';
        $this->systemDirectory = realpath(__DIR__ . '/../../vendor/codeigniter4/framework/system') ?: __DIR__ . '/../../vendor/codeigniter4/framework/system';
        $this->writableDirectory = realpath(__DIR__ . '/../../writable') ?: __DIR__ . '/../../writable';
        $this->testsDirectory = realpath(__DIR__ . '/../../tests') ?: __DIR__ . '/../../tests';
        $this->viewDirectory = realpath(__DIR__ . '/../../app/Views') ?: __DIR__ . '/../../app/Views';
        $this->hammerDirectory = realpath(__DIR__ . '/../../vendor/codeigniter4/framework') ?: __DIR__ . '/../../vendor/codeigniter4/framework';
        $this->namespaceRootDirectory = realpath(__DIR__ . '/../../src') ?: __DIR__ . '/../../src';
    }
}
