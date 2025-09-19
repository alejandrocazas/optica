<?php

require_once "../controladores/configuraciones.controlador.php";
require_once "../modelos/configuraciones.modelo.php";

class Ajaxconfiguraciones{

	/*=============================================
	EDITAR configuracion
	=============================================*/	

	public $idconfiguracion;

	public function ajaxEditarconfiguracion(){

		$item = "id";
		$valor = $this->idconfiguracion;

		$respuesta = Controladorconfiguraciones::ctrMostrarconfiguraciones($item, $valor);

		echo json_encode($respuesta);

	}



	/*=============================================
	VALIDAR NO REPETIR configuracion
	=============================================*/	

	public $validarconfiguracion;

	public function ajaxValidarconfiguracion(){

		$item = "configuracion";
		$valor = $this->validarconfiguracion;

		$respuesta = Controladorconfiguraciones::ctrMostrarconfiguraciones($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR configuracion
=============================================*/
if(isset($_POST["idconfiguracion"])){

	$editar = new Ajaxconfiguraciones();
	$editar -> idconfiguracion = $_POST["idconfiguracion"];
	$editar -> ajaxEditarconfiguracion();

}


/*=============================================
VALIDAR NO REPETIR configuracion
=============================================*/

if(isset( $_POST["validarconfiguracion"])){

	$valconfiguracion = new Ajaxconfiguraciones();
	$valconfiguracion -> validarconfiguracion = $_POST["validarconfiguracion"];
	$valconfiguracion -> ajaxValidarconfiguracion();

}