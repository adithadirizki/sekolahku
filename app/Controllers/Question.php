<?php

namespace App\Controllers;

use App\Models\M_Question;
use CodeIgniter\Exceptions\PageNotFoundException;

class Question extends BaseController
{
	protected $m_question;

	public function __construct()
	{
		$this->m_question = new M_Question();
	}

	public function index()
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}

		$data = [
			"title" => "Soal",
			"url_active" => "question"
		];
		return view('question_list', $data);
	}

	public function get_questions()
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
		$_POST['question_type'] <> null ? $where['question_type'] = $_POST['question_type'] : null;
		$total_question = $this->m_question->total_question();
		$total_question_filtered = $this->m_question->total_question_filtered($where, $keyword);
		$question_data = $this->m_question->question_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_question,
			"recordsFiltered" => $total_question_filtered,
			"data" => $question_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}

	public function show($question_id)
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}

		$where = [
			"question_id" => $question_id
		];
		if (!$result = $this->m_question->question($where)) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Detail Soal",
			"url_active" => "question",
			"data" => $result
		];
		return view('detail_question', $data);
	}

	public function new()
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}

		$data = [
			"title" => "Tambah Soal",
			"url_active" => "question"
		];
		return view('add_question', $data);
	}

	public function edit($question_id)
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}

		if ($this->role == 'teacher') {
			if (!$this->m_question->have_question($this->username, $question_id)) {
				throw new PageNotFoundException();
			}
		}

		$where = [
			"question_id" => $question_id
		];
		if (!$result = $this->m_question->question($where)) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Edit Soal",
			"url_active" => "question",
			"data" => $result
		];
		return view('edit_question', $data);
	}
}
