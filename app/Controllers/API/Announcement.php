<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Announcement;
use App\Models\M_School_Year;

class Announcement extends BaseController
{
   protected $m_announcement;
   protected $m_school_year;
   protected $rules = [
      "announcement_title" => "required",
      "announcement_desc" => "required|striptags",
      "announcement_for" => "required|in_list[all,teacher,student]",
      "announced_at" => "required|valid_date[Y-m-d\TH:i]",
      "announced_until" => "required|valid_date[Y-m-d\TH:i]"
   ];
   protected $errors = [
      "announcement_title" => [
         "required" => "Judul Pengumuman harus diisi."
      ],
      "announcement_desc" => [
         "required" => "Deskripsi Pengumuman harus diisi.",
         "striptags" => "Deskripsi Pengumuman harus diisi."
      ],
      "announcement_for" => [
         "required" => "Kolom Ditujukan harus diisi.",
         "in_list" => "Kolom Ditujukan tidak valid."
      ],
      "announced_at" => [
         "required" => "Tgl Diumumkan harus diisi.",
         "valid_date" => "Tgl Diumumkan tidak valid."
      ],
      "announced_until" => [
         "required" => "Tgl Berakhir harus diisi.",
         "valid_date" => "Tgl Berakhir tidak valid."
      ]
   ];

   public function __construct()
   {
      $this->m_announcement = new M_Announcement();
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
         $result = $this->m_announcement->announcements($where, $limit, $offset);
         $total_nums = $this->m_announcement->total_announcement($where);
      } elseif ($this->role == 'teacher') {
         $where = [
            "announced_by" => $this->username
         ];
         $result = $this->m_announcement->announcements($where, $limit, $offset);
         $total_nums = $this->m_announcement->total_announcement($where);
      } elseif ($this->role == 'student') {
         $where = [];
         $result = $this->m_announcement->announcements_student($where, $limit, $offset);
         $total_nums = $this->m_announcement->total_announcement_student($where);
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
      if ($validation->withRequest($this->request)->run() == false) {
         return $this->respond([
            "message" => "Failed to added.",
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
      $data['announced_by'] = $this->username;
      $data['at_school_year'] = $this->m_school_year->school_year_now()->school_year_id;
      $result = $this->m_announcement->create_announcement($data);
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

   public function update($announcement_id)
   {
      if ($this->role == 'teacher') {
         if (!$this->m_announcement->have_announcement($this->username, $announcement_id)) {
            return $this->failForbidden();
         }
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
      foreach ($input as $key => $value) {
         if (is_array($value)) {
            $data[$key] = json_encode(array_map('htmlentities', $value));
         } else {
            $data[$key] = $value == null ? null : htmlentities($value, ENT_QUOTES, 'UTF-8');
         }
      }
      $where = [
         "announcement_id" => $announcement_id
      ];
      $result = $this->m_announcement->update_announcement($data, $where);
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

   public function delete($announcement_id)
   {
      if ($this->role == 'teacher') {
         if (!$this->m_announcement->have_announcement($this->username, $announcement_id)) {
            return $this->failForbidden();
         }
      }
      try {
         $this->m_announcement->delete_announcement($this->username, $announcement_id);
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
