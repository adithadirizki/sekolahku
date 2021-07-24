<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Bank_Question;
use App\Models\M_Question;

class Bankquestion extends BaseController
{
   protected $m_question;
   protected $m_bank_question;
   protected $rules = [
      "bank_question_title" => "required"
   ];
   protected $errors = [
      "bank_question_title" => [
         "required" => "Nama Bank Soal harus diisi."
      ]
   ];

   public function __construct()
   {
      $this->m_question = new M_Question();
      $this->m_bank_question = new M_Bank_Question();
   }

   public function create()
   {
      if ($this->role == 'student') {
         return $this->failForbidden();
      }

      $validation = \Config\Services::validation();
      $validation->setRules($this->rules, $this->errors);
      parse_str(file_get_contents('php://input'), $input);
      if ($validation->withRequest($this->request)->run() == false) {
         return $this->respond([
            "message" => "Failed to added.",
            "status" => 400,
            "errors" => $validation->getErrors()
         ]);
      }
      $bank_question_title = htmlentities($input['bank_question_title'], ENT_QUOTES, 'UTF-8');
      $data = [
         "bank_question_title" => $bank_question_title,
         "created_by" => $this->username
      ];
      $result = $this->m_bank_question->create_bank_question($data);
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

   public function update($bank_question_id)
   {
      if ($this->role == 'student') {
         return $this->failForbidden();
      }
      
      if ($this->role == 'teacher') {
         if (!$this->m_bank_question->have_bank_question($this->username, $bank_question_id)) {
            return $this->failForbidden();
         }
      }

      $validation = \Config\Services::validation();
      $validation->setRules($this->rules, $this->errors);
      parse_str(file_get_contents('php://input'), $input);
      if ($validation->withRequest($this->request)->run() == false) {
         return $this->respond([
            "message" => "Failed to save changes.",
            "status" => 400,
            "errors" => $validation->getErrors()
         ]);
      }
      $bank_question_title = htmlentities($input['bank_question_title'], ENT_QUOTES, 'UTF-8');
      $data = [
         "bank_question_title" => $bank_question_title
      ];
      $where = [
         "bank_question_id" => $bank_question_id,
      ];
      $result = $this->m_bank_question->update_bank_question($data, $where);
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

   public function delete($bank_question_id)
   {
      if ($this->role == 'student') {
         return $this->failForbidden();
      }
      
      if ($this->role == 'teacher') {
         if (!$this->m_bank_question->have_bank_question($this->username, $bank_question_id)) {
            return $this->failForbidden();
         }
      }

      $where = [
         "bank_question_id" => $bank_question_id
      ];
      try {
         $this->m_bank_question->delete_bank_question($where);
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

   public function show_question($bank_question_id, $number_question)
   {
      if ($this->role == 'student') {
         return $this->failForbidden();
      }
      
      $result = $this->m_bank_question->get_question($bank_question_id, $number_question);
      if ($result) {
         $result->choices = json_decode($result->choice);
         return $this->respond([
            "message" => "Question found!",
            "status" => 200,
            "data" => $result,
            "error" => false
         ]);
      }
      return $this->respond([
         "message" => "Question not found!",
         "status" => 200,
         "data" => null,
         "error" => true
      ]);
   }

   public function add_question($bank_question_id)
   {
      if ($this->role == 'student') {
         return $this->failForbidden();
      }
      
      if ($this->role == 'teacher') {
         if (!$this->m_bank_question->have_bank_question($this->username, $bank_question_id)) {
            return $this->failForbidden();
         }
      }
      
      parse_str(file_get_contents('php://input'), $input);
      $question_ids = isset($input['question_id']) ? $input['question_id'] : [];
      $question_ids = array_map(function ($v) {
         return htmlentities($v, ENT_QUOTES, 'UTF-8');
      }, $question_ids);
      $questions = json_decode($this->m_bank_question->questions($bank_question_id));
      $questions = array_merge($questions, $question_ids);
      $questions = array_reverse($questions); // reverse question
      $questions = array_unique($questions); // remove duplicate question
      $questions = array_reverse($questions); // reverse back
      $result = $this->m_bank_question->update_question($bank_question_id, $questions);
      if ($result) {
         return $this->respond([
            "message" => "Added question successfully.",
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

   public function create_question($bank_question_id)
   {
      if ($this->role == 'student') {
         return $this->failForbidden();
      }
      
      if ($this->role == 'teacher') {
         if (!$this->m_bank_question->have_bank_question($this->username, $bank_question_id)) {
            return $this->failForbidden();
         }
      }

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
      $answer_key = empty($input['answer_key']) ? null : htmlentities($input['answer_key'], ENT_QUOTES, 'UTF-8');
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
         $result = $this->m_bank_question->update_question($bank_question_id, $question_id);
         if ($result) {
            return $this->respond([
               "message" => "Added question successfully.",
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

   public function delete_question($bank_question_id, $number_question)
   {
      if ($this->role == 'student') {
         return $this->failForbidden();
      }
      
      if ($this->role == 'teacher') {
         if (!$this->m_bank_question->have_bank_question($this->username, $bank_question_id)) {
            return $this->failForbidden();
         }
      }

      try {
         $this->m_bank_question->delete_question($bank_question_id, $number_question);
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
