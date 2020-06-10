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
<style type="text/css">
   footer{
     bottom:0;
 }
 body{
  height:100%;
 }


</style>
<body>

  <!--navbar-->

  <?php include 'navbar.php';?>

  <!--contenido del centro de la pagina-->
<?php
echo $_SESSION['id'];
?>
  <div class="container">
    <div class="row">
      <div class="col-12 mt-5 mb-5">
        <form enctype="multipart/form-data" id="nuevafotoperfil" method="post">
         <label for="file-input">
                <h3>Subir imagen de perfil</h3>
                  <img class="mt-2"src="subir.png" id="subirpng" width="10%;">
                </label>
                <input id="file-input" type="file" name="file-input"  hidden="" />
                <div class="col-12 m-3">
                  <div id="resultado" class=""><img id="imgSalida" style="width:17%; " /></div>
                </div>
              </div>
                <div class="col-12">
                <input type="submit" name="subir" class="btn btn-primary" value="Agregar foto de perfil">
                </div>
              </form>
      </div>
    </div>
   
  </div>

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