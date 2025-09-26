<?php
require_once "conexion.php";

class ModeloProductos{

  /* =============================================
     MOSTRAR PRODUCTOS
     ============================================= */
  static public function mdlMostrarProductos($tabla, $item, $valor, $orden){

    if($item != null){

      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");
      $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch();

    } else {

      $orden = $orden ? preg_replace('/[^a-zA-Z0-9_]/','',$orden) : 'id';
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC");
      $stmt->execute();
      return $stmt->fetchAll();
    }
  }

  /* =============================================
     REGISTRO DE PRODUCTO
     ============================================= */
  static public function mdlIngresarProducto($tabla, $datos){

    $stmt = Conexion::conectar()->prepare(
      "INSERT INTO $tabla(id_categoria, codigo, descripcion, imagen, stock, precio_compra, precio_venta, lote)
       VALUES (:id_categoria, :codigo, :descripcion, :imagen, :stock, :precio_compra, :precio_venta, :lote)"
    );

    $stmt->bindParam(":id_categoria",  $datos["id_categoria"],  PDO::PARAM_INT);
    $stmt->bindParam(":codigo",        $datos["codigo"],        PDO::PARAM_STR);
    $stmt->bindParam(":lote",          $datos["lote"],          PDO::PARAM_STR);
    $stmt->bindParam(":descripcion",   $datos["descripcion"],   PDO::PARAM_STR);
    $stmt->bindParam(":imagen",        $datos["imagen"],        PDO::PARAM_STR);
    $stmt->bindParam(":stock",         $datos["stock"],         PDO::PARAM_STR);
    $stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
    $stmt->bindParam(":precio_venta",  $datos["precio_venta"],  PDO::PARAM_STR);

    return $stmt->execute() ? "ok" : "error";
  }

  /* =============================================
     EDITAR PRODUCTO
     ============================================= */
  static public function mdlEditarProducto($tabla, $datos){

    $stmt = Conexion::conectar()->prepare(
      "UPDATE $tabla
       SET id_categoria = :id_categoria,
           descripcion  = :descripcion,
           imagen       = :imagen,
           stock        = :stock,
           precio_compra= :precio_compra,
           precio_venta = :precio_venta,
           lote         = :lote
       WHERE codigo = :codigo"
    );

    $stmt->bindParam(":id_categoria",  $datos["id_categoria"],  PDO::PARAM_INT);
    $stmt->bindParam(":codigo",        $datos["codigo"],        PDO::PARAM_STR);
    $stmt->bindParam(":descripcion",   $datos["descripcion"],   PDO::PARAM_STR);
    $stmt->bindParam(":imagen",        $datos["imagen"],        PDO::PARAM_STR);
    $stmt->bindParam(":stock",         $datos["stock"],         PDO::PARAM_STR);
    $stmt->bindParam(":lote",          $datos["lote"],          PDO::PARAM_STR);
    $stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
    $stmt->bindParam(":precio_venta",  $datos["precio_venta"],  PDO::PARAM_STR);

    return $stmt->execute() ? "ok" : "error";
  }

  /* =============================================
     BORRAR PRODUCTO
     ============================================= */
  static public function mdlEliminarProducto($tabla, $datos){

    $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
    $stmt->bindParam(":id", $datos, PDO::PARAM_INT);
    return $stmt->execute() ? "ok" : "error";
  }

  /* =============================================
     ACTUALIZAR UNA COLUMNA DE PRODUCTO (GENÉRICO)
     ============================================= */
  static public function mdlActualizarProducto($tabla, $item1, $valor1, $valor){

    $campo = preg_replace('/[^a-zA-Z0-9_]/','', $item1);
    $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $campo = :$campo WHERE id = :id");
    $stmt->bindParam(":".$campo, $valor1, PDO::PARAM_STR);
    $stmt->bindParam(":id", $valor, PDO::PARAM_STR);
    return $stmt->execute() ? "ok" : "error";
  }

  /* =============================================
     SUMA TOTAL VENTAS
     ============================================= */
  static public function mdlMostrarSumaVentas($tabla){

    $stmt = Conexion::conectar()->prepare("SELECT SUM(ventas) AS total FROM $tabla");
    $stmt->execute();
    return $stmt->fetch();
  }

  /* =============================================
     — NUEVO — DESCONTAR STOCK (atómico y seguro)
     También incrementa ventas
     ============================================= */
  static public function mdlDescontarStockSeguro($idProducto, $cantidad){
    $pdo = Conexion::conectar();
    $pdo->beginTransaction();
    try {
      // Descontar stock sin bajar de 0
      $q1 = $pdo->prepare("UPDATE productos SET stock = GREATEST(stock - :cant, 0) WHERE id = :id");
      $q1->bindParam(":cant", $cantidad, PDO::PARAM_INT);
      $q1->bindParam(":id",   $idProducto, PDO::PARAM_INT);
      $q1->execute();

      // Aumentar ventas
      $q2 = $pdo->prepare("UPDATE productos SET ventas = ventas + :cant WHERE id = :id");
      $q2->bindParam(":cant", $cantidad, PDO::PARAM_INT);
      $q2->bindParam(":id",   $idProducto, PDO::PARAM_INT);
      $q2->execute();

      $pdo->commit();
      return "ok";
    } catch (\Throwable $e) {
      $pdo->rollBack();
      return "error";
    }
  }

  /* =============================================
     — NUEVO — SUMAR STOCK (devoluciones/ediciones)
     También decrementa ventas (hasta no negativo)
     ============================================= */
  static public function mdlSumarStockSeguro($idProducto, $cantidad){
    $pdo = Conexion::conectar();
    $pdo->beginTransaction();
    try {
      $q1 = $pdo->prepare("UPDATE productos SET stock = stock + :cant WHERE id = :id");
      $q1->bindParam(":cant", $cantidad, PDO::PARAM_INT);
      $q1->bindParam(":id",   $idProducto, PDO::PARAM_INT);
      $q1->execute();

      $q2 = $pdo->prepare("UPDATE productos SET ventas = GREATEST(ventas - :cant, 0) WHERE id = :id");
      $q2->bindParam(":cant", $cantidad, PDO::PARAM_INT);
      $q2->bindParam(":id",   $idProducto, PDO::PARAM_INT);
      $q2->execute();

      $pdo->commit();
      return "ok";
    } catch (\Throwable $e) {
      $pdo->rollBack();
      return "error";
    }
  }
}
