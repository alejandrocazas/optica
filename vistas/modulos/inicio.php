<?php
if ($_SESSION["perfil"] == "Especial") {
  echo '<script>window.location = "inicio";</script>';
  return;
}

$nombreUsuario = $_SESSION["nombre"] ?? '';
$nombreUsuarioUpper = function_exists('mb_strtoupper')
  ? mb_strtoupper($nombreUsuario, 'UTF-8')
  : strtoupper($nombreUsuario);
$nombreOpticaUpper = function_exists('mb_strtoupper')
  ? mb_strtoupper('Óptica Oftalens', 'UTF-8')
  : strtoupper('Óptica Oftalens');

$modulos = [
  ["ruta" => "productos",   "icono" => "fa-product-hunt",  "texto" => "Productos"],
  ["ruta" => "crear-venta", "icono" => "fa-handshake-o",   "texto" => "Crear Venta"],
  ["ruta" => "ventas",      "icono" => "fa-shopping-cart", "texto" => "Ventas"],
  ["ruta" => "clientes",    "icono" => "fa-users",         "texto" => "Clientes"],
  ["ruta" => "historias",   "icono" => "fa-file-text-o",   "texto" => "Historias"],
  ["ruta" => "usuarios",    "icono" => "fa-user-circle-o", "texto" => "Usuarios"],
];
?>

<div class="content-wrapper inicio-clasico">

  <section class="content-header">
    <h1>Inicio <small>Bienvenido</small></h1>
  </section>

  <section class="content">

    <div class="bienvenida-box text-center">
      <h3>BIENVENID@</h3>
      <h2><?= htmlspecialchars($nombreUsuarioUpper); ?></h2>
      <div class="logo-optica"><?= htmlspecialchars($nombreOpticaUpper); ?></div>
    </div>

    <div class="row">
      <div class="col-md-9">
        <div class="row text-center">
          <?php foreach ($modulos as $modulo): ?>
            <div class="col-sm-4 col-xs-6">
              <a href="<?= htmlspecialchars($modulo['ruta']); ?>">
                <div class="btn-modern">
                  <i class="fa <?= htmlspecialchars($modulo['icono']); ?>"></i>
                  <span><?= htmlspecialchars($modulo['texto']); ?></span>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-md-3">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-calendar"></i> Calendario</h3>
          </div>
          <div class="box-body">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
    </div>

  </section>

</div>

<script>
(function persistSidebarState() {
  var key = 'lte2-sidebar-collapsed';
  var saved = localStorage.getItem(key);
  if (saved === '1') {
    document.body.classList.add('sidebar-collapse');
  }
  if (typeof jQuery !== 'undefined') {
    jQuery(document).on('click', '[data-toggle="push-menu"]', function () {
      setTimeout(function () {
        var collapsed = document.body.classList.contains('sidebar-collapse');
        localStorage.setItem(key, collapsed ? '1' : '0');
      }, 150);
    });
  }
})();

(function ensureFullCalendarStyles() {
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
  var calendarEl = document.getElementById('calendar');
  if (!calendarEl || typeof FullCalendar === 'undefined') {
    return;
  }

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    contentHeight: 350,
    locale: 'es'
  });

  calendar.render();
});
</script>
