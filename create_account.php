<?php

$error = "";

if(isset($_POST["username"]) &&
   isset($_POST["password"]) &&
   isset($_POST["name"]) &&
   isset($_POST["email"]) &&
   isset($_POST["designation"])) //if none of those fields are empty
{
   require_once 'login_cred.php';
   //login to access database. Diff from login to alter database
   $conn = new mysqli($hn, $un, $pw, $db);
   if ($conn->connect_error) die($conn->connect_error); //connection error

   $name = get_post($conn, 'name'); //get name and save it in variable
   $email = get_post($conn, 'email'); //get email and save it in variable
   $designation = get_post($conn, 'designation'); //get designation and save it in variable
   $username = get_post($conn, 'username'); //get username and save it in variable
   $password = hash("sha512", get_post($conn, 'password'));

   $query = "INSERT INTO members (`name`, `email`, `username`, `password`, `designation`)
   VALUES ('$name', '$email', '$username', '$password', '$designation');";

   $result = $conn->query($query); //save in result
   $conn->close();

   if($result) //when credentials are correct
   {

      //$auth_token = base64_encode(json_encode($member)); //encoding it
      //header("Authorization: ".$auth_token); //returning it to the browser

      header("Location: http://ravalh.myweb.cs.uwindsor.ca/60334/project/html/welcome_user.html", true, 303);
      die();
   }

   else
   {
      $error = 'Failed to create User';
   }

}

else
{
   //header('HTTP/1.1 401 Unauthorized');
   //$error = 'Please fill all required fields';
}




echo <<<_END
<!DOCTYPE html>
<html>
   <head>
      <title> Create an account </title>

      <link rel="stylesheet" href="../css/styling.css">

      <style>
         h1,h2,h3,h4,h5,h6,p,table, tr, th, td, label, a
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

         <h1> Create an Account </h1>
         <h4> COMP 3340 Project </h4> <hr>

         <br>
         <br>


         <form class="" action="create_account.php" method="post">
            <p> <b> Member Name (First Last): </b> </p> <!-- member name area -->
            <textarea class="text_area" name="name" rows="1" cols="50"></textarea>

            <br>
            <br>

            <p> <b> Member Email: </b> </p> <!-- email area -->
            <textarea class="text_area" name="email" rows="1" cols="50"></textarea>

            <br>
            <br>

            <p> <b> Are you a: </b> </p> <!-- designation -->
            <!-- Drop Down Menu -->
            <input type="radio" id="student" name="designation" value="Student" required>
            <label for="student"> Student </label>
            <input type="radio" id="teacher" name="designation" value="Teacher" required>
            <label for="teacher"> Teacher </label><br>

            <br>
            <br>

            <p> <b> New Username: </b> </p> <!-- username area -->
            <textarea class="text_area" name="username" rows="1" cols="30"></textarea>

            <br>
            <br>

            <p> <b> New Password: </b> </p> <!-- password area -->
            <textarea class="text_area" name="password" rows="1" cols="30"></textarea>

            <br>
            <br>

            <h2> $error </h2>

            <br>
            <br>
            <br>
            <br>

            <button class = "button" type="submit" value="Submit"> <!-- sign in button -->
               Create my account !
            </button>

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


         </form>
         <br>
         <br>
         <br>


         <p> <a href = "#top"> Back to top  </a> </p>

      </center>
   </body>
</html>

_END;
?>
