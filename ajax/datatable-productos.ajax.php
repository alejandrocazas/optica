<?php
// ajax/datatable-productos.ajax.php
declare(strict_types=1);

// Forzamos JSON limpio (sin notices)
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// Evita que espacios/BOM previos rompan el JSON
if (function_exists('ob_get_level')) {
  while (ob_get_level() > 0) @ob_end_clean();
}

if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

try {
  require_once __DIR__."/../controladores/productos.controlador.php";
  require_once __DIR__."/../modelos/productos.modelo.php";
  require_once __DIR__."/../controladores/categorias.controlador.php";
  require_once __DIR__."/../modelos/categorias.modelo.php";

  $perfilOculto = isset($_GET['perfilOculto']) ? (string)$_GET['perfilOculto'] : '';

  $productos = ControladorProductos::ctrMostrarProductos(null, null, "id");
  if (!is_array($productos)) $productos = [];

  $rows = [];
  foreach ($productos as $i => $p) {

    // Imagen segura
    $img = trim($p["imagen"] ?? "");
    if ($img === "") $img = "vistas/img/productos/default/anonymous.png";
    $imgHtml = "<img src=\"".htmlspecialchars($img, ENT_QUOTES, 'UTF-8')."\" width=\"40\" style=\"height:40px;object-fit:cover;border-radius:4px\">";

    // Categoría
    $cat = "";
    if (!empty($p["id_categoria"])) {
      $catRow = ControladorCategorias::ctrMostrarCategorias("id", $p["id_categoria"]);
      $cat = $catRow["categoria"] ?? "";
    }
    $descCat = "<b>".htmlspecialchars($p["descripcion"] ?? "", ENT_QUOTES, 'UTF-8')."</b>";
    if ($cat !== "") $descCat .= "<br><small class='text-muted'>".htmlspecialchars($cat, ENT_QUOTES, 'UTF-8')."</small>";

    // Stock semáforo
    $stockNum = (int)($p["stock"] ?? 0);
    if ($stockNum <= 10)      $stockHtml = "<button class='btn btn-danger'>".$stockNum."</button>";
    elseif ($stockNum <= 15)  $stockHtml = "<button class='btn btn-warning'>".$stockNum."</button>";
    else                      $stockHtml = "<button class='btn btn-success'>".$stockNum."</button>";

    // Botones
    if ($perfilOculto === "Especial") {
      $botones = "<div class='btn-group'>
        <button class='btn btn-warning btnEditarProducto' idProducto='".(int)$p["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button>
      </div>";
    } else {
      $botones = "<div class='btn-group'>
        <button class='btn btn-warning btnEditarProducto' idProducto='".(int)$p["id"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button>
        <button class='btn btn-danger btnEliminarProducto' idProducto='".(int)$p["id"]."' codigo='".htmlspecialchars($p["codigo"] ?? "", ENT_QUOTES, 'UTF-8')."' imagen='".htmlspecialchars($p["imagen"] ?? "", ENT_QUOTES, 'UTF-8')."'><i class='fa fa-times'></i></button>
      </div>";
    }

    $rows[] = [
      (string)($i + 1),
      $imgHtml,
      htmlspecialchars($p["lote"]      ?? "", ENT_QUOTES, 'UTF-8'),
      htmlspecialchars($p["codigo"]    ?? "", ENT_QUOTES, 'UTF-8'),
      $descCat,
      $stockHtml,
      number_format((float)($p["precio_compra"] ?? 0), 2, '.', ''),
      number_format((float)($p["precio_venta"]  ?? 0), 2, '.', ''),
      htmlspecialchars($p["fecha"]     ?? "", ENT_QUOTES, 'UTF-8'),
      $botones
    ];
  }

  echo json_encode(["data" => $rows], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
  // Si algo explota, devolvemos JSON vacío con detalle (para depurar en Network)
  http_response_code(500);
  echo json_encode([
    "data"  => [],
    "error" => "datatable-productos: ".$e->getMessage()
  ], JSON_UNESCAPED_UNICODE);
}
