<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Major extends Model
{
   protected $table = 'tb_major';
	protected $primaryKey = 'major_id';
   protected $allowedFields = ['major_name', 'major_code'];
   
   public function total_major()
   {
      $this->selectCount('major_id', 'total_nums');
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function total_major_filtered($where, $keyword)
   {
      $this->selectCount('major_id', 'total_nums');
      $this->groupStart();
      $this->like('major_name', $keyword);
      $this->orLike('major_code', $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function major_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("major_id,major_name,major_code");
      $this->groupStart();
      $this->like('major_name', $keyword);
      $this->orLike('major_code', $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }
   
   public function majors($where = [])
   {
      $this->select("major_id,major_name,major_code");
      $this->where($where);
      $this->orderBy('major_name ASC');
      return $this->get()->getResultObject();
   }

   public function create_major($data)
   {
      return $this->insert($data);
   }

   public function update_major($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }

   public function delete_major($where)
   {
      $this->where($where);
      return $this->delete();
   }

   public function validation_multiple_majors($whereIn)
   {
      $this->whereIn('major_id', $whereIn);
      if ($this->countAllResults() != count($whereIn)) {
         return false;
      }
      return true;
   }
}
