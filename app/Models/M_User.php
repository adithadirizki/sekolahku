<?php

namespace App\Models;

use CodeIgniter\Model;

class M_User extends Model
{
   protected $table = 'tb_user';
	protected $primaryKey = 'user_id';
   protected $allowedFields = ['username', 'photo', 'fullname', 'email', 'password', 'role', 'activation_code', 'token', 'token_expired', 'is_active', 'registered_at'];
   
   public function total_user()
   {
      $this->selectCount('user_id', 'total_nums');
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function total_user_filtered($where, $keyword)
   {
      $this->selectCount('user_id', 'total_nums');
      $this->groupStart();
      $this->like('username', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike('email', $keyword);
      $this->orLike('registered_at', $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function user_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("user_id,username,photo,fullname,email,password,role,is_active,registered_at");
      $this->groupStart();
      $this->like('username', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike('email', $keyword);
      $this->orLike('registered_at', $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }

   public function user($where)
   {
      $this->where($where);
      return $this->get()->getFirstRow('object');
   }

   public function update_user($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }
}
