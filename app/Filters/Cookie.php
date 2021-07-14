<?php

namespace App\Filters;

use App\Models\M_Auth;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cookie implements FilterInterface
{
   protected $m_auth;

   public function __construct()
   {
      $this->m_auth = new M_Auth();
   }

   public function before(RequestInterface $request, $arguments = null)
   {
      $baseURL = \Config\Services::request()->config->baseURL;
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
               "iss" => $baseURL,
               "aud" => $baseURL,
               "iat" => time(),
               "nbf" => time(),
               "exp" => time() + $_ENV['JWT_EXPIRE'], // for 6 hours
               "data" => [
                  "username" => $result->username,
                  "role" => $result->role
               ]
            ];
            $jwt_token = \Firebase\JWT\Jwt::encode($payload, $_ENV['JWT_PRIVATE_KEY']);
            session()->set([
               "username" => $result->username,
               "fullname" => $result->fullname,
               "email" => $result->email,
               "token" => $jwt_token,
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
