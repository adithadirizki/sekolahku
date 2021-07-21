<?php

namespace App\Controllers;

use App\Models\M_Quiz;
use App\Models\M_Class_Group;
use App\Models\M_Question;
use App\Models\M_Quizresult;
use App\Models\M_Subject;
use CodeIgniter\Exceptions\PageNotFoundException;

class Quiz extends BaseController
{
	protected $m_quiz;
	protected $m_quiz_result;
	protected $m_question;
	protected $m_subject;
	protected $m_class_group;

	public function __construct()
	{
		$this->m_quiz = new M_Quiz();
		$this->m_quiz_result = new M_Quizresult();
		$this->m_question = new M_Question();
		$this->m_subject = new M_Subject();
		$this->m_class_group = new M_Class_Group();
	}

	public function index()
	{
		$data = [
			"title" => "Quiz",
			"url_active" => "quiz"
		];
		if ($this->role == 'superadmin') {
			return view('quiz_list', $data);
		} elseif ($this->role == 'teacher') {
			return view('quiz_list', $data);
		} elseif ($this->role == 'student') {
			return view('student/quiz_list', $data);
		}
	}

	public function get_quizzes()
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

		if ($this->role == 'teacher') {
			$where = [
				"created_by" => $this->username
			];
		}

		$total_quiz = $this->m_quiz->total_quiz($where);
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
		$subject = [];
		if ($this->role == 'teacher') {
			foreach ($this->subject as $v) {
				$subject[] = "subject_id = '$v'";
			}
			$subject = count($subject) > 0 ? implode(' OR ', $subject) : "subject_id IS NULL";
		}

		$data = [
			"title" => "Tambah Quiz",
			"url_active" => "quiz",
			"subject" => $this->m_subject->subjects($subject),
		];
		return view('add_quiz', $data);
	}

	public function show($quiz_code)
	{
		if ($this->role == 'superadmin') {
			$result = $this->m_quiz->detail_quiz($quiz_code);
		} elseif ($this->role == 'teacher') {
			$result = $this->m_quiz->detail_quiz_teacher($this->username, $quiz_code);
		} elseif ($this->role == 'student') {
			$result = $this->m_quiz->detail_quiz_student($this->username, $quiz_code);
		}
		if (!$result) {
			throw new PageNotFoundException();
		}
		$questions = [];
		if ($this->role == 'student') {
			if (in_array($result->status, [1, 2])) {
				$whereIn = str_replace('[', '(', $result->questions);
				$whereIn = str_replace(']', ')', $whereIn);
				$questions = $this->m_question->questions("question_id IN $whereIn");
			}
		}
		$data = [
			"title" => "Detail Quiz",
			"url_active" => "quiz",
			"data" => $result,
			"questions" => $questions
		];
		if ($this->role == 'superadmin') {
			return view('detail_quiz', $data);
		} elseif ($this->role == 'teacher') {
			return view('teacher/detail_quiz', $data);
		} elseif ($this->role == 'student') {
			return view('student/detail_quiz', $data);
		}
	}

	public function edit($quiz_code)
	{
		if ($this->role == 'superadmin') {
			$result = $this->m_quiz->detail_quiz($quiz_code);
		} elseif ($this->role == 'teacher') {
			$result = $this->m_quiz->detail_quiz_teacher($this->username, $quiz_code);
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
			"title" => "Edit Quiz",
			"url_active" => "quiz",
			"data" => $result,
			"subject" => $this->m_subject->subjects($subject),
			"class_group" => $this->m_class_group->class_groups($class)
		];
		return view('edit_quiz', $data);
	}

	public function do_quiz($quiz_code)
	{
		if (!$result = $this->m_quiz_result->quiz_result_student($this->username, $quiz_code)) {
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
			"url_active" => "quiz",
			"data" => $result
		];
		return view('student/do_quiz', $data);
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
