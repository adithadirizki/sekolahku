<?php

namespace App\Controllers;

use App\Models\M_Class_Group;
use App\Models\M_Subject;
use App\Models\M_Teacher;
use CodeIgniter\Exceptions\PageNotFoundException;

class Teacher extends BaseController
{
	protected $m_teacher;
	protected $m_class_group;
	protected $m_subject;

	public function __construct()
	{
		$this->m_teacher = new M_Teacher();
		$this->m_class_group = new M_Class_Group();
		$this->m_subject = new M_Subject();
	}

	public function index()
	{
		if ($this->role != 'superadmin') {
			throw new PageNotFoundException();
		}
		
		$data = [
			"title" => "Guru",
			"url_active" => "teacher"
		];
		return view('teacher_list', $data);
	}

	public function get_teachers()
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
		if ($this->role != 'superadmin') {
			throw new PageNotFoundException();
		}
		
		$data = [
			"title" => "Tambah Guru",
			"url_active" => "teacher"
		];
		return view('add_teacher', $data);
	}

	public function show($username)
	{
		if ($this->role != 'superadmin') {
			throw new PageNotFoundException();
		}
		
		$result = $this->m_teacher->teacher_account($username);
		if (!$result) {
			throw new PageNotFoundException();
		}

		$class = [];
		foreach (json_decode($result->teaching_class) as $v) {
			$class[] = "class_group_code = '$v'";
		}
		$class = count($class) > 0 ? implode(' OR ', $class) : "class_group_code IS NULL";
		
		$subject = [];
		foreach (json_decode($result->teaching_subject) as $v) {
			$subject[] = "subject_id = '$v'";
		}
		$subject = count($subject) > 0 ? implode(' OR ', $subject) : "subject_id IS NULL";

		$data = [
			"title" => "Detail Guru",
			"url_active" => "teacher",
			"data" => $result,
			"class" => $this->m_class_group->class_groups($class),
			"subject" => $this->m_subject->subjects($subject)
		];
		return view('detail_teacher', $data);
	}

	public function edit($username)
	{
		if ($this->role != 'superadmin') {
			throw new PageNotFoundException();
		}
		
		$result = $this->m_teacher->teacher_account($username);
		if (!$result) {
			throw new PageNotFoundException();
		}

		$class = [];
		foreach (json_decode($result->teaching_class) as $v) {
			$class[] = "class_group_code = '$v'";
		}
		$class = count($class) > 0 ? implode(' OR ', $class) : "class_group_code IS NULL";
		
		$subject = [];
		foreach (json_decode($result->teaching_subject) as $v) {
			$subject[] = "subject_id = '$v'";
		}
		$subject = count($subject) > 0 ? implode(' OR ', $subject) : "subject_id IS NULL";

		$data = [
			"title" => "Edit Guru",
			"url_active" => "teacher",
			"data" => $result,
			"class" => $this->m_class_group->class_groups($class),
			"subject" => $this->m_subject->subjects($subject)
		];
		return view('edit_teacher', $data);
	}
}
