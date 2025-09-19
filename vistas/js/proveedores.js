/*=============================================
EDITAR proveedor
=============================================*/
$(".tablas").on("click", ".btnEditarproveedor", function(){

	var idproveedor = $(this).attr("idproveedor");

	var datos = new FormData();
    datos.append("idproveedor", idproveedor);

    $.ajax({

      url:"ajax/proveedores.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){
      
      	   $("#idproveedor").val(respuesta["id"]);
	       $("#editarproveedor").val(respuesta["nombre"]);
         $("#editarregistro").val(respuesta["registro"]);
          $("#editarwhatsapp").val(respuesta["whatsapp"]);
           $("#editarinstagram").val(respuesta["instagram"]);
         
         
         
	
	       $("#editarEmail").val(respuesta["email"]);
	       $("#editarTelefono").val(respuesta["telefono"]);
         $("#editarTelefono2").val(respuesta["telefono2"]);
         $("#editarTelefono3").val(respuesta["telefono3"]);
	       $("#editarDireccion").val(respuesta["direccion"]);
   
	  }

  	})

})

/*=============================================
ELIMINAR proveedor
=============================================*/
$(".tablas").on("click", ".btnEliminarproveedor", function(){

	var idproveedor = $(this).attr("idproveedor");
	
	swal({
        title: '¿Está seguro de borrar el proveedor?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar proveedor!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=proveedores&idproveedor="+idproveedor;
        }

  })

})