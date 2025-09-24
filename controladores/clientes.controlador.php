<?php

class ControladorClientes{

	/*=============================================
	CREAR CLIENTES
	=============================================*/

	static public function ctrCrearCliente(){

		if(isset($_POST["nuevoCliente"])){

			if(preg_match('/^[.,a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCliente"])&&
			   preg_match('/^[+()\-0-9 ]+$/', $_POST["nuevoTelefono"])){

			   	$tabla = "clientes";

			   	$datos = array("nombre"=>mb_strtoupper($_POST["nuevoCliente"]),
					           "documento"=>$_POST["nuevoDocumentoId"],
					           "email"=>mb_strtoupper($_POST["nuevoEmail"]),
					           "apellido"=>$_POST["nuevoapellido"],
					           "telefono"=>$_POST["nuevoTelefono"],
					           "direccion"=>$_POST["nuevaDireccion"]);

			   	$respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);

			   	if($respuesta == "ok"){

					echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "success",
      title: "El cliente ha sido creado correctamente",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "clientes"; }
    });
  });
</script>';

				}

			}else{

				
				echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "error",
      title: "¡El cliente no puede ir vacío o llevar caracteres especiales!,
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "clientes"; }
    });
  });
</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/

	static public function ctrMostrarClientes($item, $valor){

		$tabla = "clientes";

		$respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	EDITAR CLIENTE
	=============================================*/

	static public function ctrEditarCliente(){

		if(isset($_POST["editarCliente"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCliente"])){

			   	$tabla = "clientes";

			   	$datos = array("id"=>$_POST["idCliente"],
			   				   "nombre"=> mb_strtoupper($_POST["editarCliente"]),
					           "documento"=> $_POST["editarDocumentoId"],
					           "email"=> $_POST["editarEmail"],
					           "apellido"=> $_POST["editarapellido"],
					           "telefono"=> $_POST["editarTelefono"],
					           "direccion"=> $_POST["editarDireccion"]);

			   	$respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);

			   	if($respuesta == "ok"){

					echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "success",
      title: "El cliente ha sido editado correctamente",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "clientes"; }
    });
  });
</script>';

				}

			}else{

				echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "error",
      title: "¡El cliente no puede ir vacío o llevar caracteres especiales!,
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "clientes"; }
    });
  });
</script>';



			}

		}

	}

	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/

	static public function ctrEliminarCliente(){

		if(isset($_GET["idCliente"])){

			$tabla ="clientes";
			$datos = $_GET["idCliente"];

			$respuesta = ModeloClientes::mdlEliminarCliente($tabla, $datos);

			if($respuesta == "ok"){

				
				echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "success",
      title: "El cliente ha sido borrado correctamente",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "clientes"; }
    });
  });
</script>';

			}		

		}

	}

}

