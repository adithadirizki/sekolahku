<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Question;
use App\Models\M_Quiz;
use App\Models\M_Quizresult;
use App\Models\M_School_Year;

class Quiz extends BaseController
{
   protected $m_quiz;
   protected $m_quiz_result;
   protected $m_school_year;
   protected $m_question;
   protected $rules = [
      "quiz_title" => "required",
      "subject" => "required|is_not_unique[tb_subject.subject_id]",
      "class_group*" => "required|multiple_class_group",
      "question_model" => "required|in_list[0,1]",
      "show_ans_key" => "required|in_list[0,1]",
      "time" => "required|numeric",
      "start_at" => "required|valid_date[Y-m-d\TH:i]",
      "due_at" => "permit_empty|valid_date[Y-m-d\TH:i]"
   ];
   protected $errors = [
      "quiz_title" => [
         "required" => "Judul Quiz harus diisi."
      ],
      "subject" => [
         "required" => "Mata Pelajaran harus diisi.",
         "is_not_unique" => "Mata Pelajaran tidak valid."
      ],
      "class_group*" => [
         "required" => "Kelas harus diisi.",
         "multiple_class_group" => "Kelas tidak valid."
      ],
      "question_model" => [
         "required" => "Model Pertanyaan harus diisi.",
         "in_list" => "Model Pertanyaan tidak valid."
      ],
      "show_ans_key" => [
         "required" => "Model Kunci Jawaban harus diisi.",
         "in_list" => "Model Kunci Jawaban tidak valid."
      ],
      "time" => [
         "required" => "Waktu Quiz harus diisi.",
         "numeric" => "Waktu Quiz harus berisi angka."
      ],
      "start_at" => [
         "required" => "Tgl ditugaskan harus diisi.",
         "valid_date" => "Tgl ditugaskan tidak valid."
      ],
      "due_at" => [
         "valid_date" => "Tgl berakhir tidak valid."
      ]
   ];

   public function __construct()
   {
      $this->m_quiz = new M_Quiz();
      $this->m_quiz_result = new M_Quizresult();
      $this->m_school_year = new M_School_Year();
      $this->m_question = new M_Question();
   }

   public function getAll()
   {
      $validation = \Config\Services::validation();
      $validation->setRules(
         [
            "page" => "required|is_natural_no_zero"
         ],
         [
            "page" => [
               "required" => "Parameter is invalid.",
               "is_natural_no_zero" => "Parameter is invalid."
            ]
         ]
      );
      if ($validation->withRequest($this->request)->run() === false) {
         return $this->respond([
            "message" => "ERROR!",
            "status" => 400,
            "errors" => $validation->getErrors(),
         ]);
      }
      $limit = 10;
      $offset = ($_POST['page'] - 1) * $limit;
      if ($this->role == 'superadmin') {
         $where = [];
         $result = $this->m_quiz->quizzes($where, $limit, $offset);
         $total_nums = $this->m_quiz->total_quiz($where);
      } elseif ($this->role == 'teacher') {
         $where = [
            "assigned_by" => $this->username
         ];
         $result = $this->m_quiz->quizzes($where, $limit, $offset);
         $total_nums = $this->m_quiz->total_quiz($where);
      } elseif ($this->role == 'student') {
         $where = [];
         $result = $this->m_quiz->quizzes_student($this->username, $where, $limit, $offset);
         $total_nums = $this->m_quiz->total_quiz_student($this->username, $where);
      }
      return $this->respond([
         "message" => "OK",
         "status" => 200,
         "error" => false,
         "data" => $result,
         "total_nums" => $total_nums
      ]);
   }

   public function create()
   {
      $validation = \Config\Services::validation();
      $validation->setRules($this->rules, $this->errors);
      if ($validation->withRequest($this->request)->run() == false) {
         return $this->respond([
            "message" => "Failed to save changes.",
            "status" => 400,
            "errors" => $validation->getErrors()
         ]);
      }
      parse_str(file_get_contents('php://input'), $input);
      foreach ($input as $key => $value) {
         if (is_array($value)) {
            $data[$key] = json_encode(array_map('htmlentities', $value));
         } else {
            $data[$key] = $value == null ? null : htmlentities($value, ENT_QUOTES, 'UTF-8');
         }
      }
      $data['quiz_code'] = $this->m_quiz->new_quiz_code();
      $data['created_by'] = $this->username;
      $data['at_school_year'] = $this->m_school_year->school_year_now()->school_year_id;
      $result = $this->m_quiz->create_quiz($data);
      if ($result) {
         return $this->respond([
            "message" => "Added successfully.",
            "status" => 200,
            "error" => false
         ]);
      }
      return $this->respond([
         "message" => "Failed to added.",
         "status" => 400,
         "error" => true
      ]);
   }

