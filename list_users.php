<?php

$error = "";

require_once 'login_cred.php';
//login to access database. Diff from login to alter database

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error); //connection error

$query = "SELECT * FROM `members`;";

$result = $conn->query($query); //save in result
$conn->close();

$display_users = "";

$rows = $result->num_rows;
for ($j = 0 ; $j < $rows ; ++$j)
{
 $result->data_seek($j);
 $row = $result->fetch_array(MYSQLI_ASSOC);
 $member_id = $row['member_id'];
 $name = $row['name'];
 $email = $row['email'];
 $designation = $row['designation'];
 $username = $row['username'];
 $display_users.="<tr>
 <td>$member_id</td>
 <td>$name</td>
 <td>$designation</td>
 <td>$email</td>
 <td>$username</td>
 </tr>";
}

echo <<<_END
<!DOCTYPE html>
<html>
   <head>
      <title> All Members List </title>

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
         <h1> All Members List </h1>
         <h4> COMP 3340 Project </h4> <hr>


         <br>
         <br>
         <br>
         <br>

        <table class="table">
            <tr> <th> Member ID </th> <th> Name </th> <th> Designation </th> <th> Email </th> <th> Username </th></tr>
            $display_users
         </table>

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
