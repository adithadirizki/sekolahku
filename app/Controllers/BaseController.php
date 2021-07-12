<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	use ResponseTrait;
	protected $helpers = [];
	public $jwt;
	public $username;
	public $role;

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
		
		$this->jwt = new \Firebase\JWT\JWT;
		if ($request->uri->getSegment(1) === 'api') {
			try {
				$this->token = $this->jwt::decode($_SERVER['HTTP_AUTHORIZATION'], $_ENV['JWT_PRIVATE_KEY'], ['HS256']);
				$this->username = $this->token->data->username;
				$this->role = $this->token->data->role;
			} catch (\Exception $e) {
				if ($e->getMessage() == 'Expired token') {
					session()->destroy();
				}
				return $this->failUnauthorized($e->getMessage());
			}
		} else {
			$this->username = session()->username;
			$this->role = session()->role;
		}
	}
}
