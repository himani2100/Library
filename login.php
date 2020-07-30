<?php
$error = "";
if(isset($_POST["username"]) && isset($_POST["password"])) //if none of those fields are empty
{
   require_once 'login_cred.php';
   //login to access database. Diff from login to alter database
   $conn = new mysqli($hn, $un, $pw, $db);
   if ($conn->connect_error) die($conn->connect_error); //connection error

   $username = get_post($conn, 'username'); //get username and save it in variable
   $password = hash("sha512", get_post($conn, 'password'));
   //get password and save it in variable. hash is not encryption. I will not know what password you are using.

   $query  = "SELECT username, name, email, designation, member_id FROM members WHERE username='".$username."' and password='".$password."';";
   //query formating. .means append like +
   $result = $conn->query($query); //save in result
   $conn->close();
   if($result->num_rows != 0) //when credentials are correct
   {
      $result->data_seek(0); //it only retuns one result so at zero
      $member = $result->fetch_array(MYSQLI_ASSOC);

      $headers = base64_encode(json_encode($member)); //encoding it

      $secret=hash("sha256", $headers.$meh);

      $auth_token = $headers.".".$secret; //encoding it
      //header("Authorization: ".$auth_token); //returning it to the browser
      setcookie("library_session", $auth_token, time()+(86400*2));


      if($member["username"] == "Admin")
      {
         header("Location: http://ravalh.myweb.cs.uwindsor.ca/60334/project/html/Admin_Welcome.php", true, 303);
         die();
      }

      else
      {
         header("Location: http://ravalh.myweb.cs.uwindsor.ca/60334/project/html/welcome_user.html", true, 303);
         die();
      }

   }

   else
   {
      header('HTTP/1.1 401 Unauthorized');
      $error = 'Username or Password is incorrect';
   }


}

echo <<<_END
<!DOCTYPE html>
<html>
   <head>
      <title> Login </title>

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
      <form class="" action="library_welcome_page.html" method="post">
         <button class = "button" type="submit" value="Back"> <!-- sign in button -->
         Back
         </button>
      </form>
      <center>
         <h1> Sign in </h1>
         <h4> COMP 3340 Project </h4> <hr>

         <br>
         <br>
         <br>
         <br>


         <form class="" action="login.php" method="post">
            <p> Username: </p> <!-- username area -->
            <textarea class="text_area" name="username" rows="1" cols="30"></textarea>


            <br>
            <br>

            <p> Password: </p> <!-- password area -->
            <textarea class="text_area" name="password" rows="1" cols="30"></textarea>

            <br>
            <br>
            <br>

            <h2> $error </h2>

            <br>
            <br>
            <br>

            <button class = "button" type="submit" value="Submit"> <!-- sign in button -->
               Sign In
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
      </center>
   </body>
</html>

_END;
?>
