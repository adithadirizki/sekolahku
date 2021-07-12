<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\M_Subject;

class Subject extends BaseController
{
	protected $m_subject;
   protected $rules = [
      "subject_name" => "required",
      "subject_code" => "required"
   ];
   protected $errors = [
      "subject_name" => [
         "required" => "Nama Mata Pelajaran harus diisi."
      ],
      "subject_code" => [
         "required" => "Kode Mata Pelajaran harus diisi."
      ]
   ];

	public function __construct()
	{
		$this->m_subject = new M_Subject();
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
      $subject_name = htmlentities($input['subject_name'], ENT_QUOTES, 'UTF-8');
      $subject_code = htmlentities($input['subject_code'], ENT_QUOTES, 'UTF-8');
      $data = [
         "subject_name" => $subject_name,
         "subject_code" => $subject_code
      ];
      $result = $this->m_subject->create_subject($data);
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

   public function update($subject_id)
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
      $subject_name = htmlentities($input['subject_name'], ENT_QUOTES, 'UTF-8');
      $subject_code = htmlentities($input['subject_code'], ENT_QUOTES, 'UTF-8');
      $data = [
         "subject_name" => $subject_name,
         "subject_code" => $subject_code
      ];
      $where = [
         "subject_id" => $subject_id
      ];
      $result = $this->m_subject->update_subject($data, $where);
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

   public function delete($subject_id)
   {
      $where = [
         "subject_id" => $subject_id
      ];
      try {
         $this->m_subject->delete_subject($where);
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
