<?php
include "global/config.php";
include "global/conexion.php";
include "carrito.php";
include "navbar.php";
include "head.php";

?>

<?php 
	

	if($_POST){

		$total=0;//lo que le vamos a cobrar al usuario
		$SID = session_id();//devuelve una clave de la sesion.. evitamos confusion con otros pedidos
		$Correo =$_POST['email'];

		foreach($_SESSION['CARRITO'] as $indice=>$producto){
			$total=$total+($producto['PRECIO']*$producto['CANTIDAD']);
		}

		$sentencia=$pdo->prepare("INSERT INTO `tblventas` (`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) VALUES (NULL, :ClaveTransaccion, '', NOW(),:Correo, :Total, 'pendiente');");

		$sentencia->bindParam(":ClaveTransaccion",$SID);
		$sentencia->bindParam(":Correo",$Correo);
		$sentencia->bindParam(":Total",$total);
		$sentencia->execute();

		$idVenta=$pdo->lastInsertId(); //recuperamos el id de venta.. par que despues hagamos una lreacion con la venta y el detalle de la venta
		foreach($_SESSION['CARRITO'] as $indice=>$producto){
			
		
		$sentencia=$pdo->prepare("INSERT INTO `tbldetalleventa` (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `DESCARGADO`) VALUES (NULL,:IDVENTA,:IDPRODUCTO,:PRECIOUNITARIO,:CANTIDAD, '0');");

		$sentencia->bindParam(":IDVENTA",$idVenta);
		$sentencia->bindParam(":IDPRODUCTO",$producto['ID']);
		$sentencia->bindParam(":PRECIOUNITARIO",$producto['PRECIO']);
		$sentencia->bindParam(":CANTIDAD",$producto['CANTIDAD']);
		$sentencia->execute();
		}


		//echo "<h3>".$total."</h3>";	//se imprime en la pagina pagar.php
	}

?> 


 <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=USD"></script>

<style>
        /* Media query for mobile viewport */
        @media screen and (max-width: 400px) {
            #paypal-button-container {
                width: 100%;
            }
        }
        
        /* Media query for desktop viewport */
        @media screen and (min-width: 400px) {
            #paypal-button-container {
                width: 250px;
            }
        }
    </style>

<div class="jumbotron">
	<h1 class="display-4">¡Paso Final!</h1>
	<hr class="my-4">
	<p class="lead">Estás a punto de pagar con paypal la cantidad de:
		<h4><?php echo number_format($total,2); ?>€</h4>
		  <div style="margin-left:43%;"id="paypal-button-container"></div>

	</p>
		<p>Los productos podrán ser descargados una vez que se procese el pago</p>
		<strong><i>(Para aclaraciones, contacta con nosotros...)</i></strong>
</div>





    <!-- Set up a container element for the button -->
  
    <!-- Include the PayPal JavaScript SDK -->
   
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
 <script>
    paypal.Button.render({
        env: 'sandbox', // sandbox | production
        style: {
            label: 'checkout',  // checkout | credit | pay | buynow | generic
            size:  'responsive', // small | medium | large | responsive
            shape: 'pill',   // pill | rect
            color: 'gold'   // gold | blue | silver | black
        },
 
        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create

        client: {
            sandbox:    'Acz02h4D7D4gVDP_N4aMrD11fNFerjQ45w4alpEZxYsCbq3fgQTksSU4h207qU9t_q8-T9K2R_mGbZq5',
            production: ''
        },
 
        // Wait for the PayPal button to be clicked
 
        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '<?php echo $total;?>', currency: 'EUR' },
                            description:"Compra de productos a ComPC",
                            custom:"<?php echo $SID;?>#<?php echo openssl_encrypt($idVenta, COD, KEY);?>"
                        }
                    ]
                }
            });
        },
 
        // Wait for the payment to be authorized by the customer
 
        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                console.log(data);
                window.location="verificador.php?paymentToken="+data.paymentToken+"&paymentID="+data.paymentID;
            });
        }
   
    }, '#paypal-button-container');
 
</script>








<?php include "footer.php";?>