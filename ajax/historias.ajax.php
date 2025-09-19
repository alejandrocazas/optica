<?php

require_once "../controladores/historias.controlador.php";
require_once "../modelos/historias.modelo.php";

class Ajaxhistorias{

	/*=============================================
	EDITAR historia
	=============================================*/	

	public $idhistoria;

	public function ajaxEditarhistoria(){

		$item = "id";
		$valor = $this->idhistoria;

		$respuesta = Controladorhistorias::ctrMostrarhistorias($item, $valor);

		echo json_encode($respuesta);

	}

	

	/*=============================================
	VALIDAR NO REPETIR historia
	=============================================*/	

	public $validarhistoria;

	public function ajaxValidarhistoria(){

		$item = "historia";
		$valor = $this->validarhistoria;

		$respuesta = Controladorhistorias::ctrMostrarhistorias($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR historia
=============================================*/
if(isset($_POST["idhistoria"])){

	$editar = new Ajaxhistorias();
	$editar -> idhistoria = $_POST["idhistoria"];
	$editar -> ajaxEditarhistoria();

}



/*=============================================
VALIDAR NO REPETIR historia
=============================================*/

if(isset( $_POST["validarhistoria"])){

	$valhistoria = new Ajaxhistorias();
	$valhistoria -> validarhistoria = $_POST["validarhistoria"];
	$valhistoria -> ajaxValidarhistoria();

}