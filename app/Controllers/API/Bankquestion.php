<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Bank_Question;
use CodeIgniter\API\ResponseTrait;

class Bankquestion extends BaseController
{
   use ResponseTrait;
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
      $this->m_bank_question = new M_Bank_Question();
   }

   public function create()
   {
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
}
