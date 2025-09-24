<?php

class Controladorproveedores{

	/*=============================================
	CREAR proveedores
	=============================================*/

	static public function ctrCrearproveedor(){

		if(isset($_POST["nuevoproveedor"])){

			if(preg_match('/^[ &.a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoproveedor"]) &&

			   
			
			   preg_match('/^[-a-zA-Z0-9]+$/', $_POST["nuevoregistro"])){

			   	$tabla = "proveedores";

			   	$datos = array("nombre"=>$_POST["nuevoproveedor"],
					     
					           "email"=>$_POST["nuevoEmail"],
					           "registro"=>$_POST["nuevoregistro"],
					           "instagram"=>$_POST["nuevoinstagram"],
					           "whatsapp"=>$_POST["nuevowhatsapp"],
					           "telefono"=>$_POST["nuevoTelefono"],
					           "telefono2"=>$_POST["nuevoTelefono2"],
					           "telefono3"=>$_POST["nuevoTelefono3"],
					           "direccion"=>$_POST["nuevaDireccion"]);

			   	$respuesta = Modeloproveedores::mdlIngresarproveedor($tabla, $datos);

			   	if($respuesta == "ok"){

					
					echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "success",
      title: "El proveedor ha sido guardado correctamente",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "proveedores"; }
    });
  });
</script>';

				}

			}else{

				echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "error",
      title: "¡El proveedor no puede ir vacío o llevar caracteres especiales!,
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "proveedores"; }
    });
  });
</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR proveedores
	=============================================*/

	static public function ctrMostrarproveedores($item, $valor){

		$tabla = "proveedores";

		$respuesta = Modeloproveedores::mdlMostrarproveedores($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	EDITAR proveedor
	=============================================*/

	static public function ctrEditarproveedor(){

		//ACA SON LAS VALIDACIONES AL IGUAL QUE LOS OTROS MODULOS///
		//ACA SON LAS VALIDACIONES AL IGUAL QUE LOS OTROS MODULOS///
		//ACA SON LAS VALIDACIONES AL IGUAL QUE LOS OTROS MODULOS///
		//ACA SON LAS VALIDACIONES AL IGUAL QUE LOS OTROS MODULOS///
		//ACA SON LAS VALIDACIONES AL IGUAL QUE LOS OTROS MODULOS///

		if(isset($_POST["editarproveedor"])){

			if(preg_match('/^[ &.a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarproveedor"]) &&
			   

			   preg_match('/^[-a-zA-Z0-9]+$/', $_POST["editarregistro"])){

			   	$tabla = "proveedores";

			   	$datos = array("id"=>$_POST["idproveedor"],
			   				   "nombre"=>$_POST["editarproveedor"],
			   				   "registro"=>$_POST["editarregistro"],
			   				   "whatsapp"=>$_POST["editarwhatsapp"],
			   				   "instagram"=>$_POST["editarinstagram"],
					   
					           "email"=>$_POST["editarEmail"],
					           "telefono"=>$_POST["editarTelefono"],
					           "telefono2"=>$_POST["editarTelefono2"],
					           "telefono3"=>$_POST["editarTelefono3"],
					           "direccion"=>$_POST["editarDireccion"]);

			   	$respuesta = Modeloproveedores::mdlEditarproveedor($tabla, $datos);

			   	if($respuesta == "ok"){

					echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "success",
      title: "El proveedor ha sido editado correctamente",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "proveedores"; }
    });
  });
</script>';
					

				}

			}else{

				echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "error",
      title: "¡El proveedor no puede ir vacío o llevar caracteres especiales!,
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "proveedores"; }
    });
  });
</script>';



			}

		}

	}

	/*=============================================
	ELIMINAR proveedor
	=============================================*/

	static public function ctrEliminarproveedor(){

		if(isset($_GET["idproveedor"])){

			$tabla ="proveedores";
			$datos = $_GET["idproveedor"];

			$respuesta = Modeloproveedores::mdlEliminarproveedor($tabla, $datos);

			if($respuesta == "ok"){

				echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "success",
      title: "El proveedor ha sido borrado correctamente",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "proveedores"; }
    });
  });
</script>';
			}		

		}

	}

}

