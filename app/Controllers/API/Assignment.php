<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Assignment;
use App\Models\M_School_Year;

class Assignment extends BaseController
{
   protected $m_assignment;
   protected $m_school_year;
   protected $rules = [
      "assignment_title" => "required",
      "subject" => "required|is_not_unique[tb_subject.subject_id]",
      "class_group*" => "required|multiple_class_group",
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
      "class_group*" => [
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
      $this->m_school_year = new M_School_Year();
   }

   public function create()
   {
      $validation = \Config\Services::validation();
      $validation->setRules($this->rules, $this->errors);
      $validation->setRule('assignment_desc', null, "required|striptags", [
         "required" => "Deskripsi Tugas harus diisi.",
         "striptags" => "Deskripsi Tugas harus diisi."
      ]);
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
      $data['assignment_code'] = $this->m_assignment->new_assignment_code();
      $data['assigned_by'] = $this->username;
      $data['at_school_year'] = $this->m_school_year->school_year_now()->school_year_id;
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

   public function copy($assignment_code)
   {
      $new_assignment_code = $this->m_assignment->new_assignment_code();
      $assigned_by = $this->username;
      $school_year_id = $this->m_school_year->school_year_now()->school_year_id;
      $sql = "INSERT INTO tb_assignment (assignment_code,assignment_title,assignment_desc,point,assigned_by,class_group,subject,start_at,due_at,at_school_year)
         SELECT '$new_assignment_code',assignment_title,assignment_desc,point,'$assigned_by',class_group,subject,start_at,due_at,'$school_year_id' FROM tb_assignment
         WHERE assignment_code = '$assignment_code'";
      try {
         $this->m_assignment->query($sql);
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

   public function update($assignment_code)
   {
      $validation = \Config\Services::validation();
      $validation->setRules($this->rules, $this->errors);
      $validation->setRule('assignment_desc', null, "required|striptags", [
         "required" => "Deskripsi Tugas harus diisi.",
         "striptags" => "Deskripsi Tugas harus diisi."
      ]);
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