<?php

namespace App\Controllers;

use App\Models\M_Bank_Question;
use CodeIgniter\Exceptions\PageNotFoundException;

class Bankquestion extends BaseController
{
	protected $m_bank_question;

	public function __construct()
	{
		$this->m_bank_question = new M_Bank_Question();
	}

	public function index()
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}

		$data = [
			"title" => "Bank Soal",
			"url_active" => "bankquestion"
		];
		return view('bank_question_list', $data);
	}

	public function get_bank_questions()
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
		$total_bank_question = $this->m_bank_question->total_bank_question();
		$total_bank_question_filtered = $this->m_bank_question->total_bank_question_filtered($where, $keyword);
		$bank_question_data = $this->m_bank_question->bank_question_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_bank_question,
			"recordsFiltered" => $total_bank_question_filtered,
			"data" => $bank_question_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}

	public function show($bank_question_id)
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}
		
		$where = [
			"bank_question_id" => $bank_question_id
		];
		if (!$result = $this->m_bank_question->bank_question($where)) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Detail Bank Soal",
			"url_active" => "bankquestion",
			"data" => $result
		];
		if ($this->role == 'superadmin') {
			return view('detail_bank_question', $data);
		} elseif ($this->role == 'teacher') {
			return view('teacher/detail_bank_question', $data);
		}
	}

	public function add_question($bank_question_id)
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}
		
		if ($this->role == 'teacher') {
			if (!$this->m_bank_question->have_bank_question($this->username, $bank_question_id)) {
				throw new PageNotFoundException();
			}
		}
		
		$questions = $this->m_bank_question->questions($bank_question_id);
		$data = [
			"title" => "Tambah Soal",
			"url_active" => "question",
			"data" => (object) [
				"bank_question_id" => $bank_question_id,
				"questions" => json_decode($questions)
			]
		];
		return view('add_question_bank_question', $data);
	}

	public function new_question($bank_question_id)
	{
		if ($this->role == 'student') {
			throw new PageNotFoundException();
		}
		
		if ($this->role == 'teacher') {
			if (!$this->m_bank_question->have_bank_question($this->username, $bank_question_id)) {
				throw new PageNotFoundException();
			}
		}

		$data = [
			"title" => "Tambah Soal",
			"url_active" => "question",
			"data" => (object) [
				"bank_question_id" => $bank_question_id
			]
		];
		return view('new_question_bank_question', $data);
	}
}
