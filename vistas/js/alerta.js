
 /*=============================================
 ACTIVAR ALERTA
 =============================================*/ 
   function myFunction() {

 	var estadoAlerta = $(this).attr("estadoAlerta");

    var estadoAlertados = $(this).attr("estadoAlertados");

 	var datos = new FormData();

   	datos.append("activarAlerta", estadoAlerta);

	datos.append("activarAlertados", estadoAlertados);

   	$.ajax({

       url:"ajax/alerta.ajax.php",
       method: "POST",
       data: datos,
       cache: false,
       contentType: false,
       processData: false,
       success: function(data){
		$("#notification-count").remove();                  
		$("#notification-latest").show();$("#notification-latest").html(data);
	  },
	  error: function(){}           
	});
  }
							
  $(document).ready(function() {
	$('body').click(function(e){
	  if ( e.target.id != 'notification-icon'){
		$("#notification-latest").hide();
	  }
	});
  });