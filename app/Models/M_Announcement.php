<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Announcement extends Model
{
   protected $table = 'tb_announcement';
   protected $primaryKey = 'announcement_id';
   protected $allowedFields = ['announcement_title', 'announcement_desc', 'announcement_for', 'announced_by', 'announced_at', 'announced_until', 'at_school_year'];

   public function total_announcement($where = [])
   {
      $this->selectCount('announcement_id', 'total_nums');
      $this->join('tb_user', 'username = announced_by');
      $this->where($where);
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

   public function total_announcement_student($where = [])
   {
      $this->selectCount('announcement_id', 'total_nums');
      $this->where($where);
      $this->where('NOW() > announced_at');
      $this->orWhere("announcement_for", ['all', 'student']);
      return $this->get()->getFirstRow('object')->total_nums;
   }

   public function announcements_student($where = [], $limit = 0, $offset = 0)
   {
      $this->select('announcement_id,announcement_title,announced_at');
      $this->where($where);
      $this->where('NOW() > announced_at');
      $this->orWhere("announcement_for", ['all', 'student']);
      $this->limit($limit, $offset);
      $this->orderBy('announced_at DESC');
      $this->groupBy('announcement_id');
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

   public function detail_announcement($announcement_id)
   {
      $this->select("announcement_id,announcement_title,announcement_desc,announcement_for,announced_by,fullname announced,announced_at,announced_until,school_year_title");
      $this->join('tb_user', 'username = announced_by');
      $this->join('tb_school_year', 'school_year_id = at_school_year');
      $this->where('announcement_id', $announcement_id);
      $this->groupBy('announcement_id');
      return $this->get(1)->getFirstRow('object');
   }

   public function detail_announcement_teacher($username, $announcement_id)
   {
      $this->select("announcement_id,announcement_title,announcement_desc,announcement_for,announced_at,announced_until,school_year_title");
      $this->join('tb_school_year', 'school_year_id = at_school_year');
      $this->where('announcement_id', $announcement_id);
      $this->where('announced_by', $username);
      $this->orWhereIn('announcement_for', ['all', 'teacher']);
      $this->groupBy('announcement_id');
      return $this->get(1)->getFirstRow('object');
   }

   public function detail_announcement_student($announcement_id)
   {
      $this->select("announcement_id,announcement_title,announcement_desc,announced_by,fullname announced,announced_at,announced_until");
      $this->join('tb_user', 'username = announced_by');
      $this->where('announcement_id', $announcement_id);
      $this->whereIn("announcement_for", ['all', 'student']);
      $this->where('NOW() > announced_at');
      $this->groupBy('announcement_id');
      return $this->get(1)->getFirstRow('object');
   }

   public function have_announcement($username, $announcement_id)
   {
      $this->select('1');
      $this->where('announcement_id', $announcement_id);
      $this->where('announced_by', $username);
      return $this->get(1)->getFirstRow('object');
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

   public function delete_announcement($username, $announcement_id)
   {
      $builder = \Config\Database::connect();
      $builder->transBegin();
      $announcement_title = $builder->query("SELECT announcement_title FROM tb_announcement WHERE announcement_id = $announcement_id")->getFirstRow('object')->announcement_title;
      $builder->query("DELETE FROM tb_announcement WHERE announcement_id = $announcement_id");
      $builder->query("INSERT INTO tb_log_activity (log_type,log_desc,log_action,log_username) VALUES ('announcement','$announcement_title','delete','$username')");
      $builder->transComplete();
      if ($builder->transStatus() === false) {
         $builder->transRollback();
         return false;
      } else {
         $builder->transCommit();
         return true;
      }
   }
}
