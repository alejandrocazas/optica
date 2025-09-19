<?php

require_once "../controladores/alerta.controlador.php";
require_once "../modelos/alerta.modelo.php";


class AjaxAlerta{


	/*=============================================
	ZO CHORO ZO VIO -----> TIEMPO REAL MENSAJES
	=============================================*/	





	/*=============================================
	VALOR DE ALERTA
	=============================================*/	

	public $idAlerta;

	public function ajaxEditarAlerta(){

		$item = "id";
		$valor = $this->idAlerta;

		$respuesta = ControladorAlerta::ctrMostrarAlerta($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	ACTIVAR NOTIFICACION
	=============================================*/	

	public $activarAlerta;
	public $activarAlertados;


	public function ajaxActivarAlerta(){

		$tabla = "datos";

		$item1 = "estado";
		$valor1 = $this->activarAlerta;
		$valor2 = $this->activarAlertados;

		$respuesta = ModeloAlerta::mdlActualizarAlerta($tabla, $item1, $valor1, $valor2);

		echo json_encode($respuesta);


	}
}

	/*=============================================
	ACTIVAR ALERTA 
	=============================================*/	

	if(isset($_POST["activarAlerta"])){

		$activarAlerta = new AjaxAlerta();
		$activarAlerta -> activarAlerta = $_POST["activarAlerta"];
		$activarAlerta -> activarAlertados = $_POST["activarAlertados"];
		$activarAlerta -> ajaxActivarAlerta();

	}

	/*=============================================
	ALERTA ID
	=============================================*/	
	if(isset($_POST["idAlerta"])) {

		$alerta = new Ajaxalerta();
		$alerta -> idAlerta = $_POST["idAlerta"];
		$alerta -> ajaxEditarAlerta();

	}

class AjaxCount{

	/*=============================================
	VALOR COUNT
	=============================================*/	

	public $idCount;

	public function ajaxEditarCount(){

		$estado = "estado";
		$valorestado = $this->idCount;

		$respuesta = ControladorCount::ctrMostrarCount($estado, $valorestado);

		echo json_encode($respuesta);

	}
}


