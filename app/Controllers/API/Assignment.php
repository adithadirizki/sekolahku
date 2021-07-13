<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Assignment;

class Assignment extends BaseController
{
   protected $m_assignment;
   protected $rules = [
      "assignment_title" => "required",
      "subject" => "required|is_not_unique[tb_subject.subject_id]",
      "class_group" => "required|multiple_class_group",
      "point" => "required|numeric",
      "start_at" => "required|valid_date[Y-m-d\TH:i]",
      "due_at" => "permit_empty|valid_date[Y-m-d\TH:i]"
   ];
   protected $errors = [
      "assignment_title" => [
         "required" => "Judul Tugas harus diisi."
      ],
      "subject" => [
         "required" => "Mata Pelajaran harus diisi.",
         "is_not_unique" => "Mata Pelajaran tidak valid."
      ],
      "class_group" => [
         "required" => "Kelas harus diisi.",
         "multiple_class_group" => "Kelas tidak valid."
      ],
      "point" => [
         "required" => "Poin Tugas harus diisi.",
         "numeric" => "Poin Tugas harus berisi angka."
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
      $this->m_assignment = new M_Assignment();
   }

   public function create()
   {
      $validation = \Config\Services::validation();
      $validation->setRules($this->rules, $this->errors);
      if ($validation->withRequest($this->request)->run() == false) {
         return $this->respond([
            "message" => "Failed to added.",
            "status" => 400,
            "errors" => $validation->getErrors()
         ]);
      }
      parse_str(file_get_contents('php://input'), $input);
      $assignment_name = htmlentities($input['assignment_name'], ENT_QUOTES, 'UTF-8');
      $assignment_code = htmlentities($input['assignment_code'], ENT_QUOTES, 'UTF-8');
      $data = [
         "assignment_name" => $assignment_name,
         "assignment_code" => $assignment_code
      ];
      $result = $this->m_assignment->create_assignment($data);
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

   public function update($assignment_code)
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
            $data[$key] = htmlentities($value, ENT_QUOTES, 'UTF-8');
         }
      }
      $where = [
         "assignment_code" => $assignment_code
      ];
      $result = $this->m_assignment->update_assignment($data, $where);
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

   public function delete($assignment_code)
   {
      $where = [
         "assignment_code" => $assignment_code
      ];
      try {
         $this->m_assignment->delete_assignment($where);
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
