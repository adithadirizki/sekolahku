<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Assignmentresult extends Model
{
   protected $table = 'tb_assignment_result';
	protected $primaryKey = 'assignment_result_id';
   protected $allowedFields = ['assignment', 'answer', 'value', 'submitted_by', 'submitted_at', 'at_class_group'];

   public function has_submitted($username, $assignment_code)
   {
      $this->selectCount('assignment_result_id', 'total_nums');
      $this->where('assignment', $assignment_code);
      $this->where('submitted_by', $username);
      return $this->get()->getFirstRow('object')->total_nums;
   }

   public function create_assignment_result($data)
   {
      return $this->insert($data);
   }

   public function update_assignment_result($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }

   public function delete_assignment_result($where)
   {
      $this->where($where);
      return $this->delete();
   }
}
