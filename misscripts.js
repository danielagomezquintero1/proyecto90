    function agregaform(datos){ //funcion que cuando le das a modificar envian estos datos al formulario
      //rellenamos el valor del input

      d=datos.split('||'); //convierte en array
      $('#idpersonau').val(d[0]);
      $('#nombreu').val(d[1]);
    }

//-------------------------------
    function ocultarInfo2(){ 

      
       $('#info2').hide();
       $('#usu2').hide();
        
      
    }
    function darclickPublicaciones(){ 

      $("#publi").click(function(){
       $('#info').hide();
       $('#usu').hide();
       $('#usu2').show();
       $('#info2').show();
        });
      
    }

        function darclickUsuarios(){ 

      $("#publi1").click(function(){
       $('#info').show();
       $('#usu').show();
       $('#usu2').hide();
       $('#info2').hide();
        });
      
    }



function validaForm(){
        if($("#username1").val() == ""){
          $('#result-username').fadeIn(1000).html("<small>No dede de estar vacio</small>");
        $("#username1").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
      }
      if($("#lastname").val() == ""){
        alert("El campo last no puede estar vacío.");
        $("#lastname").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
      }


    return true; // Si todo está correcto
  }

  $(document).ready(function() {

    validaForm();
    darclickUsuarios();
darclickPublicaciones();
ocultarInfo2();





//funciones para busqueda por likes
function segundocontenidolikeshide(){
  $("#segundocontenidolikes").hide();
}

segundocontenidolikeshide();

$("#darverlikes").click(function(){
$("#populares1").hide();
$("#segundocontenidolikes").show();

    });

$("#darverrecientes").click(function(){
$("#populares1").show();
$("#segundocontenidolikes").hide();

    });






//funciones varias parar modificar html de editar_perfil
function segundocontenidohide(){
  $("#segundocontenido").hide();
}

segundocontenidohide();

function tercercontenidohide(){
  $("#tercercontenido").hide();
}

tercercontenidohide();  

$("#cambiarcontraseñaboton").click(function(){
$("#segundocontenido").show();
$("#primercontenido").hide();

    });

$("#cambiareditaboton").click(function(){
$("#segundocontenido").hide();
$("#primercontenido").show();
    });

$("#cambiarprivacidad").click(function(){
$("#primercontenido").hide();
$("#segundocontenido").hide();
$("#tercercontenido").show();

    });

$("#cambiarprivacidad1").click(function(){
$("#primercontenido").hide();
$("#segundocontenido").hide();
$("#tercercontenido").show();

    });

$("#cambiacontra1").click(function(){
$("#primercontenido").hide();
$("#segundocontenido").show();
$("#tercercontenido").hide();

    });


$("#cambiaperfil1").click(function(){
$("#primercontenido").show();
$("#segundocontenido").hide();
$("#tercercontenido").hide();

    });

//FUNCION DE LIKES
$(".like").click(function(){
  var id = this.id; //obtenemos la id
    $.ajax({
    type: "post",
    url: 'likes.php',
    data: {id:id},
    dataType: 'json',
    success: function(data)
    {
      var img = data['img'];
      var likes = data['likes'];
          $('#'+id).html(img); //corazones
          $('#num'+id).html("<small>Le gusta a <b>"+likes+" </b>personas</small>");
            }
          });
    });


//FUNCION PARA SUBIR UNA IMAGEN EN HTML
$(function() {
  $('#file-input').change(function(e) {
    addImage(e); 
  });

  function addImage(e){
    var file = e.target.files[0],
    imageType = /image.*/;

    if (!file.type.match(imageType))
     return;

   var reader = new FileReader();
   reader.onload = fileOnload;
   reader.readAsDataURL(file);
 }

 function fileOnload(e) {
  var result=e.target.result;
  $('#imgSalida').attr("src",result);
}
});

//----



$('#actualizarform').submit(function(e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: 'actualizar_datos.php',
    data: $(this).serialize(),
    beforeSend: function(){
      $('#modalEdicion').modal('toggle');
      $('#notificacion').html("<h6 style='background-color:#228B22;padding:1%;width:50%;margin:0 auto;margin-bottom:5%;'>Usuario modificado con éxito</h6>");

      $("#notificacion").fadeOut(5000);


    },
    success: function(response)
    {
      var jsonData = JSON.parse(response);

                // user is logged in successfully in the back-end
                // let's redirect
                if (jsonData.success == "1")
                {                 
                 location.href = "home.php";
               }
               else
               {
                alert("Error al actualizar");
                location.href = "home.php";
                exit;
              }
            }
          });
});

//para actualziar un usario buscado por el admin
$('#actualizarform1').submit(function(e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: 'actualizar_datos1.php',
    data: $(this).serialize(),
    
    success: function(response)
    {
      var jsonData = JSON.parse(response);

                // user is logged in successfully in the back-end
                // let's redirect
                if (jsonData.success == "1")
                {                 
                 location.href = "home.php";
               }
               else
               {
                alert("Error al actualizar");
                location.href = "home.php";
                exit;
              }
            }
          });
});

