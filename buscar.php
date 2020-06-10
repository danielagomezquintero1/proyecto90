 <?php 

      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "photogram";

  // Create connection
      $conexion = new mysqli($servername, $username, $password, $dbname);
  // Check connection
      if ($conexion->connect_error) {
        die("Connection failed: " . $conexion->connect_error);
      }

            //mostrar todos los campos de users
 $query = "SELECT * FROM users";
        if(isset($_POST['consulta'])){
          $q= $conexion->real_escape_string($_POST['consulta']);
          $query = "SELECT * FROM users WHERE username LIKE '%".$q."%'";
        } 

        


       
        $resultmostrar = $conexion->query($query);
        if ($resultmostrar->num_rows > 0) { 
           echo"<table>
        <tr>            
          <td><div class='col-12 mb-4' style='font-weight:bold'>ID</div></td>
          <td><div class='col-12 mb-4' style='font-weight:bold'>Nombre</div></td>
          <td><div class='col-12 mb-4' style='font-weight:bold'>Email</div></td>
          <td><div class='col-12 mb-4' style='font-weight:bold'>Registro</div></td>
          <td><div class='col-12 mb-4' style='font-weight:bold'>Foto de perfil</div></td>
          <td><div class='col-12 mb-4' style='font-weight:bold'>Acciones</div></td>
        </tr>";
        while($fila=$resultmostrar->fetch_assoc()){
              //datos para mostrar en el formulario de modificar
          $datos = $fila['id']."||".$fila['username']."||".$fila['email'];
         
          echo "<tr class='".$fila['id']."'>";
          echo "<td>".$fila['id']."</td>";
          echo "<td class='usernamee'><a style='text-decoration:none;color:black;' href='mostrarpublicaciones.php?id=".$fila['id']."'>".$fila['username']."</a></td>";
          echo "<td class='emaill'>".$fila['email']."</td>";
              echo "<td>".$fila['signup_date']."</td>"; //TR CLASS para que cada fila tenga una clase diferente para cambiarla despues con ajax
              echo "<td class='fotoperfill'><img style='width:30%;'src='".$fila['avatar']."'></td>";
              ?>
              <td><a data-toggle='modal' data-target='#modalEdicion1' onclick="agregaform('<?php echo $datos?>')" class='btn btn-primary'> <img id='editar' src='editaricon.png'> Modificar</a>
                <?php echo"<a href='eliminar_user.php?id=".$fila['id']."' class='btn btn-danger'><img id='eliminar' src='eliminar.png'> Eliminar </a>
                </td>
                </tr>";
                echo"               <!--FILA=ID PARA BORRAR UN USUARIO EN ESPECIFICO-->
                <!-- Modal modificar-->
                <div class='modal fade' id='modalEdicion1' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
                  <div class='modal-dialog modal-dialog-centered' role='document'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLongTitle'>Modificar datos</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                        </button>
                      </div>
                      <div class='modal-body'>
                        <form method='post' id='actualizarform1'>
                          <input type='text' hidden='' id='idpersonau' name='idpersonau1'> <!--muestra el id por la var datos-->
                          <label>Nombre: </label>
                          <input type='text' name='nombreu1' id='nombreu' class='form-control input-sm'>


                        </div>
                        <div class='modal-footer'>
                          <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                          <button type='submit' class='btn btn-primary'>Actualizar datos</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>";
              
            }echo"</table>
            </div>";
          } else {
            echo"<div style='color:white;'class='col-12 my-5'>No hay resultados</div>";
          }
          ?>