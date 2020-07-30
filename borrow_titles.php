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


$borrow = $_POST["borrow"];
$book_id = $_POST["book_id"];


/*$borrow = get_post("borrow");
$book_id = get_post("book_id");*/

$ids = [];

for($i = 0; $i < count($borrow); $i++)
{
   if(isset($borrow[$i]))
   {
      $ids[] = $book_id[$i];

   }
}

$ids = implode(", ", $ids);

$query_null = "SELECT * FROM `books` WHERE `member_id` IS NULL AND `book_id` IN ($ids);";
$query_not = "SELECT * FROM `books` WHERE `member_id` IS NOT NULL AND `book_id` IN ($ids);";

$borrowed_query = $conn->query($query_null);
$unavailable_query = $conn->query($query_not);
$result;
if($borrowed_query->num_rows > 0)
{
   $display_borrow =
   "<h2> These books are ready for you! </h2>
   <table class='table'>
      <tr> <th> Book Title </th> <th> Author Name </th> </tr>";
      for($l = 0; $l < $borrowed_query->num_rows; $l++)
      {
         $borrowed_query->data_seek($l);
         $row = $borrowed_query->fetch_array(MYSQLI_ASSOC);
         $book_title = $row['book_title'];
         $author = $row['author_name'];
         $id = $row['book_id'];

         $display_borrow.="<tr>
         <td>$book_title</td>
         <td>$author</td> </tr>";

         $member_id = $member['member_id'];
         $borrow_date = date('Y-m-d H:i:s');
         if($member['designation'] == 'Student')
         {
            $return_date = date('Y-m-d H:i:s', 7890000*time());
         }
         else if($member['designation'] == 'Teacher')
         {
            $return_date = date('Y-m-d H:i:s', 10520000*time());
         }
         $query = "UPDATE `books` set `member_id` = $member_id, `borrow_date` = $borrow_date , `return_date` = $return_date WHERE `book_id` = $id;";

         $result = $conn->query($query);
      }
   $display_borrow.="</table>";
}

$conn->close();

if($unavailable_query->num_rows > 0)
{
   $display_unavail =
   "<h2> These titles are unavailable... </h2>
   <table class='table'>
      <tr> <th> Book Title </th> <th> Author Name </th> </tr>";
      for($o = 0; $o < $unavailable_query->num_rows; $o++)
      {
         $unavailable_query->data_seek($o);
         $row = $unavailable_query->fetch_array(MYSQLI_ASSOC);
         $book_title = $row['book_title'];
         $author = $row['author_name'];

         $display_unavail.="<tr>
         <td>$book_title</td>
         <td>$author</td> </tr>";
      }
   $display_unavail.="</table>";
}

echo <<<_END
<!DOCTYPE html>
<html>
   <head>
      <title> Borrow Books </title>

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
         <form class="" action="list_books.php" method="post" style="text-align: left;">
            <button class = "button" action="list_books.php" type="submit" value="back">
               Back
            </button>
         </form>
         <br>
         <br>
         <h1> Checkout </h1>
         <h4> COMP 3340 Project </h4> <hr>
         <br>  <br> <br>  <br>
         $display_borrow
         <br> <br> <br> <br>
         $display_unavail
         <br> <br> <br> <br>
         <h2>
            Himani Raval <br> <br>
            $result
         </h2>
            <p>
            image credit: <a href = "https://unsplash.com/photos/YLSwjSy7stw">
            https://unsplash.com/photos/YLSwjSy7stw
         </p> </a>
      </center>
   </body>
</html>
_END
?>
