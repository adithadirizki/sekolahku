<?php

namespace App\Controllers;

use App\Models\M_Assignmentresult;
use CodeIgniter\Exceptions\PageNotFoundException;

class Assignmentresult extends BaseController
{
	protected $m_assignment_result;

	public function __construct()
	{
		$this->m_assignment_result = new M_Assignmentresult();
	}

	public function index()
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}

		$data = [
			"title" => "Assignment",
			"url_active" => "assignmentresult"
		];
		if ($this->role == 'superadmin') {
			return view('assignment_result_list', $data);
		} elseif ($this->role == 'teacher') {
			return view('assignment_result_list', $data);
		}
	}

	public function get_assignment_results()
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

		if ($_POST['value'] == null) {
		} elseif ($_POST['value'] == 0) {
			$where[] = "value IS NULL";
		} elseif ($_POST['value'] == 1) {
			$where[] = "value IS NOT NULL";
		}

		if ($this->role == 'teacher') {
			$where[] = "assigned_by = '$this->username'";
		}
		$where = count($where) > 0 ? implode(' AND ', $where) : [];

		$total_assignment_result = $this->m_assignment_result->total_assignment_result($where);
		$total_assignment_result_filtered = $this->m_assignment_result->total_assignment_result_filtered($where, $keyword);
		$assignment_result_data = $this->m_assignment_result->assignment_result_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_assignment_result,
			"recordsFiltered" => $total_assignment_result_filtered,
			"data" => $assignment_result_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}

	public function show($assignment_result_id)
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}
		
		if ($this->role == 'superadmin') {
			$result = $this->m_assignment_result->detail_assignment_result($assignment_result_id);
		} elseif ($this->role == 'teacher') {
			$result = $this->m_assignment_result->detail_assignment_result_teacher($this->username, $assignment_result_id);
		}
		if (!$result) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Detail Hasil Assignment",
			"url_active" => "assignmentresult",
			"data" => $result
		];
		if ($this->role == 'superadmin') {
			return view('detail_assignment_result', $data);
		} elseif ($this->role == 'teacher') {
			return view('detail_assignment_result', $data);
		}
	}
}
