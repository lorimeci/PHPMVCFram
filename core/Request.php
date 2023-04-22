<?php

namespace Core;

class Request
{
   /**
    * GET URI and breaks it in many parts
    */
   public function getPath()
   {
      $path = $_SERVER['REQUEST_URI'] ?? '/';
      $position = strpos($path, '?');
      if ($position == false) {
         return $path;
      }
      return substr($path, 0, $position);
   }

   public function method()
   {
      return strtolower($_SERVER['REQUEST_METHOD']);
   }

   public function isGet()
   {
      return $this->method() == 'get';;
   }
  
   public function isPost()
   {
      return $this->method() == 'post';;
   }

   public function getBody()
   {
      $body = [];
      foreach ($_GET as $key => $value) {
         $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
   
      foreach ($_POST as $key => $value) {
         $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }

      foreach ($_FILES as $key => $value) {
         $body[$key] = $value;
      }

      return $body;
   }

   public function getParamsGet($exclude)
   {
      $body = [];
      foreach ($_GET as $key => $value) {
         if ($key != $exclude) {
            $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
         }
      }
      return $body;
   }
   // funksion qe gjeneron query 
   public function getQueryString($exclude)
   {
      $params = $this->getParamsGet($exclude);

      $query = '';
      foreach ($params as $key => $value) {
         $query .= $key . '=' . $value . '&';
      }
      $query = rtrim($query,'&');
      return $query;
   }
}
