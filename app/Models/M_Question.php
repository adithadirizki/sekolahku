<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Question extends Model
{
   protected $table = 'tb_question';
	protected $primaryKey = 'question_id';
   protected $allowedFields = ['question_type', 'question_text', 'choice', 'answer_key', 'created_by'];
   
   public function total_question()
   {
      $this->selectCount('question_id', 'total_nums');
      $this->join('tb_user', 'username = created_by');
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function total_question_filtered($where, $keyword)
   {
      $this->selectCount('question_id', 'total_nums');
      $this->join('tb_user', 'username = created_by');
      $this->groupStart();
      $this->like('question_type', $keyword);
      $this->orLike('question_text', $keyword);
      $this->orLike('fullname', $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function question_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("question_id,question_type,question_text,answer_key,fullname created");
      $this->join('tb_user', 'username = created_by');
      $this->groupStart();
      $this->like('question_type', $keyword);
      $this->orLike('question_text', $keyword);
      $this->orLike('fullname', $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }
   
   public function questions($where = [])
   {
      $this->select("question_id,question_type,question_text,answer_key,created_by");
      $this->where($where);
      $this->orderBy('question_type ASC');
      return $this->get()->getResultObject();
   }

   public function question($where)
   {
      $this->where($where);
      return $this->get()->getFirstRow('object');
   }

   public function create_question($data)
   {
      return $this->insert($data);
   }

   public function update_question($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }

   public function delete_question($where)
   {
      $this->where($where);
      return $this->delete();
   }
}
