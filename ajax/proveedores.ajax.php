<?php

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";

class Ajaxproveedores{

	/*=============================================
	EDITAR proveedor
	=============================================*/	

	public $idproveedor;

	public function ajaxEditarproveedor(){

		$item = "id";
		$valor = $this->idproveedor;

		$respuesta = Controladorproveedores::ctrMostrarproveedores($item, $valor);

		echo json_encode($respuesta);


	}

}

/*=============================================
EDITAR proveedor
=============================================*/	

if(isset($_POST["idproveedor"])){

	$proveedor = new Ajaxproveedores();
	$proveedor -> idproveedor = $_POST["idproveedor"];
	$proveedor -> ajaxEditarproveedor();

}