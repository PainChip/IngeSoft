<?php
session_start();
$_SESSION["token"] = $_POST["token"];
$_SESSION["correo"] = $_POST["correo"];
$_SESSION["rol"] = $_POST["rol"];
$_SESSION["username"] = $_POST["username"];
echo 'True';
exit();
?>