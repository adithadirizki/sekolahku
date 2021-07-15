<?php namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
		$data = [
			"title" => "Dashboard",
			"url_active" => "dashboard"
		];
		if ($this->role == 'superadmin') {
			return view('dashboard', $data);
			
		} elseif ($this->role == 'student') {
			return view('student/dashboard', $data);
		}
	}
}
