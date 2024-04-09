<?php
$Host ="localhost";
$user ="root";
$pass ="";
$dbName ="messaging_system";

$conn= new mysqli($Host, $user, $pass, $dbName);
if(!$conn){
    echo 'error connecting to db'; 
}else {
    // echo ' connected to db'; 

}

