<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
// $routes->post('api/user/account/create', 'API\User::create_account');
$routes->resource('question');
$routes->get('bankquestion/(:num)/question/add', 'Bankquestion::add_question/$1');
$routes->get('bankquestion/(:num)/question/new', 'Bankquestion::new_question/$1');
$routes->resource('bankquestion', ['only' => ['show']]);
$routes->group('api', ['namespace' => 'App\Controllers\API'], function ($routes) {
	// $routes->post('auth/login', 'Auth::login'); // for webserver
	$routes->resource('classgroup');
	$routes->resource('classes');
	$routes->resource('major');
	$routes->resource('schoolyear');
	$routes->resource('subject');
	$routes->resource('question');
	$routes->post('bankquestion/(:num)/question', 'Bankquestion::create_question/$1');
	$routes->post('bankquestion/(:num)/question/(:num)', 'Bankquestion::show_question/$1/$2');
	$routes->delete('bankquestion/(:num)/question/(:num)', 'Bankquestion::delete_question/$1/$2');
	$routes->resource('bankquestion');
});
// $routes->resource('api/classes', ['controller' => 'API\Classes']);

/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
