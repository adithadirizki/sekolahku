<?php

namespace App\Controllers;

use App\Models\M_Student;

class Student extends BaseController
{
	protected $m_student;

	public function __construct()
	{
		$this->m_student = new M_Student();
	}

	public function index()
	{
		$data = [
			"title" => "Siswa",
			"url_active" => "student"
		];
		return view('student_list', $data);
	}

	public function get_students()
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
		$total_student = $this->m_student->total_student();
		$total_student_filtered = $this->m_student->total_student_filtered($where, $keyword);
		$student_data = $this->m_student->student_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_student,
			"recordsFiltered" => $total_student_filtered,
			"data" => $student_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}

	public function new()
	{
		$data = [
			"title" => "Tambah Siswa",
			"url_active" => "student"
		];
		return view('add_student', $data);
	}
}
