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
   position:absolute;
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
  <!--PRIMER CONTENIDO-->
  <div class="container mt-5 mb-5" id="primercontenido">
    <div class="row">
      <!--opciones-->
      <div class="col-3">
        <ul class="list-group">
          <li class="list-group-item active rounded">Editar perfil</li>
          <li class="list-group-item rounded" id="cambiarcontraseñaboton">Cambiar contraseña</li>
          <li class="list-group-item rounded" id="cambiarprivacidad">Privacidad y seguridad</li>
        </ul>
      </div>
      <!--contenido-->
      <?php
      require "conexion.php";
      
      ?>
      <div class="col-9 border p-5">
        <form action="" method="post">
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-2">
                  <?php
                  $sqlA = $conn->query("SELECT * FROM users WHERE username = '". $_SESSION['user']."'");
                  $rowA = $sqlA->fetch_array(); 
                  ?>
                  <img style="width:70%;"src="conf.png">
                </div>

                <?php
                if(isset($_POST['editar'])) {
                  require "conexion.php";

                  $nombre = $conn->real_escape_string($_POST['nombre']);
                  $username = $conn->real_escape_string($_POST['username']);
                  $bio = $conn->real_escape_string($_POST['bio']);
                  //comprobar si el usuario ya esta en la bd
                  $sqlB = $conn->query("SELECT * FROM users WHERE username = '$nombre'");
                  $totalusuarios = $sqlB->num_rows;

                  if($totalusuarios > 0){
                    $existe="<p style='color:red'><i>Ya hay un usuario con este nombre</i></p>";
                  } else{

                    $sqlE = $conn->query("UPDATE users SET name = '$nombre', username='$username', bio='$bio' WHERE id= '".$_SESSION['id']."'");
                    $sqlF =$conn->query("SELECT * FROM users WHERE username='$nombre'");
                    $resultF=$sqlF->fetch_array();
                    $_SESSION['user'] = $username;
                    $_SESSION['id'] = $resultF["id"]; 

                    if($sqlE){
                      $correcto="<p style='color:green'><i>Se han modificado tus datos</i></p>";
                      echo"<script>location = 'editar_perfil.php';</script>";
                    }
                  }
                }
                ?>

                <div class="col-10 mt-4" style="text-align:left;">
                  
                  <a href="cambiarfotodeperfil.php">Cambiar foto de perfil</a>
                </div>

                <div class="col-12 mt-4">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="">Nombre</span>
                    </div>
                    <input type="text" id="nombre" name="nombre" class="form-control">
                  </div>
                </div>

                <div class="col-12 mt-4">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="">Nombre de usuario</span>

                    </div>
                    <input type="text" id="username" name="username"  class="form-control"><br>
                    <span><?php if(isset($existe)) { echo $existe; } ?></span>
                  </div>
                </div>

                <div class="col-12 mt-4">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="">Biografía</span>
                    </div>
                    <input type="text" id="bio" name="bio" class="form-control">
                  </div>
                </div>

                <div class="col-12 mt-4" style="text-align: right;">
                  <button type="submit" name="editar" id="editar" class="btn btn-primary btn-md">Editar</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <!--SEGUNDO CONTENIDO-->
  <div class="container mt-5 mb-5" id="segundocontenido">
    <div class="row">
      <!--opciones-->
      <div class="col-3">
        <ul class="list-group">
          <li class="list-group-item rounded" id="cambiareditaboton">Editar perfil</li>
          <li class="list-group-item active rounded">Cambiar contraseña</li>
          <li class="list-group-item rounded" id="cambiarprivacidad1">Privacidad y seguridad</li>
        </ul>
      </div>
      <!--contenido-->
      <?php
      require "conexion.php";
      $sqlA = $conn->query("SELECT * FROM users WHERE username = '". $_SESSION['user']."'");
      $rowA = $sqlA->fetch_array(); 
      ?>
      <div class="col-9 border p-5">
        <form action="" method="post">
          <div class="row">
            <div class="col-12">
              <div class="row">


                <?php
                if(isset($_POST['editarcontra'])) {
                  require "conexion.php";

                  $passActual = $conn->real_escape_string($_POST['pass']);
                  $pass1 = $conn->real_escape_string($_POST['pass1']);
                  $pass2 = $conn->real_escape_string($_POST['pass2']);

                  //sobreescribimos las variables con md5 (las encriptamos)  
                  $passActual = md5($passActual);
                  $pass1 = md5($pass1);
                  $pass2 = md5($pass2);

                  
                  $sqlpass = $conn->query("SELECT password FROM users WHERE id = '".$_SESSION['id']."'");
                  $pass = $sqlpass->fetch_array();

                  //verificamos si la contrasena coincide con la contrasena de la bd
                  if($rowA['password'] == $passActual){

                    if($pass1 == $pass2){

                      $actualizar = $conn->query("UPDATE users SET password = '$pass1' WHERE id= '".$_SESSION['id']."'");
                      if($actualizar){$bien ="<p style='color:green;'>Se ha actualizado tu contraseña</p>";}

                    } 
                    else {
                      $no1= "<p style='color:red;'>Las contraseñas no coinciden. Vuelve a intentarlo</p>";
                    }
                  }

                  else{
                    $no2="<p style='color:red;'>Tu contraseña actual no coincide.Vuelve a intentarlo</p>";

                  }
                }
                ?>



                <div class="col-12 mt-4">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="">Contraseña Actual</span>
                    </div>
                    <input type="password" id="pass" name="pass" class="form-control">
                  </div>
                </div>

                <div class="col-12 mt-4">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="">Contraseña nueva</span>

                    </div>
                    <input type="password" id="pass1" name="pass1" class="form-control"><br>
                    
                  </div>
                </div>

                <div class="col-12 mt-4">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="">Escribe otra vez tu contraseña</span>
                    </div>
                    <input type="password" id="pass2" name="pass2" class="form-control">
                  </div>
                </div>

                <div class="col-12 mt-4" style="text-align: right;">
                  <button type="submit" name="editarcontra" id="editarcontra" class="btn btn-primary btn-md">Editar</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--TERCER CONTENIDO-->

  <div class="container mt-5 mb-5" id="tercercontenido">
    <div class="row">
      <!--opciones-->
      <div class="col-3">
        <ul class="list-group">
          <li class="list-group-item rounded" id="cambiaperfil1">Editar perfil</li>
          <li class="list-group-item rounded" id="cambiacontra1">Cambiar contraseña</li>
          <li class="list-group-item rounded active">Privacidad y seguridad</li>
        </ul>
      </div>
      <!--contenido-->
      <?php
      require "conexion.php";
      $sqlA = $conn->query("SELECT * FROM users WHERE username = '". $_SESSION['user']."'");
      $rowA = $sqlA->fetch_array(); 
      ?>
      <?php
      $sqlcheck = $conn->query("SELECT private_profile FROM users WHERE id = '". $_SESSION['id']."'");
      $rowcheck = $sqlcheck->fetch_array(); 
      ?>
      <div class="col-9 border p-5">
        <form action="" method="post">
          <div class="row">
            <div class="col-12">
              <div class="row">


                <?php
  
                if(isset($_POST['editarperfilprivado'])){
                  $privado = $conn->real_escape_string($_POST['privado']);

                  if($privado="") {
                    $pri = 1;
                  } else{
                    $pri = 0;
                  }

                  $updatee = $conn->query("UPDATE users SET private_profile = '$pri' WHERE id = '". $_SESSION['id']."'");
                  if($updatee) {
                    echo"se ha actualizado";
                  }
                }

              
                ?>



                <div class="col-12 mt-4">

             
                  <?php //si el usuario se privado se checkea solo
                  if($rowcheck['private_profile'] == 1){
                    $act = "checked";
                  } else{
                    $act = "";
                  }
                  ?>
                  <input type="checkbox" name="privado" <?php echo $act; ?>>
                  <label class="form-check-label" for="defaultCheck1">
                    Perfil Privado

                  </label>
              
              </div>



              <div class="col-12 mt-4" style="text-align: right;">
                <button type="submit" name="editarperfilprivado" id="editarperfilprivado" class="btn btn-primary btn-md">Editar</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if(isset($bien)) { echo $bien; } ?>
<?php if(isset($no1)) { echo $no1; } ?>
<?php if(isset($no2)) { echo $no2; } ?>
<?php if(isset($correcto)) { echo $correcto; } ?>
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