

/*=============================================
SUBIENDO LA FOTO DEL configuracion
=============================================*/
$(".nuevaFoto").change(function(){

	var imagen = this.files[0];
	
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/

  	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

  		$(".nuevaFoto").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen debe estar en formato JPG o PNG!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else if(imagen["size"] > 2000000){

  		$(".nuevaFoto").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen no debe pesar más de 2MB!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else{

  		var datosImagen = new FileReader;
  		datosImagen.readAsDataURL(imagen);

  		$(datosImagen).on("load", function(event){

  			var rutaImagen = event.target.result;

  			$(".previsualizar").attr("src", rutaImagen);

  		})

  	}
})

/*=============================================
EDITAR configuracion
=============================================*/
$(".tablas").on("click", ".btnEditarconfiguracion", function(){

	var idconfiguracion = $(this).attr("idconfiguracion");
	
	var datos = new FormData();
	datos.append("idconfiguracion", idconfiguracion);

	$.ajax({

		url:"ajax/configuraciones.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editardireccion").val(respuesta["direccion"]);
					$("#editardireccion2").val(respuesta["direccion2"]);
			$("#editarconfiguracion").val(respuesta["configuracion"]);

			$("#editartelefono").val(respuesta["telefono"]);
					$("#editaremail").val(respuesta["email"]);
						$("#editarmoneda").val(respuesta["moneda"]);
			$("#fotoActual").val(respuesta["foto"]);



			if(respuesta["foto"] != ""){

				$(".previsualizarEditar").attr("src", respuesta["foto"]);

			}else{

				$(".previsualizarEditar").attr("src", "vistas/img/configuraciones/default/anonymous.png");

			}

		}

	});

})

/*=============================================
ACTIVAR configuracion
=============================================*/
$(".tablas").on("click", ".btnActivar", function(){

	var idconfiguracion = $(this).attr("idconfiguracion");
	var estadoconfiguracion = $(this).attr("estadoconfiguracion");

	var datos = new FormData();
 	datos.append("activarId", idconfiguracion);
  	datos.append("activarconfiguracion", estadoconfiguracion);

  	$.ajax({

	  url:"ajax/configuraciones.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

      		if(window.matchMedia("(max-width:767px)").matches){

	      		 swal({
			      title: "El configuracion ha sido actualizado",
			      type: "success",
			      confirmButtonText: "¡Cerrar!"
			    }).then(function(result) {
			        if (result.value) {

			        	window.location = "configuraciones";

			        }


				});

	      	}

      }

  	})

  	if(estadoconfiguracion == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoconfiguracion',1);

  	}else{

  		$(this).addClass('btn-success');
  		$(this).removeClass('btn-danger');
  		$(this).html('Activado');
  		$(this).attr('estadoconfiguracion',0);

  	}

})

/*=============================================
REVISAR SI EL configuracion YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoconfiguracion").change(function(){

	$(".alert").remove();

	var configuracion = $(this).val();

	var datos = new FormData();
	datos.append("validarconfiguracion", configuracion);

	 $.ajax({
	    url:"ajax/configuraciones.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoconfiguracion").parent().after('<div class="alert alert-warning">Este configuracion ya existe en la base de datos</div>');

	    		$("#nuevoconfiguracion").val("");

	    	}

	    }

	})
})

/*=============================================
ELIMINAR configuracion
=============================================*/
$(".tablas").on("click", ".btnEliminarconfiguracion", function(){

  var idconfiguracion = $(this).attr("idconfiguracion");
  var fotoconfiguracion = $(this).attr("fotoconfiguracion");
  var configuracion = $(this).attr("configuracion");

  swal({
    title: '¿Está seguro de borrar el configuracion?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar configuracion!'
  }).then(function(result){

    if(result.value){

      window.location = "index.php?ruta=configuraciones&idconfiguracion="+idconfiguracion+"&configuracion="+configuracion+"&fotoconfiguracion="+fotoconfiguracion;

    }

  })

})




