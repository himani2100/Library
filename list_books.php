<?php

require_once 'login_cred.php';
//login to access database. Diff from login to alter database

$member=auth_check($meh);
if(!$member)
{
   header("Location: http://ravalh.myweb.cs.uwindsor.ca/60334/project/html/library_welcome_page.html", true, 303);
   die();
}


$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error); //connection error

$query = "SELECT * FROM `books`;";

$result = $conn->query($query); //save in result
$conn->close();

$display_books = "";
if($member['username']!='Admin')
{
 $display_books.="<form action='borrow_titles.php' method='post'>";
}
$display_books.="<table class='table'>
 <script src='../js/checkboxes.js'> </script>
 <tr> <th> Book Title </th> <th> Author Name </th> <th> Genre </th> <th> Borrow this title </th> </tr>";


$rows = $result->num_rows;

for ($j = 0 ; $j < $rows ; ++$j)
{
 $result->data_seek($j);
 $row = $result->fetch_array(MYSQLI_ASSOC);
 $title = $row['book_title'];
 $author = $row['author_name'];
 $genre = $row['genre'];
 $book_id = $row['book_id'];

 $display_books.="<tr>
 <td>$title</td>
 <td>$author</td>
 <td>$genre</td>";

 if($member['username']!='Admin')
  {
    $display_books.="<td> <input type='checkbox' name='borrow[]'>
       <input type='hidden' value='$book_id' name='book_id[]'> </td>";
  }
  $display_books.="</tr>";
}

$display_books.="

</table>

<br>
<br>
<br>
<br>";

if($member['username']!='Admin')
{
   $display_books .= "
   <button class = 'button' action='borrow_titles.php' type='submit' value='borrow'>
      Borrow!
   </button>
   </form>";
}


echo <<<_END
<!DOCTYPE html>
<html>
   <head>
      <title> List E-Books </title>

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
         <form class="" action="welcome_user.html" method="post" style="text-align: left;">

            <button class = "button" type="submit" value="back">
               Back
            </button>

         </form>


         <br>
         <br>
         <h1> Browse Our Selection </h1>
         <h4> COMP 3340 Project </h4> <hr>


         <br>
         <br>
         <br>
         <br>

         $display_books

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
_END

?>
