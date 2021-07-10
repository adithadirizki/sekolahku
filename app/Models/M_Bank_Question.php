<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Bank_Question extends Model
{
   protected $table = 'tb_bank_question';
	protected $primaryKey = 'bank_question_id';
   protected $allowedFields = ['bank_question_title', 'questions', 'created_by'];
   
   public function total_bank_question()
   {
      $this->selectCount('bank_question_id', 'total_nums');
      $this->join('tb_user', 'username = created_by');
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function total_bank_question_filtered($where, $keyword)
   {
      $this->selectCount('bank_question_id', 'total_nums');
      $this->join('tb_user', 'username = created_by');
      $this->groupStart();
      $this->like('bank_question_title', $keyword);
      $this->orLike('JSON_LENGTH(questions)', $keyword);
      $this->orLike('fullname', $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get()->getFirstRow('object')->total_nums;
   }
   
   public function bank_question_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("bank_question_id,bank_question_title,JSON_LENGTH(questions) total_question,fullname created");
      $this->join('tb_user', 'username = created_by');
      $this->groupStart();
      $this->like('bank_question_title', $keyword);
      $this->orLike('JSON_LENGTH(questions)', $keyword);
      $this->orLike('fullname', $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }
   
   public function bank_questions($where = [])
   {
      $this->select("bank_question_id,bank_question_title,JSON_LENGTH(questions) total_question,created_by");
      $this->where($where);
      $this->orderBy('bank_question_id DESC');
      return $this->get()->getResultObject();
   }

   public function bank_question($where)
   {
      $this->where($where);
      return $this->get()->getFirstRow('object');
   }

   public function create_bank_question($data)
   {
      return $this->insert($data);
   }

   public function update_bank_question($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }

   public function delete_bank_question($where)
   {
      $this->where($where);
      return $this->delete();
   }
}