   public function copy($quiz_code)
   {
      $new_quiz_code = $this->m_quiz->new_quiz_code();
      $created_by = $this->username;
      $school_year_id = $this->m_school_year->school_year_now()->school_year_id;
      if ($this->role == 'superadmin') {
         $sql = "INSERT INTO tb_quiz (quiz_code,quiz_title,questions,question_model,show_ans_key,time,created_by,class_group,subject,start_at,due_at,at_school_year) SELECT '$new_quiz_code',quiz_title,questions,question_model,show_ans_key,time,'$created_by',class_group,subject,start_at,due_at,'$school_year_id' FROM tb_quiz WHERE quiz_code = '$quiz_code'";
      } elseif ($this->role == 'teacher') {
         $sql = "INSERT INTO tb_quiz (quiz_code,quiz_title,questions,question_model,show_ans_key,time,created_by,start_at,due_at,at_school_year) SELECT '$new_quiz_code',quiz_title,questions,question_model,show_ans_key,time,'$created_by',start_at,due_at,'$school_year_id' FROM tb_quiz WHERE quiz_code = '$quiz_code'";
      }
      try {
         $this->m_quiz->query($sql);
         return $this->respond([
            "message" => "Copied successfully.",
            "status" => 200,
            "error" => false
         ]);
      } catch (\Exception $e) {
         return $this->respond([
            "message" => "Failed to copy.",
            "status" => 400,
            "error" => true
         ]);
      }
   }

   public function update($quiz_code)
   {
      if ($this->role == 'teacher') {
         if (!$this->m_quiz->have_quiz($this->username, $quiz_code)) {
            return $this->failForbidden();
         }
      }
      $validation = \Config\Services::validation();
      $validation->setRules($this->rules, $this->errors);
      if ($validation->withRequest($this->request)->run() == false) {
         return $this->respond([
            "message" => "Failed to save changes.",
            "status" => 400,
            "errors" => $validation->getErrors()
         ]);
      }
      parse_str(file_get_contents('php://input'), $input);
      foreach ($input as $key => $value) {
         if (is_array($value)) {
            $data[$key] = json_encode(array_map('htmlentities', $value));
         } else {
            $data[$key] = $value == null ? null : htmlentities($value, ENT_QUOTES, 'UTF-8');
         }
      }
      $where = [
         "quiz_code" => $quiz_code
      ];
      $result = $this->m_quiz->update_quiz($data, $where);
      if ($result) {
         return $this->respond([
            "message" => "Changes saved successfully.",
            "status" => 200,
            "error" => false
         ]);
      }
      return $this->respond([
         "message" => "Failed to save changes.",
         "status" => 400,
         "error" => true
      ]);
   }

   public function delete($quiz_code)
   {
      if ($this->role == 'teacher') {
         if (!$this->m_quiz->have_quiz($this->username, $quiz_code)) {
            return $this->failForbidden();
         }
      }
      $where = [
         "quiz_code" => $quiz_code
      ];
      try {
         $this->m_quiz->delete_quiz($where);
         return $this->respond([
            "message" => "Successfully deleted.",
            "status" => 200,
            "error" => false
         ]);
      } catch (\Exception $e) {
         return $this->respond([
            "message" => "Failed to delete.",
            "status" => 400,
            "error" => true
         ]);
      }
   }

   public function get_question($quiz_code, $question_id)
   {
      $where = [
         "quiz" => $quiz_code,
         "submitted_by" => $this->username
      ];
      $result = $this->m_quiz_result->show_question($where, $question_id);
      unset($result->answer_key);
      unset($result->created_by);
      if (!$result) {
         return $this->respond([
            "message" => "Quiz not found!",
            "status" => 404,
            "error" => true,
            "data" => null
         ]);
      }
      $result->choice = json_decode($result->choice);
      return $this->respond([
         "message" => "Quiz found!",
         "status" => 200,
         "error" => false,
         "data" => $result
      ]);
   }

