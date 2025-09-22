<?php
if ($_SESSION["perfil"] == "Especial") {
  echo '<script>window.location = "inicio";</script>';
  return;
}

$fechaActual = new DateTime();
$nombre = $_SESSION["nombre"] ?? "";
$apellido = $_SESSION["apellido"] ?? "";
$nombreCompleto = trim($nombre . ' ' . $apellido);
$nombreParaMostrar = $nombreCompleto !== '' ? $nombreCompleto : ($nombre ?: 'Usuario');
$nombreComercial = "Óptica Oftalens";
$fotoUsuario = !empty($_SESSION["foto"]) ? $_SESSION["foto"] : "vistas/img/usuarios/default/anonymous.png";

$horaActual = (int) $fechaActual->format('H');
if ($horaActual < 12) {
  $saludo = 'Buenos días';
} elseif ($horaActual < 18) {
  $saludo = 'Buenas tardes';
} else {
  $saludo = 'Buenas noches';
}

$diasSemana = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
$mesesAno = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
$indiceDia = (int) $fechaActual->format('w');
$indiceMes = (int) $fechaActual->format('n') - 1;
$fechaLarga = ucfirst($diasSemana[$indiceDia]) . ' ' . $fechaActual->format('d') . ' de ' . $mesesAno[$indiceMes] . ' de ' . $fechaActual->format('Y');
$horaFormateada = $fechaActual->format('H:i');
$diaDelAnio = (int) $fechaActual->format('z') + 1;

$accesosRapidos = [
  ["ruta" => "crear-venta", "icono" => "fa-handshake-o",   "texto" => "Crear venta",   "detalle" => "Inicia una nueva transacción"],
  ["ruta" => "ventas",      "icono" => "fa-shopping-cart", "texto" => "Ventas",        "detalle" => "Revisa movimientos recientes"],
  ["ruta" => "productos",   "icono" => "fa-product-hunt",  "texto" => "Productos",     "detalle" => "Actualiza el inventario"],
  ["ruta" => "clientes",    "icono" => "fa-users",         "texto" => "Clientes",      "detalle" => "Gestiona tu cartera"],
  ["ruta" => "historias",   "icono" => "fa-file-text-o",   "texto" => "Historias",     "detalle" => "Consulta expedientes clínicos"],
  ["ruta" => "usuarios",    "icono" => "fa-user-circle-o", "texto" => "Usuarios",      "detalle" => "Control de accesos"],
];

$estado = null;
$valorEstado = null;
$alertas = ControladorAlerta::ctrMostrarAlerta($estado, $valorEstado);
$alertasRecientes = [];

if (is_array($alertas)) {
  foreach ($alertas as $alerta) {
    $alertasRecientes[] = [
      'autor' => $alerta['autor'] ?? '',
      'fecha' => $alerta['fecha'] ?? '',
      'mensaje' => $alerta['mensaje'] ?? '',
    ];

    if (count($alertasRecientes) === 4) {
      break;
    }
  }
}

$totalAlertasResumen = count($alertasRecientes);
?>

<div class="content-wrapper inicio-dashboard">

  <section class="content-header">
    <h1>
      Inicio
      <small>Resumen general</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Panel</li>
    </ol>
  </section>

  <section class="content">

    <div class="row bienvenida-row">
      <div class="col-lg-8 col-xs-12">
        <div class="box box-primary bienvenida-card">
          <div class="box-body">
            <div class="bienvenida-avatar">
              <img src="<?= htmlspecialchars($fotoUsuario); ?>" alt="Foto de perfil">
            </div>
            <div class="bienvenida-texto">
              <span class="bienvenida-saludo"><?= htmlspecialchars($saludo); ?></span>
              <h2 class="bienvenida-nombre"><?= htmlspecialchars($nombreParaMostrar); ?></h2>
              <p class="bienvenida-detalle"><?= htmlspecialchars($nombreComercial); ?> • <?= htmlspecialchars($fechaLarga); ?></p>
            </div>
            <div class="bienvenida-reloj hidden-xs">
              <span class="hora"><?= htmlspecialchars($horaFormateada); ?></span>
              <small><?= htmlspecialchars('Día ' . $diaDelAnio . ' del año'); ?></small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-xs-12">
        <div class="box box-warning box-alertas-resumen">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bell-o"></i> Últimas alertas</h3>
            <div class="box-tools pull-right">
              <span class="label label-warning"><?= (int) $totalAlertasResumen; ?></span>
              <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <?php if (!empty($alertasRecientes)): ?>
              <ul class="alertas-resumen-list">
                <?php foreach ($alertasRecientes as $alerta): ?>
                  <li>
                    <span class="alerta-mensaje"><?= htmlspecialchars($alerta['mensaje']); ?></span>
                    <small class="alerta-meta">
                      <i class="fa fa-user"></i> <?= htmlspecialchars($alerta['autor'] ?: 'Sistema'); ?>
                      &middot;
                      <i class="fa fa-clock-o"></i> <?= htmlspecialchars($alerta['fecha']); ?>
                    </small>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <p class="text-muted text-center">No hay alertas pendientes por ahora.</p>
            <?php endif; ?>
          </div>
          <div class="box-footer text-center">
            <a href="reportes" class="text-muted">Ver historial de alertas</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <?php include "inicio/cajas-superiores.php"; ?>
    </div>

    <div class="row accesos-rapidos">

      <div class="col-lg-9 col-xs-12">
        <div class="box box-default box-accesos">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bolt"></i> Accesos rápidos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <?php foreach ($accesosRapidos as $acceso): ?>
                <div class="col-sm-4 col-xs-6">
                  <a class="acceso-card" href="<?= htmlspecialchars($acceso['ruta']); ?>">
                    <i class="fa <?= htmlspecialchars($acceso['icono']); ?>"></i>
                    <span><?= htmlspecialchars($acceso['texto']); ?></span>
                    <?php if (!empty($acceso['detalle'])): ?>
                      <small><?= htmlspecialchars($acceso['detalle']); ?></small>
                    <?php endif; ?>
                  </a>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
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

        <div class="box box-info box-sugerencias hidden-xs">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-lightbulb-o"></i> Sugerencias</h3>
          </div>
          <div class="box-body">
            <ul class="sugerencias-list">
              <li><i class="fa fa-eye text-blue"></i> Confirma las citas oftalmológicas programadas.</li>
              <li><i class="fa fa-line-chart text-green"></i> Revisa las ventas de la semana.</li>
              <li><i class="fa fa-cubes text-purple"></i> Controla el stock de monturas y lentes.</li>
            </ul>
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
