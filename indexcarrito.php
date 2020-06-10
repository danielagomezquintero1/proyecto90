<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';


?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>Tienda Upload It</title>
</head>
<body>
  <?php
  include "navbar.php";
  include "head.php";
  ?>
  <div class="container my-5">
    <?php if($mensaje!="") {?>
    <div class="alert alert-success"> <!--este mensaje cambiara cuando el usuario ponga algo en el carrito-->
      <?php echo $mensaje; ?>  
      <a href="mostrarCarrito.php" class="badge badge-success">Ver carrito</a>
      </div>
    <?php } ?>
    <!--utensilios para vender-->
    <div class="row">

      <?php
      $sentencia=$pdo->prepare("SELECT * FROM tblproductos");
      $sentencia->execute();
      $listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
      //print_r($listaProductos);
      ?>

      <?php foreach($listaProductos as $producto){ ?>

        <div class="col-3 ">
          <div class="card" style="width: 18rem;">
            <img title="<?php echo $producto['Nombre']; ?>" alt="<?php echo $producto['Nombre']; ?>" src="<?php echo $producto['Imagen'] ?>" class="card-img-top" data-toggle="popover" data-trigger="hover"data-content="<?php echo $producto['Descripcion']; ?>" height="317px">
            <div class="card-body">
              <span><?php echo $producto['Nombre']; ?></span>
              <h5 class="card-title"><?php echo $producto['Precio']; ?></h5>
              <p class="card-text">Descripcion</p>

              <form action="" method="post">

                <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">
                <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'], COD, KEY); ?>">
                <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'], COD, KEY); ?>">
                <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1, COD, KEY); ?>">

                <button  name="btnAccion" value="Agregar" type="submit" class="btn btn-primary">Agregar al carrito</button>

              </form>

            </div>
          </div>
        </div> 


      <?php  }  ?>


    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

  <script type="text/javascript">

    //popover

    $(function () {
      $('[data-toggle="popover"]').popover()
    })

  </script>

</body>
</html>