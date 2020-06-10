<?php
session_start();
//Si existe una id en la url... luego verificamos si esa id la tiene un usuario y la mostramos por pantalla


if(empty($_REQUEST['id'])){
	header("location: home.php");
} else{
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


	if(!empty($_POST)){
	 //si le damos al boton aceptar
	$idpubli = $_POST['idpubli']; //recogemos el valor del formulario...metodo rapido para recoger el id del usuario
	$imagen = $_FILES['file-input']['tmp_name'];
	$ruta = $_FILES['file-input']['name'];
	move_uploaded_file($imagen,$ruta);
	
	
	$sql = "UPDATE publicaciones SET descripcion = '$ruta' WHERE id= '$idpubli'";
	$result = $conn->query($sql);
	if($result){
		header("Location:home.php");
		
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
		<title>Editar una publicacion</title>
	</head>
	<body>
	
		<div class="container" style="background-color: #F5F5F5;text-align:center;">
			<div class="row">
				<div class="col-12 mt-5 mb-5">
					<h4><i>Modificar portada de la canción</i></h4>
					<img style="width:20%;"src="<?php echo $nombre;?>" class="m-5">
					<form enctype="multipart/form-data" method="post" action="">
						<label for="file-input">
							<h3>Cambiar portada de la canción</h3>
							<img class="mt-2 mb-4"src="subir.png" id="subirpng" width="10%;">
						</label>
						<input id="file-input" type="file" name="file-input"  hidden="" />
						<h5>Nueva imagen elegida:</h5>
						<div class="col-12 m-3">
							<div id="resultado" class="mr-4"><img id="imgSalida" style="width:20%; " /></div>
						</div>
					</div>
					<div class="col-12">
						<input type="submit" name="Aceptar" class="btn btn-primary mb-5" value="Aceptar">
						<input type="hidden" name="idpubli" value="<?php echo $idpubli?>">
					</div>
				</form>
			</div>
		</div>

	</div>
	<?php include 'footer.php';?>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="misscripts.js"></script>
</body>
</html>