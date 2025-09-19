/*=============================================
EDITAR historia
=============================================*/
$(".tablas").on("click", ".btnEditarhistoria", function() {

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
      $("#nuevadireccion").val(respuesta["direccion"]);
      $("#editartelefono").val(respuesta["telefono"]);

      $("#editaranamnesis").val(respuesta["anamnesis"]);
      $("#editarantecedentes").val(respuesta["antecedentes"]);

      $("#editarODsc").val(respuesta["odsc"]);
      $("#editarODcc").val(respuesta["odcc"]);
      $("#editarOIsc").val(respuesta["oisc"]);
      $("#editarOIcc").val(respuesta["oicc"]);
      $("#editarnuevacc").val(respuesta["cc"]);

      $("#editaresferaoilj").val(respuesta["esferaoilj"]);
      $("#editarcilindrooilj").val(respuesta["cilindrooilj"]);
      $("#editarejeoilj").val(respuesta["ejeoilj"]);

      $("#editaresferaodlj").val(respuesta["esferaodlj"]);
      $("#editarcilindroodlj").val(respuesta["cilindroodlj"]);
      $("#editarejeodlj").val(respuesta["ejeodlj"]);

      $("#editaresferaoicc").val(respuesta["esferaoicc"]);
      $("#editarcilindrooicc").val(respuesta["cilindrooicc"]);
      $("#editarejeoicc").val(respuesta["ejeoicc"]);

      $("#editaresferaodcc").val(respuesta["esferaodcc"]);
      $("#editarcilindroodcc").val(respuesta["cilindroodcc"]);
      $("#editarejeodcc").val(respuesta["ejeodcc"]);

      $("#editarnuevaDP").val(respuesta["dp"]);
      $("#editarnuevaADD").val(respuesta["adicion"]);
      $("#editardiagnostico").val(respuesta["diagnostico"]);

      $("#editarnuevatonoOD").val(respuesta["tonood"]);
      $("#editarnuevatonoOI").val(respuesta["tonooi"]);
      $("#editarnuevatonohora").val(respuesta["tonohora"]);

      $("#editarnuevaobservaciones").val(respuesta["observaciones"]);      

    }

  });

})

/*=============================================
FUNCION CARGAR DATOS PACIENTE EN TECNÓLOGO
=============================================*/
$("#traer_cliente").change(function () {

	var idCliente = $("#traer_cliente :selected").val();
  
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
  

		$("#nuevoNombre").val(respuesta["nombre"]);

    $("#nuevodocumentoid").val(respuesta["documento"]);

		$("#nuevoapellido").val(respuesta["apellido"]);
	
		$("#nuevotelefono").val(respuesta["telefono"]);

    $("#nuevadireccion").val(respuesta["direccion"]);


	  }
  
	})
  
});

/*=============================================
FUNCION CARGAR DATOS PACIENTE EN VENTAS
=============================================*/
$("#traer_historia").change(function () {

	var idhistoria = $("#traer_historia :selected").val();
  
	var datosHistoria = new FormData();
  
	datosHistoria.append("idhistoria", idhistoria);
  
	$.ajax({
  
	  url: "ajax/historias.ajax.php",
	  method: "POST",
	  data: datosHistoria,
	  cache: false,
	  contentType: false,
	  processData: false,
	  dataType: "json",
	  success: function (respuesta) {
  

		$("#nuevoNombre").val(respuesta["nombre"]);

    $("#id_historia").val(respuesta["id"]);

    $("#rut").val(respuesta["documentoid"]);

		$("#nuevoapellido").val(respuesta["apellido"]);
	
		$("#nuevotelefono").val(respuesta["telefono"]);

    $("#nuevoanamnesis").val(respuesta["anamnesis"]);
    
    $("#nuevadireccion").val(respuesta["direccion"]);

    $("#nuevoantecedentes").val(respuesta["antecedentes"]);

    $("#nuevoODsc").val(respuesta["odsc"]);

    $("#nuevoODcc").val(respuesta["odcc"]);

    $("#nuevoOIsc").val(respuesta["oisc"]);

    $("#nuevoOIcc").val(respuesta["oicc"]);

    $("#nuevacc").val(respuesta["cc"]);

    $("#nuevoesferaodlj").val(respuesta["esferaoilj"]);

    $("#nuevocilindroodlj").val(respuesta["cilindrooilj"]);

    $("#nuevoejeodlj").val(respuesta["nuevoejeodlj"]);

    $("#nuevoesferaoilj").val(respuesta["esferaoilj"]);

    $("#nuevocilindrooilj").val(respuesta["cilindrooilj"]);

    $("#nuevoejeoilj").val(respuesta["ejeoilj"]);

    $("#nuevoesferaodcc").val(respuesta["esferaodcc"]);

    $("#nuevocilindroodcc").val(respuesta["cilindroodcc"]);

    $("#nuevoejeodcc").val(respuesta["ejeodcc"]);

    $("#nuevoesferaoicc").val(respuesta["esferaoicc"]);

    $("#nuevocilindrooicc").val(respuesta["cilindrooicc"]);

    $("#nuevoejeoicc").val(respuesta["ejeoicc"]);

    $("#nuevaADD").val(respuesta["adicion"]);

    $("#nuevaDP").val(respuesta["dp"]);

    $("#nuevaPatologia").val(respuesta["diagnostico"]);

    $("#nuevatonoOD").val(respuesta["tonood"]);

    $("#nuevatonoOI").val(respuesta["tonooi"]);

    $("#nuevatonohora").val(respuesta["tonohora"]);

    $("#nuevaobservaciones").val(respuesta["observaciones"]);

    $("#nuevafecha").val(respuesta["fecha"]);


	  }
  
	})
  
});




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