   public function start($quiz_code)
   {
      if (!$result = $this->m_quiz->quiz_student($this->username, $quiz_code)) {
         return $this->respond([
            "message" => "Quiz not found!",
            "status" => 404,
            "error" => false
         ]);
      }
      if (strtotime('now') > strtotime($result->due_at)) {
         return $this->respond([
            "message" => "Quiz is due.",
            "status" => 403,
            "error" => true
         ]);
      }
      if ($status = $this->m_quiz_result->status_submitted($this->username, $quiz_code)) {
         if ($status->status == 0) {
            return $this->respond([
               "message" => "Successfully started Quiz.",
               "status" => 200,
               "error" => false
            ]);
         }
         if (in_array($status->status, [1, 2])) {
            return $this->respond([
               "message" => "You have submitted the quiz.",
               "status" => 403,
               "error" => true
            ]);
         }
      }
      $questions = json_decode($result->questions);
      if ($result->question_model == 1) {
         // Generate Random Number Questions
         shuffle($questions);
      }
      $questions = array_fill_keys($questions, NULL); // Set answer NULL
      $data = [
         "quiz" => $quiz_code,
         "answer" => json_encode($questions),
         "submitted_by" => $this->username,
         "at_school_year" => $this->m_school_year->school_year_now()->school_year_id
      ];
      $result = $this->m_quiz_result->create_quiz_result($data);
      if ($result) {
         return $this->respond([
            "message" => "Successfully started Quiz.",
            "status" => 200,
            "error" => false
         ]);
      }
      return $this->respond([
         "message" => "Failed to start Quiz.",
         "status" => 400,
         "error" => true
      ]);
   }

   public function answer($quiz_code)
   {
      $validation = \Config\Services::validation();
      $validation->setRules(
         [
            "answer" => "required"
         ],
         [
            "answer" => [
               "required" => "Jawaban harus diisi."
            ]
         ]
      );
      if ($validation->withRequest($this->request)->run() == false) {
         return $this->respond([
            "message" => "Failed to answer.",
            "status" => 400,
            "errors" => $validation->getErrors()
         ]);
      }
      if ($this->m_quiz->is_due($quiz_code)) {
         return $this->respond([
            "message" => "Quiz is due.",
            "status" => 403,
            "error" => true
         ]);
      }
      $where = [
         "quiz" => $quiz_code,
         "submitted_by" => $this->username
      ];
      parse_str(file_get_contents('php://input'), $input);
      $answer = htmlentities($input['answer'], ENT_QUOTES, 'UTF-8');
      $result = $this->m_quiz_result->submit_answer($_POST['question_id'], $answer, $where);
      if ($result) {
         return $this->respond([
            "message" => "Successfully answered.",
            "status" => 200,
            "error" => false
         ]);
      }
      return $this->respond([
         "message" => "Failed to answer.",
         "status" => 400,
         "error" => true
      ]);
   }

   public function complete($quiz_code)
   {
      $where = [
         "quiz" => $quiz_code,
         "submitted_by" => $this->username
      ];
      $answers = $this->m_quiz_result->answers($this->username, $quiz_code);
      $answers = json_decode($answers, true);
      $questions = json_encode(array_keys($answers));
      $questions = substr($questions, 1);
      $questions = substr($questions, 0, -1);
      $questions = $this->m_question->questions("question_id IN ($questions)");
      $total_mc = 0;
      $total_essay = 0;
      $mc_score = 0;
      $essay_score = 0;
      $save_essay_score = [];
      foreach ($questions as $k => $v) {
         if ($v->question_type == 'mc') {
            $total_mc++;
            if ($answers[$v->question_id] == $v->answer_key) {
               $mc_score += 100;
            }
         } elseif ($v->question_type == 'essay') {
            $total_essay++;
            if (strtolower($answers[$v->question_id]) == strtolower($v->answer_key)) {
               $essay_score += 100;
               $save_essay_score[$v->question_id] = 100;
            } else {
               $save_essay_score[$v->question_id] = 0;
            }
         }
      }

      $mc_score = $total_mc ? floor($mc_score / $total_mc) : 0;
      $essay_score = $total_essay ? floor($essay_score / $total_essay) : 0;
      if ($total_mc && $total_essay) {
         $total_score = floor(($mc_score + $essay_score) / 2);
      } else {
         $total_score = floor($mc_score + $essay_score);
      }
      $save_essay_score = json_encode($save_essay_score);

      $data = [
         "essay_score" => $save_essay_score,
         "value" => $total_score
      ];
      if ($this->m_quiz_result->is_timeout($this->username, $quiz_code)) {
         $result = $this->m_quiz_result->submit_timeout($data, $where);
      } else {
         $result = $this->m_quiz_result->submit_completed($data, $where);
      }
      if ($result) {
         return $this->respond([
            "message" => "Successfully completed the Quiz.",
            "status" => 200,
            "error" => false
         ]);
      }
      return $this->respond([
         "message" => "Failed to complete the Quiz.",
         "status" => 400,
         "error" => true
      ]);
   }

