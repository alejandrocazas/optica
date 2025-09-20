<?php
require_once "controladores/configuraciones.controlador.php";
require_once "modelos/configuraciones.modelo.php";

$item = null;
$valor = null;
$orden = "id";

$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
$totalProductos = is_array($productos) ? count($productos) : 0;

$moneda = "";
$configuraciones = Controladorconfiguraciones::ctrMostrarconfiguraciones($item, $valor);

if (is_array($configuraciones)) {
  foreach ($configuraciones as $value) {
    if (!empty($value["moneda"])) {
      $moneda = $value["moneda"];
      break;
    }
  }
}
?>

<div class="box box-primary">

  <div class="box-header with-border">
    <h3 class="box-title">Productos agregados recientemente</h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
      <button type="button" class="btn btn-box-tool" data-widget="remove">
        <i class="fa fa-times"></i>
      </button>
    </div>
  </div>

  <div class="box-body">
    <ul class="products-list product-list-in-box">
      <?php
        if ($totalProductos === 0) {
          echo '<li class="item text-center text-muted">No hay productos registrados todavía.</li>';
        } else {
          $limite = min(10, $totalProductos);
          for ($i = 0; $i < $limite; $i++) {
            $producto = $productos[$i];
            $descripcion = htmlspecialchars($producto["descripcion"] ?? "Producto");
            $imagen = htmlspecialchars($producto["imagen"] ?? "vistas/img/plantilla/logo.png");
            $precio = isset($producto["precio_venta"]) ? number_format((float) $producto["precio_venta"], 2) : '0.00';

            echo '<li class="item">',
                    '<div class="product-img">',
                      '<img src="' . $imagen . '" alt="Imagen del producto">',
                    '</div>',
                    '<div class="product-info">',
                      '<a href="productos" class="product-title">',
                        $descripcion,
                        '<span class="label label-warning pull-right">' . $moneda . ' ' . $precio . '</span>',
                      '</a>',
                    '</div>',
                 '</li>';
          }
        }
      ?>
    </ul>
  </div>

  <div class="box-footer text-center">
    <a href="productos" class="uppercase">Ver todos los productos</a>
  </div>

</div>
