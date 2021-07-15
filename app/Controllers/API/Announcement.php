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
      "announcement_for" => "required|in_list[all,teacher,student]",
      "announced_at" => "required|valid_date[Y-m-d\TH:i]",
      "announced_until" => "required|valid_date[Y-m-d\TH:i]"
   ];
   protected $errors = [
      "announcement_title" => [
         "required" => "Judul Pengumuman harus diisi."
      ],
      "announcement_for" => [
         "required" => "Kolom ditujukan harus diisi.",
         "in_list" => "Kolom ditujukan tidak valid."
      ],
      "announced_at" => [
         "required" => "Tgl diumumkan harus diisi.",
         "valid_date" => "Tgl diumumkan tidak valid."
      ],
      "announced_until" => [
         "required" => "Tgl berakhir harus diisi.",
         "valid_date" => "Tgl berakhir tidak valid."
      ]
   ];

   public function __construct()
   {
      $this->m_announcement = new M_Announcement();
      $this->m_school_year = new M_School_Year();
   }

   public function create()
   {
      $validation = \Config\Services::validation();
      $validation->setRules($this->rules, $this->errors);
      $validation->setRule('announcement_desc', null, "required|striptags", [
         "required" => "Deskripsi Pengumuman harus diisi.",
         "striptags" => "Deskripsi Pengumuman harus diisi."
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
      $validation = \Config\Services::validation();
      $validation->setRules($this->rules, $this->errors);
      $validation->setRule('announcement_desc', null, "required|striptags", [
         "required" => "Deskripsi Pengumuman harus diisi.",
         "striptags" => "Deskripsi Pengumuman harus diisi."
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
