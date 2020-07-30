<?php // login.php
   $hn = 'localhost'; //hostname
   $db = 'ravalh_library'; //database
   $un = 'ravalh_admin'; //username
   $pw = 'password'; //password

   $meh="some string";

   function get_post($conn, $var)
   {
     return $conn->real_escape_string($_POST[$var]);
   }



   function auth_check($meh)
   {
      if(!isset($_COOKIE["library_session"]))
      {
          return false;
          //die('auth_token');
      }
      $token = $_COOKIE["library_session"];
     // $token = getcookie("session");
      $components = explode(".", $token);

      $secret=hash("sha256", $components[0].$meh);
      //$secret=$components[0].$meh;

      if($secret!=$components[1])
      {
         return false;
         //die($components[0]." ".$components[1]." ".$secret." ".$meh);
      }
      else
      {
         //die(json_decode(base64_decode($components[0]), true));
         return json_decode(base64_decode($components[0]), true);
      }
   }
?>
