<?php

namespace Config;

/**
 * --------------------------------------------------------------------
 * Modules Configuration
 * --------------------------------------------------------------------
 *
 * This file defines the namespaces and locations of the modules
 * that are used by the application.
 */
class Modules
{
    /**
     * -------------------------------------------------------------------
     * Auto-Discover
     * -------------------------------------------------------------------
     *
     * If true, the system will automatically discover and load
     * all modules in the specified directories.
     */
    public $autoDiscover = true;

    /**
     * -------------------------------------------------------------------
     * Discover In Composer
     * -------------------------------------------------------------------
     *
     * If true, the system will also discover modules from Composer packages.
     */
    public $discoverInComposer = true;

    /**
     * -------------------------------------------------------------------
     * Composer Packages
     * -------------------------------------------------------------------
     *
     * An array of Composer package names that should be discovered.
     */
    public $composerPackages = [];

    /**
     * -------------------------------------------------------------------
     * Auto-Discover Paths
     * -------------------------------------------------------------------
     *
     * The paths to search for modules when auto-discovering.
     */
    public $autoDiscoverPaths = [
        APPPATH . 'Modules',
        ROOTPATH . 'Modules',
    ];

    /**
     * -------------------------------------------------------------------
     * Modules
     * -------------------------------------------------------------------
     *
     * The modules that are loaded by the application.
     * The key is the module name and the value is the path to the module.
     */
    public $modules = [];

    /**
     * -------------------------------------------------------------------
     * Should Discover
     * -------------------------------------------------------------------
     *
     * Returns whether the system should auto-discover modules.
     *
     * @return bool
     */
    public function shouldDiscover(): bool
    {
        return $this->autoDiscover;
    }
}
