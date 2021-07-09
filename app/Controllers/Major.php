<?php

namespace App\Controllers;

use App\Models\M_Major;

class Major extends BaseController
{
	protected $m_major;

	public function __construct()
	{
		$this->m_major = new M_Major();
	}

	public function index()
	{
		$data = [
			"title" => "Jurusan",
			"url_active" => "major"
		];
		return view('major_list', $data);
	}

	public function get_majors()
	{
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
		$total_major = $this->m_major->total_major();
		$total_major_filtered = $this->m_major->total_major_filtered($where, $keyword);
		$major_data = $this->m_major->major_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_major,
			"recordsFiltered" => $total_major_filtered,
			"data" => $major_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}
}
