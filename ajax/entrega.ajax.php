<?php

require_once "../controladores/entrega.controlador.php";
require_once "../modelos/entrega.modelo.php";

class ajaxEntrega{

	/*=============================================
	EDITAR ENTREGA
	=============================================*/	

	public $id_entrega;

	public function ajaxEditarEntrega(){

		$item = "id";
		$valor = $this->id_entrega;

		$respuesta = ControladorEntrega::ctrMostrarEntrega($item, $valor);

		echo json_encode($respuesta);


	}

}

	

/*=============================================
EDITAR ENTREGA
=============================================*/	

if(isset($_POST["id_entrega"])){

	$entrega = new ajaxEntrega();
	$entrega -> id_entrega = $_POST["id_entrega"];
	$entrega -> ajaxEditarEntrega();

}

?>