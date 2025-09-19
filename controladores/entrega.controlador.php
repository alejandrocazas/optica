<?php

class ControladorEntrega
{

    /*=============================================
	CREAR Entrega
	=============================================*/

    static public function ctrCrearEntrega()
    {
		

        if (isset($_POST["enid_pedido"])) {

			if ($_POST["entipo_pago"] == 'EFECTIVO'){
				
				$datos_forma_pago = array(
				
					"id_pedido" => $_POST["enid_pedido"],
					"formapago" => $_POST["entipo_pago"],
					"monto" => $_POST["entPENDIENTE"],
					"codigopago" => NULL,
				);
			} elseif ($_POST["entipo_pago"] == 'TRANSFERENCIA'){
				$datos_forma_pago = array(
				
					"id_pedido" => $_POST["enid_pedido"],
					"formapago" => $_POST["entipo_pago"],
					"monto" => $_POST["entPENDIENTE"],
					"codigopago" => $_POST["entCOD_TRANS"],
				);
			} elseif ($_POST["entipo_pago"] == 'TARJETA'){
				$datos_forma_pago = array(
				
					"id_pedido" => $_POST["enid_pedido"],
					"formapago" => $_POST["entipo_pago"],
					"monto" => $_POST["entPENDIENTE"],
					"codigopago" => $_POST["entCODIGO_TARJETA"]
				);
			}

			ModeloEntrega::mdlActualizarEntrega('ventas', 'remitente', '1', 'id', $_POST["enid_pedido"]);
			ModeloEntrega::mdlActualizarEntrega('ventas', 'pendiente', '0', 'id', $_POST["enid_pedido"]);
			ModeloEntrega::mdlActualizarEntrega('ventas', 'retiro', $_POST["entPENDIENTE"], 'id', $_POST["enid_pedido"]);
			ModeloEntrega::mdlActualizarEntrega('ventas', 'abono', '0', 'id', $_POST["enid_pedido"]);
			ModeloEntrega::mdlActualizarEntrega('ventas', 'totalfinalreporte', '0', 'id', $_POST["enid_pedido"]);
			ModeloEntrega::mdlActualizarEntrega('ventas', 'estado', 'PAGADO', 'id', $_POST["enid_pedido"]);
			ModeloEntrega::mdlActualizarEntrega('ventas', 'estado_bulto', 'ENTREGADO', 'id', $_POST["enid_pedido"]);
			
			$tabla = "formapago";

            $respuesta = ModeloEntrega::mdlIngresarEntrega($tabla, $datos_forma_pago);

            if ($respuesta == "ok") {

                echo '<script>


					swal({
						  type: "success",
						  title: "El pedido ha sido entregado perfectamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {
		
									window.location = "ventas";
		
									}
								})
		
					</script>';
            } else {

                echo '<script>
		
					swal({
						  type: "error",
						  title: "¡El pedido no podrá ser entregado!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {
		
							window.location = "ventas";
		
							}
						})
		
				  </script>';
            }
        }
    }

    /*=============================================
	MOSTRAR Entrega
	=============================================*/
    static public function ctrMostrarEntrega($item, $valor)
    {

        $tabla = "ventas";

        $respuesta = ModeloEntrega::mdlMostrarEntrega($tabla, $item, $valor);

        return $respuesta;
    }


}