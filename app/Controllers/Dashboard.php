<?php

namespace App\Controllers;

use App\Models\M_Announcement;
use App\Models\M_Assignment;
use App\Models\M_Assignmentresult;
use App\Models\M_Class_Group;
use App\Models\M_Material;
use App\Models\M_Quiz;
use App\Models\M_Quizresult;
use App\Models\M_Student;
use App\Models\M_Subject;
use App\Models\M_Teacher;
use App\Models\M_User;

class Dashboard extends BaseController
{
	protected $m_user;
	protected $m_teacher;
	protected $m_student;
	protected $m_class_group;
	protected $m_subject;
	protected $m_assignment;
	protected $m_quiz;
	protected $m_material;
	protected $m_announcement;
	protected $m_assignment_result;
	protected $m_quiz_result;

	public function __construct()
	{
		$this->m_user = new M_User();
		$this->m_teacher = new M_Teacher();
		$this->m_student = new M_Student();
		$this->m_class_group = new M_Class_Group();
		$this->m_subject = new M_Subject();
		$this->m_assignment = new M_Assignment();
		$this->m_quiz = new M_Quiz();
		$this->m_material = new M_Material();
		$this->m_announcement = new M_Announcement();
		$this->m_assignment_result = new M_Assignmentresult();
		$this->m_quiz_result = new M_Quizresult();
	}

	public function index()
	{
		if ($this->role == 'superadmin') {
			$total_user = $this->m_user->total_user();
			$total_user_verified = $this->m_user->total_user(['is_active' => 1]);
			$total_teacher = $this->m_teacher->total_teacher();
			$total_student = $this->m_student->total_student();
			$total_class = $this->m_class_group->total_class_group();
			$total_subject = $this->m_subject->total_subject();
			
			$data = [
				"title" => "Dashboard",
				"url_active" => "dashboard",
				"statistic" => (object) [
					"total_user" => $total_user,
					"total_user_verified" => $total_user_verified,
					"total_teacher" => $total_teacher,
					"total_student" => $total_student,
					"total_class" => $total_class,
					"total_subject" => $total_subject
				]
			];
			return view('dashboard', $data);
		} elseif ($this->role == 'teacher') {
			if (count($this->class) > 0) {
			$class = json_encode($this->class);
			$class = substr($class, 1);
			$class = substr($class, 0, -1);
			$total_student = $this->m_student->total_student("curr_class_group IN ($class)");
			} else {
				$total_student = 0;
			}
			$total_class = count($this->class);
			$total_subject = count($this->subject);
			$total_assignment = $this->m_assignment->total_assignment(['assigned_by' => $this->username]);
			$total_quiz = $this->m_quiz->total_quiz(['assigned_by' => $this->username]);
			$total_material = $this->m_material->total_material(['created_by' => $this->username]);

			$data = [
				"title" => "Dashboard",
				"url_active" => "dashboard",
				"statistic" => (object) [
					"total_student" => $total_student,
					"total_class" => $total_class,
					"total_subject" => $total_subject,
					"total_assignment" => $total_assignment,
					"total_quiz" => $total_quiz,
					"total_material" => $total_material,
				]
			];
			return view('teacher/dashboard', $data);
		} elseif ($this->role == 'student') {
			$total_assignment_completed = $this->m_assignment_result->total_assignment_result(['submitted_by' => $this->username]);
			$total_quiz_completed = $this->m_quiz_result->total_quiz_result(['submitted_by' => $this->username]);
			$total_assignment = $this->m_assignment->total_assignment_student($this->class);
			$total_quiz = $this->m_quiz->total_quiz_student($this->class);
			$total_material = $this->m_material->total_material_student($this->class);
			$total_announcement = $this->m_announcement->total_announcement_student();
			
			$data = [
				"title" => "Dashboard",
				"url_active" => "dashboard",
				"statistic" => (object) [
					"total_assignment_completed" => $total_assignment_completed,
					"total_quiz_completed" => $total_quiz_completed,
					"total_assignment" => $total_assignment,
					"total_quiz" => $total_quiz,
					"total_material" => $total_material,
					"total_announcement" => $total_announcement
				]
			];
			return view('student/dashboard', $data);
		}
	}
}
