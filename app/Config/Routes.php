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

$routes->resource('teacher', ['only' => ['show', 'new', 'edit']]);
$routes->resource('student', ['only' => ['show', 'new', 'edit']]);

$routes->resource('question');
$routes->resource('bankquestion', ['only' => ['show'], 'placeholder' => '(:num)']);
$routes->get('bankquestion/(:num)/question/add', 'Bankquestion::add_question/$1');
$routes->get('bankquestion/(:num)/question/new', 'Bankquestion::new_question/$1');

$routes->resource('assignment', ['only' => ['show', 'new', 'edit'], 'placeholder' => '(:alphanum)']);

$routes->get('quiz/(:alphanum)/question/add', 'Quiz::add_question/$1');
$routes->get('quiz/(:alphanum)/question/new', 'Quiz::new_question/$1');
$routes->resource('quiz', ['only' => ['show', 'new', 'edit'], 'placeholder' => '(:alphanum)']);

$routes->resource('material', ['only' => ['show', 'new', 'edit'], 'placeholder' => '(:alphanum)']);
$routes->resource('announcement', ['only' => ['show', 'new', 'edit'], 'placeholder' => '(:num)']);

$routes->group('api', ['namespace' => 'App\Controllers\API'], function ($routes) {
	// $routes->post('auth/login', 'Auth::login'); // for webserver
	$routes->post('teacher', 'User::create_teacher');
	$routes->post('student', 'User::create_student');
	$routes->post('teacher/(:alphanum)', 'User::update_teacher/$1');
	$routes->post('student/(:alphanum)', 'User::update_student/$1');
	$routes->delete('user/(:alphanum)', 'User::delete/$1');

	$routes->resource('classgroup');
	$routes->resource('classes');
	$routes->resource('major');
	$routes->resource('schoolyear');
	$routes->resource('subject');
	$routes->resource('question');

	$routes->put('bankquestion/(:num)/question', 'Bankquestion::add_question/$1');
	$routes->post('bankquestion/(:num)/question', 'Bankquestion::create_question/$1');
	$routes->post('bankquestion/(:num)/question/(:num)', 'Bankquestion::show_question/$1/$2');
	$routes->delete('bankquestion/(:num)/question/(:num)', 'Bankquestion::delete_question/$1/$2');
	$routes->resource('bankquestion');

	$routes->post('assignment/(:alphanum)/copy', 'Assignment::copy/$1');
	$routes->resource('assignment', ['only' => ['create', 'update', 'delete'], 'placeholder' => '(:alphanum)']);

	$routes->post('quiz/(:alphanum)/copy', 'Quiz::copy/$1');
	$routes->put('quiz/(:alphanum)/question', 'Quiz::add_question/$1');
	$routes->post('quiz/(:alphanum)/question', 'Quiz::create_question/$1');
	$routes->post('quiz/(:alphanum)/question/(:num)', 'Quiz::show_question/$1/$2');
	$routes->delete('quiz/(:alphanum)/question/(:num)', 'Quiz::delete_question/$1/$2');
	$routes->resource('quiz', ['only' => ['create', 'update', 'delete'], 'placeholder' => '(:alphanum)']);

	$routes->post('material/(:alphanum)/copy', 'Material::copy/$1');
	$routes->resource('material', ['only' => ['create', 'update', 'delete'], 'placeholder' => '(:alphanum)']);
	
	$routes->resource('announcement', ['only' => ['create', 'update', 'delete'], 'placeholder' => '(:num)']);
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
