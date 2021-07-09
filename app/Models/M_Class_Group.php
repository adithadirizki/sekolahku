<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Class_Group extends Model
{
   protected $table = 'tb_class_group';
	protected $primaryKey = 'class_group_id';
   protected $allowedFields = ['class_group_code', 'class', 'major', 'unit_major'];

   public function new_class_group_code()
   {
      while (true) {
         $class_group_code = '';
         $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
         for ($i = 0; $i < 6; $i++) {
            $class_group_code .= $string[rand(0, strlen($string) - 1)];
         }
         $this->selectCount('class_group_id', 'total_nums');
         $this->where(['class_group_code' => $class_group_code]);
         if ($this->get()->getFirstRow('object')->total_nums == 0) {
            break;
         }
      }
      return $class_group_code;
   }
   
   public function total_class_group()
   {
      $this->selectCount('class_group_id', 'total_nums');
      $this->join('tb_class', 'class_id = class');
      $this->join('tb_major', 'major_id = major');
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function total_class_group_filtered($where, $keyword)
   {
      $this->selectCount('class_group_id', 'total_nums');
      $this->join('tb_class', 'class_id = class');
      $this->join('tb_major', 'major_id = major');
      $this->groupStart();
      $this->like('class_group_code', $keyword);
      $this->orLike("CONCAT_WS(' ',class_name,major_code,unit_major)", $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function class_group_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("class_group_id,class_group_code,CONCAT_WS(' ',class_name,major_code,unit_major) class_group_name");
      $this->join('tb_class', 'class_id = class');
      $this->join('tb_major', 'major_id = major');
      $this->groupStart();
      $this->like('class_group_code', $keyword);
      $this->orLike("CONCAT_WS(' ',class_name,major_code,unit_major)", $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }
   
   public function class_groups($where = [])
   {
      $this->select("class_group_id,class_group_code,CONCAT_WS(' ',class_name,major_code,unit_major) class_group_name");
      $this->join('tb_class', 'class_id = class');
      $this->join('tb_major', 'major_id = major');
      $this->where($where);
      $this->orderBy('class_name ASC,major_code ASC,unit_major ASC');
      return $this->get()->getResultObject();
   }

   public function class_group($where)
   {
      $this->select("class_group_id,class_group_code,class_id,class_name,major_id,major_name,major_code,unit_major");
      $this->join('tb_class', 'class_id = class');
      $this->join('tb_major', 'major_id = major');
      $this->where($where);
      return $this->get()->getFirstRow('object');
   }

   public function create_class_group($data)
   {
      return $this->insert($data);
   }

   public function update_class_group($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }

   public function delete_class_group($where)
   {
      $this->where($where);
      return $this->delete();
   }
}
