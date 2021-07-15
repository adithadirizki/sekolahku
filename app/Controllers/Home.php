<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

	public function logout()
	{
		setcookie('token', '', time() - 3600, '/');
		unset($_COOKIE['token']);
		session()->destroy();
		return redirect()->to(base_url('auth/login'));
	}
}
