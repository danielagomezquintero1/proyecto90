<?php
include "global/config.php";
include "global/conexion.php";
include "carrito.php";
include "navbar.php";
include "head.php";
?>

<?php

//print_r($_GET);

$ClientID="AZ1A2TJfRppNNHgoD7joGlLo4xd_EH_g1vo69JoRPB50WrGWivh2YZylgG0kuH66RnVqIb2uduvWvt_6";
$Secret="EI593iLtVXO4iMOKApdfCiMcj2hz-rglpgrKv-idL3F3-Pyzm84AOsctRhMNex5FpJkaP2AfdJ8RTvHi";

	$Login = curl_init("https://api.sandbox.paypal.com/v1/oauth2/token");

	curl_setopt($Login, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($Login, CURLOPT_USERPWD,$ClientID.":".$Secret);
	curl_setopt($Login, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

	$Respuesta=curl_exec($Login);

	

	$objRespuesta=json_decode($Respuesta); //decodificar para  trasformarlo en un objeto y recoger el toekn

	$AccessToken=$objRespuesta->access_token; //este token sirve para acceder a la infromacion de la venta

	//print_r($AccessToken);

	$venta = curl_init("https://api.sandbox.paypal.com/v1/payments/payment/".$_GET['paymentID']); //consultar la informacion de ese pago
	
	curl_setopt($venta, CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: Bearer ".$AccessToken)); //enviar datos para que nos de informacion de esa venta
	curl_setopt($venta, CURLOPT_SSL_VERIFYPEER, TRUE);
	curl_setopt($venta, CURLOPT_RETURNTRANSFER, TRUE);
	$RespuestaVenta=curl_exec($venta);
	
	//print_r($RespuestaVenta);

	$objDatosTransaccion=json_decode($RespuestaVenta);

	//print_r($objDatosTransaccion->payer->payer_info->email); //convertimos en un objeto

	$state=$objDatosTransaccion->state;
	$email =$objDatosTransaccion->payer->payer_info->email;
	$total = $objDatosTransaccion->transactions[0]->amount->total;
	$currency = $objDatosTransaccion->transactions[0]->amount->currency;
	$custom = $objDatosTransaccion->transactions[0]->custom;

	$clave = explode("#", $custom); //valor qeu buscamos
	$SID = $clave[0]; //antes del comodin
	$claveVenta = openssl_decrypt($clave[1], COD, KEY); //quitamos la encriptacion

	curl_close($venta);
	curl_close($Login);

	//validar si el pago es aprobado

	//echo $state;

	if ($state=="approved") {
	$mensajePaypal = "<h3>Pago aprobado</h3>";

	$sentencia=$pdo->prepare("UPDATE `tblventas` SET `PaypalDatos` =:PaypalDatos, `status` = 'aprobado' WHERE `tblventas`.`ID` =:ID;");
	$sentencia->bindParam(":ID",$claveVenta);
	$sentencia->bindParam(":PaypalDatos",$RespuestaVenta);
	$sentencia->execute();

	//con estos valores validamos que el total y el id sean de la transaccion
	$sentencia=$pdo->prepare("UPDATE `tblventas` SET `status` ='completo' WHERE ClaveTransaccion=:ClaveTransaccion AND Total=:TOTAL AND ID =:ID;");
	$sentencia->bindParam(":ClaveTransaccion",$SID);
	$sentencia->bindParam(":TOTAL",$total);
	$sentencia->bindParam(":ID",$claveVenta);
	$sentencia->execute();

	$completado=$sentencia->rowCount();
	
}else{
	$mensajePaypal = "<h3>Hay un problema con el pago de paypal</h3>";
}
//echo $mensajePaypal;
//echo $mensajePaypal." ".$SID." ".$claveVenta." ".$total;

?>

<div class="jumbotron">
	<h1 class="display-4">¡Listo!</h1>
	<hr class="my-4">
	<p class="lead"><?php echo $mensajePaypal; ?></p>
	<p>
		<?php
	if($completado>=1){ //para ver las cosas que has comprado
		$sentencia=$pdo->prepare("SELECT * FROM tbldetalleventa, tblproductos
		 WHERE tbldetalleventa.IDPRODUCTO=tblproductos.ID
		 AND tbldetalleventa.IDVENTA=:ID");

			$sentencia->bindParam(":ID",$claveVenta);
			$sentencia->execute();

			$listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
			//print_r($listaProductos);
	}

		?>
		<div class="row">
			<?php foreach($listaProductos as $producto){ ?>
			<div class="col-2">
				<div class="card">
					<img height="300px"class="card-img-top" src="<?php echo $producto['Imagen']; ?>">
					<div class="card-body">

						<p class="card-text"><?php echo $producto['Nombre']; ?></p>

						<form action="descargas.php" method="post">

						<input type="text" name="IDVENTA" id="" value="<?php echo openssl_encrypt($claveVenta,COD,KEY);?>">	
						<input type="text" name="IDPRODUCTO" id="" value="<?php echo openssl_encrypt($producto['IDPRODUCTO'],COD,KEY);?>">	

						<button class="btn btn-success" type="submit">Descargar</button>


						</form>

					</div>
				</div>
			</div>
		<?php } ?>  
		</div>
	</p>
</div>
<?php include "footer.php";?>