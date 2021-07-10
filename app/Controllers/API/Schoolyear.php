<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_School_Year;
use CodeIgniter\API\ResponseTrait;

class Schoolyear extends BaseController
{
	use ResponseTrait;
	protected $m_school_year;
   protected $rules = [
      "school_year_title" => "required",
      "school_year_status" => "required|in_list[0,1]"
   ];
   protected $errors = [
      "school_year_title" => [
         "required" => "Tahun Pelajaran harus diisi."
      ],
      "school_year_status" => [
         "required" => "Status harus diisi.",
         "in_list" => "Status tidak valid."
      ]
   ];

	public function __construct()
	{
		$this->m_school_year = new M_School_Year();
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
      $school_year_title = htmlentities($input['school_year_title'], ENT_QUOTES, 'UTF-8');
      $school_year_status = htmlentities($input['school_year_status'], ENT_QUOTES, 'UTF-8');
      $data = [
         "school_year_title" => $school_year_title,
         "school_year_status" => $school_year_status
      ];
      $result = $this->m_school_year->create_school_year($data);
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

   public function update($school_year_id)
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
      $school_year_title = htmlentities($input['school_year_title'], ENT_QUOTES, 'UTF-8');
      $school_year_status = htmlentities($input['school_year_status'], ENT_QUOTES, 'UTF-8');
      $data = [
         "school_year_title" => $school_year_title,
         "school_year_status" => $school_year_status
      ];
      $where = [
         "school_year_id" => $school_year_id
      ];
      $result = $this->m_school_year->update_school_year($data, $where);
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

   public function delete($school_year_id)
   {
      $where = [
         "school_year_id" => $school_year_id
      ];
      try {
         $this->m_school_year->delete_school_year($where);
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
