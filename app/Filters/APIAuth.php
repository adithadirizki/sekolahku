<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class APIAuth implements FilterInterface
{
   public function before(RequestInterface $request, $arguments = null)
   {
      if ($request->uri->getSegment(1) == 'api' && $request->uri->getSegment(2) == 'auth') {
         return;
      }

      if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
         header('HTTP/1.1 401 Unauthorized');
         die;
      }

      try {
         \Firebase\JWT\JWT::decode($_SERVER['HTTP_AUTHORIZATION'], $_ENV['JWT_PRIVATE_KEY'], ['HS256']);
      } catch (\Exception $e) {
         if ($e->getMessage() == 'Expired token') {
            session()->destroy();
         }
         header('HTTP/1.1 401 ' . $e->getMessage());
         die;
      }
   }

   //--------------------------------------------------------------------

   public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
   {
      // Do something here
   }
}
