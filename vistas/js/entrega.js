/*=============================================
AGREGAR ATENCIONES
=============================================*/
$("#btnAgregarEntrega").click(function () {
	$(".modal-footer").show();
});

/*=============================================
FUNCION CARGAR DATOS PEDIDO PACIENTE
=============================================*/
$("#traer_orden").change(function () {

	var id_entrega = $("#traer_orden :selected").val();
  
	var datosPedido = new FormData();
  
	datosPedido.append("id_entrega", id_entrega);
  
	$.ajax({
  
	  url: "ajax/entrega.ajax.php",
	  method: "POST",
	  data: datosPedido,
	  cache: false,
	  contentType: false,
	  processData: false,
	  dataType: "json",
	  success: function (respuesta) {
  

		$("#entPENDIENTE").val(respuesta["pendiente"]);

		$("#abono").val(respuesta["abono"]);
	
		$("#endeCli").val(respuesta["id"]);

  
		if (respuesta["pendiente"] == 0){
			
			document.getElementById("CUANTO_PAGA").style.display = "none";
			document.getElementById("VUELTO").style.display = "none";
			document.getElementById("tipo_pago").style.display = "none";
			alert('SIN DEUDA PENDIENTE');

		} else {

			document.getElementById("tipo_pago").style.display = "inline-block";
			document.getElementById("CUANTO_PAGA").style.display = "inline-block";
			document.getElementById("VUELTO").style.display = "inline-block";
		}
	  }
  
	})
  
});