<?php
session_start();
 
require "conexion.php";
$usuario = $_POST['usuario'];;
$comentario = $_POST['comentario'];;
$publicacion = $_POST['publicacion'];;
$insertComent = $conn->query("INSERT INTO comentarios (usuario,comentario,fecha,publicacion) VALUES ('$usuario', '$comentario',now(), '$publicacion')");


?>