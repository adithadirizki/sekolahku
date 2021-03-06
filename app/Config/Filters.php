<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' => \CodeIgniter\Filters\Honeypot::class,
		'cors'	  => \App\Filters\Cors::class,
		'apiauth'  => \App\Filters\APIAuth::class,
		'auth'	  => \App\Filters\Auth::class,
		'cookie'	  => \App\Filters\Cookie::class
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			'cors',
			'cookie',
			'auth' => ['except' => ['/', 'auth/*', 'api/*']],
			//'honeypot'
			'csrf' => ['except' => ['api/*']],
		],
		'after'  => [
			// 'toolbar',
			//'honeypot'
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
	public $filters = [
		'apiauth' => ['before' => ['api/*']]
	];
}
