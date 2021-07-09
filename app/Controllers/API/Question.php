<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Question;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;

class Question extends BaseController
{
   use ResponseTrait;
   protected $m_question;
   protected $rules = [
      "question_type" => "required|in_list[mc,essay]",
      "question_text" => "required"
   ];
   protected $errors = [
      "question_type" => [
         "required" => "Nama Jurusan harus diisi."
      ],
      "question_text" => [
         "required" => "Kode Jurusan harus diisi."
      ]
   ];

   public function __construct()
   {
      $this->m_question = new M_Question();
   }

   public function create()
   {
      $validation = \Config\Services::validation();
      $validation->setRules($this->rules, $this->errors);
      parse_str(file_get_contents('php://input'), $input);
      $question_type = htmlentities($input['question_type'], ENT_QUOTES, 'UTF-8');
      $choices = [];
      if ($question_type == 'mc') {
         // Add more validation
         $num_choice = count($input['choice']);
         if ($num_choice < 2) {
            $validation->setError("choice", "Pilihan harus lebih dari 1.");
         }
         foreach ($input['choice'] as $key => $value) {
            $choices[] = htmlentities($value, ENT_QUOTES, 'UTF-8');
            if (strip_tags($value) == '') {
               $validation->setError("choice[$key]", "Pilihan harus diisi.");
            }
         }
         $validation->setRule('answer_key', null, "required|regex_match[/^[0-" . ($num_choice - 1) . "]/]", [
            "required" => "Kunci Jawaban harus diisi.",
            "regex_match" => "Kunci Jawaban tidak valid."
         ]);
      }
      if ($validation->withRequest($this->request)->run() == false) {
         return $this->respond([
            "message" => "Failed to save changes.",
            "status" => 400,
            "errors" => $validation->getErrors()
         ]);
      }
      $answer_key = $input['answer_key'] ? htmlentities($input['answer_key'], ENT_QUOTES, 'UTF-8') : null;
      $question_text = htmlentities($input['question_text'], ENT_QUOTES, 'UTF-8');
      $data = [
         "question_type" => $question_type,
         "question_text" => $question_text,
         "choice" => json_encode($choices),
         "answer_key" => $answer_key
      ];
      die;
      $result = $this->m_question->create_question($data);
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

   public function update($question_id)
   {
      $validation = \Config\Services::validation();
      $validation->setRules($this->rules, $this->errors);
      parse_str(file_get_contents('php://input'), $input);
      $question_type = htmlentities($input['question_type'], ENT_QUOTES, 'UTF-8');
      $choices = [];
      if ($question_type == 'mc') {
         // Add more validation
         $num_choice = count($input['choice']);
         if ($num_choice < 2) {
            $validation->setError("choice", "Pilihan harus lebih dari 1.");
         }
         foreach ($input['choice'] as $key => $value) {
            $choices[] = htmlentities($value, ENT_QUOTES, 'UTF-8');
            if (strip_tags($value) == '') {
               $validation->setError("choice[$key]", "Pilihan harus diisi.");
            }
         }
         $validation->setRule('answer_key', null, "required|regex_match[/^[0-" . ($num_choice - 1) . "]/]", [
            "required" => "Kunci Jawaban harus diisi.",
            "regex_match" => "Kunci Jawaban tidak valid."
         ]);
      }
      if ($validation->withRequest($this->request)->run() == false) {
         return $this->respond([
            "message" => "Failed to save changes.",
            "status" => 400,
            "errors" => $validation->getErrors()
         ]);
      }
      $answer_key = $input['answer_key'] ? htmlentities($input['answer_key'], ENT_QUOTES, 'UTF-8') : null;
      $question_text = htmlentities($input['question_text'], ENT_QUOTES, 'UTF-8');
      $data = [
         "question_text" => $question_text,
         "choice" => json_encode($choices),
         "answer_key" => $answer_key
      ];
      $where = [
         "question_id" => $question_id,
         "question_type" => $question_type
      ];
      $result = $this->m_question->update_question($data, $where);
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

   public function delete($question_id)
   {
      $where = [
         "question_id" => $question_id
      ];
      try {
         $this->m_question->delete_question($where);
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
