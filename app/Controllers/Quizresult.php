<?php

namespace App\Controllers;

use App\Models\M_Question;
use App\Models\M_Quizresult;
use CodeIgniter\Exceptions\PageNotFoundException;

class Quizresult extends BaseController
{
	protected $m_quiz_result;
	protected $m_question;

	public function __construct()
	{
		$this->m_quiz_result = new M_Quizresult();
		$this->m_question = new M_Question();
	}

	public function index()
	{
		$data = [
			"title" => "Quiz",
			"url_active" => "quizresult"
		];
		if ($this->role == 'superadmin') {
			return view('quiz_result_list', $data);
		} elseif ($this->role == 'student') {
			return view('student/quiz_result_list', $data);
		}
	}

	public function get_quiz_results()
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
		if ($_POST['value'] == null) {
		} elseif ($_POST['value'] == 0) {
			$where[] = "value IS NULL";
		} elseif ($_POST['value'] == 1) {
			$where[] = "value IS NOT NULL";
		}
		if ($_POST['status'] <> null) {
			$where[] = "status = $_POST[status]";
		}
		$where = $where == [] ? [] : implode(' AND ', $where);
		$total_quiz_result = $this->m_quiz_result->total_quiz_result();
		$total_quiz_result_filtered = $this->m_quiz_result->total_quiz_result_filtered($where, $keyword);
		$quiz_result_data = $this->m_quiz_result->quiz_result_data($where, $keyword, $limit, $offset, $orderby);
		$csrf_name = csrf_token();
		$data =  [
			"recordsTotal" => $total_quiz_result,
			"recordsFiltered" => $total_quiz_result_filtered,
			"data" => $quiz_result_data,
			"$csrf_name" => csrf_hash()
		];
		return json_encode($data);
	}

	public function show($quiz_result_id)
	{
		if ($this->role == 'superadmin') {
			$result = $this->m_quiz_result->detail_quiz_result($quiz_result_id);
		} elseif ($this->role == 'student') {
			// $result = $this->m_quiz->quiz_student($this->username, $quiz_result_id);
		}
		if (!$result) {
			throw new PageNotFoundException();
		}
		$whereIn = str_replace('[','(',$result->questions);
		$whereIn = str_replace(']',')',$whereIn);
		$questions = $this->m_question->questions("question_id IN $whereIn");
		$data = [
			"title" => "Detail Hasil Quiz",
			"url_active" => "quizresult",
			"data" => $result,
			"questions" => $questions
		];
		if ($this->role == 'superadmin') {
			return view('detail_quiz_result', $data);
		} elseif ($this->role == 'student') {
			return view('student/detail_quiz_result', $data);
		}
	}

	public function do_quiz($quiz_code)
	{
		if (!$result = $this->m_quiz_result->quiz_result($this->username, $quiz_code)) {
			throw new PageNotFoundException();
		}
		if (in_array($result->status, [1, 2])) {
			throw new PageNotFoundException();
		}
		if (strtotime('now') > strtotime($result->due_at)) {
			throw new PageNotFoundException();
		}
		$data = [
			"title" => "Sedang mengerjakan Quiz",
			"url_active" => "quizresult",
			"data" => $result
		];
		return view('student/do_quiz', $data);
	}
}
