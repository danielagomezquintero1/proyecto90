<?php
session_start();

if(isset($_SESSION['user'])){
  $user = $_SESSION['user'];
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "photogram";

  // Create connection
  $mysqli = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($mysqli->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 
 $busqueda = strtolower($_REQUEST['busqueda']);
  if(isset($busqueda)){
    $q= $mysqli->real_escape_string($busqueda);
 
    $sqlA = $mysqli->query("SELECT * FROM users WHERE username  LIKE '%".$q."%'");
    $rowA = $sqlA->fetch_array(); 
//comprobamos si existe algun usuario con ese nombre
   $comprobarurl =mysqli_num_rows($sqlA); //nos devuelve una cantidad de filas

   if($comprobarurl>0){ //validamos si nos ha dado esa cantidad de filas

   }else{
    header("location: error.php");
  }
  ?>


  <!doctype html>
  <html lang="es">
  <head>
    <link href="styles/buttons.css" rel="stylesheet">
    <link href="styles/style..css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Courgette|Lato|Pompiere&display=swap" rel="stylesheet">  

    <title>Página principal</title>

    <style type="text/css"> 

      span{ 
        color:blue; }
        #form {
          width: 250px;
          margin: 0 auto;
          height: 50px;
        }

        #form p {
          text-align: center;
        }

        #form label {
          font-size: 20px;
        }

        input[type="radio"] {
          display: none;
        }

        label {
          color: grey;
        }

        .clasificacion {
          direction: rtl;
          unicode-bidi: bidi-override;
        }

        label:hover,
        label:hover ~ label {
          color: blue;
        }

        input[type="radio"]:checked ~ label {
          color: blue;
        }

        fieldset.scheduler-border {
          border: 1px groove #ddd !important;
          padding: 0 1.4em 1.4em 1.4em !important;
          margin: 0 0 1.5em 0 !important;
          -webkit-box-shadow:  0px 0px 0px 0px #000;
          box-shadow:  0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
          font-size: 1.2em !important;
          font-weight: bold !important;
          text-align: left !important;
          width:auto;
          padding:0 10px;
          border-bottom:none;
        }
        #imaa{
          display: inline-block;
          width:200px;

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

        a, h1, button{
         font-family: 'Lato', sans-serif;
       }
     </style>
   </head>
   <body>

    <link rel="icon" type="image/png" href="images/hmm.png" /> 
 <?php require "navbar.php"?>;
 <?php include 'head.php';?>
 <link rel="stylesheet" type="text/css" href="estilos.css">
 <style type="text/css">
    body{
          background-color:#001a33;
          
        }
    
 </style>
<?php
                    $sql =$mysqli->query("SELECT * FROM users WHERE username='$user'");
                    $result=$sql->fetch_array();

                    $sql2 =$mysqli->query("SELECT * FROM publicaciones WHERE user='".$rowA['id']."' ORDER BY id DESC");
                    $result2=$sql2->num_rows;

                    //mostrar seguidores

                    $sql3 =$mysqli->query("SELECT * FROM seguidores WHERE seguido='".$rowA['id']."'");
                    $result3=$sql3->num_rows;

                    $sql4 =$mysqli->query("SELECT * FROM seguidores WHERE seguidor='".$rowA['id']."'");
                    $result4=$sql4->num_rows;
                    ?>
                    
    <div class="container">
      <div class="row mt-5">
        <!--usuario-->
        <div class="col-12"style="background-color: white;">
          <div class="row">
            <div class="col-2 mt-4">
              <?php echo"<img src=".$rowA["avatar"]." style='width:170px'>"; ?>
            </div>


            <div class="col-5 mt-3">
              <div class="row">
                <div class="col-2">
                  <p style="font-size: 40px;"><?php echo $rowA["username"]; ?></p>
                </div>
                <!--si este es mi perfil, sale el boton de configurar perfil-->
                <?php
                if($rowA['id'] == $_SESSION['id']) { ?>
                  <div class="col-8">
                    <div class="mt-3"><a href="editar_perfil.php" class="btn btn-info btn-sm">Editar Perfil</a></div>
                  </div>
                <?php } else{ //SI el perfil es de otro usuario, saldra, seguir  ?>
                  <div class="col-8">
                    <div class="mt-3"><button class="btn btn-info btn-sm">Seguir</button></div>
                  </div>
                <?php }  ?>
                <div class="col-12">
                  <div class="row">
                    <div class="col-3">
                      <small><span><?php echo $result3 ?> </span>Seguidores</small>
                    </div>
                    <div class="col-3">
                     <small><span><?php echo $result4 ?>  </span>Seguidos</small>
                   </div>
                 </div>
               </div>

               <div class="col-12">
                 <div class="row mt-3">
                   <div class="col-12" style="text-align: left;">
                     <?php echo "Email: ".$rowA["email"]; ?>
                   </div>
                   
                   <div class="col-12 mb-5" style="text-align: left;">
                     <?php if(is_null($rowA["bio"])){
                      echo "Este usuario no tiene biografía"; }else{ echo "biografía: ".$rowA["bio"]; }?>    
                   </div>

                 </div>
               </div>
             </div>
           </div>

             <?php
                if($rowA['id'] == $_SESSION['id']) { ?>
                  <div class="col-5" style="text-align: center; margin-top:9%;">
            <a class="btn btn-outline-primary" href="subirpost.php" role="button">Sube un post</a>
          </div>
                <?php } else{ //SI el perfil es de otro usuario, saldra, seguir  ?>
                  <div class="col-5" style="margin-top:7%;">
                    <a href="indexpaypal.php">
                    <img style="width:44%;"src="https://i2.wp.com/dulcesdetectores.com/wp-content/uploads/2019/06/Boton-donar-paypal-300x166-.png">
                    </a>
                  </div>               
                <?php }  ?>
           
        </div>
      </div>
    </div>
    <!--segundo div-->
    <div class="row mt-5">
      <div class="col-12 p-3 m-2" style="background-color: white;">
        <h4>Numero de posts: <?php echo $result2; ?><br></h4>



        <!--mostramos las publicaciones-->

        <!--si el perfil es privado y la session no es mia... no puedo ver el perfil del usuario-->
        <?php 
        if($rowA['private_profile'] == 1 AND $rowA['id'] != $_SESSION['id']){
          echo "<div class='mt-5'><h3><i>Si deseas ver sus posts, sigue a este usuario</i></h3></div>";
        }  else{ 

         ?>   <div class="row">
          <?php
          while($publicaciones = $sql2->fetch_array()) {
            ?>
            
            
            <div class="col-4">
              <img class="m-3 view_data"name="view" value="view" id="<?php echo $publicaciones['id']; ?>" data-target="#<?php echo $publicaciones['id']; ?>" data-toggle="modal" style="width:90%"src='<?php echo $publicaciones['descripcion']; ?>');>
              <!--dropdown-->
<?php
                if($rowA['id'] == $_SESSION['id']) { ?>
                                <div class="dropdown" style="text-align:right; padding-right: 20px;">

                <img class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownMenuButton" style="width:6%;"src="https://image.flaticon.com/icons/png/512/61/61099.png">
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="editarpublicacion.php?id=<?php echo $publicaciones['id']; ?>">Editar</a>
                  <a class="dropdown-item" href="eliminarpublicacion.php?id=<?php echo $publicaciones['id']; ?>">Eliminar</a>
                  
                </div>
              </div>
                <?php } else{ //SI el perfil es de otro usuario, saldra, seguir  ?>
                  <div>
                    
                  </div>
                <?php }  ?>

            </div>

            
            <!-- Modal -->
            <div id="<?php echo $publicaciones['id']; ?>" class="modal fade">  
              <div class="modal-dialog">  
               <div class="modal-content">  
                <div class="modal-header">  
                 <button type="button" class="close" data-dismiss="modal">&times;</button>  
                 <h4 class="modal-title">Detalles de la imagen seleccasdionada</h4>  
               </div>  
               <div class="modal-body" id="employee_detail"> 
                 <audio controls>
                  <source src='<?php echo $publicaciones['ubicacion']; ?>' type="audio/mpeg">
                  </audio> 
                </div>  
                <div class="modal-footer">  
                 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
               </div>  
             </div>  
           </div>  
         </div> 

       <?php }  ?>
     <?php }  ?>
   </div>
 </div>

 <!-- Modal -->