$('#nuevousuarioform').submit(function(e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: 'anadirnuevousuarioadmin.php',
    data:  new FormData(this),
    contentType: false,
    cache: false,
    processData:false,
    success: function(response)
    {
      var jsonData = JSON.parse(response);

                // user is logged in successfully in the back-end
                // let's redirect
                if (jsonData.success == "1")
                {
                  
                  location.href = "home.php";
                }
                else
                {
                  alert("No se ha añadido un nuevo usuario");
                  location.href = "home.php";
                  exit;
                }
              }
            });
});


    $('#loginform').submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: 'logeo.php',
        data: $(this).serialize(),
        success: function(response)
        {
          var jsonData = JSON.parse(response);

                // user is logged in successfully in the back-end
                // let's redirect
                if (jsonData.success == "1")
                {
                  location.href = "home.php";
                }
                else
                {
                  alert("No ha podido acceder al área privado porque sus credenciales de acceso no son válidas");
                  location.href = "home.php";
                  exit;
                }
              }
            });
    });


    $('#registroform').submit(function(e) {

      e.preventDefault();
      $.ajax({
        type: "POST",
        url: 'registrarse.php',
        data: $(this).serialize(),
        success: function(response)
        {
          var jsonData = JSON.parse(response);

                // user is logged in successfully in the back-end
                // let's redirect
                if (jsonData.success == "1")
                {
                  
                  location.href = "home.php";
                }
                else
                {
                  alert("No se ha podido registrarse");  
                  exit;
                }
              }
            });

    });

    //compara el nombre del input con un dato de la tabla de la bd
    $('#username1').on('blur', function() {
      var username1 = $(this).val();   
      var dataString = 'username1='+username1;
      $.ajax({
        type: "POST",
        url: "check_username_availablity.php",
        data: dataString,
        success: function(data) {
          $('#result-username').fadeIn(1000).html(data);
        }
      });
    });

      $('#loginchat').submit(function(e) {
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

            $.ajax({
        type: "POST",
        url: 'mostrarchat.php',
        data: $(this).serialize(),
        success: function(response) {
          $("#chatdiv").html(response);
        }
      });

//funcion de comentarios
$(document).ready(function() {

    $(".enviar-btn").keypress(function(event) {

      if ( event.which == 13 ) {

        var getpID =  $(this).parent().attr('id').replace('record-','');

        var usuario = $("input#usuario").val();
        var comentario = $("#comentario-"+getpID).val();
        var publicacion = getpID;
        var now = new Date();
        var date_show = now.getDate() + '-' + now.getMonth() + '-' + now.getFullYear() + ' ' + now.getHours() + ':' + + now.getMinutes() + ':' + + now.getSeconds();
       
        if (comentario == '') {
            alert('Debes añadir un comentario');
            return false;
        }

        var dataString = 'usuario=' + usuario + '&comentario=' + comentario + '&publicacion=' + publicacion;

        $.ajax({
                type: "POST",
                url: "agregarcomentarios.php",
                data: dataString,
                success: function(response) {
                    
                    $('#nuevocomentario'+getpID).append("<div class='col-12'><hr style='width:75%;'><div class='row'><div class='col-12'><div class='row'><div class='col-12' style='text-align:left;'><small><i><b>"+usuario+"</b></i></small></div><div class='col-12' style='text-align:left;'><small style='color:#A9A9A9;'>"+date_show+"</small></div><div class='col-12' style='text-align:left;'><small>"+comentario+"</small><hr style='width:75%;'></div></div></div></div>");
                }
        });
        return false;
      }
    });

});

//usuario modificia su imagen de perfil

$('#nuevafotoperfil').submit(function(e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: 'cambiarfotodeperfilphp.php',
    data:  new FormData(this),
    contentType: false,
    cache: false,
    processData:false,
    success: function(response)
    {
      var jsonData = JSON.parse(response);

                // user is logged in successfully in the back-end
                // let's redirect
                if (jsonData.success == "1")
                {
                  
                  location.href = "home.php";

                }
                else
                {
                  alert("No has modificado tu foto de perfil");
                  location.href = "home.php";
                  exit;
                }
              }
            });
});

//usuario modificia su portada de publicacion

//buscador con keyup

function buscar_datos(consulta){
    $.ajax({
    type: "POST",
    url: 'buscar.php',
    dataType: 'html',
    data: {consulta: consulta},
     })
    .done(function(respuesta){
      $("#info").html(respuesta);
    })
    .fail(function() {
      alert("error");
    })

}

$(document).on('keyup', '#caja_busqueda', function(){
  var valor = $(this).val();
  if(valor!= ""){
    buscar_datos(valor);
  } else{
    buscar_datos();
  }
 });

  });

