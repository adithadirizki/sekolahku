<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Material extends Model
{
   protected $table = 'tb_material';
	protected $primaryKey = 'material_id';
   protected $allowedFields = ['material_code', 'material_title', 'material_desc', 'point', 'created_by', 'class_group', 'subject', 'publish_at', 'due_at', 'at_school_year'];

   public function new_material_code()
   {
      while (true) {
         $material_code = '';
         $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
         for ($i = 0; $i < 6; $i++) {
            $material_code .= $string[rand(0, strlen($string) - 1)];
         }
         $this->selectCount('material_id', 'total_nums');
         $this->where(['material_code' => $material_code]);
         if ($this->get()->getFirstRow('object')->total_nums == 0) {
            break;
         }
      }
      return $material_code;
   }
   
   public function total_material()
   {
      $this->selectCount('material_id', 'total_nums');
      $this->join('tb_user', 'username = created_by');
      $this->join('tb_subject', 'subject_id = subject');
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function total_material_filtered($where, $keyword)
   {
      $this->selectCount('material_id', 'total_nums');
      $this->join('tb_user', 'username = created_by');
      $this->join('tb_subject', 'subject_id = subject');
      $this->groupStart();
      $this->like('material_code', $keyword);
      $this->orLike('material_title', $keyword);
      $this->orLike('subject_name', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike("DATE_FORMAT(publish_at, '%d %m %Y %H:%i')", $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function material_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("material_id,material_title,material_code,subject_name,fullname created,DATE_FORMAT(publish_at, '%d %m %Y %H:%i') publish_at");
      $this->join('tb_user', 'username = created_by');
      $this->join('tb_subject', 'subject_id = subject');
      $this->groupStart();
      $this->like('material_code', $keyword);
      $this->orLike('material_title', $keyword);
      $this->orLike('subject_name', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike("DATE_FORMAT(publish_at, '%d %m %Y %H:%i')", $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }
   
   public function materials($where = [])
   {
      $this->select("material_id,material_title,material_code");
      $this->where($where);
      $this->orderBy('material_title ASC');
      return $this->get()->getResultObject();
   }

   public function material($material_code)
   {
      $this->select("material_id,material_code,material_title,material_desc,GROUP_CONCAT(CONCAT_WS(' ',class_name,major_code,unit_major) SEPARATOR ',') class_group_name,class_group class_group_code,subject_id,subject_code,subject_name,created_by,fullname created,publish_at,school_year_title");
      $this->join('tb_user', 'username = created_by');
      $this->join('tb_class_group', 'JSON_CONTAINS(class_group, JSON_QUOTE(class_group_code))');
      $this->join('tb_class', 'class_id = class');
      $this->join('tb_major', 'major_id = major');
      $this->join('tb_subject', 'subject_id = subject');
      $this->join('tb_school_year', 'school_year_id = at_school_year');
      $this->where('material_code', $material_code);
      $this->groupBy('material_code');
      return $this->get()->getFirstRow('object');
   }

   public function create_material($data)
   {
      return $this->insert($data);
   }

   public function update_material($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }

   public function delete_material($where)
   {
      $this->where($where);
      return $this->delete();
   }
}