   public function show_question($quiz_code, $number_question)
   {
      if ($this->role == 'superadmin') {
         $result = $this->m_quiz->get_question($quiz_code, $number_question);
      } elseif ($this->role == 'teacher') {
         $result = $this->m_quiz->get_question_teacher($this->username, $quiz_code, $number_question);
      } elseif ($this->role == 'student') {
         $where = [
            "quiz" => $quiz_code,
            "submitted_by" => $this->username
         ];
         $result = $this->m_quiz_result->show_question($where, $number_question);
      }
      if ($result) {
         if ($this->role == 'student') {
            unset($result->answer_key);
            unset($result->created_by);
         }
         $result->choices = json_decode($result->choice);
         unset($result->choice);
         return $this->respond([
            "message" => "Quiz found!",
            "status" => 200,
            "data" => $result,
            "error" => false
         ]);
      }
      return $this->respond([
         "message" => "Quiz not found!",
         "status" => 200,
         "data" => null,
         "error" => true
      ]);
   }

   public function add_question($quiz_code)
   {
      parse_str(file_get_contents('php://input'), $input);
      $question_ids = isset($input['question_id']) ? $input['question_id'] : [];
      $question_ids = array_map(function ($v) {
         return htmlentities($v, ENT_QUOTES, 'UTF-8');
      }, $question_ids);
      $questions = json_decode($this->m_quiz->questions($quiz_code));
      $questions = array_merge($questions, $question_ids);
      $questions = array_reverse($questions);
      $questions = array_unique($questions);
      $questions = array_reverse($questions);

      if ($this->role == 'superadmin') {
         $result = $this->m_quiz->update_question($quiz_code, $questions);
      } elseif ($this->role == 'teacher') {
         $result = $this->m_quiz->update_question_teacher($this->username, $quiz_code, $questions);
      }

      if ($result) {
         return $this->respond([
            "message" => "Changes saved successfully.",
            "status" => 200,
            "error" => false
         ]);
      }
      return $this->respond([
         "message" => "Failed to save changes.",
         "status" => 400,
         "error" => true
      ]);
   }

   public function create_question($quiz_code)
   {
      parse_str(file_get_contents('php://input'), $input);
      if ($errors = (new Question)->question_validation($input, $this->request)) {
         return $this->respond([
            "message" => "Failed to added.",
            "status" => 400,
            "errors" => $errors
         ]);
      }
      $question_type = htmlentities($input['question_type'], ENT_QUOTES, 'UTF-8');
      $question_text = htmlentities($input['question_text'], ENT_QUOTES, 'UTF-8');
      $choices = [];
      if ($question_type == 'mc') {
         foreach ($input['choice'] as $key => $value) {
            $choices[] = htmlentities($value, ENT_QUOTES, 'UTF-8');
         }
      }
      $answer_key = $input['answer_key'] ? htmlentities($input['answer_key'], ENT_QUOTES, 'UTF-8') : null;
      $data = [
         "question_type" => $question_type,
         "question_text" => $question_text,
         "choice" => json_encode($choices),
         "answer_key" => $answer_key,
         "created_by" => $this->username
      ];
      $result = $this->m_question->create_question($data);
      if ($result) {
         $question_id = $this->m_question->last_question_id();

         if ($this->role == 'superadmin') {
            $result = $this->m_quiz->update_question($quiz_code, $question_id);
         } elseif ($this->role == 'teacher') {
            $result = $this->m_quiz->update_question_teacher($this->username, $quiz_code, $question_id);
         }

         if ($result) {
            return $this->respond([
               "message" => "Added successfully.",
               "status" => 200,
               "error" => false
            ]);
         }
      }
      return $this->respond([
         "message" => "Failed to added.",
         "status" => 400,
         "error" => true
      ]);
   }

   public function delete_question($quiz_code, $number_question)
   {
      try {
         if ($this->role == 'superadmin') {
            $this->m_quiz->delete_question($quiz_code, $number_question);
         } elseif ($this->role == 'teacher') {
            $this->m_quiz->delete_question_teacher($this->username, $quiz_code, $number_question);
         }

         return $this->respond([
            "message" => "Successfully deleted.",
            "status" => 200,
            "error" => false
         ]);
      } catch (\Exception $e) {
         return $this->respond([
            "message" => "Failed to delete.",
            "status" => 400,
            "error" => true
         ]);
      }
   }
}
