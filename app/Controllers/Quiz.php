<?php

namespace App\Controllers;

use App\Models\M_Quiz;
use App\Models\M_Class_Group;
use App\Models\M_Subject;
use CodeIgniter\Exceptions\PageNotFoundException;

class Quiz extends BaseController
{
	protected $m_quiz;
	protected $m_subject;
	protected $m_class_group;

	public function __construct()
	{
		$this->m_quiz = new M_Quiz();
		$this->m_subject = new M_Subject();
		$this->m_class_group = new M_Class_Group();
	}

	public function index()
	{
		$data = [
			"title" => "Quiz",
			"url_active" => "quiz"
		];
		return view('quiz_list', $data);
	}

	public function get_quizs()
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
		$total_quiz = $this->m_quiz->total_quiz();
		$total_quiz_filtered = $this->m_quiz->total_quiz_filtered($where, $keyword);
		$quiz_data = $this->m_quiz->quiz_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_quiz,
			"recordsFiltered" => $total_quiz_filtered,
			"data" => $quiz_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}

	public function new()
	{
		$data = [
			"title" => "Tambah Quiz",
			"url_active" => "quiz",
			"subject" => $this->m_subject->subjects(),
		];
		return view('add_quiz', $data);
	}

	public function show($quiz_code)
	{
		$result = $this->m_quiz->quiz($quiz_code);
		if (!$result) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Detail Quiz",
			"url_active" => "quiz",
			"data" => $result
		];
		return view('detail_quiz', $data);
	}

	public function edit($quiz_code)
	{
		$result = $this->m_quiz->quiz($quiz_code);
		if (!$result) {
			throw new PageNotFoundException();
		}
		$where = [];
		foreach (json_decode($result->class_group_code) as $v) {
			$where[] = "class_group_code = '$v'";
		}
		$where = implode(' OR ', $where);
		$data = [
			"title" => "Edit Quiz",
			"url_active" => "quiz",
			"data" => $result,
			"subject" => $this->m_subject->subjects(),
			"class_group" => $this->m_class_group->class_groups($where)
		];
		return view('edit_quiz', $data);
	}

	public function add_question($quiz_code)
	{
		$questions = $this->m_quiz->questions($quiz_code);
		$data = [
			"title" => "Tambah Soal",
			"url_active" => "question",
			"data" => (object) [
				"quiz_code" => $quiz_code,
				"questions" => json_decode($questions)
			]
		];
		return view('add_question_quiz', $data);
	}

	public function new_question($quiz_code)
	{
		$data = [
			"title" => "Tambah Soal",
			"url_active" => "question",
			"data" => (object) [
				"quiz_code" => $quiz_code
			]
		];
		return view('new_question_quiz', $data);
	}
}
