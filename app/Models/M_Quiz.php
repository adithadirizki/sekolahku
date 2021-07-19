<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Quiz extends Model
{
   protected $table = 'tb_quiz';
	protected $primaryKey = 'quiz_id';
   protected $allowedFields = ['quiz_code', 'quiz_title', 'questions', 'created_by', 'subject', 'class_group', 'question_model', 'show_ans_key', 'time', 'start_at', 'due_at', 'at_school_year'];

   public function new_quiz_code()
   {
      while (true) {
         $quiz_code = '';
         $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
         for ($i = 0; $i < 6; $i++) {
            $quiz_code .= $string[rand(0, strlen($string) - 1)];
         }
         $this->selectCount('quiz_id', 'total_nums');
         $this->where(['quiz_code' => $quiz_code]);
         if ($this->get(1)->getFirstRow('object')->total_nums == 0) {
            break;
         }
      }
      return $quiz_code;
   }
   
   public function total_quiz()
   {
      $this->selectCount('quiz_id', 'total_nums');
      $this->join('tb_user', 'username = created_by');
      $this->join('tb_subject', 'subject_id = subject');
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function total_quiz_filtered($where, $keyword)
   {
      $this->selectCount('quiz_id', 'total_nums');
      $this->join('tb_user', 'username = created_by');
      $this->join('tb_subject', 'subject_id = subject');
      $this->groupStart();
      $this->like('quiz_code', $keyword);
      $this->orLike('quiz_title', $keyword);
      $this->orLike('JSON_LENGTH(questions)', $keyword);
      $this->orLike('subject_name', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike("DATE_FORMAT(start_at, '%d %m %Y %H:%i')", $keyword);
      $this->groupEnd();
      $this->where($where);
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function quiz_data($where, $keyword, $limit, $offset, $orderby)
   {
      $this->select("quiz_id,quiz_code,quiz_title,JSON_LENGTH(questions) total_questions,subject_name,fullname created,DATE_FORMAT(start_at, '%d %m %Y %H:%i') start_at");
      $this->join('tb_user', 'username = created_by');
      $this->join('tb_subject', 'subject_id = subject');
      $this->groupStart();
      $this->like('quiz_code', $keyword);
      $this->orLike('quiz_title', $keyword);
      $this->orLike('JSON_LENGTH(questions)', $keyword);
      $this->orLike('subject_name', $keyword);
      $this->orLike('fullname', $keyword);
      $this->orLike("DATE_FORMAT(start_at, '%d %m %Y %H:%i')", $keyword);
      $this->groupEnd();
      $this->where($where);
      $this->orderBy($orderby);
      $this->limit($limit, $offset);
      return $this->get()->getResultObject();
   }
   
   public function quizzes($where = [], $limit = 0, $offset = 0)
   {
      $this->where($where);
      $this->limit($limit, $offset);
      $this->orderBy('start_at DESC');
      return $this->get()->getResultObject();
   }
   
   public function total_quiz_student($username, $where = [])
   {
      $this->selectCount('quiz_id', 'total_nums');
      $this->join('tb_student', "student_username = '$username' AND JSON_CONTAINS(class_group, JSON_QUOTE(curr_class_group))");
      $this->join('tb_quiz_result', 'quiz = quiz_code', 'left');
      $this->join('tb_subject', 'subject_id = subject');
      $this->where($where);
      return $this->get(1)->getFirstRow('object')->total_nums;
   }
   
   public function quizzes_student($username, $where = [], $limit = 0, $offset = 0)
   {
      $this->select('quiz_code,quiz_title,start_at,due_at,quiz_result_id,status,subject_name,subject_code');
      $this->join('tb_student', "student_username = '$username' AND JSON_CONTAINS(class_group, JSON_QUOTE(curr_class_group))");
      $this->join('tb_quiz_result', 'quiz = quiz_code AND submitted_by = student_username', 'left');
      $this->join('tb_subject', 'subject_id = subject');
      $this->where($where);
      $this->limit($limit, $offset);
      $this->orderBy('start_at DESC');
      $this->groupBy('quiz_code');
      return $this->get()->getResultObject();
   }

   public function quiz($quiz_code)
   {
      $this->where('quiz_code', $quiz_code);
      return $this->get(1)->getFirstRow('object');
   }

   public function detail_quiz($quiz_code)
   {
      $this->select("quiz_id,quiz_code,quiz_title,questions,GROUP_CONCAT(CONCAT_WS(' ',class_name,major_code,unit_major) SEPARATOR ',') class_group_name,class_group class_group_code,subject_id,subject_code,subject_name,created_by,fullname created,question_model,show_ans_key,time,start_at,due_at,school_year_title");
      $this->join('tb_user', 'username = created_by');
      $this->join('tb_class_group', 'JSON_CONTAINS(class_group, JSON_QUOTE(class_group_code))');
      $this->join('tb_class', 'class_id = class');
      $this->join('tb_major', 'major_id = major');
      $this->join('tb_subject', 'subject_id = subject');
      $this->join('tb_school_year', 'school_year_id = at_school_year');
      $this->where('quiz_code', $quiz_code);
      $this->groupBy('quiz_code');
      return $this->get(1)->getFirstRow('object');
   }

   public function quiz_student($username, $quiz_code)
   {
      $this->select('tb_quiz.*');;
      $this->join('tb_student', "student_username = '$username' AND JSON_CONTAINS(class_group, JSON_QUOTE(curr_class_group))");
      $this->where('quiz_code', $quiz_code);
      return $this->get(1)->getFirstRow('object');
   }

   public function detail_quiz_student($username, $quiz_code)
   {
      $this->select("quiz_id,quiz_code,quiz_title,questions,question_model,show_ans_key,time,subject_id,subject_code,subject_name,created_by,fullname created,start_at,due_at,quiz_result_id,answer,essay_score,value,status,submitted_at");
      $this->join('tb_user', 'username = created_by');
      $this->join('tb_student', "student_username = '$username' AND JSON_CONTAINS(class_group, JSON_QUOTE(curr_class_group))");
      $this->join('tb_quiz_result', 'quiz = quiz_code AND submitted_by = student_username', 'left');
      $this->join('tb_subject', 'subject_id = subject');
      $this->where('quiz_code', $quiz_code);
      $this->groupBy('quiz_code');
      return $this->get(1)->getFirstRow('object');
   }

   public function is_due($quiz_code)
   {
      $this->select('1');
      $this->where('NOW() > due_at');
      $this->where('quiz_code', $quiz_code);
      return $this->get(1)->getFirstRow('object');
   }

   public function create_quiz($data)
   {
      return $this->insert($data);
   }

   public function update_quiz($data, $where)
   {
      $this->set($data);
      $this->where($where);
      return $this->update();
   }

   public function delete_quiz($where)
   {
      $this->where($where);
      return $this->delete();
   }

   public function questions($quiz_code)
   {
      $this->select("questions");
      $this->where('quiz_code', $quiz_code);
      return $this->get(1)->getFirstRow('object')->questions;
   }

   public function get_question($quiz_code, $number_question)
   {
      $this->select("tb_question.*");
      $this->join('tb_question', "question_id = JSON_EXTRACT(questions, '$[$number_question]')");
      $this->where('quiz_code', $quiz_code);
      return $this->get(1)->getFirstRow('object');
   }

   public function update_question($quiz_code, $question_id)
   {
      if (is_array($question_id)) {
         // Replace all
         $this->set('questions', json_encode($question_id, JSON_NUMERIC_CHECK));
      } else {
         // Append
         $question_id = (int) $question_id;
         $this->set('questions', "JSON_ARRAY_APPEND(questions, '$', $question_id)", false);
      }
      $this->where('quiz_code', $quiz_code);
      return $this->update();
   }

   public function delete_question($quiz_code, $number_question)
   {
      $this->set('questions', "JSON_REMOVE(questions, '$[$number_question]')", false);
      $this->where('quiz_code', $quiz_code);
      return $this->update();
   }
}
