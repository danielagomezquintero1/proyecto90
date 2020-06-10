<?php
session_start();
require "conexion.php";
$postid = $_POST['id'];
$user =$_SESSION['id']; // el usuario registrado... guardamos la sesion en una variable para trabajar con ella..
//usuario si le ha dado like o no en la publicacion
$countLikes = $conn->query("SELECT * FROM likes WHERE usuario ='$user' AND  post = '$postid'");
$cLike = $countLikes->num_rows;

 //borramos el like de la tabla, pero si no le ha dado like le insertarmos
//insertamos y actulziamos la publicaicon para que se sume un like
if($cLike == 0){
	$insertLike = $conn->query("INSERT INTO likes (usuario,post,fecha) VALUES ('$user', '$postid',now())");
	$updatePub = $conn->query("UPDATE publicaciones SET likes = likes+1 WHERE id ='$postid'");
} else{
	$insertLike = $conn->query("DELETE FROM likes WHERE usuario= '$user' AND post ='$postid'");
	$updatePub = $conn->query("UPDATE publicaciones SET likes = likes-1 WHERE id ='$postid'");
}
//mostrar cuantos likes tiene una publicacion
$contarlikes = $conn->query("SELECT * FROM publicaciones WHERE id = '$postid'");
$cont = mysqli_fetch_array($contarlikes);
$numlikes = $cont['likes'];

if ($cLike == 0){ //si yo no lo he dado like a esta publicacion
	//UNA COSA ES CONTAR LOS LIKES Y OTRA COSA ES SI YO LE HE DADO LIKE
	//EN LA BASE DE DATOS, LA TABLA LIKES PUEDE EXISTIR O NO, SI EXISTE LE HA DADO LIKE EL USER...
	//EN LA BASE DE DATOS, LA TABLA PBLUCAIONES CUENTA LOS LIKES
	$megusta = "<img src='images/cora2.png'>";	
	$numlikes = $numlikes++;
} else{
	$megusta = "<img src='images/cora.png'>";	
	$numlikes = $numlikes--;
}

$return = array("img"=>$megusta,"likes"=>$numlikes);

echo json_encode($return);
?>