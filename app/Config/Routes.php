<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->get('/', 'Home::index');

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Contact Management Routes
 * --------------------------------------------------------------------
 */
// Contact web interface routes
$routes->get('/contacts', 'Contacts::index');
$routes->get('/contacts/create', 'Contacts::create');
$routes->post('/contacts/store', 'Contacts::store');
$routes->get('/contacts/edit/(:num)', 'Contacts::edit/$1');
$routes->post('/contacts/update/(:num)', 'Contacts::update/$1');
$routes->get('/contacts/delete/(:num)', 'Contacts::delete/$1');
$routes->post('/contacts/import', 'Contacts::import');
$routes->get('/contacts/export', 'Contacts::export');
$routes->get('/contacts/export/vcard', 'Contacts::exportVcard');
$routes->get('/contacts/export/pdf', 'Contacts::exportPdf');

// Auth routes
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/logout', 'Auth::logout');

// AI routes
$routes->get('/ai/duplicates', 'AI::duplicates');
$routes->match(['get','post'], '/ai/parse', 'AI::parse');

// Org routes
$routes->get('/org', 'Org::index');
$routes->match(['get','post'], '/org/create', 'Org::create');
$routes->get('/org/select/(:segment)', 'Org::select/$1');
$routes->get('/org/clear', 'Org::clear');

// Settings
$routes->get('/settings', 'Settings::index');
$routes->post('/settings', 'Settings::update');

// Default route redirect to contacts
$routes->get('/', 'Contacts::index');
