<?php

namespace App\Controllers;

use App\Models\M_Class_Group;
use App\Models\M_School_Year;
use App\Models\M_Student;
use CodeIgniter\Exceptions\PageNotFoundException;

class Student extends BaseController
{
	protected $m_student;
	protected $m_class_group;
	protected $m_school_year;

	public function __construct()
	{
		$this->m_student = new M_Student();
		$this->m_class_group = new M_Class_Group();
		$this->m_school_year = new M_School_Year();
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

	public function show($username)
	{
		$result = $this->m_student->student_account($username);
		if (!$result) {
			throw new PageNotFoundException();
		}
		$whereIn = ['class' => [], 'year' => []];
		$history = json_decode($result->class_history);
		// dd(array_column($history, 'class'));
		foreach ($history as $v) {
			$whereIn['class'][] = "class_group_code = '$v->class'";
			$whereIn['year'][] = "school_year_id = '$v->year'";
		}
		$whereIn['class'] = implode(' OR ', $whereIn['class']);
		$whereIn['year'] = implode(' OR ', $whereIn['year']);

		$classgroup_history = $whereIn['class'] == null ? [] : $this->m_class_group->class_groups($whereIn['class']);
		$schoolyear_history = $whereIn['year'] == null ? [] : $this->m_school_year->school_years($whereIn['year']);

		$data = [
			"title" => "Detail Guru",
			"url_active" => "student",
			"data" => $result,
			"classgroup_history" => array_reverse($classgroup_history),
			"schoolyear_history" => array_reverse($schoolyear_history)
		];
		return view('detail_student', $data);
	}

	public function edit($username)
	{
		$result = $this->m_student->student_account($username);
		if (!$result) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Edit Guru",
			"url_active" => "student",
			"data" => $result,
			"class_group" => $this->m_class_group->class_group_data(['class_group_code' => $result->curr_class_group], '', 1, 0, 'class_name ASC, major_code ASC, unit_major ASC')
		];
		return view('edit_student', $data);
	}
}
