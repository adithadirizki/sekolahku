<?php

namespace App\Controllers;

use App\Models\M_Teacher;

class Teacher extends BaseController
{
	protected $m_teacher;

	public function __construct()
	{
		$this->m_teacher = new M_Teacher();
	}

	public function index()
	{
		$data = [
			"title" => "Guru",
			"url_active" => "teacher"
		];
		return view('teacher_list', $data);
	}

	public function get_teachers()
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
		$_POST['gender'] <> null ? $where['gender'] = $_POST['gender'] : null;
		$total_teacher = $this->m_teacher->total_teacher();
		$total_teacher_filtered = $this->m_teacher->total_teacher_filtered($where, $keyword);
		$teacher_data = $this->m_teacher->teacher_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_teacher,
			"recordsFiltered" => $total_teacher_filtered,
			"data" => $teacher_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}

	public function new()
	{
		$data = [
			"title" => "Tambah Guru",
			"url_active" => "teacher"
		];
		return view('add_teacher', $data);
	}
}
