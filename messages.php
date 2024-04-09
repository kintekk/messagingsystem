<?php
//  require_once("db/config.php");
 require_once("auth_check.php");

// $result = mysqli_query($conn, $id);
 function test_input($data){
    $data= trim($data);
    $data= stripslashes($data);
    $data= htmlspecialchars($data);
    return $data;
 }
    if(isset($_POST['send'])) {
            $message = test_input($_POST['messages']);
            $id = $_POST['uid'];
            $uname = $_SESSION['uname'];
            if (empty($message)) {
                header("location: messages.php?error=error");
            }else{
                $sql = "INSERT INTO messages(user_id, messages, uname) VALUES('$id', '$message' , '$uname')";
                $result= mysqli_query($conn, $sql);
            }
    }
   
    // writing queries to display messages
    $messages = "SELECT * FROM messages";
    $row = mysqli_query($conn, $messages);


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
    <div class="navbar" style="background-color: gray;">
        <!-- <a href="messages.php">Messages</a> -->
        <a href="logout.php" class="right">Logout</a>
    </div>
    <div class="header">
            <h1>Messaging System</h1>
            <p>A Simple messaging system created by Abel Uchennaya Kingson.</p>
    </div>
    <div class="container">
    <h2 style="text-align: center;">Chat Messages</h2>
    </div>
    <div class="container">
        <?php if(isset($_GET["error"])== "error"){
          echo '<p class="alert alert-danger">You cannot send an empty message!</p>';
      }  ?>
    </div>
    <?php foreach ($row as $messages) {
      $id=$messages['user_id'] ;
      

        if($_SESSION['id']== $messages['user_id']){
      ?>
      
    <div class="container">

    <i class="btn btn-primary"><?php if($_SESSION['id']== $messages['user_id']){ echo "You";}?></i>
        <p  class="bg-dark-subtle"><?php echo $messages['messages'];?></p>
        <span style=" float: rigt;color: #aaa;"><?php echo $messages['created_at']?></span>
    </div>
    <?php }else{?>
        <div class="container ">
            <i class="btn btn-primary" style="float: right;"><?php echo $messages['uname'];?></i><br><br>
        <p style="text-align: right;" class="bg-dark-subtle"><?php echo $messages['messages'];?></p>
        <span style=" float:right; color: #aaa;"><?php echo $messages['created_at']?></span>
    </div>
    <?php }} ?>
        <div class="container">
            <form action="" method="POST">
                <textarea name="messages" id="" cols="130" rows="1" placeholder="
                start typing....."></textarea>
                <input type="hidden" name="uid" value="<?php echo $_SESSION['id'];?>">
                <button type="submit" name="send">send</button>
            </form>
        </div>
    <div class="footer">
        <h2>All Rights Reserved </h2>
    </div>
</body>
</html>