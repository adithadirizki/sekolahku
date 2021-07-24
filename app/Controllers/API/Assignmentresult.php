<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Assignmentresult;

class Assignmentresult extends BaseController
{
   protected $m_assignment_result;

   public function __construct()
   {
      $this->m_assignment_result = new M_Assignmentresult();
   }

   public function update($assignment_result_id)
   {
      if ($this->role == 'student') {
         return $this->failForbidden();
      }

      if ($this->role == 'teacher') {
         if (!$this->m_assignment_result->have_assignment($this->username, $assignment_result_id)) {
            return $this->failForbidden();
         }
      }

      $validation = \Config\Services::validation();
      $validation->setRules(
         [
            "value" => "required|numeric"
         ],
         [
            "value" => [
               "required" => "Nilai harus diisi.",
               "numeric" => "Nilai harus terdiri dari angka."
            ]
         ]
      );
      if ($validation->withRequest($this->request)->run() == false) {
         return $this->respond([
            "message" => "Failed to save changes.",
            "status" => 400,
            "errors" => $validation->getErrors()
         ]);
      }
      parse_str(file_get_contents('php://input'), $input);
      $data['value'] = htmlentities($input['value'], ENT_QUOTES, 'UTF-8');
      $where = [
         "assignment_result_id" => $assignment_result_id
      ];
      $result = $this->m_assignment_result->update_assignment_result($data, $where);
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

   public function delete($assignment_result_id)
   {
      if ($this->role == 'student') {
         return $this->failForbidden();
      }
      
      if ($this->role == 'teacher') {
         if (!$this->m_assignment_result->have_assignment($this->username, $assignment_result_id)) {
            return $this->failForbidden();
         }
      }

      $where = [
         "assignment_result_id" => $assignment_result_id
      ];
      try {
         $this->m_assignment_result->delete_assignment_result($where);
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
