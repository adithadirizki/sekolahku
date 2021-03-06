<?php

namespace App\Controllers;

use App\Models\M_Assignment;
use App\Models\M_Class_Group;
use App\Models\M_Subject;
use CodeIgniter\Exceptions\PageNotFoundException;

class Assignment extends BaseController
{
	protected $m_assignment;
	protected $m_subject;
	protected $m_class_group;

	public function __construct()
	{
		$this->m_assignment = new M_Assignment();
		$this->m_subject = new M_Subject();
		$this->m_class_group = new M_Class_Group();
	}

	public function index()
	{
		$data = [
			"title" => "Tugas",
			"url_active" => "assignment"
		];
		if ($this->role == 'superadmin') {
			return view('assignment_list', $data);
		} elseif ($this->role == 'teacher') {
			return view('assignment_list', $data);
		} elseif ($this->role == 'student') {
			return view('student/assignment_list', $data);
		}
	}

	public function get_assignments()
	{
		if ($this->role == 'student') {
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

		if ($this->role == 'teacher') {
			$where = [
				"assigned_by" => $this->username
			];
		}

		$total_assignment = $this->m_assignment->total_assignment($where);
		$total_assignment_filtered = $this->m_assignment->total_assignment_filtered($where, $keyword);
		$assignment_data = $this->m_assignment->assignment_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_assignment,
			"recordsFiltered" => $total_assignment_filtered,
			"data" => $assignment_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}

	public function new()
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}

		$subject = [];
		if ($this->role == 'teacher') {
			foreach ($this->subject as $v) {
				$subject[] = "subject_id = '$v'";
			}
			$subject = count($subject) > 0 ? implode(' OR ', $subject) : "subject_id IS NULL";
		}

		$data = [
			"title" => "Tambah Tugas",
			"url_active" => "assignment",
			"subject" => $this->m_subject->subjects($subject),
		];
		return view('add_assignment', $data);
	}

	public function show($assignment_code)
	{
		if ($this->role == 'superadmin') {
			$result = $this->m_assignment->detail_assignment($assignment_code);
		} elseif ($this->role == 'teacher') {
			$result = $this->m_assignment->detail_assignment_teacher($this->username, $assignment_code);
		} elseif ($this->role == 'student') {
			$result = $this->m_assignment->detail_assignment_student($this->username, $assignment_code);
		}
		if (!$result) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Detail Tugas",
			"url_active" => "assignment",
			"data" => $result
		];
		if ($this->role == 'superadmin') {
			return view('detail_assignment', $data);
		} elseif ($this->role == 'teacher') {
			return view('teacher/detail_assignment', $data);
		} elseif ($this->role == 'student') {
			return view('student/detail_assignment', $data);
		}
	}

	public function edit($assignment_code)
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}

		if ($this->role == 'superadmin') {
			$result = $this->m_assignment->detail_assignment($assignment_code);
		} elseif ($this->role == 'teacher') {
			$result = $this->m_assignment->detail_assignment_teacher($this->username, $assignment_code);
		}
		if (!$result) {
			throw new PageNotFoundException();
		}
		$class = [];
		foreach (json_decode($result->class_group_code) as $v) {
			$class[] = "class_group_code = '$v'";
		}
		$class = count($class) > 0 ? implode(' OR ', $class) : "class_group_code IS NULL";

		$subject = [];
		if ($this->role == 'teacher') {
			foreach ($this->subject as $v) {
				$subject[] = "subject_id = '$v'";
			}
			$subject = count($subject) > 0 ? implode(' OR ', $subject) : "subject_id IS NULL";
		}

		$data = [
			"title" => "Edit Tugas",
			"url_active" => "assignment",
			"data" => $result,
			"subject" => $this->m_subject->subjects($subject),
			"class_group" => $this->m_class_group->class_groups($class)
		];
		return view('edit_assignment', $data);
	}
}
