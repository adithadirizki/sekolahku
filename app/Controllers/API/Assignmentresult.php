<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Assignment;
use App\Models\M_Assignmentresult;
use App\Models\M_School_Year;

class Assignmentresult extends BaseController
{
   protected $m_assignment;
   protected $m_assignment_result;
   protected $m_school_year;
   protected $rules = [
      "assignment_code" => "required|is_not_unique[tb_assignment.assignment_code]",
      "answer" => "required|striptags"
   ];
   protected $errors = [
      "assignment_code" => [
         "required" => "Kode Tugas harus diisi.",
         "is_not_unique" => "Kode Tugas tidak valid."
      ],
      "answer" => [
         "required" => "Jawaban harus diisi.",
         "striptags" => "Jawaban harus diisi."
      ]
   ];

   public function __construct()
   {
      $this->m_assignment = new M_Assignment();
      $this->m_assignment_result = new M_Assignmentresult();
      $this->m_school_year = new M_School_Year();
   }

   public function create()
   {
      $validation = \Config\Services::validation();
      $validation->setRules(
         [
            "assignment_code" => "required|is_not_unique[tb_assignment.assignment_code]",
            "answer" => "required|striptags"
         ],
         [
            "assignment_code" => [
               "required" => "Kode Tugas harus diisi.",
               "is_not_unique" => "Kode Tugas tidak valid."
            ],
            "answer" => [
               "required" => "Jawaban harus diisi.",
               "striptags" => "Jawaban harus diisi."
            ]
         ]
      );
      if ($validation->withRequest($this->request)->run() == false) {
         return $this->respond([
            "message" => "Failed to submitted.",
            "status" => 400,
            "errors" => $validation->getErrors()
         ]);
      }
      parse_str(file_get_contents('php://input'), $input);
      if ($this->m_assignment_result->has_submitted($this->username, $input['assignment_code'])) {
         return $this->respond([
            "message" => "You have submitted the assignment.",
            "status" => 403,
            "error" => true
         ]);
      }
      if ($this->m_assignment->is_due($input['assignment_code'])) {
         return $this->respond([
            "message" => "Assignment is due.",
            "status" => 403,
            "error" => true
         ]);
      }
      $data['assignment'] = htmlentities($input['assignment_code'], ENT_QUOTES, 'UTF-8');
      $data['answer'] = htmlentities($input['answer'], ENT_QUOTES, 'UTF-8');
      $data['submitted_by'] = $this->username;
      $data['at_school_year'] = $this->m_school_year->school_year_now()->school_year_id;
      $result = $this->m_assignment_result->create_assignment_result($data);
      if ($result) {
         return $this->respond([
            "message" => "Submitted successfully.",
            "status" => 200,
            "error" => false
         ]);
      }
      return $this->respond([
         "message" => "Failed to submitted.",
         "status" => 400,
         "error" => true
      ]);
   }

   public function update($assignment_result_id)
   {
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
