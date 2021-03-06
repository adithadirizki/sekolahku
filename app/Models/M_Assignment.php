<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Assignment extends Model
{
   protected $table = 'tb_assignment';
	protected $primaryKey = 'assignment_id';
   protected $allowedFields = ['assignment_code', 'assignment_title', 'assignment_desc', 'point', 'assigned_by', 'class_group', 'subject', 'start_at', 'due_at', 'at_school_year'];

   public function new_assignment_code()
   {
      while (true) {
         $assignment_code = '';
         $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
         for ($i = 0; $i < 6; $i++) {
            $assignment_code .= $string[rand(0, strlen($string) - 1)];
         }
         $this->selectCount('assignment_id', 'total_nums');
         $this->where(['assignment_code' => $assignment_code]);
         if ($this->get(1)->getFirstRow('object')->total_nums == 0) {
            break;
         }
      }
      return $assignment_code;
   }
   
   public function total_assignment($where = [])
   {
      $this->selectCount('assignment_id', 'total_nums');
      // $this->join('tb_user', 'username = assigned_by');
      // $this->join('tb_subject', 'subject_id = subject');
      $this->where($where);
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function total_assignment_filtered($where, $keyword)
   {
      $this->selectCount('assignment_id', 'total_nums');
      $this->join('tb_user', 'username = assigned_by');
      $this->join('tb_subject', 'subject_id = subject');
      $this->groupStart();
      $this->like('assignment_code', $keyword);
      $this->orLike('assignment_title', $keyword);
      $this->orLike('subject_name', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike("DATE_FORMAT(start_at, '%d %b %Y %H:%i')", $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function assignment_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("assignment_id,assignment_title,assignment_code,subject_name,fullname assigned,start_at");
      $this->join('tb_user', 'username = assigned_by');
      $this->join('tb_subject', 'subject_id = subject');
      $this->groupStart();
      $this->like('assignment_code', $keyword);
      $this->orLike('assignment_title', $keyword);
      $this->orLike('subject_name', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike("DATE_FORMAT(start_at, '%d %b %Y %H:%i')", $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }
   
   public function assignments($where = [], $limit = 0, $offset = 0)
   {
      $this->where($where);
      $this->limit($limit, $offset);
      $this->orderBy('start_at DESC');
      return $this->get()->getResultObject();
   }
   
   public function total_assignment_student($class, $where = [])
   {
      $this->selectCount('assignment_id', 'total_nums');
      // $this->join('tb_student', "JSON_CONTAINS(class_group, JSON_QUOTE('$class'))");
      // $this->join('tb_assignment_result', 'assignment = assignment_code AND submitted_by = student_username', 'left');
      // $this->join('tb_subject', 'subject_id = subject');
      $this->where($where);
      $this->where('NOW() > start_at');
      $this->where("JSON_CONTAINS(class_group, JSON_QUOTE('$class'))");
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function assignments_student($class, $where = [], $limit = 0, $offset = 0)
   {
      $this->select('assignment_code,assignment_title,start_at,due_at,assignment_result_id,subject_name,subject_code');
      $this->join('tb_student', "JSON_CONTAINS(class_group, JSON_QUOTE('$class'))");
      $this->join('tb_assignment_result', 'assignment = assignment_code AND submitted_by = student_username', 'left');
      $this->join('tb_subject', 'subject_id = subject');
      $this->where($where);
      $this->where('NOW() > start_at');
      $this->limit($limit, $offset);
      $this->orderBy('start_at DESC');
      $this->groupBy('assignment_code');
      return $this->get()->getResultObject();
   }

   public function assignment($where)
   {
      $this->where($where);
      return $this->get(1)->getFirstRow('object');
   }

   public function detail_assignment($assignment_code)
   {
      $this->select("assignment_id,assignment_code,assignment_title,assignment_desc,point,GROUP_CONCAT(CONCAT_WS(' ',class_name,major_code,unit_major) SEPARATOR ',') class_group_name,class_group class_group_code,subject_id,subject_code,subject_name,assigned_by,fullname assigned,start_at,due_at,school_year_title");
      $this->join('tb_user', 'username = assigned_by');
      $this->join('tb_class_group', 'JSON_CONTAINS(class_group, JSON_QUOTE(class_group_code))');
      $this->join('tb_class', 'class_id = class');
      $this->join('tb_major', 'major_id = major');
      $this->join('tb_subject', 'subject_id = subject');
      $this->join('tb_school_year', 'school_year_id = at_school_year');
      $this->where('assignment_code', $assignment_code);
      $this->groupBy('assignment_code');
      return $this->get(1)->getFirstRow('object');
   }

   public function detail_assignment_teacher($username, $assignment_code)
   {
      $this->select("assignment_id,assignment_code,assignment_title,assignment_desc,point,GROUP_CONCAT(CONCAT_WS(' ',class_name,major_code,unit_major) SEPARATOR ',') class_group_name,class_group class_group_code,subject_id,subject_code,subject_name,start_at,due_at,school_year_title");
      $this->join('tb_class_group', 'JSON_CONTAINS(class_group, JSON_QUOTE(class_group_code))');
      $this->join('tb_class', 'class_id = class');
      $this->join('tb_major', 'major_id = major');
      $this->join('tb_subject', 'subject_id = subject');
      $this->join('tb_school_year', 'school_year_id = at_school_year');
      $this->where('assignment_code', $assignment_code);
      $this->where('assigned_by', $username);
      $this->groupBy('assignment_code');
      return $this->get(1)->getFirstRow('object');
   }

   public function detail_assignment_student($username, $assignment_code)
   {
      $this->select("assignment_id,assignment_code,assignment_title,assignment_desc,point,subject_id,subject_code,subject_name,assigned_by,fullname assigned,start_at,due_at,assignment_result_id,answer,value,submitted_at");
      $this->join('tb_user', 'username = assigned_by');
      $this->join('tb_subject', 'subject_id = subject');
      $this->join('tb_assignment_result', "assignment = assignment_code AND submitted_by = '$username'", 'left');
      $this->where('assignment_code', $assignment_code);
      $this->where('NOW() > start_at');
      $this->groupBy('assignment_code');
      return $this->get(1)->getFirstRow('object');
   }

   public function is_due($assignment_code)
   {
      $this->select('1');
      $this->where('NOW() > due_at');
      $this->where('assignment_code', $assignment_code);
      return $this->get(1)->getFirstRow('object');
   }

   public function have_assignment($username, $assignment_code)
   {
      $this->select('1');
      $this->where('assignment_code', $assignment_code);
      $this->where('assigned_by', $username);
      return $this->get(1)->getFirstRow('object');
   }

   public function have_assignment_student($class, $assignment_code)
   {
      $this->select('1');
      $this->where('assignment_code', $assignment_code);
      $this->where("JSON_CONTAINS(class_group, JSON_QUOTE('$class'))");
      return $this->get(1)->getFirstRow('object');
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
