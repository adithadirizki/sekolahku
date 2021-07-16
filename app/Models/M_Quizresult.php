<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Quizresult extends Model
{
   protected $table = 'tb_quiz_result';
	protected $primaryKey = 'quiz_result_id';
   protected $allowedFields = ['quiz', 'answer', 'essay_score', 'value', 'status', 'submitted_by', 'submitted_at', 'at_class_group'];

   public function has_submitted($username, $quiz_code)
   {
      $this->selectCount('quiz_result_id', 'total_nums');
      $this->where('quiz', $quiz_code);
      $this->where('submitted_by', $username);
      return $this->get()->getFirstRow('object')->total_nums;
   }

   public function create_quiz_result($data)
   {
      return $this->insert($data);
   }

   public function update_quiz_result($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }

   public function delete_quiz_result($where)
   {
      $this->where($where);
      return $this->delete();
   }
}
