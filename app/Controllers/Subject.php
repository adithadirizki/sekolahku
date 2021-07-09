<?php

namespace App\Controllers;

use App\Models\M_Subject;

class Subject extends BaseController
{
	protected $m_subject;

	public function __construct()
	{
		$this->m_subject = new M_Subject();
	}

	public function index()
	{
		$data = [
			"title" => "Mata Pelajaran",
			"url_active" => "subject"
		];
		return view('subject_list', $data);
	}

	public function get_subjects()
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
		$total_subject = $this->m_subject->total_subject();
		$total_subject_filtered = $this->m_subject->total_subject_filtered($where, $keyword);
		$subject_data = $this->m_subject->subject_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_subject,
			"recordsFiltered" => $total_subject_filtered,
			"data" => $subject_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}
}
