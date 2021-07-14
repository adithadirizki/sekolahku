<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Material;
use App\Models\M_School_Year;

class Material extends BaseController
{
   protected $m_material;
   protected $m_school_year;
   protected $rules = [
      "material_title" => "required",
      "subject" => "required|is_not_unique[tb_subject.subject_id]",
      "class_group*" => "required|multiple_class_group",
      "publish_at" => "required|valid_date[Y-m-d\TH:i]"
   ];
   protected $errors = [
      "material_title" => [
         "required" => "Judul Materi harus diisi."
      ],
      "subject" => [
         "required" => "Mata Pelajaran harus diisi.",
         "is_not_unique" => "Mata Pelajaran tidak valid."
      ],
      "class_group*" => [
         "required" => "Kelas harus diisi.",
         "multiple_class_group" => "Kelas tidak valid."
      ],
      "publish_at" => [
         "required" => "Tgl dibuat harus diisi.",
         "valid_date" => "Tgl dibuat tidak valid."
      ]
   ];

   public function __construct()
   {
      $this->m_material = new M_Material();
      $this->m_school_year = new M_School_Year();
   }

   public function create()
   {
      $validation = \Config\Services::validation();
      $validation->setRules($this->rules, $this->errors);
      $validation->setRule('material_desc', null, "required|striptags", [
         "required" => "Deskripsi Materi harus diisi.",
         "striptags" => "Deskripsi Materi harus diisi."
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
      $data['material_code'] = $this->m_material->new_material_code();
      $data['created_by'] = $this->username;
      $data['at_school_year'] = $this->m_school_year->school_year_now()->school_year_id;
      $result = $this->m_material->create_material($data);
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

   public function copy($material_code)
   {
      $new_material_code = $this->m_material->new_material_code();
      $created_by = $this->username;
      $school_year_id = $this->m_school_year->school_year_now()->school_year_id;
      $sql = "INSERT INTO tb_material (material_code,material_title,material_desc,created_by,class_group,subject,publish_at,at_school_year) SELECT '$new_material_code',material_title,material_desc,'$created_by',class_group,subject,publish_at,'$school_year_id' FROM tb_material WHERE material_code = '$material_code'";
      try {
         $this->m_material->query($sql);
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

   public function update($material_code)
   {
      $validation = \Config\Services::validation();
      $validation->setRules($this->rules, $this->errors);
      $validation->setRule('material_desc', null, "required|striptags", [
         "required" => "Deskripsi Materi harus diisi.",
         "striptags" => "Deskripsi Materi harus diisi."
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
         "material_code" => $material_code
      ];
      $result = $this->m_material->update_material($data, $where);
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

   public function delete($material_code)
   {
      $where = [
         "material_code" => $material_code
      ];
      try {
         $this->m_material->delete_material($where);
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
