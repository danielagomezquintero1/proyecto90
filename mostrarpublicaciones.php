<?php
//Si existe una id en la url... luego verificamos si esa id la tiene un usuario y la mostramos por pantalla
//recogemos el id de la url porque pusimos .php?id=X conrequest

if(empty($_REQUEST['id'])){
	header("location: indexofi.php");
} else{

	$idusuario = $_REQUEST['id'];
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

	//ahora RELACIONAMOS ESA ID CON UNA BASE DE DATOS


	$sql = "SELECT * FROM publicaciones WHERE user='$idusuario'"; //el idusuario es para comprobar si existe uno en la tabla
	
	  //se hace la consulta
	$result = $conn->query($sql);


	 if($result){ //validamos si nos ha dado esa cantidad de filas
	 	while($data=$result->fetch_assoc()){//devuelve el resultado de las tablas en array para que podamos trabajar con los datos
	 		echo $data['descripcion'];
	 	}
	 }else{
	 	header("location: indexofi.php");
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
		<title>Eliminar un usuario</title>

		<style type="text/css">


			.bs-example{
				font-family: sans-serif;
				position: relative;
				margin: 50px;
			}
			.typeahead, .tt-query, .tt-hint {
				border: 2px solid #CCCCCC;
				border-radius: 8px;
				font-size: 24px;
				height: 30px;
				line-height: 30px;
				outline: medium none;
				padding: 8px 12px;
				width: 396px;
			}
			.typeahead {
				background-color: #FFFFFF;
			}
			.typeahead:focus {
				border: 2px solid #0097CF;
			}
			.tt-query {
				box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
			}
			.tt-hint {
				color: #999999;
			}
			.tt-dropdown-menu {
				background-color: #FFFFFF;
				border: 1px solid rgba(0, 0, 0, 0.2);
				border-radius: 8px;
				box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
				margin-top: 12px;
				padding: 8px 0;
				width: 422px;
			}
			.tt-suggestion {
				font-size: 24px;
				line-height: 24px;
				padding: 3px 20px;
			}
			.tt-suggestion.tt-is-under-cursor {
				background-color: #0097CF;
				color: #FFFFFF;
			}
			.tt-suggestion p {
				margin: 0;
			}

			.image {
				display:inline-block;
				margin:6%;
				width:80%;
				max-width:100%;
			}
			body{
				background-color:#001a33;
			}
			*{
				text-align: center;
			}
			a, h1, button{
				font-family: 'Lato', sans-serif;
			}

			table {
				table-layout: fixed;
				width: 100%;
				border-collapse: collapse;
				border: 3px solid purple;
				background-color: #F5F5F5;
			}
			thead th:nth-child(1) {
				width: 30%;
			}

			thead th:nth-child(2) {
				width: 20%;
			}

			thead th:nth-child(3) {
				width: 15%;
			}

			thead th:nth-child(4) {
				width: 35%;
			}

			th, td {
				padding: 10px;
			}
			#editar{
				width: 15%;
			}
			#eliminar{
				width: 15%;
			}

			#subirpng:hover {
				opacity: .5;
			}



		</style>
	</head>
	
	<body>
		<div class="container">
			<div class="row" id="info">
				<div class="col-12 m-5" style="font-weight: bold;color:white;">
					<h3 id="usu"><i><u>Publicaciones del usuario

						<?php
            $sqlxd = "SELECT * FROM users WHERE id='$idusuario'"; //el idusuario es para comprobar si existe uno en la tabla

	 $resultxd = mysqli_query($conn, $sqlxd);  //se hace la consulta
	 $result1xd =mysqli_num_rows($resultxd); //nos devuelve una cantidad de filas

	 if($result1xd>0){ //validamos si nos ha dado esa cantidad de filas
	 	while ($dataxd = mysqli_fetch_array($resultxd)) { //devuelve el resultado de las tablas en array para que podamos trabajar con los datos
	 		echo $dataxd['username'];
	 	}
	 }else{
	 	header("location: indexofi.php");
	 }

	 ?>



	</u></i></h3>

</div>
<table style="background-color: white;">
	<tr> 
		<td><div class="col-12 mb-4" style="font-weight:bold">Canción</div></td>           
		<td><div class="col-12 mb-4" style="font-weight:bold">Portada de la canción</div></td>		
		<td><div class="col-12 mb-4" style="font-weight:bold">Fecha de subida</div></td>
		<td><div class="col-12 mb-4" style="font-weight:bold">Acciones</div></td>
	</tr>
	<tr>

		<?php 


            //mostrar todos los campos de users

		$sqlp = "SELECT * FROM publicaciones WHERE user='$idusuario'";
		$resultp=$conn->query($sql);
		while($data=$resultp->fetch_assoc()){
              //datos para mostrar en el formulario de modificar

			echo"<td><audio controls>
			<source src='".$data['ubicacion']."' type='audio/ogg'>
			<source src='horse.mp3' type='audio/mpeg'>
			Your browser does not support the audio element.
			</audio></td>";
		//echo "<td><img style='width:60%;'src='ubicacion/".$data['ubicacion']."'></td>";
			echo "<td><img style='width:45%;'src='".$data['descripcion']."'></td>";
			echo "<td>".$data['fecha']."</td>";    
			?>
			<td><a data-toggle='modal' data-target='#modalEdicion' onclick="agregaform('<?php echo $datos?>')" class='btn btn-primary'> <img id='editar' src='editaricon.png'> Modificar</a>
				<?php echo"<a href='eliminar_user.php?id=".$data['id']."' class='btn btn-danger'><img id='eliminar' src='eliminar.png'> Eliminar </a>
				</td>
				</tr>";}?>
				<!--FILA=ID PARA BORRAR UN USUARIO EN ESPECIFICO-->
				<!-- Modal modificar-->
				<div class="modal fade" id="modalEdicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Modificar datos</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="post" id="actualizarform">
									<input type="text" hidden="" id="idpersonau" name="idpersonau"> <!--muestra el id por la var datos-->
									<label>Nombre: </label>
									<input type="text" name="nombreu" id="nombreu" class="form-control input-sm">


								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
									<button type="submit" class="btn btn-primary">Actualizar datos</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</table>
		</div>
	</div>
	<div class="row mt-5 ml-5">
		<div class="col-3">
			<a href="javascript:history.back()"><img src="goback.png" width="20%" alt="Botón">
			</div>
		</div>
	</body>
	</html>
