<?php

require_once "conexion.php";

class ModeloEntrega

{

/*=============================================
	AGREGAR Entrega
=============================================*/
    static public function mdlIngresarEntrega($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_pedido,formapago,monto,codigopago)
        VALUES (:id_pedido,:formapago,:monto,:codigopago)");

        $stmt -> bindParam(":id_pedido", $datos["id_pedido"], PDO::PARAM_STR);
        $stmt -> bindParam(":formapago", $datos["formapago"], PDO::PARAM_STR); 
        $stmt -> bindParam(":monto", $datos["monto"], PDO::PARAM_STR); 
		$stmt -> bindParam(":codigopago", $datos["codigopago"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;

	}

    /*=============================================
	MOSTRAR ENTREGA
	=============================================*/
    static public function mdlMostrarEntrega($tabla, $item, $valor)
    {

        if ($item != null) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();

        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();

        }

        $stmt->close();

        $stmt = null;

    }


    /*=============================================
	ACTUALIZAR ENTREGA
	=============================================*/
    static public function mdlActualizarEntrega($tabla, $item1, $valor1, $item2, $valor2)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

        $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);

        $stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";

        } else {

            return "error";

        }

        $stmt->close();

        $stmt = null;

    }

}
