<?php
if ($_SESSION["perfil"] == "Especial") {
  echo '<script>window.location = "inicio";</script>';
  return;
}

$fechaActual = date("d-m-Y");
$nombre = $_SESSION["nombre"] ?? "";
$apellido = $_SESSION["apellido"] ?? "";
$nombreCompleto = trim($nombre . ' ' . $apellido);
$nombreParaMostrar = $nombreCompleto ?: $nombre ?: 'Usuario';
$nombreComercial = "Óptica Oftalens";

$accesosRapidos = [
  ["ruta" => "productos",   "icono" => "fa-product-hunt",  "texto" => "Productos"],
  ["ruta" => "crear-venta", "icono" => "fa-handshake-o",   "texto" => "Crear venta"],
  ["ruta" => "ventas",      "icono" => "fa-shopping-cart", "texto" => "Ventas"],
  ["ruta" => "clientes",    "icono" => "fa-users",         "texto" => "Clientes"],
  ["ruta" => "historias",   "icono" => "fa-file-text-o",   "texto" => "Historias"],
  ["ruta" => "usuarios",    "icono" => "fa-user-circle-o", "texto" => "Usuarios"],
];
?>

<div class="content-wrapper inicio-dashboard">

  <section class="content-header">
    <h1>
      Inicio
      <small>Panel principal</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Panel</li>
    </ol>
  </section>

  <section class="content">

    <div class="row">
      <div class="col-xs-12">
        <div class="bienvenida-box">
          <h3>Bienvenido(a)</h3>
          <h2><?= htmlspecialchars(strtoupper($nombreParaMostrar)); ?></h2>
          <p><?= htmlspecialchars($nombreComercial); ?> &bull; <?= htmlspecialchars($fechaActual); ?></p>
        </div>
      </div>
    </div>

    <div class="row">
      <?php include "inicio/cajas-superiores.php"; ?>
    </div>

    <div class="row accesos-rapidos">

      <div class="col-lg-9 col-xs-12">
        <div class="row">
          <?php foreach ($accesosRapidos as $acceso): ?>
            <div class="col-sm-4 col-xs-6">
              <a class="acceso-card" href="<?= htmlspecialchars($acceso["ruta"]); ?>">
                <i class="fa <?= htmlspecialchars($acceso["icono"]); ?>"></i>
                <span><?= htmlspecialchars($acceso["texto"]); ?></span>
              </a>
            </div>
          <?php endforeach; ?>
        </div>

        <?php include "inicio/productos-recientes.php"; ?>
      </div>

      <div class="col-lg-3 col-xs-12">
        <div class="box box-success box-calendar">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-calendar"></i> Agenda</h3>
          </div>
          <div class="box-body">
            <div id="dashboard-calendar"></div>
          </div>
        </div>
      </div>

    </div>

  </section>

</div>

<script>
(function appendFullCalendarStyles() {
  var fcCssId = 'fullcalendar-css';
  if (!document.getElementById(fcCssId)) {
    var link = document.createElement('link');
    link.id = fcCssId;
    link.rel = 'stylesheet';
    link.href = 'https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css';
    document.head.appendChild(link);
  }
})();
</script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('dashboard-calendar');
  if (!calendarEl) {
    return;
  }

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    height: 350,
    headerToolbar: {
      left: 'title',
      center: '',
      right: 'prev,next'
    }
  });

  calendar.render();
});
</script>
