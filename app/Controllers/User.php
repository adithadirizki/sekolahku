<?php

namespace App\Controllers;

use App\Models\M_User;
use CodeIgniter\Exceptions\PageNotFoundException;

class User extends BaseController
{
	protected $m_user;

	public function __construct()
	{
		$this->m_user = new M_User();
	}

	public function index()
	{
		if ($this->role != 'superadmin') {
			throw new PageNotFoundException();
		}
		
		$data = [
			"title" => "User",
			"url_active" => "user"
		];
		return view('user_list', $data);
	}

	public function get_users()
	{
		if ($this->role != 'superadmin') {
			throw new PageNotFoundException();
		}
		
		$limit = $_POST['length'];
		$offset = $_POST['start'];
		$keyword = $_POST['search']['value'];
		$orderby = [];
		$where = [];
		foreach ($_POST['order'] as $key => $value) {
			$field = $_POST['columns'][$value['column']]['data'];
			$dir = $value['dir'];
			array_push($orderby, "$field $dir");
		}
		$orderby = implode(',', $orderby);
		$_POST['is_active'] <> null ? $where['is_active'] = $_POST['is_active'] : null;
		$_POST['role'] <> null ? $where['role'] = $_POST['role'] : null;
		$total_user = $this->m_user->total_user();
		$total_user_filtered = $this->m_user->total_user_filtered($where, $keyword);
		$user_data = $this->m_user->user_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_user,
			"recordsFiltered" => $total_user_filtered,
			"data" => $user_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}
}
