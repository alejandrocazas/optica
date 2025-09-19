<?php

require_once "conexion.php";

class ModeloAlerta{

	/*=============================================
	REGISTRO DE ALERTA
	=============================================*/

	static public function mdlIngresarAlerta($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(mensaje, autor) VALUES (:mensaje, :autor)");

		$stmt->bindParam(":mensaje", $datos["mensaje"], PDO::PARAM_STR);
		$stmt->bindParam(":autor", $datos["autor"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;

	}

    /*=============================================
	ACTUALIZAR ALERTA
	=============================================*/

	static public function mdlActualizarAlerta($tabla, $item1, $valor1, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = 1 WHERE $item1 = 0");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

	}

	/*=============================================
	MOSTRAR ALERTA
	=============================================*/

	static public function mdlMostrarAlerta($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM datos ORDER BY id DESC LIMIT 3 ");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		

		$stmt -> close();

		$stmt = null;

	}
}

class ModeloCount{

	/*=============================================
	MOSTRAR CONTEO ALERTA
	=============================================*/

	static public function MdlMostrarCount($tablacount, $estado, $valorestado){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tablacount WHERE estado = 0");

		$stmt -> bindParam(":".$estado, $valorestado, PDO::PARAM_STR);

		$stmt -> execute();

	return $stmt -> fetchAll();

    }

}