<?php
//Si existe una id en la url... luego verificamos si esa id la tiene un usuario y la mostramos por pantalla


if(empty($_REQUEST['id'])){
	header("location: home.php");
} else{
	echo"existe un usuario";
	$idpubli = $_REQUEST['id'];
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "photogram";

  // Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}


	if(!empty($_POST)){ //si le damos al boton aceptar
	$idpubli = $_POST['idpubli']; //recogemos el valor del formulario...metodo rapido para recoger el id del usuario
	$sql = "DELETE FROM publicaciones WHERE id='$idpubli'";
	$sqlpubli = "DELETE FROM comentarios WHERE publicacion='$idpubli'"; 


	$conn->query($sqlpubli);
    $result = $conn->query($sql);
    if($result){
    	header("location:home.php");
    } else{
    	echo"Error al eliminar";
    }
}

	$sql = "SELECT * FROM publicaciones WHERE id='$idpubli'"; //el idusuario es para comprobar si existe uno en la tabla
	
	 $result = mysqli_query($conn, $sql);  //se hace la consulta
	 $result1 =mysqli_num_rows($result); //nos devuelve una cantidad de filas

	 if($result1>0){ //validamos si nos ha dado esa cantidad de filas
	 	while ($data = mysqli_fetch_array($result)) { //devuelve el resultado de las tablas en array para que podamos trabajar con los datos
	 		$nombre = $data['descripcion'];
	 	}
	 }else{
	 	header("location: home.php");
	 }
	}
	?>

	<!DOCTYPE html>
	<html>
	<head>

		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<meta charset="utf-8">
		<style type="text/css">
			body{
				background-color:#001a33;
			}
			span{
				color:red;
			}
		</style>
		<title>Eliminar una publicacion</title>
	</head>
	<body>
		<div class="container" style="background-color: #F5F5F5;text-align:center;">
			<div class="row">
				<div class="col-12 mt-4">
					<h2>¿Estas seguro de eliminar la siguiente publicación?</h2> 
					<img style="width:50%;"src="<?php echo $nombre;?>">
					<div class="row">
						<div class="col-12 mt-4">
							<form method="POST" action="">
								<!-- esto es para pillar el id del usuario cunado le demos a aceptar-->
								<input type="hidden" name="idpubli" value="<?php echo $idpubli?>">
								<input type="submit" name="Aceptar" class="btn btn-primary" value="Aceptar">
								<a href="home.php" class="btn btn-danger">Cancelar</a>
							</form>
						</div>
					</div>
				</div>
			</div>
		</body>
		</html>
