<?php

namespace App\Filters;

use App\Models\M_Auth;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use DateTime;
use Firebase\JWT\JWT;

class Cookie implements FilterInterface
{
   protected $m_auth;

   public function __construct()
   {
      $this->m_auth = new M_Auth();
   }

   public function before(RequestInterface $request, $arguments = null)
   {
      if (isset($_COOKIE['token']) && !session()->has('hasLogin')) {
         $result = $this->m_auth->login_cookie($_COOKIE['token']);
         if ($result) {
            if (strtotime($result->token_expired) < strtotime('now')) {
               // if cookie is expired
               setcookie('token', '', time() - 3600);
               unset($_COOKIE['token']);
               session()->destroy();
               return redirect()->to(base_url('auth/login'));
            }
            if ($result->is_active != 1) {
               setcookie('token', '', time() - 3600);
               unset($_COOKIE['token']);
               session()->destroy();
               return redirect()->to(base_url('auth/login'));
            }
            // Set JWT Token
            $payload = [
               "iss" => "http://localhost/",
               "aud" => "http://localhost/",
               "iat" => time(),
               "nbf" => time(),
               "exp" => time() + (60 * 60 * 6), // for 6 hours
               "data" => [
                  "username" => $result->username,
                  "role" => $result->role
               ]
            ];
            $token = JWT::encode($payload, $this->m_auth->private_key_jwt());
            session()->set([
               "username" => $result->username,
               "fullname" => $result->fullname,
               "email" => $result->email,
               "token" => $token,
               "role" => $result->role,
               "photo" => $result->photo,
               "hasLogin" => true
            ]);
         } else {
            setcookie('token', '', time() - 3600);
            unset($_COOKIE['token']);
            session()->destroy();
            return redirect()->to(base_url('auth/login'));
         }
      }
   }

   //--------------------------------------------------------------------

   public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
   {
      // Do something here
   }
}
