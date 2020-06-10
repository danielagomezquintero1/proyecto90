<?php
session_start();
unset($_SESSION['user']);  
unset($_SESSION['CARRITO']);  
header("Location: home.php");
?>
