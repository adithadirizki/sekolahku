<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Assignment extends Model
{
   protected $table = 'tb_assignment';
	protected $primaryKey = 'assignment_id';
   protected $allowedFields = ['assignment_code', 'assignment_title', 'assignment_desc', 'point', 'assigned_by', 'class_group', 'subject', 'start_at', 'due_at', 'at_school_year'];
   
   public function total_assignment()
   {
      $this->selectCount('assignment_id', 'total_nums');
      $this->join('tb_user', 'username = assigned_by');
      $this->join('tb_subject', 'subject_id = subject');
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function total_assignment_filtered($where, $keyword)
   {
      $this->selectCount('assignment_id', 'total_nums');
      $this->join('tb_user', 'username = assigned_by');
      $this->join('tb_subject', 'subject_id = subject');
      $this->groupStart();
      $this->like('assignment_title', $keyword);
      $this->orLike('assignment_code', $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function assignment_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("assignment_id,assignment_title,assignment_code,subject_name,fullname assigned,DATE_FORMAT(start_at, '%d %m %Y %H:%i') start_at");
      $this->join('tb_user', 'username = assigned_by');
      $this->join('tb_subject', 'subject_id = subject');
      $this->groupStart();
      $this->like('assignment_title', $keyword);
      $this->orLike('assignment_code', $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }
   
   public function assignments($where = [])
   {
      $this->select("assignment_id,assignment_title,assignment_code");
      $this->where($where);
      $this->orderBy('assignment_title ASC');
      return $this->get()->getResultObject();
   }

   public function assignment($assignment_code)
   {
      $this->select("assignment_id,assignment_code,assignment_title,assignment_desc,point,GROUP_CONCAT(CONCAT_WS(' ',class_name,major_code,unit_major) SEPARATOR ',') class_group_name,class_group class_group_code,subject_id,subject_code,subject_name,assigned_by,fullname assigned,start_at,due_at,school_year_title");
      $this->join('tb_user', 'username = assigned_by');
      $this->join('tb_class_group', 'JSON_CONTAINS(class_group, JSON_QUOTE(class_group_code))');
      $this->join('tb_class', 'class_id = class');
      $this->join('tb_major', 'major_id = major');
      $this->join('tb_subject', 'subject_id = subject');
      $this->join('tb_school_year', 'school_year_id = at_school_year');
      $this->where('assignment_code', $assignment_code);
      return $this->get()->getFirstRow('object');
   }

   public function create_assignment($data)
   {
      return $this->insert($data);
   }

   public function update_assignment($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }

   public function delete_assignment($where)
   {
      $this->where($where);
      return $this->delete();
   }
}
