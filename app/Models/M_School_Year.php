<?php

namespace App\Models;

use CodeIgniter\Model;

class M_School_Year extends Model
{
   protected $table = 'tb_school_year';
	protected $primaryKey = 'school_year_id';
   protected $allowedFields = ['school_year_title', 'school_year_status'];

   public function school_year_now()
   {
      $this->where('school_year_status', 1);
      return $this->get()->getFirstRow('object');
   }
   
   public function total_school_year()
   {
      $this->selectCount('school_year_id', 'total_nums');
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function total_school_year_filtered($where, $keyword)
   {
      $this->selectCount('school_year_id', 'total_nums');
      $this->groupStart();
      $this->like('school_year_title', $keyword);
      $this->orLike('school_year_status', $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function school_year_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("school_year_id,school_year_title,school_year_status");
      $this->groupStart();
      $this->like('school_year_title', $keyword);
      $this->orLike('school_year_status', $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }
   
   public function school_years($where = [])
   {
      $this->select("school_year_id,school_year_title,school_year_status");
      $this->where($where);
      $this->orderBy('school_year_title ASC');
      return $this->get()->getResultObject();
   }

   public function create_school_year($data)
   {
      if ($data['school_year_status'] == 1) {
         // Deactive School Year
         $this->set('school_year_status', 0);
         $this->where('school_year_status', 1);
         $this->update();
      }
      return $this->insert($data);
   }

   public function update_school_year($data, $where)
   {
      if ($data['school_year_status'] == 1) {
         // Deactive School Year
         $this->set('school_year_status', 0);
         $this->where('school_year_status', 1);
         $this->update();
      }
      $this->set($data);
      $this->where($where);
      $this->where('school_year_status', 0);
      return $this->update();
   }

   public function delete_school_year($where)
   {
      $this->where($where);
      $this->where('school_year_status', 0);
      return $this->delete();
   }
}
