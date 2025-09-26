<?php

class Controladorhistorias{
	
	

   /* Última historia por cliente */
  static public function ctrUltimaHistoriaPorCliente($idCliente){
    $tabla = "historias";
    return ModeloHistorias::mdlUltimaHistoriaPorCliente($tabla, (int)$idCliente);
  }

	/*=============================================
	REGISTRO DE historia
	=============================================*/

	static public function ctrCrearhistoria(){

		if(isset($_POST["nuevoNombre"])){

			if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
				preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoapellido"])){

				$diag = $_POST['diagnostico'];
				$Diagnostico = implode(', ',$diag);

				$tabla = "historias";

				$datos = array("nombre" => mb_strtoupper( $_POST["nuevoNombre"]),
				"apellido" => mb_strtoupper ( $_POST["nuevoapellido"]),
				"documentoid" => mb_strtoupper($_POST["nuevodocumentoid"]),
				"direccion" => $_POST["nuevadireccion"],
				"telefono" => $_POST["nuevotelefono"],
				"anamnesis" => $_POST["nuevoanamnesis"],
				"antecedentes" => $_POST["nuevoantecedentes"],
				"edad" => $_POST["nuevaedad"],
				"odsc" => $_POST["nuevoODsc"],
				"odcc" => $_POST["nuevoODcc"],
				"oisc" => $_POST["nuevoOIsc"],
				"oicc" => $_POST["nuevoOIcc"],
				"cc" => $_POST["nuevacc"],
				"esferaodlj" => $_POST["nuevoesferaodlj"],
				"cilindroodlj" => $_POST["nuevocilindroodlj"],
				"ejeodlj" => $_POST["nuevoejeodlj"],
				"esferaoilj" => $_POST["nuevoesferaoilj"],
				"cilindrooilj" => $_POST["nuevocilindrooilj"],
				"ejeoilj" => $_POST["nuevoejeoilj"],
				"esferaodcc" => $_POST["nuevoesferaodcc"],
				"cilindroodcc" => $_POST["nuevocilindroodcc"],
				"ejeodcc" => $_POST["nuevoejeodcc"],
				"esferaoicc" => $_POST["nuevoesferaoicc"],
				"cilindrooicc" => $_POST["nuevocilindrooicc"],
				"ejeoicc" => $_POST["nuevoejeoicc"],
				"dp" => $_POST["nuevaDP"],
				"adicion" => $_POST["nuevaADD"],
				"diagnostico" => $Diagnostico,
				"tonood" => $_POST["nuevatonoOD"],
				"tonooi" => $_POST["nuevatonoOI"],
				"tonohora" => $_POST["nuevatonohora"],
				"observaciones" => $_POST["nuevaobservaciones"]);



				$respuesta = Modelohistorias::mdlIngresarhistoria($tabla, $datos);
			
				if($respuesta == "ok"){

					echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "success",
      title: "La atención ha sido guardada correctamente",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "historias"; }
    });
  });
</script>';



				}	


			}else{

				echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "error",
      title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "historias"; }
    });
  });
</script>';

			}


		}


	}

	/*=============================================
	MOSTRAR historia
	=============================================*/

	/* Listar/mostrar */
  static public function ctrMostrarhistorias($item, $valor){
    $tabla = "historias";
    return ModeloHistorias::mdlMostrarHistorias($tabla, $item, $valor);
  }

	/*=============================================
	EDITAR historia
	=============================================*/

	static public function ctrEditarhistoria(){

		if(isset($_POST["editardocumentoid"])){

			if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
			preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarapellido"])){

				$diag = $_POST['editardiagnostico'];
				$Diagnostico = implode(', ',$diag);
					
				$tabla = "historias";

			
				$datos = array("nombre" => mb_strtoupper( $_POST["editarNombre"]),
				"apellido" => mb_strtoupper ( $_POST["editarapellido"]),
				"documentoid" => mb_strtoupper($_POST["editardocumentoid"]),
				"direccion" => $_POST["editardireccion"],
				"telefono" => $_POST["editartelefono"],
				"anamnesis" => $_POST["editaranamnesis"],
				"antecedentes" => $_POST["editarantecedentes"],
				"edad" => $_POST["editarnuevaedad"],
				"odsc" => $_POST["editarODsc"],
				"odcc" => $_POST["editarODcc"],
				"oisc" => $_POST["editarOIsc"],
				"oicc" => $_POST["editarOIcc"],
				"cc" => $_POST["editarnuevacc"],
				"esferaodlj" => $_POST["editaresferaodlj"],
				"cilindroodlj" => $_POST["editarcilindroodlj"],
				"ejeodlj" => $_POST["editarejeodlj"],
				"esferaoilj" => $_POST["editaresferaoilj"],
				"cilindrooilj" => $_POST["editarcilindrooilj"],
				"ejeoilj" => $_POST["editarejeoilj"],
				"esferaodcc" => $_POST["editaresferaodcc"],
				"cilindroodcc" => $_POST["editarcilindroodcc"],
				"ejeodcc" => $_POST["editarejeodcc"],
				"esferaoicc" => $_POST["editaresferaoicc"],
				"cilindrooicc" => $_POST["editarcilindrooicc"],
				"ejeoicc" => $_POST["editarejeoicc"],
				"dp" => $_POST["editarnuevaDP"],
				"adicion" => $_POST["editarnuevaADD"],
				"diagnostico" => $Diagnostico,
				"tonood" => $_POST["editarnuevatonoOD"],
				"tonooi" => $_POST["editarnuevatonoOI"],
				"tonohora" => $_POST["editarnuevatonohora"],
				"observaciones" => $_POST["editarnuevaobservaciones"]);

				$respuesta = Modelohistorias::mdlEditarhistoria($tabla, $datos);

				if($respuesta == "ok"){

					echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "success",
      title: "La historia ha sido editada correctamente",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "historias"; }
    });
  });
</script>';


				}


			}else{

				
				echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "error",
      title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "historias"; }
    });
  });
</script>';

			}

		}

	}

	/*=============================================
	BORRAR historia
	=============================================*/

	static public function ctrBorrarhistoria(){

		if(isset($_GET["idhistoria"])){

			$tabla ="historias";
			$datos = $_GET["idhistoria"];


			$respuesta = Modelohistorias::mdlBorrarhistoria($tabla, $datos);

			if($respuesta == "ok"){

				echo '<script>
  window.addEventListener("load", function () {
    swal({
      type: "success",
      title: "La historia ha sido borrada correctamente",
      showConfirmButton: true,
      confirmButtonText: "Cerrar"
    }).then(function(result){
      if (result.value) { window.location = "historias"; }
    });
  });
</script>';


			}		

		}

	}
// controladores/historias.controlador.php
static public function ctrMostrarUltimaHistoriaPorCliente($clienteId = null, $documento = null) {
  return Modelohistorias::mdlUltimaHistoriaPorCliente('historias', $clienteId, $documento);
}


}
	


