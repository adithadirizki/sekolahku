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
		return view('assignment_list', $data);
	}

	public function get_assignments()
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
		$total_assignment = $this->m_assignment->total_assignment();
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

	public function show($assignment_code)
	{
		$result = $this->m_assignment->assignment($assignment_code);
		if (!$result) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Detail Tugas",
			"url_active" => "assignment",
			"data" => $result
		];
		return view('detail_assignment', $data);
	}

	public function edit($assignment_code)
	{
		$result = $this->m_assignment->assignment($assignment_code);
		if (!$result) {
			throw new PageNotFoundException();
		}
		$where = [];
		foreach (json_decode($result->class_group_code) as $v) {
			$where[] = "class_group_code = '$v'";
		}
		$where = implode(' OR ', $where);
		$data = [
			"title" => "Edit Tugas",
			"url_active" => "assignment",
			"data" => $result,
			"subject" => $this->m_subject->subjects(),
			"class_group" => $this->m_class_group->class_groups($where)
		];
		return view('edit_assignment', $data);
	}
}
