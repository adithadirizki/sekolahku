<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Class extends Model
{
   protected $table = 'tb_class';
   protected $primaryKey = 'class_id';
   protected $allowedFields = ['class_name'];

   public function total_class()
   {
      $this->selectCount('class_id', 'total_nums');
      return $this->get()->getFirstRow('object')->total_nums;
   }

   public function total_class_filtered($where, $keyword)
   {
      $this->selectCount('class_id', 'total_nums');
      $this->groupStart();
      $this->like('class_name', $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get()->getFirstRow('object')->total_nums;
   }

   public function class_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("class_id,class_name");
      $this->groupStart();
      $this->like('class_name', $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }

   public function classes($where = [])
   {
      $this->select("class_id,class_name");
      $this->where($where);
      $this->orderBy('class_name ASC');
      return $this->get()->getResultObject();
   }

   public function create_class($data)
   {
      return $this->insert($data);
   }

   public function update_class($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }

   public function delete_class($where)
   {
      $this->where($where);
      return $this->delete();
   }
}
