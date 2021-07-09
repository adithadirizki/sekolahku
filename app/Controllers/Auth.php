<?php

namespace App\Controllers;

class Auth extends BaseController
{
	public function login()
	{
		if (session()->has('hasLogin')) {
			return redirect()->to(base_url('dashboard'));
		}
		return view('login');
	}
}
