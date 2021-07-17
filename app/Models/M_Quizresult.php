<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Quizresult extends Model
{
   protected $table = 'tb_quiz_result';
   protected $primaryKey = 'quiz_result_id';
   protected $allowedFields = ['quiz', 'answer', 'essay_score', 'value', 'status', 'submitted_by', 'submitted_at', 'at_class_group'];

   public function quiz_result($username, $quiz_code)
   {
      $this->select("quiz_code,time,start_at,due_at,answer,status,created_at");
      $this->join('tb_quiz', 'quiz_code = quiz');
      $this->where('quiz_code', $quiz_code);
      $this->where('submitted_by', $username);
      return $this->get(1)->getFirstRow('object');
   }

   public function status_submitted($username, $quiz_code)
   {
      $this->select('status');
      $this->where('quiz', $quiz_code);
      $this->where('submitted_by', $username);
      return $this->get(1)->getFirstRow('object');
   }

   public function create_quiz_result($data)
   {
      return $this->insert($data);
   }

   public function update_quiz_result($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }

   public function delete_quiz_result($where)
   {
      $this->where($where);
      return $this->delete();
   }

   public function is_timeout($username, $quiz_code)
   {
      $this->select('1');
      $this->join('tb_quiz', "quiz_code = '$quiz_code'");
      $this->where('NOW() > created_at + INTERVAL time MINUTE');
      $this->orWhere('NOW() > due_at');
      $this->where('quiz_code', $quiz_code);
      $this->where('submitted_by', $username);
      return $this->get(1)->getFirstRow('object');
   }

   public function answers($username, $quiz_code)
   {
      $this->select("answer");
      $this->where('quiz', $quiz_code);
      $this->where('submitted_by', $username);
      return $this->get(1)->getFirstRow('object')->answer;
   }

   public function submit_answer($question_id, $answer, $where)
   {
      $this->set('answer', "JSON_SET(answer, '$.\"$question_id\"', '$answer')", false);
      $this->where($where);
      $this->where('status', 0);
      $this->where('submitted_at', null, false);
      return $this->update();
   }

   public function submit_completed($where)
   {
      $this->set('submitted_at', date('Y-m-d H:i'));
      $this->set('status', 1);
      $this->where($where);
      $this->where('status', 0);
      $this->where('submitted_at', null, false);
      return $this->update();
   }

   public function submit_timeout($where)
   {
      $this->set('submitted_at', date('Y-m-d H:i'));
      $this->set('status', 2);
      $this->where($where);
      $this->where('status', 0);
      $this->where('submitted_at', null, false);
      return $this->update();
   }

   public function show_question($where, $number_question)
   {
      $this->select("question_type,question_text,choice,answer_key,JSON_UNQUOTE(JSON_EXTRACT(JSON_EXTRACT(answer, '$.*'), '$[$number_question]')) answer");
      $this->join('tb_question', "question_id = JSON_UNQUOTE(JSON_EXTRACT(JSON_KEYS(answer), '$[$number_question]'))");
      $this->where($where);
      return $this->get(1)->getFirstRow('object');
   }
}
