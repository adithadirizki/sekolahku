<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Teacher extends Model
{
   protected $table = 'tb_teacher';
	protected $primaryKey = 'teacher_id';
   protected $allowedFields = ['teacher_username', 'nip', 'dob', 'pob', 'gender', 'religion', 'address', 'phone'];
   
   public function total_teacher()
   {
      $this->selectCount('teacher_id', 'total_nums');
      $this->join('tb_user', 'username = teacher_username');
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function total_teacher_filtered($where, $keyword)
   {
      $this->selectCount('teacher_id', 'total_nums');
      $this->join('tb_user', 'username = teacher_username');
      $this->groupStart();
      $this->like('username', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike('nip', $keyword);
      $this->orLike('religion', $keyword);
      $this->orLike('phone', $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function teacher_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("teacher_id,username,fullname,nip,gender,religion,phone");
      $this->join('tb_user', 'username = teacher_username');
      $this->groupStart();
      $this->like('username', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike('nip', $keyword);
      $this->orLike('religion', $keyword);
      $this->orLike('phone', $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }

   public function teacher($username)
   {
      $this->where('teacher_username', $username);
      return $this->get()->getFirstRow('object');
   }

   public function teacher_account($username)
   {
      $this->select('tb_teacher.*,photo,fullname,email,password,is_active');
      $this->join('tb_user', 'username = teacher_username');
      $this->where('teacher_username', $username);
      return $this->get()->getFirstRow('object');
   }
}
