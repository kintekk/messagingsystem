<?php 
require_once('db/config.php');
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST['register'])){
    $uname = test_input($_POST['uname']);
    $email = test_input($_POST['email']);
    $pswd = test_input($_POST['pswd']);
    $pswd_repeat = $_POST['pswd_repeat'];

    if (empty($uname)|| empty($email) || empty($pswd)) {
        echo '<script type="text/javascript">';
        echo 'alert("All fields are required!");';
        echo 'window.location.href ="register.php";';
        echo '</script>';
    }elseif (!preg_match("/^[a-zA-Z ]*$/",$uname)) {
            echo '<script type="text/javascript">';
            echo 'alert("Wrong Username format!");';
            echo 'window.location.href ="register.php";';
            echo '</script>';
            exit();
      }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script type="text/javascript">';
        echo 'alert("Wrong email format!");';
        echo 'window.location.href ="register.php";';

        echo '</script>';
          exit();
      }else {
        $uppercase = preg_match('@[A-Z]@', $pswd);
        $lowercase = preg_match('@[a-z]@', $pswd);
        $number    = preg_match('@[0-9]@', $pswd);
        if(!$uppercase || !$lowercase || !$number || strlen($pswd) < 8){
            echo '<script type="text/javascript">';
            echo 'alert("password format is wrong, min 8 include uppercase, lowercase and number!");';
            echo 'window.location.href ="register.php";';

            echo '</script>';
            exit();
        }else {
          if($pswd !== $pswd_repeat){
            echo '<script type="text/javascript">';
            echo 'alert("password do not match!");';
            echo 'window.location.href ="register.php";';

            echo '</script>';
            exit();
          }else {
            $sql= "SELECT * FROM user WHERE email='$email'";
            $result= mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) >= 1 ) {
                echo '<script type="text/javascript">';
                echo 'alert("email taken!");';
                echo 'window.location.href ="register.php";';

                echo '</script>';
              exit();
            }else {
                $sql= "SELECT * FROM user WHERE uname='$uname'";
                $result= mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) >= 1 ) {
                    echo '<script type="text/javascript">';
                    echo 'alert("username taken!");';
                    echo 'window.location.href ="register.php";';

                    echo '</script>';
                  exit();
                }else{
                    $pswd= password_hash($pswd, PASSWORD_DEFAULT);
                    $created=date("Y/m/d");
                    $sql= "INSERT INTO user (uname, email, pswd, created_at) VALUES ('$uname', '$email', '$pswd', '$created')";
                    $result = mysqli_query($conn, $sql);
                    header("Location: index.php");
                     exit();
                 
                  
        }
    }
}
        }
    }
}  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <Link rel="icon" href="images/favicon.ico">
    <title>Welcome to | Messaging System!</title>
    <Link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <a href="#">Messages</a>
        <a href="index.php">Login</a>
        <a href="#" class="right">Logout</a>
    </div>

    <div class="header">
        <h1>Messaging System</h1>
        <p>A Simple messaging system created by Abel Uchennaya Kingson.</p>
    </div>
    <div>
        <form action="" method="POST">
            <div class="container">
                <h1>Register</h1>
                <p>Please fill in this form to create an account.</p>
                <hr>
                <label for="email"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname"  required>

                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email"  required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="pswd"  required>

                <label for="pswd-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="pswd_repeat"  required>

                <label for="avatar"><b>Upload Avatar</b></label>
                <input type="file" name="avatar" >
                                                                
                <hr>

                <button type="submit" name="register" class="registerbtn">Register</button>
                </div>

                <div class="container signin">
                <p>Already have an account? <a href="index.php">Sign in</a>.</p>
            </div>
        </form>
    </div>
   
    <div class="footer">
    <h2>All Rights Reserved </h2>
    </div>
</body>
</html>