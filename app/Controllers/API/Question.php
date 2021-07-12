<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Question;

class Question extends BaseController
{
   protected $m_question;
   protected $rules = [
      "question_type" => "required|in_list[mc,essay]",
      "question_text" => "required|striptags"
   ];
   protected $errors = [
      "question_type" => [
         "required" => "Tipe Soal harus diisi.",
         "in_list" => "Tipe Soal tidak valid."
      ],
      "question_text" => [
         "required" => "Pertanyaan harus diisi.",
         "striptags" => "Pertanyaan harus diisi."
      ]
   ];

   public function __construct()
   {
      $this->m_question = new M_Question();
   }

   public function create()
   {
      parse_str(file_get_contents('php://input'), $input);
      if ($errors = $this->question_validation($input, $this->request)) {
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
      parse_str(file_get_contents('php://input'), $input);
      if ($errors = $this->question_validation($input, $this->request)) {
         return $this->respond([
            "message" => "Failed to save changes.",
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

   public function question_validation($input, $request)
   {
      $rules = [
         "question_type" => "required|in_list[mc,essay]",
         "question_text" => "required|striptags"
      ];
      $errors = [
         "question_type" => [
            "required" => "Tipe Soal harus diisi.",
            "in_list" => "Tipe Soal tidak valid."
         ],
         "question_text" => [
            "required" => "Pertanyaan harus diisi.",
            "striptags" => "Pertanyaan harus diisi."
         ]
      ];
      $validation = \Config\Services::validation();
      $validation->setRules($rules, $errors);
      if (isset($input['question_type']) && $input['question_type'] == 'mc') {
         // Add more validation
         $validation->setRule('choice', null, "required|striptags", [
            "required" => "Pilihan harus diisi.",
            "striptags" => "Pilihan harus diisi.",
            "choicelength" => "Pilihan harus lebih dari 1."
         ]);
         $validation->setRule('answer_key', null, "required|anskey", [
            "required" => "Kunci Jawaban harus diisi.",
            "anskey" => "Kunci Jawaban tidak valid."
         ]);
      }
      if ($validation->withRequest($request)->run() == false) {
         return $validation->getErrors();
      }
      return false;
   }
}
