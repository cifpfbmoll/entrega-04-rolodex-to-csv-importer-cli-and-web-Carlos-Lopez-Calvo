<?php

namespace Config;

use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /**
     * Override buildServicesCache to handle case where autoloader
     * namespace is not yet available
     */
    protected static function buildServicesCache(): void
    {
        if (! static::$discovered) {
            if ((new Modules())->shouldDiscover('services')) {
                $locator = static::locator();
                $files   = $locator->search('Config/Services');

                $autoloader = static::autoloader();
                $namespaces = $autoloader->getNamespace('CodeIgniter');
                
                // Handle case where namespace is not yet available
                if (empty($namespaces) || !isset($namespaces[0])) {
                    // Skip building cache if autoloader is not ready
                    return;
                }
                
                $systemPath = $namespaces[0];

                // Get instances of all service classes and cache them locally.
                foreach ($files as $file) {
                    // Does not search `CodeIgniter` namespace to prevent from loading twice.
                    if (str_starts_with($file, $systemPath)) {
                        continue;
                    }

                    $classname = $locator->findQualifiedNameFromPath($file);

                    if ($classname === false) {
                        continue;
                    }

                    if (! class_exists($classname)) {
                        continue;
                    }

                    static::$services[$classname] = new $classname();
                }
            }

            static::$discovered = true;
        }
    }
    
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */
}
