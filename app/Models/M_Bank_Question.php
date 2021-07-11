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

   public function questions($bank_question_id)
   {
      $this->select("questions");
      $this->where('bank_question_id', $bank_question_id);
      return $this->get()->getFirstRow('object')->questions;
   }

   public function get_question($bank_question_id, $number_question)
   {
      $this->select("tb_question.*");
      $this->join('tb_question', "question_id = JSON_EXTRACT(questions, '$[$number_question]')");
      $this->where('bank_question_id', $bank_question_id);
      return $this->get()->getFirstRow('object');
   }

   public function update_question($bank_question_id, $question_id)
   {
      if (is_array($question_id)) {
         // Replace all
         $this->set('questions', json_encode($question_id));
      } else {
         // Append
         $this->set('questions', "JSON_ARRAY_APPEND(questions, '$', $question_id)", false);
      }
      $this->where('bank_question_id', $bank_question_id);
      return $this->update();
   }

   public function delete_question($bank_question_id, $number_question)
   {
      $this->set('questions', "JSON_REMOVE(questions, '$[$number_question]')", false);
      $this->where('bank_question_id', $bank_question_id);
      return $this->update();
   }
}
