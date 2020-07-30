<?php

$error = "";

if(isset($_POST["book_name"]) &&
   isset($_POST["author_name"]) &&
   isset($_POST["genre"])) //if none of those fields are empty
{
   require_once 'login_cred.php';
   //login to access database. Diff from login to alter database

   $conn = new mysqli($hn, $un, $pw, $db);
   if ($conn->connect_error) die($conn->connect_error); //connection error

   $book_name = get_post($conn, 'book_name');
   $author_name = get_post($conn, 'author_name');
   $genre = get_post($conn, 'genre');

   $query = "INSERT INTO books (`book_title`, `author_name`, `genre`)
   VALUES ('$book_name', '$author_name', '$genre');";

   $result = $conn->query($query); //save in result
   $conn->close();

   if($result) //when credentials are correct
   {
      header("Location: http://ravalh.myweb.cs.uwindsor.ca/60334/project/html/add_books.php", true, 303);
      die();
   }

   else
   {
      $error = 'Failed to add book to records';
   }
}

echo <<<_END
<!DOCTYPE html>
<html>
   <head>
      <title> Add Books </title>

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
         <form class="" action="Admin_Welcome.html" method="post" style="text-align: left;">

            <button class = "button" action="Admin_Welcome.php" type="submit" value="log_out">
               Back
            </button>

         </form>



         <br>
         <br>
         <h1> Add Books </h1>
         <h4> COMP 3340 Project </h4> <hr>


         <br>
         <br>
         <br>
         <br>

         <form class="" action="add_books.php" method="post">

            <p> <b> Book Title: </b> </p>
            <textarea class="text_area" name="book_name" rows="1" cols="50"></textarea>

            <br>
            <br>

            <p> <b> Author Name(First Last): </b> </p>
            <textarea class="text_area" name="author_name" rows="1" cols="50"></textarea>

            <br>
            <br>

            <p> <b> Genre </b> </p>
            <textarea class="text_area" name="genre" rows="1" cols="30"></textarea>

            <br>
            <br>
            <br>

            <h2> $error </h2>


            <br>
            <br>
            <br>

            <button class = "button" type="submit" value="Submit"> <!-- sign in button -->
               Add Book!
            </button>

         </form>

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
