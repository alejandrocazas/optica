/*=============================================
EDITAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEditarCliente", function(){

	var idCliente = $(this).attr("idCliente");

	var datos = new FormData();
    datos.append("idCliente", idCliente);

    $.ajax({

      url:"ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      
      	   $("#idCliente").val(respuesta["id"]);
	       $("#editarCliente").val(respuesta["nombre"]);
	       $("#editarDocumentoId").val(respuesta["documento"]);
	       $("#editarEmail").val(respuesta["email"]);
	       $("#editarTelefono").val(respuesta["telefono"]);
	       $("#editarDireccion").val(respuesta["direccion"]);
         $("#editarapellido").val(respuesta["apellido"]);
	  }

  	})

})

/*=============================================
FUNCION CARGAR DATOS PACIENTE EN ALERTAR TECNÓLOGO
=============================================*/
$("#seleccionarCliente").change(function () {

	var idCliente = $("#seleccionarCliente :selected").val();
  
	var datosCliente = new FormData();
  
	datosCliente.append("idCliente", idCliente);
  
	$.ajax({
  
	  url: "ajax/clientes.ajax.php",
	  method: "POST",
	  data: datosCliente,
	  cache: false,
	  contentType: false,
	  processData: false,
	  dataType: "json",
	  success: function (respuesta) {

		$("#clienteAlerta").val("Atención, el paciente con nombre: "+respuesta["nombre"]+" Rut: "+respuesta["documento"]+" está en espera!");

	  }
  
	})
  
});



/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEliminarCliente", function(){

	var idCliente = $(this).attr("idCliente");
	
	swal({
        title: '¿Está seguro de borrar el cliente?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar cliente!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=clientes&idCliente="+idCliente;
        }

  })

})