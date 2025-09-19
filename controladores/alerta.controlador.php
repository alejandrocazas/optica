<?php

class ControladorAlerta {

	/*=============================================
	REGISTRO DE ALERTAS
	=============================================*/

	static public function ctrCrearAlerta(){

		if(isset($_POST["clienteAlerta"])){

			if($_POST["clienteAlerta"]){
				
				$datos = array(
					
				"autor" =>  $_POST["clienteAlerta"],
				"mensaje" => mb_strtoupper($_POST["observacionAlerta"]));

                $tabla = "datos";

				$respuesta = ModeloAlerta::mdlIngresarAlerta($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>

					swal({

						type: "success",
						title: "¡Espacio Oftalmológico Alertado!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "crear-venta";

						}

					});
				

					</script>';

				}

				}else{

				echo '<script>

					swal({

						type: "error",
						title: "¡SELECCIONA AL CLIENTE!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
						
							window.location = "crear-venta";

						}

					});
				

				</script>';
			}
	
		}

	}



	/*=============================================
	MOSTRAR ALERTAS
	=============================================*/

	static public function ctrMostrarAlerta($item, $valor){

		$tabla = "datos";

		$respuesta = ModeloAlerta::MdlMostrarAlerta($tabla, $item, $valor);

		return $respuesta;
	}

}

class ControladorCount {

	/*=============================================
	MOSTRAR ALERTAS
	=============================================*/

	static public function ctrMostrarCount($estado, $valorestado){

		$tablacount = "datos";

		$respuesta = ModeloCount::MdlMostrarCount($tablacount, $estado, $valorestado);

		return $respuesta;
	}

}

	
