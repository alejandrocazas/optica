<?php

class Controladorconfiguraciones{

	

	/*=============================================
	REGISTRO DE configuracion
	=============================================*/

	static public function ctrCrearconfiguracion(){

		if(isset($_POST["nuevoconfiguracion"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ,-_. ]+$/', $_POST["nuevoNombre"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ,-_#. ]+$/', $_POST["nuevadireccion"]) &&

			   preg_match('/^[a-zA-Z0-9,-_ ]+$/', $_POST["nuevoconfiguracion"])){

			   	/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = "";

				if(isset($_FILES["nuevaFoto"]["tmp_name"]) && !empty($_FILES["nuevaFoto"]["tmp_name"])){
                    list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);
                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /* Creacion del directorio para guardar imagen*/

                    $directorio = "vistas/img/configuraciones/".$_POST["nuevoconfiguracion"];
                    mkdir($directorio, 0755);

                    /* Guardar imagen en el directorio*/

                    if($_FILES["nuevaFoto"]["type"] == "image/jpeg"){                   
                        $aleatorio = mt_rand(100,999);
                        $ruta = "vistas/img/configuraciones/".$_POST["nuevoconfiguracion"]."/".$aleatorio.".jpg";
                        $origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);                    
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);

                    }

                    /* Guardar imagen */
                    if($_FILES["nuevaFoto"]["type"] == "image/png"){
                        $aleatorio = mt_rand(100,999);
                        $ruta = "vistas/img/configuraciones/".$_POST["nuevoconfiguracion"]."/".$aleatorio.".png";
                        $origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);                     
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);
                    }

                }

				$tabla = "configuraciones";

		

				$datos = array("nombre" => mb_strtoupper($_POST["nuevoNombre"]),
								"direccion" => mb_strtoupper($_POST["nuevadireccion"]),
									"direccion2" => mb_strtoupper($_POST["nuevadireccion2"]),
					           "configuracion" =>  mb_strtoupper($_POST["nuevoconfiguracion"]),
					      
					           "telefono" => $_POST["nuevotelefono"],
					             "moneda" => $_POST["nuevomoneda"],
					             "email" =>  mb_strtoupper($_POST["nuevoemail"]),
					        
					           "foto"=>$ruta);

				$respuesta = Modeloconfiguraciones::mdlIngresarconfiguracion($tabla, $datos);
			
				if($respuesta == "ok"){

					
					echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "success",
      title: "La configuración ha sido guardada correctamente",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "configuraciones"; }
    });
  });
</script>';


				}	


			}else{

				
				echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "error",
      title: "¡La configuración no puede ir vacío o llevar caracteres especiales!,
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "configuraciones"; }
    });
  });
</script>';

			}


		}


	}

	/*=============================================
	MOSTRAR configuracion
	=============================================*/

	static public function ctrMostrarconfiguraciones($item, $valor){

		$tabla = "configuraciones";

		$respuesta = Modeloconfiguraciones::MdlMostrarconfiguraciones($tabla, $item, $valor);

		return $respuesta;
	}

	/*=============================================
	EDITAR configuracion
	=============================================*/

	static public function ctrEditarconfiguracion(){

		if(isset($_POST["editarconfiguracion"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ,-_#. ]+$/', $_POST["editarNombre"])){

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = $_POST["fotoActual"];

				if(isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])){

					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL configuracion
					=============================================*/

					$directorio = "vistas/img/configuraciones/".$_POST["editarconfiguracion"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if(!empty($_POST["fotoActual"])){

						unlink($_POST["fotoActual"]);

					}else{

						mkdir($directorio, 0755);

					}	

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($_FILES["editarFoto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/configuraciones/".$_POST["editarconfiguracion"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if($_FILES["editarFoto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/configuraciones/".$_POST["editarconfiguracion"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "configuraciones";

			

				$datos = array("nombre" => mb_strtoupper($_POST["editarNombre"]),
					"direccion" => mb_strtoupper($_POST["editardireccion"]),
						"direccion2" => mb_strtoupper($_POST["editardireccion2"]),
							   "configuracion" =>  mb_strtoupper($_POST["editarconfiguracion"]),
							    "telefono" => $_POST["editartelefono"],
							     "moneda" => $_POST["editarmoneda"],
					            "email" =>  mb_strtoupper($_POST["editaremail"]),
				
							
							   "foto" => $ruta);

				$respuesta = Modeloconfiguraciones::mdlEditarconfiguracion($tabla, $datos);

				if($respuesta == "ok"){

					echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "success",
      title: "La configuración ha sido editada correctamente",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "configuraciones"; }
    });
  });
</script>';

				}


			}else{

				echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "error",
      title: "¡La configuración no puede ir vacío o llevar caracteres especiales!,
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "configuraciones"; }
    });
  });
</script>';


			}

		}

	}

	/*=============================================
	BORRAR configuracion
	=============================================*/

	static public function ctrBorrarconfiguracion(){

		if(isset($_GET["idconfiguracion"])){

			$tabla ="configuraciones";
			$datos = $_GET["idconfiguracion"];

			if($_GET["fotoconfiguracion"] != ""){

				unlink($_GET["fotoconfiguracion"]);
				rmdir('vistas/img/configuraciones/'.$_GET["configuracion"]);

			}

			$respuesta = Modeloconfiguraciones::mdlBorrarconfiguracion($tabla, $datos);

			if($respuesta == "ok"){

				echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "success",
      title: "La configuración ha sido borrada correctamente",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "configuraciones"; }
    });
  });
</script>';

			}		

		}

	}


}
	


