<?php
require_once('auth_check.php'); 
session_destroy(); 
header("location: index.php");
