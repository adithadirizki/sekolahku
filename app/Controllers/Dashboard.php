<?php namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
		$data = [
			"title" => "Dashboard",
			"url_active" => "dashboard"
		];
		return view('dashboard', $data);
	}
}
