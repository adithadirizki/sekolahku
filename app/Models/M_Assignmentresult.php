<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Assignmentresult extends Model
{
   protected $table = 'tb_assignment_result';
	protected $primaryKey = 'assignment_result_id';
   protected $allowedFields = ['assignment', 'answer', 'value', 'submitted_by', 'submitted_at', 'at_class_group'];
   
   public function total_assignment_result()
   {
      $this->selectCount('assignment_result_id', 'total_nums');
      $this->join('tb_assignment', 'assignment_code = assignment');
      $this->join('tb_user', 'username = submitted_by');
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function total_assignment_result_filtered($where, $keyword)
   {
      $this->selectCount('assignment_result_id', 'total_nums');
      $this->join('tb_assignment', 'assignment_code = assignment');
      $this->join('tb_user', 'username = submitted_by');
      $this->groupStart();
      $this->like('assignment', $keyword);
      $this->orLike('assignment_title', $keyword);
      $this->orLike('value', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike("DATE_FORMAT(submitted_at, '%d/%m/%Y %H:%i')", $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function assignment_result_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("assignment_result_id,assignment assignment_code,assignment_title,value,fullname created,DATE_FORMAT(submitted_at, '%d/%m/%Y %H:%i') submitted_at");
      $this->join('tb_assignment', 'assignment_code = assignment');
      $this->join('tb_user', 'username = submitted_by');
      $this->groupStart();
      $this->like('assignment', $keyword);
      $this->orLike('assignment_title', $keyword);
      $this->orLike('value', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike("DATE_FORMAT(submitted_at, '%d/%m/%Y %H:%i')", $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }

   public function detail_assignment_result($assignment_result_id)
   {
      $this->select('tb_assignment_result.*,fullname submitted,submitted_at');
      $this->join('tb_user', 'username = submitted_by');
      $this->join('tb_assignment', 'assignment_code = assignment');
      $this->where('assignment_result_id', $assignment_result_id);
      return $this->get(1)->getFirstRow('object');
   }

   public function has_submitted($username, $assignment_code)
   {
      $this->select('1');
      $this->where('assignment', $assignment_code);
      $this->where('submitted_by', $username);
      return $this->get(1)->getFirstRow('object');
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
