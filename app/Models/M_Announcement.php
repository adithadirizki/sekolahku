<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Announcement extends Model
{
   protected $table = 'tb_announcement';
	protected $primaryKey = 'announcement_id';
   protected $allowedFields = ['announcement_title', 'announcement_desc', 'announcement_for', 'announced_by', 'announced_at', 'announced_until', 'at_school_year'];
   
   public function total_announcement()
   {
      $this->selectCount('announcement_id', 'total_nums');
      $this->join('tb_user', 'username = announced_by');
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function total_announcement_filtered($where, $keyword)
   {
      $this->selectCount('announcement_id', 'total_nums');
      $this->join('tb_user', 'username = announced_by');
      $this->groupStart();
      $this->like('announcement_title', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike("DATE_FORMAT(announced_at, '%d %m %Y %H:%i')", $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function announcement_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("announcement_id,announcement_title,fullname announced,DATE_FORMAT(announced_at, '%d %m %Y %H:%i') announced_at");
      $this->join('tb_user', 'username = announced_by');
      $this->groupStart();
      $this->like('announcement_title', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike("DATE_FORMAT(announced_at, '%d %m %Y %H:%i')", $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }
   
   public function announcements($where = [])
   {
      $this->select("announcement_id,announcement_title");
      $this->where($where);
      $this->orderBy('announcement_title ASC');
      return $this->get()->getResultObject();
   }

   public function announcement($announcement_id)
   {
      $this->select("announcement_id,announcement_title,announcement_desc,announcement_for,announced_by,fullname announced,announced_at,announced_until,school_year_title");
      $this->join('tb_user', 'username = announced_by');
      $this->join('tb_school_year', 'school_year_id = at_school_year');
      $this->where('announcement_id', $announcement_id);
      $this->groupBy('announcement_id');
      return $this->get()->getFirstRow('object');
   }

   public function create_announcement($data)
   {
      return $this->insert($data);
   }

   public function update_announcement($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }

   public function delete_announcement($where)
   {
      $this->where($where);
      return $this->delete();
   }
}
