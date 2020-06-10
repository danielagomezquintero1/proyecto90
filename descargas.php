<?php
//controla las descargas que hace el usuario, actualiza la tabla cuando el usuario descarga un archivo incluyendo el archivo encriptado.. este archivo lo renombra a un nombre encriptado
include "global/config.php";
include "global/conexion.php";
include "carrito.php";
?>
<?php 
	//print_r($_POST);
	if($_POST){
		$IDVENTA=openssl_decrypt($_POST['IDVENTA'],COD,KEY);
		$IDPRODUCTO=openssl_decrypt($_POST['IDPRODUCTO'],COD,KEY);

		
		//print_r($IDPRODUCTO);

		$sentencia=$pdo->prepare("SELECT * FROM `tbldetalleventa`
									WHERE IDVENTA=:IDVENTA
									AND IDPRODUCTO=:IDPRODUCTO
									AND DESCARGADO<1"); //carrito de compras solo permite una descarga

							$sentencia->bindParam(":IDVENTA",$IDVENTA);
							$sentencia->bindParam(":IDPRODUCTO",$IDPRODUCTO);
							$sentencia->execute();

					$listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

					//print_r($listaProductos);

					if($sentencia->rowCount()>0){ //cuando el usuario  contabilice de que hay una descargar, le da el archivo y acutlziamos la tabla y ya no puede descargar mas veces el archivo

						//echo "Archivo en descarga...";
						//le doy la direccion de los archivos, el id del producto y el .pdf
						$nombreArchivo="archivospdf/".$listaProductos[0]['IDPRODUCTO'].".pdf";

						$nuevoNombreArchivo= $_POST['IDVENTA'].$_POST['IDPRODUCTO'].".pdf";

						//echo $nuevoNombreArchivo;
						
						header('Content-Transfer-Encoding: binary');
						header("Content-type: application/pdf"); //hacemos que se descargue el pdf
						header("Content-Disposition: attachment; filename=\"$nuevoNombreArchivo\" ");
						readfile("$nombreArchivo");
						

						/*$sentencia = $pdo->prepare("UPDATE `tbldetalleventa` set descargado=descargado+1
							WHERE IDVENTA=:IDVENTA AND IDPRODUCTO=:IDPRODUCTO");

							$sentencia->bindParam(":IDVENTA",$IDVENTA);
							$sentencia->bindParam(":IDPRODUCTO",$IDPRODUCTO);

						$sentencia->execute();
						*/
					}else{
						echo"Tus descargas se acabaron";	
					}
	}

?>
