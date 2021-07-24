<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Subject extends Model
{
   protected $table = 'tb_subject';
	protected $primaryKey = 'subject_id';
   protected $allowedFields = ['subject_name', 'subject_code'];
   
   public function total_subject()
   {
      $this->selectCount('subject_id', 'total_nums');
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function total_subject_filtered($where, $keyword)
   {
      $this->selectCount('subject_id', 'total_nums');
      $this->groupStart();
      $this->like('subject_name', $keyword);
      $this->orLike('subject_code', $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function subject_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("subject_id,subject_name,subject_code");
      $this->groupStart();
      $this->like('subject_name', $keyword);
      $this->orLike('subject_code', $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }
   
   public function subjects($where = [])
   {
      $this->select("subject_id,subject_name,subject_code");
      $this->where($where);
      $this->orderBy('subject_name ASC');
      return $this->get()->getResultObject();
   }

   public function create_subject($data)
   {
      return $this->insert($data);
   }

   public function update_subject($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }

   public function delete_subject($where)
   {
      $this->where($where);
      return $this->delete();
   }

   public function validation_multiple_subjects($whereIn)
   {
      $this->whereIn('subject_id', $whereIn);
      if ($this->countAllResults() != count($whereIn)) {
         return false;
      }
      return true;
   }
}
