<?php

class ControladorVentas{

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/
	static public function ctrMostrarVentas($item, $valor){
		$tabla = "ventas";
		return ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
	}

	/*=============================================
	CREAR VENTA
	=============================================*/
	static public function ctrCrearVenta(){

		if(isset($_POST["nuevaVenta"])){

			if(empty($_POST["listaProductos"])){
				echo '<script>
				  window.addEventListener("load", function () {
					swal({
					  type: "error",
					  title: "La venta no se ejecuta si no hay productos",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					}).then(function(result){
					  if (result.value) { window.location = "ventas"; }
					});
				  });
				</script>';
				return;
			}

			$listaProductos = json_decode($_POST["listaProductos"], true);
			$totalProductosComprados = array();

			/* ============================================
			   ACTUALIZA ventas/stock de forma SEGURA
			   ============================================ */
			foreach ($listaProductos as $linea) {

				$idProd = (int)$linea["id"];
				$cant   = (int)$linea["cantidad"];

				array_push($totalProductosComprados, $cant);

				// Resta stock y suma ventas en una sola sentencia SQL
				ModeloProductos::mdlDescontarStockSeguro("productos", $idProd, $cant);
			}

			/* ============================================
			   ACTUALIZA compras/última compra del cliente
			   ============================================ */
			$tablaClientes = "clientes";
			$item = "id";
			$valor = $_POST["seleccionarCliente"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);

			$item1a = "compras";
			$valor1a = array_sum($totalProductosComprados) + (int)$traerCliente["compras"];
			ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valor);

			$item1b = "ultima_compra";
			date_default_timezone_set('America/Santiago');
			$valor1b = date('Y-m-d H:i:s');
			ModeloClientes::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);

			/* ============================================
			   GUARDA LA VENTA
			   ============================================ */
			$estado_PENDIENTE = 'PENDIENTE';
			$estado_PAGADO    = 'PAGADO';
			$estado_bulto     = 'EN LABORATORIO';
			$totalfinal       = 0;
			$tabla            = "ventas";

			if ($_POST["nuevoFormaPago"] == 'CONTADO'){
				$datos = array(
					"id_vendedor"=>$_POST["idVendedor"],
					"estado" => $estado_PAGADO,
					"estado_bulto" => $estado_bulto,
					"id_cliente"=>$_POST["seleccionarCliente"],
					"codigo"=>$_POST["nuevaVenta"],
					"productos"=>$_POST["listaProductos"],
					"impuesto"=>$_POST["nuevoPrecioImpuesto"],
					"neto"=>$_POST["nuevoPrecioNeto"],
					"total"=>$_POST["totalVenta"],
					"descuento"=>$_POST["nuevoDescuentoVenta"],
					"totalfinal"=>$_POST["nuevoTotalFinal"],
					"totalfinalreporte"=>$_POST["totalVenta"],
					"abono"=>$_POST["Abono"],
					"pendiente"=>$_POST["SaldoPendiente"],
					"observaciones"=>$_POST["Observaciones"],
					"fechaentrega"=>$_POST["FechaEntrega"],
					"metodo_pago"=>$_POST["listaMetodoPago"],
				);
			}else{ // ABONO o RETIRO -> PENDIENTE
				$datos = array(
					"id_vendedor"=>$_POST["idVendedor"],
					"estado" => $estado_PENDIENTE,
					"estado_bulto" => $estado_bulto,
					"id_cliente"=>$_POST["seleccionarCliente"],
					"codigo"=>$_POST["nuevaVenta"],
					"productos"=>$_POST["listaProductos"],
					"impuesto"=>$_POST["nuevoPrecioImpuesto"],
					"neto"=>$_POST["nuevoPrecioNeto"],
					"total"=>$_POST["totalVenta"],
					"descuento"=>$_POST["nuevoDescuentoVenta"],
					"totalfinal"=>$_POST["nuevoTotalFinal"],
					"totalfinalreporte"=>$totalfinal,
					"abono"=>$_POST["Abono"],
					"pendiente"=>$_POST["SaldoPendiente"],
					"observaciones"=>$_POST["Observaciones"],
					"fechaentrega"=>$_POST["FechaEntrega"],
					"metodo_pago"=>$_POST["listaMetodoPago"]
				);
			}

			$respuesta = ModeloVentas::mdlIngresarVenta($tabla, $datos);

