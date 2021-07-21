<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Quizresult extends Model
{
   protected $table = 'tb_quiz_result';
   protected $primaryKey = 'quiz_result_id';
   protected $allowedFields = ['quiz', 'answer', 'essay_score', 'value', 'status', 'submitted_by', 'submitted_at', 'at_class_group', 'at_school_year'];
   
   public function total_quiz_result()
   {
      $this->selectCount('quiz_result_id', 'total_nums');
      $this->join('tb_quiz', 'quiz_code = quiz');
      $this->join('tb_user', 'username = submitted_by');
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function total_quiz_result_filtered($where, $keyword)
   {
      $this->selectCount('quiz_result_id', 'total_nums');
      $this->join('tb_quiz', 'quiz_code = quiz');
      $this->join('tb_user', 'username = submitted_by');
      $this->groupStart();
      $this->like('quiz', $keyword);
      $this->orLike('quiz_title', $keyword);
      $this->orLike('value', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike("DATE_FORMAT(submitted_at, '%d/%m/%Y %H:%i')", $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function quiz_result_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("quiz_result_id,quiz quiz_code,quiz_title,value,status,fullname created,DATE_FORMAT(submitted_at, '%d/%m/%Y %H:%i') submitted_at");
      $this->join('tb_quiz', 'quiz_code = quiz');
      $this->join('tb_user', 'username = submitted_by');
      $this->groupStart();
      $this->like('quiz', $keyword);
      $this->orLike('quiz_title', $keyword);
      $this->orLike('value', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike("DATE_FORMAT(submitted_at, '%d/%m/%Y %H:%i')", $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }

   public function quiz_result($quiz_result_id)
   {
      $this->where('quiz_result_id', $quiz_result_id);
      return $this->get(1)->getFirstRow('object');
   }

   public function detail_quiz_result($quiz_result_id)
   {
      $this->select('tb_quiz_result.*,fullname submitted,status,submitted_at,questions');
      $this->join('tb_user', 'username = submitted_by');
      $this->join('tb_quiz', 'quiz_code = quiz');
      $this->where('quiz_result_id', $quiz_result_id);
      return $this->get(1)->getFirstRow('object');
   }

   public function quiz_result_student($username, $quiz_code)
   {
      $this->select("quiz_code,time,start_at,due_at,answer,status,created_at");
      $this->join('tb_quiz', 'quiz_code = quiz');
      $this->where('quiz_code', $quiz_code);
      $this->where('NOW() > start_at');
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

   public function have_quiz($username, $quiz_result_id)
   {
      $this->select('1');
      $this->join('tb_quiz', "quiz_code = quiz AND created_by = '$username'");
      $this->where('quiz_result_id', $quiz_result_id);
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
      $this->join('tb_quiz', "quiz_code = quiz");
      $this->groupStart();
      $this->where('NOW() > created_at + INTERVAL time MINUTE');
      $this->orWhere('NOW() > due_at');
      $this->groupEnd();
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

   public function submit_completed($data, $where)
   {
      $this->set('submitted_at', date('Y-m-d H:i'));
      $this->set('status', 1);
      $this->set($data);
      $this->where($where);
      $this->where('status', 0);
      $this->where('submitted_at', null, false);
      return $this->update();
   }

   public function submit_timeout($data, $where)
   {
      $this->set('submitted_at', date('Y-m-d H:i'));
      $this->set('status', 2);
      $this->set($data);
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
