<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Student extends Model
{
   protected $table = 'tb_student';
	protected $primaryKey = 'student_id';
   protected $allowedFields = ['student_username', 'nis', 'dob', 'pob', 'gender', 'religion', 'address', 'phone', 'curr_class_group', 'class_history'];
   
   public function total_student()
   {
      $this->selectCount('student_id', 'total_nums');
      $this->join('tb_user', 'username = student_username');
      $this->join('tb_class_group', 'class_group_code = curr_class_group');
      $this->join('tb_class', 'class_id = class');
      $this->join('tb_major', 'major_id = major');
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function total_student_filtered($where, $keyword)
   {
      $this->selectCount('student_id', 'total_nums');
      $this->join('tb_user', 'username = student_username');
      $this->join('tb_class_group', 'class_group_code = curr_class_group');
      $this->join('tb_class', 'class_id = class');
      $this->join('tb_major', 'major_id = major');
      $this->groupStart();
      $this->like('username', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike('nis', $keyword);
      $this->orLike('religion', $keyword);
      $this->orLike('phone', $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function student_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("student_id,username,fullname,nis,CONCAT_WS(' ',class_name,major_code,unit_major) class_group_name,gender,religion,phone");
      $this->join('tb_user', 'username = student_username');
      $this->join('tb_class_group', 'class_group_code = curr_class_group');
      $this->join('tb_class', 'class_id = class');
      $this->join('tb_major', 'major_id = major');
      $this->groupStart();
      $this->like('username', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike('nis', $keyword);
      $this->orLike('religion', $keyword);
      $this->orLike('phone', $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }
}
