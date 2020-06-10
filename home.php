<?php
session_start();
//if(!isset($_SESSION['user'])){
//  echo"hola no registrado";
//  } elseif($_SESSION['user'] != 'demo'){
//    echo"hola normal";
//    } else{
//      echo"hola admin";
//    }
?>
<!doctype html>
<html lang="es">
<?php include 'head.php';?>
<body>

    <!--navbar-->

  <?php include 'navbar.php';?>

    <!--contenido del centro de la pagina-->

  <?php include 'contenido.php';?>

    <!-----footer----->

  <?php include 'footer.php';?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="misscripts.js"></script>
  </body>
  </html>