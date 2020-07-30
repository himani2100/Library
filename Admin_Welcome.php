<?php

require_once 'login_cred.php';
$member=auth_check($meh);
if(!$member || $member['username']!='Admin')
{
    //die($member["member_id"]);
   header("Location: http://ravalh.myweb.cs.uwindsor.ca/60334/project/html/library_welcome_page.html", true, 303);

}

echo <<<_END
<!DOCTYPE html>
<html>
   <head>
      <title> Admin </title>

      <link rel="stylesheet" href="../css/styling.css">

      <style>
         h1,h2,h3,h4,h5,h6,p,table, tr, th, td, a
         {
            color : #FFFFFF;
         }
      </style>
   </head>
   <a name="top"> </a>

   <body class="body">
      <center>
         <form class="" action="logout.php" method="post" style="text-align: right;">

            <br>
            <br>

            <button class = "button" type="submit" value="log_out">
               Log Out
            </button>

         </form>

         <br>
         <br>
         <h1> Welcome, Admin </h1>
         <h4> COMP 3340 Project </h4> <hr>


         <br>
         <br>
         <br>
         <br>

         <form class="" action="add_books.php" method="post">

            <br>
            <br>

            <button class = "button" type="submit" value="Submit"> <!-- sign in button -->
               Add Books
            </button>

         </form>

         <br>
         <br>
         <br>
         <br>

         <form class="" action="list_users.php" method="post">

            <br>
            <br>

            <button class = "button" type="submit" value="Submit"> <!-- sign in button -->
               View Members
            </button>

         </form>

         <br>
         <br>
         <br>
         <br>
         <br>
         <br>

         <h2>
            Himani Raval <br> <br>
         </h2>

            <p>
            image credit: <a href = "https://unsplash.com/photos/YLSwjSy7stw">
            https://unsplash.com/photos/YLSwjSy7stw
         </p> </a>

         <br>
         <br>
         <br>
         <br>


         <p> <a href = "#top"> Back to top  </a> </p>


      </center>
   </body>
</html>
_END;
?>
