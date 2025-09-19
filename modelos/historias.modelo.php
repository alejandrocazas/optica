<?php

require_once "conexion.php";

class Modelohistorias{

	/*=============================================
	MOSTRAR historias
	=============================================*/

	static public function mdlMostrarhistorias($tabla, $item, $valor){

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
	REGISTRO DE historia
	=============================================*/

	static public function mdlIngresarhistoria($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, apellido, documentoid, direccion, telefono, anamnesis, antecedentes, edad, odsc, odcc, oisc, oicc, cc, esferaoilj, cilindrooilj, ejeoilj, esferaodlj, cilindroodlj, ejeodlj, esferaoicc, cilindrooicc, ejeoicc, esferaodcc, cilindroodcc, ejeodcc, dp, adicion, diagnostico, tonood, tonooi, tonohora, observaciones) 

			VALUES (:nombre, :apellido, :documentoid, :direccion, :telefono, :anamnesis, :antecedentes, :edad, :odsc, :odcc, :oisc, :oicc, :cc, :esferaoilj, :cilindrooilj, :ejeoilj, :esferaodlj, :cilindroodlj, :ejeodlj, :esferaoicc, :cilindrooicc, :ejeoicc, :esferaodcc, :cilindroodcc, :ejeodcc, :dp, :adicion, :diagnostico, :tonood, :tonooi, :tonohora, :observaciones )");

				$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
				$stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
				$stmt->bindParam(":documentoid", $datos["documentoid"], PDO::PARAM_STR);
				$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
				$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
				$stmt->bindParam(":anamnesis", $datos["anamnesis"], PDO::PARAM_STR);
				$stmt->bindParam(":antecedentes", $datos["antecedentes"], PDO::PARAM_STR);
				$stmt->bindParam(":edad", $datos["edad"], PDO::PARAM_STR);
				$stmt->bindParam(":odsc", $datos["odsc"], PDO::PARAM_STR);
				$stmt->bindParam(":odcc", $datos["odcc"], PDO::PARAM_STR);
				$stmt->bindParam(":oisc", $datos["oisc"], PDO::PARAM_STR);
				$stmt->bindParam(":oicc", $datos["oicc"], PDO::PARAM_STR);
				$stmt->bindParam(":cc", $datos["cc"], PDO::PARAM_STR);
				$stmt->bindParam(":esferaoilj", $datos["esferaoilj"], PDO::PARAM_STR);
				$stmt->bindParam(":cilindrooilj", $datos["cilindrooilj"], PDO::PARAM_STR);
			    $stmt->bindParam(":ejeoilj", $datos["ejeoilj"], PDO::PARAM_STR);
				$stmt -> bindParam(":esferaodlj", $datos["esferaodlj"], PDO::PARAM_STR);
				$stmt -> bindParam(":cilindroodlj", $datos["cilindroodlj"], PDO::PARAM_STR);
				$stmt -> bindParam(":ejeodlj", $datos["ejeodlj"], PDO::PARAM_STR);
				$stmt -> bindParam(":esferaoicc", $datos["esferaoicc"], PDO::PARAM_STR);
				$stmt -> bindParam(":cilindrooicc", $datos["cilindrooicc"], PDO::PARAM_STR);
				$stmt -> bindParam(":ejeoicc", $datos["ejeoicc"], PDO::PARAM_STR);
				$stmt -> bindParam(":esferaodcc", $datos["esferaodcc"], PDO::PARAM_STR);
				$stmt -> bindParam(":cilindroodcc", $datos["cilindroodcc"], PDO::PARAM_STR);
				$stmt -> bindParam(":ejeodcc", $datos["ejeodcc"], PDO::PARAM_STR);
				$stmt -> bindParam(":dp", $datos["dp"], PDO::PARAM_STR);
				$stmt -> bindParam(":adicion", $datos["adicion"], PDO::PARAM_STR);
				$stmt -> bindParam(":diagnostico", $datos["diagnostico"], PDO::PARAM_STR);
				$stmt -> bindParam(":tonood", $datos["tonood"], PDO::PARAM_STR);
				$stmt -> bindParam(":tonooi", $datos["tonooi"], PDO::PARAM_STR);
				$stmt -> bindParam(":tonohora", $datos["tonohora"], PDO::PARAM_STR);
				$stmt -> bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;

	}

