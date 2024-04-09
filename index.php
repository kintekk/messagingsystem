<?php 

require_once 'db/config.php';

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if(isset($_POST['login'])) {
    $uname = test_input(mysqli_real_escape_string($conn, $_POST["uname"]));
    $pswd = test_input(mysqli_real_escape_string($conn, $_POST["pswd"]));
    //error handlers
    if(empty($uname) || empty($pswd)){
        header("location: index.php?empty=emptyfields");

    } else{
        $sql="SELECT * FROM user WHERE uname='$uname'";
        $result=mysqli_query($conn, $sql);
        $resultCheck= mysqli_num_rows($result);
        if($resultCheck < 1 ){
            header("location: index.php?unregistered=unregistered");
        } else {
            if($row=mysqli_fetch_assoc($result)) {
// dehashing pswd
        $hashedpassCheck=password_verify($pswd, $row['pswd']);
        if($hashedpassCheck == false) {
            header("location: index.php?error=wrongpassword");


        }elseif ($hashedpassCheck == true) {
            // loggin the user here 
            session_start();
          $_SESSION['uname']=$row['uname'];
          $_SESSION['id']=$row['id'];
            
        }
             }
        }
    }
  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to | Messaging System!</title>
    <Link rel="icon" href="images/favicon.ico">
    <Link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php

       if(!isset($_SESSION['uname'])){  ?>

<div class="header">
        <h1>Messaging System</h1>
        <p>A Simple messaging system created by Abel Uchennaya Kingson.</p>
    </div>
    <div>
        <form action="" method="POST">
            <div class="container">
                <h1>Login</h1>
                <p>Please fill in this form to Login.</p>
                <hr>
                <?php if(isset($_GET["empty"])== "emptyfields"){
          echo '<p class="alert alert-danger">fill your login details</p>';
      } ?>
                <label for="uname"><b>Username </b></label><?php if(isset($_GET["unregistered"])== "unregistered"){
          echo '<p class="alert alert-danger">Unregistered Username</p>';
      } ?>
                <input type="text" placeholder="Enter Username" name="uname"  required>

                <label for="pswd-repeat"><b>Enter Password </b> <?php if(isset($_GET["error"])== "wrongpassword"){
          echo '<p class="alert alert-danger">Wrong password please try again!</p>';
      } ?></label>
                <input type="password" placeholder="Enter Password" name="pswd"  required>
                <hr>

                <button type="submit" name="login" class="registerbtn">Login</button>
                </div>

                <div class="container signin">
                <p>Don't have an account? <a href="register.php">Register</a>.</p>
            </div>
        </form>
    </div>
      <?php } else {?>
        <div class="navbar" style="background-color: gray;">
        <a href="messages.php">Messages</a>
        <a href="logout.php" class="right">Logout</a>
    </div>

    <div class="header">
        <h1>Messaging System</h1>
        <p>A Simple messaging system created by Abel Uchennaya Kingson.</p>
    </div>
    
    <?php  }
    

    ?>
   
   
    <div class="footer">
    <h2>All Rights Reserved </h2>
    </div>
</body>
</html>