</div>

</div>

 <?php include 'footer.php';?>
<!--
      <fieldset>
        <legend>Datos</legend>
        <h4>Tus datos son</h4>



        <button id="modificar">Modificar datos</button>
        <form id="modificardatos" method="post" style="display: none">
          Nuevo nombre: <input type="text" name="nombrenuevo"><br>
          Nuevo apellido: <input type="text" name="apellidonuevo"><br>
          Nueva contraseña: <input type="text" name="contrasenanuevo">
          <button type="submit">Modificar</button>

        </form>
        <div id="insertar">
          <form id="uploadForm" action="upload.php" method="post">
            <label>Inserte una imagen de perfil</label><br/>
            <input name="userImage" type="file" class="inputFile" />
            <input type="submit" value="Subir imagen" class="btnSubmit" />
          </form>
        </div>
        <div id="mostrardatos"></div>
      </fieldset>
    -->
  <?php }else{
    echo"Este usuario no existe";
  } ?>
</body>
<script type="text/javascript">

  function limpiar(){
    $("#enviaa").click(function(){
      $("#limpia").html("");
    });
  }
  var i = 0;
  function gracias(){
    $("label").click(function(){
      i++;
      $("#gracias").html("Gracias por puntuar!");
      $("#likee").html(i+" likes");

    });

  }
  function modificar(){
    $("#modificar").click(function(){
      $("#modificardatos").show();
    });

  }
  $(document).ready(function() {
    gracias();
    modificar();  
    limpiar();    

     // $('.view_data').click(function(){  no funciona
      // var employee_id = $(this).attr("id");  
      // $.ajax({  
      //  url:"select.php",  
      //  method:"post",  
      //  data:{employee_id:employee_id},  
      //  success:function(data){  
       //  $('#employee_detail').html(data);  
        // $('#dataModal').modal("show");  
      // }  
     //});  
     //});  
     $('#loginform').submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: 'chat.php',
        data: $(this).serialize(),
        success: function(response) {
          $("#chatdiv").html(response);
        }
      });
    });
   });

  $(document).ready(function() {      

    $.ajax({
      type: "POST",
      url: 'mostrarchat.php',
      data: $(this).serialize(),
      success: function(response) {
        $("#chatdiv").html(response);
      }
    });
  });

      //subir image
      $(document).ready(function (e){
        $("#uploadForm").on('submit',(function(e){
          e.preventDefault();
          $.ajax({
            url: "upload.php",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
              $("#ima").html(data);
              $("#insertar").html("");
            },
            error: function(){}           
          });
        }));
      });

      


    </script>
    </html>
    <?php
  }
  else{
    header('WWW-Authenticate: Basic realm="Contenido restringido"');
    header("HTTP/1.0 401 Unauthorized");
    exit;
  }
  ?>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script type="text/javascript">

</script>
</body>
</html>