	/*=============================================
	EDITAR historia
	=============================================*/

	static public function mdlEditarhistoria($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, apellido = :apellido, documentoid = :documentoid, direccion = :direccion, telefono = :telefono, anamnesis = :anamnesis, edad = :edad, antecedentes = :antecedentes, odsc = :odsc, odcc = :odcc, oisc = :oisc, oicc = :oicc, cc = :cc, esferaoilj = :esferaoilj, cilindrooilj = :cilindrooilj, ejeoilj = :ejeoilj, esferaodlj = :esferaodlj, cilindroodlj = :cilindroodlj, ejeodlj = :ejeodlj,





		 esferaoicc = :esferaoicc, cilindrooicc = :cilindrooicc, ejeoicc = :ejeoicc, esferaodcc = :esferaodcc, cilindroodcc = :cilindroodcc, ejeodcc = :ejeodcc, dp = :dp, adicion = :adicion, diagnostico = :diagnostico, tonood = :tonood, tonooi = :tonooi, tonohora = :tonohora, observaciones = :observaciones WHERE documentoid = :documentoid");

				$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
				$stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
				$stmt->bindParam(":documentoid", $datos["documentoid"], PDO::PARAM_STR);
				$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
				$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
				$stmt->bindParam(":anamnesis", $datos["anamnesis"], PDO::PARAM_STR);
				$stmt->bindParam(":antecedentes", $datos["antecedentes"], PDO::PARAM_STR);
				$stmt->bindParam(":edad", $datos["edad"], PDO::PARAM_STR);
				$stmt->bindParam(":odsc", $datos["odsc"], PDO::PARAM_STR);
				$stmt->bindParam(":odcc", $datos["odcc"], PDO::PARAM_STR);
				$stmt->bindParam(":oisc", $datos["oisc"], PDO::PARAM_STR);
				$stmt->bindParam(":oicc", $datos["oicc"], PDO::PARAM_STR);
				$stmt->bindParam(":cc", $datos["cc"], PDO::PARAM_STR);
				$stmt->bindParam(":esferaoilj", $datos["esferaoilj"], PDO::PARAM_STR);
				$stmt->bindParam(":cilindrooilj", $datos["cilindrooilj"], PDO::PARAM_STR);
			    $stmt->bindParam(":ejeoilj", $datos["ejeoilj"], PDO::PARAM_STR);
				$stmt -> bindParam(":esferaodlj", $datos["esferaodlj"], PDO::PARAM_STR);
				$stmt -> bindParam(":cilindroodlj", $datos["cilindroodlj"], PDO::PARAM_STR);
				$stmt -> bindParam(":ejeodlj", $datos["ejeodlj"], PDO::PARAM_STR);
				$stmt -> bindParam(":esferaoicc", $datos["esferaoicc"], PDO::PARAM_STR);
				$stmt -> bindParam(":cilindrooicc", $datos["cilindrooicc"], PDO::PARAM_STR);
				$stmt -> bindParam(":ejeoicc", $datos["ejeoicc"], PDO::PARAM_STR);
				$stmt -> bindParam(":esferaodcc", $datos["esferaodcc"], PDO::PARAM_STR);
				$stmt -> bindParam(":cilindroodcc", $datos["cilindroodcc"], PDO::PARAM_STR);
				$stmt -> bindParam(":ejeodcc", $datos["ejeodcc"], PDO::PARAM_STR);
				$stmt -> bindParam(":dp", $datos["dp"], PDO::PARAM_STR);
				$stmt -> bindParam(":adicion", $datos["adicion"], PDO::PARAM_STR);
				$stmt -> bindParam(":diagnostico", $datos["diagnostico"], PDO::PARAM_STR);
				$stmt -> bindParam(":tonood", $datos["tonood"], PDO::PARAM_STR);
				$stmt -> bindParam(":tonooi", $datos["tonooi"], PDO::PARAM_STR);
				$stmt -> bindParam(":tonohora", $datos["tonohora"], PDO::PARAM_STR);
				$stmt -> bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);


		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR historia
	=============================================*/

	static public function mdlActualizarhistoria($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	BORRAR historia
	=============================================*/

	static public function mdlBorrarhistoria($tabla, $datos){

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

}