			if($respuesta == "ok"){
				echo '<script>
				  window.addEventListener("load", function () {
					swal({
					  type: "success",
					  title: "La venta ha sido guardada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					}).then(function(result){
					  if (result.value) { window.location = "ventas"; }
					});
				  });
				</script>';
			}
		}
	}

	/*=============================================
	EDITAR VENTA
	=============================================*/
	static public function ctrEditarVenta(){

		if(isset($_POST["editarVenta"])){

			$tabla = "ventas";
			$item  = "codigo";
			$valor = $_POST["editarVenta"];
			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			// Si cambian productos, primero revertimos la venta anterior
			if(!empty($_POST["listaProductos"])){
				$productosViejos = json_decode($traerVenta["productos"], true);
				foreach ($productosViejos as $l){
					ModeloProductos::mdlSumarStockSeguro("productos", (int)$l["id"], (int)$l["cantidad"]);
				}
				// y aplicamos los nuevos
				$nuevos = json_decode($_POST["listaProductos"], true);
				$totalProductosComprados_2 = 0;
				foreach ($nuevos as $l2){
					ModeloProductos::mdlDescontarStockSeguro("productos", (int)$l2["id"], (int)$l2["cantidad"]);
					$totalProductosComprados_2 += (int)$l2["cantidad"];
				}

				// Actualiza compras cliente
				$tablaClientes = "clientes";
				$cliId = $_POST["seleccionarCliente"];
				$cli   = ModeloClientes::mdlMostrarClientes($tablaClientes, "id", $cliId);
				ModeloClientes::mdlActualizarCliente($tablaClientes, "compras",
					(int)$cli["compras"] + (int)$totalProductosComprados_2, $cliId);
				ModeloClientes::mdlActualizarCliente($tablaClientes, "ultima_compra", date('Y-m-d H:i:s'), $cliId);
			}

			// Guardar cambios de la venta (estado según forma de pago)
			$estado_PENDIENTE = 'PENDIENTE';
			$estado_PAGADO    = 'PAGADO';
			$estado_bulto     = 'EN LABORATORIO';
			$totalfinal       = 0;

			if ($_POST["nuevoFormaPago"] == 'CONTADO'){
				$datos = array(
					"id_vendedor"=>$_POST["idVendedor"],
					"estado" => $estado_PAGADO,
					"estado_bulto" => $estado_bulto,
					"id_cliente"=>$_POST["seleccionarCliente"],
					"codigo"=>$_POST["editarVenta"],
					"productos"=>$_POST["listaProductos"],
					"impuesto"=>$_POST["nuevoPrecioImpuesto"],
					"neto"=>$_POST["nuevoPrecioNeto"],
					"total"=>$_POST["totalVenta"],
					"descuento"=>$_POST["nuevoDescuentoVenta"],
					"totalfinal"=>$_POST["nuevoTotalFinal"],
					"totalfinalreporte"=>$_POST["totalVenta"],
					"abono"=>$_POST["Abono"],
					"pendiente"=>$_POST["SaldoPendiente"],
					"observaciones"=>$_POST["Observaciones"],
					"fechaentrega"=>$_POST["FechaEntrega"],
					"metodo_pago"=>$_POST["listaMetodoPago"],
				);
			}else{
				$datos = array(
					"id_vendedor"=>$_POST["idVendedor"],
					"estado" => $estado_PENDIENTE,
					"estado_bulto" => $estado_bulto,
					"id_cliente"=>$_POST["seleccionarCliente"],
					"codigo"=>$_POST["editarVenta"],
					"productos"=>$_POST["listaProductos"],
					"impuesto"=>$_POST["nuevoPrecioImpuesto"],
					"neto"=>$_POST["nuevoPrecioNeto"],
					"total"=>$_POST["totalVenta"],
					"descuento"=>$_POST["nuevoDescuentoVenta"],
					"totalfinal"=>$_POST["nuevoTotalFinal"],
					"totalfinalreporte"=>$totalfinal,
					"abono"=>$_POST["Abono"],
					"pendiente"=>$_POST["SaldoPendiente"],
					"observaciones"=>$_POST["Observaciones"],
					"fechaentrega"=>$_POST["FechaEntrega"],
					"metodo_pago"=>$_POST["listaMetodoPago"],
				);
			}

			$respuesta = ModeloVentas::mdlEditarVenta($tabla, $datos);

			if($respuesta == "ok"){
				echo '<script>
				  window.addEventListener("load", function () {
					swal({
					  type: "success",
					  title: "La venta ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					}).then(function(result){
					  if (result.value) { window.location = "ventas"; }
					});
				  });
				</script>';
			}
		}
	}

	/*=============================================
	ELIMINAR VENTA
	=============================================*/
	static public function ctrEliminarVenta(){

		if(isset($_GET["idVenta"])){

			$tabla = "ventas";
			$item  = "id";
			$valor = $_GET["idVenta"];

			$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

			/* Revertir stock/ventas de esa venta */
			$productos =  json_decode($traerVenta["productos"], true);
			$totalProductosComprados = 0;

			foreach ($productos as $l) {
				$totalProductosComprados += (int)$l["cantidad"];
				ModeloProductos::mdlSumarStockSeguro("productos", (int)$l["id"], (int)$l["cantidad"]);
			}

			/* Actualizar última compra del cliente (igual que tenías) */
			$tablaClientes = "clientes";
			$itemVentas = null;
			$valorVentas = null;
			$traerVentas = ModeloVentas::mdlMostrarVentas($tabla, $itemVentas, $valorVentas);

			$guardarFechas = array();
			foreach ($traerVentas as $v) {
				if($v["id_cliente"] == $traerVenta["id_cliente"]){
					$guardarFechas[] = $v["fecha"];
				}
			}

			if(count($guardarFechas) > 1){
				rsort($guardarFechas);
				$fechaNueva = $guardarFechas[1]; // segunda más reciente
			}else{
				$fechaNueva = "0000-00-00 00:00:00";
			}
			ModeloClientes::mdlActualizarCliente($tablaClientes, "ultima_compra", $fechaNueva, $traerVenta["id_cliente"]);

			/* Eliminar */
			$respuesta = ModeloVentas::mdlEliminarVenta($tabla, $_GET["idVenta"]);

			if($respuesta == "ok"){
				echo '<script>
				  window.addEventListener("load", function () {
					swal({
					  type: "success",
					  title: "La venta ha sido eliminada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					}).then(function(result){
					  if (result.value) { window.location = "ventas"; }
					});
				  });
				</script>';
			}
		}
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/
	static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal){
		return ModeloVentas::mdlRangoFechasVentas("ventas", $fechaInicial, $fechaFinal);
	}

	/*=============================================
	SUMA TOTAL VENTAS
	=============================================*/
	static public function ctrSumaTotalVentas(){
		return ModeloVentas::mdlSumaTotalVentas("ventas");
	}

	/*=============================================
	DESCARGAR XML (igual que lo tenías)
	=============================================*/
	static public function ctrDescargarXML(){
		// ... (sin cambios relevantes)
	}
}
