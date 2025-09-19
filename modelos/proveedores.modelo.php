<?php

require_once "conexion.php";

class Modeloproveedores{

	/*=============================================
	CREAR proveedor
	=============================================*/

	static public function mdlIngresarproveedor($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, email, telefono, telefono2, telefono3, direccion, registro, instagram, whatsapp) VALUES (:nombre, :email, :telefono, :telefono2, :telefono3, :direccion, :registro, :instagram, :whatsapp )");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":registro", $datos["registro"], PDO::PARAM_STR);
		$stmt->bindParam(":whatsapp", $datos["whatsapp"], PDO::PARAM_STR);
		$stmt->bindParam(":instagram", $datos["instagram"], PDO::PARAM_STR);
		
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono2", $datos["telefono2"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono3", $datos["telefono3"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR proveedores
	=============================================*/

	static public function mdlMostrarproveedores($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR proveedor
	=============================================*/

	static public function mdlEditarproveedor($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre,  email = :email, telefono = :telefono, telefono2 = :telefono2, telefono3 = :telefono3, direccion = :direccion,  registro = :registro, whatsapp = :whatsapp,  instagram = :instagram  WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":registro", $datos["registro"], PDO::PARAM_STR);
		$stmt->bindParam(":whatsapp", $datos["whatsapp"], PDO::PARAM_STR);
		$stmt->bindParam(":instagram", $datos["instagram"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono2", $datos["telefono2"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono3", $datos["telefono3"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
	

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ELIMINAR proveedor
	=============================================*/

	static public function mdlEliminarproveedor($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR proveedor
	=============================================*/

	static public function mdlActualizarproveedor($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

}