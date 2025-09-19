

/*=============================================
EDITAR historia
=============================================*/
$(".tablas").on("click", ".btnEditarhistoria", function(){

  var idhistoria = $(this).attr("idhistoria");
  
  var datos = new FormData();
  datos.append("idhistoria", idhistoria);

  $.ajax({

    url:"ajax/historias.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){
      
      $("#editarNombre").val(respuesta["nombre"]);
      $("#editarapellido").val(respuesta["apellido"]);
      $("#editarNombre2").val(respuesta["nombre2"]);
      $("#editarapellido2").val(respuesta["apellido2"]);
      $("#editardocumentoid").val(respuesta["documentoid"]);
      $("#editarnota").val(respuesta["nota"]);
      $("#editaresferaoi").val(respuesta["esferaoi"]);
      $("#editaresferaod").val(respuesta["esferaod"]);
        $("#editarcilindrooi").val(respuesta["cilindrooi"]);
      $("#editarcilindrood").val(respuesta["cilindrood"]);

        $("#editarejeoi").val(respuesta["ejeoi"]);
      $("#editarejeod").val(respuesta["ejeod"]);

              $("#editaraddoi").val(respuesta["addoi"]);
      $("#editaraddod").val(respuesta["addod"]);

 $("#editardpoi").val(respuesta["dpoi"]);
      $("#editardpod").val(respuesta["dpod"]);
      
      $("#editarhistoria").val(respuesta["historia"]);
    
    

    }

  });

})

/*=============================================
ACTIVAR historia
=============================================*/
$(".tablas").on("click", ".btnActivar", function(){

  var idhistoria = $(this).attr("idhistoria");
  var estadohistoria = $(this).attr("estadohistoria");

  var datos = new FormData();
  datos.append("activarId", idhistoria);
    datos.append("activarhistoria", estadohistoria);

    $.ajax({

    url:"ajax/historias.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

          if(window.matchMedia("(max-width:767px)").matches){

             swal({
            title: "El historia ha sido actualizado",
            type: "success",
            confirmButtonText: "¡Cerrar!"
          }).then(function(result) {
              if (result.value) {

                window.location = "historias";

              }


        });

          }

      }

    })

    if(estadohistoria == 0){

      $(this).removeClass('btn-success');
      $(this).addClass('btn-danger');
      $(this).html('Desactivado');
      $(this).attr('estadohistoria',1);

    }else{

      $(this).addClass('btn-success');
      $(this).removeClass('btn-danger');
      $(this).html('Activado');
      $(this).attr('estadohistoria',0);

    }

})

/*=============================================
REVISAR SI EL historia YA ESTÁ REGISTRADO
=============================================*/

$("#nuevohistoria").change(function(){

  $(".alert").remove();

  var historia = $(this).val();

  var datos = new FormData();
  datos.append("validarhistoria", historia);

   $.ajax({
      url:"ajax/historias.ajax.php",
      method:"POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(respuesta){
        
        if(respuesta){

          $("#nuevohistoria").parent().after('<div class="alert alert-warning">Este historia ya existe en la base de datos</div>');

          $("#nuevohistoria").val("");

        }

      }

  })
})

/*=============================================
IMPRIMIR historia
=============================================*/

$(".tablas").on("click", ".btnImprimirhistoria", function(){

  var codigoVenta = $(this).attr("codigoVenta");

  window.open("extensiones/tcpdf/pdf/historia.php?codigo="+codigoVenta, "_blank");

})



/*=============================================
ELIMINAR historia
=============================================*/
$(".tablas").on("click", ".btnEliminarhistoria", function(){

  var idhistoria = $(this).attr("idhistoria");
  var fotohistoria = $(this).attr("fotohistoria");
  var historia = $(this).attr("historia");

  swal({
    title: '¿Está seguro de borrar el historia?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar historia!'
  }).then(function(result){

    if(result.value){

      window.location = "index.php?ruta=historias&idhistoria="+idhistoria+"&historia="+historia;

    }

  })

})




