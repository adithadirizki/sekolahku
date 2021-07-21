<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Auth extends Model
{
   protected $table = 'tb_user';
	protected $primaryKey = 'user_id';
   protected $allowedFields = ['username', 'photo', 'fullname', 'email', 'password', 'role', 'activation_code', 'token', 'token_expired', 'is_active', 'registered_at'];

   public function private_key_jwt()
   {
      return "adithadirizki";
   }

   public function login($username, $password)
   {
      $this->select("user_id,username,photo,fullname,email,password,role,is_active");
      $this->where('username', $username);
      $result = $this->get(1)->getFirstRow('object');
      if (!$result) {
         return (object) [
            "data" => null,
            "response" => [
               "message" => "Username atau Password yang digunakan salah.",
               "status" => 200,
               "error" => true
            ]
         ];
      }
      if (!password_verify($password, $result->password)) {
         return (object) [
            "data" => null,
            "response" => [
               "message" => "Username atau Password yang digunakan salah.",
               "status" => 200,
               "error" => true
            ]
         ];
      }
      if ($result->is_active == 0) {
         return (object) [
            "data" => null,
            "response" => [
               "message" => "Akun Anda belum dikonfirmasi.",
               "status" => 200,
               "error" => true
            ]
         ];
      }
      if ($result->is_active == 2) {
         return (object) [
            "data" => null,
            "response" => [
               "message" => "Akun Anda telah dinonaktifkan.",
               "status" => 200,
               "error" => true
            ]
         ];
      }
      return (object) [
         "data" => $result,
         "response" => [
            "message" => "Berhasil masuk ke akun.",
            "status" => 200,
            "error" => false
         ]
      ];
   }

   public function login_cookie($token)
   {
      $this->select("user_id,username,photo,fullname,email,role,is_active,token_expired");
      $this->where('token', $token);
      return $this->get(1)->getFirstRow('object');
   }
}
