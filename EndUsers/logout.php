<?php 
session_start();
unset($_SESSION["username"]);
unset($_SESSION["fullname"]);
unset($_SESSION["role"]);
echo header("location:../index.php");
?>