<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Major;

class Major extends BaseController
{
   protected $m_major;
   protected $rules = [
      "major_name" => "required",
      "major_code" => "required|alphanumeric"
   ];
   protected $errors = [
      "major_name" => [
         "required" => "Nama Jurusan harus diisi."
      ],
      "major_code" => [
         "required" => "Kode Jurusan harus diisi.",
         "alphanumeric" => "Kode Jurusan harus terdiri dari huruf atau angka."
      ]
   ];

   public function __construct()
   {
      $this->m_major = new M_Major();
   }

   public function create()
   {
      if ($this->role != 'superadmin') {
         return $this->failForbidden();
      }
      
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
      $major_name = htmlentities($input['major_name'], ENT_QUOTES, 'UTF-8');
      $major_code = htmlentities($input['major_code'], ENT_QUOTES, 'UTF-8');
      $data = [
         "major_name" => $major_name,
         "major_code" => $major_code
      ];
      $result = $this->m_major->create_major($data);
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

   public function update($major_id)
   {
      if ($this->role != 'superadmin') {
         return $this->failForbidden();
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
      $major_name = htmlentities($input['major_name'], ENT_QUOTES, 'UTF-8');
      $major_code = htmlentities($input['major_code'], ENT_QUOTES, 'UTF-8');
      $data = [
         "major_name" => $major_name,
         "major_code" => $major_code
      ];
      $where = [
         "major_id" => $major_id
      ];
      $result = $this->m_major->update_major($data, $where);
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

   public function delete($major_id)
   {
      if ($this->role != 'superadmin') {
         return $this->failForbidden();
      }
      
      $where = [
         "major_id" => $major_id
      ];
      try {
         $this->m_major->delete_major($where);
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
