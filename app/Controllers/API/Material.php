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

   public function getAll()
   {
      $validation = \Config\Services::validation();
      $validation->setRules(
         [
            "page" => "required|is_natural_no_zero"
         ],
         [
            "page" => [
               "required" => "Parameter is invalid.",
               "is_natural_no_zero" => "Parameter is invalid."
            ]
         ]
      );
      if ($validation->withRequest($this->request)->run() === false) {
         return $this->respond([
            "message" => "ERROR!",
            "status" => 400,
            "errors" => $validation->getErrors(),
         ]);
      }
      $limit = 10;
      $offset = ($_POST['page'] - 1) * $limit;
      if ($this->role == 'superadmin') {
         $where = [];
         $result = $this->m_material->materials($where, $limit, $offset);
         $total_nums = $this->m_material->total_material($where);
      } elseif ($this->role == 'teacher') {
         $where = [
            "assigned_by" => $this->username
         ];
         $result = $this->m_material->materials($where, $limit, $offset);
         $total_nums = $this->m_material->total_material($where);
      } elseif ($this->role == 'student') {
         $where = [];
         $result = $this->m_material->materials_student($this->class, $where, $limit, $offset);
         $total_nums = $this->m_material->total_material_student($this->class, $where);
      }
      return $this->respond([
         "message" => "OK",
         "status" => 200,
         "error" => false,
         "data" => $result,
         "total_nums" => $total_nums
      ]);
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
      if ($this->role == 'superadmin') {
         $sql = "INSERT INTO tb_material (material_code,material_title,material_desc,created_by,class_group,subject,publish_at,at_school_year) SELECT '$new_material_code',material_title,material_desc,'$created_by',class_group,subject,publish_at,'$school_year_id' FROM tb_material WHERE material_code = '$material_code'";
      } elseif ($this->role == 'teacher') {
         $sql = "INSERT INTO tb_material (material_code,material_title,material_desc,created_by,publish_at,at_school_year) SELECT '$new_material_code',material_title,material_desc,'$created_by',publish_at,'$school_year_id' FROM tb_material WHERE material_code = '$material_code'";
      }
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
      if ($this->role == 'teacher') {
         if (!$this->m_material->have_material($this->username, $material_code)) {
            return $this->failForbidden();
         }
      }
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
      if ($this->role == 'teacher') {
         if (!$this->m_material->have_material($this->username, $material_code)) {
            return $this->failForbidden();
         }
      }
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
