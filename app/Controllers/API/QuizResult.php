<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Quizresult;

class Quizresult extends BaseController
{
   protected $m_quiz_result;

   public function __construct()
   {
      $this->m_quiz_result = new M_Quizresult();
   }

   public function update($quiz_result_id)
   {
      parse_str(file_get_contents('php://input'), $input);
      $validation = \Config\Services::validation();
      $validation->setRules(
         [
            "value" => "required|numeric"
         ],
         [
            "value" => [
               "required" => "Nilai Akhir harus diisi.",
               "numeric" => "Nilai Akhir harus diisi."
            ]
         ]
      );
      if (isset($input['essay_score'])) {
         foreach ($input['essay_score'] as $key => $value) {
            $validation->setRule("essay_score.$key", null, "required|regex_match[/^[0-9][0-0]?$|^100$/]", [
               "required" => "Skor Essai harus diisi.",
               "regex_match" => "Skor Essai harus terdiri dari angka 0 - 100."
            ]);
         }
      }
      if ($validation->withRequest($this->request)->run() == false) {
         return $this->respond([
            "message" => "Failed to save changes.",
            "status" => 400,
            "errors" => $validation->getErrors()
         ]);
      }
      $data['value'] = htmlentities($input['value'], ENT_QUOTES, 'UTF-8');
      $data['essay_score'] = json_encode($input['essay_score']);
      $where = [
         "quiz_result_id" => $quiz_result_id
      ];
      $result = $this->m_quiz_result->update_quiz_result($data, $where);
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

   public function delete($quiz_result_id)
   {
      $where = [
         "quiz_result_id" => $quiz_result_id
      ];
      try {
         $this->m_quiz_result->delete_quiz_result($where);
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
